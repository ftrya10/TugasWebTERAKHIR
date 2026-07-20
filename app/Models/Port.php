<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Port extends Model
{

    protected $fillable = [

        'country_id',
        'name',
        'city',
        'latitude',
        'longitude',
        'status',
        'description'

    ];


    public function country()
    {
        return $this->belongsTo(Country::class);
    }

}