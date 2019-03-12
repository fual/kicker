<?php
	require_once __DIR__ . "/inc/bootstrap.php";
	require_once __DIR__ . "/inc/layout/head.php";
	$sth = $db->prepare("select tournament_id as id, tournament_description as name from tournaments where id in (1, 2) order by tournament_name");
	$sth->execute();
	$tournaments = $sth->fetchAll();
	$sth = $db->prepare("select tournament_id as division, team_name_long as name, team_id as id from teams where division in (1, 2) order by name");
	$sth->execute();
	$teams = $sth->fetchAll();
?>
<body class="pt-3">
<main role="main" class="container">
  	<div class="starter-template pt-0 text-center">
    	<?php if (isset($_GET['result'])): ?>
    		<?php if ($_GET['result'] == "success"): ?>
	    		<p class="bg-success text-white mt-3" id="result">
    			Результат успешно добавлен
    		<?php elseif ($_GET['result'] == "error"): ?>
	    		<p class="bg-danger text-white mt-3" id="result">
    			<?php if ($_GET['code'] == "1"): ?>
    			К сожалению, нельзя добавить более двух матчей с участием этих команд.
    			<?php elseif ($_GET['code'] == "2"): ?>
    			Пожалуйста, проверьте правильность введенных данных.
	    		<?php else: ?>
	    		К сожалению, возникли проблемы с содинением. Пожалуйста, попробуйте позже.
	    		<?php endif; ?>
	    	<?php endif; ?>
    		</p>
    	<?php endif; ?>
    	<h2 class="mb-3">Добавить результат</h2>
    	<form method="post" action="" id="addResult">
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
		    <div class="form-row mt-2" id="score" style="display:none;">
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
		    		<button type="submit" class="btn btn-success" disabled="true">Отправить</button>
		    	</div>
	    	</div>
    	</form>
  		<h2 class="mt-4 mb-3">Первый дивизион</h2>
  		<div class="table-responsive">
	    	<?php print_result_table(1, "2019"); ?>
	    </div>
  		<h2 class="mt-4 mb-3">Второй дивизион</h2>
  		<div class="table-responsive">
    		<?php print_result_table(2, "2019"); ?>
	    </div>
    	<p class="small mt-5">Если результат какого-либо матча отображен неверно, свяжитесь с <a href="http://vk.com/aantropov">нами</a>.</p>
    	<p class="small mt-5">Upcoming updates: редактирование счета, расписание предстоящих игр с площадками, рейтинг игроков, заполнение протокола онлайн, личные кабинеты для капитанов, управление ростером.</p>
    	<p class="small mt-3">Contribute: <a href="https://github.com/aleksanderantropov/kicker">github</a>.</p>
  	</div>
</main>
<div class="loading-icon"></div>
<?php require_once __DIR__ . "/inc/layout/footer.php"; ?>
</body>
</html>