<?php

if (!function_exists('formatRupiah')) {
    /**
     * Format number to Rupiah currency
     *
     * @param  int|float  $amount
     * @param  bool  $showSymbol
     * @return string
     */
    function formatRupiah($amount, $showSymbol = true)
    {
        if (is_null($amount)) {
            return '-';
        }
        
        $formatted = number_format($amount, 0, ',', '.');
        
        return $showSymbol ? 'Rp ' . $formatted : $formatted;
    }
}

if (!function_exists('formatSalaryRange')) {
    /**
     * Format salary range for display
     *
     * @param  int|float|null  $min
     * @param  int|float|null  $max
     * @return string
     */
    function formatSalaryRange($min, $max)
    {
        if (!$min && !$max) {
            return 'Salary not specified';
        }
        
        if ($min && $max) {
            return formatRupiah($min) . ' - ' . formatRupiah($max);
        }
        
        if ($min) {
            return 'Starting from ' . formatRupiah($min);
        }
        
        return 'Up to ' . formatRupiah($max);
    }
}
