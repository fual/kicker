<?php
require __DIR__ . '/../inc/bootstrap.php';
try {
	$id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
	$sth = $db->prepare("delete from matches where match_id = :id");
	$sth->bindValue(':id', $id, PDO::PARAM_INT);
	$sth->execute();
	echo "success";
} catch (Exception $e) {
	echo $e;
}