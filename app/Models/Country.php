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
        'currency',
        'weather',
        'weather_score',
        'inflation_score',
        'exchange_score',
        'news_score'

    ];


    public function getRiskScoreAttribute()
    {

        return 
        $this->weather_score +
        $this->inflation_score +
        $this->exchange_score +
        $this->news_score;

    }


    public function getRiskStatusAttribute()
    {

        if($this->risk_score <= 40)
        {
            return "Low Risk";
        }

        elseif($this->risk_score <= 70)
        {
            return "Medium Risk";
        }

        else
        {
            return "High Risk";
        }

    }

}