#!/usr/bin/env php
<?php

$inputs = [];
while (($item = fgets(STDIN)) !== false) {
    $inputs[] = $item;
}

$map = [
    'A' => 'T',
    'T' => 'A',
    'C' => 'G',
    'G' => 'C',
];
$x = trim(array_shift($inputs));
echo $map[$x].PHP_EOL;
