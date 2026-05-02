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
<li><strong>Nasi & umbi-umbian</strong> - Sumber energi utama</li>
<li><strong>Lauk pauk</strong> - Sumber protein (ikan, telur, daging, tempe, tahu)</li>
<li><strong>Sayur-sayuran</strong> - Sumber serat, vitamin, dan mineral</li>
<li><strong>Buah-buahan</strong> - Sumber vitamin C dan antioksidan</li>
<li><strong>Susu</strong> - Sumber kalsium untuk tulang dan gigi</li>
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
<p>- Konsumsi makanan bergizi sejak hamil<br>
- ASI eksklusif 6 bulan, dilanjutkan sampai 2 tahun<br>
- Berikan MPASI bergizi lengkap dan higienis<br>
- Rutin ke Posyandu untuk pemantauan pertumbuhan<br>
- Jaga kebersihan lingkungan dan cuci tangan pakai sabun</p>',
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
<li><strong>Informasi Nilai Gizi (ING)</strong> - Jumlah energi, protein, lemak, karbohidrat per saji</li>
<li><strong>% AKG (Angka Kecukupan Gizi)</strong> - Persentase kebutuhan gizi harian yang terpenuhi per saji</li>
<li><strong>Daftar Bahan</strong> - Bahan utama disebutkan pertama, semakin pendek daftar biasanya semakin baik</li>
<li><strong>Tanggal kedaluwarsa</strong> - Pastikan masih segar</li>
</ul>

<h3>Tips Memilih Makanan Sehat</h3>
<p>- Pilih produk dengan gula < 10g per saji<br>
- Garam (natrium) < 200mg per saji<br>
- Lemak jenuh < 2g per saji<br>
- Serat > 3g per saji<br>
- Hindari bahan tambahan pangan (BTP) berlebihan</p>',
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
                'judul' => 'Keragaman pangan, pola asuh makan dan kejadian stunting pada balita usia 24-59 bulan',
                'ringkasan' => 'PDF resmi Jurnal Gizi Indonesia. Visual sayur-buah dipilih karena artikel ini menekankan keragaman pangan dan pola asuh makan sebagai faktor yang berhubungan dengan stunting balita.',
                'konten' => '<p>Artikel ini meneliti hubungan keragaman pangan dan pola asuh makan dengan kejadian stunting pada balita usia 24-59 bulan di Kecamatan Bayat, Kabupaten Klaten.</p>
