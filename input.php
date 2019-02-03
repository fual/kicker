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
				<table class="table text-center">
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
											<div class="form-inline justify-content-around text-center flex-nowrap">
												<select class="form-control" data-team="a">
													<option value="0">0</option>
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
												</select>
												<span class="mx-2">:</span>
												<select class="form-control" data-team="b">
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
		updateTeamNames();
		updateTeamTags();
		$("#tournament").change(updateTeamNames);
		$("#teamNameA select, #teamNameB select").change(updateTeamTags);
		function updateTeamNames() {
			var tournament = $("#tournament").val();
			$("#teamNameA option, #teamNameB option").removeAttr("style");
			$("#teamNameA select [data-tournament!=" + tournament + "], #teamNameB select [data-tournament!=" + tournament + "]").hide();
			$optionA = $("#teamNameA select option:not([style]):eq(0)");
			$("#teamNameA select").val($optionA.val());
			$optionB = $("#teamNameB select option:not([style]):eq(1)");
			$("#teamNameB select").val($optionB.val());
		}
		function updateTeamTags() {
			$("[data-team='A']").html($("#teamNameA select").val());
			$("[data-team='B']").html($("#teamNameB select").val());
		}
		var matches = {
			currentCap: 4,
			lastScored: [0, 0],
			currentMatch: "D1",
			D1: 0,
			D2: 0,
			S1: 0,
			S2: 0,
			D3: 0,
		};
		var event = "click";
		var timer;
		$("[data-goal]").on("touchstart mousedown", function(event) {
			// Mouse right click
			if (event.button == 2)
				return ;
			timer = setTimeout(function() {
				event = "hold";
			}, 400);
		});
		$("[data-goal]").on("touchend mouseup", function(event) {
			// Mouse right click
			if (event.button == 2)
				return ;
			clearTimeout(timer);
			setScore($(this));
		});
		function setScore($obj) {
			var team = !$obj.prev().length ? 0 : 1;
			var goal = +$obj.attr("data-goal");
			if (event == "click")
				setScoreTeam(team, goal);
			else if (event == "hold")
				eraseScore(team, goal);
			event = "click";
		}
		function setScoreTeam(team, goal) {
			var $teamGoal = $("#goalTable [data-goal=" + goal + "]:eq(" + team + ")");
			var $oppositeGoal = $("#goalTable [data-goal=" + goal + "]:eq(" + +!team + ")");
			if (goal > matches.currentCap || matches[matches.currentMatch] >= 4  || goal < matches.lastScored[team] || $teamGoal.text() == matches.currentMatch || (goal == matches.currentCap && $oppositeGoal.text()))
					return ;
			$teamGoal.text($teamGoal.text() ? $teamGoal.text() + ", " + matches.currentMatch : matches.currentMatch);
			matches[matches.currentMatch]++;
			matches.lastScored[team] = goal;
			if (goal != matches.currentCap && matches[matches.currentMatch] % 2 != 0) {
				$("#goalTable [data-goal=" + matches.currentCap + "]:eq(" + +!team + ")").text(matches.currentMatch);
				matches[matches.currentMatch]++;
				matches.lastScored[+!team] = matches.currentCap;
			}
			updateTwenty();
			nextMatch();
		}
		function nextMatch() {
			if (matches[matches.currentMatch] % 2 == 0) {
				matches.currentCap += 4;
				var flag = 0;
				for (key in matches) {
					if (flag) {
						matches.currentMatch = key;
						flag = 0;
						break ;
					}
					if (key == matches.currentMatch)
						flag = 1;
				}
				if (flag == 1)
					matches.currentMatch = "D1";
			}
		}
		function eraseScore(team, goal) {
			if (matches.lastScored[team] != goal)
				return ;
			var $teamGoal = $("#goalTable [data-goal=" + goal + "]:eq(" + team + ")");
			var $oppositeGoal = $("#goalTable [data-goal=" + matches.lastScored[+!team] + "]:eq(" + +!team + ")");
			matches.currentMatch = $teamGoal.text().slice(-2);
			matches[matches.currentMatch] -= $oppositeGoal.text() ? 2 : 1;
			matches.currentCap -= $oppositeGoal.text() ? 4 : 0;
			if ($teamGoal.text().length > 2)
				$teamGoal.text( $teamGoal.text().slice(0, -4) );
			else
				$teamGoal.empty();
			if ($oppositeGoal.text().length > 2)
				$oppositeGoal.text( $oppositeGoal.text().slice(0, -4) );
			else
				$oppositeGoal.empty();
			matches.lastScored[team] = +$("#goalTable [data-goal]" + (team ? ":last-child" : ":first-child") + ":not(:empty)").last().parent().attr("data-goal");
			matches.lastScored[+!team] = +$("#goalTable [data-goal]" + (+!team ? ":last-child" : ":first-child") + ":not(:empty)").last().parent().attr("data-goal");
			// if NaN set to 0
			matches.lastScored[team] = matches.lastScored[team] ? matches.lastScored[team] : 0;
			matches.lastScored[+!team] = matches.lastScored[+!team] ? matches.lastScored[+!team] : 0;
			updateTwenty();
		}
		function updateTwenty() {
			$("[data-goal='20']:eq(3)").text($("[data-goal='20']:eq(0)").text());
			$("[data-goal='20']:eq(4)").text($("[data-goal='20']:eq(1)").text());
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