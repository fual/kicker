<?php
require_once __DIR__ . "/inc/bootstrap.php";
// $db->query('');
// $sth = $db->prepare("select * from teams where tournament_id = 3");
// $sth->execute();
// $teams = $sth->fetchAll();
// var_dump($teams);
$db->query("
	insert into schedule values
	(NULL, 1, 4, 1, 27, 29, 8.04, 14.04, NULL, NULL, NULL),
	(NULL, 1, 4, 1, 26, 28, 8.04, 14.04, NULL, NULL, NULL),
	(NULL, 1, 4, 1, 24, 25, 8.04, 14.04, NULL, NULL, NULL),
	(NULL, 1, 4, 2, 28, 27, 15.04, 21.04, NULL, NULL, NULL),
	(NULL, 1, 4, 2, 30, 26, 15.04, 21.04, NULL, NULL, NULL),
	(NULL, 1, 4, 2, 29, 24, 15.04, 21.04, NULL, NULL, NULL),
	(NULL, 1, 4, 3, 27, 26, 22.04, 28.04, NULL, NULL, NULL),
	(NULL, 1, 4, 3, 28, 29, 22.04, 28.04, NULL, NULL, NULL),
	(NULL, 1, 4, 3, 25, 30, 22.04, 28.04, NULL, NULL, NULL),
	(NULL, 1, 4, 4, 24, 27, 29.04, 5.05, NULL, NULL, NULL),
	(NULL, 1, 4, 4, 28, 25, 29.04, 5.05, NULL, NULL, NULL),
	(NULL, 1, 4, 4, 29, 30, 29.04, 5.05, NULL, NULL, NULL),
	(NULL, 1, 4, 5, 27, 25, 6.05, 12.05, NULL, NULL, NULL),
	(NULL, 1, 4, 5, 30, 24, 6.05, 12.05, NULL, NULL, NULL),
	(NULL, 1, 4, 6, 30, 27, 13.05, 19.05, NULL, NULL, NULL),
	(NULL, 1, 4, 6, 28, 24, 13.05, 19.05, NULL, NULL, NULL),
	(NULL, 1, 4, 7, 30, 28, 20.05, 26.05, NULL, NULL, NULL),
	(NULL, 1, 4, 7, 25, 29, 20.05, 26.05, NULL, NULL, NULL),
	(NULL, 1, 4, 8, 29, 27, 27.05, 2.06, NULL, NULL, NULL),
	(NULL, 1, 4, 8, 28, 26, 27.05, 2.06, NULL, NULL, NULL),
	(NULL, 1, 4, 8, 25, 24, 27.05, 2.06, NULL, NULL, NULL),
	(NULL, 1, 4, 9, 26, 30, 3.06, 9.06, NULL, NULL, NULL),
	(NULL, 1, 4, 10, 26, 27, 10.06, 16.06, NULL, NULL, NULL),
	(NULL, 1, 4, 10, 29, 28, 10.06, 16.06, NULL, NULL, NULL),
	(NULL, 1, 4, 10, 30, 25, 10.06, 16.06, NULL, NULL, NULL),
	(NULL, 1, 4, 11, 27, 24, 17.06, 23.06, NULL, NULL, NULL),
	(NULL, 1, 4, 11, 25, 28, 17.06, 23.06, NULL, NULL, NULL),
	(NULL, 1, 4, 11, 30, 29, 17.06, 23.06, NULL, NULL, NULL),
	(NULL, 1, 4, 12, 24, 30, 24.06, 30.06, NULL, NULL, NULL),
	(NULL, 1, 4, 13, 27, 30, 1.07, 7.07, NULL, NULL, NULL),
	(NULL, 1, 4, 13, 24, 28, 1.07, 7.07, NULL, NULL, NULL),
	(NULL, 1, 4, 13, 25, 26, 1.07, 7.07, NULL, NULL, NULL),
	(NULL, 1, 4, 14, 26, 24, 8.07, 14.07, NULL, NULL, NULL);
");
