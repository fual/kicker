<?php
	/* This page recalculates all ratings. Service purposes. */
	require_once $_SERVER["DOCUMENT_ROOT"] . "/inc/bootstrap.php";
	$db->query("update rosters set rating = 1000");
	$sth = $db->prepare("select * from games");
	$sth->execute();
	$games = $sth->fetchAll();
	foreach ($games as $game) {
		$player11 = $game['player_id11'];
		$sth = $db->prepare("select rating from rosters where id = :id");
		$sth->bindValue(":id", $player11, PDO::PARAM_INT);
		$sth->execute();
		$rating11 = $sth->fetch()['rating'];
		if (isset($game['player_id12'])) {
			$player12 = $game['player_id12'];
			$sth = $db->prepare("select rating from rosters where id = :id");
			$sth->bindValue(":id", $player12, PDO::PARAM_INT);
			$sth->execute();
			$rating12 = $sth->fetch()['rating'];
		}
		$player21 = $game['player_id21'];
		$sth = $db->prepare("select rating from rosters where id = :id");
		$sth->bindValue(":id", $player21, PDO::PARAM_INT);
		$sth->execute();
		$rating21 = $sth->fetch()['rating'];
		if (isset($game['player_id12'])) {
			$player22 = $game['player_id22'];
			$sth = $db->prepare("select rating from rosters where id = :id");
			$sth->bindValue(":id", $player22, PDO::PARAM_INT);
			$sth->execute();
			$rating22 = $sth->fetch()['rating'];
		}
		$score1 = $game['score1'];
		$score2 = $game['score2'];
		if (isset($player12)) {
			$rating1 = $rating11 > $rating12 ? 
				(2 * $rating11 + $rating12) / 3 : (2 * $rating12 + $rating11) / 3;
			$rating2 = $rating21 > $rating22 ? 
				(2 * $rating21 + $rating22) / 3 : (2 * $rating22 + $rating21) / 3;
		} else {
			$rating1 = $rating11;
			$rating2 = $rating21;
		}
		$x = $score1 > $score2 ? $rating2 - $rating1 : $rating1 - $rating2;
		$rating_diff = round(abs($score1 - $score2) * 6 * (1 - 1 / (pow(10, ($x / 400)) + 1)));
		$rating11 += $score1 > $score2 ? $rating_diff : -$rating_diff;
		$rating21 += $score2 > $score1 ? $rating_diff : -$rating_diff;
		if (isset($game['player_id12'])) {
			$rating12 += $score1 > $score2 ? $rating_diff : -$rating_diff;
			$rating22 += $score2 > $score1 ? $rating_diff : -$rating_diff;
		}
		$ratings = [$player11 => $rating11, $player21 => $rating21];
		if (isset($game['player_id12'])) {
			$ratings[$player12] = $rating12;
			$ratings[$player22] = $rating22;
		}
		foreach ($ratings as $id => $rating) {
			$sth = $db->prepare("update rosters set rating = :rating where id = :id");
			$sth->bindValue(":rating", $rating, PDO::PARAM_INT);
			$sth->bindValue(":id", $id, PDO::PARAM_INT);
			$sth->execute();
		}
	}