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

$s = getNext($gen);
$n = 0;
for ($i = 0; $i < strlen($s); $i++) {
    if ($s[$i] == 1) {
        $n++;
    }
}
echo $n.PHP_EOL;
