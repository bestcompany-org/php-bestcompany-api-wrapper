<?php

if (! function_exists('headerStringToArray')) {
    function headerStringToArray(string $headers)
    {
        return array_reduce(
            explode(',', $headers),
            function ($carry, $kvp) {
                [$key, $value] = explode('=', $kvp);
                $carry[trim($key)] = trim($value);

                return $carry;
            },
            []
        );
    }
}
