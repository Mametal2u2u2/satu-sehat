<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'title'   => 'Cara Menjaga Tekanan Darah Tetap Normal',
                'content' => 'Tekanan darah normal adalah 120/80 mmHg. Untuk menjaganya, batasi konsumsi garam, lakukan olahraga rutin 30 menit per hari, hindari stres, dan konsumsi makanan kaya kalium seperti pisang dan alpukat. Periksa tekanan darah secara rutin minimal satu bulan sekali.',
            ],
            [
                'title'   => 'Pentingnya Imunisasi untuk Anak',
                'content' => 'Imunisasi melindungi anak dari penyakit berbahaya seperti polio, campak, dan difteri. Sesuai jadwal dari Kemenkes RI, vaksin dasar wajib diberikan sejak bayi baru lahir hingga usia 18 bulan. Pastikan anak Anda mendapatkan imunisasi lengkap di Puskesmas atau klinik terdekat.',
            ],
            [
                'title'   => 'Tips Hidup Sehat dengan Diabetes',
                'content' => 'Penderita diabetes perlu memonitor kadar gula darah secara rutin. Batasi karbohidrat sederhana, pilih serat tinggi, dan jaga pola makan teratur. Olahraga ringan seperti jalan kaki 30 menit setiap hari sangat direkomendasikan. Jangan lewatkan kontrol ke dokter setiap bulan.',
            ],
            [
                'title'   => 'Mengenal Gejala Awal Stroke dan Pertolongan Pertama',
                'content' => 'Gunakan metode FAST: Face drooping (wajah mencong), Arm weakness (lengan lemah), Speech difficulty (bicara pelo), Time to call 119 (segera hubungi darurat). Stroke adalah kondisi darurat medis. Setiap menit sangat berharga — semakin cepat ditangani semakin baik prognosis pasien.',
            ],
            [
                'title'   => 'Panduan Cuci Tangan yang Benar Menurut WHO',
                'content' => 'Cuci tangan 6 langkah WHO efektif membunuh 99% kuman penyakit. Langkah: (1) Basahi tangan, (2) Sabuni, (3) Gosok telapak, (4) Gosok punggung tangan, (5) Gosok sela-sela jari, (6) Gosok ibu jari, (7) Bilas dan keringkan. Lakukan sebelum makan, setelah toilet, dan setelah menyentuh benda publik.',
            ],
        ];

        foreach ($articles as $article) {
            Article::create([
                'title'        => $article['title'],
                'slug'         => Str::slug($article['title']),
                'content'      => $article['content'],
                'is_published' => true,
            ]);
        }
    }
}
