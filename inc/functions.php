<?php

function request() {
    return \Symfony\Component\HttpFoundation\Request::createFromGlobals();
}

function findUserByLogin($login) {
	global $db;

	try {
		$query = "SELECT * FROM users WHERE login = :login";
		$stmt = $db->prepare($query);
		$stmt->bindParam(":login", $login);
		$stmt->execute();
		return ($stmt->fetch());
	} catch (\Exception $e) {
		throw $e;
	}
}

function display_errors() {
	global $session;
	if (!$session->getFlashBag()->has("error"))
		return;
	$messages = $session->getFlashBag()->get("error");
	$response = "<div class='alert alert-danger alert-dismissable'>";
	foreach ($messages as $message)
		$response .= "{$message}<br>";
	$response .= "</div>";
	return ($response);
}

function display_success() {
	global $session;
	if (!$session->getFlashBag()->has("success"))
		return;
	$messages = $session->getFlashBag()->get("succes");
	$response = "<div class='alert alert-success alert-dismissable'>";
	foreach ($messages as $message)
		$response .= "{$message}<br>";
	$response .= "</div>";
	return ($response);
}

function redirect($path, $extra = []) {
	$response = \Symfony\Component\HttpFoundation\Response::create(null ,
	\Symfony\Component\HttpFoundation\Response::HTTP_FOUND, ['Location' => $path]);
	if (key_exists('cookies', $extra)) {
		foreach ($extra['cookies'] as $cookie) {
			$response->headers->setCookie($cookie);
		}
	}
	$response->send();
	exit;
}

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
			where trn.tournament_id = ? and s.season_name = ?
		");
	$sth->execute(array($division, $season));
	$tournament = $sth->fetch();
	/* teams names ordered by points scored */
	$sql = "with points_table as
			(select
			ht.team_name_short as name,
			sum(m.points_1) as points,
			count(*) as games_played,
			sum(sets_won1) as scored,
			sum(sets_won2) as conceded
			from teams as ht
			inner join matches as m on ht.team_id = m.team_id1
			where m.tournament_id = :tournament_id and m.season_id = :season_id
			group by name
			union all
			select
			at.team_name_short as name,
			sum(m.points_2) as points,
			count(*) as games_played,
			sum(sets_won2) as scored,
			sum(sets_won1) as conceded
			from teams as at
			inner join matches as m on at.team_id = m.team_id2
			where m.tournament_id = :tournament_id and m.season_id = :season_id
			group by name)
			select name, sum(points) as points, sum(games_played) as games_played, sum(scored) - sum(conceded) as goal_diff, ((:qty - 1) * :r - sum(games_played)) as games_left
			from points_table
			group by name
			order by points desc, goal_diff desc";
	$sth = $db->prepare($sql);
	$sth->bindValue(':tournament_id', $tournament['tournament_id'], PDO::PARAM_INT);
	$sth->bindValue(':season_id', $tournament['season_id'], PDO::PARAM_INT);
	$sth->bindValue(':qty', $tournament['teams_quantity'], PDO::PARAM_INT);
	$sth->bindValue(':r', $tournament['rounds'], PDO::PARAM_INT);
	$sth->execute();
	$standings = $sth->fetchAll();
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
	$results = $sth->fetchAll();
	$cols = $tournament['teams_quantity'] + 5;
	if (count($standings) < $tournament['teams_quantity'])
	{
		$sth = $db->prepare("select team_name_short as name from teams where tournament_id = :tournament_id order by name");
		$sth->bindValue(':tournament_id', $tournament['tournament_id'], PDO::PARAM_INT);
		$sth->execute();
		$teams = $sth->fetchAll();
		foreach ($teams as $team)
		{
			$double = 0;
			foreach ($standings as $standing)
				if ($team['name'] == $standing['name'])
					$double = 1;
			if (!$double)
			{
				$team['points'] = '0';
				$team['goal_diff'] = '0';
				$team['games_played'] = '0';
				$team['games_left'] = ''.($tournament['teams_quantity'] - 1) * $tournament['rounds'];
				array_push($standings, $team);
			}
		}
	}
	echo '<table class="table table-striped table-hover text-center table-sm">';
	echo '<thead class="thead-dark">';
	echo '<tr>';
	echo '<th>Команда</th>';
	for ($i = 0; $i < $tournament['teams_quantity']; $i++)
		echo '<th сolspan="2">' . $standings[$i]['name'] . '</th>';
	echo '<th>Очки</th>';
	echo '<th>+/-</th>';
	echo '<th>Игры</th>';
	echo '<th>Осталось</th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
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
					echo '<td class="bg-dark"></td>';
					break ;
				case ($cols - 4):
					echo '<td>' . $standings[$i]['points'] . '</td>';
					break ;
				case ($cols - 3):
					echo '<td>' . $standings[$i]['goal_diff'] . '</td>';
					break ;
				case ($cols - 2):
					echo '<td>' . $standings[$i]['games_played'] . '</td>';
					break ;
				case ($cols - 1):
					echo '<td>' . $standings[$i]['games_left'] . '</td>';
					break ;
				default:
					$away_team = $standings[$j - 1]['name'];
					echo '<td>' . find_match_results($home_team, $away_team, $results, $tournament) . '</td>';
					break ;
			}
		}
		echo '</tr>';
	}
	echo '</tbody>';
	echo '</table>';
}
/* find match results in 2-dimensional array */
function find_match_results($home_team, $away_team, $results, $tournament) {
	$res = " ";
	foreach ($results as $result)
		if ($result['home_team'] == $home_team && $result['away_team'] == $away_team)
		{
			if ($result['away_score'] != "t" || $result['home_score'] != "t")
				$res .= '<a href="match.php?id=' . $result['match_id'] . '">';
			$res .= $result['home_score'] . ':' . $result['away_score'];
			if ($result['away_score'] != "t" || $result['home_score'] != "t")
				$res .= '</a>';
			$res .= " ";
		}
		else if ($result['away_team'] == $home_team && $result['home_team'] == $away_team)
		{
			if ($result['away_score'] != "t" || $result['home_score'] != "t")
				$res .= '<a href="match.php?id=' . $result['match_id'] . '">';
			$res .= $result['away_score'] . ':' . $result['home_score'];
			if ($result['away_score'] != "t" || $result['home_score'] != "t")
				$res .= '</a>';
			$res .= " ";
		}
	if (!(strlen($res) - 1))
	{
		$i = $tournament['rounds'];
		while ($i--)
			$res .= " - ";
	}
	return ($res);
}