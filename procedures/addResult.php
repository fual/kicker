<?php
require __DIR__ . '/../inc/bootstrap.php';
try {	
	// common part
	$season = 1;
	$tournament = filter_var($_POST['tournament_id'], FILTER_SANITIZE_NUMBER_INT);
	// part 1 matches
	$team1 = filter_var($_POST['team1_id'], FILTER_SANITIZE_NUMBER_INT);
	$team2 = filter_var($_POST['team2_id'], FILTER_SANITIZE_NUMBER_INT);
	$score1 = filter_var($_POST['t1score'], FILTER_SANITIZE_NUMBER_INT);
	$score2 = filter_var($_POST['t2score'], FILTER_SANITIZE_NUMBER_INT);
	$points1 = $score1 > $score2 ? 2 : 0;
	$points2 = 2 - $points1;
	$sth = $db->prepare("insert into matches values (NULL, :season, :tournament, :team1, :team2, :score1, :score2, :points1, :points2)");
	$sth->bindValue(':season', $season, PDO::PARAM_INT);
	$sth->bindValue(':tournament', $tournament, PDO::PARAM_INT);
	$sth->bindValue(':team1', $team1, PDO::PARAM_INT);
	$sth->bindValue(':team2', $team2, PDO::PARAM_INT);
	$sth->bindValue(':score1', $score1, PDO::PARAM_INT);
	$sth->bindValue(':score2', $score2, PDO::PARAM_INT);
	$sth->bindValue(':points1', $points1, PDO::PARAM_INT);
	$sth->bindValue(':points2', $points2, PDO::PARAM_INT);
	$sth->execute();
	// get match_id
	$sth = $db->prepare("select max(match_id) as id from matches");
	$sth->execute();
	$match_id = $sth->fetch()['id'];
	// part 2 players
	// players
	$t1d1p1 = filter_var($_POST['t1d1p1'], FILTER_SANITIZE_NUMBER_INT);
	$t1d1p2 = filter_var($_POST['t1d1p2'], FILTER_SANITIZE_NUMBER_INT);
	$t2d1p1 = filter_var($_POST['t2d1p1'], FILTER_SANITIZE_NUMBER_INT);
	$t2d1p2 = filter_var($_POST['t2d1p2'], FILTER_SANITIZE_NUMBER_INT);
	$t1d2p1 = filter_var($_POST['t1d2p1'], FILTER_SANITIZE_NUMBER_INT);
	$t1d2p2 = filter_var($_POST['t1d2p2'], FILTER_SANITIZE_NUMBER_INT);
	$t2d2p1 = filter_var($_POST['t2d2p1'], FILTER_SANITIZE_NUMBER_INT);
	$t2d2p2 = filter_var($_POST['t2d2p2'], FILTER_SANITIZE_NUMBER_INT);
	$t1s1p1 = filter_var($_POST['t1s1p1'], FILTER_SANITIZE_NUMBER_INT);
	$t2s1p1 = filter_var($_POST['t2s1p1'], FILTER_SANITIZE_NUMBER_INT);
	$t1s2p1 = filter_var($_POST['t1s2p1'], FILTER_SANITIZE_NUMBER_INT);
	$t2s2p1 = filter_var($_POST['t2s2p1'], FILTER_SANITIZE_NUMBER_INT);
	$t1d3p1 = filter_var($_POST['t1d3p1'], FILTER_SANITIZE_NUMBER_INT);
	$t1d3p2 = filter_var($_POST['t1d3p2'], FILTER_SANITIZE_NUMBER_INT);
	$t2d3p1 = filter_var($_POST['t2d3p1'], FILTER_SANITIZE_NUMBER_INT);
	$t2d3p2 = filter_var($_POST['t2d3p2'], FILTER_SANITIZE_NUMBER_INT);
	// rating
	$sth = $db->prepare("select id, rating from rosters where id in (:p1, :p2, :p3, :p4, :p5, :p6, :p7, :p8, :p9, :p10, :p11, :p12, :p13, :p14, :p15, :p16)");
	$sth->bindValue(':p1', $t1d1p1, PDO::PARAM_INT);
	$sth->bindValue(':p2', $t1d1p2, PDO::PARAM_INT);
	$sth->bindValue(':p3', $t2d1p1, PDO::PARAM_INT);
	$sth->bindValue(':p4', $t2d1p2, PDO::PARAM_INT);
	$sth->bindValue(':p5', $t1d2p1, PDO::PARAM_INT);
	$sth->bindValue(':p6', $t1d2p2, PDO::PARAM_INT);
	$sth->bindValue(':p7', $t2d2p1, PDO::PARAM_INT);
	$sth->bindValue(':p8', $t2d2p2, PDO::PARAM_INT);
	$sth->bindValue(':p9', $t1s1p1, PDO::PARAM_INT);
	$sth->bindValue(':p10', $t2s1p1, PDO::PARAM_INT);
	$sth->bindValue(':p11', $t1s2p1, PDO::PARAM_INT);
	$sth->bindValue(':p12', $t2s2p1, PDO::PARAM_INT);
	$sth->bindValue(':p13', $t1d3p1, PDO::PARAM_INT);
	$sth->bindValue(':p14', $t1d3p2, PDO::PARAM_INT);
	$sth->bindValue(':p15', $t2d3p1, PDO::PARAM_INT);
	$sth->bindValue(':p16', $t2d3p2, PDO::PARAM_INT);
	$sth->execute();
	$results = $sth->fetchAll();
	$ratings = [];
	foreach ($results as $result) {
		$ratings[$result['id']] = +$result['rating'];
	}
	// Round 1
	// D1
	$r1t1d1 = filter_var($_POST['r1t1d1'], FILTER_SANITIZE_NUMBER_INT);
	$r1t2d1 = filter_var($_POST['r1t2d1'], FILTER_SANITIZE_NUMBER_INT);
	$sth = $db->prepare("insert into games values (NULL, :match_id, :t1p1, :t1p2, :t2p1, :t2p2, :score1, :score2)");
	$sth->bindValue(':match_id', $match_id, PDO::PARAM_INT);
	$sth->bindValue(':t1p1', $t1d1p1, PDO::PARAM_INT);
	$sth->bindValue(':t1p2', $t1d1p2, PDO::PARAM_INT);
	$sth->bindValue(':t2p1', $t2d1p1, PDO::PARAM_INT);
	$sth->bindValue(':t2p2', $t2d1p2, PDO::PARAM_INT);
	$sth->bindValue(':score1', $r1t1d1, PDO::PARAM_INT);
	$sth->bindValue(':score2', $r1t2d1, PDO::PARAM_INT);
	$sth->execute();
	$r1 = $ratings[$t1d1p1] > $ratings[$t1d1p2] 
		? (2 * $ratings[$t1d1p1] + $ratings[$t1d1p2]) / 3
		: (2 * $ratings[$t1d1p2] + $ratings[$t1d1p1]) / 3;
	$r2 = $ratings[$t2d1p1] > $ratings[$t2d1p2] 
		? (2 * $ratings[$t2d1p1] + $ratings[$t2d1p2]) / 3
		: (2 * $ratings[$t2d1p2] + $ratings[$t2d1p1]) / 3;
	$x = $r1t1d1 > $r1t2d1 ? $r2 - $r1 : $r1 - $r2;
	$rating_diff = round(abs($r1t1d1 - $r1t2d1) * 6 * (1 - 1 / (pow(10, ($x / 400)) + 1)));
	$ratings[$t1d1p1] += $r1t1d1 > $r1t2d1 ? $rating_diff : -$rating_diff;
	$ratings[$t1d1p2] += $r1t1d1 > $r1t2d1 ? $rating_diff : -$rating_diff;
	$ratings[$t2d1p1] += $r1t2d1 > $r1t1d1 ? $rating_diff : -$rating_diff;
	$ratings[$t2d1p2] += $r1t2d1 > $r1t1d1 ? $rating_diff : -$rating_diff;
	// D2
	$r1t1d2 = filter_var($_POST['r1t1d2'], FILTER_SANITIZE_NUMBER_INT);
	$r1t2d2 = filter_var($_POST['r1t2d2'], FILTER_SANITIZE_NUMBER_INT);
	$sth = $db->prepare("insert into games values (NULL, :match_id, :t1p1, :t1p2, :t2p1, :t2p2, :score1, :score2)");
	$sth->bindValue(':match_id', $match_id, PDO::PARAM_INT);
	$sth->bindValue(':t1p1', $t1d2p1, PDO::PARAM_INT);
	$sth->bindValue(':t1p2', $t1d2p2, PDO::PARAM_INT);
	$sth->bindValue(':t2p1', $t2d2p1, PDO::PARAM_INT);
	$sth->bindValue(':t2p2', $t2d2p2, PDO::PARAM_INT);
	$sth->bindValue(':score1', $r1t1d2, PDO::PARAM_INT);
	$sth->bindValue(':score2', $r1t2d2, PDO::PARAM_INT);
	$sth->execute();
	$r1 = $ratings[$t1d2p1] > $ratings[$t1d2p2] 
		? (2 * $ratings[$t1d2p1] + $ratings[$t1d2p2]) / 3
		: (2 * $ratings[$t1d2p2] + $ratings[$t1d2p1]) / 3;
	$r2 = $ratings[$t2d2p1] > $ratings[$t2d2p2] 
		? (2 * $ratings[$t2d2p1] + $ratings[$t2d2p2]) / 3
		: (2 * $ratings[$t2d2p2] + $ratings[$t2d2p1]) / 3;
	$x = $r1t1d2 > $r1t2d2 ? $r2 - $r1 : $r1 - $r2;
	$rating_diff = round(abs($r1t1d2 - $r1t2d2) * 6 * (1 - 1 / (pow(10, ($x / 400)) + 1)));
	$ratings[$t1d2p1] += $r1t1d2 > $r1t2d2 ? $rating_diff : -$rating_diff;
	$ratings[$t1d2p2] += $r1t1d2 > $r1t2d2 ? $rating_diff : -$rating_diff;
	$ratings[$t2d2p1] += $r1t2d2 > $r1t1d2 ? $rating_diff : -$rating_diff;
	$ratings[$t2d2p2] += $r1t2d2 > $r1t1d2 ? $rating_diff : -$rating_diff;
	// S1
	$r1t1s1 = filter_var($_POST['r1t1s1'], FILTER_SANITIZE_NUMBER_INT);
	$r1t2s1 = filter_var($_POST['r1t2s1'], FILTER_SANITIZE_NUMBER_INT);
	$sth = $db->prepare("insert into games values (NULL, :match_id, :t1p1, NULL, :t2p1, NULL, :score1, :score2)");
	$sth->bindValue(':match_id', $match_id, PDO::PARAM_INT);
	$sth->bindValue(':t1p1', $t1s1p1, PDO::PARAM_INT);
	$sth->bindValue(':t2p1', $t2s1p1, PDO::PARAM_INT);
	$sth->bindValue(':score1', $r1t1s1, PDO::PARAM_INT);
	$sth->bindValue(':score2', $r1t2s1, PDO::PARAM_INT);
	$sth->execute();
	$x = $r1t1s1 > $r1t2s1 ? $ratings[$t2s1p1] - $ratings[$t1s1p1] : $ratings[$t1s1p1] - $ratings[$t2s1p1];
	$rating_diff = round(abs($r1t1s1 - $r1t2s1) * 6 * (1 - 1 / (pow(10, ($x / 400)) + 1)));
	$ratings[$t1s1p1] += $r1t1s1 > $r1t2s1 ? $rating_diff : -$rating_diff;
	$ratings[$t2s1p1] += $r1t2s1 > $r1t1s1 ? $rating_diff : -$rating_diff;
	// S2
	$r1t1s2 = filter_var($_POST['r1t1s2'], FILTER_SANITIZE_NUMBER_INT);
	$r1t2s2 = filter_var($_POST['r1t2s2'], FILTER_SANITIZE_NUMBER_INT);
	$sth = $db->prepare("insert into games values (NULL, :match_id, :t1p1, NULL, :t2p1, NULL, :score1, :score2)");
	$sth->bindValue(':match_id', $match_id, PDO::PARAM_INT);
	$sth->bindValue(':t1p1', $t1s2p1, PDO::PARAM_INT);
	$sth->bindValue(':t2p1', $t2s2p1, PDO::PARAM_INT);
	$sth->bindValue(':score1', $r1t1s2, PDO::PARAM_INT);
	$sth->bindValue(':score2', $r1t2s2, PDO::PARAM_INT);
	$sth->execute();
	$x = $r1t1s2 > $r1t2s2 ? $ratings[$t2s2p1] - $ratings[$t1s2p1] : $ratings[$t1s2p1] - $ratings[$t2s2p1];
	$rating_diff = round(abs($r1t1s2 - $r1t2s2) * 6 * (1 - 1 / (pow(10, ($x / 400)) + 1)));
	$ratings[$t1s2p1] += $r1t1s2 > $r1t2s2 ? $rating_diff : -$rating_diff;
	$ratings[$t2s2p1] += $r1t2s2 > $r1t1s2 ? $rating_diff : -$rating_diff;
	// D3
	$r1t1d3 = filter_var($_POST['r1t1d3'], FILTER_SANITIZE_NUMBER_INT);
	$r1t2d3 = filter_var($_POST['r1t2d3'], FILTER_SANITIZE_NUMBER_INT);
	$sth = $db->prepare("insert into games values (NULL, :match_id, :t1p1, :t1p2, :t2p1, :t2p2, :score1, :score2)");
	$sth->bindValue(':match_id', $match_id, PDO::PARAM_INT);
	$sth->bindValue(':t1p1', $t1d3p1, PDO::PARAM_INT);
	$sth->bindValue(':t1p2', $t1d3p2, PDO::PARAM_INT);
	$sth->bindValue(':t2p1', $t2d3p1, PDO::PARAM_INT);
	$sth->bindValue(':t2p2', $t2d3p2, PDO::PARAM_INT);
	$sth->bindValue(':score1', $r1t1d3, PDO::PARAM_INT);
	$sth->bindValue(':score2', $r1t2d3, PDO::PARAM_INT);
	$sth->execute();
	$r1 = $ratings[$t1d3p1] > $ratings[$t1d3p2] 
		? (2 * $ratings[$t1d3p1] + $ratings[$t1d3p2]) / 3
		: (2 * $ratings[$t1d3p2] + $ratings[$t1d3p1]) / 3;
	$r2 = $ratings[$t2d3p1] > $ratings[$t2d3p2] 
		? (2 * $ratings[$t2d3p1] + $ratings[$t2d3p2]) / 3
		: (2 * $ratings[$t2d3p2] + $ratings[$t2d3p1]) / 3;
	$x = $r1t1d3 > $r1t2d3 ? $r2 - $r1 : $r1 - $r2;
	$rating_diff = round(abs($r1t1d3 - $r1t2d3) * 6 * (1 - 1 / (pow(10, ($x / 400)) + 1)));
	$ratings[$t1d3p1] += $r1t1d3 > $r1t2d3 ? $rating_diff : -$rating_diff;
	$ratings[$t1d3p2] += $r1t1d3 > $r1t2d3 ? $rating_diff : -$rating_diff;
	$ratings[$t2d3p1] += $r1t2d3 > $r1t1d3 ? $rating_diff : -$rating_diff;
	$ratings[$t2d3p2] += $r1t2d3 > $r1t1d3 ? $rating_diff : -$rating_diff;
	// Round 2
	// D1
	$r2t1d1 = filter_var($_POST['r2t1d1'], FILTER_SANITIZE_NUMBER_INT);
	$r2t2d1 = filter_var($_POST['r2t2d1'], FILTER_SANITIZE_NUMBER_INT);
	$sth = $db->prepare("insert into games values (NULL, :match_id, :t1p1, :t1p2, :t2p1, :t2p2, :score1, :score2)");
	$sth->bindValue(':match_id', $match_id, PDO::PARAM_INT);
	$sth->bindValue(':t1p1', $t1d1p1, PDO::PARAM_INT);
	$sth->bindValue(':t1p2', $t1d1p2, PDO::PARAM_INT);
	$sth->bindValue(':t2p1', $t2d1p1, PDO::PARAM_INT);
	$sth->bindValue(':t2p2', $t2d1p2, PDO::PARAM_INT);
	$sth->bindValue(':score1', $r2t1d1, PDO::PARAM_INT);
	$sth->bindValue(':score2', $r2t2d1, PDO::PARAM_INT);
	$sth->execute();
	$r1 = $ratings[$t1d1p1] > $ratings[$t1d1p2] 
		? (2 * $ratings[$t1d1p1] + $ratings[$t1d1p2]) / 3
		: (2 * $ratings[$t1d1p2] + $ratings[$t1d1p1]) / 3;
	$r2 = $ratings[$t2d1p1] > $ratings[$t2d1p2] 
		? (2 * $ratings[$t2d1p1] + $ratings[$t2d1p2]) / 3
		: (2 * $ratings[$t2d1p2] + $ratings[$t2d1p1]) / 3;
	$x = $r2t1d1 > $r2t2d1 ? $r2 - $r1 : $r1 - $r2;
	$rating_diff = round(abs($r2t1d1 - $r2t2d1) * 6 * (1 - 1 / (pow(10, ($x / 400)) + 1)));
	$ratings[$t1d1p1] += $r2t1d1 > $r2t2d1 ? $rating_diff : -$rating_diff;
	$ratings[$t1d1p2] += $r2t1d1 > $r2t2d1 ? $rating_diff : -$rating_diff;
	$ratings[$t2d1p1] += $r2t2d1 > $r2t1d1 ? $rating_diff : -$rating_diff;
	$ratings[$t2d1p2] += $r2t2d1 > $r2t1d1 ? $rating_diff : -$rating_diff;
	// D2
	$r2t1d2 = filter_var($_POST['r2t1d2'], FILTER_SANITIZE_NUMBER_INT);
	$r2t2d2 = filter_var($_POST['r2t2d2'], FILTER_SANITIZE_NUMBER_INT);
	$sth = $db->prepare("insert into games values (NULL, :match_id, :t1p1, :t1p2, :t2p1, :t2p2, :score1, :score2)");
	$sth->bindValue(':match_id', $match_id, PDO::PARAM_INT);
	$sth->bindValue(':t1p1', $t1d2p1, PDO::PARAM_INT);
	$sth->bindValue(':t1p2', $t1d2p2, PDO::PARAM_INT);
	$sth->bindValue(':t2p1', $t2d2p1, PDO::PARAM_INT);
	$sth->bindValue(':t2p2', $t2d2p2, PDO::PARAM_INT);
	$sth->bindValue(':score1', $r2t1d2, PDO::PARAM_INT);
	$sth->bindValue(':score2', $r2t2d2, PDO::PARAM_INT);
	$sth->execute();
	$r1 = $ratings[$t1d2p1] > $ratings[$t1d2p2] 
		? (2 * $ratings[$t1d2p1] + $ratings[$t1d2p2]) / 3
		: (2 * $ratings[$t1d2p2] + $ratings[$t1d2p1]) / 3;
	$r2 = $ratings[$t2d2p1] > $ratings[$t2d2p2] 
		? (2 * $ratings[$t2d2p1] + $ratings[$t2d2p2]) / 3
		: (2 * $ratings[$t2d2p2] + $ratings[$t2d2p1]) / 3;
	$x = $r2t1d2 > $r2t2d2 ? $r2 - $r1 : $r1 - $r2;
	$rating_diff = round(abs($r2t1d2 - $r2t2d2) * 6 * (1 - 1 / (pow(10, ($x / 400)) + 1)));
	$ratings[$t1d2p1] += $r2t1d2 > $r2t2d2 ? $rating_diff : -$rating_diff;
	$ratings[$t1d2p2] += $r2t1d2 > $r2t2d2 ? $rating_diff : -$rating_diff;
	$ratings[$t2d2p1] += $r2t2d2 > $r2t1d2 ? $rating_diff : -$rating_diff;
	$ratings[$t2d2p2] += $r2t2d2 > $r2t1d2 ? $rating_diff : -$rating_diff;
	// S1
	$r2t1s1 = filter_var($_POST['r2t1s1'], FILTER_SANITIZE_NUMBER_INT);
	$r2t2s1 = filter_var($_POST['r2t2s1'], FILTER_SANITIZE_NUMBER_INT);
	$sth = $db->prepare("insert into games values (NULL, :match_id, :t1p1, NULL, :t2p1, NULL, :score1, :score2)");
	$sth->bindValue(':match_id', $match_id, PDO::PARAM_INT);
	$sth->bindValue(':t1p1', $t1s1p1, PDO::PARAM_INT);
	$sth->bindValue(':t2p1', $t2s1p1, PDO::PARAM_INT);
	$sth->bindValue(':score1', $r2t1s1, PDO::PARAM_INT);
	$sth->bindValue(':score2', $r2t2s1, PDO::PARAM_INT);
	$sth->execute();
	$x = $r2t1s1 > $r2t2s1 ? $ratings[$t2s1p1] - $ratings[$t1s1p1] : $ratings[$t1s1p1] - $ratings[$t2s1p1];
	$rating_diff = round(abs($r2t1s1 - $r2t2s1) * 6 * (1 - 1 / (pow(10, ($x / 400)) + 1)));
	$ratings[$t1s1p1] += $r2t1s1 > $r2t2s1 ? $rating_diff : -$rating_diff;
	$ratings[$t2s1p1] += $r2t2s1 > $r2t1s1 ? $rating_diff : -$rating_diff;
	// S2
	$r2t1s2 = filter_var($_POST['r2t1s2'], FILTER_SANITIZE_NUMBER_INT);
	$r2t2s2 = filter_var($_POST['r2t2s2'], FILTER_SANITIZE_NUMBER_INT);
	$sth = $db->prepare("insert into games values (NULL, :match_id, :t1p1, NULL, :t2p1, NULL, :score1, :score2)");
	$sth->bindValue(':match_id', $match_id, PDO::PARAM_INT);
	$sth->bindValue(':t1p1', $t1s2p1, PDO::PARAM_INT);
	$sth->bindValue(':t2p1', $t2s2p1, PDO::PARAM_INT);
	$sth->bindValue(':score1', $r2t1s2, PDO::PARAM_INT);
	$sth->bindValue(':score2', $r2t2s2, PDO::PARAM_INT);
	$sth->execute();
	$x = $r2t1s2 > $r2t2s2 ? $ratings[$t2s2p1] - $ratings[$t1s2p1] : $ratings[$t1s2p1] - $ratings[$t2s2p1];
	$rating_diff = round(abs($r2t1s2 - $r2t2s2) * 6 * (1 - 1 / (pow(10, ($x / 400)) + 1)));
	$ratings[$t1s2p1] += $r2t1s2 > $r2t2s2 ? $rating_diff : -$rating_diff;
	$ratings[$t2s2p1] += $r2t2s2 > $r2t1s2 ? $rating_diff : -$rating_diff;
	// D3
	$r2t1d3 = filter_var($_POST['r2t1d3'], FILTER_SANITIZE_NUMBER_INT);
	$r2t2d3 = filter_var($_POST['r2t2d3'], FILTER_SANITIZE_NUMBER_INT);
	$sth = $db->prepare("insert into games values (NULL, :match_id, :t1p1, :t1p2, :t2p1, :t2p2, :score1, :score2)");
	$sth->bindValue(':match_id', $match_id, PDO::PARAM_INT);
	$sth->bindValue(':t1p1', $t1d3p1, PDO::PARAM_INT);
	$sth->bindValue(':t1p2', $t1d3p2, PDO::PARAM_INT);
	$sth->bindValue(':t2p1', $t2d3p1, PDO::PARAM_INT);
	$sth->bindValue(':t2p2', $t2d3p2, PDO::PARAM_INT);
	$sth->bindValue(':score1', $r2t1d3, PDO::PARAM_INT);
	$sth->bindValue(':score2', $r2t2d3, PDO::PARAM_INT);
	$sth->execute();
	$r1 = $ratings[$t1d3p1] > $ratings[$t1d3p2] 
		? (2 * $ratings[$t1d3p1] + $ratings[$t1d3p2]) / 3
		: (2 * $ratings[$t1d3p2] + $ratings[$t1d3p1]) / 3;
	$r2 = $ratings[$t2d3p1] > $ratings[$t2d3p2] 
		? (2 * $ratings[$t2d3p1] + $ratings[$t2d3p2]) / 3
		: (2 * $ratings[$t2d3p2] + $ratings[$t2d3p1]) / 3;
	$x = $r2t1d3 > $r2t2d3 ? $r2 - $r1 : $r1 - $r2;
	$rating_diff = round(abs($r2t1d3 - $r2t2d3) * 6 * (1 - 1 / (pow(10, ($x / 400)) + 1)));
	$ratings[$t1d3p1] += $r2t1d3 > $r2t2d3 ? $rating_diff : -$rating_diff;
	$ratings[$t1d3p2] += $r2t1d3 > $r2t2d3 ? $rating_diff : -$rating_diff;
	$ratings[$t2d3p1] += $r2t2d3 > $r2t1d3 ? $rating_diff : -$rating_diff;
	$ratings[$t2d3p2] += $r2t2d3 > $r2t1d3 ? $rating_diff : -$rating_diff;
	// update ratings
	foreach ($ratings as $id => $rating) {
		$sth = $db->prepare("update rosters set rating = :rating where id = :id");
		$sth->bindValue(":rating", $rating, PDO::PARAM_INT);
		$sth->bindValue(":id", $id, PDO::PARAM_INT);
		$sth->execute();
	}
	header("Location: /?result=success&code=1");
} catch (Exception $e) {
	header("Location: /?result=error&code=3");
}
