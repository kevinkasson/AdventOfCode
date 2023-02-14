<?php

include('common.php');

$input = getInput('12');
$sample_input = getSample('12');
$sample_input2 = getSample('12-2');
$sample_input3 = getSample('12-3');

function navigate($p, $paths, $chain, $day_two = FALSE) {
    //print "Checking $chain + $p\n";
    if ($p === 'start') {
        return FALSE;
    }
    if ($p === 'end') {
        return [$chain . ',end'];
    }
    if ($day_two) {
        $chain = $chain . ',' . $p;
        $explode_chain = explode(',', $chain);
        $counts = array_count_values($explode_chain);
        $has_two = FALSE;
        foreach ($counts as $letter => $count) {
            if ($letter === strtolower($letter)) {
                if ($count > 2) {
                    return FALSE;
                }
                if ($count > 1) {
                    if ($has_two) {
                        return FALSE;
                    }
                    $has_two = TRUE;
                }
            }            
        }
    }
    else {
        if ($p === strtolower($p)) {
            $explode_chain = explode(',', $chain);
            if (in_array($p, $explode_chain)) {
                return FALSE;
            }
        }
        $chain = $chain . ',' . $p;
    }
    $options = [];
    //print "Branching off $chain\n";
    foreach ($paths[$p] as $option) {
        if ($merge = navigate($option, $paths, $chain, $day_two)) {
          $options = array_merge($options, $merge);
        }
    }
    return $options;

}

function first($input) {
    $paths = [];

    foreach ($input as $path) {
        $e = explode('-', $path);
        $paths[$e[0]][] = $e[1];
        $paths[$e[1]][] = $e[0];
    }

    $options = [];
    foreach ($paths['start'] as $next) {
        if ($merge = navigate($next, $paths, 'start')) {
            $options = array_merge($options, $merge);
        }
    }
    return count(array_unique($options));

}

function second($input) {
    $paths = [];

    foreach ($input as $path) {
        $e = explode('-', $path);
        $paths[$e[0]][] = $e[1];
        $paths[$e[1]][] = $e[0];
    }

    $options = [];
    foreach ($paths['start'] as $next) {
        $options = array_merge($options, navigate($next, $paths, 'start', TRUE));
    }
    foreach ($options as &$option) {
        //print $option . "\n";
    }
    return count(array_unique($options));
}

test($sample_input, 'first', 10);
test($sample_input2, 'first', 19);
test($sample_input3, 'first', 226);
test($sample_input, 'second', 36);
test($sample_input2, 'second', 103);
test($sample_input3, 'second', 3509);

print "First: " . first($input) . "\n";
print "Second: " . second($input) . "\n";
