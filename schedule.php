<?php
	require_once __DIR__ . "/inc/bootstrap.php";
	require_once __DIR__ . "/inc/layout/head.php";
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
		where date is NULL or date >= date('now', '-2 day') or place_id is NULL or time is NULL
		order by tour"
	);
	$sth->execute();
	$schedule = $sth->fetchAll();
	$sth = $db->prepare("select * from places");
	$sth->execute();
	$places = $sth->fetchAll();
	// var_dump($schedule);
?>
<body>
<main role="main" class="container">
  	<div class="starter-template text-left">
  		<a href="/" class="btn btn-primary">Назад</a>
    	<?php if (isset($_GET['result'])): ?>
    		<?php if ($_GET['result'] == "success"): ?>
    			<p class="bg-success text-white mt-3 result" id="result">
    			<?php if (isset($_GET['code']) && $_GET['code'] == "1"): ?>
    			Расписание успешно изменено.
	    		<?php endif; ?>
    		<?php elseif ($_GET['result'] == "error"): ?>
	    		<p class="bg-danger text-white mt-3 result" id="result">
    			<?php if ($_GET['code'] == "3"): ?>
	    		К сожалению, возникли проблемы с соединением. Пожалуйста, попробуйте позже.
	    		<?php endif; ?>
	    	<?php endif; ?>
    		</p>
    	<?php endif; ?>
		<h2 class="text-center mt-4 mb-3">Расписание</h2>
    	<?php include __DIR__ . "/inc/layout/templates/schedule_table.php"; ?>
    	<p class="small mt-4">Заполните все поля, чтобы игра появилась на главной странице. Игры доступны для редактирования 3 дня со дня указанного в столбце "Дата".</p>
  	</div>
</main>
<div class="loading-icon"></div>
<?php require_once __DIR__ . "/inc/layout/footer.php"; ?>
</body>
</html>