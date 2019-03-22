<?php
require __DIR__ . '/../inc/bootstrap.php';
$team1 = filter_var($_POST['team1'], FILTER_SANITIZE_NUMBER_INT);
$team2 = filter_var($_POST['team2'], FILTER_SANITIZE_NUMBER_INT);
$sth = $db->prepare("select count(*) as qty from matches where team_id1 in (:teamid1, :teamid2) and team_id2 in (:teamid1, :teamid2)");
$sth->bindValue(':teamid1', $team1, PDO::PARAM_INT);
$sth->bindValue(':teamid2', $team2, PDO::PARAM_INT);
$sth->execute();
$count = $sth->fetch();
if ($count['qty'] < 2) {
	echo "success";
	return ;
}
echo "error";