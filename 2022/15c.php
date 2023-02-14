<?php
set_time_limit(0);
$mcstart = microtime(true);
echo "<pre>\n";
$input = trim(str_replace("\r","",file_get_contents("inputs/15")));

//create lines array
$lines = explode("\n",$input);
$cavern = [];
$max_rows = sizeof($lines);
$max_cols = strlen($lines[0]);
for($y=0;$y<5;$y++) {
	for($x=0;$x<5;$x++) {
		for($r=0;$r<$max_rows;$r++) {
			for($c=0;$c<$max_cols;$c++) {
				$value = ((int)$lines[$r][$c] + $x + $y) % 9;
				if($value == 0) $value = 9;
				$cavern[$r+($max_cols*$y)][$c+($max_rows*$x)] = $value;
				$risk[$r+($max_cols*$y)][$c+($max_rows*$x)] = PHP_INT_MAX;
			}
		}
	}
}
/*
foreach($cavern as $row) {
	echo implode("", $row) . "\n";
}
*/
//ignore initial square
$risk[0][0] = 0;
//reset these now cavern is 5*5 times larger
$max_rows = sizeof($cavern)-1;
$max_cols = sizeof($cavern[0])-1;

$queue = [[0,0]];

while(sizeof($queue)) {
	[$r, $c] = array_shift($queue);
	//up
	if(isset($cavern[$r-1][$c]) && $risk[$r-1][$c] > ($risk[$r][$c] + $cavern[$r-1][$c])) {
		$queue[] = [$r-1,$c];
		$risk[$r-1][$c] = $risk[$r][$c] + $cavern[$r-1][$c];
	}
	//down
	if(isset($cavern[$r+1][$c]) && $risk[$r+1][$c] > ($risk[$r][$c] + $cavern[$r+1][$c])) {
		$queue[] = [$r+1,$c];
		$risk[$r+1][$c] = $risk[$r][$c] + $cavern[$r+1][$c];
	}
	//left
	if(isset($cavern[$r][$c-1]) && $risk[$r][$c-1] > ($risk[$r][$c] + $cavern[$r][$c-1])) {
		$queue[] = [$r,$c-1];
		$risk[$r][$c-1] = $risk[$r][$c] + $cavern[$r][$c-1];
	}
	//down
	if(isset($cavern[$r][$c+1]) && $risk[$r][$c+1] > ($risk[$r][$c] + $cavern[$r][$c+1])) {
		$queue[] = [$r,$c+1];
		$risk[$r][$c+1] = $risk[$r][$c] + $cavern[$r][$c+1];
	}
}

echo "Part 2: " . $risk[$max_rows][$max_cols];

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";