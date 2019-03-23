<?php
	require_once __DIR__ . "/inc/bootstrap.php";
	require_once __DIR__ . "/inc/layout/head.php";
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$tournament_id = $_GET['tournament'];
		$team1 = $_GET['team1'];
		$team2 = $_GET['team2'];
	}
	if (!isset($_GET['tournament'])) {
		$sth = $db->prepare("select tournament_id as id, tournament_description as name from tournaments where id in (1, 2) order by tournament_name");
		$sth->execute();
		$tournaments = $sth->fetchAll();
	} else {
		$tournament_id = $_GET['tournament'];
		$sth = $db->prepare("select tournament_id, team_name_long as name, team_id as id from teams where tournament_id = :id order by name");
		$sth->bindValue(":id", $tournament_id, PDO::PARAM_INT);
		$sth->execute();
		$teams = $sth->fetchAll();
	}
	if (isset($_GET['team1']) && isset($_GET['team2'])) {
		$team1_id = $_GET['team1'];
		$team2_id = $_GET['team2'];
		foreach ($teams as $team) {
			if ($team['id'] == $team1_id)
				$team1 = $team['name'];
			if ($team['id'] == $team2_id)
				$team2 = $team['name']; 
		}
		$sth = $db->prepare("
			select id, team_id, first_name, second_name from rosters inner join players on rosters.player_id = players.player_id
			where team_id in (:team1, :team2)
			order by second_name
		");
		$sth->bindValue(":team1", $team1_id, PDO::PARAM_INT);
		$sth->bindValue(":team2", $team2_id, PDO::PARAM_INT);
		$sth->execute();
		$players = $sth->fetchAll();
	}
?>
<body class="pt-5">
<main role="main" class="container">
  	<div class="starter-template pt-0">
		<h2>Добавить результат</h2>
		<?php if (isset($tournament_id)): ?>
			<h4><?php echo $tournament_id == 1 ? "Первый дивизион" : "Второй дивизион"; ?></h4>
		<?php endif; ?>
		<?php if (isset($_GET['result']) && $_GET['result'] == "error"): ?>
			<div class="alert alert-danger result" id="result">
				<?php if ($_GET['code'] == "2"): ?>
					К сожалению, нельзя добавить более двух матчей с участием этих команд.
				<?php else: ?>
					К сожалению, возникли проблемы с соединением. Пожалуйста, попробуйте позже.
				<?php endif; ?>
			</div>
		<?php endif; ?>
		<?php include __DIR__ . "/inc/layout/templates/choose_teams.php"; ?>
		<?php if ($_SERVER['REQUEST_METHOD'] != "POST" && isset($team1) && isset($team2)): ?>
	   		<?php include __DIR__ . "/inc/layout/templates/fill_lineup.php"; ?>
		<?php elseif ($_SERVER['REQUEST_METHOD'] == "POST" && isset($team1) && isset($team2)): ?>
	   		<?php include __DIR__ . "/inc/layout/templates/input_score.php"; ?>
	   	<?php elseif ($_SERVER['REQUEST_METHOD'] == "POST"): ?>
	   		<p>К сожалению, возникла ошибка. Свяжитесь с администратором.</p>
   		<?php endif; ?>
		<div class="text-left mt-5">
			<a href="/" class="btn btn-primary">Назад</a>
		</div>
	</div>
</main>
<?php require_once __DIR__ . "/inc/layout/footer.php"; ?>
</body>
</html>