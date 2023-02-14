<?php

function test($input, $function, $result, ...$extraInputs) {
	$actual = call_user_func_array($function, array_merge([$input], $extraInputs));
	if ($actual !== $result) {
		die($function . " failed, expected $result, got $actual\n");
	}
	print $function . " succeeded, expected $result, got $result\n";
}

function getInput($d) {
	return array_map('trim', file('inputs/' . $d));
}

function getSample($d) {
	return array_map('trim', file('inputs/sample/' . $d));
}
