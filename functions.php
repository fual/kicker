<?php
/* utility function to display database tables */
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
/* print standings */
function print_result_table($division, $season) {
	global $db;
	/* teams quantity in the given $season and $division */
	$sth = $db->prepare("
			select
			count(tms.team_name_short) as teams_quantity,
			trn.tournament_rounds as rounds,
			trn.tournament_id as tournament_id,
			s.season_id as season_id
			from teams as tms
			inner join tournaments as trn on trn.tournament_id = tms.tournament_id
			inner join seasons as s on tms.season_id = s.season_id
			where trn.tournament_name = ? and s.season_name = ?
		");
	$sth->execute(array($division, $season));
	$tournament = $sth->fetch();
	/* teams names ordered by points scored */
	$sql = "
			with points_table as
			(select
			ht.team_name_short as name,
			sum(m.points_1) as points,
			count(*) as games_played
			from teams as ht
			inner join matches as m on ht.team_id = m.team_id1
			where m.tournament_id = :tournament_id and m.season_id = :season_id
			group by name
			union all
			select
			at.team_name_short as name,
			sum(m.points_2) as points,
			count(*) as games_played
			from teams as at
			inner join matches as m on at.team_id = m.team_id2
			where m.tournament_id = :tournament_id and m.season_id = :season_id
			group by name)
			select name, sum(points) as points, sum(games_played) as games_played, ((:qty - 1) * :r - sum(games_played)) as games_left
			from points_table
			group by name
			order by points desc";
	$sth = $db->prepare($sql);
	$sth->bindValue(':tournament_id', $tournament['tournament_id'], PDO::PARAM_INT);
	$sth->bindValue(':season_id', $tournament['season_id'], PDO::PARAM_INT);
	$sth->bindValue(':qty', $tournament['teams_quantity'], PDO::PARAM_INT);
	$sth->bindValue(':r', $tournament['rounds'], PDO::PARAM_INT);
	$sth->execute();
	$standings = $sth->fetchAll();
	var_dump($standings);
	exit;
	$sth = $db->prepare("
			select
			m.match_id as match_id,
			m.season_id as season_id,
			m.tournament_id as tournament_id,
			ht.team_name_short as home_team,
			at.team_name_short as away_team,
			m.sets_won1 as home_score,
			m.sets_won2 as away_score
			from matches as m
			inner join teams as ht on ht.team_id = m.team_id1
			inner join teams as at on at.team_id = m.team_id2
			where m.season_id = :season_id and m.tournament_id = :tournament_id
		");
	$sth->bindValue(':tournament_id', $tournament['tournament_id'], PDO::PARAM_INT);
	$sth->bindValue(':season_id', $tournament['season_id'], PDO::PARAM_INT);
	$sth->execute();
	// $sth->execute(array(1, 1));
	$results = $sth->fetchAll();
	echo '<table>';
	echo '<thead>';
	echo '<tr>';
	echo '<th>Команда</th>';
	for ($i = 0; $i < $tournament['teams_quantity']; $i++)
		echo '<th сolspan="2">' . $standings[$i]['name'] . '</th>';
	echo '<th>Очки</th>';
	echo '<th>Игры</th>';
	echo '<th>Осталось</th>';
	echo '</tr>';
	$cols = $tournament['teams_quantity'] + 4;
	for ($i = 0; $i < $tournament['teams_quantity']; $i++) {
		echo '<tr>';
		for ($j = 0; $j < $cols; $j++)
		{
			$home_team = $standings[$i]['name'];
			switch ($j)
			{
				case 0:
					echo '<td>' . $home_team . '</td>';
					break ;
				case ($i + 1):
					echo '<td style="background-color:gray;"></td>';
					break ;
				case ($cols - 3):
					echo '<td>' . $standings[$i]['points'] . '</td>';
					break ;
				case ($cols - 2):
					echo '<td>' . $standings[$i]['games_played'] . '</td>';
					break ;
				case ($cols - 1):
					echo '<td>' . $standings[$i]['games_left'] . '</td>';
					break ;
				default:
					$away_team = $standings[$j - 1]['name'];
					echo '<td>' . find_match_results($home_team, $away_team, $results) . '</td>';
					break ;
			}
		}
		echo '</tr>';
	}
}
/* find match results in 2-dimensional array */
function find_match_results($home_team, $away_team, $results) {
	$res = " ";
	foreach ($results as $result)
		if ($result['home_team'] == $home_team && $result['away_team'] == $away_team)
		{
			$res .= '<a href="match?id=' . $result['match_id'] . '">';
			$res .= $result['home_score'] . ':' . $result['away_score'];
			$res .= '</a>' . " ";
		}
		else if ($result['away_team'] == $home_team && $result['home_team'] == $away_team)
		{
			$res .= '<a href="match?id=' . $result['match_id'] . '">';
			$res .= $result['away_score'] . ':' . $result['home_score'];
			$res .= '</a>' . " ";
		}
	return ($res);
}