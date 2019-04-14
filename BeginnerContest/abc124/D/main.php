#!/usr/bin/env php
<?php
function solve(int $N, int $K, string $S)
{
    $first = (int)($S[0]);
    $last = $first;
    $list = [];
    $zero = 0;
    foreach (explode('0', $S) as $item) {
        if (($l = strlen($item)) == 0) {
            $zero++;
        } else {
            if ($zero) {
                $list[] = $zero;
            }
            $zero = 1;
            $list[] = $l;
        }
    }
    if ($zero >= 2) {
        $zero--;
        $list[] = $zero;
    }

    $join_num = $K * 2 + 1;
    if (count($list) < $join_num) {
        echo array_sum($list).PHP_EOL;
        return;
    }

    for($i = 0; $i + $join_num <= count($list) + 1; $i++) {
        if (($i % 2) + $first === 0 && $i >= 1) {
            continue;
        }
        $num = $join_num;
        if ($i == 0) {
            $num--;
        }
        $counts[$i] = array_sum(array_slice($list, $i, $num));
    }
    echo max($counts).PHP_EOL;
}

fscanf(STDIN, '%d %d', $N, $K);
fscanf(STDIN, '%s', $S);
solve($N, $K, $S);

