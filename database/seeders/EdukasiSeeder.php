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
                'judul' => 'Pedoman Gizi Seimbang: Isi Piringku untuk Keluarga',
                'konten' => '<h3>Mengapa bukan hanya 4 Sehat 5 Sempurna?</h3>
<p>Pedoman yang lebih baru menekankan gizi seimbang, variasi makanan, aktivitas fisik, kebersihan, dan pemantauan berat badan. Jadi fokusnya bukan sekadar menambah susu, tetapi memastikan makanan sehari-hari cukup, beragam, aman, dan sesuai kebutuhan.</p>

<h3>Isi Piringku</h3>
<p>Dalam satu kali makan, keluarga dapat memakai prinsip sederhana:</p>
<ul>
<li><strong>Makanan pokok</strong>: nasi, jagung, kentang, ubi, atau sumber karbohidrat lain.</li>
<li><strong>Lauk pauk</strong>: ikan, telur, ayam, daging, hati, tempe, tahu, atau kacang-kacangan.</li>
<li><strong>Sayur</strong>: pilih warna beragam agar vitamin dan mineral lebih lengkap.</li>
<li><strong>Buah</strong>: sumber vitamin, mineral, serat, dan cairan.</li>
</ul>

<h3>Empat Kebiasaan Pendukung</h3>
<ol>
<li>Makan beragam, tidak bergantung pada satu jenis makanan saja.</li>
<li>Membiasakan perilaku hidup bersih, termasuk cuci tangan pakai sabun.</li>
<li>Melakukan aktivitas fisik sesuai usia.</li>
<li>Memantau berat badan dan pertumbuhan secara rutin.</li>
</ol>

