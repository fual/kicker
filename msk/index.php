<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/inc/bootstrap.php";
$pageTitle = "Московская лига кикера";
require_once $_SERVER["DOCUMENT_ROOT"] . "/inc/layout/head.php";
$sth = $db->prepare("select * from tournaments where tournament_type = 1");
$sth->execute();
$pro_tournaments = $sth->fetchAll();

$sth = $db->prepare("select * from tournaments where tournament_id in (7, 8)");
$sth->execute();
$group_tournaments = $sth->fetchAll();

$sth = $db->prepare("select * from tournaments where tournament_id = 4");
$sth->execute();
$amateur_tournaments = $sth->fetchAll();
$tournaments = array_merge($pro_tournaments, $group_tournaments, $amateur_tournaments);
?>

<body>
	<main role="main" class="container">
		<div class="starter-template text-center">
			<!--<div class="alert alert-warning small">
            Добавляем сыгранные матчи и рейтинг для любителей. Не вводите сыгранные матчи любителей самостоятельно - мы добавляем их по-очереди, чтобы правильно рассчитать рейтинг. Остальные функции сайта доступны без ограничений
        </div>-->
			<?php if (isset($_GET['result'])) : ?>
				<?php if ($_GET['result'] == "success") : ?>
					<div class="alert alert-success mt-3 result" id="result">
						<?php if (isset($_GET['code']) && $_GET['code'] == "1") : ?>
							Результат успешно изменен.
						<?php elseif (isset($_GET['code']) && $_GET['code'] == "2") : ?>
							Матч успешно удален.
						<?php else : ?>
							Результат успешно добавлен.
						<?php endif; ?>
					<?php elseif ($_GET['result'] == "error") : ?>
						<div class="alert alert-danger mt-3 result" id="result">
							<?php if ($_GET['code'] == "3") : ?>
								К сожалению, возникли проблемы с соединением. Пожалуйста, попробуйте позже.
							<?php endif; ?>
						<?php endif; ?>
						</div>
					<?php endif; ?>
					<?php include $_SERVER["DOCUMENT_ROOT"] . "/inc/layout/widgets/schedule.php"; ?>
					<?php foreach ($pro_tournaments as $tournament) {
						include $_SERVER["DOCUMENT_ROOT"] . "/inc/layout/widgets/simple_tournament.php";
					} ?>
					<div class="d-flex align-items-center mt-4 mb-3">
						<h2 class="text-left">ЛКЛ</h2>
					</div>
					<ul class="nav nav-tabs">
						<li class="nav-item">
							<a class="nav-link active" href="#divTeamsPane5" id="firstDivTeamsTab" data-toggle="tab" role="tab">Команды</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#divPlayersPane5" id="firstDivPlayersTab" data-toggle="tab" role="tab">Игроки</a>
						</li>
					</ul>
					<div class="tab-content mt-3">
						<div class="tab-pane fade show active" id="divTeamsPane5">
							<div class="table-responsive">
								<?php foreach ($group_tournaments as $tournament) : ?>
									<div class="d-flex align-items-center mt-4 mb-3">
										<h5 class="text-left"><?php echo $tournament["tournament_description"]; ?></h5>
										<a href="<?php echo $subfolder; ?>/input.php?tournament=<?php echo $tournament["tournament_id"]; ?>" class="btn btn-success ml-auto">+ счет</a>
									</div>
									<?php print_result_table($tournament["tournament_id"]); ?>
								<?php endforeach; ?>
							</div>
						</div>
						<div class="tab-pane fade text-left" id="divPlayersPane5">
							<div class="table-responsive">
								<form class="d-flex mb-2 px-1" id="search1">
									<input type="text" name="search1" class="form-control w-75 mr-3 my-1" placeholder="Искать">
									<button type="submit" class="btn btn-primary ml-auto mr-2 my-1">
										<i class="fas fa-search"></i>
									</button>
									<button class="btn btn-danger my-1" id="clear1">
										<i class="fas fa-times"></i>
									</button>
								</form>
								<?php print_ratings($group_tournaments[0]["tournament_id"], $tournament["tournament_type"], 3, $group_tournaments[1]["tournament_id"]); ?>
							</div>
						</div>
					</div>
					<?php foreach ($amateur_tournaments as $tournament) {
						include $_SERVER["DOCUMENT_ROOT"] . "/inc/layout/widgets/simple_tournament.php";
					} ?>
					</div>
	</main>
	<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/inc/layout/footer.php"; ?>
</body>

</html>