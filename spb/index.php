<?php
		require_once $_SERVER["DOCUMENT_ROOT"] . "/inc/bootstrap.php";
		$pageTitle = "Санкт-Петербургская лига кикера";
        require_once $_SERVER["DOCUMENT_ROOT"] . "/inc/layout/head.php";
        $seasons = array(
            "2019" => array(
                "query" => "select * from tournaments where tournament_id = 1 or tournament_id = 2 or tournament_id = 3"
            ),
            "2020" => array(
                "query" => "select * from tournaments where tournament_id = 5 or tournament_id = 6 or tournament_id = 4"
            )
        );

        $currentSeason = isset($_GET['season']) ? $_GET['season'] : '2020';

        $selectTournamentsQuery = $seasons[$currentSeason]["query"];
        $sth = $db->prepare($selectTournamentsQuery);
        $sth->execute();
        $tournaments = $sth->fetchAll();
?>
<body>
<main role="main" class="container">
  	<div class="starter-template text-center">
        <!--<div class="alert alert-warning small">
            Добавляем сыгранные матчи и рейтинг для любителей. Не вводите сыгранные матчи любителей самостоятельно - мы добавляем их по-очереди, чтобы правильно рассчитать рейтинг. Остальные функции сайта доступны без ограничений
        </div>-->
		<form method="GET" action="" class="needs-validation" novalidate="">
			<div class="row">
				<div class="col-md-2 mb-3">
					<select class="custom-select d-block" id="season" name="season" required>
					<option value="2019" <?php if($currentSeason == '2019') {echo 'selected';} ?>>2019</option>
					<option value="2020" <?php if($currentSeason == '2020') {echo 'selected';} ?>>2020</option>
					</select>
				</div>
				<div class="col-md-2 mb-3">
					<button class="btn btn-primary btn-block" type="submit">Сменить сезон</button>
				</div>
			</div>
		</form>

    	<?php if (isset($_GET['result'])): ?>
    		<?php if ($_GET['result'] == "success"): ?>
    			<div class="alert alert-success mt-3 result" id="result">
    			<?php if (isset($_GET['code']) && $_GET['code'] == "1"): ?>
    			Результат успешно изменен.
    			<?php elseif (isset($_GET['code']) && $_GET['code'] == "2"): ?>
    			Матч успешно удален.
				<?php else: ?>
    			Результат успешно добавлен.
	    		<?php endif; ?>
    		<?php elseif ($_GET['result'] == "error"): ?>
	    		<div class="alert alert-danger mt-3 result" id="result">
    			<?php if ($_GET['code'] == "3"): ?>
	    		К сожалению, возникли проблемы с соединением. Пожалуйста, попробуйте позже.
	    		<?php endif; ?>
	    	<?php endif; ?>
    		</div>
    	<?php endif; ?>
        <?php /*include $_SERVER["DOCUMENT_ROOT"] . "/inc/layout/widgets/schedule.php";*/ ?>
        <?php foreach ($tournaments as $tournament) {
            include $_SERVER["DOCUMENT_ROOT"] . "/inc/layout/widgets/simple_tournament.php";
		} ?>
  	</div>
</main>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/inc/layout/footer.php"; ?>
</body>
</html>