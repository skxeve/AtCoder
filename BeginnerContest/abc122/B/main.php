#!/usr/bin/env php
<?php
function solve(string $S)
{
    $white = preg_replace('/[^ACGT]/', ' ', $S);
    foreach (explode(' ', $white) as $item) {
        $c[] = strlen($item);
    }
    echo max($c).PHP_EOL;
}

fscanf(STDIN, '%s', $S);
solve($S);

