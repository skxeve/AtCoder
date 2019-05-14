#!/usr/bin/env php
<?php
const MOD = 2;

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

function calc_mod_count($a) {
    static $mod_counts = [];
    if (isset($mod_counts[$a])) {
        return $mod_counts[$a];
    }
    if ($a % MOD !== 0) {
        $mod_counts[$a] = 0;
        return 0;
    }
    $ret = calc_mod_count($a / MOD) + 1;
    $mod_counts[$a] = $ret;
    return $ret;
}

for($i = 0; $i < $N; $i++) {
    $a = getNext($gen);
    $origin_counts[$i] = calc_mod_count($a);
}
echo min($origin_counts).PHP_EOL;