<h3>Ringkasan Artikel</h3>
<ul>
<li>Desain penelitian menggunakan cross-sectional study dengan 100 balita.</li>
<li>Keragaman pangan diukur menggunakan Individual Dietary Diversity Score (IDDS).</li>
<li>Hasil menunjukkan hubungan antara panjang badan lahir, pola asuh makan, dan keragaman pangan dengan stunting.</li>
</ul>
<h3>Kesimpulan Singkat</h3>
<p>Keragaman pangan menjadi salah satu faktor dominan yang berhubungan dengan kejadian stunting pada balita.</p>',
                'tipe' => 'jurnal',
                'kategori' => 'Stunting Balita',
                'gambar' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=800',
                'sumber' => 'Jurnal Gizi Indonesia, Vol 7 No 1 (2018), pp. 22-29',
                'google_scholar_url' => 'https://scholar.google.com/scholar?q=%22Keragaman+pangan%2C+pola+asuh+makan+dan+kejadian+stunting+pada+balita+usia+24-59+bulan%22',
                'pdf_url' => 'https://ejournal.undip.ac.id/index.php/jgi/article/download/20025/14467',
                'durasi_baca' => 8,
            ],
            [
                'judul' => 'Pengaruh pendidikan gizi terhadap pengetahuan, praktik gizi seimbang dan status gizi pada anak sekolah dasar',
                'ringkasan' => 'PDF resmi Jurnal Gizi Indonesia. Visual bekal sehat dipakai karena artikel membahas pendidikan gizi, praktik membawa makanan gizi seimbang, dan status gizi siswa sekolah dasar.',
                'konten' => '<p>Artikel ini mengevaluasi pengaruh pendidikan gizi terhadap pengetahuan gizi, praktik gizi seimbang, dan status gizi anak sekolah dasar.</p>
<h3>Ringkasan Artikel</h3>
<ul>
<li>Penelitian dilakukan pada siswa SDN Paringin 2, Kalimantan Selatan.</li>
<li>Intervensi berupa pendidikan gizi tentang Pedoman Gizi Seimbang.</li>
<li>Hasil menunjukkan peningkatan pengetahuan gizi setelah intervensi.</li>
</ul>
<h3>Kesimpulan Singkat</h3>
<p>Pendidikan gizi membantu meningkatkan pengetahuan anak sekolah, meskipun perubahan praktik dan status gizi membutuhkan pendampingan lebih lanjut.</p>',
                'tipe' => 'jurnal',
                'kategori' => 'Edukasi Anak Sekolah',
                'gambar' => 'https://images.unsplash.com/photo-1547592180-85f173990554?w=800',
                'sumber' => 'Jurnal Gizi Indonesia, Vol 6 No 1 (2017), pp. 58-64',
                'google_scholar_url' => 'https://scholar.google.com/scholar?q=%22Pengaruh+pendidikan+gizi+terhadap+pengetahuan%2C+praktik+gizi+seimbang+dan+status+gizi+pada+anak+sekolah+dasar%22',
                'pdf_url' => 'https://ejournal.undip.ac.id/index.php/jgi/article/download/17757/12614',
                'durasi_baca' => 7,
            ],
            [
                'judul' => 'A nutrition diary-book effectively increase knowledge and adherence of iron tablet consumption among adolescent female students',
                'ringkasan' => 'PDF resmi Jurnal Gizi dan Dietetik Indonesia. Visual tablet suplemen dipakai karena artikel ini berfokus pada kepatuhan konsumsi tablet zat besi pada remaja putri.',
                'konten' => '<p>Artikel ini menilai pengaruh edukasi melalui buku diary gizi terhadap pengetahuan, minat mencari tablet zat besi, dan kepatuhan konsumsi tablet zat besi pada remaja putri.</p>
<h3>Ringkasan Artikel</h3>
<ul>
<li>Desain penelitian quasi experimental dengan kelompok intervensi dan kontrol.</li>
<li>Kelompok intervensi mendapat tablet zat besi dan buku Diary Gizi.</li>
<li>Kelompok dengan buku Diary Gizi menunjukkan pengetahuan dan kepatuhan konsumsi tablet zat besi yang lebih baik.</li>
</ul>
<h3>Kesimpulan Singkat</h3>
<p>Buku Diary Gizi dapat menjadi media edukasi untuk meningkatkan kepatuhan konsumsi tablet zat besi pada remaja putri.</p>',
                'tipe' => 'jurnal',
                'kategori' => 'Anemia Remaja',
                'gambar' => 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=800',
                'sumber' => 'Jurnal Gizi dan Dietetik Indonesia, Vol 8 No 2 (2020), pp. 87-92',
                'google_scholar_url' => 'https://scholar.google.com/scholar?q=%22A+nutrition+diary-book+effectively+increase+knowledge+and+adherence+of+iron+tablet+consumption+among+adolescent+female+students%22',
                'pdf_url' => 'https://ejournal.almaata.ac.id/index.php/IJND/article/download/1273/pdfjg',
                'durasi_baca' => 6,
            ],
        ];

        foreach ($materi as $item) {
            Edukasi::updateOrCreate(
                ['judul' => $item['judul']],
                $item
            );
        }

        Edukasi::where('tipe', 'jurnal')->delete();

        foreach ($jurnal as $item) {
            Edukasi::create($item);
        }
    }
}
