<?php

namespace App\Helpers;

if (!function_exists('countLengthNewlinesOneCharacter')) {
    /**
     * Count the length of $string but the newlines are counted as only 1 character
     * @param $string
     * @return false|int
     */
    function countLengthNewlinesOneCharacter($string)
    {
        $countNewlines = preg_match_all('/\n/', $string);
        $countCharacters = preg_match_all('/[\S\s]/', str_replace(["\n", "\r\n", "\r"],"",$string));
        return $countNewlines + $countCharacters;
    }
}

if (!function_exists('textAreaNewlinesToSimpleNewline')) {
    /**
     * Convert newlines from a textarea into '\n'
     * @param $string
     * @return string|string[]
     */
    function textAreaNewlinesToSimpleNewline($string)
    {
        $string = str_replace(["\n", "\r\n", "\r"],"",$string);
        return $string;
    }
}
