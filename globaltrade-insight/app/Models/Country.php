<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'flag',
        'region',
        'gdp',
        'inflation',
        'population',
        'currency',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'gdp' => 'decimal:2',
        'inflation' => 'decimal:2',
        'population' => 'integer',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    public function weather()
    {
        return $this->hasOne(Weather::class);
    }

    public function exchangeRate()
    {
        return $this->hasOne(ExchangeRate::class);
    }

    public function riskScore()
    {
        return $this->hasOne(RiskScore::class);
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function ports()
    {
        return $this->hasMany(Port::class);
    }
}