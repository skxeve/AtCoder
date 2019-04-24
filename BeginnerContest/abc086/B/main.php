#!/usr/bin/env php
<?php
const YES = "Yes";  # type: str
const NO = "No";  # type: str
function solve(int $a, int $b)
{
    $c = (int)((string)$a . (string)$b);
    $s = sqrt($c);
    $r = (int)$s;
    if (($s - $r) > 0) {
        echo NO.PHP_EOL;
    } else {
        echo YES.PHP_EOL;
    }
}

$inputs = [];
while (($item = fgets(STDIN)) !== false) {
    $inputs = array_merge($inputs, explode(' ', $item));
}
$a = (int)array_shift($inputs);
$b = (int)array_shift($inputs);
solve($a, $b);

