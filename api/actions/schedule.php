<?php
$tournament_id = filter_var($_GET["tournament_id"], FILTER_SANITIZE_NUMBER_INT);
$season_id = filter_var($_GET["season_id"], FILTER_SANITIZE_NUMBER_INT);

$start_dates = array_filter($_GET, "filter_start", ARRAY_FILTER_USE_KEY);
$end_dates = array_filter($_GET, "filter_end", ARRAY_FILTER_USE_KEY);

if (isset($db)) {
    $sth = $db->prepare("select tournament_rounds as rounds from tournaments where tournament_id = :tournament_id");
    $sth->bindValue(":tournament_id", $tournament_id, PDO::PARAM_INT);
    $sth->execute();
    $rounds = $sth->fetch()["rounds"];  

    if (!check_dates($start_dates, $end_dates) || count($start_dates) != $rounds || count($end_dates) != $rounds) {
        $valid = false;
        $result .= "Invalid quantity of rounds and start/end dates.<br>";
    }

    if (is_generated($tournament_id, $season_id))
        $result .= "The schedule is already generated.<br>";
    else {
        generate_schedule($tournament_id, $season_id, $rounds, $start_dates, $end_dates);
        $result .= "Success.<br>";
    }
}