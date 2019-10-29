<?php
require __DIR__ . '/../inc/bootstrap.php';
try {	
	// part 1 matches
	$tournament = filter_var($_POST['tournament_id'], FILTER_SANITIZE_NUMBER_INT);
	$team1 = filter_var($_POST['team1_id'], FILTER_SANITIZE_NUMBER_INT);
	$team2 = filter_var($_POST['team2_id'], FILTER_SANITIZE_NUMBER_INT);
	$score1 = filter_var($_POST['t1score'], FILTER_SANITIZE_NUMBER_INT);
	$score2 = filter_var($_POST['t2score'], FILTER_SANITIZE_NUMBER_INT);
	$points1 = $score1 > $score2 ? 2 : 0;
	$points2 = 2 - $points1;
	// get season
	$sth = $db->prepare("select season_id from teams where team_id = :tid");
	$sth->bindValue(":tid", $team1, PDO::PARAM_INT);
	$sth->execute();
	$season = $sth->fetch()["season_id"];
	// insert
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
	$matches = ["d1", "d2", "s1", "s2", "d3"];
	for ($r = 1; $r < 3; $r++)
	{
		foreach ($matches as $match) {
			${"r".$r."t1".$match} = filter_var($_POST["r".$r."t1".$match], FILTER_SANITIZE_NUMBER_INT);
			${"r".$r."t2".$match} = filter_var($_POST["r".$r."t2".$match], FILTER_SANITIZE_NUMBER_INT);
			$query = "insert into games values (NULL, :match_id, :t1p1, " . (strpos($match, "s") === false ? ":t1p2" : "NULL") . ", :t2p1, " . (strpos($match, "s") === false ? ":t2p2" : "NULL") . ", :score1, :score2)";
			$sth = $db->prepare($query);
			$sth->bindValue(':match_id', $match_id, PDO::PARAM_INT);
			$sth->bindValue(':t1p1', ${"t1".$match."p1"}, PDO::PARAM_INT);
			$sth->bindValue(':t2p1', ${"t2".$match."p1"}, PDO::PARAM_INT);
			if (strpos($match, "s") === false) {
				$sth->bindValue(':t1p2', ${"t1".$match."p2"}, PDO::PARAM_INT);
				$sth->bindValue(':t2p2', ${"t2".$match."p2"}, PDO::PARAM_INT);
			}
			$sth->bindValue(':score1', ${"r".$r."t1".$match}, PDO::PARAM_INT);
			$sth->bindValue(':score2', ${"r".$r."t2".$match}, PDO::PARAM_INT);
			$sth->execute();
			if (strpos($match, "s") === false) {
				$r1 = $ratings[${"t1".$match."p1"}] > $ratings[${"t1".$match."p2"}] 
					? (2 * $ratings[${"t1".$match."p1"}] + $ratings[${"t1".$match."p2"}]) / 3
					: (2 * $ratings[${"t1".$match."p2"}] + $ratings[${"t1".$match."p1"}]) / 3;
				$r2 = $ratings[${"t2".$match."p1"}] > $ratings[${"t2".$match."p2"}] 
					? (2 * $ratings[${"t2".$match."p1"}] + $ratings[${"t2".$match."p2"}]) / 3
					: (2 * $ratings[${"t2".$match."p2"}] + $ratings[${"t2".$match."p1"}]) / 3;
			} else {
				$r1 = $ratings[${"t1".$match."p1"}];
				$r2 = $ratings[${"t2".$match."p1"}];
			}
			$x = ${"r".$r."t1".$match} > ${"r".$r."t2".$match} ? $r2 - $r1 : $r1 - $r2;
			$rating_diff = round(abs(${"r".$r."t1".$match} - ${"r".$r."t2".$match}) * 6 * (1 - 1 / (pow(10, ($x / 400)) + 1)));
			$ratings[${"t1".$match."p1"}] += ${"r".$r."t1".$match} > ${"r".$r."t2".$match} ? $rating_diff : -$rating_diff;
			$ratings[${"t2".$match."p1"}] += ${"r".$r."t2".$match} > ${"r".$r."t1".$match} ? $rating_diff : -$rating_diff;
			if (strpos($match, "s") === false) {
				$ratings[${"t1".$match."p2"}] += ${"r".$r."t1".$match} > ${"r".$r."t2".$match} ? $rating_diff : -$rating_diff;
				$ratings[${"t2".$match."p2"}] += ${"r".$r."t2".$match} > ${"r".$r."t1".$match} ? $rating_diff : -$rating_diff;
			}
		}
	}
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
