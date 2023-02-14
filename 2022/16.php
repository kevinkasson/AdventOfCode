<?php

include('common.php');

$input = getInput('16');
$sample_input = getSample('16');

function parseBinary($input) {
    $binary = '';
    foreach (str_split($input) as $hex) {
        switch ($hex) {
            case '0':
                $binary .= '0000';
                break;
            case '1':
                $binary .= '0001';
                break;
            case '2':
                $binary .= '0010';
                break;
            case '3':
                $binary .= '0011';
                break;
            case '4':
                $binary .= '0100';
                break;
            case '5':
                $binary .= '0101';
                break;
            case '6':
                $binary .= '0110';
                break;
            case '7':
                $binary .= '0111';
                break;
            case '8':
                $binary .= '1000';
                break;
            case '9':
                $binary .= '1001';
                break;
            case 'A':
                $binary .= '1010';
                break;
            case 'B':
                $binary .= '1011';
                break;
            case 'C':
                $binary .= '1100';
                break;
            case 'D':
                $binary .= '1101';
                break;
            case 'E':
                $binary .= '1110';
                break;
            case 'F':
                $binary .= '1111';
                break;
        }
    }
    return $binary;
}

function parsePackets($binary, $max = NULL) {
    //print "Beginning parse on $binary\n";
    if (is_null($max)) {
      $max = strlen($binary);
    }
    $packets = [];
    $position = 0;
    while (($position < strlen($binary) - 6) && count($packets) < $max) {
        $version = bindec(substr($binary, $position, 3));
        $position += 3;
        $type = bindec(substr($binary, $position, 3));
        $position += 3;
        if ($type === 4) { // Literal packet
            //print "Literal packet\n";
            $number = '';
            $continue = '1';
            while ($continue === '1') {
                $group = substr($binary, $position, 5);
                $number .= substr($group, 1);
                $continue = substr($group, 0, 1);
                $position += 5;
            }
            var_dump($number);
            $number = bindec($number);
            $packets[] = ['version' => $version, 'type' => $type, 'literal' => $number];
        }
        else { // Operator packet
            $length_type_id = bindec(substr($binary, $position, 1));
            $position++;
            //print "Operator packet\n";
            if ($length_type_id === 0) {
                $length = bindec(substr($binary, $position, 15));
                $position+=15;
                //print "15 bit type, length is $length\n";
                $subpackets = parsePackets(substr($binary, $position, $length));
                $packets[] = ['version' => $version, 'type' => $type, 'length_type_id' => $length_type_id, 'subpackets' => $subpackets['packets']];
                $position+=$length;
            }
            else {
                $num_of_packets = bindec(substr($binary, $position, 11));
                $position+=11;
                //print "11 bit type, number of packets is $num_of_packets\n";
                $subpackets = parsePackets(substr($binary, $position), $num_of_packets);
                $packets[] = ['version' => $version, 'type' => $type, 'length_type_id' => $length_type_id, 'subpackets' => $subpackets['packets']];
                $position+= $subpackets['position'];
            }
        }
    }

    return ['packets' => $packets, 'position' => $position];
}

function getVersionSum($packets) {
    $sum = 0;
    foreach ($packets as $packet) {
        $sum += $packet['version'];
        if (isset($packet['subpackets'])) {
            $sum += getVersionSum($packet['subpackets']);
        }
    }
    return $sum;
}

