<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = [
        'user_id',
        'country_id',
    ];

    /**
     * Relasi favorit dengan pengguna.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi favorit dengan negara.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}