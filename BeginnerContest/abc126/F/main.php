#!/usr/bin/env php
<?php
$start_time = microtime(true);
const NONE = -1;
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

$M = (int)getNext($gen);
$K = (int)getNext($gen);

$list_under = pow(2, $M);
$list_count = pow(2, $M + 1);

$list = [];
if ($K === 0) {
    for ($i = 0; $i < $list_under; $i++) {
        $list[] = $i;
        $list[] = $i;
    }
} else {
    for ($i = 0; $i < $list_under; $i++) {
        $list[] = $i;
        $list[] = $i;
    }
    // わからぬ・・・
}
if (is_ok($list, $K)) {
    echo implode(' ', $list).PHP_EOL;
} else {
    echo NONE.PHP_EOL;
}

function is_ok($list, $K) {
    for ($i = 0; $i <= max($list); $i++) {
        list($a, $b) =  array_keys($list, $i);
        $xsum = 0;
        for ($j = $a; $j <= $b; $j++) {
            $xsum = $xsum ^ $list[$j];
        }
        if ($xsum != $K) {
            return false;
        }
    }
    return true;
}
