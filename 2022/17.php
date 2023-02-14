<?php

include('common.php');

$input = getInput('17');
$sample_input = getSample('17');

function first($input) {
    $e = explode(',', substr(reset($input), 15));
    $ex = explode('..', $e[0]);
    $x_target_low = min($ex[0], $ex[1]);
    $x_target_high = max($ex[0], $ex[1]);
    $ey = explode('..', substr($e[1],3));
    $y_target_low = min($ey[0], $ey[1]);
    $y_target_high = max($ey[0], $ey[1]);

    $final_y_max = 0;
    for ($sx = -1*abs($x_target_high) * 2; $sx <= abs($x_target_high) * 2; $sx++) {
        for ($sy= -1*abs($y_target_high) * 2; $sy <= abs($y_target_high) * 2; $sy++) {
            $y_max = 0;
            $x = $y = 0;
            $x_velocity = $sx;
            $y_velocity = $sy;
            $in_target = FALSE;
            do {
                $continue = ($y > $y_target_low) || (($y_target_low - ($y + $y_velocity)) < ($y_target_low - ($y)));
                $x += $x_velocity;
                $y += $y_velocity;

                if ($x_velocity < 0) {
                    $x_velocity++;
                }
                if ($x_velocity > 0) {
                    $x_velocity--;
                }
                $y_velocity-=1;

                if ($x >= $x_target_low && $x <= $x_target_high && $y >= $y_target_low && $y <= $y_target_high) {
                    $in_target = TRUE;
                }

                if ($y > $y_max) {
                    $y_max = $y;
                }

            } while ($continue);
            if ($in_target) {
                if ($y_max > $final_y_max) {
                    $final_y_max = $y_max;
                }
            }
        }
    }

    return $final_y_max;
}

function second($input) {
    
    $e = explode(',', substr(reset($input), 15));
    $ex = explode('..', $e[0]);
    $x_target_low = min($ex[0], $ex[1]);
    $x_target_high = max($ex[0], $ex[1]);
    $ey = explode('..', substr($e[1],3));
    $y_target_low = min($ey[0], $ey[1]);
    $y_target_high = max($ey[0], $ey[1]);

    $count = 0;
    for ($sx = -1*abs($x_target_high) * 2; $sx <= abs($x_target_high) * 2; $sx++) {
        for ($sy= -1*abs($y_target_high) * 2; $sy <= abs($y_target_high) * 2; $sy++) {
            $x = $y = 0;
            $x_velocity = $sx;
            $y_velocity = $sy;
            do {
                $continue = ($y > $y_target_low) || (($y_target_low - ($y + $y_velocity)) < ($y_target_low - ($y)));
                $x += $x_velocity;
                $y += $y_velocity;

                if ($x_velocity < 0) {
                    $x_velocity++;
                }
                if ($x_velocity > 0) {
                    $x_velocity--;
                }
                $y_velocity-=1;

                if ($x >= $x_target_low && $x <= $x_target_high && $y >= $y_target_low && $y <= $y_target_high) {
                    $count++;
                    break;
                }
            } while ($continue);
        }
    }

    return $count;
}

test($sample_input, 'first', 45);
test($sample_input, 'second', 112);

print "First: " . first($input) . "\n";
print "Second: " . second($input) . "\n";
