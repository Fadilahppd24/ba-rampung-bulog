<?php

namespace Database\Seeders;

use App\Models\Gudang;
use Illuminate\Database\Seeder;

class GudangFilialSeeder extends Seeder
{
    public function run(): void
    {
        $gudangUtama = [
            'GDG-001' => Gudang::where('kode_gudang', 'GDG-001')->firstOrFail()->id,
            'GDG-002' => Gudang::where('kode_gudang', 'GDG-002')->firstOrFail()->id,
            'GDG-003' => Gudang::where('kode_gudang', 'GDG-003')->firstOrFail()->id,
            'GDG-004' => Gudang::where('kode_gudang', 'GDG-004')->firstOrFail()->id,
            'GDG-005' => Gudang::where('kode_gudang', 'GDG-005')->firstOrFail()->id,
            'GDG-006' => Gudang::where('kode_gudang', 'GDG-006')->firstOrFail()->id,
            'GDG-007' => Gudang::where('kode_gudang', 'GDG-007')->firstOrFail()->id,
            'GDG-008' => Gudang::where('kode_gudang', 'GDG-008')->firstOrFail()->id,
        ];

        $data = [
            ['kode_gudang' => 'FIL-001', 'nama_gudang' => 'Fil H. Rasidi (Gd Tgg)', 'alamat' => 'Desa Tukdana Kec Tukdana Indramayu', 'kapasitas' => 3000, 'gudang_induk_id' => 5],
            ['kode_gudang' => 'FIL-002', 'nama_gudang' => 'Fil Cv Bakti Alam (Gd Cdp)', 'alamat' => 'Desa Bulak Lor Kec. Jatibarang Kab. Indramayu', 'kapasitas' => 650, 'gudang_induk_id' => 8],
            ['kode_gudang' => 'FIL-003', 'nama_gudang' => 'Fil Cv Daud Tiga Putra Jaya (Gd Sk1)', 'alamat' => 'Desa Kedungwungu Kec Krangkeng Indramayu', 'kapasitas' => 1000, 'gudang_induk_id' => 6],
            ['kode_gudang' => 'FIL-004', 'nama_gudang' => 'Fil Cv Andi Mulya (Gd Sk1)', 'alamat' => 'Desa Tempel Kulon Rt2 Rw1 Blok Sana Kec. Lelea', 'kapasitas' => 400, 'gudang_induk_id' => 6],
            ['kode_gudang' => 'FIL-005', 'nama_gudang' => 'Fil Pb Alam Jaya (Gd Kdw)', 'alamat' => 'Kiara Payung Kec Anjatan Indramayu', 'kapasitas' => 450, 'gudang_induk_id' => 2],
            ['kode_gudang' => 'FIL-006', 'nama_gudang' => 'Fil Cv Dede Iting (Gd Sk2)', 'alamat' => 'Desa Srengseng Kec. Krangkeng Kab. Indramayu', 'kapasitas' => 500, 'gudang_induk_id' => 7],
            ['kode_gudang' => 'FIL-007', 'nama_gudang' => 'Fil Pt Satu Arah Sukses (Gd Pkd)', 'alamat' => 'Jl Pahlawan No 242 Lemahmekar Indramayu', 'kapasitas' => 1000, 'gudang_induk_id' => 1],
            ['kode_gudang' => 'FIL-008', 'nama_gudang' => 'Fil Cv Jaya Persada Langgeng (Gd Lwg)', 'alamat' => 'Jl Larangan Kec. Lohbener Kab. Indramayu', 'kapasitas' => 2000, 'gudang_induk_id' => 3],
            ['kode_gudang' => 'FIL-009', 'nama_gudang' => 'Fil Pt Syailendra Bagus Jaya (Gd Tgg)', 'alamat' => 'Desa Tukdana Kec. Tukdana Kab. Indramayu', 'kapasitas' => 3000, 'gudang_induk_id' => 5],
            ['kode_gudang' => 'FIL-010', 'nama_gudang' => 'Fil Cv Saldo Jaya (Gd Pkd)', 'alamat' => 'Jl. Raya Bypass Kec. Widasari Kab. Indramayu', 'kapasitas' => 2500, 'gudang_induk_id' => 1],
            ['kode_gudang' => 'FIL-011', 'nama_gudang' => 'Fil Cv Campur Jaya (Gd Pkd)', 'alamat' => 'Desa Rambatan Wetan Kec. Indramayu Kab. Indramayu', 'kapasitas' => 1200, 'gudang_induk_id' => 1],
            ['kode_gudang' => 'FIL-012', 'nama_gudang' => 'Fil Berkah Impian Utama (Gd Sk2)', 'alamat' => 'Desa Klayan Kec. Gunung Jati Kab. Cirebon', 'kapasitas' => 5000, 'gudang_induk_id' => 7],
            ['kode_gudang' => 'FIL-013', 'nama_gudang' => 'Adi Saputra (Gd Sk2)', 'alamat' => 'Desa Kedokanbunder Wetan Kec Kedokanbunder', 'kapasitas' => 3200, 'gudang_induk_id' => 7],
            ['kode_gudang' => 'FIL-014', 'nama_gudang' => 'Fikri Miftaahul Zaman (Gd Tgg)', 'alamat' => 'Desa Tempel Kulon Rt 1 Rw 1 Blok Sana Kecamatan Lelea', 'kapasitas' => 3000, 'gudang_induk_id' => 5],
            ['kode_gudang' => 'FIL-015', 'nama_gudang' => 'Gudang Solehah (Gd Los)', 'alamat' => 'Desa Wirapanjunan Blok Lembang Kecamatan Kandanghaur Kabupaten Indramayu', 'kapasitas' => 7000, 'gudang_induk_id' => 4],
            ['kode_gudang' => 'FIL-016', 'nama_gudang' => 'Gudang Syahril Aditri (Gd Los)', 'alamat' => 'Blok Rong Desa Sekarmulya Kecamatan Gabuswetan Kabupaten Indramayu', 'kapasitas' => 3000, 'gudang_induk_id' => 4],
            ['kode_gudang' => 'FIL-017', 'nama_gudang' => 'Gudang Thaci (Gd Los)', 'alamat' => 'Desa Wirapanjunan Blok Kungkung Kecamatan Kandanghaur Kabupaten Indramayu', 'kapasitas' => 7500, 'gudang_induk_id' => 4],
            ['kode_gudang' => 'FIL-018', 'nama_gudang' => 'Gudang Chindi Anggita Sari (Gd Kdw)', 'alamat' => 'Desa Gembor Kecamatan Pagaden Kabupaten Subang', 'kapasitas' => 3000, 'gudang_induk_id' => 2],
            ['kode_gudang' => 'FIL-019', 'nama_gudang' => 'Gudang Saepudin (Gd Kdw)', 'alamat' => 'Desa Situraja Kec Gantar Kabupaten Indramayu', 'kapasitas' => 3000, 'gudang_induk_id' => 2],
            ['kode_gudang' => 'FIL-020', 'nama_gudang' => 'Fil Pt Surya Jaya Dongkal (Gd Lwg)', 'alamat' => 'Jl Bypass Kongsijaya - Indramayu', 'kapasitas' => 500, 'gudang_induk_id' => 3],
            ['kode_gudang' => 'FIL-021', 'nama_gudang' => 'Fil Cv Putra Karunia Utama 02 (Gd Tgg)', 'alamat' => 'Desa Bangkaloa Ilir Kec Widasari Kab. Indramayu', 'kapasitas' => 1800, 'gudang_induk_id' => 5],
            ['kode_gudang' => 'FIL-022', 'nama_gudang' => 'Fil Cv Putra Karunia Utama 03 (Gd Tgg)', 'alamat' => 'Bangkaloa Ilir Kec Widasari Indramayu', 'kapasitas' => 4000, 'gudang_induk_id' => 5],
            ['kode_gudang' => 'FIL-023', 'nama_gudang' => 'Fil Cv Indo Padi Nusantara (Gd Lwg)', 'alamat' => 'Jl. Letnan Joni Kec. Jatibarang Kab. Indramayu', 'kapasitas' => 3000, 'gudang_induk_id' => 3],
            ['kode_gudang' => 'FIL-024', 'nama_gudang' => 'Fil Cv Sumber Tani Sams (Gd Sk2)', 'alamat' => 'Jl Raya Kedaton Kab. Indramayu', 'kapasitas' => 1000, 'gudang_induk_id' => 7],
            ['kode_gudang' => 'FIL-025', 'nama_gudang' => 'Fil Cv Dewa Padi (Gd Sk2)', 'alamat' => 'Desa Kapringan Blok Pesantren Kab. Indramayu', 'kapasitas' => 800, 'gudang_induk_id' => 7],
            ['kode_gudang' => 'FIL-026', 'nama_gudang' => 'Fil Cv Saldo Jaya 02 (Gd Pkd)', 'alamat' => 'Jl. Raya Pantura Lama Kab. Indramayu', 'kapasitas' => 2000, 'gudang_induk_id' => 1],
            ['kode_gudang' => 'FIL-027', 'nama_gudang' => 'Fil Pt Pangan Masa Depan (Gd Los)', 'alamat' => 'Jl Raya Losarang Indramayu', 'kapasitas' => 2000, 'gudang_induk_id' => 4],
            ['kode_gudang' => 'FIL-028', 'nama_gudang' => 'Fil Cv Talita Adzilla (Gd Sk1)', 'alamat' => 'Desa Kapringan Kec. Krangkeng Kab. Indramayu', 'kapasitas' => 450, 'gudang_induk_id' => 6],
            ['kode_gudang' => 'FIL-029', 'nama_gudang' => 'Fil Cv Aina Jaya Mandiri 01 (Gd Tgg)', 'alamat' => 'Blok Tengah Desa Bunder Kec. Widasari Kab. Indramayu', 'kapasitas' => 700, 'gudang_induk_id' => 5],
            ['kode_gudang' => 'FIL-030', 'nama_gudang' => 'Fil Cv Mega Bintang Kurniawan (Gd Pkd)', 'alamat' => 'Jl. Semirang Plumbon Kec. Lohbener Kab. Indramayu', 'kapasitas' => 2000, 'gudang_induk_id' => 1],
            ['kode_gudang' => 'FIL-031', 'nama_gudang' => 'Fil Cv Indo Padi Nusantara Balongan (Gd Pkd)', 'alamat' => 'Balongan Kec. Karangmpel Kab. Indramayu', 'kapasitas' => 1500, 'gudang_induk_id' => 1],
            ['kode_gudang' => 'FIL-032', 'nama_gudang' => 'Fil Cv Bungsu Jaya Jagat (Gd Sk1)', 'alamat' => 'Ds Dukuh Jati Krangkeng Indramayu', 'kapasitas' => 700, 'gudang_induk_id' => 6],
            ['kode_gudang' => 'FIL-033', 'nama_gudang' => 'Gudang Agus Maqori (Sk1)', 'alamat' => 'Blok Tegalasemaya Ds Singakerta Krangngkeng Indramayu', 'kapasitas' => 8000, 'gudang_induk_id' => 6],
            ['kode_gudang' => 'FIL-034', 'nama_gudang' => 'Gudang Innayatul Azkiyah (Gd Sk1)', 'alamat' => 'Blok Kalder Ds Krangkeng Indramayu', 'kapasitas' => 5000, 'gudang_induk_id' => 6],
            ['kode_gudang' => 'FIL-035', 'nama_gudang' => 'Gudang Awanto (Gd Cdp)', 'alamat' => 'Jl Ds Sukagumiwang Kec Sukagumiwang Indramayu', 'kapasitas' => 2500, 'gudang_induk_id' => 8],
            ['kode_gudang' => 'FIL-036', 'nama_gudang' => 'Fikri Miftaahul Zaman 2 (Gd Tgg)', 'alamat' => 'Desa Tempel Kulon Rt 1 Rw 1 Blok Sana Kecamatan Lelea', 'kapasitas' => 3000, 'gudang_induk_id' => 5],
            ['kode_gudang' => 'FIL-037', 'nama_gudang' => 'Fil Pt Sriana Putri Group (Gd Cdp)', 'alamat' => 'Tambi Lor Sliyeg Indramayu', 'kapasitas' => 4000, 'gudang_induk_id' => 8],
            ['kode_gudang' => 'FIL-038', 'nama_gudang' => 'Fil Cv Manisha Gula (Gd Los)', 'alamat' => 'Jl Karangsinom Gabus Wetan Indramayu', 'kapasitas' => 1500, 'gudang_induk_id' => 4],
            ['kode_gudang' => 'FIL-039', 'nama_gudang' => 'Fil Pt Sri Manunggal Jaya 01 (Gd Pkd)', 'alamat' => 'Ds Majakerta Balongan Indramayu', 'kapasitas' => 1800, 'gudang_induk_id' => 1],
            ['kode_gudang' => 'FIL-040', 'nama_gudang' => 'Fil Pt Sri Manunggal Jaya 02 (Gd Pkd)', 'alamat' => 'Ds Majakerta Balongan Indramayu', 'kapasitas' => 1500, 'gudang_induk_id' => 1],
            ['kode_gudang' => 'FIL-041', 'nama_gudang' => 'Fil Cv Daud Tiga Putra Jaya 02 (Gd Sk1)', 'alamat' => 'Ds Cemeti Kedokan Bunder Wetan Indramayu', 'kapasitas' => 700, 'gudang_induk_id' => 6],
            ['kode_gudang' => 'FIL-042', 'nama_gudang' => 'Fil Cv Urip Berkah Jaya (Gd Kdw)', 'alamat' => 'Wirakanan Kandanghaur Indramayu', 'kapasitas' => 1000, 'gudang_induk_id' => 2],
            ['kode_gudang' => 'FIL-043', 'nama_gudang' => 'Fil Pt Padi Jaya Tukdana (Gd Cdp)', 'alamat' => 'Desa Kertasemaya Indramayu', 'kapasitas' => 540, 'gudang_induk_id' => 8],
            ['kode_gudang' => 'FIL-044', 'nama_gudang' => 'Fil Pt Anas Putra Tunggal (Gd Kdw)', 'alamat' => 'Kiarasari Comreng Subang', 'kapasitas' => 2800, 'gudang_induk_id' => 2],
            ['kode_gudang' => 'FIL-045', 'nama_gudang' => 'Fil Cv Ipik Sumber Jaya (Gd Kdw)', 'alamat' => 'Blok K8 Ds Kedungjaya Gabuswetan Indramayu', 'kapasitas' => 1500, 'gudang_induk_id' => 2],
            ['kode_gudang' => 'FIL-046', 'nama_gudang' => 'Fil Cv Dunia Tani Mandiri (Gd Kdw)', 'alamat' => 'Desa Cipedang Blok Kanam Indramayu', 'kapasitas' => 1000, 'gudang_induk_id' => 2],
            ['kode_gudang' => 'FIL-047', 'nama_gudang' => 'Fil Pt Surya Jaya Dongkal 2 (Gd Lwg)', 'alamat' => 'Blok Purbaya Ds Kongsijaya Widasari Indramayu', 'kapasitas' => 1500, 'gudang_induk_id' => 3],
            ['kode_gudang' => 'FIL-048', 'nama_gudang' => 'Fil Cv Heru Nur Jaya (Gd Sk1)', 'alamat' => 'Ds Srengseng Kec Krangkeng Indramayu', 'kapasitas' => 2000, 'gudang_induk_id' => 6],
            ['kode_gudang' => 'FIL-049', 'nama_gudang' => 'Fil Pt Pangan Masa Depan 02 (Gd Los)', 'alamat' => 'Jl Pu Karangsinom Kandanghaur Indramayu', 'kapasitas' => 1000, 'gudang_induk_id' => 4],
            ['kode_gudang' => 'FIL-050', 'nama_gudang' => 'Fil Cv Daud Tiga Putra Jaya 03 (Gd Sk1)', 'alamat' => 'Ds Bulak Kec Jatibarang Indramayu', 'kapasitas' => 2000, 'gudang_induk_id' => 6],
            ['kode_gudang' => 'FIL-051', 'nama_gudang' => 'Fil Pt Tegar Arum Aini (Gd Sk1)', 'alamat' => 'Ds Kapringan Kec Krangkeng Indramayu', 'kapasitas' => 3000, 'gudang_induk_id' => 6],
            ['kode_gudang' => 'FIL-052', 'nama_gudang' => 'Fil Cv Putra Muncul (Gd Los)', 'alamat' => 'Ds Wirakan Kandanghaur Indramayu', 'kapasitas' => 1500, 'gudang_induk_id' => 4],
            ['kode_gudang' => 'FIL-053', 'nama_gudang' => 'Fil Pt Tawakal Maju Bersama (Gd Sk2)', 'alamat' => 'Blok Kandangeling Krangkeng Indramayu', 'kapasitas' => 2500, 'gudang_induk_id' => 7],
            ['kode_gudang' => 'FIL-054', 'nama_gudang' => 'Fil Pt Putra Digjaya Sejahtera (Gd Sk1)', 'alamat' => 'Rt 7 Rw 2 Kapetakan Cirebon', 'kapasitas' => 900, 'gudang_induk_id' => 6],
            ['kode_gudang' => 'FIL-055', 'nama_gudang' => 'Fil Pt Pb Cahaya Sri Padi (Gd Cdp)', 'alamat' => 'Blok Palem Ds Lemahayu Kec Kertasemaya Indramayu', 'kapasitas' => 500, 'gudang_induk_id' => 8],
            ['kode_gudang' => 'FIL-056', 'nama_gudang' => 'Fil Cv Nuji Dasminah Jaya (Gd Kdw)', 'alamat' => 'Jl Haurgeulis Gantar Indramayu', 'kapasitas' => 1500, 'gudang_induk_id' => 2],
            ['kode_gudang' => 'FIL-057', 'nama_gudang' => 'Fil Pt Tunas Mulya Group (Gd Pkd)', 'alamat' => 'Desa Limpangan Kec Juntinyuat Indramayu', 'kapasitas' => 1500, 'gudang_induk_id' => 1],
            ['kode_gudang' => 'FIL-058', 'nama_gudang' => 'Fil Pt Sriana Putra Group (Gd Cdp)', 'alamat' => 'Blok Sana Ni 11A Ds Bulak Jatibarang Indramayu', 'kapasitas' => 700, 'gudang_induk_id' => 8],
            ['kode_gudang' => 'FIL-059', 'nama_gudang' => 'Fil Cv Heru Nur Jaya (Gd Lwg)', 'alamat' => 'Jl Perindustrian Kenanga Kec Sindang Indramayu', 'kapasitas' => 1500, 'gudang_induk_id' => 3],
            ['kode_gudang' => 'FIL-060', 'nama_gudang' => 'Fil Pt Sri Kencana Putra (Gd Cdp)', 'alamat' => 'Ds Wanakajir Susukan Cirebon', 'kapasitas' => 700, 'gudang_induk_id' => 8],
            ['kode_gudang' => 'FIL-061', 'nama_gudang' => 'Fil Cv Aina Jaya Mandiri 02 (Gd Tgg)', 'alamat' => 'Jl Mayor Dasuki Jtbarang Indramayu', 'kapasitas' => 1200, 'gudang_induk_id' => 5],
            ['kode_gudang' => 'FIL-062', 'nama_gudang' => 'Fil Pt Yhara Sukses Sejahtera (Gd Cdp)', 'alamat' => 'Desa Sukaperna Kec Tukdana Indramayu', 'kapasitas' => 500, 'gudang_induk_id' => 8],
            ['kode_gudang' => 'FIL-063', 'nama_gudang' => 'Fil Pt Generasi Sriana Putra (Gd Cdp)', 'alamat' => 'Desa Bulak Lor Jtbarang Indramayu', 'kapasitas' => 1000, 'gudang_induk_id' => 8],
            ['kode_gudang' => 'FIL-064', 'nama_gudang' => 'Fil Pt Generasi Sriana Putra 02 (Gd Cdp)', 'alamat' => 'Desa Tersana Sukagumiwang Indramayu', 'kapasitas' => 700, 'gudang_induk_id' => 8],
            ['kode_gudang' => 'FIL-065', 'nama_gudang' => 'Pt Pupuk Indonesia Pangan', 'alamat' => 'Patrol Kec Patrol Indramayu', 'kapasitas' => 5000, 'gudang_induk_id' => 2],
            ['kode_gudang' => 'FIL-066', 'nama_gudang' => 'Berkah Persada Makmur', 'alamat' => 'Ds Krmulya Kec Kandanghaur Indramayu', 'kapasitas' => 3000, 'gudang_induk_id' => 1],
            ['kode_gudang' => 'FIL-067', 'nama_gudang' => 'Gudang Caya (Gd Lwg)', 'alamat' => 'Ds Leuwigede Widasari Indramayu', 'kapasitas' => 3000, 'gudang_induk_id' => 3],
            ['kode_gudang' => 'FIL-068', 'nama_gudang' => 'Gudang Slamet Rahayu 01 (Gd Pkd)', 'alamat' => 'Jl Raya Pantura Lama Indramayu', 'kapasitas' => 4000, 'gudang_induk_id' => 1],
            ['kode_gudang' => 'FIL-069', 'nama_gudang' => 'Gudang Slamet Rahayu 02 (Gd Pkd)', 'alamat' => 'Desa Leuwigede Widasari Indramayu', 'kapasitas' => 3000, 'gudang_induk_id' => 1],
            ['kode_gudang' => 'FIL-070', 'nama_gudang' => 'Gudang Rasidi (Gd Cdp)', 'alamat' => 'Desa Rancajawat Tukdana Indramayu', 'kapasitas' => 4000, 'gudang_induk_id' => 8],
            ['kode_gudang' => 'FIL-071', 'nama_gudang' => 'Gudang H Sunita (Gd Cdp)', 'alamat' => 'Desa Lemahayu Kertasemaya Indramayu', 'kapasitas' => 1500, 'gudang_induk_id' => 8],
            ['kode_gudang' => 'FIL-072', 'nama_gudang' => 'Gudang Sariya (Gd Pkd)', 'alamat' => 'Jl Tambak Raya Lemahmekar Indramayu', 'kapasitas' => 2500, 'gudang_induk_id' => 1],
            ['kode_gudang' => 'FIL-073', 'nama_gudang' => 'Gudang Saepudin 02 (Gd Kdw)', 'alamat' => 'Desa Situraja Kec Gantar Indramayu', 'kapasitas' => 1000, 'gudang_induk_id' => 2],
            ['kode_gudang' => 'FIL-074', 'nama_gudang' => 'Gudang Firman Lubis (Gd Los)', 'alamat' => 'Desa Karanganyar Kandanghaur Indramayu', 'kapasitas' => 7000, 'gudang_induk_id' => 4],
            ['kode_gudang' => 'FIL-075', 'nama_gudang' => 'Gudang Sunendi Bin Sakim (Gd Kdw)', 'alamat' => 'Desa Kroya Kec Kroya Indramayu', 'kapasitas' => 2500, 'gudang_induk_id' => 2],
            ['kode_gudang' => 'FIL-076', 'nama_gudang' => 'Gudang Agus Maqori 02 (Gd Sk1)', 'alamat' => 'Blok Tegalasemaya Ds Singakerta Krangkeng Indramayu', 'kapasitas' => 5000, 'gudang_induk_id' => 6],
            ['kode_gudang' => 'FIL-077', 'nama_gudang' => 'Gudang H. Pandi (Gd Pkd)', 'alamat' => 'Jl. Karangampel Kab. Indramayu', 'kapasitas' => 5500, 'gudang_induk_id' => 1],
            ['kode_gudang' => 'FIL-078', 'nama_gudang' => 'Gudang Satrio J.P (Gd Lwg)', 'alamat' => 'Desa Leuwigede Kec. Widasari Kab. Indramayu', 'kapasitas' => 3500, 'gudang_induk_id' => 3],
            ['kode_gudang' => 'FIL-079', 'nama_gudang' => 'Gudang Wahyudin (Gd Sk2)', 'alamat' => 'Desa Srengseng Kec. Krangkeng Kab. Indramayu', 'kapasitas' => 1700, 'gudang_induk_id' => 7],
            ['kode_gudang' => 'FIL-080', 'nama_gudang' => 'Gudang M Wildan Aripin (Gd Tgg)', 'alamat' => 'Desa Rancajawat Kec. Tukdana Kab. Indramayu', 'kapasitas' => 1800, 'gudang_induk_id' => 5],
            ['kode_gudang' => 'FIL-081', 'nama_gudang' => 'Gudang M Wildan Aripin 02 (Gd Tgg)', 'alamat' => 'Desa Rancajawat Kec. Tukdana Indramayu', 'kapasitas' => 800, 'gudang_induk_id' => 5],
            ['kode_gudang' => 'FIL-082', 'nama_gudang' => 'Gudang Ade Irawan (Gd Sk1)', 'alamat' => 'Desa Karangampel Kec. Karangampel Kab. Indramayu', 'kapasitas' => 1500, 'gudang_induk_id' => 6],
            ['kode_gudang' => 'FIL-083', 'nama_gudang' => 'Gudang Fikri Miftaahul Zaman 03 (Gd Tgg)', 'alamat' => 'Desa Tempel Kulon Rt/Rw 001/001 Blok Sana Kec. Lelea Kab. Indramayu', 'kapasitas' => 1200, 'gudang_induk_id' => 5],
            ['kode_gudang' => 'FIL-084', 'nama_gudang' => 'Gudang Danuki (Gd Cdp)', 'alamat' => 'Jl. Raya Jatibarang Desa Rancajawat Kec. Tukdana Kab. Indramayu', 'kapasitas' => 3500, 'gudang_induk_id' => 8],
            ['kode_gudang' => 'FIL-085', 'nama_gudang' => 'Fil Lumbung Pangan Bambu (Gd Pkd)', 'alamat' => 'Desa Panyindangan Wetan Kec Sindang Indramayu', 'kapasitas' => 792, 'gudang_induk_id' => 1],
            ['kode_gudang' => 'FIL-086', 'nama_gudang' => 'Fil Urip Berkah Jaya 02 (Gd Kdw)', 'alamat' => 'Jl. Legok Kertawinangun Kec. Kandanghaur Indramayu', 'kapasitas' => 1152, 'gudang_induk_id' => 2],
            ['kode_gudang' => 'FIL-087', 'nama_gudang' => 'Fil Ipik Sumber Jaya 02 (Gd Kdw)', 'alamat' => 'Kedungdawa, Kec. Gabuswetan Indramayu', 'kapasitas' => 1380, 'gudang_induk_id' => 2],
            ['kode_gudang' => 'FIL-088', 'nama_gudang' => 'Fil CV Megang Bintang Kurniawan (Gd Kdw)', 'alamat' => 'Kencana Katileng Patrol Baru Kec. Patrol Indramayu', 'kapasitas' => 2380, 'gudang_induk_id' => 2],
            ['kode_gudang' => 'FIL-089', 'nama_gudang' => 'Gudang Yenny Cyndiani (Gd Los)', 'alamat' => 'Jl. Raya Gabus, Karanganyar, Kec. Kandanghaur Indramayu', 'kapasitas' => 864, 'gudang_induk_id' => 4],
            ['kode_gudang' => 'FIL-090', 'nama_gudang' => 'Gudang Edo Adi Ryanto (Gd Kdw)', 'alamat' => 'Blok Cipedang Kec. Bongas Kab. Indramayu', 'kapasitas' => 2270, 'gudang_induk_id' => 2],
            ['kode_gudang' => 'FIL-091', 'nama_gudang' => 'Fil Pt Sri Manunggal Jaya 03 (Gd Pkd)', 'alamat' => 'Ds Majakerta Balongan Indramayu', 'kapasitas' => 600, 'gudang_induk_id' => 1],
            ['kode_gudang' => 'FIL-092', 'nama_gudang' => 'Gudang Raswi (Gd Los)', 'alamat' => 'Jl. Raya Karangsinom Wirapanjunan Kec. Kandanghaur Kab. Indramayu', 'kapasitas' => 5000, 'gudang_induk_id' => 4],
            ['kode_gudang' => 'FIL-093', 'nama_gudang' => 'GUDANG CV DIGJAYA UNIT 1 MINYAK GORENG BANPANG FEB-MAR 2026', 'alamat' => 'BLOK TEGAL SEMAYA RT03 RT02 DS SINGAKERTA KEC KRANGKENF INDRAMAYU', 'kapasitas' => 41800, 'gudang_induk_id' => 6],
        ];

        foreach ($data as &$item) {
            $nomorInduk = $item['gudang_induk_id'];

            $kodeInduk = 'GDG-' . str_pad($nomorInduk, 3, '0', STR_PAD_LEFT);

            $item['gudang_induk_id'] = $gudangUtama[$kodeInduk];
        }

        unset($item);

        foreach ($data as $item) {
            Gudang::updateOrCreate(
                ['kode_gudang' => $item['kode_gudang']],
                [
                    'nama_gudang' => $item['nama_gudang'],
                    'alamat' => $item['alamat'],
                    'kapasitas' => $item['kapasitas'],
                    'gudang_induk_id' => $item['gudang_induk_id'],
                    'status' => 'aktif',
                ]
            );
        }
    }
}
