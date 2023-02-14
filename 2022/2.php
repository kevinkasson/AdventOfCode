<?php

include('common.php');

$input = getInput('2');
$sample_input = getSample('2');

function first($input) {
	$h = 0;
	$v = 0;
	foreach ($input as $k => $i) {
		$e = explode(' ', $i);
		switch ($e[0]) {
			case 'forward':
	    		$h += $e[1];
	    		break;
    		case 'up':
	   			$v -= $e[1];
	    		break;
    		case 'down':
	   			$v += $e[1];
	   			break;
  		}
	}
	return $v * $h;
}

function second($input) {
	$h = 0;
	$d = 0;
	$aim = 0;
	foreach ($input as $k => $i) {
		$e = explode(' ', $i);
		switch ($e[0]) {
		case 'forward':
	    	$h += $e[1];
	    	$d += $aim * $e[1];
	    	break;
    	case 'up':
	   		$aim -= $e[1];
	    	break;
    	case 'down':
	    	$aim += $e[1];
	    	break;
  		}
	}
  	return $d * $h;
}

test($sample_input, 'first', 150);
test($sample_input, 'second', 900);

print "First: " . first($input) . "\n";
print "Second: " . second($input) . "\n";
