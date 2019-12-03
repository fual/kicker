<?php
	require_once $_SERVER["DOCUMENT_ROOT"] . "/inc/bootstrap.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/inc/layout/head.php";
    $sth = $db->prepare("select * from tournaments");
    $sth->execute();
    $tournaments = $sth->fetchAll();
?>
<body>
<main role="main" class="container">
  	<div class="starter-template text-center">
        <!--<div class="alert alert-warning small">
            Добавляем сыгранные матчи и рейтинг для любителей. Не вводите сыгранные матчи любителей самостоятельно - мы добавляем их по-очереди, чтобы правильно рассчитать рейтинг. Остальные функции сайта доступны без ограничений
        </div>-->
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
        <?php include $_SERVER["DOCUMENT_ROOT"] . "/inc/layout/widgets/schedule.php"; ?>
        <?php foreach ($tournaments as $tournament) {
            include $_SERVER["DOCUMENT_ROOT"] . "/inc/layout/widgets/simple_tournament.php";
		} ?>
        <p class="small mt-5">Нажмите на счет, чтобы просмотреть счет по сетам. Свяжитесь с <a href="http://vk.com/aantropov">нами</a> в случае ошибки.</p>
    	<p class="small mt-3">Upcoming updates: заполнение протокола онлайн, личные кабинеты для капитанов, управление ростером.</p>
    	<p class="small mt-3">Contribute: <a href="https://github.com/aleksanderantropov/kicker">github</a>. Обратная связь и изменения: <a href="https://vk.com/topic-58506517_42583616">vk.com</a></p>
  	</div>
</main>
<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/inc/layout/footer.php"; ?>
</body>
</html>