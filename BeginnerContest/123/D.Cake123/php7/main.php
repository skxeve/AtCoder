<?php

$counts = [];
fscanf(STDIN, "%d %d %d %d", $counts[0], $counts[1], $counts[2], $k);

$cakes = [];
for ($i = 0; $i < 3; $i++) {
    $input = trim(fgets(STDIN));
    $cakes[$i] = explode(' ', $input);
    rsort($cakes[$i]);
}

$calc = function($p) use ($cakes) {
    $sum = 0;
    for ($i = 0; $i < 3; $i++) {
        $j = $p[$i];
        $n = $cakes[$i][$j];
        $sum += $n;
    }
    return $sum;
};
$kcalc = function($p) {
    return implode("_", $p);
};

$cp = [0,0,0];
$key = $kcalc($cp);
$used = [$key => true];
echo $calc($cp).PHP_EOL;

$add_current = function(&$current, $new) use($calc, $kcalc, $used, $counts) {
    for ($j = 0; $j < 3; $j++) {
        $tmp = $new;
        $tmp[$j]++;
        if ($tmp[$j] >= $counts[$j]) {
            continue;
        }
        $key = $kcalc($tmp);
        if (array_key_exists($key, $current) || array_key_exists($key, $used)) {
            continue;
        }
        $current[$key] = $calc($tmp);
    }
};

$current = [];
$add_current($current, $cp);

for ($i = 1; $i < $k; $i++) {
    $key = array_search(max($current), $current);
    echo $current[$key].PHP_EOL;
    $add_current($current, explode('_', $key));
    $used[$key] = true;
    unset($current[$key]);
}
