<?php
	require_once __DIR__ . "/inc/bootstrap.php";
	require_once __DIR__ . "/inc/layout/head.php";
	if (isset($_GET['search']) && $_GET['search'] != "0") {
		$team = filter_var($_GET['search'], FILTER_SANITIZE_STRING);
		$sth = $db->prepare("select
			s.id as id,
			s.tournament_id,
			s.team_id1 as team_id1,
			s.team_id2 as team_id2,
			ht.team_name_short as team_name1,
			at.team_name_short as team_name2,
			tour,
			date_start,
			date_end,
			s.place_id,
			date,
			time
			from schedule as s
			inner join teams as ht on ht.team_id = s.team_id1
			inner join teams as at on at.team_id = s.team_id2
			where (date is NULL or date >= date(datetime('now', '-1 day'), 'localtime') or place_id is NULL or time is NULL) and (team_name1 == :team or team_name2 == :team)
			order by tour"
		);
		$sth->bindValue(":team", $team, PDO::PARAM_STR);
	} else
		$sth = $db->prepare("select
			s.id as id,
			s.tournament_id,
			s.team_id1 as team_id1,
			s.team_id2 as team_id2,
			ht.team_name_short as team_name1,
			at.team_name_short as team_name2,
			tour,
			date_start,
			date_end,
			s.place_id,
			date,
			time
			from schedule as s
			inner join teams as ht on ht.team_id = s.team_id1
			inner join teams as at on at.team_id = s.team_id2
			where date is NULL or date >= date(datetime('now', '-1 day'), 'localtime') or place_id is NULL or time is NULL
			order by tour"
		);
	$sth->execute();
	$schedule = $sth->fetchAll();
	$sth = $db->prepare("select * from places order by name");
	$sth->execute();
	$places = $sth->fetchAll();
	$sth = $db->prepare("select team_name_short as name from teams order by team_name_short");
	$sth->execute();
	$teams = $sth->fetchAll();
	// var_dump($schedule);
?>
<body>
<main role="main" class="container">
  	<div class="starter-template text-left">
  		<a href="/" class="btn btn-primary mt-4">Назад</a>
    	<?php if (isset($_GET['result'])): ?>
    		<?php if ($_GET['result'] == "success"): ?>
			<div class="alert alert-success mt-3 result" id="result">
    			Расписание успешно изменено.
    		<?php elseif ($_GET['result'] == "error"): ?>
    		<div class="alert alert-danger mt-3 result" id="result">
	    		К сожалению, возникли проблемы с соединением. Пожалуйста, попробуйте позже.
	    	<?php endif; ?>
    		</div>
    	<?php endif; ?>
		<h2 class="text-center mt-3 mb-3">Расписание</h2>
    	<?php include __DIR__ . "/inc/layout/templates/schedule_table.php"; ?>
    	<p class="small mt-4">Заполните все поля, чтобы игра появилась на главной странице. Игры доступны для редактирования 1 день со дня указанного в столбце "Дата".</p>
  	</div>
</main>
<div class="loading-icon"></div>
<?php require_once __DIR__ . "/inc/layout/footer.php"; ?>
</body>
</html>