<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    protected $fillable = [
        'country_id',
        'currency',
        'rate',
        'exchange_score'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}