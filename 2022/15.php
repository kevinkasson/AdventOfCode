<?php

include('common.php');

$input = getInput('15');
$sample_input = getSample('15');

function first($input) {

    $nodes = $risks =$path = [];
    foreach ($input as $y => $line) {
        $risks[$y] = [];
        $nodes[$y] = [];
        foreach (str_split($line) as $x => $risk) {
          $risks[$y][$x] = $risk;
          $nodes[$y][$x] = ['risk' => INF, 'visited' => FALSE];
        }
    }
    $ymax = $y;
    $xmax = $x;

    $nodes[0][0]['risk'] = 0;

    $x = 0;
    $y = 0;

    while ($nodes[$ymax][$xmax]['risk'] == INF) {
        $nodes[$y][$x]['visited'] = TRUE;

            if (isset($nodes[($y - 1)][$x]) && !$nodes[$y-1][$x]['visited']) {
                $existing = $nodes[$y-1][$x]['risk'];
                $new = $nodes[$y][$x]['risk'] + $risks[$y-1][$x];
                if ($new < $existing) {
                    $nodes[$y-1][$x]['risk'] = $new;
                }
            }
            if (isset($nodes[($y + 1)][$x]) && !$nodes[$y+1][$x]['visited']) {
                $existing = $nodes[$y+1][$x]['risk'];
                $new = $nodes[$y][$x]['risk'] + $risks[$y+1][$x];
                if ($new < $existing) {
                    $nodes[$y+1][$x]['risk'] = $new;
                }
            }
            if (isset($nodes[$y][($x - 1)]) && !$nodes[$y][$x-1]['visited']) {
                $existing = $nodes[$y][$x-1]['risk'];
                $new = $nodes[$y][$x]['risk'] + $risks[$y][$x-1];
                if ($new < $existing) {
                    $nodes[$y][$x-1]['risk'] = $new;
                }
            }
            if (isset($nodes[$y][($x + 1)]) && !$nodes[$y][$x+1]['visited']) {
                $existing = $nodes[$y][$x+1]['risk'];
                $new = $nodes[$y][$x]['risk'] + $risks[$y][$x+1];
                if ($new < $existing) {
                    $nodes[$y][$x+1]['risk'] = $new;
                }
            }

            $min = INF;
            foreach ($nodes as $_y => $col) {
                foreach ($col as $_x => $node) {
                    if (!$node['visited']) {
                        if ($node['risk'] < $min) {
                            $min = $node['risk'];
                            $x = $_x;
                            $y = $_y;
                        }
                    }
                }
            }
    }
    return $nodes[$ymax][$xmax]['risk'];
}

function second($input) {
    $new_input = [];
    foreach ($input as $count => $line) {
        $output = ['','','','','',''];
        foreach (str_split($line) as $risk) {
            for ($i = 0; $i < 5; $i++) {
                $new = $risk + $i;
                if ($new > 9) {
                    $new -= 9;
                }
                $output[$i] .= $new;
            }
        }
        $new_input[] = implode('', $output);
    }
    $count++;
    $line_buffer = [];
    for ($i = 0; $i < 5 * $count; $i++) {
        $line_buffer[$i] = '';
    }
    foreach ($new_input as $k => $line) {
            foreach (str_split($line) as $risk) {
                for ($i = 0; $i < 5; $i++) {
                    $new = $risk + $i;
                    if ($new > 9) {
                        $new -= 9;
                    }
                    $line_buffer[$k + ($count * $i)] .= $new;    
                }
            }
    }
    return first($line_buffer);

}

test($sample_input, 'first', 40);
test($sample_input, 'second', 315);

print "First: " . first($input) . "\n";
print "Second: " . second($input) . "\n";
