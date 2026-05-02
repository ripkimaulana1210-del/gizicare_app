<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quiz;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        $soal = [
            [
                'pertanyaan' => 'Berapa lama waktu yang direkomendasikan untuk memberikan ASI eksklusif?',
                'pilihan' => [
                    'A' => '3 bulan',
                    'B' => '6 bulan',
                    'C' => '9 bulan',
                    'D' => '12 bulan'
                ],
                'jawaban_benar' => 'B',
                'kategori' => 'Gizi Anak',
                'penjelasan' => 'WHO merekomendasikan ASI eksklusif selama 6 bulan pertama kehidupan bayi, tanpa tambahan makanan atau minuman lain kecuali obat-obatan yang diperlukan.',
            ],
            [
                'pertanyaan' => 'Zat gizi mikro apa yang paling penting untuk mencegah cacat tabung saraf pada janin?',
                'pilihan' => [
                    'A' => 'Zat besi',
                    'B' => 'Kalsium',
                    'C' => 'Asam folat',
                    'D' => 'Vitamin D'
                ],
                'jawaban_benar' => 'C',
                'kategori' => 'Kehamilan',
                'penjelasan' => 'Asam folat berperan penting dalam pembentukan sel saraf dan mencegah neural tube defects seperti spina bifida. Ibu hamil disarankan mengonsumsi 400 mcg asam folat per hari.',
            ],
            [
                'pertanyaan' => 'Stunting adalah kondisi gagal tumbuh akibat kekurangan gizi kronis pada periode kritis berapa hari pertama kehidupan?',
                'pilihan' => [
                    'A' => '500 hari pertama',
                    'B' => '1.000 hari pertama',
                    'C' => '1.500 hari pertama',
                    'D' => '2.000 hari pertama'
                ],
                'jawaban_benar' => 'B',
                'kategori' => 'Stunting',
                'penjelasan' => '1.000 hari pertama kehidupan (dari konsepsi hingga usia 2 tahun) adalah periode kritis yang menentukan perkembangan otak, tubuh, dan kesehatan anak di masa depan.',
            ],
            [
                'pertanyaan' => 'Manakah yang TIDAK termasuk prinsip Pedoman Gizi Seimbang?',
                'pilihan' => [
                    'A' => 'Makan beragam',
                    'B' => 'Membiasakan hidup bersih',
                    'C' => 'Melakukan aktivitas fisik',
                    'D' => 'Minum minuman bersoda setiap hari'
                ],
                'jawaban_benar' => 'D',
                'kategori' => 'Gizi Dasar',
                'penjelasan' => 'Pedoman Gizi Seimbang menekankan makan beragam, perilaku hidup bersih, aktivitas fisik, dan pemantauan berat badan. Minuman bersoda tinggi gula perlu dibatasi.',
            ],
            [
                'pertanyaan' => 'Pada usia berapa bayi disarankan mulai diberikan MPASI (Makanan Pendamping ASI)?',
                'pilihan' => [
                    'A' => '3 bulan',
                    'B' => '4 bulan',
                    'C' => '6 bulan',
                    'D' => '9 bulan'
                ],
                'jawaban_benar' => 'C',
                'kategori' => 'MPASI',
                'penjelasan' => 'MPASI diberikan mulai usia 6 bulan ketika bayi sudah menunjukkan tanda-tanda siap makan: bisa duduk dengan bantuan, kepala tegak, tertarik pada makanan, dan refleks lidah menghalangi sudah berkurang.',
            ],
            [
                'pertanyaan' => 'Berapa kebutuhan kalsium harian untuk ibu hamil?',
                'pilihan' => [
                    'A' => '500 mg',
                    'B' => '800 mg',
                    'C' => '1000 mg',
                    'D' => '1500 mg'
                ],
                'jawaban_benar' => 'C',
                'kategori' => 'Kehamilan',
                'penjelasan' => 'Ibu hamil membutuhkan 1000 mg kalsium per hari untuk mendukung pembentukan tulang dan gigi janin, serta menjaga kesehatan tulang ibu.',
            ],
            [
                'pertanyaan' => 'Apa warna urin yang menandakan tubuh terhidrasi dengan baik?',
                'pilihan' => [
                    'A' => 'Kuning tua',
                    'B' => 'Kuning muda atau bening',
                    'C' => 'Oranye',
                    'D' => 'Merah'
                ],
                'jawaban_benar' => 'B',
                'kategori' => 'Hidrasi',
                'penjelasan' => 'Urin berwarna kuning muda atau bening menandakan tubuh terhidrasi dengan baik. Warna kuning tua atau oranye menandakan dehidrasi.',
            ],
            [
                'pertanyaan' => 'Berapa persen balita Indonesia yang mengonsumsi sayur dan buah sesuai anjuran menurut Riskesdas 2018?',
                'pilihan' => [
                    'A' => '10%',
                    'B' => '23,5%',
                    'C' => '45%',
                    'D' => '60%'
                ],
                'jawaban_benar' => 'B',
                'kategori' => 'Data Gizi',
                'penjelasan' => 'Menurut Riskesdas 2018, hanya 23,5% balita Indonesia yang mengonsumsi sayur dan buah sesuai anjuran. Padahal konsumsi sayur dan buah adekuat dapat menurunkan risiko stunting hingga 40%.',
            ],
            [
                'pertanyaan' => 'Makanan apa yang paling kaya akan zat besi heme (yang paling mudah diserap tubuh)?',
                'pilihan' => [
                    'A' => 'Bayam',
                    'B' => 'Hati sapi',
                    'C' => 'Tempe',
                    'D' => 'Jeruk'
                ],
                'jawaban_benar' => 'B',
                'kategori' => 'Mikronutrien',
                'penjelasan' => 'Hati sapi merupakan sumber zat besi heme tertinggi. Zat besi heme lebih mudah diserap tubuh (15-35%) dibanding zat besi non-heme dari tumbuhan (2-20%).',
            ],
            [
                'pertanyaan' => 'Berapa banyak air putih yang disarankan dikonsumsi setiap hari untuk dewasa?',
                'pilihan' => [
                    'A' => '4 gelas (1 liter)',
                    'B' => '6 gelas (1,5 liter)',
                    'C' => '8 gelas (2 liter)',
                    'D' => '12 gelas (3 liter)'
                ],
                'jawaban_benar' => 'C',
                'kategori' => 'Hidrasi',
                'penjelasan' => 'Dewasa disarankan minum minimal 8 gelas (sekitar 2 liter) air putih per hari. Kebutuhan bisa lebih tinggi saat cuaca panas, berolahraga, atau saat menyusui.',
            ],
            [
                'pertanyaan' => 'Indikator apa yang digunakan untuk menilai stunting pada balita?',
                'pilihan' => [
                    'A' => 'Berat badan menurut umur (BB/U)',
                    'B' => 'Panjang atau tinggi badan menurut umur (PB/U atau TB/U)',
                    'C' => 'Berat badan menurut tinggi badan (BB/TB)',
                    'D' => 'Lingkar perut menurut umur'
                ],
                'jawaban_benar' => 'B',
                'kategori' => 'Standar UNICEF-WHO',
                'penjelasan' => 'Stunting dinilai dari panjang atau tinggi badan menurut umur. Anak dikategorikan stunted bila Z-score PB/U atau TB/U kurang dari -2 SD.',
            ],
            [
                'pertanyaan' => 'Apa perbedaan utama wasting dan stunting?',
                'pilihan' => [
                    'A' => 'Wasting adalah terlalu pendek, stunting adalah terlalu gemuk',
                    'B' => 'Wasting adalah terlalu kurus untuk tinggi badan, stunting adalah terlalu pendek untuk umur',
                    'C' => 'Wasting hanya terjadi pada remaja, stunting hanya pada bayi',
                    'D' => 'Keduanya selalu berarti hal yang sama'
                ],
                'jawaban_benar' => 'B',
                'kategori' => 'Stunting dan Wasting',
                'penjelasan' => 'Wasting menggambarkan anak terlalu kurus untuk tinggi atau panjang badannya, sedangkan stunting menggambarkan anak terlalu pendek untuk umurnya.',
            ],
            [
                'pertanyaan' => 'Dalam standar pertumbuhan, Z-score kurang dari -3 SD biasanya menunjukkan kondisi apa?',
                'pilihan' => [
                    'A' => 'Kondisi normal',
                    'B' => 'Risiko ringan tanpa tindak lanjut',
                    'C' => 'Kondisi berat yang perlu perhatian cepat',
                    'D' => 'Anak pasti obesitas'
                ],
                'jawaban_benar' => 'C',
                'kategori' => 'Standar UNICEF-WHO',
                'penjelasan' => 'Z-score kurang dari -3 SD menunjukkan masalah gizi berat pada indikator terkait dan perlu penilaian serta tindak lanjut tenaga kesehatan.',
            ],
            [
                'pertanyaan' => 'Target minimal keragaman pangan anak usia 6-23 bulan adalah mengonsumsi berapa kelompok pangan dalam sehari?',
                'pilihan' => [
                    'A' => 'Minimal 2 dari 8 kelompok pangan',
                    'B' => 'Minimal 3 dari 8 kelompok pangan',
                    'C' => 'Minimal 5 dari 8 kelompok pangan',
                    'D' => 'Semua makanan harus dari 1 kelompok pangan'
                ],
                'jawaban_benar' => 'C',
                'kategori' => 'MPASI',
                'penjelasan' => 'WHO dan UNICEF menggunakan minimum dietary diversity untuk anak 6-23 bulan, yaitu konsumsi minimal 5 dari 8 kelompok pangan dalam sehari.',
            ],
            [
                'pertanyaan' => 'Makanan berikut yang termasuk sumber protein hewani padat gizi untuk balita adalah...',
                'pilihan' => [
                    'A' => 'Kerupuk dan teh manis',
                    'B' => 'Ikan, telur, ayam, daging, dan hati',
                    'C' => 'Permen dan minuman bersoda',
                    'D' => 'Bubur nasi encer tanpa lauk'
                ],
                'jawaban_benar' => 'B',
                'kategori' => 'Gizi Balita',
                'penjelasan' => 'Protein hewani menyediakan protein, zat besi, zinc, vitamin B12, dan asam amino penting yang mendukung pertumbuhan anak.',
            ],
            [
                'pertanyaan' => 'Usia 6-8 bulan umumnya membutuhkan berapa kali makan utama MPASI per hari?',
                'pilihan' => [
                    'A' => '1 kali',
                    'B' => '2-3 kali',
                    'C' => '5-6 kali makan utama besar',
                    'D' => 'Tidak perlu MPASI'
                ],
                'jawaban_benar' => 'B',
                'kategori' => 'MPASI',
                'penjelasan' => 'Pada usia 6-8 bulan, WHO merekomendasikan MPASI sekitar 2-3 kali per hari sambil tetap melanjutkan ASI.',
            ],
            [
                'pertanyaan' => 'Prinsip responsive feeding berarti...',
                'pilihan' => [
                    'A' => 'Memaksa anak menghabiskan makanan secepat mungkin',
                    'B' => 'Membiarkan anak selalu makan sendiri tanpa bantuan',
                    'C' => 'Membantu anak makan dengan sabar dan memperhatikan tanda lapar serta kenyang',
                    'D' => 'Memberikan makanan hanya saat anak menangis'
                ],
                'jawaban_benar' => 'C',
                'kategori' => 'MPASI',
                'penjelasan' => 'Responsive feeding berarti pengasuh memberi makan secara sabar, aktif, tidak memaksa, dan responsif terhadap tanda lapar serta kenyang anak.',
            ],
            [
                'pertanyaan' => 'Data apa yang wajib ada agar pencatatan pertumbuhan balita bisa dihitung dengan benar?',
                'pilihan' => [
                    'A' => 'Nama, jenis kelamin, umur/tanggal lahir, berat, dan tinggi/panjang badan',
                    'B' => 'Nama panggilan saja',
                    'C' => 'Warna baju anak',
                    'D' => 'Nomor telepon tetangga'
                ],
                'jawaban_benar' => 'A',
                'kategori' => 'Posyandu',
                'penjelasan' => 'Perhitungan status gizi membutuhkan umur, jenis kelamin, berat badan, dan tinggi atau panjang badan. Nama membantu identifikasi data anak.',
            ],
            [
                'pertanyaan' => 'Mengapa data perlu dikelompokkan berdasarkan posyandu atau tempat layanan?',
                'pilihan' => [
                    'A' => 'Agar data tidak bisa dianalisis',
                    'B' => 'Agar wilayah dengan risiko gizi dapat terlihat dan ditindaklanjuti',
                    'C' => 'Agar grafik selalu kosong',
                    'D' => 'Agar nama anak tidak perlu dicatat'
                ],
                'jawaban_benar' => 'B',
                'kategori' => 'Posyandu',
                'penjelasan' => 'Pengelompokan tempat membantu kader dan petugas melihat wilayah prioritas, merancang edukasi, dan menentukan tindak lanjut seperti kunjungan rumah.',
            ],
            [
                'pertanyaan' => 'Tanda yang perlu segera dirujuk pada anak dengan masalah gizi adalah...',
                'pilihan' => [
                    'A' => 'Anak aktif dan berat naik sesuai tren',
                    'B' => 'Anak tampak sangat lemas, bengkak kedua kaki, atau berat turun',
                    'C' => 'Anak suka satu jenis buah',
                    'D' => 'Anak punya jadwal makan teratur'
                ],
                'jawaban_benar' => 'B',
                'kategori' => 'Stunting dan Wasting',
                'penjelasan' => 'Lemas berat, bengkak kedua kaki, penurunan berat badan, atau gejala infeksi berat adalah tanda yang perlu dinilai tenaga kesehatan.',
            ],
            [
                'pertanyaan' => 'Minuman apa yang dapat menghambat penyerapan zat besi bila diminum dekat waktu makan?',
                'pilihan' => [
                    'A' => 'Air putih',
                    'B' => 'Teh atau kopi',
                    'C' => 'Air matang',
                    'D' => 'Kuah sayur'
                ],
                'jawaban_benar' => 'B',
                'kategori' => 'Anemia',
                'penjelasan' => 'Teh dan kopi mengandung senyawa yang dapat menghambat penyerapan zat besi, terutama bila diminum dekat waktu makan.',
            ],
            [
                'pertanyaan' => 'Makanan atau minuman apa yang membantu penyerapan zat besi dari makanan nabati?',
                'pilihan' => [
                    'A' => 'Sumber vitamin C seperti jeruk, jambu, tomat, atau pepaya',
                    'B' => 'Teh pekat',
                    'C' => 'Kopi hitam',
                    'D' => 'Minuman bersoda'
                ],
                'jawaban_benar' => 'A',
                'kategori' => 'Anemia',
                'penjelasan' => 'Vitamin C membantu meningkatkan penyerapan zat besi non-heme dari makanan nabati seperti tempe, kacang-kacangan, dan sayuran hijau.',
            ],
            [
                'pertanyaan' => 'Mengapa tren berat badan dari bulan ke bulan lebih penting daripada satu kali angka saja?',
                'pilihan' => [
                    'A' => 'Karena tren membantu melihat perlambatan pertumbuhan lebih awal',
                    'B' => 'Karena satu kali angka selalu salah',
                    'C' => 'Karena umur anak tidak penting',
                    'D' => 'Karena tinggi badan tidak perlu dicatat'
                ],
                'jawaban_benar' => 'A',
                'kategori' => 'Posyandu',
                'penjelasan' => 'Tren membantu mendeteksi growth faltering, misalnya berat badan tidak naik atau menurun sebelum masalah menjadi lebih berat.',
            ],
            [
                'pertanyaan' => 'Apa risiko utama bila anak usia 6-23 bulan hanya makan bubur encer tanpa lauk?',
                'pilihan' => [
                    'A' => 'Asupan energi dan zat gizi penting tidak cukup',
                    'B' => 'Anak pasti lebih cepat tinggi',
                    'C' => 'Tidak ada risiko sama sekali',
                    'D' => 'Anak tidak memerlukan ASI'
                ],
                'jawaban_benar' => 'A',
                'kategori' => 'MPASI',
                'penjelasan' => 'Bubur encer biasanya rendah energi dan zat gizi. Anak membutuhkan makanan padat gizi dengan protein, lemak sehat, vitamin, dan mineral.',
            ],
            [
                'pertanyaan' => 'Pada anak yang sakit, pendekatan makan yang lebih tepat adalah...',
                'pilihan' => [
                    'A' => 'Menghentikan makan sampai sembuh total',
                    'B' => 'Memberi porsi kecil lebih sering dan lanjutkan ASI bila masih menyusu',
                    'C' => 'Memberikan minuman manis sebagai pengganti semua makanan',
                    'D' => 'Memaksa makan sangat banyak sekali waktu'
                ],
                'jawaban_benar' => 'B',
                'kategori' => 'Gizi Balita',
                'penjelasan' => 'Saat sakit, anak sering sulit makan. Porsi kecil lebih sering, cairan cukup, dan ASI tetap dilanjutkan dapat membantu menjaga asupan.',
            ],
            [
                'pertanyaan' => 'Triple burden of malnutrition mencakup...',
                'pilihan' => [
                    'A' => 'Stunting/wasting, defisiensi mikronutrien, dan gizi lebih',
                    'B' => 'Hanya stunting',
                    'C' => 'Hanya obesitas pada dewasa',
                    'D' => 'Hanya kurang minum air'
                ],
                'jawaban_benar' => 'A',
                'kategori' => 'Triple Burden',
                'penjelasan' => 'UNICEF Indonesia menjelaskan tiga beban malnutrisi mencakup undernutrition, kekurangan mikronutrien seperti anemia, dan overweight/obesity.',
            ],
            [
                'pertanyaan' => 'Mengapa ibu hamil perlu memperhatikan anemia?',
                'pilihan' => [
                    'A' => 'Karena anemia dapat meningkatkan risiko bayi lahir berat rendah',
                    'B' => 'Karena anemia selalu membuat bayi obesitas',
                    'C' => 'Karena zat besi tidak dibutuhkan selama hamil',
                    'D' => 'Karena ibu hamil tidak perlu makan beragam'
                ],
                'jawaban_benar' => 'A',
                'kategori' => 'Kehamilan',
                'penjelasan' => 'Anemia pada ibu hamil berkaitan dengan risiko kesehatan ibu dan bayi, termasuk risiko bayi lahir dengan berat badan rendah.',
            ],
            [
                'pertanyaan' => 'Kelompok pangan apa yang sering penting untuk memenuhi zat besi, zinc, protein, dan vitamin B12 pada balita?',
                'pilihan' => [
                    'A' => 'Protein hewani seperti ikan, telur, ayam, daging, dan hati',
                    'B' => 'Gula pasir',
                    'C' => 'Sirup',
                    'D' => 'Kerupuk'
                ],
                'jawaban_benar' => 'A',
                'kategori' => 'Keragaman Pangan',
                'penjelasan' => 'Protein hewani adalah sumber padat gizi yang membantu memenuhi zat gizi penting untuk pertumbuhan dan perkembangan anak.',
            ],
            [
                'pertanyaan' => 'Apa tujuan utama edukasi gizi di posyandu setelah hasil pengukuran ditemukan bermasalah?',
                'pilihan' => [
                    'A' => 'Memberi arahan makan dan tindak lanjut sesuai masalah anak',
                    'B' => 'Menyalahkan keluarga',
                    'C' => 'Menghapus data anak',
                    'D' => 'Menghentikan kunjungan berikutnya'
                ],
                'jawaban_benar' => 'A',
                'kategori' => 'Posyandu',
                'penjelasan' => 'Edukasi harus membantu keluarga memahami masalah, memperbaiki praktik makan, dan mengikuti rujukan atau pemantauan ulang bila diperlukan.',
            ],
            [
                'pertanyaan' => 'Apa yang paling tepat dilakukan bila hasil ukur anak tampak tidak masuk akal?',
                'pilihan' => [
                    'A' => 'Langsung menyimpulkan anak stunting tanpa cek ulang',
                    'B' => 'Mengukur ulang dengan alat dan posisi yang benar',
                    'C' => 'Menghapus seluruh riwayat',
                    'D' => 'Mengabaikan data selamanya'
                ],
                'jawaban_benar' => 'B',
                'kategori' => 'Standar UNICEF-WHO',
                'penjelasan' => 'Kesalahan ukur dapat terjadi. Data yang tampak tidak masuk akal harus diverifikasi dengan pengukuran ulang sebelum dibuat keputusan.',
            ],
        ];

        $legacyQuiz = Quiz::where('pertanyaan', 'Manakah yang BUKAN termasuk komponen 4 Sehat 5 Sempurna?')->first();

        if ($legacyQuiz) {
            $legacyQuiz->fill([
                'pertanyaan' => 'Manakah yang TIDAK termasuk prinsip Pedoman Gizi Seimbang?',
                'pilihan' => [
                    'A' => 'Makan beragam',
                    'B' => 'Membiasakan hidup bersih',
                    'C' => 'Melakukan aktivitas fisik',
                    'D' => 'Minum minuman bersoda setiap hari',
                ],
                'jawaban_benar' => 'D',
                'kategori' => 'Gizi Dasar',
                'penjelasan' => 'Pedoman Gizi Seimbang menekankan makan beragam, perilaku hidup bersih, aktivitas fisik, dan pemantauan berat badan. Minuman bersoda tinggi gula perlu dibatasi.',
            ])->save();
        }

        foreach ($soal as $item) {
            Quiz::updateOrCreate(
                ['pertanyaan' => $item['pertanyaan']],
                $item
            );
        }
    }
}
