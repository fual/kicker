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
				with points_table as
				(select
				ht.team_name_short as name,
				sum(m.points_1) as points,
				count(*) as games_played
				from teams as ht
				inner join matches as m on ht.team_id = m.team_id1
				group by name
				union all
				select
				at.team_name_short as name,
				sum(m.points_2) as points,
				count(*) as games_played
				from teams as at
				inner join matches as m on at.team_id = m.team_id2
				group by name)
				select name, sum(points) as points, sum(games_played) as games_played, ((? - 1) * 2 - sum(games_played)) as games_left
				from points_table
				group by name
				order by points desc
			");
		$sth->execute(array($teams_quantity));
		$teams_names_by_pts = $sth->fetchAll();
		/* match results */
		$sth = $db->prepare("
				select
				ht.team_name_short as team,
				at.team_name_short as opponent,
				(m.sets_won1 || ':' || m.sets_won2) as score
				from matches as m
				inner join teams as ht on ht.team_id = m.team_id1
				inner join teams as at on at.team_id = m.team_id2
			");
		$sth->execute();
		$results = $sth->fetchAll();
		echo '<table>';
		echo '<thead>';
		echo '<tr>';
		echo '<th>Команда</th>';
		for ($i = 0; $i < $teams_quantity; $i++)
			echo '<th сolspan="2">' . $teams_names_by_pts[$i]['name'] . '</th>';
		echo '<th>Очки</th>';
		echo '<th>Игры</th>';
		echo '<th>Осталось</th>';
		echo '</tr>';
		$cols = $teams_quantity + 4;
		for ($i = 0; $i < $teams_quantity; $i++) {
			echo '<tr>';
			for ($j = 0; $j < $cols; $j++)
			{
				$home_team = $teams_names_by_pts[$i]['name'];
				switch ($j)
				{
					case 0:
						echo '<td>' . $home_team . '</td>';
						break ;
					case ($i + 1):
						echo '<td style="background-color:gray;"></td>';
						break ;
					case ($cols - 3):
						echo '<td>' . $teams_names_by_pts[$i]['points'] . '</td>';
						break ;
					case ($cols - 2):
						echo '<td>' . $teams_names_by_pts[$i]['games_played'] . '</td>';
						break ;
					case ($cols - 1):
						echo '<td>' . $teams_names_by_pts[$i]['games_left'] . '</td>';
						break ;
					default:
						$opponent = $teams_names_by_pts[$j - 1]['name'];
						echo '<td>' . find_match_result($home_team, $opponent) . ' ' . find_match_result($opponent, $home_team) . '</td>';
						break ;
				}
			}
			echo '</tr>';
		}
		$db->query("update matches set team_id1 = 5, team_id2 = 1 where match_id = 49");

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
		/* find match results in 2-dimensional array */
		function find_match_result($team1, $team2) {
			global $results;
			foreach ($results as $result)
				if ($result['team'] == $team1 && $result['opponent'] == $team2)
					return ($result['score']);
		}
	?>
</body>
</html>