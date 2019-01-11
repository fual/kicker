<html lang="ru">
<head>
	<title>Kicker</title>
	<meta charset="UTF-8">
</head>
<body>
	<?php
		try {
		    $db = new PDO( 'sqlite:'.__DIR__.'/database' );
		    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		} catch ( \Exception $e ) {
		    echo 'Error connecting to the Database: ' . $e->getMessage();
		    exit;
		}
		$division = "mos2";
		$season = "2018";
		print_table("select * from seasons");
		print_table("select * from tournaments");
		print_table("select * from teams");
		print_table("select * from matches");
		/* teams quantity in the given $season and $division */
		$sth = $db->prepare("
				select count(tms.team_name_short) as number from teams as tms
				inner join tournaments as trn on trn.tournament_id = tms.tournament_id
				inner join seasons as s on tms.season_id = s.season_id
				where trn.tournament_name = ? and s.season_name = ?
			");
		$sth->execute(array($division, $season));
		$teams_quantity = $sth->fetch()['number'];
		/* teams names ordered by points scored */
		$sth = $db->prepare("
				select t.team_name_short as name from teams as t
				inner join matches as m on t.team_id = m.team_id1
			");
		$sth->execute();
		$teams_names_by_pts = $sth->fetchAll();
		var_dump($teams_names_by_pts);
		/* */
		$sth = $db->prepare("
				select 
				ft.team_name_short as home_team, 
				st.team_name_short as away_team,
				m.sets_won1 as home_sets_won,
				m.sets_won2 as away_sets_won
				from matches as m 
				inner join teams as ft on m.team_id1 = ft.team_id
				inner join teams as st on m.team_id2 = st.team_id
			");
		$sth->execute();
		$results = $sth->fetchAll();
		var_dump($results);
		echo '<table>';
		echo '<thead>';
		echo '<tr>';
		echo '<th>Команда</th>';
		// for ($i = 0; $i < $teams_quantity; $i++)
		// 	echo '<th сolspan="2">' . $teams[$i]['team_name_short'] . '</th>';
		echo '<th>Очки</th>';
		echo '<th>Игры</th>';
		echo '<th>Осталось</th>';
		echo '</tr>';
		$cols = $teams_quantity + 4;
		// for ($i = 0; $i < $teams_quantity; $i++) {
		// 	$home_team = $results[$i]['home_team'];
		// 	echo '<tr>';
		// 	for ($j = 0; $j < $cols; $j++)
		// 	{
		// 		switch ($j)
		// 		{
		// 			case 0:
		// 				echo '<td>' . $home_team . '</td>';
		// 				break ;
		// 			case ($i + 1):
		// 				echo '<td style="background-color:gray;"></td>';
		// 				break ;
		// 			default:
		// 				echo '<td></td>';
		// 				break ;
		// 		}
				
		// 	}
		// 	echo '</tr>';
		// }
		$db->query("update tournaments set tournament_description = 'Москва - 2 дивизион'");

		/* Utility function to display database tables */
		function print_table($sql) {
			global $db;
			$sth = $db->prepare($sql);
			$sth->execute();
			$array = $sth->fetchAll();
			echo '<table>';
			echo '<thead>';
			echo '<tr>';
			foreach (array_keys($array[0]) as $th)
				echo '<th>'. $th . '</td>';
			echo '</tr>';
			echo '</thead>';
			foreach ($array as $arr)
			{
				echo '<tr>';
				foreach ($arr as $property)
					echo '<td>' . $property . '</td>';
				echo '</tr>';
			}
			echo '</table>';
		}
	?>
</body>
</html>