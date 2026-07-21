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
        'description',
    ];

    /**
     * Relasi pelabuhan dengan negara.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Mengecek apakah pelabuhan sedang aktif.
     */
    public function isActive()
    {
        return strtolower($this->status ?? '') === 'active';
    }

    /**
     * Mengecek apakah pelabuhan sedang mengalami kemacetan.
     */
    public function isCongested()
    {
        return in_array(
            strtolower($this->status ?? ''),
            ['congested', 'delayed', 'critical']
        );
    }

    /**
     * Mendapatkan label status pelabuhan.
     */
    public function getStatusLabelAttribute()
    {
        return match (strtolower($this->status ?? '')) {
            'active' => 'Aktif',
            'congested' => 'Macet',
            'delayed' => 'Terlambat',
            'critical' => 'Kritis',
            'inactive' => 'Tidak Aktif',
            default => ucfirst($this->status ?? 'Tidak Diketahui'),
        };
    }
}