<?php

include('common.php');

$input = getInput('4');
$sample_input = getSample('4');

function printBoards($boards) {
    foreach ($boards as $board_key => $board) {
        foreach ($board as $row_key => $row) {
            foreach ($row as $col_key => $col) {
                print ($col == 'x' ? 'x' : ($col < 10 ? ' ' : '')) . $col . ' ';
            }
            print "\n";
        }
        print "\n";
    }
}

function prepareBoards($input) {
    $i = 2;
    $boards = [];
    while (!empty($input[$i])) {
        $board = [];
        for ($k = 0; $k < 5; $k++) {
            $board[] = array_values(array_filter(explode(' ', $input[$i+$k]), 'strlen'));
        }
        $boards[] = $board;
        $i+=6;
    }
    return $boards;
}

function first($input) {
    $numbers = explode(',', reset($input));
    $boards = prepareBoards($input);

    foreach ($numbers as $number) {
        foreach ($boards as $board_key => &$board) {
            foreach ($board as &$row) {
                foreach ($row as &$col) {
                    if ($col == $number) {
                        $col = 'x';
                    }
                }
                //Check for winning board
                for ($i = 0; $i < 5; $i++) {
                    if (
                        ($board[$i][0] == 'x' && $board[$i][1] == 'x' && $board[$i][2] == 'x' && $board[$i][3] == 'x' && $board[$i][4] == 'x') // Completed row
                        ||
                        ($board[0][$i] == 'x' && $board[1][$i] == 'x' && $board[2][$i] == 'x' && $board[3][$i] == 'x' && $board[4][$i] == 'x') // Completed column
                    ) {
                        //print "Board $board_key wins with $number\n";
                        //printBoards([$board]);
                        $sum = 0;
                        foreach ($board as $r) {
                            foreach ($r as $c) {
                                if ($c != 'x') {
                                    $sum += $c;
                                }
                            }
                        }
                        return $sum *= $number;
                    }
                }
            }
        }
    }
}

function second($input) {
    $numbers = explode(',', reset($input));
    $boards = prepareBoards($input);
    $winning_boards = [];

    foreach ($numbers as $number) {
        foreach ($boards as $board_key => &$board) {
            foreach ($board as &$row) {
                foreach ($row as &$col) {
                    if ($col == $number) {
                        $col = 'x';
                    }
                }
                //Check for winning board
                for ($i = 0; $i < 5; $i++) {
                    if (
                        ($board[$i][0] == 'x' && $board[$i][1] == 'x' && $board[$i][2] == 'x' && $board[$i][3] == 'x' && $board[$i][4] == 'x') // Completed row
                        ||
                        ($board[0][$i] == 'x' && $board[1][$i] == 'x' && $board[2][$i] == 'x' && $board[3][$i] == 'x' && $board[4][$i] == 'x') // Completed column
                    ) {
                        $winning_boards[$board_key] = TRUE;
                        //print "Board $board_key wins with $number\n";
                        //printBoards([$board]);
                    }
                }
                if (count($winning_boards) == count($boards)) {
                    $sum = 0;
                    foreach ($board as $r) {
                        foreach ($r as $c) {
                            if ($c != 'x') {
                                $sum += $c;
                            }
                        }
                    }
                    return $sum *= $number;
                }
            }
        }
    }
}

test($sample_input, 'first', 4512);
test($sample_input, 'second', 1924);

print "First: " . first($input) . "\n";
print "Second: " . second($input) . "\n";