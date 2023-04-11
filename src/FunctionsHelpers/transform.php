<?php

function singleArrayToMultiArray(array $array, string $value = ''): array
{
    $newArray = [];
    foreach ($array as $key) {
        $newArray[$key] = $value;
    }

    return $newArray;
}
