<?php
	require_once __DIR__ . "/../../bootstrap.php";
	$sth = $db->prepare("select
		s.id as id,
		s.tournament_id,
		s.team_id1 as team_id1,
		s.team_id2 as team_id2,
		ht.team_name_short as team_name1,
		at.team_name_short as team_name2,
		tour,
		p.name as place,
		date,
		time
		from schedule as s
		inner join teams as ht on ht.team_id = s.team_id1
		inner join teams as at on at.team_id = s.team_id2
		inner join places as p on s.place_id = p.place_id
		where date is not NULL and date >= date(datetime(), 'localtime') and time is not NULL and place is not NULL
		order by date, time"
	);
	$sth->execute();
	$next_games = $sth->fetchAll();
	// var_dump($next_games);
?>
<?php if (sizeof($next_games)): ?>
<table class="table table-sm table-striped table-hover text-center">
	<thead class="thead-dark">
		<tr>
			<th>Див.</th>
			<th>Тур</th>
			<th>Команды</th>
			<th>Место</th>
			<th>Дата</th>
			<th>Время</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($next_games as $next): ?>
			<tr<?php if (date_format(date_create($next['date']), "j.m") == date_format(date_create("now"), "j.m")) echo " class='bg-warning font-italic'"; ?>>
				<td title="
					<?php 
						switch ($next['tournament_id']) {
							case "1":
								echo "Первый";
								break;
							case "2":
								echo "Второй";
								break;
							case "3":
								echo "ЛКЛ";
								break;
							case "4":
								echo "ЗКЛ";
								break;
						}
					?>
				">
					<?php 
						switch ($next['tournament_id']) {
							case "1":
								echo "П";
								break;
							case "2":
								echo "В";
								break;
							case "3":
								echo "Л";
								break;
							case "4":
								echo "З";
								break;
						}
					?>
					
				</td>
				<td><?php echo $next['tour']; ?></td>
				<td><?php echo $next['team_name1'] . " - " . $next['team_name2']; ?></td>
				<td><?php echo $next['place']; ?></td>
				<td><?php echo date_format(date_create($next['date']), "j.m"); ?></td>
				<td><?php echo $next['time']; ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php else: ?>
	<p>Предстоящих игр не запланировано. Здесь появятся игры, внесенные в расписание.</p>
<?php endif; ?>