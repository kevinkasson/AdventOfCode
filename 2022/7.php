<?php

include('common.php');

$input = getInput('7');
$sample_input = getSample('7');

function first($input) {
  $e = explode(',', reset($input));

  $fuels = [];
  for ($i = 0; $i <= max($e); $i++) {
      $fuel = 0;
      foreach ($e as $pos) {
          $fuel += abs($i - $pos);
      }
      $fuels[$i] = $fuel;
  }

  return min($fuels);
}

function second($input) {
    $e = explode(',', reset($input));

    $fuels = [];
    for ($i = 0; $i <= max($e); $i++) {
        $fuel = 0;
        foreach ($e as $pos) {
            $n = abs($i - $pos);
            $fuel += ($n * ($n + 1) / 2);
        }
        $fuels[$i] = $fuel;
    }
  
    return min($fuels);  
}

test($sample_input, 'first', 37);
test($sample_input, 'second', 168);

print "First: " . first($input) . "\n";
print "Second: " . second($input) . "\n";
