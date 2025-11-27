<?php

$pairs = 10;
$strikes = 24;
$time = 50;

$bonus_difficulty = 100;
$malus = $strikes - $pairs;


function time_bonus_calc($time, $pairs)
{
    $bonus_table = [
        "great" => 100,
        "good" => 50,
        "ok" => 25,
        "bad" => 0
    ];
    //for time bonus calculate time per strike
    $time_great = $pairs;
    //+100
    $time_good = $pairs * 2;
    //+50
    $time_ok = $pairs * 4;
    //+25
    $time_bad = $pairs * 10;
    //0 if more than time_bad

    if ($time <= $time_great and $time < $time_good) {
        $bonus = $bonus_table["great"];
    } elseif ($time >= $time_good and $time < $time_ok) {
        $bonus = $bonus_table["good"];
    } elseif ($time >= $time_ok and $time < $time_bad) {
        $bonus = $bonus_table["ok"];
    } elseif ($time >= $time_bad) {
        $bonus = $bonus_table["bad"];
    }

    return $bonus;
}

$time_bonus = time_bonus_calc($time, $pairs);

$score = (($pairs * $bonus_difficulty) - $malus) + $time_bonus;
$score < 0 ?? $score = 1;

echo $score;
