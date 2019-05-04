#!/usr/bin/env php
<?php
const YES = "YES";
const NO = "NO";

const UP = 'U';
const DOWN = 'D';
const LEFT = 'L';
const RIGHT = 'R';

const REVERSE = [
    UP => DOWN,
    DOWN => UP,
    LEFT => RIGHT,
    RIGHT => LEFT,
];

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

$H = (int)getNext($gen);
$W = (int)getNext($gen);
$N = (int)getNext($gen);
$s_r = (int)getNext($gen);
$s_c = (int)getNext($gen);
$S = (string)getNext($gen);
$T = (string)getNext($gen);

$calc_need = function($now) use($H, $W, $s_r, $s_c) {
    $need = 0;
    if ($now == UP) {
        $need = $s_r;
    } elseif ($now == DOWN) {
        $need = $H - $s_r + 1;
    } elseif ($now == LEFT) {
        $need = $s_c;
    } else {
        $need = $W - $s_c + 1;
    }
    return $need;
};

$is_end_game = function($s_now, $s_vec, $t_vec) use($calc_need) {
    $off = $s_vec[$s_now];
    $on = $t_vec[REVERSE[$s_now]];
    if ($off <= $on) {
        return false;
    }
    $need = $calc_need($s_now);
    if (($off - $on) >= $need) {
        return true;
    }
    return false;
};

$check_usable_vec = function($t_now, $s_vec, &$t_vec) use($calc_need) {
    $off = $t_vec[$t_now];
    $on = $s_vec[REVERSE[$t_now]];
    $need = $calc_need($t_now);
    if (($off - $on) >= $need) {
        $t_vec[$t_now]--;
    }
};

$s_vec = $t_vec = [
    UP => 0,
    DOWN => 0,
    LEFT => 0,
    RIGHT => 0,
];
for ($i = 0; $i < $N; $i++) {
    $s_now = $S[$i];
    $s_vec[$s_now]++;
    //print_r([$i, $s_now, $s_vec, $t_vec]);
    if ($is_end_game($s_now, $s_vec, $t_vec)) {
        echo NO.PHP_EOL;
        exit;
    }
    $t_now = $T[$i];
    $t_vec[$t_now]++;
    $check_usable_vec($t_now, $s_vec, $t_vec);
}
echo YES.PHP_EOL;
exit;
