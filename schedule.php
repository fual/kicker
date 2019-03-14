<?php
	require_once __DIR__ . "/inc/bootstrap.php";
	require_once __DIR__ . "/inc/layout/head.php";
	$sth = $db->prepare("select 
		s.team_id1 as team_id1,
		s.team_id2 as team_id2,
		ht.team_name_short as team_name1,
		at.team_name_short as team_name2,
		date_start,
		date_end,
		date_scheduled,
		place,
		tour
		from schedule as s
		inner join teams as ht on ht.team_id = s.team_id1
		inner join teams as at on at.team_id = s.team_id2
		where s.tournament_id = 1"
	);
	$sth->execute();
	$schedule = $sth->fetchAll();
	// var_dump($schedule);
?>
<body class="pt-5">
<main role="main" class="container">
  	<div class="starter-template pt-0">
    	<h2>Расписание</h2>
	  	<table class="table table-hover text-center table-sm" id="schedule">
	  		<thead class="thead-dark">
	  			<tr>
	  				<th colspan="2">Команды</th>
	  				<th>Место</th>
	  				<th>Время</th>
	  			</tr>
	  		</thead>
	  		<tbody>
			  	<?php $i = 1; ?>
			  	<?php foreach ($schedule as $game): ?>
			  		<?php if ($i == $game['tour']): ?>
			  			<tr>
			  				<td colspan="4">
			  					<?php echo $i++; ?> тур <span class="px-3">-</span> <?php echo $game['date_start']
			  					. " - " . $game['date_end']; ?>
		  					</td>
			  			</tr>
			  		<?php endif; ?>
			  		<tr>
			  			<td><?php echo $game['team_name1']; ?></td>
			  			<td><?php echo $game['team_name2']; ?></td>
			  			<td>
							<?php if (!isset($game['place'])): ?>
								<input type="text" class="form-control">
							<?php else: ?>
			  					<?php echo $game['place']; ?>
							<?php endif; ?>
						</td>
			  			<td>
							<?php if (!isset($game['place'])): ?>
								<input type="text" class="form-control">
							<?php else: ?>
			  					<?php echo $game['date_scheduled']; ?>
							<?php endif; ?>
						</td>
			  		</tr>
			  	<?php endforeach; ?>
			</tbody>
  		</table>
  	</div>
</main>
<div class="loading-icon"></div>
<?php require_once __DIR__ . "/inc/layout/footer.php"; ?>
</body>
</html>