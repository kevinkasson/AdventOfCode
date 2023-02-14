<?php

include('common.php');

$input = getInput('5');
$sample_input = getSample('5');

function printGrid($grid) {
    for ($i = 0; $i <= max(array_keys($grid)); $i++) {
        for ($j = 0; $j <= max(array_keys($grid[$i] ?? [])); $j++) {
            if (isset($grid[$j][$i])) {
                print $grid[$j][$i];
            }
            else {
                print "x";
            }
        }
        print "\n";
    }
}

function first($input) {
    $grid = [];

    foreach ($input as $line) {
        $endpoints = explode(' -> ', $line);
        $start = explode(',', $endpoints[0]);
        $end = explode(',', $endpoints[1]);
        $k = NULL;
        if ($start[0] == $end[0]) { // Same x coord
            $k = 1;
        }
        if ($start[1] == $end[1]) { // Same y coord
            $k = 0;
        }
        if ($k !== NULL) {
            //print "Using line {$start[0]},{$start[1]} to {$end[0]},{$end[1]}\n";
            for ($i = min($start[$k], $end[$k]); $i <= max($start[$k], $end[$k]); $i++) {
                if ($k == 1) { // Same x coord, so $i gets added to y coord
                    //print "Setting {$start[0]}, $i\n";
                    $grid[$start[0]][$i] = ($grid[$start[0]][$i] ?? 0) + 1;
                }
                else { // Same y coord, so $i gets added to x coord
                    //print "Setting $i, {$start[1]}\n";
                    $grid[$i][$start[1]] = ($grid[$i][$start[1]] ?? 0) + 1;
                }
            }
        }
    }
    //printGrid($grid);
    $count = 0;
    foreach ($grid as $x) {
        foreach ($x as $y) {
            if ($y > 1) {
                $count++;
            }
        }
    }
    return $count;
}

function second($input) {

    $grid = [];

    foreach ($input as $line) {
        $endpoints = explode(' -> ', $line);
        $start = explode(',', $endpoints[0]);
        $end = explode(',', $endpoints[1]);
        $xdiff = $end[0] - $start[0];
        $ydiff = $end[1] - $start[1];
        //print "$line $xdiff $ydiff\n";
        for ($i = 0; $i <= max(abs($xdiff), abs($ydiff)); $i++) {
            //print "Filling " . ($start[0] + ($xdiff > 0 ? $i : ($xdiff < 0 ? -1 * $i : 0))) . ',' . ($start[1] + ($ydiff > 0 ? $i : ($ydiff < 0 ? -1 * $i : 0))) . "\n";
            $grid[$start[0] + ($xdiff > 0 ? $i : ($xdiff < 0 ? -1 * $i : 0))][$start[1] + ($ydiff > 0 ? $i : ($ydiff < 0 ? -1 * $i : 0))] = ($grid[$start[0] + ($xdiff > 0 ? $i : ($xdiff < 0 ? -1 * $i : 0))][$start[1] + ($ydiff > 0 ? $i : ($ydiff < 0 ? -1 * $i : 0))] ?? 0) + 1;
        }
    }
    //printGrid($grid);
    $count = 0;
    foreach ($grid as $x) {
        foreach ($x as $y) {
            if ($y > 1) {
                $count++;
            }
        }
    }
    return $count;
}

test($sample_input, 'first', 5);
test($sample_input, 'second', 12);

print "First: " . first($input) . "\n";
print "Second: " . second($input) . "\n";