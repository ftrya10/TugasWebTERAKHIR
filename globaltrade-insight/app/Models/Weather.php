<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    use HasFactory;

    protected $table = 'weather';

    protected $fillable = [
        'country_id',
        'temperature',
        'condition',
        'weather_score',
    ];

    protected $casts = [
        'temperature' => 'decimal:2',
        'weather_score' => 'integer',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}