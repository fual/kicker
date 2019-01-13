<html lang="ru">
<head>
	<title>Kicker</title>
	<meta charset="UTF-8">
</head>
<body>
	<?php
		require_once 'autoload.php';
		$division = "mos2";
		$season = "2018";	
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
		var_dump($tournament['tournament_id']);
		/* teams names ordered by points scored */
		$sth = $db->prepare("
				with points_table as
				(select
				ht.team_name_short as name,
				sum(m.points_1) as points,
				count(*) as games_played
				from teams as ht
				inner join matches as m on ht.team_id = m.team_id1
				where m.tournament_id = ?
				group by name
				union all
				select
				at.team_name_short as name,
				sum(m.points_2) as points,
				count(*) as games_played
				from teams as at
				inner join matches as m on at.team_id = m.team_id2
				where m.tournament_id = ?
				group by name)
				select name, sum(points) as points, sum(games_played) as games_played, ((? - 1) * ? - sum(games_played)) as games_left
				from points_table
				group by name
				order by points desc
			");
		$sth->execute(
			array(
				$tournament['tournament_id'],
				$tournament['tournament_id'],
				$tournament['teams_quantity'],
				$tournament['rounds']
			)
		);
		$standings = $sth->fetchAll();
		var_dump($standings);
		$sth = $db->prepare("
				select
				m.match_id as match_id,
				ht.team_name_short as home_team,
				at.team_name_short as away_team,
				m.sets_won1 as home_score,
				m.sets_won2 as away_score
				from matches as m
				inner join teams as ht on ht.team_id = m.team_id1
				inner join teams as at on at.team_id = m.team_id2
			");
		$sth->execute();
		$results = $sth->fetchAll();
		/* match results */
		// print_result_table();
		// print_table("select * from teams");
		// print_table("select * from tournaments");
		// print_table("select * from matches");
	?>
</body>
</html>