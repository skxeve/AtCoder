<?php

$abcde = [];

for ($i = 0; $i < 5; $i++) {
    fscanf(STDIN, "%d", $abcde[$i]);
}
fscanf(STDIN, "%d", $k);

if (($abcde[4] - $abcde[0]) > $k) {
    echo ":(";
} else {
    echo "Yay!";
}
