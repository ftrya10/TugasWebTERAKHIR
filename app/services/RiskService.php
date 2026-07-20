<?php

namespace App\Services;

class RiskService 
{
    /**
     * Hitung total skor risiko berdasarkan 4 indikator utama.
     */
    public static function calculateTotal($weather, $inflation, $exchange, $news) 
    {
        return (int)$weather + (int)$inflation + (int)$exchange + (int)$news;
    }

    /**
     * Tentukan label status risiko berdasarkan total skor.
     */
    public static function getStatus($totalScore) 
    {
        if ($totalScore <= 30) {
            return 'Low Risk';
        } elseif ($totalScore <= 70) {
            return 'Medium Risk';
        } else {
            return 'High Risk';
        }
    }
}