function getOutput($packets, $nest_level = 0) {
    if (isset($packets['version'])) {
        $packets = [$packets];
    }
    $sum = 0;
    foreach ($packets as $packet) {
        //var_dump($packet);
        $packet_value = 0;
        if (!is_array($packet)) {
            //print "Error\n"; exit;
            //var_dump($packets); exit;
        }
        if ($packet['type'] == 0) {
            str_repeat(' ',$nest_level) . "Nest level $nest_level - Packet 0, add\n";
            foreach ($packet['subpackets'] as $subpacket) {
                //print "Getting output on subpacket\n";
                //var_dump($subpacket);
              $packet_value += getOutput($subpacket, $nest_level+1);
            }
        }
        if ($packet['type'] == 1) {
            $packet_value = 1;
            //print str_repeat(' ',$nest_level) . "Nest level $nest_level - Packet 1, multiply\n";
            foreach ($packet['subpackets'] as $subpacket) {
                //print "Getting output on subpacket\n";
                //var_dump($subpacket);
              $packet_value *= getOutput($subpacket, $nest_level+1);
            }
        }
        if ($packet['type'] == 2) {
            $packet_values = [];
            //print str_repeat(' ',$nest_level) . "Nest level $nest_level - Packet 2, minimum\n";
            foreach ($packet['subpackets'] as $subpacket) {
                //print "Getting output on subpacket\n";
                //var_dump($subpacket);
              $packet_values[] = getOutput($subpacket, $nest_level+1);
            }
            $packet_value = min($packet_values);
        }
        if ($packet['type'] == 3) {
            $packet_values = [];
            //print str_repeat(' ',$nest_level) . "Nest level $nest_level - Packet 3, maximum\n";
            foreach ($packet['subpackets'] as $subpacket) {
                //print "Getting output on subpacket\n";
                //var_dump($subpacket);
              $packet_values[] = getOutput($subpacket, $nest_level+1);
            }
            $packet_value = max($packet_values);
        }
        if ($packet['type'] === 4) {
            //print str_repeat(' ',$nest_level) . "Nest level $nest_level - Literal packet " . $packet['literal'] . "\n";;
            $packet_value = $packet['literal'];
        }
        if ($packet['type'] == 5) {
            //print str_repeat(' ',$nest_level) . "Nest level $nest_level - Packet 5, greater than\n";
            //print "Getting output on subpacket\n";
            //var_dump($packet['subpackets'][0]);
            //print "Getting output on subpacket\n";
            //var_dump($packet['subpackets'][1]);
            if (getOutput($packet['subpackets'][0], $nest_level+1) > getOutput($packet['subpackets'][1], $nest_level+1)) {
                $packet_value = 1;
            }
        }
        if ($packet['type'] == 6) {
            //print str_repeat(' ',$nest_level) . "Nest level $nest_level - Packet 6, less than\n";
            //print "Getting output on subpacket\n";
            //var_dump($packet['subpackets'][0]);
            //print "Getting output on subpacket\n";
            //var_dump($packet['subpackets'][1]);
            if (getOutput($packet['subpackets'][0], $nest_level+1) < getOutput($packet['subpackets'][1], $nest_level+1)) {
                $packet_value = 1;
            }
        }
        if ($packet['type'] == 7) {
            //print str_repeat(' ',$nest_level) . "Nest level $nest_level - Packet 7, equal to\n";
            //print "Getting output on subpacket\n";
            //var_dump($packet['subpackets'][0]);
            //print "Getting output on subpacket\n";
            //var_dump($packet['subpackets'][1]);
            if (getOutput($packet['subpackets'][0], $nest_level+1) == getOutput($packet['subpackets'][1], $nest_level+1)) {
                $packet_value = 1;
            }
        }
        if ($nest_level === 1) {
          print "Adding $packet_value\n";
        }
        $sum += $packet_value;
    }
    //print str_repeat(' ',$nest_level) . "Returning $sum\n";
    return $sum;
}

function first($input) {
    $binary = parseBinary($input);
    $packets = parsePackets($binary);
    return getVersionSum($packets['packets']);
}

function second($input) {
    $binary = parseBinary($input);
    print $binary . "\n";
    $packets = parsePackets($binary);
    var_dump($packets['packets']);
    return getOutput($packets['packets']);
}

$expected = [16,12,23,31];
reset($sample_input);
while ($line = current($sample_input)) {
  test($line, 'first', $expected[key($sample_input)]);
  next($sample_input);
}
$expected = [3,54,7,9,1,0,0,1];
next($sample_input); // Skip blank line
$k = key($sample_input);
while ($line = current($sample_input)) {
  test($line, 'second', $expected[key($sample_input) - $k]);
  next($sample_input);
}

print "First: " . first(reset($input)) . "\n";
print "Second: " . second(reset($input)) . "\n";
