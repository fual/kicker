<?php
require __DIR__ . '/../inc/bootstrap.php';
try {
	$id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
	if (isset($_POST['date'])) {
		$sth = $db->prepare("update schedule set date = :d where id = :id");
		if ($_POST['date'] != "0") {
			$date = filter_var($_POST['date'], FILTER_SANITIZE_STRING);
			$sth->bindValue(':d', $date, PDO::PARAM_STR);
		}
		else
			$sth->bindValue(':d', NULL, PDO::PARAM_INT);
	}
	if (isset($_POST['place'])) {
		$place = $_POST['place'] ? filter_var($_POST['place'], FILTER_SANITIZE_NUMBER_INT) : NULL;
		$sth = $db->prepare("update schedule set place_id = :p where id = :id");
		$sth->bindValue(':p', $place, PDO::PARAM_INT);
	}
	$sth->bindValue(':id', $id, PDO::PARAM_INT);
	$sth->execute();
	echo "success";
} catch (Exception $e) {
	echo $e;
}