<?php
require __DIR__ . '/../inc/bootstrap.php';
try {
	$id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
	$score1 = filter_var($_POST['score1'], FILTER_SANITIZE_NUMBER_INT);
	$score2 = filter_var($_POST['score2'], FILTER_SANITIZE_NUMBER_INT);
	if (($score1 + $score2) < 40 || ($score1 + $score2) > 79 || ($score1 != 40 && $score2 != 40)) {
		echo "2";
		return ;
	}
	$sth = $db->prepare("update matches set sets_won1 = :s1, sets_won2 = :s2 where match_id = :id");
	$sth->bindValue(':s1', $score1, PDO::PARAM_INT);
	$sth->bindValue(':s2', $score2, PDO::PARAM_INT);
	$sth->bindValue(':id', $id, PDO::PARAM_INT);
	$sth->execute();
	echo "success";
} catch (Exception $e) {
	echo $e;
}