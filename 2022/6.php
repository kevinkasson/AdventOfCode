<?php

include('common.php');

$input = getInput('6');
$sample_input = getSample('6');


class LanternFish {

    public $timer;

    function __construct($timer) {
        global $id;

        $this->id = $id++;
        //print "Fish $id created\n";
        $this->timer = $timer;
    }

    function progress() {
        //print "Fish " . $this->id . " changing from " . $this->timer . " to ";
        $this->timer--;
        if ($this->timer < 0) {
            $this->timer = 6;
            return new LanternFish(8);
        }
        //print $this->timer . "\n";
        return FALSE;
    }
}

function first($input, $days) {
    global $id;
    $id = 0;
    $e = explode(',', $input[0]);
    $fish = [];
    foreach ($e as $l) {
        $fish[] = new LanternFish($l);
    }
    for ($i = 1; $i <= $days; $i++) {
        // print "Day $i\n";
        $keys = array_keys($fish);
        foreach ($keys as $key) {
            if ($new_fish = $fish[$key]->progress()) {
                $fish[] = $new_fish;
                //print "Created fish " . count($fish) . "\n";
            }
        }
    }
    return count($fish);

}

function second($input, $days) {
    $e = explode(',', $input[0]);
    $fish = [0,0,0,0,0,0,0,0,0];
    foreach ($e as $l) {
        $fish[$l] += 1;
    }
    for ($day = 1; $day <= $days; $day++) {
        $add = $fish[0];
        for ($i = 0; $i < 8; $i++) {
            $fish[$i] = $fish[$i+1];
        };
        $fish[6] += $add;
        $fish[8] = $add;
    }
    return array_sum($fish);
}

test($sample_input, 'first', 26, 18);
test($sample_input, 'first', 5934, 80);
test($sample_input, 'second', 26984457539, 256);

print "First: " . first($input, 80) . "\n";
print "Second: " . second($input, 256) . "\n";
