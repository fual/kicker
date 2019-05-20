<?php
	require_once __DIR__ . "/inc/bootstrap.php";
	require_once __DIR__ . "/inc/layout/head.php";
	$match_id = isset($_GET['id']) ? $_GET['id'] : NULL;
	if ($match_id) {
		$sth = $db->prepare("select
				m.match_id as match_id,
				m.season_id as season_id,
				m.tournament_id as tournament_id,
				ht.team_name_long as home_team,
				at.team_name_long as away_team,
				m.sets_won1 as home_score,
				m.sets_won2 as away_score
				from matches as m
				inner join teams as ht on ht.team_id = m.team_id1
				inner join teams as at on at.team_id = m.team_id2
				where match_id = ?");
		$sth->execute(array($match_id));
		$match = $sth->fetch();
		$sth = $db->prepare("select * from games where match_id = :id");
		$sth->bindValue(":id", $match_id, PDO::PARAM_INT);
		$sth->execute();
		$games = $sth->fetchAll();
		$sth = $db->prepare("select id, first_name, second_name from rosters inner join players on rosters.player_id = players.player_id");
		$sth->execute();
		$players = $sth->fetchAll();
		$sth = $db->prepare("select tournament_description as name from tournaments where tournament_id = :id");
		$sth->bindValue(":id", $match['tournament_id'], PDO::PARAM_INT);
		$sth->execute();
		$tournament_name = $sth->fetch()["name"];
	}
?>
<body class="pt-5">
<main role="main" class="container">
  	<div class="starter-template pt-0">
  		<?php if (!$match_id || !sizeof($games)): ?>
	    	<h2>Матч не найден</h2>
  			<p>К сожалению, матч не найден. Пожалуйста, вернитесь на главную страницу.</p>
  		<?php else: ?>
    	<h2><?php echo $match['home_team'] . " vs " . $match['away_team']; ?></h2>
    	<h4><?php echo $tournament_name ?></h4>
    	<table class="table table-striped table-sm mt-3" id="match">
    		<thead class="thead-dark">
    			<th colspan="2"><?php echo $match['home_team'] ?></th>
    			<th colspan="2"><?php echo $match['away_team']; ?></th>
    		</thead>
    		<tbody>
    			<?php /* Amateurs */ ?>
    			<?php if (sizeof($games) == 12): ?>
    				<?php for ($i = 0; $i < 12; $i += 2): ?>
    					<tr>
					   		<td class="text-left">
					   			<?php
					   				echo find_player_name_by_id($games[$i]['player_id11'], $players);
					   				if ($games[$i]['player_id12'])
					   					echo "<br>" . find_player_name_by_id($games[$i]['player_id12'], $players);
				   				?>
				   			</td>
					   		<td>
					   			<?php echo "<p class='mb-1'>" . $games[$i]['score1'] . "</p>"; ?>
					   			<?php echo "<p class='m-0'>" . $games[$i + 1]['score1'] . "</p>"; ?>
					   		</td>
					   		<td>
					   			<?php echo "<p class='mb-1'>" . $games[$i]['score2'] . "</p>"; ?>
					   			<?php echo "<p class='m-0'>" . $games[$i + 1]['score2'] . "</p>"; ?>
					   		</td>
					   		<td class="text-right">
					   			<?php
					   				echo find_player_name_by_id($games[$i]['player_id21'], $players);
					   				if ($games[$i]['player_id22'])
					   					echo "<br>" . find_player_name_by_id($games[$i]['player_id22'], $players);
				   				?>
					   		</td>
    					</tr>
    				<?php endfor; ?>
    			<?php elseif (sizeof($games)): ?>
    			<?php /* Pro */ ?>
    				<?php foreach ($games as $game): ?>
    					<tr>
					   		<td class="text-left">
					   			<?php
					   				echo find_player_name_by_id($game['player_id11'], $players);
					   				if ($game['player_id12'])
					   					echo "<br>" . find_player_name_by_id($game['player_id12'], $players);
				   				?>
				   			</td>
					   		<td>
					   			<?php echo $game['score1']; ?>
					   		</td>
					   		<td>
					   			<?php echo $game['score2']; ?>
					   		</td>
					   		<td class="text-right">
					   			<?php
					   				echo find_player_name_by_id($game['player_id21'], $players);
					   				if ($game['player_id22'])
					   					echo "<br>" . find_player_name_by_id($game['player_id22'], $players);
				   				?>
					   		</td>
    					</tr>
    				<?php endforeach; ?>
    			<?php endif; ?>	
			   	<tr>
			   		<td></td>
			   		<td class="py-4">
						<output id="t1score" class="lead"><?php echo $match['home_score']; ?></output>
					</td>
			   		<td class="py-4">
			   			<output id="t2score" class="lead"><?php echo $match['away_score']; ?></output>
			   		</td>
			   		<td></td>
			   	</tr>
    		</tbody>
    	</table>
	    <?php endif; ?>
    	<div class="text-left">
			<a href="/" class="btn btn-primary">Назад</a>
		</div>
  	</div>
</main>
<?php require_once __DIR__ . "/inc/layout/footer.php"; ?>
</body>
</html>