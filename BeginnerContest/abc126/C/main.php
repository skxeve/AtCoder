#!/usr/bin/env php
<?php

function genInputs() {
    while(($input = rtrim(fgets(STDIN))) !== false) {
        foreach (explode(' ', $input) as $v) {
            yield $v;
        }
    }
}
function getNext($gen) {
    $value = $gen->current();
    $gen->next();
    return $value;
}
$gen = genInputs();

$N = (int)getNext($gen);
$K = (int)getNext($gen);

$q = 0;
while (pow(2, $q) < $K) { $q++; }
$per = pow(2, $q);
$sum = 1;

$p = 0;
for ($i = $N; $i > 1; $i--) {
    while ($i * pow(2, $p) < $K) { $p++; }
    $sum += pow(2, $q - $p);
}

echo ($sum / $per / $N).PHP_EOL;

