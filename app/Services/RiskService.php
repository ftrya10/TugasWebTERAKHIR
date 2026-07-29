<?php

namespace App\Services;

class RiskService
{
    /**
     * Kalkulasi Total Risk Score menggunakan Weighted Risk Model.
     * Mengacu pada spesifikasi di PDF:
     * Weather = 30%
     * Inflation = 20%
     * Exchange Rate = 10%
     * News (Political/Sentiment) = 40%
     */
    public static function calculateTotal($weatherScore, $inflationScore, $exchangeScore, $newsScore)
    {
        $weatherScore = (float) ($weatherScore ?? 0);
        $inflationScore = (float) ($inflationScore ?? 0);
        $exchangeScore = (float) ($exchangeScore ?? 0);
        $newsScore = (float) ($newsScore ?? 0);

        $total = ($weatherScore * 0.30) + 
                 ($inflationScore * 0.20) + 
                 ($exchangeScore * 0.10) + 
                 ($newsScore * 0.40);

        return round($total, 2);
    }

    /**
     * Menentukan status resiko berdasarkan total score.
     */
    public static function getStatus($totalScore)
    {
        $totalScore = (float) ($totalScore ?? 0);
        if ($totalScore >= 60) {
            return 'High Risk';
        } elseif ($totalScore >= 35) {
            return 'Medium Risk';
        } else {
            return 'Low Risk';
        }
    }

}
