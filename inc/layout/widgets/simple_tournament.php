<?php $season_id = get_latest_season_id($tournament["tournament_id"]); ?>
<div class="d-flex align-items-center mt-4 mb-3">
    <h2 class="text-left"><?php echo $tournament["tournament_description"]; ?></h2>
    <a href="<?php echo $subfolder; ?>/input.php?tournament=<?php echo $tournament["tournament_id"]; ?>" class="btn btn-success ml-auto">+ счет</a>
</div>
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" href="#divTeamsPane<?php echo $tournament["tournament_id"]; ?>" id="firstDivTeamsTab" data-toggle="tab" role="tab">Команды</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#divPlayersPane<?php echo $tournament["tournament_id"]; ?>" id="firstDivPlayersTab" data-toggle="tab" role="tab">Игроки</a>
    </li>
</ul>
<div class="tab-content mt-3">
    <div class="tab-pane fade show active" id="divTeamsPane<?php echo $tournament["tournament_id"]; ?>">
        <div class="table-responsive">
            <?php print_result_table($tournament["tournament_id"]); ?>
        </div>
    </div>
    <div class="tab-pane fade text-left" id="divPlayersPane<?php echo $tournament["tournament_id"]; ?>">
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
            <?php print_ratings($tournament["tournament_id"], $tournament["tournament_type"], $season_id); ?>
        </div>
    </div>
</div>