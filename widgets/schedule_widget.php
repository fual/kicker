<div>
    <h2 class="text-left">Ближайшие игры</h2>
    <div class="d-flex align-items-center my-3 flex-wrap">
        <p class="mb-0 mr-3 mb-1">Расписание:</p>
        <div class="d-flex mb-1">
            <a href="schedule.php?tournament=pro" class="btn btn-sm btn-light border-secondary">Профи</a>
            <a href="schedule.php?tournament=amateur" class="btn btn-sm btn-light border-secondary ml-3">Любители</a>
        </div>
    </div>
</div>
<div class="table-responsive">
    <?php include $_SERVER["DOCUMENT_ROOT"] . "/inc/layout/templates/next_games.php"; ?>
</div>