<?php
$subfolder = isset($_POST["subfolder"]) ? "/" . $_POST["subfolder"] : "";
require $_SERVER["DOCUMENT_ROOT"] . '/inc/bootstrap.php';
$team1 = filter_var($_POST['team1'], FILTER_SANITIZE_NUMBER_INT);
$team2 = filter_var($_POST['team2'], FILTER_SANITIZE_NUMBER_INT);
$tournament_id = filter_var($_POST["tournament"], FILTER_SANITIZE_NUMBER_INT);
$sth = $db->prepare("select count(*) as qty from matches where team_id1 in (:teamid1, :teamid2) and team_id2 in (:teamid1, :teamid2)");
$sth->bindValue(':teamid1', $team1, PDO::PARAM_INT);
$sth->bindValue(':teamid2', $team2, PDO::PARAM_INT);
$sth->execute();
$count = $sth->fetch();
$sth = $db->prepare("select tournament_rounds from tournaments where tournament_id = :tid");
$sth->bindValue(":tid", $tournament_id, PDO::PARAM_INT);
$sth->execute();
$rounds = $sth->fetch()["tournament_rounds"];
if ($count['qty'] < $rounds) {
	echo "success";
	return ;
}
echo $rounds;