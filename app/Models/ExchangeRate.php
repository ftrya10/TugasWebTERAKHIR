<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    protected $fillable = [
        'country_id',
        'currency',
        'rate',
        'exchange_score',
    ];

    protected $casts = [
        'rate' => 'float',
        'exchange_score' => 'float',
    ];

    /**
     * Relasi nilai tukar dengan negara.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Mengecek apakah risiko nilai tukar tinggi.
     */
    public function isHighRisk()
    {
        return $this->exchange_score >= 70;
    }

    /**
     * Mengecek apakah risiko nilai tukar sedang.
     */
    public function isMediumRisk()
    {
        return $this->exchange_score >= 40
            && $this->exchange_score < 70;
    }

    /**
     * Mendapatkan kategori risiko nilai tukar.
     */
    public function getRiskLevelAttribute()
    {
        $score = (float) ($this->exchange_score ?? 0);

        if ($score >= 70) {
            return 'High';
        }

        if ($score >= 40) {
            return 'Medium';
        }

        return 'Low';
    }
}