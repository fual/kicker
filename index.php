<html lang="ru">
<head>
	<title>Kicker</title>
	<meta charset="UTF-8">
</head>
<body>
	<?php
		require_once 'autoload.php';
		include 'input.php';
		/* match results */
		// print_table("select * from teams where tournament_id = 3");
		// print_table("select * from matches where tournament_id = 2");
		print_result_table("mos2", "2018");
		print_result_table("mos1", "2018");
		print_result_table("mos3", "2018");
		// print_table("select * from teams");
		// print_table("select * from tournaments");
		// print_table("select * from matches");
		// $test = $db->query("
		// 	select
		// 	ht.team_name_short as name,
		// 	sum(m.points_1) as points,
		// 	count(*) as games_played
		// 	from matches as m
		// 	inner join teams as ht on ht.team_id = m.team_id1
		// 	where m.tournament_id = 2 and m.season_id = 1
		// 	group by name");
		// foreach ($test as $t)
		// {
		// 	foreach ($t as $k => $v)
		// 		echo $k . ' => ' . $v . '<br>';
		// 	echo '<br>';
		// }
	?>
</body>
</html>