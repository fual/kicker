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
/* find player by id */
function find_player_name_by_id($player_id, $players_query) {
	foreach ($players_query as $player)
		if ($player['id'] == $player_id)
			return ($player['second_name'] . " " . $player['first_name']);
	return ("Т");
}

function print_ratings($division, $type, $season) {
	global $db;
	$sth = $db->prepare("
		with player as (
			select 
			player_id11 as id,
			count(*) as played,
			sum(score1) as scored,
			sum(score2) as conceded
			from games
			group by id
			union all
			select
			player_id12 as id,
			count(*) as played,
			sum(score1) as scored,
			sum(score2) as conceded
			from games
			where player_id12 is not null
			group by id
			union all
			select player_id21 as id,
			count(*) as played,
			sum(score2) as scored,
			sum(score1) as conceded
			from games
			group by id
			union all
			select
			player_id22 as id,
			count(*) as played,
			sum(score2) as scored,
			sum(score1) as conceded
			from games
			where id is not null
			group by id
		),
		participation as (
			with lineups as (
				select * from rosters
				inner join games on rosters.id = games.player_id11
				union all
				select * from rosters
				inner join games on rosters.id = games.player_id12
				union all
				select * from rosters
				inner join games on rosters.id = games.player_id21
				union all
				select * from rosters
				inner join games on rosters.id = games.player_id22
			),
			team_matches as (
				with tm as (
				select team_id1 as team_id, count(*) as count_matches from matches
				group by team_id1
				union all
				select team_id2 as team_id, count(*) as count_matches from matches
				group by team_id2
				)
				select team_id, sum(count_matches) as team_matches from tm group by team_id
			)
			select id, team_matches.team_id, count(distinct(lineups.match_id)) as participated, team_matches from lineups
			inner join team_matches on lineups.team_id = team_matches.team_id
			where tournament_id = :t and season_id = :s 
			group by id
		)
		select player.id, rosters.tournament_id as tournament, sum(player.played) as played, sum(player.scored) as scored, sum(player.conceded) as conceded, sum(player.scored) - sum(player.conceded) as diff, first_name as first_name, second_name as name, rosters.rating as rating, team_name_short as team, participated, team_matches from player
		inner join rosters on rosters.id = player.id
		inner join players on players.player_id = rosters.player_id
		inner join teams on rosters.team_id = teams.team_id
		inner join participation on participation.id = player.id
		where rosters.tournament_id = :t and rosters.season_id = :s
		group by player.id
		order by rating desc, diff desc, played desc;
	");
	$sth->bindValue(":t", $division, PDO::PARAM_INT);
	$sth->bindValue(":s", $season, PDO::PARAM_INT);
	$sth->execute();
	$players = $sth->fetchAll();
	if ($type == 2) {
		$sth = $db->prepare("
			with player as (
				select 
				player_id11 as id,
				count(*) as played,
				sum(score1) as scored,
				sum(score2) as conceded
				from games
				group by id
				union all
				select
				player_id12 as id,
				count(*) as played,
				sum(score1) as scored,
				sum(score2) as conceded
				from games
				where player_id12 is not null
				group by id
				union all
				select player_id21 as id,
				count(*) as played,
				sum(score2) as scored,
				sum(score1) as conceded
				from games
				group by id
				union all
				select
				player_id22 as id,
				count(*) as played,
				sum(score2) as scored,
				sum(score1) as conceded
				from games
				where id is not null
				group by id
			),
			won as (
				with amGames as (
					select games.match_id, player_id11, player_id12, player_id21, player_id22, sum(score1) as score1, sum(score2) as score2 
					from games
					inner join matches on matches.match_id = games.match_id
					inner join tournaments on matches.tournament_id = tournaments.tournament_id
					where tournament_type = 2 and tournaments.tournament_id = :t
					group by games.match_id, player_id11, player_id12, player_id21, player_id22
				)
				select 
				player_id11 as id,
				count(*) as won
				from amGames
				where score1 = 10
				group by id
				union all
				select
				player_id12 as id,
				count(*) as won
				from amGames
				where player_id12 is not null and score1 = 10
				group by id
				union all
				select player_id21 as id,
				count(*) as won
				from amGames
				where score2 = 10
				group by id
				union all
				select
				player_id22 as id,
				count(*) as won
				from amGames
				where id is not null and score2 = 10
				group by id
			),
			lost as (
				with amGames as (
					select games.match_id, player_id11, player_id12, player_id21, player_id22, sum(score1) as score1, sum(score2) as score2 
					from games
					inner join matches on matches.match_id = games.match_id
					inner join tournaments on matches.tournament_id = tournaments.tournament_id
					where tournament_type = 2 and tournaments.tournament_id = :t
					group by games.match_id, player_id11, player_id12, player_id21, player_id22
				)
				select 
				player_id11 as id,
				count(*) as lost
				from amGames
				where score2 = 10
				group by id
				union all
				select
				player_id12 as id,
				count(*) as lost
				from amGames
				where player_id12 is not null and score2 = 10
				group by id
				union all
				select player_id21 as id,
				count(*) as lost
				from amGames
				where score1 = 10
				group by id
				union all
				select
				player_id22 as id,
				count(*) as lost
				from amGames
				where id is not null and score1 = 10
				group by id
			)
			select * from player
			inner join won on player.id = won.id
			inner join lost on player.id = lost.id
		");
		$sth->bindValue(":t", $division, PDO::PARAM_INT);
		$sth->execute();
		$test = $sth->fetchAll();
		var_dump($test);
	}
	$i = 1;
	echo "<table class='table table-sm table-striped table-hover table-ratings'>";
	echo "<thead class='thead-dark'>";
	echo "<tr>";
	echo "<th>№</th>";
	echo "<th>Игрок</th>";
	echo "<th>Команда</th>";
	echo "<th>Партий</th>";
	if ($type == 2) {
		echo "<th>Побед</th>";
		echo "<th>Поражений</th>";
		echo "<th>Ничьих</th>";
	}
	echo "<th>Забито</th>";
	echo "<th>Пропущено</th>";
	echo "<th>Разница</th>";
	echo "<th>Участие в играх</th>";
	echo "<th>Рейтинг</th>";
	echo "<th>Процент участия</th>";
	echo "</tr>";
	echo "</thead>";
	echo "<tbody>";
	foreach ($players as $player) {
		foreach ($players as $player1) {
			if (strpos($player['name'], " ") || $player1['id'] == $player['id'])
				continue ;
			if ($player1['name'] == $player['name']) {
				if (substr($player['first_name'], 0, 2) != substr($player1['first_name'], 0, 2)) {
					$player['name'] .= " " . substr($player['first_name'], 0, 2) . ".";
					$player1['name'] .= " " . substr($player1['first_name'], 0, 2) . ".";
				} else {
					$player['name'] .= " " . $player['first_name'];
					$player1['name'] .= " " . $player1['first_name'];
				}
			}
		}
		echo "<tr>";
		echo "<td>" . $i++ ."</td>";
		echo "<td class='text-left'>" . $player['name'] . "</td>";
		echo "<td>" . $player['team'] . "</td>";
		echo "<td>" . ($type == 2 ? $player['played'] / 2 : $player['played']). "</td>";
		if ($type == 2) {
			echo "<td>0</td>";
			echo "<td>0</td>";
			echo "<td>0</td>";
		}
		echo "<td>" . $player['scored'] . "</td>";
		echo "<td>" . $player['conceded'] . "</td>";
		echo "<td>" . $player['diff'] . "</td>";
		echo "<td>" . $player['participated'] . "</td>";
		echo "<td>" . $player['rating'] . "</td>";
		echo "<td>" . round($player['participated'] / $player['team_matches'] * 100) . "%</td>";
		echo "</tr>";
	}
	echo "</tbody>";
	echo "</table>";
}
