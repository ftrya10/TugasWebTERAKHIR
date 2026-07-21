<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiskScore extends Model
{
    protected $fillable = [
        'country_id',
        'weather_score',
        'inflation_score',
        'exchange_score',
        'news_score',
        'total_score',
        'status',
    ];

    protected $casts = [
        'weather_score' => 'float',
        'inflation_score' => 'float',
        'exchange_score' => 'float',
        'news_score' => 'float',
        'total_score' => 'float',
    ];

    /**
     * Risk score belongs to a country.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(
            Country::class,
            'country_id'
        );
    }

    /**
     * Mendapatkan label risiko.
     */
    public function getRiskLabelAttribute(): string
    {
        $score = (float) $this->total_score;

        if ($score >= 70) {
            return 'Critical Risk';
        }

        if ($score >= 50) {
            return 'High Risk';
        }

        if ($score >= 30) {
            return 'Medium Risk';
        }

        return 'Low Risk';
    }

    /**
     * Mendapatkan warna indikator risiko.
     */
    public function getRiskColorAttribute(): string
    {
        $score = (float) $this->total_score;

        if ($score >= 70) {
            return 'red';
        }

        if ($score >= 50) {
            return 'orange';
        }

        if ($score >= 30) {
            return 'yellow';
        }

        return 'green';
    }
}