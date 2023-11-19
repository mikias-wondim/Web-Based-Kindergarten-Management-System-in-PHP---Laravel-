<?php

namespace App\Helpers;

class Helper
{
    public static function tocsv($data, $keyword)
    {
        $strings = Helper::getValuesBySubstring($data, $keyword);
        $csv = '';
        for ($i = 0; $i < count($strings); $i++) {
            $csv .= ($i + 1 === count($strings)) ? $strings[$i] : $strings[$i].",";
        }

        return $csv;
    }

    public static function getValuesBySubstring($array, $substring) {
        $filteredValues = [];

        foreach ($array as $key => $value) {
            if (strpos($key, $substring) !== false) {
                $filteredValues[] = $value;
            }
        }

        return $filteredValues;
    }
}
