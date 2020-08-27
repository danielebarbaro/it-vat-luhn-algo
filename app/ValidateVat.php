<?php declare(strict_types=1);

namespace App;

use phpDocumentor\Reflection\Types\Integer;

final class ValidateVat
{
    /**
     * Regular expression patterns per country code
     *
     * @var array
     * @link http://ec.europa.eu/taxation_customs/vies/faq.html?locale=en#item_11
     */
    protected static $pattern_expression = [
        'IT' => '\d{11}',
    ];

    /**
     * Verify IT VAT
     *
     * @param  string  $vat
     * @return bool
     */
    public static function verify(string $vat): bool
    {
        $vat = self::clean($vat);

        $is_valid = self::isValidFormat($vat);
        if ($is_valid) {
            $result = self::luhnCheck($vat);
            return $result % 10 == 0 ? true : false;
        }

        return false;
    }

    /**
     * A php implementation of Luhn Algo
     *
     * @link https://en.wikipedia.org/wiki/Luhn_algorithm
     * @param  string  $vat
     * @return int
     */
    public static function luhnCheck(string $vat): int
    {
        $sum = 0;
        $vat_array = str_split($vat);
        for ($index = 0; $index < count($vat_array); $index++) {
            $value = intval($vat_array[$index]);
            if ($index % 2) {
                $value = $value * 2;
                if ($value > 9) {
                    $value = 1 + ($value % 10);
                }
            }
            $sum += $value;
        }
        return $sum;
    }

    /**
     * Verify if VAT have right format
     *
     * @param  string  $vat
     * @return bool
     */
    public static function isValidFormat(string $vat): bool
    {
        return preg_match('/^'.self::$pattern_expression['IT'].'$/', $vat) > 0;
    }

    /**
     * Clean VAT spaces
     *
     * @param  string  $vat
     * @return string
     */
    public static function clean(string $vat): string
    {
        return trim($vat);
    }
}
