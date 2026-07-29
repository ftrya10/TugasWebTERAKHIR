<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        Article::query()->delete();

        $admin = User::where('email', 'admin@gmail.com')->first();
        $userId = $admin ? $admin->id : 1;

        $articles = [
            [
                'title'    => 'Indonesia: Analisis Ekspor Nikel, CPO & Kinerja Pelabuhan Tanjung Priok 2026',
                'content'  => "• PDB & Inflasi Indonesia: PDB $1,32 Triliun | Inflasi 2,84% | Kurs Rp15.890 / USD.\n• Komoditas Ekspor Unggulan: Nikel, CPO (Kelapa Sawit), Produk Tekstil, dan Batubara.\n• Kinerja Pelabuhan Utama: Pelabuhan Tanjung Priok mengendalikan >60% lalu lintas kontainer ekspor-impor nasional.\n• Tantangan Logistik: Gelombang cuaca monsun dan penumpukan sementara pada terminal kontainer.\n• Rekomendasi Intelijen: Perluasan jadwal sandar serta otomatisasi sistem kepabeanan pelabuhan.",
                'category' => 'Negara',
            ],
            [
                'title'    => 'China: Evaluasi Industri Manufaktur Global & Otomasi Pelabuhan Shanghai',
                'content'  => "• PDB & Industri China: PDB $17,73 Triliun | Inflasi 0,20% | Kurs 7.25 CNY / USD.\n• Inovasi Smart Port: Port of Shanghai & Ningbo mengimplementasikan terminal kontainer fully automated 24 jam.\n• Rantai Pasok Elektronik: Menjadi hub pasokan komoditas komponen semikonduktor utama dunia.\n• Tantangan Perdagangan: Penyesuaian kuota kargo udara dan maritim di tengah ketidakpastian pasar global.",
                'category' => 'Negara',
            ],
            [
                'title'    => 'Jerman: Jaringan Logistik EU & Analisis Efisiensi Manufaktur Otomotif',
                'content'  => "• PDB & Inflasi Jerman: PDB $4,07 Triliun | Inflasi 2,30% | Kurs €0,92 / USD.\n• Keunggulan Infrastruktur: Jaringan kereta kargo dan tol terintegrasi tertinggi di kawasan Eropa (#1 LPI).\n• Sektor Otomotif: Tekanan biaya energi mendorong efisiensi rantai pasok bahan baku baja & baterai EV.\n• Outlook Logistik: Stabilitas mata uang Euro mendukung daya saing perdagangan internasional.",
                'category' => 'Negara',
            ],
            [
                'title'    => 'Australia: Kinerja Ekspor Komoditas Tambang Bijih Besi & LNG Ke Asia',
                'content'  => "• Indikator Ekonomi Australia: PDB $1,68 Triliun | Inflasi 3,60% | Kurs A$1,53 / USD.\n• Komoditas Utama: Bijih Besi, Gas Alam Cair (LNG), dan Produk Pertanian (Gandum & Daging).\n• Rute Logistik Maritim: Waktu transit pengiriman laut 5–10 hari menuju pelabuhan Asia Pasifik.\n• Faktor Risiko: Potensi gangguan badai tropis di perairan barat Australia pada musim tertentu.",
                'category' => 'Negara',
            ],
            [
                'title'    => 'Amerika Serikat: Tren PDB Sektor Teknologi & Efisiensi Pelabuhan Pantai Barat',
                'content'  => "• Ekonomi & Pasar AS: PDB $25,46 Triliun | Inflasi 3,40% | Kurs $1,00 USD.\n• Hub Logistik Utama: Pelabuhan Los Angeles & Long Beach memproses volume kontainer impor terbesar.\n• Sektor Pendorong: Ekspor produk semikonduktor, perangkat lunak, dan komoditas energi cair.\n• Kebijakan Moneter: Evaluasi suku bunga Federal Reserve menjaga kestabilan transaksi ekspor-impor.",
                'category' => 'Negara',
            ],
            [
                'title'    => 'Jepang: Sistem Just-In-Time (JIT) Pelabuhan Tokyo & Stabilitas Yen',
                'content'  => "• Ekonomi Jepang: PDB $4,23 Triliun | Inflasi 2,80% | Kurs ¥157.50 / USD.\n• Sistem Logistik Presisi: Pelabuhan Tokyo & Yokohama menerapkan jadwal bongkar muat berbasis AI (JIT).\n• Sektor Ekspor: Mesin presisi, otomotif, dan komponen elektronik berteknologi tinggi.\n• Pengaruh Kurs: Volatilitas Yen mempengaruhi margin biaya impor bahan mentah industri.",
                'category' => 'Negara',
            ],
            [
                'title'    => 'Singapura: Peran Transshipment Hub #1 Dunia & Integrasi Digital Twin Port',
                'content'  => "• Kinerja Singapura: PDB $466 Miliar | Inflasi 3,00% | Kurs S$1,35 / USD.\n• Kapasitas Pelabuhan: Mengendalikan lebih dari 37 juta TEUs kontainer per tahun sebagai hub global.\n• Teknologi Digital: Monitoring kapal waktu-nyata (Real-time IoT) mengurangi waktu tunggu hingga 30%.\n• Peran Geopolitik: Menjadi pintu gerbang utama lalu lintas maritim Selat Malaka.",
                'category' => 'Negara',
            ],
            [
                'title'    => 'United Kingdom: Koridor Perdagangan Pasca-Brexit & Kargo Pelabuhan London',
                'content'  => "• Profil Ekonomi Inggris: PDB $3,07 Triliun | Inflasi 4,00% | Kurs £0,79 / USD.\n• Pelabuhan Utama: Pelabuhan London & Felixstowe memegang peranan kunci impor bahan baku.\n• Perjanjian Dagang: Pembentukan kemitraan bilateral baru meningkatkan volume kargo jasa & barang.\n• Catatan Risiko: Fluktuasi tarif distribusi kontainer regional menjadi perhatian pengusaha.",
                'category' => 'Negara',
            ],
            [
                'title'    => 'India: Pertumbuhan Manufaktur Farmasi & Modernisasi Pelabuhan Mumbai',
                'content'  => "• Ekonomi India: PDB $3,39 Triliun | Inflasi 5,10% | Kurs ₹83.50 / USD.\n• Pertumbuhan Ekspor: Produk farmasi dan tekstil India mencatat rekor lonjakan di pasar global.\n• Proyek Infrastruktur: Modernisasi Pelabuhan Jawaharlal Nehru (Mumbai) tingkatkan arus logistik.\n• Risiko Inflasi: Tekanan inflasi bahan pangan domestik mempengaruhi biaya operasional darat.",
                'category' => 'Negara',
            ],
            [
                'title'    => 'Malaysia: Eksosistem Semikonduktor & Otomasi AI Pelabuhan Tanjung Pelepas',
                'content'  => "• Profil Malaysia: PDB $415 Miliar | Inflasi 2,50% | Kurs RM4,72 / USD.\n• Industri Unggulan: Perakitan semikonduktor, komponen elektronik, dan turunan minyak sawit.\n• Pelabuhan Pintar: Pelabuhan Tanjung Pelepas memanfaatkan kecerdasan buatan (AI) untuk alokasi sandar kapal.\n• Integrasi ASEAN: Menjadi mitra logistik strategis dalam rantai pasok Asia Tenggara.",
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
                    'created_at' => now()->subDays(rand(1, 20)),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
