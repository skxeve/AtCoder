#!/usr/bin/env php
<?php
function solve(int $a, int $b)
{
    if ($a == $b) {
        echo $a * 2;
    } elseif ($a > $b) {
        echo $a * 2 - 1;
    } else {
        echo $b * 2 - 1;
    }
    echo PHP_EOL;
}

fscanf(STDIN, '%d %d', $a, $b);
solve($a, $b);

