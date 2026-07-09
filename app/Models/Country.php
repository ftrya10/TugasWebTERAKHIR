<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name',
        'gdp',
        'inflation',
        'population',
        'currency'
    ];

    public function weather()
    {
        return $this->hasOne(Weather::class);
    }

    public function exchangeRate()
    {
        return $this->hasOne(ExchangeRate::class);
    }

    public function news()
    {
        return $this->hasOne(News::class);
    }

    public function riskScore()
    {
        return $this->hasOne(RiskScore::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}