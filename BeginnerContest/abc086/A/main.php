#!/usr/bin/env php
<?php
function solve(int $a, int $b)
{
    if (($a * $b) % 2) {
        echo "Odd".PHP_EOL;
    } else {
        echo "Even".PHP_EOL;
    }
}

$inputs = [];
while (($item = fgets(STDIN)) !== false) {
    $inputs = array_merge($inputs, explode(' ', $item));
}
$a = (int)array_shift($inputs);
$b = (int)array_shift($inputs);
solve($a, $b);

