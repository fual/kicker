<?php
	require_once __DIR__ . "/inc/bootstrap.php";
	require_once __DIR__ . "/inc/layout/head.php";
	$match_id = $_GET['id'];
	$sth = $db->prepare("select
			m.match_id as match_id,
			m.season_id as season_id,
			m.tournament_id as tournament_id,
			ht.team_name_short as home_team,
			at.team_name_short as away_team,
			m.sets_won1 as home_score,
			m.sets_won2 as away_score
			from matches as m
			inner join teams as ht on ht.team_id = m.team_id1
			inner join teams as at on at.team_id = m.team_id2
			where match_id = ?");
	$sth->execute(array($match_id));
	$match = $sth->fetch();
?>
<body class="pt-5">
<main role="main" class="container">
  	<div class="starter-template pt-0">
    	<h2><?php echo $match['home_team'] . " vs " . $match['away_team']; ?></h2>
    	<p>Match ID <?php echo $match_id; ?></p>
    	<form method="post" action="" id="editResult">
    		<input type="hidden" name="id" value="<?php echo $match_id; ?>">
		    <div class="form-row mt-2" id="score">
	    		<div class="col">
		    		<input type="number" class="form-control" id="inputScore1" placeholder="Счет команды 1" name="score1" value="<?php echo $match['home_score']; ?>" required>
		    	</div>
		    	<div class="col-auto d-flex align-items-center">
		    		<span class="mx-1">:</span>
		    	</div>
		    	<div class="col">
		    		<input type="number" class="form-control" id="inputScore2" placeholder="Счет команды 2" name="score2" value="<?php echo $match['away_score']; ?>" required>
		    	</div>
		    	<div class="col-auto ml-2">
		    		<button type="submit" class="btn btn-success" disabled="true">Отправить</button>
		    	</div>
	    	</div>
    	</form>
    	<form method="post" action="" class="text-left mt-5" id="deleteResult">
    		<input type="hidden" name="id" value="<?php echo $match_id; ?>">
	    	<button type="submit" class="btn btn-danger">Удалить матч</button>
	    </form>
  	</div>
</main>
<div class="loading-icon"></div>
<?php require_once __DIR__ . "/inc/layout/footer.php"; ?>
</body>
</html>