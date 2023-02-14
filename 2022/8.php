<?php

include('common.php');

$input = getInput('8');
$sample_input = getSample('8');

function first($input) {
    $unique = 0;
    foreach ($input as $line) {
        $e = explode(' | ', $line);
        $outputs = explode(' ', $e[1]);

        foreach ($outputs as $output) {
            $len = strlen($output);

            if (
                ($len === 2) ||
                ($len === 4) ||
                ($len === 3) ||
                ($len === 7)
            ) {
                $unique++;
            }
        }
    }
    return $unique;
}

function permute($str,$i,$n) {
    $results = [];
    if ($i == $n)
        return [$str];
    else {
         for ($j = $i; $j < $n; $j++) {
           swap($str,$i,$j);
           $results = array_merge($results, permute($str, $i+1, $n));
           swap($str,$i,$j);
        }
    }
    return $results;
 }
 
 function swap(&$str,$i,$j) {
     $temp = $str[$i];
     $str[$i] = $str[$j];
     $str[$j] = $temp;
 }   

function second($input) {
    $digits = [
        'abcefg' => 0,
        'cf' => 1,
        'acdeg' => 2,
        'acdfg' => 3,
        'bcdf' => 4,
        'abdfg' => 5,
        'abdefg' => 6,
        'acf' => 7,
        'abcdefg' => 8,
        'abcdfg' => 9
    ];

    $str = "abcdefg";
    $perms = permute($str,0,strlen($str));

    $sum = 0;
    foreach ($input as $line) {
        $e = explode(' | ', $line);
        $inputs = explode(' ', $e[0]);
        $outputs = explode(' ', $e[1]);
        $output_display = '';

        foreach ($perms as $k => $p) {
            $map = array_combine(str_split($p), ['a','b','c','d','e','f','g']);
            //var_dump($map);
            foreach ($inputs as $display) {
                $split = str_split($display);
                $word = '';
                foreach ($split as $char) {
                    $word .= $map[$char];
                }
                //print "$display becomes $word\n";

                $s = str_split($word);
                sort($s);
                $word = implode($s);

                if (!in_array($word, array_keys($digits))) {
                    continue 2;
                }
            }
            //We have our mapping, apply to each output
            //var_dump($map);
            foreach ($outputs as $output) {
                $split = str_split($output);
                $word = '';
                foreach ($split as $char) {
                    $word .= $map[$char];
                }
                $s = str_split($word);
                sort($s);
                $word = implode($s);
                //print $word . "\n";
                $output_display .= $digits[$word];
            }
        }
        $sum += $output_display;

    }
    return $sum;
}

//second(['acedgfb cdfbe gcdfa fbcad dab cefabd cdfgeb eafb cagedb ab | cdfeb fcadb cdfeb cdbaf']);
test($sample_input, 'first', 26);
test($sample_input, 'second', 61229);

print "First: " . first($input) . "\n";
print "Second: " . second($input) . "\n";
