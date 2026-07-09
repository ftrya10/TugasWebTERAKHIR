<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiskScore extends Model
{
    protected $fillable = [
        'country_id',
        'weather_score',
        'inflation_score',
        'exchange_score',
        'news_score',
        'total_score',
        'status'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}