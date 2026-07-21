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
                'title'    => 'Dampak Kenaikan Inflasi Global terhadap Rantai Pasok Asia Tenggara',
                'content'  => "Inflasi global yang terus meningkat sepanjang tahun 2025-2026 memberikan tekanan signifikan terhadap biaya logistik dan rantai pasok di kawasan Asia Tenggara. Indonesia, sebagai ekonomi terbesar di ASEAN, menghadapi tantangan khusus akibat melemahnya daya beli dan meningkatnya biaya bahan baku impor.\n\nMenurut data World Bank, rata-rata inflasi di kawasan ini mencapai 4.2%, lebih tinggi dari target bank sentral regional sebesar 3%. Hal ini berdampak langsung pada:\n\n1. **Biaya Pengiriman**: Tarif kargo container meningkat 15-20% YoY\n2. **Harga Bahan Baku**: Baja, aluminium, dan semikonduktor mengalami kenaikan harga\n3. **Tenaga Kerja**: Upah minimum di sektor manufaktur naik di beberapa negara\n\nDampak ini dirasakan paling besar oleh industri otomotif, elektronik, dan tekstil yang sangat bergantung pada rantai pasok global.",
                'category' => 'Ekonomi',
            ],
            [
                'title'    => 'Analisis Risiko Cuaca Ekstrem pada Pelabuhan Utama Dunia 2026',
                'content'  => "Perubahan iklim semakin mempengaruhi operasional pelabuhan-pelabuhan strategis di dunia. Musim badai yang semakin intens di Pasifik Barat dan peningkatan suhu air laut telah menyebabkan gangguan signifikan pada jadwal pengiriman global.\n\nPelabuhan-pelabuhan yang paling terdampak meliputi:\n\n- **Port of Shanghai** (China): Mengalami 12 hari penutupan akibat topan musim panas\n- **Port of Singapore**: Peningkatan delay rata-rata 2 hari akibat cuaca buruk\n- **Tanjung Priok** (Indonesia): Banjir rob menyebabkan kemacetan kontainer\n\nRisk scoring model kami menunjukkan bahwa negara-negara dengan weather_score di atas 7 memiliki probabilitas 60% lebih tinggi untuk mengalami gangguan rantai pasok dalam 6 bulan ke depan. Rekomendasi: diversifikasi rute pengiriman dan peningkatan buffer stock untuk komoditas kritis.",
                'category' => 'Risiko Cuaca',
            ],
            [
                'title'    => 'Perbandingan GDP dan Daya Saing Logistik: Jerman vs Jepang',
                'content'  => "Dua kekuatan ekonomi terbesar di benua mereka masing-masing — Jerman di Eropa dan Jepang di Asia — menunjukkan pola yang menarik dalam hal efisiensi rantai pasok.\n\n**Jerman (GDP: ~\$4.07 Triliun)**\n- Logistics Performance Index (LPI) Rank: #1 Global\n- Infrastruktur pelabuhan Hamburg dan Bremerhaven yang world-class\n- Inflasi: 2.3% — relatif stabil\n- Kekuatan: Konektivitas darat (autobahn, kereta api) dan standar EU yang terintegrasi\n\n**Jepang (GDP: ~\$4.23 Triliun)**\n- LPI Rank: #5 Global\n- Pelabuhan Yokohama dan Kobe sebagai hub utama\n- Inflasi: 2.8% — tekanan dari pelemahan Yen\n- Kekuatan: Just-In-Time manufacturing dan efisiensi operasional pelabuhan\n\nKesimpulan: Meskipun GDP Jepang sedikit lebih tinggi, Jerman unggul dalam hal infrastruktur logistik dan stabilitas mata uang. Bagi perusahaan yang mempertimbangkan sourcing dari kedua negara, faktor kurs JPY yang volatile perlu diperhatikan.",
                'category' => 'Analisis Komparatif',
            ],
            [
                'title'    => 'Peran Strategis Selat Malaka dalam Rantai Pasok Global',
                'content'  => "Selat Malaka tetap menjadi chokepoint paling kritis dalam perdagangan maritim global. Sekitar 25-30% perdagangan laut dunia melewati selat sempit yang menghubungkan Samudra Hindia dan Laut China Selatan ini.\n\nTiga negara yang berbatasan langsung — Indonesia, Malaysia, dan Singapura — memainkan peran sentral:\n\n- **Singapura**: Hub transshipment #1 dunia dengan throughput >37 juta TEU/tahun\n- **Malaysia (Port Klang)**: Alternatif yang semakin kompetitif dengan biaya lebih rendah\n- **Indonesia (Batam/Belawan)**: Potensi besar yang masih underutilized\n\nTantangan keamanan seperti pembajakan (meskipun menurun 40% dari dekade lalu) dan potensi konflik geopolitik di Laut China Selatan tetap menjadi risk factor utama. Model risk scoring kami menggabungkan news_score (sentimen berita) dengan data cuaca untuk memberikan early warning kepada pelaku logistik.",
                'category' => 'Geopolitik',
            ],
            [
                'title'    => 'Tren Digitalisasi Pelabuhan: Smart Port 2026 dan Dampaknya',
                'content'  => "Revolusi digital telah merambah industri pelabuhan secara masif. Konsep 'Smart Port' bukan lagi wacana futuristik, melainkan kebutuhan untuk tetap kompetitif di pasar global.\n\nContoh implementasi Smart Port terdepan:\n\n1. **Port of Rotterdam** (Belanda): Digital Twin seluruh area pelabuhan, IoT sensors pada crane dan conveyor\n2. **Port of Shanghai Yangshan** (China): Fully automated terminal tanpa operator manusia\n3. **Tanjung Pelepas** (Malaysia): AI-powered berth allocation dan predictive maintenance\n\nBagi 10 negara yang kami monitor, tingkat digitalisasi pelabuhan berkorelasi positif dengan GDP per capita dan berkorelasi negatif dengan risk score. Negara seperti Singapura (GDP per capita \$82,807) memiliki risk score yang lebih rendah dibandingkan India (GDP per capita \$2,389).\n\nInvestasi dalam teknologi pelabuhan diprediksi tumbuh 18% CAGR hingga 2028, didorong oleh kebutuhan efisiensi dan tekanan regulasi emisi karbon dari IMO.",
                'category' => 'Teknologi',
            ],
            [
                'title'    => 'Update Kurs Mata Uang: Rupiah Stabil, Yuan di Bawah Tekanan',
                'content'  => "Pasar valuta asing menunjukkan dinamika yang menarik di kuartal ini. Berikut analisis untuk mata uang utama negara yang kami pantau:\n\n**IDR (Rupiah Indonesia)**: Stabil di kisaran Rp15.800-16.000/USD, didukung oleh surplus perdagangan komoditas dan kebijakan BI yang hawkish.\n\n**CNY (Yuan China)**: Melemah ke level 7.25/USD, tertekan oleh perlambatan ekonomi domestik dan ketegangan perdagangan dengan AS.\n\n**EUR (Euro)**: Menguat moderat ke 0.92/USD setelah ECB menaikkan suku bunga.\n\n**JPY (Yen Jepang)**: Terus melemah ke 157.50/USD, BOJ tetap mempertahankan kebijakan ultra-longgar.\n\n**GBP (Poundsterling)**: Relatif stabil di 0.79/USD pasca-stabilisasi ekonomi UK.\n\nImplikasi untuk rantai pasok: Pelemahan Yuan menguntungkan importir dari China, namun meningkatkan risiko bagi perusahaan yang memiliki utang dalam USD. Kami merekomendasikan hedging bagi eksposur mata uang di atas \$1 juta.",
                'category' => 'Mata Uang',
            ],
            [
                'title'    => 'Indeks Risiko Rantai Pasok: Methodology dan Interpretasi',
                'content'  => "Platform GlobalTrade Insight menggunakan model Weighted Risk Scoring untuk mengevaluasi risiko rantai pasok setiap negara. Berikut penjelasan metodologi:\n\n**Komponen Risk Score:**\n- Weather Score (30%): Mengukur dampak cuaca terhadap operasional logistik\n- Inflation Score (20%): Sensitivitas biaya terhadap tekanan inflasi\n- Exchange Rate Score (10%): Volatilitas dan tren mata uang\n- News Score (40%): Sentimen berita politik, ekonomi, dan keamanan\n\n**Rumus:**\n```\nTotal Score = (W × 0.30) + (I × 0.20) + (E × 0.10) + (N × 0.40)\n```\n\n**Interpretasi:**\n- 0-33: LOW RISK (hijau) — Kondisi stabil, rantai pasok aman\n- 34-66: MEDIUM RISK (kuning) — Perlu monitoring intensif\n- 67-100: HIGH RISK (merah) — Rekomendasi: diversifikasi supplier dan rute\n\nModel ini diupdate setiap 5 menit menggunakan data real-time dari berbagai API (cuaca, kurs, berita). Akurasi back-testing model menunjukkan korelasi 72% dengan gangguan rantai pasok aktual dalam 6 bulan terakhir.",
                'category' => 'Metodologi',
            ],
            [
                'title'    => 'Australia: Hub Komoditas Strategis untuk Pasar Asia-Pasifik',
                'content'  => "Australia mempertahankan posisinya sebagai salah satu pemasok komoditas terpenting bagi negara-negara Asia. Dengan GDP \$1.67 triliun dan sektor pertambangan yang dominan, negara ini adalah sumber utama bijih besi, batu bara, dan gas alam.\n\n**Keunggulan Kompetitif:**\n- Proximity ke pasar Asia (waktu pengiriman 5-10 hari ke pelabuhan utama Asia)\n- Pelabuhan Port Hedland dan Newcastle berkapasitas besar\n- Regulasi perdagangan yang transparan dan stabil\n- Perjanjian FTA dengan China, Jepang, Korea, dan ASEAN\n\n**Tantangan:**\n- Jarak jauh ke pasar Eropa dan Amerika\n- Biaya tenaga kerja tinggi (upah minimum ~AUD 23.23/jam)\n- Ketergantungan pada pasar China (~35% ekspor)\n\nDengan AUD yang relatif stabil di 1.53/USD dan inflasi 3.6%, Australia menawarkan kombinasi risk-return yang menarik bagi importir komoditas mentah.",
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
