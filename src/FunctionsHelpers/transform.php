<?php

function singleArrayToMultiArray($array, $value = ''): array
{
    $newArray = [];
    foreach ($array as $key) {
        $newArray[$key] = $value;
    }

    return $newArray;
}
