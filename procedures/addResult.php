<?php
require __DIR__ . '/../inc/bootstrap.php';
try {
	$division = filter_var($_POST['division'], FILTER_SANITIZE_NUMBER_INT);
	if (isset($_POST['team11'])) {
		$teamid11 = filter_var($_POST['team11'], FILTER_SANITIZE_NUMBER_INT);
		$teamid12 = filter_var($_POST['team12'], FILTER_SANITIZE_NUMBER_INT);
	}
	if (isset($_POST['team21'])) {
		$teamid21 = filter_var($_POST['team21'], FILTER_SANITIZE_NUMBER_INT);
		$teamid22 = filter_var($_POST['team22'], FILTER_SANITIZE_NUMBER_INT);
	}
	$teamid1 = isset($teamid11) && $teamid11 != 0 ? $teamid11 : $teamid21;
	$teamid2 = isset($teamid12) && $teamid12 != 0 ? $teamid12 : $teamid22;
	$score1 = filter_var($_POST['score1'], FILTER_SANITIZE_NUMBER_INT);
	$score2 = filter_var($_POST['score2'], FILTER_SANITIZE_NUMBER_INT);
	$season_id = 1;
	$points1 = $score1 > $score2 ? 2 : 0;
	$points2 = 2 - $points1;
	$sth = $db->prepare("select count(*) as qty from matches where team_id1 in (:teamid1, :teamid2) and team_id2 in (:teamid1, :teamid2)");
	$sth->bindValue(':teamid1', $teamid1, PDO::PARAM_INT);
	$sth->bindValue(':teamid2', $teamid2, PDO::PARAM_INT);
	$sth->execute();
	$count = $sth->fetchAll();
	if ($count[0]['qty'] > 1) {
		echo "1";
		return ;
	}
	if ($teamid1 == $teamid2 || ($score1 + $score2) < 40 || ($score1 + $score2) > 79 || ($score1 != 40 && $score2 != 40)) {
		echo "2";
		return ;
	}
	$sth = $db->prepare("insert into matches values (NULL, :season_id, :division, :teamid1, :teamid2, :score1, :score2, :points1, :points2)");
	$sth->bindValue(':season_id', $season_id, PDO::PARAM_INT);
	$sth->bindValue(':division', $division, PDO::PARAM_INT);
	$sth->bindValue(':teamid1', $teamid1, PDO::PARAM_INT);
	$sth->bindValue(':teamid2', $teamid2, PDO::PARAM_INT);
	$sth->bindValue(':score1', $score1, PDO::PARAM_INT);
	$sth->bindValue(':score2', $score2, PDO::PARAM_INT);
	$sth->bindValue(':points1', $points1, PDO::PARAM_INT);
	$sth->bindValue(':points2', $points2, PDO::PARAM_INT);
	$sth->execute();
	echo "success";
} catch (Exception $e) {
	echo $e;
}