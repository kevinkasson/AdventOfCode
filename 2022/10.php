<?php

include('common.php');

$input = getInput('10');
$sample_input = getSample('10');

function first($input) {
    $score = 0;

    foreach ($input as $k => $line) {
        $split = str_split($line);
        $stack = [];
        foreach ($split as $p => $char) {
            //print "$char at position $p\nStack:\n";
            //var_dump($stack);
            switch ($char) {
                case '(':
                case '[':
                case '{':
                case '<':
                    $stack[] = $char;
                    //print "Adding $char to stack\n";
                    break;
                case ')':
                    $pop = array_pop($stack);
                    if ($pop !== '(') {
                        //print "Line $k failed with $char position $p\n";
                        $score += 3;
                        continue 3;
                    }
                    break;
                case ']':
                    $pop = array_pop($stack);
                    if ($pop !== '[') {
                        //print "Line $k failed with $char position $p\n";
                        $score += 57;
                        continue 3;
                    }
                    break;
                case '}':
                    $pop = array_pop($stack);
                    if ($pop !== '{') {
                        //print "Line $k failed with $char position $p\n";
                        $score += 1197;
                        continue 3;
                    }
                    break;
                case '>':
                    $pop = array_pop($stack);
                    if ($pop !== '<') {
                        //print "Line $k failed with $char position $p\n";
                        $score += 25137;
                        continue 3;
                    }
                    break;
            }
        }
    }

    return $score;
}

function second($input) {
    $scores = [];

    foreach ($input as $k => $line) {
        $split = str_split($line);
        $stack = [];
        foreach ($split as $p => $char) {
            //print "$char at position $p\nStack:\n";
            //var_dump($stack);
            switch ($char) {
                case '(':
                case '[':
                case '{':
                case '<':
                    $stack[] = $char;
                    //print "Adding $char to stack\n";
                    break;
                case ')':
                    $pop = array_pop($stack);
                    if ($pop !== '(') {
                        //print "Line $k failed with $char position $p\n";
                        //$score += 3;
                        continue 3;
                    }
                    break;
                case ']':
                    $pop = array_pop($stack);
                    if ($pop !== '[') {
                        //print "Line $k failed with $char position $p\n";
                        //$score += 57;
                        continue 3;
                    }
                    break;
                case '}':
                    $pop = array_pop($stack);
                    if ($pop !== '{') {
                        //print "Line $k failed with $char position $p\n";
                        //$score += 1197;
                        continue 3;
                    }
                    break;
                case '>':
                    $pop = array_pop($stack);
                    if ($pop !== '<') {
                        //print "Line $k failed with $char position $p\n";
                        //$score += 25137;
                        continue 3;
                    }
                    break;
            }
        }

        $line_score = 0;
        while ($char = array_pop($stack)) {
            switch ($char) {
                case '(':
                    $line_score = ($line_score * 5) + 1;
                    break;
                case '[':
                    $line_score = ($line_score * 5) + 2;
                    break;
                case '{':
                    $line_score = ($line_score * 5) + 3;
                    break;
                case '<':
                    $line_score = ($line_score * 5) + 4;
                    break;
            }
        }
        $scores[] = $line_score;
    }

    sort($scores);

    return $scores[floor(count($scores) / 2)];
}

test($sample_input, 'first', 26397);
test($sample_input, 'second', 288957);

print "First: " . first($input) . "\n";
print "Second: " . second($input) . "\n";
