# Project Final UAS - GlobalTrade Insight

## Deskripsi
GlobalTrade Insight adalah aplikasi berbasis Laravel yang digunakan untuk menampilkan informasi perdagangan global dari beberapa negara. Sistem menyediakan informasi mengenai GDP, inflasi, populasi, mata uang, cuaca, serta analisis risiko (Risk Scoring) berdasarkan beberapa indikator.

## Fitur Utama

- Dashboard
- Global Country Dashboard
- Countries
- Trade Analysis
- Weather
- Exchange Rate
- Global News
- Port Map
- Risk Analysis
- Favorites

## Teknologi

- Laravel 12
- PHP 8.2
- MySQL
- Tailwind CSS
- Blade Template

## Instalasi

Clone repository

```bash
git clone https://github.com/ftrya10/project-final-uas-globaltrade-insight.git
```

Masuk ke folder project

```bash
cd project-final-uas-globaltrade-insight
```

Install dependency

```bash
composer install
npm install
```

Salin file environment

```bash
cp .env.example .env
```

Generate application key

```bash
php artisan key:generate
```

Atur koneksi database pada file `.env`.

Jalankan migrasi

```bash
php artisan migrate
```

Jalankan aplikasi

```bash
php artisan serve
```

## Login

Email:

```
admin@gmail.com
```

Password:

```
password
```

> Jika akun belum tersedia, jalankan seeder atau buat akun melalui halaman Register.

## Struktur Menu

- Dashboard
- Countries
- Trade Analysis
- Weather
- Exchange Rate
- Global News
- Port Map
- Risk Analysis
- Favorites

## Developer

Project Final UAS

Nama: **Fittriya**

Repository:
https://github.com/ftrya10/project-final-uas-globaltrade-insight
