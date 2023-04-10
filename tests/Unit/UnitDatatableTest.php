<?php

it('cant transform array into array with key and empty value', function () {
    $array = singleArrayToMultiArray(['name', 'surname', 'email']);

    expect($array)->toMatchArray([
        'name' => '',
        'surname' => '',
        'email' => '',
    ]);
});


