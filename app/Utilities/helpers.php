<?php

if (!function_exists('numeric')) {

    /**
     * Helper get decimal value if needed.
     * Trim unnecessary zero after comma: (2,000 -> 2) or (3,200 -> 3,2)
     *
     * @param $number
     * @param int $precision
     * @param bool $trimmed
     * @param string $dec_point
     * @param string $thousands_sep
     * @return int|string
     */
    function numeric($number, $precision = 3, $trimmed = true, $dec_point = ',', $thousands_sep = '.')
    {
        if (empty($number)) {
            return 0;
        }
        $formatted = number_format($number, $precision, $dec_point, $thousands_sep);

        if (!$trimmed) {
            return $formatted;
        }

        // Trim unnecessary zero after comma: (2,000 -> 2) or (3,200 -> 3,2)
        return strpos($formatted, $dec_point) !== false ? rtrim(rtrim($formatted, '0'), $dec_point) : $formatted;
    }
}

if (!function_exists('extract_number')) {

    /**
     * Extract number from value.
     *
     * @param $value
     * @param $default
     * @return null|string|string[]
     */
    function extract_number($value, $default = 0)
    {
        $value = preg_replace("/[^0-9-,\/]/", "", $value);
        $value = preg_replace("/,/", ".", $value);
        return $value == '' ? $default : $value;
    }
}

if (!function_exists('app_setting')) {

    /**
     * Get application setting by passing value.
     *
     * @param $key
     * @param $default
     * @return null|string|string[]
     */
    function app_setting($key, $default = '')
    {
        return \App\Models\Setting::item($key, $default);
    }
}
