<?php

include('common.php');

$input = getInput('9');
$sample_input = getSample('9');

function first($input) {
    $map = [];

    foreach ($input as $y => $line) {
        foreach (str_split($line) as $x => $char) {
            if (!isset($map[$x])) {
                $map[$x] = [];
            }
            $map[$x][$y] = $char;
        }
    }

    $sum = 0;

    for ($i = 0; $i <= $x; $i++) {
        for ($j = 0; $j <= $y; $j++) {
            $low = TRUE;
            $v = $map[$i][$j];
            if (
                (isset($map[$i - 1][$j])) &&
                ($v >= $map[$i - 1][$j])
            ) {
                $low = FALSE;
            }
            if (
                (isset($map[$i + 1][$j])) &&
                ($v >= $map[$i + 1][$j])
            ) {
                $low = FALSE;
            }
            if (
                (isset($map[$i][$j - 1])) &&
                ($v >= $map[$i][$j - 1])
            ) {
                $low = FALSE;
            }
            if (
                (isset($map[$i][$j + 1])) &&
                ($v >= $map[$i][$j + 1])
            ) {
                $low = FALSE;
            }

            if ($low) {
                $sum += $v+1;
            }
        
        }
    }
    return $sum;
}

function second($input) {
    
    $basin_id = 1;

    $basin_sizes = [];

    $map = [];

    foreach ($input as $y => $line) {
        foreach (str_split($line) as $x => $char) {
            if (!isset($map[$x])) {
                $map[$x] = [];
            }
            $map[$x][$y] = [
                'height' => $char,
                'basin' => NULL
            ];
        }
    }

    for ($i = 0; $i <= $x; $i++) {
        for ($j = 0; $j <= $y; $j++) {
            $low = TRUE;
            $v = $map[$i][$j]['height'];
            if (
                (isset($map[$i - 1][$j]['height'])) &&
                ($v >= $map[$i - 1][$j]['height'])
            ) {
                $low = FALSE;
            }
            if (
                (isset($map[$i + 1][$j]['height'])) &&
                ($v >= $map[$i + 1][$j]['height'])
            ) {
                $low = FALSE;
            }
            if (
                (isset($map[$i][$j - 1]['height'])) &&
                ($v >= $map[$i][$j - 1]['height'])
            ) {
                $low = FALSE;
            }
            if (
                (isset($map[$i][$j + 1]['height'])) &&
                ($v >= $map[$i][$j + 1]['height'])
            ) {
                $low = FALSE;
            }

            if ($low) {
                $basin_sizes[$basin_id] = 1;
                $map[$i][$j]['basin'] = $basin_id++;
            }
        
        }
    }

    do {
        $changed = FALSE;

        for ($i = 0; $i <= $x; $i++) {
            for ($j = 0; $j <= $y; $j++) {
                $basin = $map[$i][$j]['basin'];
                if (empty($basin)) {
                    continue;
                }
                if (
                    (isset($map[$i - 1][$j]['height'])) &&
                    ($map[$i - 1][$j]['height'] != '9') &&
                    ($map[$i - 1][$j]['basin'] != $basin)
                ) {
                    $map[$i - 1][$j]['basin'] = $basin;
                    $basin_sizes[$basin]++;
                    $changed = TRUE;
                }
                if (
                    (isset($map[$i + 1][$j]['height'])) &&
                    ($map[$i + 1][$j]['height'] != '9') &&
                    ($map[$i + 1][$j]['basin'] != $basin)
                ) {
                    $map[$i + 1][$j]['basin'] = $basin;
                    $basin_sizes[$basin]++;
                    $changed = TRUE;
                }
                if (
                    (isset($map[$i][$j - 1]['height'])) &&
                    ($map[$i][$j - 1]['height'] != '9') &&
                    ($map[$i][$j - 1]['basin'] != $basin)
                ) {
                    $map[$i][$j - 1]['basin'] = $basin;
                    $basin_sizes[$basin]++;
                    $changed = TRUE;
                }
                if (
                    (isset($map[$i][$j + 1]['height'])) &&
                    ($map[$i][$j + 1]['height'] != '9') &&
                    ($map[$i][$j + 1]['basin'] != $basin)
                ) {
                    $map[$i][$j + 1]['basin'] = $basin;
                    $basin_sizes[$basin]++;
                    $changed = TRUE;
                }
            
            }
        }

        for ($i = 0; $i <= $y; $i++) {
            for ($j = 0; $j <= $x; $j++) {
                print ($map[$j][$i]['height'] === '9' ? 'x' : ($map[$j][$i]['basin'] ? 'o' : '.'));
            }
            print "\n";
        }
        print "\n";
        
    } while ($changed);

    rsort($basin_sizes);

    return $basin_sizes[0] * $basin_sizes[1] * $basin_sizes[2];
}

test($sample_input, 'first', 15);
test($sample_input, 'second', 1134);

print "First: " . first($input) . "\n";
print "Second: " . second($input) . "\n";
