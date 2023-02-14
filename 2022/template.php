<?php

include('common.php');

$input = getInput('x');
$sample_input = getSample('x');

function first($input) {
}

function second($input) {

}

test($sample_input, 'first', x);
//test($sample_input, 'second', x);

print "First: " . first($input) . "\n";
//print "Second: " . second($input) . "\n";