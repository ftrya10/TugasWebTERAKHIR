<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $newsByCountry = [
            'ID' => [
                [
                    'title' => 'Indonesia: Pertumbuhan Ekspor Nikel & CPO Meningkat 8,4%',
                    'content' => 'Permintaan komoditas ekspor utama Indonesia seperti Nikel dan CPO menunjukkan tren positif di pasar Asia Pasifik.',
                    'sentiment' => 'Positive',
                    'score' => 15,
                    'source' => 'Bisnis Logistik Indonesia',
                ],
                [
                    'title' => 'Indonesia: Kepadatan Pelabuhan Tanjung Priok Terkendala Cuaca Buruk & Rob',
                    'content' => 'Terminal kontainer Pelabuhan Tanjung Priok mengalami sedikit keterlambatan waktu bongkar muat kapal akibat curah hujan tinggi.',
                    'sentiment' => 'Negative',
                    'score' => 80,
                    'source' => 'Antara News',
                ],
                [
                    'title' => 'Indonesia: Pergerakan Nilai Tukar Rupiah Terhadap Dolar AS Stabil di Rp15.890',
                    'content: 'Bank Indonesia melaporkan kestabilan cadangan devisa dan pergerakan mata uang domestik yang relatif terjaga.',
                    'sentiment' => 'Neutral',
                    'score' => 45,
                    'source' => 'Kontan',
                ],
            ],
            'CN' => [
                [
                    'title' => 'China: Pelabuhan Shanghai & Ningbo Operasikan Terminal Kontainer Otomatis 24 Jam',
                    'content' => 'Otomasi penuh pada terminal kontainer Yangshan meningkatkan kecepatan arus transit kargo impor-ekspor.',
                    'sentiment' => 'Positive',
                    'score' => 15,
                    'source' => 'Xinhua Trade',
                ],
                [
                    'title' => 'China: Perlambatan Pengiriman Kargo Komoditas Impor di Kawasan Industri Timur',
                    'content' => 'Penyesuaian rantai pasok manufaktur menyebabkan penumpukan singkat kontainer kargo di beberapa titik pelabuhan.',
                    'sentiment' => 'Negative',
                    'score' => 75,
                    'source' => 'Global Times',
                ],
                [
                    'title' => 'China: Pemerintah Rilis Paket Kebijakan Stimulus Perdagangan Manufaktur Global',
                    'content' => 'Kebijakan baru ditujukan untuk mendorong insentif efisiensi pengiriman komoditas ekspor elektronik.',
                    'sentiment' => 'Neutral',
                    'score' => 40,
                    'source' => 'China Daily',
                ],
            ],
            'DE' => [
                [
                    'title' => 'Jerman: Jalur Distribusi Logistik Darat Eropa Membaik Pasca Pembaruan Rel Kereta',
                    'content' => 'Konektivitas jaringan transportasi barang darat Jerman yang terintegrasi mempermudah arus kargo antarnegara EU.',
                    'sentiment' => 'Positive',
                    'score' => 15,
                    'source' => 'Deutsche Welle',
                ],
                [
                    'title' => 'Jerman: Kenaikan Biaya Energi Tekan Industri Manufaktur Otomotif Domestik',
                    'content' => 'Produsen kendaraan otomotif Jerman menyesuaikan jadwal rilis komoditas ekspor akibat tingginya biaya produksi.',
                    'sentiment' => 'Negative',
                    'score' => 75,
                    'source' => 'Handelsblatt',
                ],
                [
                    'title' => 'Jerman: Laju Inflasi Melandai ke Level 2.3% Memperkuat Stabilitas Euro',
                    'content' => 'Bank Sentral Eropa (ECB) mencatat stabilitas harga bahan pokok dan penguatan moderat mata uang Euro.',
                    'sentiment' => 'Neutral',
                    'score' => 40,
                    'source' => 'Frankfurter Allgemeine',
                ],
            ],
            'AU' => [
                [
                    'title' => 'Australia: Permintaan Ekspor Bijih Besi & Gas Alam Cair (LNG) ke Asia Melonjak',
                    'content' => 'Volume pengiriman bijih besi Australia menuju negara mitra Asia Timur mencatat rekor tertinggi kuartal ini.',
                    'sentiment' => 'Positive',
                    'score' => 15,
                    'source' => 'Australian Financial Review',
                ],
                [
                    'title' => 'Australia: Badai Tropis Di Kawasan Barat Ganggu Sandar Kapal Kargo Pelabuhan',
                    'content' => 'Peringatan cuaca ekstrem memaksa penundaan keberangkatan beberapa kapal tanker komoditas energi.',
                    'sentiment' => 'Negative',
                    'score' => 70,
                    'source' => 'ABC News Australia',
                ],
                [
                    'title' => 'Australia: Dolar Australia Bergerak Stabil Didorong Tren Harga Komoditas Global',
                    'content' => 'Sektor pertambangan memberikan dorongan positif pada neraca perdagangan komoditas Australia.',
                    'sentiment' => 'Neutral',
                    'score' => 45,
                    'source' => 'Sydney Morning Herald',
                ],
            ],
            'US' => [
                [
                    'title' => 'Amerika Serikat: Pertumbuhan PDB Stabil Didorong Tingginya Ekspor Sektor Teknologi',
                    'content' => 'Laporan ekonomi kuartalan menunjukkan ekspor perangkat semikonduktor dan produk digital AS tetap tinggi.',
                    'sentiment' => 'Positive',
                    'score' => 15,
                    'source' => 'Wall Street Journal',
                ],
                [
                    'title' => 'Amerika Serikat: Kepadatan Pelabuhan Pantai Barat Pemicu Penundaan Kargo',
                    'content' => 'Lonjakan volume masuk kontainer menyebabkan antrean kapal sandar di Pelabuhan Los Angeles.',
                    'sentiment' => 'Negative',
                    'score' => 70,
                    'source' => 'Bloomberg Logistics',
                ],
                [
                    'title' => 'Amerika Serikat: Federal Reserve Jaga Stabilitas Volatilitas Suku Bunga & Dolar',
                    'content' => 'Kebijakan moneter AS terus dipantau oleh pelaku pasar perdagangan internasional.',
                    'sentiment' => 'Neutral',
                    'score' => 40,
                    'source' => 'Reuters US',
                ],
            ],
            'JP' => [
                [
                    'title' => 'Jepang: Penerapan Sistem Smart Port Di Pelabuhan Tokyo Tingkatkan Efisiensi 25%',
                    'content' => 'Sistem Just-In-Time (JIT) terotomasi mempercepat durasi penanganan muatan kapal kargo di Tokyo Bay.',
                    'sentiment' => 'Positive',
                    'score' => 15,
                    'source' => 'Nikkei Asia',
                ],
                [
                    'title' => 'Jepang: Kenaikan Biaya Impor Logistik Bahan Baku Tekan Volatilitas Yen',
                    'content' => 'Pelemahan mata uang Yen berdampak pada kenaikan biaya logistik impor energi dan komoditas pangan.',
                    'sentiment' => 'Negative',
                    'score' => 70,
                    'source' => 'Japan Times',
                ],
                [
                    'title' => 'Jepang: Laporan Aktivitas Perdagangan Ekspor Otomotif & Mesin Presisi Stabil',
                    'content' => 'Sektor manufaktur utama Jepang mencatatkan volume pengiriman ekspor yang terjaga.',
                    'sentiment' => 'Neutral',
                    'score' => 45,
                    'source' => 'Asahi Shimbun',
                ],
            ],
            'SG' => [
                [
                    'title' => 'Singapura: Pelabuhan Singapura Pertahankan Gelar Hub Transshipment Terbesar Dunia',
                    'content' => 'Volume bongkar muat kontainer Singapura melampaui 37 juta TEUs didukung infrastruktur canggih.',
                    'sentiment' => 'Positive',
                    'score' => 15,
                    'source' => 'Straits Times',
                ],
                [
                    'title' => 'Singapura: Cuaca Hujan Deras Berpotensi Hambat Operasional Bongkar Muat Sementara',
                    'content' => 'Otoritas pelabuhan memberlakukan prosedur keselamatan ketat selama cuaca monsun.',
                    'sentiment' => 'Negative',
                    'score' => 65,
                    'source' => 'Channel NewsAsia',
                ],
                [
                    'title' => 'Singapura: Kebijakan Perdagangan Bebas ASEAN Perluas Akses Pasar Logistik Regional',
                    'content' => 'Konektivitas maritim Singapura semakin memperkuat koridor perdagangan antarnegara Asia Tenggara.',
                    'sentiment' => 'Neutral',
                    'score' => 40,
                    'source' => 'Business Times SG',
                ],
            ],
            'GB' => [
                [
                    'title' => 'United Kingdom: Perjanjian Perdagangan Bebas Baru Perluas Akses Ekspor Inggris',
                    'content' => 'Pemerintah Inggris meresmikan aliansi perdagangan baru untuk mendorong ekspor jasa dan produk manufaktur.',
                    'sentiment' => 'Positive',
                    'score' => 15,
                    'source' => 'BBC Business',
                ],
                [
                    'title' => 'United Kingdom: Kenaikan Tarif Logistik Maritim Sebabkan Fluktuasi Harga Komoditas',
                    'content' => 'Pengiriman barang impor ke Pelabuhan Felixstowe mengalami peningkatan biaya kargo kontainer.',
                    'sentiment' => 'Negative',
                    'score' => 70,
                    'source' => 'The Financial Times',
                ],
                [
                    'title' => 'United Kingdom: Bank of England Pertahankan Tingkat Suku Bunga & Stabilitas GBP',
                    'content' => 'Laju inflasi domestik yang melandai memberikan sinyal positif bagi pertumbuhan sektor logistik.',
                    'sentiment' => 'Neutral',
                    'score' => 40,
                    'source' => 'The Guardian Trade',
                ],
            ],
            'IN' => [
                [
                    'title' => 'India: Sektor Manufaktur Farmasi & Tekstil Catat Rekor Kenaikan Ekspor',
                    'content' => 'Volume pengiriman produk farmasi India ke Amerika Serikat dan Eropa mengalami peningkatan signifikan.',
                    'sentiment' => 'Positive',
                    'score' => 15,
                    'source' => 'The Economic Times India',
                ],
                [
                    'title' => 'India: Tingkat Inflasi Komoditas Pangan 5.1% Pemicu Tantangan Logistik Domestik',
                    'content' => 'Kenaikan harga barang kebutuhan pokok berdampak pada biaya distribusi jalur darat dan rel.',
                    'sentiment' => 'Negative',
                    'score' => 80,
                    'source' => 'Times of India',
                ],
                [
                    'title' => 'India: Modernisasi Pelabuhan Mumbai Tingkatkan Kapasitas Kontainer Ekspor',
                    'content' => 'Proyek otomatisasi gerbang kontainer pelabuhan membantu mempercepat proses beacukai.',
                    'sentiment' => 'Neutral',
                    'score' => 45,
                    'source' => 'Business Standard',
                ],
            ],
            'MY' => [
                [
                    'title' => 'Malaysia: Ekspor Produk Semikonduktor & Sawit Tumbuh Positif di Kawasan ASEAN',
                    'content' => 'Permintaan komoditas elektronik dan olahan kelapa sawit Malaysia mencatat pertumbuhan stabil.',
                    'sentiment' => 'Positive',
                    'score' => 15,
                    'source' => 'The Star Malaysia',
                ],
                [
                    'title' => 'Malaysia: Cuaca Muson Barat Daya Berdampak Pada Jadwal Sandar Kapal Kargo',
                    'content' => 'Gelombang tinggi di Selat Malaka menyebabkan beberapa kapal kargo menunda waktu sandar.',
                    'sentiment' => 'Negative',
                    'score' => 70,
                    'source' => 'New Straits Times',
                ],
                [
                    'title' => 'Malaysia: Pelabuhan Tanjung Pelepas Gunakan AI Untuk Penjadwalan Kontainer',
                    'content' => 'Teknologi penjadwalan cerdas berhasil mengurangi waktu tunggu kapal hingga 18%.',
                    'sentiment' => 'Neutral',
                    'score' => 40,
                    'source' => 'Bernama Trade',
                ],
            ],
        ];

        foreach (Country::all() as $country) {
            $items = $newsByCountry[$country->code] ?? [];
            foreach ($items as $item) {
                News::updateOrCreate(
                    [
                        'country_id' => $country->id,
                        'title' => $item['title'],
                    ],
                    [
                        'content' => $item['content'],
                        'sentiment' => $item['sentiment'],
                        'news_score' => $item['score'],
                        'source' => $item['source'],
                        'created_at' => now()->subHours(rand(1, 48)),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}