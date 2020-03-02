<?php
/* 
** action=schedule
*/
function filter_start($value) {
    $filtered_value = filter_var($value, FILTER_SANITIZE_STRING);
    return (strpos($filtered_value, "start") !== false);
}
function filter_end($value) {
    $filtered_value = filter_var($value, FILTER_SANITIZE_STRING);
    return (strpos($filtered_value, "end") !== false);
}
function check_dates($start_dates, $end_dates) {
    global $error;

    $dates = array_merge($start_dates, $end_dates);
    foreach ($dates as $key => $date) {
        $date_array = explode(".", $date);
        if (count($date_array) != 3) {
            $error .= "Error in date format in " . $key . "<br>";
            return (false);
        }
        $result = checkdate($date_array[1], $date_array[0], $date_array[2]);
        if (!$result)
            $error .= "Error in date format in " . $key . "<br>";
        return ($result);
    }
}
function is_generated($tournament_id, $season_id) {
    global $db;

    $sth = $db->prepare("select count(id) as count from schedule where tournament_id = :tournament_id and season_id = :season_id");
    $sth->bindValue(":tournament_id", $tournament_id, PDO::PARAM_INT);
    $sth->bindValue(":season_id", $season_id, PDO::PARAM_INT);
    $sth->execute();
    $is_generated = $sth->fetch()["count"] != 0;

    return ($is_generated);
}
function generate_schedule($tournament_id, $season_id, $rounds, $start_dates, $end_dates) {
    global $db, $round_pairs;

    $sth = $db->prepare("select team_id from teams where tournament_id = :tournament_id and season_id = :season_id");
    $sth->bindValue(":tournament_id", $tournament_id, PDO::PARAM_INT);
    $sth->bindValue(":season_id", $season_id, PDO::PARAM_INT);
    $sth->execute();
    while ($team = $sth->fetch())
        $teams[] = $team["team_id"];

    /* Round consists of several tours */
    $matches_per_tour = ceil(count($teams) / 2);
    $tour = 1;
    for ($round = 1; $round <= $rounds; $round++) {
        $round_start = new DateTime($start_dates["start".$round]);
        $round_end = new DateTime($end_dates["end".$round]);
        /* Generate matches for the next two rounds: same matches, different guest/host */
        if ($round % 2)
            $round_pairs = generate_round_pairs($teams);
        /* Generate tours */
        $tour_pairs = generate_tour_pairs($round, $matches_per_tour);
        $round_continuance = $round_end->diff($round_start)->format("%a");
        $tour_continuance = ceil( $round_continuance / count($tour_pairs) );
        
        $tour_start = $round_start;
        $tour_end = clone $tour_start;
        $tour_end->add(new DateInterval("P".($tour_continuance - 1)."D"));
        for ($i = 1; $i <= count($tour_pairs); $i++, $tour++) {
            $sql = "insert into schedule values ";
            foreach ($tour_pairs[$i] as $pair)
                $sql .= "(NULL, :season_id, :tournament_id, :tour, ".$pair[0].", ".$pair[1].", :tour_start, :tour_end, NULL, NULL, NULL),";
            $sth = $db->prepare( rtrim($sql, ", ") );
            $sth->bindValue(":season_id", $season_id, PDO::PARAM_INT);
            $sth->bindValue(":tournament_id", $tournament_id, PDO::PARAM_INT);
            $sth->bindValue(":tour", $tour, PDO::PARAM_INT);
            $sth->bindValue(":tour_start", $tour_start->format("d.m"), PDO::PARAM_STR);
            $sth->bindValue(":tour_end", $tour_end->format("d.m"), PDO::PARAM_STR);
            $sth->execute();
            
            $tour_start->add(new DateInterval("P".$tour_continuance."D"));
            $tour_end->add(new DateInterval("P".$tour_continuance."D"));
        }
    }
}
function generate_round_pairs($teams) {
    $round_pairs = [];

    while (count($teams)) {
        for ($i = 1; $i < count($teams); $i++) {
            $round_pairs[0][] = [$teams[0], $teams[$i]];
            $round_pairs[1][] = [$teams[$i], $teams[0]];
        }
        array_shift($teams);
    }
    shuffle($round_pairs[0]);
    shuffle($round_pairs[1]);

    return ($round_pairs);
}
function generate_tour_pairs($round, $matches_per_tour) {
    global $round_pairs;

    $tour_pairs = [];
    
    for ($tour = 1; count($round_pairs[$round - 1]) > 0; $tour++) {
        $tour_pairs[$tour] = [];
        $max_iterations = array_key_last($round_pairs[$round - 1]);
        /* Add to pairs if there is no such team already playing in this tour. Otherwise get next */
        for ($i = 0; count($tour_pairs[$tour]) < $matches_per_tour && $i <= $max_iterations; $i++) {
            if (!array_key_exists($i, $round_pairs[$round - 1]))
                continue ;
            $new_pair = $round_pairs[$round - 1][$i];
            $unique_new_pair = 1;

            foreach ($tour_pairs[$tour] as $pair) {
                if ( count(array_diff($pair, $new_pair)) != 2) {
                    $unique_new_pair--;
                    break ;
                }
            }
            if ($unique_new_pair) {
                $tour_pairs[$tour][] = $new_pair;
                unset($round_pairs[$round - 1][$i]);
            }
        }
    }

    return ($tour_pairs);
}