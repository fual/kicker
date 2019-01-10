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
		} catch ( \Exception $e ) {
		    echo 'Error connecting to the Database: ' . $e->getMessage();
		    exit;
		}
		$tournaments = $db->query("select * from tournaments");
		echo '<table>';
		echo '<thead>';
		echo '<tr>';
		echo '<th>tournament_id</th>';
		echo '<th>tournament_name</th>';
		echo '</tr>';
		echo '</thead>';
		foreach ($tournaments as $tournament)
		{
			echo '<tr>';
			echo '<td>' . $tournament['tournament_id'] . '</td>';
			echo '<td>' . $tournament['tournament_name'] . '</td>';
			echo '</tr>';
		}
		echo '</table>';
		$teams = $db->query("select * from teams");
		echo '<table>';
		echo '<thead>';
		echo '<tr>';
		echo '<th>team_id</th>';
		echo '<th>tournament_id</th>';
		echo '<th>team_name_short</th>';
		echo '<th>team_name_long</th>';
		echo '</tr>';
		echo '</thead>';
		foreach ($teams as $team)
		{
			echo '<tr>';
			echo '<td>' . $team['team_id'] . '</td>';
			echo '<td>' . $team['tournament_id'] . '</td>';
			echo '<td>' . $team['team_name_short'] . '</td>';
			echo '<td>' . $team['team_name_long'] . '</td>';
			echo '</tr>';
		}
		echo '</table>';
		$matches = $db->query("select * from matches");
		echo '<table>';
		echo '<thead>';
		echo '<tr>';
		echo '<th>match_id</th>';
		echo '<th>tournament_id</th>';
		echo '<th>team_id1</th>';
		echo '<th>team_id2</th>';
		echo '<th>sets_won1</th>';
		echo '<th>sets_won2</th>';
		echo '<th>points_1</th>';
		echo '<th>points_2</th>';
		echo '</tr>';
		echo '</thead>';
		foreach ($matches as $match)
		{
			echo '<tr>';
			echo '<td>' . $match['match_id'] . '</td>';
			echo '<td>' . $match['tournament_id'] . '</td>';
			echo '<td>' . $match['team_id1'] . '</td>';
			echo '<td>' . $match['team_id2'] . '</td>';
			echo '<td>' . $match['sets_won2'] . '</td>';
			echo '<td>' . $match['points_1'] . '</td>';
			echo '<td>' . $match['points_2'] . '</td>';
			echo '</tr>';
		}
		echo '</table>';
		/*$q = $db->query("select tournaments.tournament_name, teams.team_name_short from teams inner join tournaments on tournaments.tournament_id = teams.tournament_id");
		foreach ($q as $test)
		{
			echo "<p>" . $test['tournament_name'] ."</p>";
			echo "<p>" . $test['team_name_short'] ."</p>";
		}*/
		$division = "mos2";
		$sth = $db->prepare("select * from teams ");
		$sth->execute();
		$teams = $sth->fetchAll();
		$sth = $db->prepare("select count(tms.team_name_short) from teams as tms inner join tournaments as trn on trn.tournament_id = tms.tournament_id where trn.tournament_name = ?");
		$sth->execute(array($division));
		$teams_quantity = $sth->fetch()[0];
		echo '<table>';
		echo '<thead>';
		echo '<tr>';
		echo '<th>Команда</th>';
		for ($i = 0; $i < $teams_quantity; $i++)
			echo '<th сolspan="2">' . $teams[$i]['team_name_short'] . '</th>';
		echo '<th>Очки</th>';
		echo '<th>Игры</th>';
		echo '<th>Осталось</th>';
		echo '</tr>';
		// $sth = $db->prepare("select t.team_name_short, t.team_name_short, m.sets_won1, m.sets_won2 from matches as m inner join teams as t on m.team_id1 = t.team_id and m.team_id2 = t.team_id inner join tournaments as trn on m.tournament_id = trn.tournament_id t.tournament_ = ");
		$sth = $db->prepare("
			select 
			ft.team_name_short as home_team, 
			st.team_name_short as away_team,
			m.sets_won1 as home_sets_won,
			m.sets_won2 as away_sets_won
			from matches as m 
			inner join teams as ft on m.team_id1 = ft.team_id
			inner join teams as st on m.team_id2 = st.team_id");
		$sth->execute();
		$results = $sth->fetchAll();
		var_dump($results);
		$cols = $teams_quantity + 4;
		for ($i = 0; $i < $teams_quantity; $i++) {
			$home_team = $teams[$i]['team_name_short'];
			echo '<tr>';
			for ($j = 0; $j < $cols; $j++)
			{
				switch ($j)
				{
					case 0:
						echo '<td>' . $home_team . '</td>';
						break ;
					case ($i + 1):
						echo '<td style="background-color:gray;"></td>';
						break ;
					default:
						echo '<td></td>';
						break ;
				}
				
			}
			echo '</tr>';
		}
	?>
</body>
</html>