<h3>Catatan untuk Balita</h3>
<p>Balita membutuhkan makanan padat gizi. Jangan hanya memberi porsi besar karbohidrat; sertakan lauk sumber protein, terutama protein hewani bila tersedia, serta sayur dan buah sesuai kemampuan makan anak.</p>',
                'tipe' => 'materi',
                'kategori' => 'Gizi Dasar',
                'gambar' => 'https://images.unsplash.com/photo-1490645935967-10de6ba17061?w=600',
                'sumber' => 'Kemenkes RI - Pedoman Gizi Seimbang',
                'durasi_baca' => 7,
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
            [
                'judul' => 'Standar UNICEF-WHO: Membaca Status Gizi Balita dari Z-score',
                'konten' => '<h3>Mengapa memakai Z-score?</h3>
<p>Z-score dipakai dalam standar pertumbuhan WHO untuk membandingkan hasil ukur anak dengan populasi rujukan internasional. Cara ini lebih kuat daripada hanya melihat berat badan atau tinggi badan secara terpisah.</p>

<h3>Indikator yang Perlu Dicatat</h3>
<ul>
<li><strong>BB/U</strong>: berat badan menurut umur, membantu membaca underweight.</li>
<li><strong>PB/U atau TB/U</strong>: panjang/tinggi badan menurut umur, dipakai untuk membaca stunting.</li>
<li><strong>BB/PB atau BB/TB</strong>: berat badan menurut panjang/tinggi, dipakai untuk membaca wasting atau risiko gizi lebih.</li>
<li><strong>IMT/U</strong>: indeks massa tubuh menurut umur, sering dipakai pada anak lebih besar.</li>
</ul>

<h3>Batas Interpretasi Umum</h3>
<ul>
<li>Z-score kurang dari -2 SD menandakan masalah gizi yang perlu perhatian.</li>
<li>Z-score kurang dari -3 SD menandakan kondisi berat dan perlu tindak lanjut cepat.</li>
<li>Stunting dibaca dari indikator PB/U atau TB/U, bukan dari berat badan saja.</li>
<li>Wasting dibaca dari BB/PB atau BB/TB karena menggambarkan kondisi kurus akut.</li>
</ul>

<h3>Catatan untuk Posyandu</h3>
<p>Data harus dicatat dengan umur yang tepat, jenis kelamin, berat, tinggi atau panjang badan, dan tempat pengukuran. Satu angka tidak cukup; tren dari bulan ke bulan jauh lebih berguna untuk melihat perlambatan pertumbuhan.</p>',
                'tipe' => 'materi',
                'kategori' => 'Standar UNICEF-WHO',
                'gambar' => 'https://images.unsplash.com/photo-1584515933487-779824d29309?w=800',
                'sumber' => 'WHO Child Growth Standards, UNICEF Nutrition',
                'durasi_baca' => 9,
            ],
            [
                'judul' => 'MPASI 6-23 Bulan: Keragaman Pangan dan Frekuensi Makan',
                'konten' => '<h3>Prinsip MPASI yang Serius</h3>
<p>MPASI dimulai saat bayi berusia 6 bulan, tetap disertai ASI, dan harus memenuhi empat prinsip: tepat waktu, cukup zat gizi, aman, serta diberikan secara responsif sesuai tanda lapar dan kenyang anak.</p>

<h3>Minimal Keragaman Pangan</h3>
<p>UNICEF dan WHO memakai keragaman kelompok pangan untuk menilai kualitas makan anak usia 6-23 bulan. Target praktisnya adalah anak mendapat minimal 5 dari 8 kelompok pangan dalam sehari.</p>
<ul>
<li>ASI.</li>
<li>Karbohidrat pokok: nasi, jagung, kentang, ubi, roti.</li>
<li>Kacang-kacangan dan biji-bijian.</li>
<li>Produk susu: susu, yogurt, keju sesuai usia.</li>
<li>Protein hewani: daging, ikan, ayam, hati.</li>
<li>Telur.</li>
<li>Buah dan sayur kaya vitamin A.</li>
<li>Buah dan sayur lainnya.</li>
</ul>

<h3>Frekuensi Makan</h3>
<ul>
<li>Usia 6-8 bulan: 2-3 kali makan utama per hari.</li>
<li>Usia 9-23 bulan: 3-4 kali makan utama per hari.</li>
<li>Usia 12-24 bulan: dapat ditambah 1-2 selingan bergizi.</li>
</ul>

<h3>Yang Sering Terlewat</h3>
<p>Anak tidak cukup hanya diberi bubur encer. Makanan perlu padat energi, mengandung protein hewani, lemak sehat, dan teksturnya naik bertahap sesuai kemampuan makan anak.</p>',
                'tipe' => 'materi',
                'kategori' => 'MPASI',
                'gambar' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=800',
                'sumber' => 'WHO Complementary Feeding, UNICEF Child Nutrition',
                'durasi_baca' => 10,
            ],
            [
                'judul' => 'Wasting dan Stunting: Bedanya, Risikonya, dan Kapan Harus Rujuk',
                'konten' => '<h3>Bedanya Wasting dan Stunting</h3>
<p><strong>Stunting</strong> adalah kondisi anak terlalu pendek untuk usianya akibat masalah gizi kronis atau berulang. <strong>Wasting</strong> adalah kondisi anak terlalu kurus untuk tinggi badannya dan sering mencerminkan masalah akut seperti asupan kurang, infeksi, atau keduanya.</p>

<h3>Mengapa Tidak Boleh Disamakan?</h3>
<ul>
<li>Stunting menunjukkan masalah pertumbuhan jangka panjang.</li>
<li>Wasting dapat memburuk cepat dan lebih dekat dengan risiko sakit berat.</li>
<li>Anak bisa mengalami keduanya sekaligus, sehingga risikonya lebih tinggi.</li>
</ul>

<h3>Tanda yang Perlu Diwaspadai</h3>
<ul>
<li>Berat badan turun atau tidak naik berulang.</li>
<li>Anak tampak sangat kurus, lemas, atau tidak aktif.</li>
<li>Bengkak pada kedua punggung kaki.</li>
<li>Diare, muntah, demam, batuk, atau infeksi berulang.</li>
<li>Hasil pengukuran masuk kategori Z-score kurang dari -2 SD.</li>
</ul>

<h3>Apa yang Harus Dilakukan?</h3>
<p>Lakukan pengukuran ulang dengan alat yang benar, cek riwayat makan dan sakit, lalu rujuk ke puskesmas bila ada tanda bahaya, penurunan berat badan, atau Z-score kurang dari -2 SD.</p>',
                'tipe' => 'materi',
                'kategori' => 'Stunting dan Wasting',
                'gambar' => 'https://images.unsplash.com/photo-1519689680058-324335c77eba?w=800',
                'sumber' => 'UNICEF Indonesia Nutrition, WHO Child Growth Standards',
                'durasi_baca' => 8,
            ],
            [
                'judul' => 'Anemia pada Ibu, Remaja Putri, dan Balita',
                'konten' => '<h3>Mengapa Anemia Penting?</h3>
<p>Anemia membuat tubuh kekurangan sel darah merah sehat sehingga oksigen tidak tersalurkan dengan optimal. Pada ibu hamil, anemia meningkatkan risiko bayi lahir dengan berat rendah. Pada anak, anemia dapat mengganggu konsentrasi, daya tahan tubuh, dan perkembangan.</p>

<h3>Kelompok Berisiko</h3>
<ul>
<li>Ibu hamil dan menyusui.</li>
<li>Remaja putri yang mulai menstruasi.</li>
<li>Bayi dan balita dengan asupan zat besi rendah.</li>
<li>Anak yang sering infeksi atau cacingan.</li>
</ul>

<h3>Sumber Zat Besi</h3>
<ul>
<li>Lebih mudah diserap: hati ayam, hati sapi, daging, ikan, ayam, telur.</li>
<li>Sumber nabati: tempe, tahu, kacang hijau, sayur hijau.</li>
<li>Bantu penyerapan dengan vitamin C dari jeruk, jambu, tomat, atau pepaya.</li>
</ul>

<h3>Hal yang Menghambat Penyerapan</h3>
<p>Teh dan kopi dapat menghambat penyerapan zat besi bila diminum dekat waktu makan. Untuk ibu hamil atau remaja putri, konsumsi tablet tambah darah harus mengikuti arahan tenaga kesehatan.</p>',
                'tipe' => 'materi',
                'kategori' => 'Anemia',
                'gambar' => 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=800',
                'sumber' => 'UNICEF Maternal Nutrition, Kemenkes RI',
                'durasi_baca' => 8,
            ],
            [
                'judul' => 'Alur Pemantauan Posyandu: Dari Timbang sampai Tindak Lanjut',
                'konten' => '<h3>Tujuan Pemantauan</h3>
<p>Pemantauan pertumbuhan bukan hanya mengisi angka. Tujuannya adalah menemukan anak yang mulai melambat pertumbuhannya sebelum menjadi masalah gizi berat.</p>

<h3>Data Minimal yang Perlu Dicatat</h3>
<ul>
<li>Nama anak, jenis kelamin, tanggal lahir, dan umur dalam bulan.</li>
<li>Berat badan dengan satuan kilogram.</li>
<li>Panjang atau tinggi badan dengan satuan sentimeter.</li>
<li>Lingkar kepala bila usia dan layanan mensyaratkan.</li>
<li>Nama posyandu atau tempat pencatatan.</li>
<li>Tanggal pengukuran dan nama petugas bila tersedia.</li>
</ul>

<h3>Alur Praktis</h3>
<ol>
<li>Pastikan alat ukur nol dan anak diukur tanpa benda berat.</li>
<li>Catat data segera setelah pengukuran.</li>
<li>Lihat tren dibanding bulan sebelumnya.</li>
<li>Beri konseling makan sesuai masalah yang ditemukan.</li>
<li>Rujuk bila ada tanda bahaya, berat turun, atau hasil indikator masuk kategori bermasalah.</li>
</ol>

<h3>Mengapa Harus Dikelompokkan per Posyandu?</h3>
<p>Pengelompokan per posyandu membantu kader melihat wilayah mana yang banyak memiliki risiko stunting, wasting, anemia, atau kenaikan berat badan tidak adekuat. Data ini berguna untuk menentukan prioritas kunjungan rumah dan edukasi.</p>',
                'tipe' => 'materi',
                'kategori' => 'Posyandu',
                'gambar' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=800',
                'sumber' => 'Kemenkes RI, UNICEF Indonesia',
                'durasi_baca' => 7,
            ],
            [
                'judul' => 'Isi Piring Balita: Fokus pada Padat Gizi, Bukan Sekadar Kenyang',
                'konten' => '<h3>Masalah yang Sering Terjadi</h3>
<p>Banyak anak tampak sudah makan banyak, tetapi makanan utamanya hanya karbohidrat encer. Anak bisa kenyang, namun tetap kurang protein, zat besi, zinc, lemak sehat, dan vitamin penting.</p>

<h3>Komposisi Praktis</h3>
<ul>
<li><strong>Karbohidrat</strong>: nasi, kentang, ubi, jagung, roti, atau pasta.</li>
<li><strong>Protein hewani</strong>: telur, ikan, ayam, daging, hati, atau susu sesuai usia.</li>
<li><strong>Protein nabati</strong>: tempe, tahu, kacang merah, kacang hijau.</li>
<li><strong>Sayur dan buah</strong>: pilih warna beragam.</li>
<li><strong>Lemak sehat</strong>: minyak, santan secukupnya, alpukat, atau kacang yang aman sesuai usia.</li>
</ul>

<h3>Contoh Menu 1 Hari untuk Anak 1-2 Tahun</h3>
<ul>
<li>Pagi: nasi lembek, telur orak-arik, bayam, minyak sedikit.</li>
<li>Siang: nasi, ikan kembung, tempe, wortel.</li>
<li>Selingan: pisang atau pepaya, yogurt tawar bila cocok.</li>
<li>Malam: kentang, ayam cincang, buncis, tahu.</li>
</ul>

<h3>Prinsip Responsif</h3>
<p>Duduk bersama anak, beri waktu makan cukup, jangan memaksa, tetapi tetap dorong dengan sabar. Anak yang sakit sering butuh porsi kecil lebih sering dan perlu makan pemulihan setelah sembuh.</p>',
                'tipe' => 'materi',
                'kategori' => 'Gizi Balita',
                'gambar' => 'https://images.unsplash.com/photo-1498837167922-ddd27525d352?w=800',
                'sumber' => 'WHO Infant and Young Child Feeding, UNICEF Nutrition',
                'durasi_baca' => 8,
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
            [
                'judul' => 'WHO Guideline for complementary feeding of infants and young children 6-23 months of age',
                'ringkasan' => 'Pedoman global WHO tahun 2023 tentang MPASI anak usia 6-23 bulan, mencakup keragaman pangan, frekuensi makan, keamanan pangan, dan responsive feeding.',
                'konten' => '<p>Pedoman WHO ini menjadi rujukan global untuk pemberian makanan pendamping ASI pada anak usia 6-23 bulan, baik anak yang masih menyusu maupun yang tidak menyusu.</p>
<h3>Poin Penting</h3>
<ul>
<li>MPASI umumnya dimulai pada usia 6 bulan ketika ASI saja tidak lagi cukup memenuhi kebutuhan energi dan zat gizi.</li>
<li>Makanan harus padat gizi, aman, bervariasi, dan meningkat teksturnya sesuai usia.</li>
<li>Responsive feeding ditekankan: anak dibantu makan dengan sabar, tidak dipaksa, dan tanda lapar atau kenyang dihargai.</li>
</ul>
<h3>Relevansi untuk GiziCare</h3>
<p>Pedoman ini mendukung fitur pencatatan usia, berat, tinggi, dan edukasi MPASI agar rekomendasi tidak hanya fokus pada angka, tetapi juga praktik makan harian.</p>',
                'tipe' => 'jurnal',
                'kategori' => 'Pedoman MPASI',
                'gambar' => 'https://images.unsplash.com/photo-1490645935967-10de6ba17061?w=800',
                'sumber' => 'World Health Organization, 2023',
                'google_scholar_url' => 'https://scholar.google.com/scholar?q=WHO+Guideline+complementary+feeding+infants+young+children+6-23+months+2023',
                'pdf_url' => 'https://www.who.int/publications/i/item/9789240081864',
                'durasi_baca' => 9,
            ],
            [
                'judul' => 'Child Food Poverty: Nutrition deprivation in early childhood',
                'ringkasan' => 'Laporan UNICEF 2024 tentang kemiskinan pangan anak, terutama anak yang tidak mendapat diet beragam pada masa awal kehidupan.',
                'konten' => '<p>Laporan UNICEF ini membahas anak yang tidak mampu mengakses dan mengonsumsi makanan bergizi serta beragam pada usia dini. Isu ini sangat dekat dengan risiko stunting, wasting, dan hambatan perkembangan.</p>
<h3>Poin Penting</h3>
<ul>
<li>Diet yang terlalu bergantung pada makanan pokok bertepung sering tidak cukup padat zat gizi.</li>
<li>Protein hewani, telur, kacang-kacangan, buah, dan sayur penting untuk zat besi, zinc, vitamin A, protein, dan asam lemak esensial.</li>
<li>Kualitas makan pada dua tahun pertama sangat menentukan pertumbuhan, daya tahan tubuh, dan perkembangan otak.</li>
</ul>
<h3>Relevansi untuk GiziCare</h3>
<p>Materi ini mendukung edukasi keragaman pangan dan pencatatan risiko gizi berdasarkan wilayah posyandu atau tempat layanan.</p>',
                'tipe' => 'jurnal',
                'kategori' => 'Keragaman Pangan',
                'gambar' => 'https://images.unsplash.com/photo-1543362906-acfc16c67564?w=800',
                'sumber' => 'UNICEF Data, 2024',
                'google_scholar_url' => 'https://scholar.google.com/scholar?q=Child+Food+Poverty+Nutrition+deprivation+in+early+childhood+UNICEF+2024',
                'pdf_url' => 'https://data.unicef.org/resources/child-food-poverty-report-2024/',
                'durasi_baca' => 8,
            ],
            [
                'judul' => 'Towards a future in Indonesia without child undernutrition',
                'ringkasan' => 'Laporan Kementerian Kesehatan RI dan UNICEF tentang pengelolaan wasting dan penurunan stunting di Indonesia.',
                'konten' => '<p>Laporan ini menekankan bahwa wasting dan stunting memiliki faktor risiko yang saling berhubungan. Anak yang mengalami salah satu bentuk undernutrition perlu dipantau karena risikonya dapat berkembang menjadi masalah gizi lain.</p>
<h3>Poin Penting</h3>
<ul>
<li>Wasting mengancam kelangsungan hidup, pertumbuhan, dan perkembangan anak.</li>
<li>Stunting dan wasting membutuhkan pencegahan, deteksi dini, serta tata laksana yang terhubung.</li>
<li>Program perlu menjangkau layanan kesehatan, posyandu, keluarga, dan komunitas.</li>
</ul>
<h3>Relevansi untuk GiziCare</h3>
<p>Fitur pencatatan per posyandu, grafik status gizi, dan ringkasan data anak dapat membantu kader melihat prioritas tindak lanjut.</p>',
                'tipe' => 'jurnal',
                'kategori' => 'Undernutrition Indonesia',
                'gambar' => 'https://images.unsplash.com/photo-1576765607924-fae7b7b88f2a?w=800',
                'sumber' => 'Kementerian Kesehatan RI dan UNICEF, 2024',
                'google_scholar_url' => 'https://scholar.google.com/scholar?q=Towards+a+future+in+Indonesia+without+child+undernutrition+UNICEF+Ministry+of+Health+2024',
                'pdf_url' => 'https://www.unicef.org/indonesia/nutrition/reports/towards-future-indonesia-without-child-undernutrition',
                'durasi_baca' => 9,
            ],
            [
                'judul' => 'Nutrition in Indonesia: tackling the triple burden of malnutrition',
                'ringkasan' => 'Ringkasan UNICEF Indonesia tentang tiga beban malnutrisi: undernutrition, defisiensi mikronutrien, dan overweight/obesity.',
                'konten' => '<p>UNICEF Indonesia menjelaskan bahwa Indonesia menghadapi tiga beban malnutrisi sekaligus: stunting dan wasting, anemia atau kekurangan mikronutrien, serta gizi lebih.</p>
<h3>Poin Penting</h3>
<ul>
<li>Masalah gizi tidak hanya stunting; wasting, anemia, dan gizi lebih juga harus dipantau.</li>
<li>Praktik makan, ASI, MPASI, akses layanan, dan kondisi ibu berperan besar.</li>
<li>Intervensi perlu mengikuti siklus hidup: ibu hamil, bayi, balita, anak sekolah, dan remaja.</li>
</ul>
<h3>Relevansi untuk GiziCare</h3>
<p>Konten ini menjadi dasar agar edukasi, quiz, dan pencatatan tidak hanya membahas berat badan, tetapi juga kualitas diet, anemia, serta risiko gizi lebih.</p>',
                'tipe' => 'jurnal',
                'kategori' => 'Triple Burden',
                'gambar' => 'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=800',
                'sumber' => 'UNICEF Indonesia',
                'google_scholar_url' => 'https://scholar.google.com/scholar?q=UNICEF+Indonesia+triple+burden+malnutrition+nutrition',
                'pdf_url' => 'https://www.unicef.org/indonesia/nutrition',
                'durasi_baca' => 7,
            ],
        ];

        Edukasi::where('judul', '4 Sehat 5 Sempurna: Panduan Gizi Seimbang')
            ->update(['judul' => 'Pedoman Gizi Seimbang: Isi Piringku untuk Keluarga']);

        foreach ($materi as $item) {
            Edukasi::updateOrCreate(
                ['judul' => $item['judul']],
                $item
            );
        }

        foreach ($jurnal as $item) {
            Edukasi::updateOrCreate(
                ['judul' => $item['judul']],
                $item
            );
        }
    }
}
