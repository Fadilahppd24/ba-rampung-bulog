<?php
/**
 * Import data gudang dari Excel hasil pemeriksaan desa/kecamatan.
 *
 * Default: hanya menampilkan laporan (dry-run), TIDAK mengubah database.
 * Terapkan setelah laporan diperiksa:
 *   php import_data_filial_excel.php --apply "C:\path\data gudang filial bulog imyu.xlsx"
 *
 * Membaca sheet "REKAP FIL GABAH BERAS".
 */
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Gudang;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

function normText($value): string
{
    $s = mb_strtolower(trim((string) $value), 'UTF-8');
    $s = str_replace(["\u{00A0}", "\r", "\n", "\t"], ' ', $s);
    $s = preg_replace('/\s+/u', ' ', $s);
    // Buang tanda baca agar perbedaan titik/koma tidak menggagalkan pencocokan.
    $s = preg_replace('/[^\p{L}\p{N}]+/u', ' ', $s);
    return trim(preg_replace('/\s+/u', ' ', $s));
}

function numValue($value): ?float
{
    if ($value === null || trim((string) $value) === '') return null;
    if (is_numeric($value)) return (float) $value;
    $s = trim((string) $value);
    $s = str_replace(' ', '', $s);
    // Format Excel bisa berupa 6,5 (desimal koma) atau 1.234,5.
    if (str_contains($s, ',') && str_contains($s, '.')) {
        $s = str_replace('.', '', $s);
        $s = str_replace(',', '.', $s);
    } elseif (str_contains($s, ',')) {
        $s = str_replace(',', '.', $s);
    }
    return is_numeric($s) ? (float) $s : null;
}


function parseLocation(string $location): array
{
    $location = trim(preg_replace('/\s+/u', ' ', $location));
    $desa = null;
    $kecamatan = null;

    // Ambil nama desa setelah "Desa" sampai penanda RT/RW/Blok/Kecamatan/Kabupaten,
    // atau sampai "Kec." jika format lokasi tidak menyebut Desa di awal.
    if (preg_match('/\bDesa\s+(.+?)(?=\s+(?:RT?\s*\d|RW?\s*\d|Blok\b|Kec(?:amatan)?\.?\b|Kab(?:upaten)?\.?\b)|$)/iu', $location, $m)) {
        $desa = trim($m[1], " \t\n\r\0\x0B,.-");
    }

    // Jika ada penanda kecamatan, ambil sampai penanda kabupaten/kota atau akhir.
    if (preg_match('/\b(?:Kec(?:amatan)?\.?)\s+(.+?)(?=\s+(?:Kab(?:upaten)?\.?|Kota)\b|$)/iu', $location, $m)) {
        $kecamatan = trim($m[1], " \t\n\r\0\x0B,.-");
    }

    // Jika lokasi berupa "Kiara Payung Kec Anjatan Indramayu" tanpa kata Desa,
    // bagian sebelum Kec dianggap nama desa/lokasi hanya bila bukan alamat jalan.
    if (!$desa && preg_match('/^(.+?)\s+\b(?:Kec(?:amatan)?\.?)\s+/iu', $location, $m)) {
        $candidate = trim($m[1], " \t\n\r\0\x0B,.-");
        if (!preg_match('/\b(?:Jl|Jalan|Jln|Blok|RT|RW)\b/i', $candidate)) {
            $desa = $candidate;
        }
    }

    // Hindari menyimpan teks administratif sebagai nama desa/kecamatan.
    foreach (['desa', 'kecamatan'] as $field) {
        if ($$field !== null) {
            $$field = trim(preg_replace('/\s+/u', ' ', $$field));
            if ($$field === '') $$field = null;
        }
    }

    return ['desa' => $desa, 'kecamatan' => $kecamatan];
}

$args = $argv;
array_shift($args);
$apply = false;
$excelPath = null;
foreach ($args as $arg) {
    if ($arg === '--apply') $apply = true;
    else $excelPath = trim($arg, "\"'");
}

if (!$excelPath) {
    $candidates = [
        __DIR__ . DIRECTORY_SEPARATOR . 'data_gudang_filial_desa_kecamatan_diperiksa.xlsx',
    ];
    foreach ($candidates as $candidate) {
        if (is_file($candidate)) { $excelPath = $candidate; break; }
    }
}
if (!$excelPath || !is_file($excelPath)) {
    fwrite(STDERR, "File Excel tidak ditemukan.\n");
    fwrite(STDERR, "Contoh: php import_data_filial_excel_v3.php \"C:\\path\\data gudang filial bulog imyu.xlsx\"\n");
    exit(1);
}
if (!class_exists(IOFactory::class)) {
    fwrite(STDERR, "Library PhpSpreadsheet tidak ditemukan. Periksa apakah maatwebsite/excel atau phpoffice/phpspreadsheet terpasang.\n");
    exit(1);
}

