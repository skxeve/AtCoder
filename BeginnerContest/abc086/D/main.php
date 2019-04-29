#!/usr/bin/env php
<?php
const WHITE = 'W';
const BLACK = 'B';
function genInputs() {
    while(($input = rtrim(fgets(STDIN))) !== false) {
        foreach (explode(' ', $input) as $v) {
            yield $v;
        }
    }
}
function getNext(Generator $gen) {
    $value = $gen->current();
    $gen->next();
    return $value;
}
$gen = genInputs();

$N = (int)getNext($gen);
$K = (int)getNext($gen);
$sq = array_fill(0, ($K * $K * 2), 0);
for ($i = 0; $i < $N; $i++) {
    $x = (int)getNext($gen);
    $y = (int)getNext($gen);
    $c = (string)getNext($gen);

    $x = $x % ($K * 2);
    $y = $y % ($K * 2);
    if ($x < 0) { $x += $K * 2; }
    if ($y < 0) { $y += $K * 2; }
    for ($j = 0; $j < (count($sq) / 2); $j++) {
        $a = (int)($j / $K);
        $b = $j % $K;
        $diff_x = $x - $a;
        $diff_y = $y - $b;
        $is_ok = false;
        if ($diff_x >= 0) {
            if ($diff_y >= 0) {
                if ($diff_x < $K && $diff_y < $K) {
                    $is_ok = true;
                } elseif ($diff_x >= $K && $diff_y >= $K) {
                    $is_ok = true;
                }
            } else {
                if ($diff_x < $K && $diff_y < (0 - $K)) {
                    $is_ok = true;
                } elseif ($diff_x >= $K && $diff_y >= (0 - $K)) {
                    $is_ok = true;
                }
            }
        } else {
            if ($diff_y >= 0) {
                if ($diff_x >= (0 - $K) && $diff_y >= $K) {
                    $is_ok = true;
                } elseif ($diff_x < (0 - $K) && $diff_y < $K) {
                    $is_ok = true;
                }
            } else {
                if ($diff_x >= (0 - $K) && $diff_y >= (0 - $K)) {
                    $is_ok = true;
                } elseif ($diff_x < (0 - $K) && $diff_y < (0 - $K)) {
                    $is_ok = true;
                }
            }
        }
        if (($is_ok && $c == WHITE) || (!$is_ok && $c == BLACK)) {
            $sq[$j]++;
        } elseif (($is_ok && $c == BLACK) || (!$is_ok && $c == WHITE)) {
            $k = $j + $K * $K;
            $sq[$k]++;
        }
    }
}
echo max($sq).PHP_EOL;
