#!/usr/bin/env php
<?php
// Use ACGT strings.
const STRS = ['A','C','G','T'];
// AGC is NG, allow 1 exchange.
const NG_PATTERN = [
    'AGC',
    'ACG',
    'GAC',
    'A.GC',
    'AG.C',
];
const MOD = 1000000007;  # type: int

function is_ok($tail4string) {
    static $ok_cache = [];
    if (array_key_exists($tail4string, $ok_cache)) {
        return $ok_cache[$tail4string];
    }
    foreach (NG_PATTERN as $ng) {
        if (preg_match('/'.$ng.'/', $tail4string)) {
            $ok_cache[$tail4string] = false;
            return false;
        }
    }
    $ok_cache[$tail4string] = true;
    return true;
};

function sch($current, $last3string) {
    global $N;
    static $sch_cache = [];
    if (isset($sch_cache[$current][$last3string])) {
        return $sch_cache[$current][$last3string];
    }
    if ($current == $N) {
        return 1;
    }
    $ret = 0;
    foreach (STRS as $next) {
        if (is_ok($last3string . $next)) {
            $ret += sch($current + 1, substr($last3string, 1) . $next);
        }
    }
    $ret = $ret % MOD;
    $sch_cache[$current][$last3string] = $ret;
    return $ret;
};

fscanf(STDIN, '%d', $N);
echo sch(0, 'TTT').PHP_EOL;

