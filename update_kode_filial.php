<?php

// Jalankan dari root proyek Laravel: php update_kode_filial.php
// Skrip memvalidasi seluruh pemetaan sebelum mengubah data, lalu memakai transaksi DB.
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Gudang;

$mapping = [
    ['id' => 17, 'old' => "FIL-007", 'new' => "FIL-001", 'name' => "Fil Pt Satu Arah Sukses (Gd Pkd)", 'parent' => "GDG-001"],
    ['id' => 20, 'old' => "FIL-010", 'new' => "FIL-002", 'name' => "Fil Cv Saldo Jaya (Gd Pkd)", 'parent' => "GDG-001"],
    ['id' => 21, 'old' => "FIL-011", 'new' => "FIL-003", 'name' => "Fil Cv Campur Jaya (Gd Pkd)", 'parent' => "GDG-001"],
    ['id' => 36, 'old' => "FIL-026", 'new' => "FIL-004", 'name' => "Fil Cv Saldo Jaya 02 (Gd Pkd)", 'parent' => "GDG-001"],
    ['id' => 40, 'old' => "FIL-030", 'new' => "FIL-005", 'name' => "Fil Cv Mega Bintang Kurniawan (Gd Pkd)", 'parent' => "GDG-001"],
    ['id' => 41, 'old' => "FIL-031", 'new' => "FIL-006", 'name' => "Fil Cv Indo Padi Nusantara Balongan (Gd Pkd)", 'parent' => "GDG-001"],
    ['id' => 49, 'old' => "FIL-039", 'new' => "FIL-007", 'name' => "Fil Pt Sri Manunggal Jaya 01 (Gd Pkd)", 'parent' => "GDG-001"],
    ['id' => 50, 'old' => "FIL-040", 'new' => "FIL-008", 'name' => "Fil Pt Sri Manunggal Jaya 02 (Gd Pkd)", 'parent' => "GDG-001"],
    ['id' => 67, 'old' => "FIL-057", 'new' => "FIL-009", 'name' => "Fil Pt Tunas Mulya Group (Gd Pkd)", 'parent' => "GDG-001"],
    ['id' => 76, 'old' => "FIL-066", 'new' => "FIL-010", 'name' => "Berkah Persada Makmur", 'parent' => "GDG-001"],
    ['id' => 78, 'old' => "FIL-068", 'new' => "FIL-011", 'name' => "Gudang Slamet Rahayu 01 (Gd Pkd)", 'parent' => "GDG-001"],
    ['id' => 79, 'old' => "FIL-069", 'new' => "FIL-012", 'name' => "Gudang Slamet Rahayu 02 (Gd Pkd)", 'parent' => "GDG-001"],
    ['id' => 82, 'old' => "FIL-072", 'new' => "FIL-013", 'name' => "Gudang Sariya (Gd Pkd)", 'parent' => "GDG-001"],
    ['id' => 87, 'old' => "FIL-077", 'new' => "FIL-014", 'name' => "Gudang H. Pandi (Gd Pkd)", 'parent' => "GDG-001"],
    ['id' => 95, 'old' => "FIL-085", 'new' => "FIL-015", 'name' => "Fil Lumbung Pangan Bambu (Gd Pkd)", 'parent' => "GDG-001"],
    ['id' => 101, 'old' => "FIL-091", 'new' => "FIL-016", 'name' => "Fil Pt Sri Manunggal Jaya 03 (Gd Pkd)", 'parent' => "GDG-001"],
    ['id' => 14, 'old' => "FIL-005", 'new' => "FIL-017", 'name' => "Fil Pb Alam Jaya (Gd Kdw)", 'parent' => "GDG-002"],
    ['id' => 28, 'old' => "FIL-018", 'new' => "FIL-018", 'name' => "Gudang Chindi Anggita Sari (Gd Kdw)", 'parent' => "GDG-002"],
    ['id' => 29, 'old' => "FIL-019", 'new' => "FIL-019", 'name' => "Gudang Saepudin (Gd Kdw)", 'parent' => "GDG-002"],
    ['id' => 52, 'old' => "FIL-042", 'new' => "FIL-020", 'name' => "Fil Cv Urip Berkah Jaya (Gd Kdw)", 'parent' => "GDG-002"],
    ['id' => 54, 'old' => "FIL-044", 'new' => "FIL-021", 'name' => "Fil Pt Anas Putra Tunggal (Gd Kdw)", 'parent' => "GDG-002"],
    ['id' => 55, 'old' => "FIL-045", 'new' => "FIL-022", 'name' => "Fil Cv Ipik Sumber Jaya (Gd Kdw)", 'parent' => "GDG-002"],
    ['id' => 56, 'old' => "FIL-046", 'new' => "FIL-023", 'name' => "Fil Cv Dunia Tani Mandiri (Gd Kdw)", 'parent' => "GDG-002"],
    ['id' => 66, 'old' => "FIL-056", 'new' => "FIL-024", 'name' => "Fil Cv Nuji Dasminah Jaya (Gd Kdw)", 'parent' => "GDG-002"],
    ['id' => 75, 'old' => "FIL-065", 'new' => "FIL-025", 'name' => "Pt Pupuk Indonesia Pangan", 'parent' => "GDG-002"],
    ['id' => 83, 'old' => "FIL-073", 'new' => "FIL-026", 'name' => "Gudang Saepudin 02 (Gd Kdw)", 'parent' => "GDG-002"],
    ['id' => 85, 'old' => "FIL-075", 'new' => "FIL-027", 'name' => "Gudang Sunendi Bin Sakim (Gd Kdw)", 'parent' => "GDG-002"],
    ['id' => 96, 'old' => "FIL-086", 'new' => "FIL-028", 'name' => "Fil Urip Berkah Jaya 02 (Gd Kdw)", 'parent' => "GDG-002"],
    ['id' => 97, 'old' => "FIL-087", 'new' => "FIL-029", 'name' => "Fil Ipik Sumber Jaya 02 (Gd Kdw)", 'parent' => "GDG-002"],
    ['id' => 98, 'old' => "FIL-088", 'new' => "FIL-030", 'name' => "Fil CV Megang Bintang Kurniawan (Gd Kdw)", 'parent' => "GDG-002"],
    ['id' => 100, 'old' => "FIL-090", 'new' => "FIL-031", 'name' => "Gudang Edo Adi Ryanto (Gd Kdw)", 'parent' => "GDG-002"],
    ['id' => 18, 'old' => "FIL-008", 'new' => "FIL-032", 'name' => "Fil Cv Jaya Persada Langgeng (Gd Lwg)", 'parent' => "GDG-003"],
    ['id' => 30, 'old' => "FIL-020", 'new' => "FIL-033", 'name' => "Fil Pt Surya Jaya Dongkal (Gd Lwg)", 'parent' => "GDG-003"],
    ['id' => 33, 'old' => "FIL-023", 'new' => "FIL-034", 'name' => "Fil Cv Indo Padi Nusantara (Gd Lwg)", 'parent' => "GDG-003"],
    ['id' => 57, 'old' => "FIL-047", 'new' => "FIL-035", 'name' => "Fil Pt Surya Jaya Dongkal 2 (Gd Lwg)", 'parent' => "GDG-003"],
    ['id' => 69, 'old' => "FIL-059", 'new' => "FIL-036", 'name' => "Fil Cv Heru Nur Jaya (Gd Lwg)", 'parent' => "GDG-003"],
    ['id' => 77, 'old' => "FIL-067", 'new' => "FIL-037", 'name' => "Gudang Caya (Gd Lwg)", 'parent' => "GDG-003"],
    ['id' => 88, 'old' => "FIL-078", 'new' => "FIL-038", 'name' => "Gudang Satrio J.P (Gd Lwg)", 'parent' => "GDG-003"],
    ['id' => 25, 'old' => "FIL-015", 'new' => "FIL-039", 'name' => "Gudang Solehah (Gd Los)", 'parent' => "GDG-004"],
    ['id' => 26, 'old' => "FIL-016", 'new' => "FIL-040", 'name' => "Gudang Syahril Aditri (Gd Los)", 'parent' => "GDG-004"],
    ['id' => 27, 'old' => "FIL-017", 'new' => "FIL-041", 'name' => "Gudang Thaci (Gd Los)", 'parent' => "GDG-004"],
    ['id' => 37, 'old' => "FIL-027", 'new' => "FIL-042", 'name' => "Fil Pt Pangan Masa Depan (Gd Los)", 'parent' => "GDG-004"],
    ['id' => 48, 'old' => "FIL-038", 'new' => "FIL-043", 'name' => "Fil Cv Manisha Gula (Gd Los)", 'parent' => "GDG-004"],
    ['id' => 59, 'old' => "FIL-049", 'new' => "FIL-044", 'name' => "Fil Pt Pangan Masa Depan 02 (Gd Los)", 'parent' => "GDG-004"],
    ['id' => 62, 'old' => "FIL-052", 'new' => "FIL-045", 'name' => "Fil Cv Putra Muncul (Gd Los)", 'parent' => "GDG-004"],
    ['id' => 84, 'old' => "FIL-074", 'new' => "FIL-046", 'name' => "Gudang Firman Lubis (Gd Los)", 'parent' => "GDG-004"],
    ['id' => 99, 'old' => "FIL-089", 'new' => "FIL-047", 'name' => "Gudang Yenny Cyndiani (Gd Los)", 'parent' => "GDG-004"],
    ['id' => 102, 'old' => "FIL-092", 'new' => "FIL-048", 'name' => "Gudang Raswi (Gd Los)", 'parent' => "GDG-004"],
    ['id' => 10, 'old' => "FIL-001", 'new' => "FIL-049", 'name' => "Fil H. Rasidi (Gd Tgg)", 'parent' => "GDG-005"],
    ['id' => 19, 'old' => "FIL-009", 'new' => "FIL-050", 'name' => "Fil Pt Syailendra Bagus Jaya (Gd Tgg)", 'parent' => "GDG-005"],
    ['id' => 24, 'old' => "FIL-014", 'new' => "FIL-051", 'name' => "Fikri Miftaahul Zaman (Gd Tgg)", 'parent' => "GDG-005"],
    ['id' => 31, 'old' => "FIL-021", 'new' => "FIL-052", 'name' => "Fil Cv Putra Karunia Utama 02 (Gd Tgg)", 'parent' => "GDG-005"],
    ['id' => 32, 'old' => "FIL-022", 'new' => "FIL-053", 'name' => "Fil Cv Putra Karunia Utama 03 (Gd Tgg)", 'parent' => "GDG-005"],
    ['id' => 39, 'old' => "FIL-029", 'new' => "FIL-054", 'name' => "Fil Cv Aina Jaya Mandiri 01 (Gd Tgg)", 'parent' => "GDG-005"],
    ['id' => 46, 'old' => "FIL-036", 'new' => "FIL-055", 'name' => "Fikri Miftaahul Zaman 2 (Gd Tgg)", 'parent' => "GDG-005"],
    ['id' => 71, 'old' => "FIL-061", 'new' => "FIL-056", 'name' => "Fil Cv Aina Jaya Mandiri 02 (Gd Tgg)", 'parent' => "GDG-005"],
    ['id' => 90, 'old' => "FIL-080", 'new' => "FIL-057", 'name' => "Gudang M Wildan Aripin (Gd Tgg)", 'parent' => "GDG-005"],
    ['id' => 91, 'old' => "FIL-081", 'new' => "FIL-058", 'name' => "Gudang M Wildan Aripin 02 (Gd Tgg)", 'parent' => "GDG-005"],
    ['id' => 93, 'old' => "FIL-083", 'new' => "FIL-059", 'name' => "Gudang Fikri Miftaahul Zaman 03 (Gd Tgg)", 'parent' => "GDG-005"],
    ['id' => 12, 'old' => "FIL-003", 'new' => "FIL-060", 'name' => "Fil Cv Daud Tiga Putra Jaya (Gd Sk1)", 'parent' => "GDG-006"],
    ['id' => 13, 'old' => "FIL-004", 'new' => "FIL-061", 'name' => "Fil Cv Andi Mulya (Gd Sk1)", 'parent' => "GDG-006"],
    ['id' => 38, 'old' => "FIL-028", 'new' => "FIL-062", 'name' => "Fil Cv Talita Adzilla (Gd Sk1)", 'parent' => "GDG-006"],
    ['id' => 42, 'old' => "FIL-032", 'new' => "FIL-063", 'name' => "Fil Cv Bungsu Jaya Jagat (Gd Sk1)", 'parent' => "GDG-006"],
    ['id' => 43, 'old' => "FIL-033", 'new' => "FIL-064", 'name' => "Gudang Agus Maqori (Sk1)", 'parent' => "GDG-006"],
    ['id' => 44, 'old' => "FIL-034", 'new' => "FIL-065", 'name' => "Gudang Innayatul Azkiyah (Gd Sk1)", 'parent' => "GDG-006"],
    ['id' => 51, 'old' => "FIL-041", 'new' => "FIL-066", 'name' => "Fil Cv Daud Tiga Putra Jaya 02 (Gd Sk1)", 'parent' => "GDG-006"],
    ['id' => 58, 'old' => "FIL-048", 'new' => "FIL-067", 'name' => "Fil Cv Heru Nur Jaya (Gd Sk1)", 'parent' => "GDG-006"],
    ['id' => 60, 'old' => "FIL-050", 'new' => "FIL-068", 'name' => "Fil Cv Daud Tiga Putra Jaya 03 (Gd Sk1)", 'parent' => "GDG-006"],
    ['id' => 61, 'old' => "FIL-051", 'new' => "FIL-069", 'name' => "Fil Pt Tegar Arum Aini (Gd Sk1)", 'parent' => "GDG-006"],
    ['id' => 64, 'old' => "FIL-054", 'new' => "FIL-070", 'name' => "Fil Pt Putra Digjaya Sejahtera (Gd Sk1)", 'parent' => "GDG-006"],
    ['id' => 86, 'old' => "FIL-076", 'new' => "FIL-071", 'name' => "Gudang Agus Maqori 02 (Gd Sk1)", 'parent' => "GDG-006"],
    ['id' => 92, 'old' => "FIL-082", 'new' => "FIL-072", 'name' => "Gudang Ade Irawan (Gd Sk1)", 'parent' => "GDG-006"],
    ['id' => 16, 'old' => "FIL-006", 'new' => "FIL-073", 'name' => "Fil Cv Dede Iting (Gd Sk2)", 'parent' => "GDG-007"],
    ['id' => 22, 'old' => "FIL-012", 'new' => "FIL-074", 'name' => "Fil Berkah Impian Utama (Gd Sk2)", 'parent' => "GDG-007"],
    ['id' => 23, 'old' => "FIL-013", 'new' => "FIL-075", 'name' => "Adi Saputra (Gd Sk2)", 'parent' => "GDG-007"],
    ['id' => 34, 'old' => "FIL-024", 'new' => "FIL-076", 'name' => "Fil Cv Sumber Tani Sams (Gd Sk2)", 'parent' => "GDG-007"],
    ['id' => 35, 'old' => "FIL-025", 'new' => "FIL-077", 'name' => "Fil Cv Dewa Padi (Gd Sk2)", 'parent' => "GDG-007"],
    ['id' => 63, 'old' => "FIL-053", 'new' => "FIL-078", 'name' => "Fil Pt Tawakal Maju Bersama (Gd Sk2)", 'parent' => "GDG-007"],
    ['id' => 89, 'old' => "FIL-079", 'new' => "FIL-079", 'name' => "Gudang Wahyudin (Gd Sk2)", 'parent' => "GDG-007"],
    ['id' => 11, 'old' => "FIL-002", 'new' => "FIL-080", 'name' => "Fil Cv Bakti Alam (Gd Cdp)", 'parent' => "GDG-008"],
    ['id' => 45, 'old' => "FIL-035", 'new' => "FIL-081", 'name' => "Gudang Awanto (Gd Cdp)", 'parent' => "GDG-008"],
    ['id' => 47, 'old' => "FIL-037", 'new' => "FIL-082", 'name' => "Fil Pt Sriana Putri Group (Gd Cdp)", 'parent' => "GDG-008"],
    ['id' => 53, 'old' => "FIL-043", 'new' => "FIL-083", 'name' => "Fil Pt Padi Jaya Tukdana (Gd Cdp)", 'parent' => "GDG-008"],
    ['id' => 65, 'old' => "FIL-055", 'new' => "FIL-084", 'name' => "Fil Pt Pb Cahaya Sri Padi (Gd Cdp)", 'parent' => "GDG-008"],
    ['id' => 68, 'old' => "FIL-058", 'new' => "FIL-085", 'name' => "Fil Pt Sriana Putra Group (Gd Cdp)", 'parent' => "GDG-008"],
    ['id' => 70, 'old' => "FIL-060", 'new' => "FIL-086", 'name' => "Fil Pt Sri Kencana Putra (Gd Cdp)", 'parent' => "GDG-008"],
    ['id' => 72, 'old' => "FIL-062", 'new' => "FIL-087", 'name' => "Fil Pt Yhara Sukses Sejahtera (Gd Cdp)", 'parent' => "GDG-008"],
    ['id' => 73, 'old' => "FIL-063", 'new' => "FIL-088", 'name' => "Fil Pt Generasi Sriana Putra (Gd Cdp)", 'parent' => "GDG-008"],
    ['id' => 74, 'old' => "FIL-064", 'new' => "FIL-089", 'name' => "Fil Pt Generasi Sriana Putra 02 (Gd Cdp)", 'parent' => "GDG-008"],
    ['id' => 80, 'old' => "FIL-070", 'new' => "FIL-090", 'name' => "Gudang Rasidi (Gd Cdp)", 'parent' => "GDG-008"],
    ['id' => 81, 'old' => "FIL-071", 'new' => "FIL-091", 'name' => "Gudang H Sunita (Gd Cdp)", 'parent' => "GDG-008"],
    ['id' => 94, 'old' => "FIL-084", 'new' => "FIL-092", 'name' => "Gudang Danuki (Gd Cdp)", 'parent' => "GDG-008"],
];

