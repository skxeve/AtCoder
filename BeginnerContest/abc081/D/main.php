#!/usr/bin/env php
<?php
fscanf(STDIN, "%d", $N);
$array = array_map(function($v) {return (int)$v;}, explode(' ', rtrim(fgets(STDIN))));

$plus = [];
$first_max = max($array);
$first_min = min($array);

$direct_plus = true;
if ($first_min >= 0) {
    $direct_plus = true;
} elseif ($first_max <= 0) {
    $direct_plus = false;
} elseif ($first_max > abs($first_min)) {
    $direct_plus = true;
    $k = array_search($first_max, $array, true);
    for ($i = 0; $i < $N; $i++) {
        if ($array[$i] < 0) {
            $plus[] = sprintf("%d %d", $k + 1, $i + 1);
            $array[$i] += $array[$k];
        }
    }
} else {
    $direct_plus = false;
    $k = array_search($first_min, $array, true);
    for ($i = 0; $i < $N; $i++) {
        if ($array[$i] > 0) {
            $plus[] = sprintf("%d %d", $k + 1, $i + 1);
            $array[$i] += $array[$k];
        }
    }
}

if ($direct_plus) {
    for ($i = 0; ($i + 1) < $N; $i++) {
        $a = $array[$i];
        $b = $array[$i + 1];
        while ($a > $b) {
            $mx = max($array);
            $k = null;
            if ($a > ($b + $mx)) {
                $k = array_search($mx, $array, true);
            } else {
                $mn = $mx;
                foreach ($array as $j => $v) {
                    if ($a <= ($b + $v) && $mn >= $v) {
                        $k = $j;
                        $mn = $v;
                    }
                }
            }
            $plus[] = sprintf("%d %d", $k + 1, $i + 2);
            $array[$i + 1] += $array[$k];
            $b = $array[$i + 1];
        }
    }
} else {
    for ($i = $N - 1; $i >= 1; $i--) {
        $a = $array[$i - 1];
        $b = $array[$i];
        while ($a > $b) {
            $mn = min($array);
            $k = null;
            if (($a + $mn) > $b) {
                $k = array_search($mx, $array, true);
            } else {
                $mx = $mn;
                foreach ($array as $j => $v) {
                    if (($a + $v) <= $b && $mx <= $v) {
                        $k = $j;
                        $mx = $v;
                    }
                }
            }
            $plus[] = sprintf("%d %d", $k + 1, $i);
            $array[$i - 1] += $array[$k];
            $a = $array[$i - 1];
        }
    }
}

echo count($plus).PHP_EOL;
if (count($plus)) {
    echo implode(PHP_EOL, $plus).PHP_EOL;
}
