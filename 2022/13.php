<?php

include('common.php');

$input = getInput('13');
$sample_input = getSample('13');

function fold($grid, $fold_type, $fold_pos) {
    $new_grid = [];
    foreach ($grid as $x => $v) {
        foreach ($v as $y => $t) {
            if ($fold_type == 'x') {
                if ($x > $fold_pos) {
                    if (!isset($new_grid[$x])) {
                        $new_grid[$x] = [];
                    }
                    $new_grid[($fold_pos * 2) - $x][$y] = TRUE;
                }
                else {
                    $new_grid[$x][$y] = TRUE;
                }
            }
            else  {
                if ($y > $fold_pos) {
                    if (!isset($new_grid[$x])) {
                        $new_grid[$x] = [];
                    }
                    $new_grid[$x][($fold_pos * 2) - $y] = TRUE;
                }
                else {
                    $new_grid[$x][$y] = TRUE;
                }
            }
        }
    }
    return $new_grid;
}

function first($input) {
    $grid = [];

    $coord = reset($input);

    while (!empty($coord)) {
        $e = explode(',', $coord);
        if (!isset($grid[$e[0]])) {
            $grid[$e[0]] = [];
        }
        $grid[$e[0]][$e[1]] = TRUE;

        $coord = next($input);
    }

    $fold = next($input);

    if (substr($fold, 0, 13) == 'fold along x=') {
        $grid = fold($grid, 'x', substr($fold, 13));
    }
    else {
        $grid = fold($grid, 'y', substr($fold, 13));
    }

    $count = 0;
    foreach ($grid as $x => $v) {
        foreach ($v as $y => $t) {
            $count++;
        }
    }
    return $count;

}

function second($input) {
    $grid = [];

    $coord = reset($input);

    while (!empty($coord)) {
        $e = explode(',', $coord);
        if (!isset($grid[$e[0]])) {
            $grid[$e[0]] = [];
        }
        $grid[$e[0]][$e[1]] = TRUE;

        $coord = next($input);
    }

    while ($fold = next($input)) {
        if (substr($fold, 0, 13) == 'fold along x=') {
            $grid = fold($grid, 'x', substr($fold, 13));
        }
        else {
            $grid = fold($grid, 'y', substr($fold, 13));
        }
    }

    $max = [];
    foreach ($grid as $x => $v) {
        $k = array_keys($v);
        if (!empty($k)) {
          $max[] = max($k);
        }
    }
    $ymax = max($max);
    $max = max(array_keys($grid));

    for ($y = 0; $y <= $ymax; $y++) {
        for ($x = 0; $x <= $max; $x++) {
            if (isset($grid[$x][$y])) {
                print "#";
            }
            else {
                print " ";
            }
            }
        print "\n";
    }

    return TRUE;
}

test($sample_input, 'first', 17);
test($sample_input, 'second', TRUE);

print "First: " . first($input) . "\n";
print "Second: " . second($input) . "\n";
