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
				<table class="table text-center">
					<thead class="thead-dark">
						<tr>
							<th colspan="4">Match</th>
						</tr>
						<tr>
							<th>Team A</th>
							<th>Team B</th>
							<th>Team A</th>
							<th>Team B</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="2" class="p-0">
								<table class="table table-bordered m-0 text-center">
									<?php for ($i = 1; $i <= 20; $i++) {?>
									<tr <?php if (!($i % 4)) echo "class='table-info'" ?>>
										<td></td>
										<td><?php echo $i; ?></td>
										<td><?php echo $i; ?></td>
										<td></td>
									</tr>
									<?php } ?>
								</table>
							</td>
							<td colspan="2" class="p-0">
								<table class="table table-bordered m-0 text-center">
									<?php for ($i = 21; $i <= 40; $i++) {?>
									<tr <?php if (!($i % 4)) echo "class='table-info'" ?>>
										<td></td>
										<td><?php echo $i ?></td>
										<td><?php echo $i ?></td>
										<td></td>
									</tr>
									<?php } ?>
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
							<th>Team A</th>
							<th>Score</th>
							<th>Team B</th>
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
							<th>Team A</th>
							<th>Time-out</th>
							<th>Team B</th>
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
	td {
		vertical-align: middle !important;
	}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
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
</script>
</html>