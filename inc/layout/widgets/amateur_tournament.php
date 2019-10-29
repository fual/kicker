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
            <?php foreach ($amateur_tournaments as $tournament): ?>
                <div class="d-flex align-items-center mt-4 mb-3">
                    <h5 class="text-left"><?php echo $tournament["tournament_description"]; ?></h5>
                    <a href="input.php?tournament=<?php echo $tournament["tournament_id"]; ?>" class="btn btn-success ml-auto">+ счет</a>
                </div>
                <?php print_result_table($tournament["tournament_id"], "2020"); ?>
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
            <?php print_ratings($amateur_tournaments[0]["tournament_id"], $tournament["tournament_type"], 2, $amateur_tournaments[1]["tournament_id"]); ?>
        </div>
    </div>
</div>