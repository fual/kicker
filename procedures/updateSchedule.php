<?php
require __DIR__ . '/../inc/bootstrap.php';
try {
	$sth = $db->prepare("update schedule set place_id = :p, date = :d, time = :t where id = :id");
	$id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
	$sth->bindValue(':id', $id, PDO::PARAM_INT);
	$place = isset($_POST['place']) && $_POST['place'] != 0 ? filter_var($_POST['place'], FILTER_SANITIZE_NUMBER_INT) : NULL;
	$sth->bindValue(':p', $place, PDO::PARAM_INT);
	if (isset($_POST['date']) && $_POST['date'] != "") {
		$date = filter_var($_POST['date'], FILTER_SANITIZE_STRING);
		$sth->bindValue(':d', $date, PDO::PARAM_STR);
	}
	else
		$sth->bindValue(':d', NULL, PDO::PARAM_INT);
	if (isset($_POST['time']) && $_POST['time'] != "") {
		$time = filter_var($_POST['time'], FILTER_SANITIZE_STRING);
		$sth->bindValue(':t', $time, PDO::PARAM_STR);
	}
	else
		$sth->bindValue(':t', NULL, PDO::PARAM_INT);
	$sth->execute();
	echo "success";
} catch (Exception $e) {
	echo $e;
}