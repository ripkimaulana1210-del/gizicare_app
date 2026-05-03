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
                'pertanyaan' => 'Manakah yang BUKAN termasuk komponen 4 Sehat 5 Sempurna?',
                'pilihan' => [
                    'A' => 'Nasi dan umbi-umbian',
                    'B' => 'Lauk pauk',
                    'C' => 'Sayur-sayuran',
                    'D' => 'Minuman bersoda'
                ],
                'jawaban_benar' => 'D',
                'kategori' => 'Gizi Dasar',
                'penjelasan' => '4 Sehat 5 Sempurna terdiri dari: nasi/umbi-umbian, lauk pauk, sayur-sayuran, buah-buahan, dan susu. Minuman bersoda justru harus dibatasi karena tinggi gula.',
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
        ];

        foreach ($soal as $item) {
            Quiz::create($item);
        }
    }
}

