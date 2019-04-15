#!/usr/bin/env php
<?php
fscanf(STDIN, "%d %d", $N, $Q);
fscanf(STDIN, "%s", $S);
$left = [];
for($i = 0; $i < $N; $i++) {
    $t = $S[$i];
    if ($i > 0) {
        $left[$i] = $left[$i - 1];
    } else {
        $left[$i] = 0;
    }
    if ($t != 'A') {
        continue;
    }
    if ($i + 1 >= $N) {
        continue;
    }
    if ($S[$i + 1] != 'C') {
        continue;
    }
    $left[$i]++;
}
while (($item = fgets(STDIN)) !== false) {
    list($i, $j) = explode(' ', $item);
    $l = 0;
    $r = 0;
    if ($i > 1) {
        $l = $left[$i-2];
    }
    if ($j > 1) {
        $r = $left[$j-2];
    }
    $num = $r - $l;

    echo $num.PHP_EOL;
}
