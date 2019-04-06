<?php

$inputs = [];

for ($i = 0; $i < 6; $i++) {
    fscanf(STDIN, "%d", $inputs[$i]);
}
$number = array_shift($inputs);

$plus = (int)ceil($number / min($inputs)) - 1;
$min = 5 + $plus;

echo $min;
