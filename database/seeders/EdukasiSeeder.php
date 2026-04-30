<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Edukasi;

class EdukasiSeeder extends Seeder
{
    public function run(): void
    {
        // MATERI
        $materi = [
            [
                'judul' => '4 Sehat 5 Sempurna: Panduan Gizi Seimbang',
                'konten' => '<h3>Apa itu 4 Sehat 5 Sempurna?</h3>
<p>Konsep 4 Sehat 5 Sempurna adalah panduan makan sehari-hari yang terdiri dari:</p>
<ul>
<li><strong>Nasi & umbi-umbian</strong> → Sumber energi utama</li>
<li><strong>Lauk pauk</strong> → Sumber protein (ikan, telur, daging, tempe, tahu)</li>
<li><strong>Sayur-sayuran</strong> → Sumber serat, vitamin, dan mineral</li>
<li><strong>Buah-buahan</strong> → Sumber vitamin C dan antioksidan</li>
<li><strong>Susu</strong> → Sumber kalsium untuk tulang dan gigi</li>
</ul>
<h3>Tips Praktis</h3>
<p>1. Variasikan menu setiap hari agar tidak bosan<br>
2. Pilih sayur berwarna-warni (merah, hijau, kuning, ungu)<br>
3. Batasi gula, garam, dan lemak berlebih<br>
4. Minum air putih minimal 8 gelas sehari</p>',
                'tipe' => 'materi',
                'kategori' => 'Gizi Dasar',
                'gambar' => 'https://images.unsplash.com/photo-1490645935967-10de6ba17061?w=600',
                'sumber' => 'Kemenkes RI',
                'durasi_baca' => 5,
            ],
            [
                'judul' => 'Stunting: Penyebab, Dampak, dan Pencegahan',
                'konten' => '<h3>Apa itu Stunting?</h3>
<p>Stunting adalah kondisi gagal tumbuh pada anak akibat kekurangan gizi kronis, terutama pada 1.000 hari pertama kehidupan (dari janin hingga usia 2 tahun).</p>
<h3>Penyebab Utama</h3>
<ul>
<li>Kurangnya asupan gizi ibu hamil</li>
<li>Tidak memberikan ASI eksklusif 6 bulan</li>
<li>Kurangnya variasi makanan pendamping ASI (MPASI)</li>
<li>Infeksi berulang (diare, ISPA)</li>
<li>Sanitasi dan hygiene yang buruk</li>
</ul>
<h3>Dampak Jangka Panjang</h3>
<p>Anak stunting cenderung memiliki:</p>
<ul>
<li>IQ lebih rendah dan prestasi belajar menurun</li>
<li>Risiko penyakit tidak menular lebih tinggi (diabetes, jantung)</li>
<li>Produktivitas kerja rendah saat dewasa</li>
</ul>
<h3>Cara Mencegah</h3>
<p>✅ Konsumsi makanan bergizi sejak hamil<br>
✅ ASI eksklusif 6 bulan, dilanjutkan sampai 2 tahun<br>
✅ Berikan MPASI bergizi lengkap dan higienis<br>
✅ Rutin ke Posyandu untuk pemantauan pertumbuhan<br>
✅ Jaga kebersihan lingkungan dan cuci tangan pakai sabun</p>',
                'tipe' => 'materi',
                'kategori' => 'Kesehatan Anak',
                'gambar' => 'https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?w=600',
                'sumber' => 'WHO & UNICEF',
                'durasi_baca' => 8,
            ],
            [
                'judul' => 'MPASI: Panduan Lengkap Makanan Pendamping ASI',
                'konten' => '<h3>Kapan Mulai MPASI?</h3>
<p>MPASI (Makanan Pendamping ASI) diberikan mulai usia <strong>6 bulan</strong>, ketika bayi sudah menunjukkan tanda-tanda siap:</p>
<ul>
<li>Bisa duduk dengan sedikit bantuan</li>
<li>Kepala sudah tegak stabil</li>
<li>Tertarik pada makanan orang dewasa</li>
<li>Refleks menghalangi makanan dengan lidah sudah berkurang</li>
</ul>
<h3>Prinsip MPASI yang Benar</h3>
<p><strong>Timbang:</strong> Tekstur makanan harus sesuai usia<br>
<strong>Warna:</strong> Variasikan warna sayur dan buah<br>
<strong>Aroma:</strong> Gunakan bumbu alami (bawang putih, jahe, daun salam)<br>
<strong>Rasa:</strong> Tanpa gula, garam, dan penyedap hingga usia 1 tahun</p>
<h3>Contoh Menu MPASI 6-8 Bulan</h3>
<table border="1" cellpadding="8">
<tr><th>Waktu</th><th>Menu</th></tr>
<tr><td>Pagi (06.00)</td><td>ASI</td></tr>
<tr><td>Sarapan (08.00)</td><td>Bubur nasi + hati ayam + wortel (diblender)</td></tr>
<tr><td>Siang (12.00)</td><td>Nasi tim + ikan kembung + bayam (diblender kasar)</td></tr>
<tr><td>Sore (15.00)</td><td>ASI</td></tr>
<tr><td>Malam (18.00)</td><td>Bubur kacang hijau + pisang (diblender)</td></tr>
</table>',
                'tipe' => 'materi',
                'kategori' => 'MPASI',
                'gambar' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=600',
                'sumber' => 'IDAI (Ikatan Dokter Anak Indonesia)',
                'durasi_baca' => 10,
            ],
            [
                'judul' => 'Mikronutrien Penting untuk Ibu Hamil',
                'konten' => '<h3>Zat Gizi Mikro yang Wajib Dikonsumsi</h3>
<p>Selama kehamilan, kebutuhan zat gizi mikro meningkat drastis. Berikut yang paling penting:</p>

<h3>1. Asam Folat (400 mcg/hari)</h3>
<p>Fungsi: Mencegah cacat tabung saraf (neural tube defects) pada janin.<br>
Sumber: Bayam, brokoli, kacang-kacangan, jeruk, suplemen.</p>

<h3>2. Zat Besi (27 mg/hari)</h3>
<p>Fungsi: Mencegah anemia, membantu pembentukan hemoglobin janin.<br>
Sumber: Hati sapi, daging merah, kacang hijau, sayur hijau.</p>

<h3>3. Kalsium (1000 mg/hari)</h3>
<p>Fungsi: Pembentukan tulang dan gigi janin.<br>
Sumber: Susu, yogurt, keju, ikan teri, sayur hijau.</p>

<h3>4. Yodium (220 mcg/hari)</h3>
<p>Fungsi: Perkembangan otak dan sistem saraf janin.<br>
Sumber: Garam beryodium, ikan laut, rumput laut.</p>

<h3>5. Omega-3 (DHA & EPA)</h3>
<p>Fungsi: Perkembangan otak dan retina janin.<br>
Sumber: Ikan salmon, sarden, makarel, kacang kenari.</p>

<h3>Tips Konsumsi Suplemen</h3>
<p>Minum tablet tambah darah (Fe) bersama vitamin C (jeruk) untuk penyerapan lebih baik. Hindari minum kalsium dan zat besi bersamaan karena saling menghambat penyerapan.</p>',
                'tipe' => 'materi',
                'kategori' => 'Kehamilan',
                'gambar' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=600',
                'sumber' => 'Perkumpulan Obstetri dan Ginekologi Indonesia',
                'durasi_baca' => 7,
            ],
            [
                'judul' => 'Cara Membaca Label Gizi pada Kemasan Makanan',
                'konten' => '<h3>Mengapa Membaca Label Gizi Penting?</h3>
<p>Label gizi membantu kita memilih makanan yang lebih sehat dan menghindari produk dengan gula, garam, atau lemak berlebih.</p>

<h3>Komponen Label Gizi</h3>
<ul>
<li><strong>Informasi Nilai Gizi (ING)</strong> → Jumlah energi, protein, lemak, karbohidrat per saji</li>
<li><strong>% AKG (Angka Kecukupan Gizi)</strong> → Persentase kebutuhan gizi harian yang terpenuhi per saji</li>
<li><strong>Daftar Bahan</strong> → Bahan utama disebutkan pertama, semakin pendek daftar biasanya semakin baik</li>
<li><strong>Tanggal kedaluwarsa</strong> → Pastikan masih segar</li>
</ul>

<h3>Tips Memilih Makanan Sehat</h3>
<p>✅ Pilih produk dengan gula < 10g per saji<br>
✅ Garam (natrium) < 200mg per saji<br>
✅ Lemak jenuh < 2g per saji<br>
✅ Serat > 3g per saji<br>
❌ Hindari bahan tambahan pangan (BTP) berlebihan</p>',
                'tipe' => 'materi',
                'kategori' => 'Gizi Dasar',
                'gambar' => 'https://images.unsplash.com/photo-1606787366850-de6330128bfc?w=600',
                'sumber' => 'BPOM RI',
                'durasi_baca' => 6,
            ],
        ];

        // JURNAL
        $jurnal = [
            [
                'judul' => 'Hubungan Antara Konsumsi Sayur dan Buah dengan Status Gizi Balita di Indonesia',
                'konten' => '<p>Penelitian ini menganalisis data Riskesdas 2018 untuk melihat hubungan konsumsi sayur dan buah dengan status gizi balita di 34 provinsi Indonesia.</p>
<h3>Hasil Utama</h3>
<ul>
<li>Hanya 23,5% balita Indonesia yang mengonsumsi sayur dan buah sesuai anjuran</li>
<li>Balita dengan konsumsi sayur & buah adekuat memiliki risiko stunting 40% lebih rendah</li>
<li>Faktor penghambat: harga, ketersediaan musiman, dan kebiasaan orang tua</li>
</ul>
<h3>Kesimpulan</h3>
<p>Intervensi pendidikan gizi pada orang tua dan program kebun sayur keluarga dapat meningkatkan konsumsi sayur dan buah balita secara signifikan.</p>',
                'tipe' => 'jurnal',
                'kategori' => 'Penelitian Gizi',
                'gambar' => null,
                'sumber' => 'Jurnal Gizi Klinik Indonesia, Vol 15 No 2 (2023)',
                'durasi_baca' => 12,
            ],
            [
                'judul' => 'Dampak Program Pemberian Makanan Tambahan (PMT) terhadap Perbaikan Status Gizi Anak Sekolah',
                'konten' => '<p>Studi quasi-experimental ini dilakukan di 20 sekolah dasar di Jawa Barat selama 6 bulan untuk mengevaluasi efektivitas program PMT.</p>
<h3>Metode</h3>
<p>Kelompok intervensi (n=240) menerima PMT berupa biskuit fortifikasi + susu 3x seminggu. Kelompok kontrol (n=240) hanya mendapat edukasi gizi.</p>
<h3>Hasil</h3>
<ul>
<li>Kenaikan BB kelompok intervensi: rata-rata 1,8 kg</li>
<li>Kenaikan BB kelompok kontrol: rata-rata 0,9 kg</li>
<li>Perbedaan bermakna secara statistik (p kurang dari 0,05)</li>
<li>Kehadiran sekolah meningkat 15% pada kelompok intervensi</li>
</ul>
<h3>Rekomendasi</h3>
<p>Program PMT perlu diintegrasikan dengan edukasi gizi dan keterlibatan orang tua untuk keberlanjutan.</p>',
                'tipe' => 'jurnal',
                'kategori' => 'Intervensi Gizi',
                'gambar' => null,
                'sumber' => 'Jurnal Kesehatan Masyarakat Nasional, Vol 18 No 1 (2024)',
                'durasi_baca' => 15,
            ],
            [
                'judul' => 'Prevalensi Anemia pada Remaja Putri dan Hubungannya dengan Konsumsi Tablet Tambah Darah',
                'konten' => '<p>Survei cross-sectional pada 1.200 remaja putri usia 15-18 tahun di 10 SMA di Yogyakarta.</p>
<h3>Temuan</h3>
<ul>
<li>Prevalensi anemia: 32,4% (mild 22%, moderate 9%, severe 1,4%)</li>
<li>Hanya 18% remaja yang rutin minum TTD (Tablet Tambah Darah)</li>
<li>Remaja dengan konsumsi TTD rutin memiliki hemoglobin rata-rata 12,8 g/dL vs 10,9 g/dL pada yang tidak rutin</li>
</ul>
<h3>Faktor Penghambat Konsumsi TTD</h3>
<ol>
<li>Efek samping (mual, konstipasi)</li>
<li>Lupa meminum</li>
<li>Kurangnya informasi dari tenaga kesehatan</li>
<li>Stigma negatif tentang TTD</li>
</ol>
<h3>Saran</h3>
<p>Pendekatan peer education dan reminder digital (WhatsApp) terbukti efektif meningkatkan kepatuhan konsumsi TTD hingga 65%.</p>',
                'tipe' => 'jurnal',
                'kategori' => 'Gizi Remaja',
                'gambar' => null,
                'sumber' => 'Jurnal Gizi dan Dietetik Indonesia, Vol 9 No 3 (2023)',
                'durasi_baca' => 14,
            ],
        ];

        foreach (array_merge($materi, $jurnal) as $item) {
            Edukasi::create($item);
        }
    }
}

