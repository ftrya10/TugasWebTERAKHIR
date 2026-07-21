<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'country_id',
        'title',
        'sentiment',
        'news_score',
    ];

    protected $casts = [
        'news_score' => 'float',
    ];

    /**
     * Relasi berita dengan negara.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Mengecek apakah berita memiliki risiko tinggi.
     */
    public function isHighRisk()
    {
        return $this->news_score >= 70;
    }

    /**
     * Mengecek apakah berita memiliki risiko sedang.
     */
    public function isMediumRisk()
    {
        return $this->news_score >= 40
            && $this->news_score < 70;
    }

    /**
     * Mendapatkan kategori risiko berita.
     */
    public function getRiskLevelAttribute()
    {
        $score = (float) ($this->news_score ?? 0);

        if ($score >= 70) {
            return 'High';
        }

        if ($score >= 40) {
            return 'Medium';
        }

        return 'Low';
    }
}