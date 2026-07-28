<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil user admin sebagai author
        $admin = User::where('email', 'admin@gmail.com')->first();
        $userId = $admin ? $admin->id : 1;

        $articles = [
            [
                'title'    => 'Fakta Inflasi Global & Dampak Logistik ASEAN 2026',
                'content'  => "• Inflasi Rata-rata ASEAN: 4.2% (melewati target bank sentral 3.0%).\n• Tarif Kargo Kontainer: Naik 15% - 20% secara Year-on-Year (YoY).\n• Kenaikan Harga Bahan Baku: Baja (+12%), Aluminium (+8%), dan Semikonduktor (+15%).\n• Sektor Paling Terdampak: Otomotif, Manufaktur Elektronik, dan Tekstil.\n• Catatan Ringkas: Tekanan biaya logistik diperkirakan bertahan hingga akhir Kuartal III.",
                'category' => 'Ekonomi',
            ],
            [
                'title'    => 'Fakta Dampak Risiko Cuaca Ekstrem Pelabuhan Dunia',
                'content'  => "• Port of Shanghai (China): Penutupan operasional 12 hari akibat badai topan.\n• Port of Singapore: Keterlambatan bongkar muat meningkat rata-rata 2 hari.\n• Pelabuhan Tanjung Priok (Indonesia): Terkendala banjir rob pada area terminal kontainer.\n• Probabilitas Gangguan: Naik hingga 60% untuk rute maritim Pasifik Barat.\n• Rekomendasi Ringkas: Pengalihan rute alternatif dan penambahan stok cadangan komoditas.",
                'category' => 'Risiko Cuaca',
            ],
            [
                'title'    => 'Fakta Perbandingan Logistik & PDB: Jerman vs Jepang',
                'content'  => "• PDB & Ranking LPI Jerman: $4.07 Triliun | Ranking LPI Global #1 | Inflasi 2.3%.\n• PDB & Ranking LPI Jepang: $4.23 Triliun | Ranking LPI Global #5 | Inflasi 2.8%.\n• Keunggulan Jerman: Konektivitas jaringan darat EU yang terintegrasi dan stabilitas Euro.\n• Keunggulan Jepang: Efisiensi tinggi sistem Just-In-Time (JIT), namun tertekan volatilitas Yen.",
                'category' => 'Analisis Komparatif',
            ],
            [
                'title'    => 'Fakta Peran Strategis & Keamanan Selat Malaka',
                'content'  => "• Volume Perdagangan: 25% - 30% kargo maritim dunia melewati Selat Malaka.\n• Pelabuhan Singapura: Hub transshipment #1 dunia (>37 juta TEU/tahun).\n• Pelabuhan Klang (Malaysia): Alternatif kompetitif dengan pertumbuhan volume +8.5% YoY.\n• Keamanan Maritime: Angka insiden pembajakan turun 40% dalam dekade terakhir.",
                'category' => 'Geopolitik',
            ],
            [
                'title'    => 'Fakta Otomasi & Smart Port Pelabuhan 2026',
                'content'  => "• Port of Rotterdam: Implementasi sistem Digital Twin & pemantauan sensor IoT 100%.\n• Port of Shanghai (Yangshan): Operasional terminal kontainer fully automated 24 jam.\n• Tanjung Pelepas (Malaysia): Penggunaan algoritma AI untuk penjadwalan sandar kapal.\n• Pertumbuhan Investasi: Pasar pelabuhan pintar tumbuh dengan tingkat CAGR 18%.",
                'category' => 'Teknologi',
            ],
            [
                'title'    => 'Fakta Pembaruan Kurs & Valuta Asing Global',
                'content'  => "• IDR (Rupiah Indonesia): Pergerakan stabil pada rentang Rp15.800 - Rp16.000 per USD.\n• CNY (Yuan China): Tertekan di level 7.25 per USD akibat penyesuaian industri manufaktur.\n• EUR (Euro): Menguat moderat di 0.92 per USD pasca kebijakan suku bunga ECB.\n• JPY (Yen Jepang): Berada di kisaran 157.50 per USD.",
                'category' => 'Mata Uang',
            ],
            [
                'title'    => 'Fakta Metodologi Risk Score Rantai Pasok',
                'content'  => "• Komponen Bobot Risk Score: Cuaca (30%), Inflasi (20%), Kurs (10%), Sentimen Berita (40%).\n• Skala Risiko: 0-33 (Risiko Rendah / Hijau), 34-66 (Sedang / Kuning), 67-100 (Tinggi / Merah).\n• Update Data: Otomatis diperbarui setiap 5 menit dari sumber API terverifikasi.\n• Akurasi Historis: Mengukur korelasi hingga 72% dengan kondisi riil lapangan.",
                'category' => 'Metodologi',
            ],
            [
                'title'    => 'Fakta Ekspor Komoditas Utama Australia',
                'content'  => "• Indikator Utama Australia: PDB $1.67 Triliun | Inflasi 3.6% | Kurs 1.53 AUD/USD.\n• Komoditas Utama Ekspor: Bijih Besi, Batu Bara, dan Gas Alam Cair (LNG).\n• Tujuan Ekspor Dominan: 35% total volume ekspor ditujukan ke kawasan East Asia.\n• Waktu Transit Laut: Rata-rata 5 - 10 hari pengiriman menuju pelabuhan utama Asia.",
                'category' => 'Negara',
            ],
        ];

        foreach ($articles as $article) {
            Article::updateOrCreate(
                ['title' => $article['title']],
                [
                    'user_id'    => $userId,
                    'content'    => $article['content'],
                    'category'   => $article['category'],
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
