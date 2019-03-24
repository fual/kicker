<?php
	require_once __DIR__ . "/inc/bootstrap.php";
	require_once __DIR__ . "/inc/layout/head.php";
?>
<body>
<main role="main" class="container">
  	<div class="starter-template text-center">
        <!--<div class="alert alert-warning">
            В данный момент разворачивается большой патч. Пожалуйста, не вносите новые данные в течение часа - они будут утерены.
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
        <div class="d-flex align-items-center mt-4 mb-3 flex-column flex-md-row">
            <h2 class="text-left">Ближайшие игры</h2>
            <a href="schedule.php" class="btn btn-primary mr-auto mr-md-0 ml-md-auto">Расписание</a>
        </div>
        <div class="table-responsive">
            <?php include __DIR__ . "/inc/layout/templates/next_games.php"; ?>
        </div>
    	<div class="d-flex align-items-center mt-4 mb-3">
	  		<h2 class="text-left">Первый дивизион</h2>
	  		<a href="input.php?tournament=1" class="btn btn-success ml-auto">+ счет</a>
	  	</div>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#firstDivTeamsPane" id="firstDivTeamsTab" data-toggle="tab" role="tab">Команды</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#firstDivPlayersPane" id="firstDivPlayersTab" data-toggle="tab" role="tab">Игроки</a>
            </li>
        </ul>
        <div class="tab-content mt-3">
            <div class="tab-pane fade show active" id="firstDivTeamsPane">
                <div class="table-responsive">
                    <?php print_result_table(1, "2019"); ?>
                </div>
            </div>
            <div class="tab-pane fade text-left" id="firstDivPlayersPane">
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
                    <?php print_ratings(1, 1); ?>
                </div>
            </div>
        </div>
  		<div class="d-flex align-items-center mt-4 mb-3">
	  		<h2 class="text-left">Второй дивизион</h2>
	  		<a href="input.php?tournament=2" class="btn btn-success ml-auto">+ счет</a>
	  	</div>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#secondDivTeamsPane" id="secondDivTeamsTab" data-toggle="tab" role="tab">Команды</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#secondDivPlayersPane" id="secondDivPlayersTab" data-toggle="tab" role="tab">Игроки</a>
            </li>
        </ul>
        <div class="tab-content mt-3">
            <div class="tab-pane fade show active" id="secondDivTeamsPane">
          		<div class="table-responsive">
            		<?php print_result_table(2, "2019"); ?>
        	    </div>
            </div>
            <div class="tab-pane fade text-left" id="secondDivPlayersPane">
                <div class="table-responsive">
                    <form class="d-flex mb-2 px-1" id="search2">
                        <input type="text" name="search2" class="form-control w-75 mr-3 my-1" placeholder="Искать">
                        <button type="submit" class="btn btn-primary ml-auto mr-2 my-1">
                            <i class="fas fa-search"></i>
                        </button>
                        <button class="btn btn-danger my-1" id="clear2">
                            <i class="fas fa-times"></i>
                        </button>
                    </form>
                    <?php print_ratings(2, 1); ?>
                </div>
            </div>
        </div>
    	<p class="small mt-5">Нажмите на счет, чтобы просмотреть счет по сетам. Свяжитесь с <a href="http://vk.com/aantropov">нами</a> в случае ошибки.</p>
    	<p class="small mt-5">Recently released: функция "скрыть состав" для заполнения на одном устройстве, рейтинг игроков, поиск по рейтингу, подробные результаты игр, выделение сегодняшних игр, фильтр расписания, расписание предстоящих игр с площадками, +/-.</p>
    	<p class="small mt-3">Upcoming updates: заполнение протокола онлайн, личные кабинеты для капитанов, управление ростером.</p>
    	<p class="small mt-3">Contribute: <a href="https://github.com/aleksanderantropov/kicker">github</a>.</p>
  	</div>
</main>
<?php require_once __DIR__ . "/inc/layout/footer.php"; ?>
</body>
</html>