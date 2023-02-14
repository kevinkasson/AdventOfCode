<?php

include('common.php');

$input = getInput('11');
$sample_input = getSample('11');

class Octopus {

    protected $timer;
    protected $triggered;
    protected $flash;

    public $i;
    public $j;

    public function __construct($n, $i, $j) {
        $this->timer = $n;
        $this->triggered = FALSE;
        $this->flash = FALSE;

        $this->i = $i;
        $this->j = $j;
    }

    public function checkFlash($grid) {
        if ($this->timer > 9 && !$this->flash) {
            //print $this->i . ',' . $this->j . " flashing\n";
            $this->flash = TRUE;

            $i = $this->i;
            $j = $this->j;

            $adjacents = array_filter([
                $grid[$i - 1][$j - 1] ?? NULL,
                $grid[$i - 1][$j] ?? NULL,
                $grid[$i - 1][$j + 1] ?? NULL,
                $grid[$i][$j - 1] ?? NULL,
                $grid[$i][$j + 1] ?? NULL,
                $grid[$i + 1][$j - 1] ?? NULL,
                $grid[$i + 1][$j] ?? NULL,
                $grid[$i + 1][$j + 1] ?? NULL,
            ]);

            /*print "My coords $i,$j\n";
            print ($i-1) . ',' . ($j-1) . "\n";
            print ($i-1) . ',' . ($j) . "\n";
            print ($i-1) . ',' . ($j+1) . "\n";
            print ($i) . ',' . ($j-1) . "\n";
            print "ME\n";
            print ($i) . ',' . ($j+1) . "\n";
            print ($i+1) . ',' . ($j-1) . "\n";
            print ($i+1) . ',' . ($j) . "\n";
            print ($i+1) . ',' . ($j+1) . "\n";*/


            foreach ($adjacents as $o) {
                //print "Increasing timer for " . $o->i . ',' . $o->j . "\n";
                $o->increaseTimer();
            }
            
            foreach ($adjacents as $o) {
                $o->checkFlash($grid);
            }
        }
    }

    public function isFlash() {
        return $this->flash;
    }

    public function resetTimer() {
        if ($this->timer > 9) {
            $this->timer = 0;
        }
        $this->flash = FALSE;
    }

    public function increaseTimer() {
        $this->timer++;
    }

    public function getTimer() {
        return $this->timer;
    }

}

function first($input, $steps) {

    $count = 0;

    foreach ($input as $i => $line) {
        $split = str_split($line);
        foreach ($split as $j => $n) {
            $grid[$i][$j] = new Octopus($n, $i, $j);
        }
    }

    while ($steps > 0) {
        foreach ($grid as $i => $line) {
            foreach ($line as $j => $o) {
                $o->increaseTimer();
                //print $o->getTimer() % 10;
            }
            //print "\n";
        }

        foreach ($grid as $i => $line) {
            foreach ($line as $j => $o) {
                $o->checkFlash($grid, $i, $j);
            }
        }

        foreach ($grid as $i => $line) {
            foreach ($line as $j => $o) {
                if ($o->isFlash()) {
                    $count++;
                }
                $o->resetTimer();
            }
        }

        $steps--;
    }

    foreach ($grid as $i => $line) {
        foreach ($line as $j => $o) {
            //print $o->getTimer() % 10;
        }
        //print "\n";
    }

    return $count;
}

function second($input) {

    $steps = 1;

    foreach ($input as $i => $line) {
        $split = str_split($line);
        foreach ($split as $j => $n) {
            $grid[$i][$j] = new Octopus($n, $i, $j);
        }
    }

    while (1) {
        foreach ($grid as $i => $line) {
            foreach ($line as $j => $o) {
                $o->increaseTimer();
                //print $o->getTimer() % 10;
            }
            //print "\n";
        }

        foreach ($grid as $i => $line) {
            foreach ($line as $j => $o) {
                $o->checkFlash($grid, $i, $j);
            }
        }

        $finished = TRUE;
        foreach ($grid as $i => $line) {
            foreach ($line as $j => $o) {
                if (!$o->isFlash()) {
                    $finished = FALSE;
                }
                $o->resetTimer();
            }
        }

        if ($finished) {
          return $steps;
        }
        $steps++;
    }

}

test($sample_input, 'first', 0, 1);
test($sample_input, 'first', 35, 2);
test($sample_input, 'first', 204, 10);
test($sample_input, 'first', 1656, 100);
test($sample_input, 'second', 195);

print "First: " . first($input, 100) . "\n";
print "Second: " . second($input) . "\n";