try {
    $spreadsheet = IOFactory::load($excelPath);
    $sheet = $spreadsheet->getSheetByName('REKAP FIL GABAH BERAS');
    if (!$sheet) throw new RuntimeException('Sheet "REKAP FIL GABAH BERAS" tidak ditemukan.');

    // Struktur file hasil pemeriksaan: baris 5 mulai data; C=Nama, D=Luas, E=Kapasitas,
    // F=panjang, G=lebar, H=tinggi, I=Lokasi, J=Desa, K=Kecamatan, L=Gudang Induk.
    $rows = [];
    for ($r = 5; $r <= $sheet->getHighestRow(); $r++) {
        $name = trim((string) $sheet->getCell("C{$r}")->getFormattedValue());
        if ($name === '') continue;
        $rows[] = [
            'excel_row' => $r,
            'excel_name' => $name,
            'luas_m2' => numValue($sheet->getCell("D{$r}")->getCalculatedValue()),
            'kapasitas' => numValue($sheet->getCell("E{$r}")->getCalculatedValue()),
            'panjang_m' => numValue($sheet->getCell("F{$r}")->getCalculatedValue()),
            'lebar_m' => numValue($sheet->getCell("G{$r}")->getCalculatedValue()),
            'tinggi_m' => numValue($sheet->getCell("H{$r}")->getCalculatedValue()),
            'lokasi' => trim((string) $sheet->getCell("I{$r}")->getFormattedValue()),
            'desa_excel' => trim((string) $sheet->getCell("J{$r}")->getFormattedValue()),
            'kecamatan_excel' => trim((string) $sheet->getCell("K{$r}")->getFormattedValue()),
            'parent_excel' => trim((string) $sheet->getCell("L{$r}")->getFormattedValue()),
        ];
    }

    $filials = Gudang::whereNotNull('gudang_induk_id')->with('gudangInduk')->get();
    $dbByName = [];
    foreach ($filials as $g) {
        $key = normText($g->nama_gudang);
        $dbByName[$key][] = $g;
    }

    $usedIds = [];
    $matches = [];
    $unmatchedExcel = [];
    $ambiguousExcel = [];
    foreach ($rows as $row) {
        $key = normText($row['excel_name']);
        $candidates = $dbByName[$key] ?? [];

        // Fallback konservatif: cocokkan setelah menghapus akhiran "(Gd ...)"
        // hanya bila hasilnya tepat satu kandidat yang belum dipakai.
        if (count($candidates) === 0) {
            $shortKey = normText(preg_replace('/\s*\(Gd\s+[^)]*\)\s*$/iu', '', $row['excel_name']));
            $fallback = [];
            foreach ($filials as $g) {
                if (normText(preg_replace('/\s*\(Gd\s+[^)]*\)\s*$/iu', '', $g->nama_gudang)) === $shortKey) {
                    $fallback[] = $g;
                }
            }
            $candidates = $fallback;
        }

        $candidates = array_values(array_filter($candidates, fn($g) => !isset($usedIds[$g->id])));
        if (count($candidates) === 0) {
            $unmatchedExcel[] = $row;
            continue;
        }
        if (count($candidates) > 1) {
            $ambiguousExcel[] = ['row' => $row, 'candidates' => array_map(fn($g) => [
                'id' => $g->id, 'name' => $g->nama_gudang, 'code' => $g->kode_gudang
            ], $candidates)];
            continue;
        }

        $g = $candidates[0];
        $usedIds[$g->id] = true;
        $row['id'] = $g->id;
        $row['kode_gudang'] = $g->kode_gudang;
        $row['db_name'] = $g->nama_gudang;
        $row['db_parent_code'] = $g->gudangInduk?->kode_gudang;
        $row['changes'] = [];
        $fields = [
            'alamat' => $row['lokasi'],
            // Gunakan hanya nilai eksplisit dari kolom DESA/KECAMATAN Excel.
            // Jika kosong, jangan menghapus nilai yang sudah ada di database.
            'desa' => $row['desa_excel'] !== '' ? $row['desa_excel'] : null,
            'kecamatan' => $row['kecamatan_excel'] !== '' ? $row['kecamatan_excel'] : null,
            'kapasitas' => $row['kapasitas'],
            'luas_m2' => $row['luas_m2'],
            'panjang_m' => $row['panjang_m'],
            'lebar_m' => $row['lebar_m'],
            'tinggi_m' => $row['tinggi_m'],
        ];
        foreach ($fields as $field => $value) {
            if ($value === null || $value === '') continue;
            $current = $g->{$field};
            if (in_array($field, ['alamat', 'desa', 'kecamatan'], true)) {
                if ($value !== null && trim((string) $current) !== trim((string) $value)) {
                    $row['changes'][$field] = ['before' => $current, 'after' => $value];
                }
            } else {
                $old = ($current === null || $current === '') ? null : (float) $current;
                if ($old === null || abs($old - (float) $value) > 0.00001) {
                    $row['changes'][$field] = ['before' => $current, 'after' => $value];
                }
            }
        }
        $matches[] = $row;
    }

    $matchedIds = array_fill_keys(array_column($matches, 'id'), true);
    $dbNotInExcel = $filials->filter(fn($g) => !isset($matchedIds[$g->id]));
    echo "=== LAPORAN IMPOR DATA FILIAL ===\n";
    echo "File: {$excelPath}\n";
    echo "Baris nama filial di Excel: " . count($rows) . "\n";
    echo "Filial di database: " . $filials->count() . "\n";
    echo "Cocok unik: " . count($matches) . "\n";
    echo "Nama Excel tidak cocok: " . count($unmatchedExcel) . "\n";
    echo "Nama ambigu: " . count($ambiguousExcel) . "\n";
    echo "Filial database tidak terpasangkan: " . $dbNotInExcel->count() . "\n\n";

    foreach ($matches as $m) {
        if (!$m['changes']) continue;
        echo "[ID {$m['id']} | {$m['kode_gudang']}] {$m['db_name']}\n";
        echo "  Excel: {$m['excel_name']} | Induk DB: {$m['db_parent_code']} | Induk Excel: {$m['parent_excel']}\n";
        foreach ($m['changes'] as $field => $change) {
            echo "  - {$field}: " . var_export($change['before'], true) . " => " . var_export($change['after'], true) . "\n";
        }
    }
    if ($unmatchedExcel) {
        echo "\n--- NAMA EXCEL TIDAK COCOK ---\n";
        foreach ($unmatchedExcel as $r) echo "Baris {$r['excel_row']}: {$r['excel_name']}\n";
    }
    if ($ambiguousExcel) {
        echo "\n--- NAMA AMBIGU ---\n";
        foreach ($ambiguousExcel as $a) {
            echo "Baris {$a['row']['excel_row']}: {$a['row']['excel_name']}\n";
            foreach ($a['candidates'] as $c) echo "  ID {$c['id']} | {$c['code']} | {$c['name']}\n";
        }
    }
    if ($dbNotInExcel->isNotEmpty()) {
        echo "\n--- FILIAL DB TIDAK ADA DI EXCEL ---\n";
        foreach ($dbNotInExcel as $g) echo "ID {$g->id} | {$g->kode_gudang} | {$g->nama_gudang}\n";
    }

    // Tidak pernah menyentuh telepon/email. Tidak menerapkan update bila pencocokan tidak lengkap.
    $ready = count($rows) === 92
        && $filials->count() === 92
        && count($matches) === 92
        && count($unmatchedExcel) === 0
        && count($ambiguousExcel) === 0
        && $dbNotInExcel->isEmpty();

    if (!$apply) {
        echo "\nMODE LAPORAN SAJA: database TIDAK diubah.\n";
        echo $ready ? "Validasi pemetaan lengkap. Setelah memeriksa laporan, jalankan ulang dengan --apply untuk menerapkan perubahan.\n"
                    : "Pemetaan belum lengkap. Jangan gunakan --apply sebelum masalah pencocokan dibereskan.\n";
        exit($ready ? 0 : 2);
    }
    if (!$ready) {
        throw new RuntimeException('Pemetaan belum lengkap/unik; update dibatalkan.');
    }

    DB::transaction(function () use ($matches) {
        foreach ($matches as $m) {
            $updates = [];
            foreach ($m['changes'] as $field => $change) {
                $updates[$field] = $change['after'];
            }
            if ($updates) {
                Gudang::whereKey($m['id'])->update($updates);
            }
        }
    });
    echo "\nBERHASIL: data yang tersedia di Excel diterapkan ke 92 filial.\n";
    echo "Nomor telepon dan email tidak diubah. Kolom yang kosong di Excel dibiarkan seperti semula.\n";
} catch (Throwable $e) {
    fwrite(STDERR, "\nGAGAL: " . $e->getMessage() . "\n");
    fwrite(STDERR, "Tidak ada update yang diterapkan jika validasi gagal; perubahan dalam transaksi akan di-rollback.\n");
    exit(1);
}
