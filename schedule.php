<?php
	require_once __DIR__ . "/inc/bootstrap.php";
	require_once __DIR__ . "/inc/layout/head.php";
	$sth = $db->prepare("select
		s.id as id,
		s.team_id1 as team_id1,
		s.team_id2 as team_id2,
		ht.team_name_short as team_name1,
		at.team_name_short as team_name2,
		date_start,
		date_end,
		date,
		s.place_id,
		tour
		from schedule as s
		inner join teams as ht on ht.team_id = s.team_id1
		inner join teams as at on at.team_id = s.team_id2
		where s.tournament_id = 1"
	);
	$sth->execute();
	$schedule = $sth->fetchAll();
	$sth = $db->prepare("select * from places");
	$sth->execute();
	$places = $sth->fetchAll();
	// var_dump($schedule);
?>
<body class="pt-5">
<main role="main" class="container">
  	<div class="starter-template pt-0">
    	<h2>Расписание</h2>
    	<?php if (isset($_GET['result'])): ?>
    		<?php if ($_GET['result'] == "success"): ?>
    			<p class="bg-success text-white mt-3" id="result">
    			<?php if (isset($_GET['code']) && $_GET['code'] == "1"): ?>
    			Расписание успешно изменено.
	    		<?php endif; ?>
    		<?php elseif ($_GET['result'] == "error"): ?>
	    		<p class="bg-danger text-white mt-3" id="result">
    			<?php if ($_GET['code'] == "3"): ?>
	    		К сожалению, возникли проблемы с соединением. Пожалуйста, попробуйте позже.
	    		<?php endif; ?>
	    	<?php endif; ?>
    		</p>
    	<?php endif; ?>
	  	<table class="table table-hover text-center table-sm" id="schedule">
	  		<thead class="thead-dark">
	  			<tr>
	  				<th>Команды</th>
	  				<th>Место</th>
	  				<th>Время</th>
	  			</tr>
	  		</thead>
	  		<tbody>
			  	<?php $i = 1; ?>
			  	<?php foreach ($schedule as $game): ?>
			  		<?php if ($i == $game['tour']): ?>
			  			<tr>
			  				<td colspan="3" class="font-italic">
			  					<?php echo $i++; ?> тур <span class="px-3">-</span> <?php echo $game['date_start']
			  					. "-" . $game['date_end']; ?>
		  					</td>
			  			</tr>
			  		<?php endif; ?>
			  		<tr>
			  			<td><?php echo $game['team_name1']; ?> - <?php echo $game['team_name2']; ?></td>
			  			<td>
							<select class="form-control<?php if (!isset($game['place_id'])) echo " show"; ?>" name="place" id="place" data-schedule="<?php echo $game['id']; ?>">
								<option value="0">Место ...</option>
								<?php foreach ($places as $place): ?>
									<option value="<?php echo $place['place_id']; ?>"<?php if ($game['place_id'] == $place['place_id']) echo " selected"; ?>>
										<?php echo $place['name']; ?>
									</option>
								<?php endforeach; ?>
							</select>
		  					<span class="schedule-place<?php if (isset($game['place_id'])) echo " show"; ?>">
		  						<?php foreach ($places as $place): ?>
			  						<?php if ($place['place_id'] == $game['place_id']) echo $place['name']; ?>
			  					<?php endforeach; ?>
	  						</span>
						</td>
			  			<td>
							<input type="date" class="form-control<?php if (!isset($game['date'])) echo " show"; ?>" name="date" id="date" data-schedule="<?php echo $game['id']; ?>">
		  					<span class="schedule-date<?php if (isset($game['date'])) echo " show"; ?>"><?php echo $game['date']; ?></span>
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