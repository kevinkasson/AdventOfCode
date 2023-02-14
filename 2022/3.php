<?php

include('common.php');

$input = getInput('3');
$sample_input = getSample('3');

function first($input) {
	foreach ($input as $n) {
		for ($i = 0; $i < strlen($n); $i++) {
			$results[$i][substr($n, $i, 1)] = ($results[$i][substr($n, $i, 1)] ?? 0) + 1;
		}
	}

	$gamma = $epsilon = 0;
	$len = count($results);
	foreach ($results as $bit_position => $bits) {
		if ($bits['1'] > $bits['0']) {
			$gamma += (pow(2,$len - $bit_position - 1));
		}
		else {
			$epsilon += (pow(2,$len - $bit_position - 1));
		}
	}
	return $gamma * $epsilon;
}

function second($input) {
	$len = strlen(reset($input));
	$oxygen_input = $input;
	$co2_input = $input;
	for ($i = 0; $i < $len; $i++) {
		$oxygen_results = ['1' => 0, '0' => 0];
		$co2_results = ['1' => 0, '0' => 0];
		foreach ($oxygen_input as $n) {
			$oxygen_results[substr($n, $i, 1)] += 1;
		}
		foreach ($co2_input as $n) {
			$co2_results[substr($n, $i, 1)] += 1;
		}
		if (count($oxygen_input) > 1) {
			if ($oxygen_results['1'] >= $oxygen_results['0']) {
				foreach ($oxygen_input as &$v) {
					if (substr($v, $i, 1) != '1') {
						$v = NULL;
					}
				}
			}
			else {
				foreach ($oxygen_input as &$v) {
					if (substr($v, $i, 1) != '0') {
						$v = NULL;
					}
				}
			}
		}
		if (count($co2_input) > 1) {
			if ($co2_results['0'] <= $co2_results['1']) {
				foreach ($co2_input as &$v) {
					if (substr($v, $i, 1) != '0') {
						$v = NULL;
					}
				}
			}
			else {
				foreach ($co2_input as &$v) {
					if (substr($v, $i, 1) != '1') {
						$v = NULL;
					}
				}
			}
		}

		$oxygen_input = array_filter($oxygen_input);
		$co2_input = array_filter($co2_input);
	}

	$oxygen_result = reset($oxygen_input);
	$co2_result = reset($co2_input);
	$oxygen = $co2 = 0;
	for ($i = 0; $i < $len; $i++) {
		if (substr($oxygen_result,$i,1) == '1') {
			$oxygen += (pow(2,$len - $i - 1));
		}
		if (substr($co2_result,$i,1) == '1') {
			$co2 += (pow(2,$len - $i - 1));
		}
	}
	return $oxygen * $co2;
}

test($sample_input, 'first', 198);
test($sample_input, 'second', 230);

print "First: " . first($input) . "\n";
print "Second: " . second($input) . "\n";