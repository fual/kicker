<?php
	require_once 'bootstrap.php';
	$sth = $db->prepare("select tournament_id as id, tournament_description as name from tournaments order by tournament_description");
	$sth->execute();
	$tournaments = $sth->fetchAll();
	$sth = $db->prepare("select tournament_id as division, team_name_long as name from teams order by name");
	$sth->execute();
	$teams = $sth->fetchAll();
?>
<html lang="ru">
<head>
	<title>Kicker</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<table class="table text-center" id="goalTable">
					<thead class="thead-dark">
						<tr>
							<th colspan="4">
								Match in
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
				<table class="table text-center" id="matchTable">
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
										$team1 = array("Double 1 (D1)", "Double 2 (D2)", "Single 1 (S1)", "Single 2 (S2)", "Double 3 (D3)");
										$team2 = array("Double 1 (D1)", "Double 2 (D2)", "Single 1 (S1)", "Single 2 (S2)", "Double 3 (D3)");
										for ($j = 0; $j < 2; $j++)
											for ($i = 0; $i < 5; $i++) {
									?>
									<tr <?php if ($i >= 2 && $j != 1) echo "class='table-info'" ?>>
										<td>
											<?php for ($z = 0; $z <= (($i <= 1 || $i == 4) ? 1 : 0); $z++): ?>
												<select class="form-control my-1" readonly>
													<?php foreach ($team1 as $member): ?>
													<option value="<?php echo $member?>"><?php echo $member?></option>
													<?php endforeach; ?>
												</select>
											<?php endfor; ?>
										</td>
										<td>
											<div class="form-inline justify-content-around text-center flex-nowrap" data-match-id="<?php echo $j * 5 + $i + 1; ?>">
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
											<?php for ($z = 0; $z <= (($i <= 1 || $i == 4) ? 1 : 0); $z++): ?>
												<select class="form-control my-1">
													<?php foreach ($team1 as $member): ?>
													<option value="<?php echo $member?>"><?php echo $member?></option>
													<?php endforeach; ?>
												</select>
											<?php endfor; ?>
										</td>
									</tr>
									<?php } ?>
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
</body>
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
		updateTeamOptions();
		updateTeamTags();
		matchTableSelectInit();
		$("#tournament").change(function() {
			updateTeamOptions();
			updateTeamTags();
		});
		$("#teamNameA select, #teamNameB select").change(updateTeamTags);
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
		var matches = {
			lastScored: [[0, 0]],
			currentCap: 4,
			currentMatchId: 0,
			currentMatchTitle: "D1",
			D1: 0,
			D2: 0,
			S1: 0,
			S2: 0,
			D3: 0,
		};
		var action = "click";
		var timer;
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
			setScore($(this));
		});
		/* setScore: toggles score after touch/mouse event in goalTable */
		function setScore($obj) {
			var team = $("[data-goal='" + $obj.attr("data-goal") + "']").index($obj);
			team = team == 2 ? 0 : team == 3 ? 1 : team;
			var goal = +$obj.attr("data-goal");
			if (action == "click")
				setScoreTeam(team, goal);
			else if (action == "hold")
				eraseScore(team, goal);
			action = "click";
		}
		/* setScoreTeam: sets the score in goalTable for the given team */
		function setScoreTeam(team, goal) {
			var $teamGoal = $("[data-goal=" + goal + "]:eq(" + team + ")");
			var $oppositeGoal = $("[data-goal=" + goal + "]:eq(" + +!team + ")");
			if (goal > matches.currentCap || matches.currentMatchId > 9 || goal < matches.lastScored[matches.currentMatchId][team] || $teamGoal.text() == matches.currentMatchTitle || (goal == matches.currentCap && $oppositeGoal.text()))
					return ;
			$teamGoal.text($teamGoal.text() ? $teamGoal.text() + ", " + matches.currentMatchTitle : matches.currentMatchTitle);
			matches[matches.currentMatchTitle]++;
			matches.lastScored.push([0, 0]);
			matches.lastScored[matches.currentMatchId + 1][team] = goal;
			if (goal != matches.currentCap && matches[matches.currentMatchTitle] % 2 != 0) {
				$("[data-goal=" + matches.currentCap + "]:eq(" + +!team + ")").text(matches.currentMatchTitle);
				matches[matches.currentMatchTitle]++;
				matches.lastScored[matches.currentMatchId + 1][+!team] = matches.currentCap;
			}
			updateTwenty();
			nextMatch();
		}
		/* nextMatch: updates (increases) matches object (currentCap, currentMatchid, currentMatchTitle) */
		function nextMatch() {
			console.log(matches);
			if (matches[matches.currentMatchTitle] % 2 == 0) {
				var flag = 0;
				for (key in matches) {
					if (flag) {
						matches.currentMatchTitle = key;
						flag = 0;
						break ;
					}
					if (key == matches.currentMatchTitle)
						flag = 1;
				}
				if (flag == 1)
					matches.currentMatchTitle = "D1";
				matches.currentCap += 4;
				matches.currentMatchId++;
				updateMatchTable();
			}
		}
		/* eraseScore: erases last input in goalTable */
		function eraseScore(team, goal) {
			console.log(matches);
			if (matches.lastScored[matches.lastScored.length - 1][team] != goal)
				return ;
			var $teamGoal = $("[data-goal=" + goal + "]:eq(" + team + ")");
			var $oppositeGoal = $("[data-goal=" + matches.lastScored[matches.lastScored.length - 1][+!team] + "]:eq(" + +!team + ")");
			matches.currentMatchTitle = $teamGoal.text().slice(-2);
			matches[matches.currentMatchTitle] -= $oppositeGoal.text() ? 2 : 1;
			matches.currentCap -= $oppositeGoal.text() ? 4 : 0;
			matches.currentMatchId -= $oppositeGoal.text() ? 1 : 0;
			if ($teamGoal.text().length > 2)
				$teamGoal.text( $teamGoal.text().slice(0, -4) );
			else
				$teamGoal.empty();
			if ($oppositeGoal.text().length > 2)
				$oppositeGoal.text( $oppositeGoal.text().slice(0, -4) );
			else
				$oppositeGoal.empty();
			matches.lastScored.pop();
			lockPrevSelect();
			updateTwenty();
		}
		/* updateTwenty: updates [data-goal='20'] in goalTable after each input to keep them in sync */
		function updateTwenty() {
			$("[data-goal='20']:eq(2)").text($("[data-goal='20']:eq(0)").text());
			$("[data-goal='20']:eq(3)").text($("[data-goal='20']:eq(1)").text());
		}
		/* updateMatchTable: updates score in matchTable after goalTable input */
		function updateMatchTable() {
			var scoreA = matches.lastScored[matches.currentMatchId][0] - matches.lastScored[matches.currentMatchId - 1][0];
			var scoreB = matches.lastScored[matches.currentMatchId][1] -  matches.lastScored[matches.currentMatchId - 1][1];
			$("[data-match-id='" + matches.currentMatchId + "'] select:eq(0)").val(scoreA);
			$("[data-match-id='" + matches.currentMatchId + "'] select:eq(1)").val(scoreB);
			unlockNextSelect();
		}
		/* matchTableSelectInit: disables all but first 2 selects in matchTable */
		function matchTableSelectInit() {
			$("[data-match-id]:not(:eq(0)) select").prop("disabled", true);
		}
		/* unlockNextSelect: unlocks next match in matchTable and appends valid score options to it (based on previous match result) */
		function unlockNextSelect() {
			var $teamASelect = $("[data-match-id] select:disabled:eq(0)");
			var $teamBSelect = $("[data-match-id] select:disabled:eq(1)");
			var teamAGoalsMax = matches.currentCap - matches.lastScored[matches.currentMatchId][0];
			var teamBGoalsMax = matches.currentCap - matches.lastScored[matches.currentMatchId][1];
			$teamASelect.empty();
			for (var i = 0; i <= teamAGoalsMax; i++)
				$teamASelect.append("<option value='" + i + "'>" + i + "</option>");
			$teamBSelect.empty();
			for (var i = 0; i <= teamBGoalsMax; i++)
				$teamBSelect.append("<option value='" + i + "'>" + i + "</option>");
			$("[data-match-id] select:disabled:eq(0), [data-match-id] select:disabled:eq(1)").prop("disabled", false);
		}
		/* lockPrevSelect: disables last 2 not disabled selects and sets previous select values to 0 */
		function lockPrevSelect() {
			$("[data-match-id] select:not(:disabled):eq(-1), [data-match-id] select:not(:disabled):eq(-2)").prop("disabled", true);
			$("[data-match-id] select:not(:disabled):eq(-1)").val(0);
			$("[data-match-id] select:not(:disabled):eq(-2)").val(0);
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
		$("[data-team]").change(function() {
			$opponent = $(this).attr("data-team") == "a" ? $(this).parent().find("[data-team='b']") : $(this).parent().find("[data-team='a']");
			if ($(this).val() != 4)
				$opponent.val("4");
		});
	});
</script>
</html>