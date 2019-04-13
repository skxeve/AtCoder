<?php

$inputs = [];

for ($i = 0; $i < 5; $i++) {
    fscanf(STDIN, "%d", $inputs[$i]);
}

$sum = 0;
$diffs = [];
foreach ($inputs as $item) {
    $upten = (int)ceil($item / 10) * 10;
    $diff = $upten - $item;
    if ($diff > 0) {
        $diffs[] = $diff;
    }
    $sum += $upten;
}

if (count($diffs) > 0) {
    $sum -= max($diffs);
}

echo $sum;
