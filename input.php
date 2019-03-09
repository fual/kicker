<?php require_once "templates/header.php"; ?>
<?php
	$sth = $db->prepare("select tournament_id as id, tournament_description as name from tournaments order by tournament_description");
	$sth->execute();
	$tournaments = $sth->fetchAll();
	$sth = $db->prepare("select tournament_id as division, team_name_long as name from teams order by name");
	$sth->execute();
	$teams = $sth->fetchAll();
	$sth = $db->prepare("
		select
		p.first_name,
		p.second_name,
		t.team_name_long
		from rosters as r
		inner join teams as t on r.team_id = t.team_id
		inner join players as p on r.player_id = p.player_id");
	$sth->execute();
	$rosters = $sth->fetchAll();
?>
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<table class="table text-center" id="goalTable">
					<thead class="thead-dark">
						<tr>
							<th colspan="4">
								Game in
								<select class="form-control mt-2" id="tournament">
									<?php foreach ($tournaments as $tournament): ?>
									<option value="<?php echo $tournament['id']; ?>">
										<?php echo $tournament['name']; ?>
									</option>
									<?php endforeach; ?>
								</select>
							</th>
						</tr>
						<tr>
							<th id="teamNameA" colspan="2">
								<select class="form-control">
									<?php foreach ($teams as $team): ?>
										<option value="<?php echo $team['name']; ?>" data-tournament="<?php echo $team['division']; ?>">
											<?php echo $team['name']; ?>
										</option>
									<?php endforeach; ?>	
								</select>
							</th>
							<th id="teamNameB" colspan="2">
								<select class="form-control">
									<?php foreach ($teams as $team): ?>
										<option value="<?php echo $team['name']; ?>" data-tournament="<?php echo $team['division']; ?>">
											<?php echo $team['name']; ?>
										</option>
									<?php endforeach; ?>	
								</select>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="4" class="p-0">
								<table class="table table-bordered m-0 text-center">
									<?php for ($i = 0; $i <= 20; $i++): ?>
									<tr <?php if ($i % 4 == 0) echo "class='table-info'" ;?>>
										<td data-goal="<?php echo $i; ?>"></td>
										<td><?php echo $i; ?></td>
										<td><?php echo $i; ?></td>
										<td data-goal="<?php echo $i; ?>"></td>
										<td data-goal="<?php echo $i + 20; ?>"></td>
										<td><?php echo $i + 20; ?></td>
										<td><?php echo $i + 20; ?></td>
										<td data-goal="<?php echo $i + 20; ?>"></td>
									</tr>
									<?php endfor; ?>
								</table>
							</td>
						</tr>
					</tbody>
				</table>			
			</div>
			<div class="col-lg-6">
				<table class="table text-center" id="gameTable">
					<thead class="thead-dark">
						<tr>
							<th colspan="3">Element's scores</th>
						</tr>
						<tr>
							<th data-team="A">Team A</th>
							<th>Score</th>
							<th data-team="B">Team B</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="3" class="p-0">
								<table class="table table-bordered m-0 text-center">
									<?php
										$gameId = 0;
										for ($j = 0; $j < 2; $j++):
											$playerId = 0;
											for ($i = 0; $i < 5; $i++):
									?>
									<tr <?php if ($j == 0) {
												if ($i > 1 && $i < 5) echo "class='bg-blue-grey'";
											} else
												echo "class='bg-light-grey'";
										?>
									>
										<td>
											<?php if ($j == 0): ?>
												<?php for ($z = 0; $z <= (($i <= 1 || $i == 4) ? 1 : 0); $z++): ?>
													<select class="form-control my-1" data-select="A" data-player="<?php echo ++$playerId; ?>">
														<option value="Игрок">Выберите игрока</option>
														<?php foreach ($rosters as $player): ?>
															<option data-team-name="<?php echo $player['team_name_long']; ?>" value="<?php echo $player['first_name'] . " " . $player['second_name']; ?>">
																<?php echo $player['first_name'] . " " . $player['second_name']; ?>
															</option>
														<?php endforeach; ?>
													</select>
												<?php endfor;  ?>
											<?php else: ?>
												<?php for ($z = 0; $z <= (($i <= 1 || $i == 4) ? 1 : 0); $z++): ?>
													<p data-player="<?php echo ++$playerId; ?>">Player</p>
												<?php endfor;  ?>
											<?php endif; ?>
										</td>
										<td>
											<div class="form-inline justify-content-around text-center flex-nowrap" data-game-id="<?php echo ++$gameId; ?>">
												<select class="form-control">
													<option value="0">0</option>
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
												</select>
												<span class="mx-2">:</span>
												<select class="form-control">
													<option value="0">0</option>
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
												</select>
											</div>
										</td>
										<td>
											<?php if ($j == 0): ?>
												<?php for ($z = 0; $z <= (($i <= 1 || $i == 4) ? 1 : 0); $z++): ?>
													<select class="form-control my-1" data-select="B" data-player="<?php echo ++$playerId; ?>">
														<option value="Игрок">Выберите игрока</option>
														<?php foreach ($rosters as $player): ?>
															<option data-team-name="<?php echo $player['team_name_long']; ?>" value="<?php echo $player['first_name'] . " " . $player['second_name']; ?>">
																<?php echo $player['first_name'] . " " . $player['second_name']; ?>
															</option>
														<?php endforeach; ?>
													</select>
												<?php endfor;  ?>
											<?php else: ?>
												<?php for ($z = 0; $z <= (($i <= 1 || $i == 4) ? 1 : 0); $z++): ?>
													<p data-player="<?php echo ++$playerId; ?>">Player</p>
												<?php endfor;  ?>
											<?php endif; ?>
										</td>
									</tr>
									<?php endfor; ?>
									<?php endfor; ?>
									<tr>
										<th data-team="A" class="p-4">Team A</th>
										<th>
											<output id="teamAScore">0</output>
											<span class="mx-2">:</span>
											<output id="teamBScore">0</output>
										</th>
										<th data-team="B">Team B</th>
									</tr>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
				<table class="table text-center">
					<thead class="thead-dark">
						<tr>
							<th colspan="3">Team's Time-out</th>
						</tr>
						<tr>
							<th data-team="A">Team A</th>
							<th>Time-out</th>
							<th data-team="B">Team B</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="3" class="p-0">
								<table class="table table-bordered m-0 text-center">
									<tr>
										<td id="team1Timeout1"></td>
										<td>1st</td>
										<td id="team2Timeout1"></td>
									</tr>
									<tr>
										<td id="team1Timeout2"></td>
										<td>2nd</td>
										<td id="team2Timeout2"></td>
									</tr>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<style>
	table {
		table-layout: fixed;
	}
	td, th {
		vertical-align: middle !important;
	}
	[data-goal] {
		cursor: pointer;
		user-select: none;
	}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
	$(function() {
		var games;
		var timer;
		var action = "click";

		updateTeamOptions();
		updateTeamTags();
		gameTableSelectInit();
		initGames();
		updatePlayerSelects();

		$("#tournament").change(function() {
			updateTeamOptions();
			updateTeamTags();
			updatePlayerSelects();
		});
		$("#teamNameA select, #teamNameB select").change(function() {
			updateTeamTags();
			updatePlayerSelects();
		});
		$("[data-goal]").on("touchstart mousedown", function(e) {
			// Mouse right click
			if (e.button == 2)
				return ;
			timer = setTimeout(function() {
				action = "hold";
			}, 400);
		});
		$("[data-goal]").on("touchend mouseup", function(e) {
			// Mouse right click
			if (e.button == 2)
				return ;
			clearTimeout(timer);
			processGoalTable($(this));
		});
		$("[data-game-id] select").change(function() {
			var $oppositeGoal = $(this).parent().find("select").not($(this));
			if ($(this).val() != $(this).find("option:last").val())
				$oppositeGoal.val($oppositeGoal.find("option:last").val());
			else if ($oppositeGoal.val() == $oppositeGoal.find("option:last").val())
				$oppositeGoal.val($oppositeGoal.find("option:eq(-2)").val());
			updateGoalTable(+$(this).parent().attr("data-game-id"));
		});
		$("#gameTable select").change(duplicatePlayerNames);
		
		/* updatePlayerSelects: updates select options for players when team is changed */
		function updatePlayerSelects() {
			var teamA = $("#teamNameA select").val().replace(/([;&,\.\+\*\~':"\!\^#$%@\[\]\(\)=>\|])/g, '\\$1');
			var teamB = $("#teamNameB select").val().replace(/([;&,\.\+\*\~':"\!\^#$%@\[\]\(\)=>\|])/g, '\\$1');
			$("[data-select='A'] option, [data-select='B'] option").not(":first-of-type").hide();
			$("[data-select='A'] [data-team-name='" + teamA + "'], [data-select='B'] [data-team-name='" + teamB + "']").show().removeAttr("style");
			$("[data-select='A']").val($("[data-select='A'] option:not([style]):eq(0)").val());
			$("[data-select='B']").val($("[data-select='B'] option:not([style]):eq(0)").val());
			duplicatePlayerNames();
		}
		/**/
		function duplicatePlayerNames() {
			$.each($("p[data-player]"), function() {
				$(this).text($("select[data-player='" + $(this).attr("data-player") + "']").val());
			});
		}
		/* processGoalTable: toggles score after touch/mouse event in goalTable */
		function processGoalTable($obj) {
			var team = $("[data-goal='" + $obj.attr("data-goal") + "']").index($obj);
			team = team == 2 ? 0 : team == 3 ? 1 : team;
			var goal = +$obj.attr("data-goal");
			if (action == "click")
			{
				setScore(team, goal);
				unlockSelect($("[data-game-id=" + (games.currentGameId + 1) + "]"));
			}
			else if (action == "hold")
				eraseScore(team, goal);
			action = "click";
		}
		/* updateGoalTable: synchs gameTable and goalTable on change of gameTable */
		function updateGoalTable(gameId) {
			initGames();
			$("[data-goal]").empty();
			var game = [0, 0];
			$("[data-game-id]").each(function() {
				if ($(this).attr("data-game-id") > gameId)
					return ;
				game[0] += +$(this).find("select:eq(0)").val();
				game[1] += +$(this).find("select:eq(1)").val();
				game[0] == games.currentCap ? setScore(1, game[1], gameId) : setScore(0, game[0], gameId);
			});
			unlockSelect($("[data-game-id=" + (gameId + 1) + "]"));
		}
		/* setScore: sets the score in goalTable for the given team */
		function setScore(team, goal) {
			var $teamGoal = $("[data-goal=" + goal + "]:eq(" + team + ")");
			var $oppositeGoal = $("[data-goal=" + goal + "]:eq(" + +!team + ")");
			if (goal > games.currentCap || games.currentGameId > 9 || goal < games.lastScored[games.currentGameId][team] || $teamGoal.text() == games.currentGameTitle || (goal == games.currentCap && $oppositeGoal.text()))
					return ;
			$teamGoal.text($teamGoal.text() ? $teamGoal.text() + ", " + games.currentGameTitle : games.currentGameTitle);
			games[games.currentGameTitle]++;
			games.lastScored.push([0, 0]);
			games.lastScored[games.currentGameId + 1][team] = goal;
			if (goal != games.currentCap && games[games.currentGameTitle] % 2 != 0) {
				$("[data-goal=" + games.currentCap + "]:eq(" + +!team + ")").text(games.currentGameTitle);
				games[games.currentGameTitle]++;
				games.lastScored[games.currentGameId + 1][+!team] = games.currentCap;
			}
			updateTwenty();
			nextGame();
			updateGameTable();
		}
		/* nextGame: updates (increases) games object (currentCap, currentGameId, currentGameTitle) */
		function nextGame() {
			if (games[games.currentGameTitle] % 2 == 0) {
				var flag = 0;
				for (key in games) {
					if (flag) {
						games.currentGameTitle = key;
						flag = 0;
						break ;
					}
					if (key == games.currentGameTitle)
						flag = 1;
				}
				if (flag == 1)
					games.currentGameTitle = "D1";
				games.currentCap += 4;
				games.currentGameId++;
			}
		}
		/* eraseScore: erases last input in goalTable */
		function eraseScore(team, goal) {
			if (games.lastScored[games.lastScored.length - 1][team] != goal)
				return ;
			var $teamGoal = $("[data-goal=" + goal + "]:eq(" + team + ")");
			var $oppositeGoal = $("[data-goal=" + games.lastScored[games.lastScored.length - 1][+!team] + "]:eq(" + +!team + ")");
			games.currentGameTitle = $teamGoal.text().slice(-2);
			games[games.currentGameTitle] -= $oppositeGoal.text() ? 2 : 1;
			games.currentCap -= $oppositeGoal.text() ? 4 : 0;
			games.currentGameId -= $oppositeGoal.text() ? 1 : 0;
			if ($teamGoal.text().length > 2)
				$teamGoal.text( $teamGoal.text().slice(0, -4) );
			else
				$teamGoal.empty();
			if ($oppositeGoal.text().length > 2)
				$oppositeGoal.text( $oppositeGoal.text().slice(0, -4) );
			else
				$oppositeGoal.empty();
			games.lastScored.pop();
			lockPrevSelect();
			updateGameTable();
			updateTwenty();
		}
		/* updateTwenty: updates [data-goal='20'] in goalTable after each input to keep them in sync */
		function updateTwenty() {
			$("[data-goal='20']:eq(2)").text($("[data-goal='20']:eq(0)").text());
			$("[data-goal='20']:eq(3)").text($("[data-goal='20']:eq(1)").text());
		}
		/* updateGameTable: updates score in gameTable after goalTable input */
		function updateGameTable() {
			var gameScoreA;
			var gameScoreB;
			if (games.lastScored.length > 1) {
				gameScoreA = games.lastScored[games.currentGameId][0] - games.lastScored[games.currentGameId - 1][0];
				gameScoreB = games.lastScored[games.currentGameId][1] - games.lastScored[games.currentGameId - 1][1];
			}
			else
				gameScoreA = gameScoreB = 0;
			$("[data-game-id='" + games.currentGameId + "'] select:eq(0)").val(gameScoreA);
			$("[data-game-id='" + games.currentGameId + "'] select:eq(1)").val(gameScoreB);
			updateTotalScore();	
		}
		/* updateTotalScore: updates value of total scored goals in gameTable */
		function updateTotalScore() {
			var totalScoreA = games.lastScored[games.lastScored.length - 1][0];
			var totalScoreB = games.lastScored[games.lastScored.length - 1][1];
			$("#teamAScore").val(totalScoreA);
			$("#teamBScore").val(totalScoreB);
		}
		/* gameTableSelectInit: disables all but first 2 selects in gameTable */
		function gameTableSelectInit() {
			$("[data-game-id]:not(:eq(0)) select").prop("disabled", true);
		}
		/* unlockSelect: unlocks a select in gameTable and appends valid score options to it (based on previous game result) */
		function unlockSelect($parent) {
			var $teamASelect = $parent.find("select:eq(0)");
			var $teamBSelect = $parent.find("select:eq(1)");
			var teamAGoalsMax = games.currentCap - games.lastScored[games.currentGameId][0];
			var teamBGoalsMax = games.currentCap - games.lastScored[games.currentGameId][1];
			$teamASelect.empty();
			for (var i = 0; i <= teamAGoalsMax; i++)
				$teamASelect.append("<option value='" + i + "'>" + i + "</option>");
			$teamBSelect.empty();
			for (var i = 0; i <= teamBGoalsMax; i++)
				$teamBSelect.append("<option value='" + i + "'>" + i + "</option>");
			$parent.find("select").prop("disabled", false);
		}
		/* lockPrevSelect: disables last 2 not disabled selects and sets previous select values to 0 */
		function lockPrevSelect() {
			$("[data-game-id] select:not(:disabled):eq(-1), [data-game-id] select:not(:disabled):eq(-2)").prop("disabled", true);
			$("[data-game-id] select:not(:disabled):eq(-1)").val(0);
			$("[data-game-id] select:not(:disabled):eq(-2)").val(0);
		}
		/* initGames: initializes games object and sets all props to default */
		function initGames() {
			games = {
				lastScored: [[0, 0]],
				currentCap: 4,
				currentGameId: 0,
				currentGameTitle: "D1",
				D1: 0,
				D2: 0,
				S1: 0,
				S2: 0,
				D3: 0,
			};
		}
		/* updateTeamOptions: manage team names select options on tournament change */
		function updateTeamOptions() {
			var tournament = $("#tournament").val();
			$("#teamNameA option, #teamNameB option").removeAttr("style");
			$("#teamNameA select [data-tournament!=" + tournament + "], #teamNameB select [data-tournament!=" + tournament + "]").hide();
			$optionA = $("#teamNameA select option:not([style]):eq(0)");
			$("#teamNameA select").val($optionA.val());
			$optionB = $("#teamNameB select option:not([style]):eq(1)");
			$("#teamNameB select").val($optionB.val());
		}
		/* updateTeamTags: update team tags across page on teams selection */
		function updateTeamTags() {
			$("[data-team='A']").html($("#teamNameA select").val());
			$("[data-team='B']").html($("#teamNameB select").val());
		}
		$("[id*='Timeout']").click(function() {
			if (($(this).attr("id") == "team1Timeout1"
					&& $("#team1Timeout2").hasClass("table-info"))
				||
				($(this).attr("id") == "team2Timeout1"
					&& $("#team2Timeout2").hasClass("table-info"))
				||
	 			($(this).attr("id") == "team1Timeout2"
	 				&& !$("#team1Timeout1").hasClass("table-info"))
	 			||
	 			($(this).attr("id") == "team2Timeout2"
	 				&& !$("#team2Timeout1").hasClass("table-info")))
				return ;
			$(this).toggleClass("table-info");
		});
	});
</script>
<?php require_once "templates/footer.php"; ?>