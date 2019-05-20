#!/usr/bin/env php
<?php
const YYMM = 'YYMM';
const MMYY = 'MMYY';
const BOTH = 'AMBIGUOUS';
const INVALID = 'NA';
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

$S = (int)getNext($gen);

$a = (int)($S / 100);
$b = (int)($S % 100);


function valid_month($n) {
    return ($n >= 1 && $n <= 12);
}

if (valid_month($a) && valid_month($b)) {
    echo BOTH;
} elseif (valid_month($a)) {
    echo MMYY;
} elseif (valid_month($b)) {
    echo YYMM;
} else {
    echo INVALID;
}
echo PHP_EOL;