if (count($mapping) !== 92) {
    fwrite(STDERR, "GAGAL: pemetaan bukan 92 baris. Tidak ada perubahan.\n");
    exit(1);
}

echo "Skrip akan mengubah kode 92 filial berdasarkan file pemetaan.\n";
echo "Pastikan backup database sudah tersedia.\n";
echo "Ketik YA untuk melanjutkan: ";
$confirmation = trim(fgets(STDIN));
if ($confirmation !== 'YA') {
    echo "Dibatalkan. Tidak ada perubahan.\n";
    exit(0);
}

try {
    DB::transaction(function () use ($mapping) {
        // Validasi kode target dan baris sumber sebelum mengubah apa pun.
        $newCodes = array_column($mapping, 'new');
        if (count(array_unique($newCodes)) !== 92) {
            throw new RuntimeException('Kode baru tidak unik.');
        }

        foreach ($mapping as $row) {
            $g = Gudang::find($row['id']);
            if (!$g) {
                throw new RuntimeException("ID gudang tidak ditemukan: {$row['id']}");
            }
            if ($g->kode_gudang !== $row['old']) {
                throw new RuntimeException("Kode lama tidak cocok untuk ID {$row['id']}: database={$g->kode_gudang}, pemetaan={$row['old']}");
            }
            if ($g->nama_gudang !== $row['name']) {
                throw new RuntimeException("Nama filial tidak cocok untuk ID {$row['id']}: {$g->nama_gudang}");
            }
            $parent = Gudang::find($g->gudang_induk_id);
            if (!$parent || $parent->kode_gudang !== $row['parent']) {
                throw new RuntimeException("Gudang induk tidak cocok untuk ID {$row['id']}");
            }
        }

        $actualFilials = Gudang::whereNotNull('gudang_induk_id')->count();
        if ($actualFilials !== 92) {
            throw new RuntimeException("Jumlah filial sekarang {$actualFilials}, seharusnya 92.");
        }

        // Tahap 1: pindahkan kode lama ke kode sementara agar indeks unik tidak bentrok.
        foreach ($mapping as $row) {
            Gudang::whereKey($row['id'])->update([
                'kode_gudang' => 'TMP-' . str_pad((string) $row['id'], 5, '0', STR_PAD_LEFT),
            ]);
        }

        // Tahap 2: pasang kode baru.
        foreach ($mapping as $row) {
            Gudang::whereKey($row['id'])->update(['kode_gudang' => $row['new']]);
        }

        // Verifikasi hasil di dalam transaksi.
        foreach ($mapping as $row) {
            $g = Gudang::find($row['id']);
            if (!$g || $g->kode_gudang !== $row['new'] || $g->nama_gudang !== $row['name']) {
                throw new RuntimeException("Verifikasi kode baru gagal untuk ID {$row['id']}.");
            }
        }
    });

    echo "BERHASIL: 92 kode filial diperbarui. ID, nama, dan relasi gudang induk dipertahankan.\n";
} catch (Throwable $e) {
    fwrite(STDERR, "GAGAL: " . $e->getMessage() . "\n");
    fwrite(STDERR, "Transaksi dibatalkan; perubahan database di-rollback.\n");
    exit(1);
}
