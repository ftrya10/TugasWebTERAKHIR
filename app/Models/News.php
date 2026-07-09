<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'country_id',
        'title',
        'sentiment',
        'news_score'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}