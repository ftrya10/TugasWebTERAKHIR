<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
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


    /**
     * Relasi negara dengan pelabuhan
     */
    public function ports()
    {
        return $this->hasMany(Port::class);
    }


    public function newsCaches()
    {
        return $this->hasMany(NewsCache::class);
    }


    public function watchlists()
    {
        return $this->hasMany(Watchlist::class);
    }
}