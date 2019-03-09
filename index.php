<?php
	/* match results */
	// print_table("select * from teams where tournament_id = 3");
	// print_table("select * from matches where tournament_id = 2");
	// print_table("select * from teams");
	// print_table("select * from players");
	// print_table("select * from rosters");
	// print_result_table("mos2", "2018");
	// print_result_table("mos1", "2018");
	// print_result_table("mos3", "2018");
	// print_table("select * from tournaments");
	// print_table("select * from matches");
	// $test = $db->query("
	// 	select
	// 	ht.team_name_short as name,
	// 	sum(m.points_1) as points,
	// 	count(*) as games_played
	// 	from matches as m
	// 	inner join teams as ht on ht.team_id = m.team_id1
	// 	where m.tournament_id = 2 and m.season_id = 1
	// 	group by name");
	// foreach ($test as $t)
	// {
	// 	foreach ($t as $k => $v)
	// 		echo $k . ' => ' . $v . '<br>';
	// 	echo '<br>';
	// }
	// $db->query("update teams set team_name_long = 'Работяги 2' where team_id = 6");
	// $db->query("update teams set team_name_long = 'Подзабей' where team_id = 7");
	// $db->query("update teams set team_name_long = 'Научный подход' where team_id = 8");
	// $db->query("update teams set team_name_long = 'Забей' where team_id = 10");
	// $db->query("update teams set team_name_long = 'Работяги' where team_id = 13");
?>
<?php
	require_once __DIR__ . "/inc/bootstrap.php";
	require_once __DIR__ . "/inc/layout/head.php";
	$db->query("update teams set team_name_long = 'ЗАБЕЙ' where team_id = 29");
	$sth = $db->prepare("select tournament_id as id, tournament_description as name from tournaments where id in (4, 5) order by tournament_name");
	$sth->execute();
	$tournaments = $sth->fetchAll();
	$sth = $db->prepare("select tournament_id as division, team_name_long as name, team_id as id from teams where division in (4, 5) order by name");
	$sth->execute();
	$teams = $sth->fetchAll();
?>
<body class="pt-3">
<main role="main" class="container">
  	<div class="starter-template pt-0">
    	<h2 class="mb-3">Добавить результат</h2>
    	<form method="post" action="procedures/addResult.php">
    		<div class="form-row">
    			<div class="col">
		    		<select class="custom-select" id="inputTournament" name="division" required>
		    		    <option selected>Дивизион...</option>
		    		    <?php foreach ($tournaments as $tournament): ?>
		    		    <option value="<?php echo $tournament['id']; ?>">
		    		    	<?php echo $tournament['name']; ?>
		    		    </option>
		    		    <?php endforeach; ?>
		    		</select>
		    	</div>
    			<div class="col">
		    		<select class="custom-select" id="inputTeam1" name="team1" required>
		    		    <option selected>Команда 1...</option>
		    		    <?php foreach ($teams as $team): ?>
		    		    	<option value="<?php echo $team['id']; ?>" data-tournament="<?php echo $team['division']; ?>">
		    		    		<?php echo $team['name']; ?>
		    		    	</option>
		    		    <?php endforeach; ?>
		    		</select>
		    	</div>
    			<div class="col">
		    		<select class="custom-select" id="inputTeam2" name="team2" required>
		    		    <option selected>Команда 2...</option>
		    		    <?php foreach ($teams as $team): ?>
		    		    	<option value="<?php echo $team['id']; ?>" data-tournament="<?php echo $team['division']; ?>">
		    		    		<?php echo $team['name']; ?>
		    		    	</option>
		    		    <?php endforeach; ?>
		    		</select>
		    	</div>
		    </div>
		    <div class="form-row mt-2">
	    		<div class="col">
		    		<input type="number" class="form-control" id="inputScore1" placeholder="Счет команды 1" name="score1" required>
		    	</div>
		    	<div class="col-auto d-flex align-items-center">
		    		<span class="mx-1">:</span>
		    	</div>
		    	<div class="col">
		    		<input type="number" class="form-control" id="inputScore2" placeholder="Счет команды 2" name="score2" required>
		    	</div>
		    	<div class="col-auto ml-2">
		    		<button type="submit" class="btn btn-success">Отправить</button>
		    	</div>
	    	</div>
    	</form>
  		<h2 class="mt-4 mb-3">Первый дивизион</h2>
    	<?php print_result_table(4, "2019"); ?>
  		<h2 class="mt-4 mb-3">Второй дивизион</h2>
    	<?php print_result_table(5, "2019"); ?>
    	<p class="small mt-5">Если результат какого-либо матча отображен неверно, свяжитесь с <a href="http://vk.com/aantropov">нами</a>.</p>
  	</div>
</main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
	$(function() {
		$("#inputTournament").change(function() {
			updateTeamOptions();
		});
		/* updateTeamOptions: manage team names select options on tournament change */
		function updateTeamOptions() {
			var tournament = $("#inputTournament").val();
			$("#inputTeam1 option, #inputTeam2 option").removeAttr("style");
			$("#inputTeam1 [data-tournament!=" + tournament + "], #inputTeam2 [data-tournament!=" + tournament + "]").hide();
		}
	});
</script>
<?php require_once __DIR__ . "/inc/layout/footer.php"; ?>