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
for ($i = 0; $i < $N; $i++) {
    $A[] = (int)getNext($gen);
}
$map = array_count_values($A);
asort($map);
echo array_sum(array_slice($map, 0, count($map) - $K)).PHP_EOL;
