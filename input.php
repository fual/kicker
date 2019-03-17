<?php
	require_once __DIR__ . "/inc/bootstrap.php";
	require_once __DIR__ . "/inc/layout/head.php";
	$sth = $db->prepare("select tournament_id as id, tournament_description as name from tournaments where id in (1, 2) order by tournament_name");
	$sth->execute();
	$tournaments = $sth->fetchAll();
	$sth = $db->prepare("select tournament_id as division, team_name_long as name, team_id as id from teams where division in (1, 2) order by name");
	$sth->execute();
	$teams = $sth->fetchAll();
	if (isset($_GET['tournament']))
		$tournament_id = $_GET['tournament'];
?>
<body class="pt-5">
<main role="main" class="container">
  	<div class="starter-template pt-0">
		<h2>Добавить результат</h2>
		<?php if (isset($tournament_id)): ?>
		<h4>
			<?php echo $tournament_id == 1 ? "Первый дивизион" : "Второй дивизион"; ?>
		</h4>
		<?php endif; ?>
		<form method="post" action="" id="addResult" class="mt-4">
			<?php if (!isset($tournament_id)): ?>
	    		<div class="mb-2">
	    			<label class="sr-only" for="inputTournament">Выберите дивизион</label>
		    		<select class="custom-select" id="inputTournament" name="division" required>
		    		    <option selected>Дивизион...</option>
		    		    <?php foreach ($tournaments as $tournament): ?>
		    		    <option value="<?php echo $tournament['id']; ?>">
		    		    	<?php echo $tournament['name']; ?>
		    		    </option>
		    		    <?php endforeach; ?>
		    		</select>
		    	</div>
		    	<?php for ($i = 1; $i < 3 ; $i++): ?>
		    	<div class="form-row" id="<?php echo ($i == 1 ? "firstDiv" : "secondDiv"); ?>" style="display:none;">
		    		<?php for ($j = 1; $j < 3; $j++): ?>
		    		<div class="col-md my-1">
		    			<select class="custom-select" id="inputTeam<?php echo $i . $j; ?>" name="team<?php echo $i . $j; ?>" required>
		    			    <option value="0" selected>Команда <?php echo $j; ?>...</option>
		    				<?php foreach ($teams as $team): ?>
		    					<?php if ($team['division'] == "$i") {
		    						echo "<option value='" . $team['id'] . "'>" 
		    									. $team['name'] . "</option>";
		    					}
		    	    			?>
		    				<?php endforeach; ?>
		    			</select>
		    		</div>
		    		<?php endfor; ?>
		    	</div>
	    	<?php endfor; ?>
	    	<?php else: ?>
	    		<input type="hidden" name="division" value="<?php echo $tournament_id; ?>">
	    		<div class="form-row" id="<?php echo ($tournament_id == 1 ? "firstDiv" : "secondDiv"); ?>">
	    			<?php for ($j = 1; $j < 3; $j++): ?>
	    			<div class="col-md my-1">
	    				<select class="custom-select" id="inputTeam<?php echo $tournament_id . $j; ?>" name="team<?php echo $tournament_id . $j; ?>" required>
	    				    <option value="0" selected>Команда <?php echo $j; ?>...</option>
	    					<?php foreach ($teams as $team): ?>
	    						<?php if ($team['division'] == "$tournament_id") {
	    							echo "<option value='" . $team['id'] . "'>" 
	    										. $team['name'] . "</option>";
	    						}
	    		    			?>
	    					<?php endforeach; ?>
	    				</select>
	    			</div>
	    			<?php endfor; ?>
	    		</div>
		    <?php endif;?>
	    	<div class="form-row mt-2" id="score"<?php if (!isset($tournament_id)) echo ' style="display:none;"'; ?>>
	    		<div class="col">
		    		<input type="number" class="form-control" id="inputScore1" placeholder="Счет команды 1" name="score1" required>
		    	</div>
		    	<div class="col-auto d-none d-md-flex align-items-center">
		    		<span class="mx-1">:</span>
		    	</div>
		    	<div class="col">
		    		<input type="number" class="form-control" id="inputScore2" placeholder="Счет команды 2" name="score2" required>
		    	</div>
		    	<div class="col-auto ml-2">
		    		<button type="submit" class="btn btn-success" disabled="true">Отправить</button>
		    	</div>
	    	</div>
		</form>
		<div class="text-left mt-5">
			<a href="/" class="btn btn-primary">Назад</a>
		</div>
	</div>
</main>
<div class="loading-icon"></div>
<?php require_once __DIR__ . "/inc/layout/footer.php"; ?>
</body>
</html>