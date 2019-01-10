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
		$sth = $db->prepare("select * from teams");
		$sth->execute();
		$teams = $sth->fetchAll();
		$sth = $db->prepare("select count(team_name_short) from teams where tournament_id = 1");
		$sth->execute();
		$team_quantity = $sth->fetch()[0];
		var_dump($team_quantity);
		echo '<table>';
		echo '<thead>';
		echo '<tr>';
		echo '<th>Команда</th>';
		for ($i = 0; $i < $team_quantity; $i++)
			echo '<th сolspan="2">' . $teams[$i]['team_name_short'] . '</th>';
		echo '<th>Очки</th>';
		echo '<th>Игры</th>';
		echo '<th>Осталось</th>';
		echo '</tr>';
		for ($i = 0; $i < $team_quantity; $i++) {
			echo '<tr>';
			echo '<td>' . $teams[$i]['team_name_short'] . '</td>';
			echo '</tr>';
		}
	?>
</body>
</html>