<?php
	require_once __DIR__ . "/inc/bootstrap.php";
	require_once __DIR__ . "/inc/layout/head.php";
?>
<body class="pt-3">
<main role="main" class="container">
  	<div class="starter-template pt-0 text-center">
    	<?php if (isset($_GET['result'])): ?>
    		<?php if ($_GET['result'] == "success"): ?>
    			<p class="bg-success text-white mt-3" id="result">
    			<?php if (isset($_GET['code']) && $_GET['code'] == "1"): ?>
    			Результат успешно изменен
    			<?php elseif (isset($_GET['code']) && $_GET['code'] == "2"): ?>
    			Матч успешно удален
				<?php else: ?>
    			Результат успешно добавлен
	    		<?php endif; ?>
    		<?php elseif ($_GET['result'] == "error"): ?>
	    		<p class="bg-danger text-white mt-3" id="result">
    			<?php if ($_GET['code'] == "1"): ?>
    			К сожалению, нельзя добавить более двух матчей с участием этих команд.
    			<?php elseif ($_GET['code'] == "2"): ?>
    			Пожалуйста, проверьте правильность введенных данных.
	    		<?php else: ?>
	    		К сожалению, возникли проблемы с соединением. Пожалуйста, попробуйте позже.
	    		<?php endif; ?>
	    	<?php endif; ?>
    		</p>
    	<?php endif; ?>
    	<div class="d-flex align-items-center mt-4 mb-3">
	  		<h2 class="text-left">Первый дивизион</h2>
	  		<a href="input.php?tournament=1" class="btn btn-success ml-auto">+ счет</a>
	  	</div>
  		<div class="table-responsive">
	    	<?php print_result_table(1, "2019"); ?>
	    </div>
  		<div class="d-flex align-items-center mt-4 mb-3">
	  		<h2 class="text-left">Второй дивизион</h2>
	  		<a href="input.php?tournament=2" class="btn btn-success ml-auto">+ счет</a>
	  	</div>
  		<div class="table-responsive">
    		<?php print_result_table(2, "2019"); ?>
	    </div>
    	<p class="small mt-5">Нажмите на счет, чтобы отредактировать. Свяжитесь с <a href="http://vk.com/aantropov">нами</a> в случае ошибки.</p>
    	<p class="small mt-5">Recently released: редактирование и удаление счета, +/-.</p>
    	<p class="small mt-3">Upcoming updates: расписание предстоящих игр с площадками, рейтинг игроков, заполнение протокола онлайн, личные кабинеты для капитанов, управление ростером.</p>
    	<p class="small mt-3">Contribute: <a href="https://github.com/aleksanderantropov/kicker">github</a>.</p>
  	</div>
</main>
<div class="loading-icon"></div>
<?php require_once __DIR__ . "/inc/layout/footer.php"; ?>
</body>
</html>