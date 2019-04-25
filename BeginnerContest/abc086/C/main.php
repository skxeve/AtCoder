#!/usr/bin/env php
<?php
const YES = "Yes";
const NO = "No";

function getInputs() {
    while(($input = fgets(STDIN)) !== false) {
        foreach (explode(' ', $input) as $v) {
            yield $v;
        }
    }
}

$gen = getInputs();
$N = $gen->current(); $gen->next();
$pre_x = 0;
$pre_y = 0;
$pre_t = 0;
while ($gen->valid()) {
    $time = $gen->current(); $gen->next();
    $cur_x = $gen->current(); $gen->next();
    $cur_y = $gen->current(); $gen->next();
    $move_t = $time - $pre_t;
    $move_s = abs($cur_x - $pre_x) + abs($cur_y - $pre_y);
    if ($move_s > $move_t) {
        echo NO.PHP_EOL;
        return;
    }
    if (($move_s % 2) != ($move_t % 2)) {
        echo NO.PHP_EOL;
        return;
    }

    $pre_x = $cur_x;
    $pre_y = $cur_y;
    $pre_t = $time;
}
echo YES.PHP_EOL;
