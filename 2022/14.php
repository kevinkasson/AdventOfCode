<?php

include('common.php');

$input = getInput('14');
$sample_input = getSample('14');

function first($input, $steps) {

    $replacements = [];
    
    $string = reset($input);
    next($input); // Skip blank line
    
    while ($line = next($input)) {
        $e = explode(' -> ', $line);
        $replacements[$e[0]] = $e[1];
    }

    $step = 0;
    while ($step < $steps) {
        $new_string = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $s = substr($string, $i, 2);
            $new_string .= substr($s, 0, 1);
            if (isset($replacements[$s])) {
                $new_string .= $replacements[$s];
            }
        }

        $string = $new_string;


        $step++;
    }

    $counts = array_count_values(str_split($string));
    return max($counts) - min($counts);
}

function second($input, $steps) {
    $replacements = [];
    
    $string = reset($input);
    next($input); // Skip blank line
    
    while ($line = next($input)) {
        $e = explode(' -> ', $line);
        $replacements[$e[0]] = $e[1];
    }

    $step = 0;
    $pairs = [];
    for ($i = 0; $i < strlen($string) - 1; $i++) {
        $s = substr($string, $i, 2);
        if (!isset($pairs[$s])) {
            //print "$s is not set, setting to 1\n";
            $pairs[$s] = 0;
        }
        $pairs[$s]++;
    }
    while ($step < $steps) {
        $current_pairs = $pairs;
        foreach ($current_pairs as $s => $count) {
            $pairs[$s] -= $count;
           
            if (isset($replacements[$s])) {
                if (!isset($pairs[substr($s,0,1) . $replacements[$s]])) {
                    $t = substr($s,0,1) . $replacements[$s];
                    //print "$t is not set, setting to 0\n";
                    $pairs[substr($s,0,1) . $replacements[$s]] = 0;
                }
                //print "Got " . substr($s,0,1) . $replacements[$s] . "\n";
                $pairs[substr($s,0,1) . $replacements[$s]]+=$count;
                if (!isset($pairs[$replacements[$s] . substr($s,1,1)])) {
                    $t = $replacements[$s] . substr($s,1,1);
                    //print "$t is not set, setting to 0\n";
                    $pairs[$replacements[$s] . substr($s,1,1)] = 0;
                }
                //print "Got " . $replacements[$s] . substr($s,1,1) . "\n";
                $pairs[$replacements[$s] . substr($s,1,1)]+=$count;
            }
        }
        //print "\n\n";
        $step++;
        //var_dump($pairs);
/*        $counts = [];
        foreach ($pairs as $pair => $count) {
            //var_dump($pair);
            if (!isset($counts[substr($pair, 0, 1)])) {
                print substr($pair, 0, 1) . " not set\n";
                $counts[substr($pair, 0, 1)] = 0;
            }
            $counts[substr($pair, 0, 1)] += $count;
            print substr($pair, 0, 1) . " + 1 = " . $counts[substr($pair,0,1)] . "\n";
            if (!isset($counts[substr($pair, 1, 1)])) {
                print substr($pair, 1, 1) . " not set\n";
                $counts[substr($pair, 1, 1)] = 0;
            }
            $counts[substr($pair, 1, 1)] += $count;
            print substr($pair, 1, 1) . " + 1 = " . $counts[substr($pair,1,1)] . "\n";
        }
        print "\n\n";
        var_dump($counts);*/
    }

    $counts = [];
    foreach ($pairs as $pair => $count) {
        if (!isset($counts[substr($pair, 0, 1)])) {
            $counts[substr($pair, 0, 1)] = 0;
        }
        $counts[substr($pair, 0, 1)] += $count;
        if (!isset($counts[substr($pair, 1, 1)])) {
            $counts[substr($pair, 1, 1)] = 0;
        }
        $counts[substr($pair, 1, 1)] += $count;
    }
    $counts[substr($string, 0, 1)]++;
    $counts[substr($string, -1)]++;
    foreach ($counts as &$c) {
        $c = $c / 2;
    }


    return max($counts) - min($counts);
}

test($sample_input, 'first', 1588, 10);
test($sample_input, 'second', 2188189693529, 40);

print "First: " . first($input, 10) . "\n";
print "Second: " . second($input, 40) . "\n";
