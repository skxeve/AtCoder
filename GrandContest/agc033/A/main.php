#!/usr/bin/env php
<?php
const BLACK = '#';
const WHITE = '.';
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

$change = [];
for ($i = 0; $i < $H; $i++) {
    $item = getNext($gen);
    for ($j = 0; $j < $W; $j++) {
        if ($item[$j] == BLACK) {
            $change[$i][$j] = 0;
        }
    }
}
$add_change = function($i, $j, $n) use($H, $W, &$change, &$add_change) {
    if (!isset($change[$i][$j])) {
        $change[$i][$j] = $n;
    } elseif ($change[$i][$j] > $n) {
        $change[$i][$j] = $n;
    } else {
        return false;
    }
    return true;
};
$number = 0;
$next = true;
while ($next) {
    $next = false;
    foreach ($change as $i => $row) {
        foreach ($row as $j => $item) {
            if ($item != $number) {
                continue;
            }
            foreach ([[$i - 1, $j], [$i + 1, $j], [$i, $j - 1], [$i, $j + 1]] as $pos) {
                if ($pos[0] < 0 || $pos[0] >= $H || $pos[1] < 0 || $pos[1] >= $W) {
                    continue;
                }
                $ret = $add_change($pos[0], $pos[1], $number + 1);
                if ($ret) {
                    $next = true;
                }
            }
        }
    }
    $number++;
}
echo max(array_map(function($child) { return max($child); }, $change)).PHP_EOL;
