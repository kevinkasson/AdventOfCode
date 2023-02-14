<?php

include('common.php');

$input = getInput('1');
$sample_input = getSample('1');

function first($input) {
	$increases = 0;
	foreach ($input as $k => $i) {
		if (isset($input[$k - 1])) {
			if ($i > $input[$k -1]) {
				$increases++;
			}
		}
	}
	return $increases;
}

function second($input) {
	$increases = 0;
	foreach ($input as $k => $i) {
		if (isset($input[$k - 1])) {
			if (isset($input[$k - 2])) {
				if (isset($input[$k - 3])) {
					$b = $i + $input[$k - 1] + $input[$k - 2];
					$a = $input[$k - 1] + $input[$k - 2] + $input[$k - 3];
					if ($b > $a) {
						$increases++;
					}
				}
			}
		}
	}
	return $increases;
}

test($sample_input, 'first', 7);
test($sample_input, 'second', 5);

print "First: " . first($input) . "\n";
print "Second: " . second($input) . "\n";
