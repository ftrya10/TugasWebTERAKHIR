<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsCache extends Model
{
    protected $fillable = [
        'country_id',
        'title',
        'description',
        'url',
        'source',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Relasi cache berita dengan negara.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}