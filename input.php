<html lang="ru">
<head>
	<title>Kicker</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<table class="table text-center">
			<thead class="thead-dark">
				<tr>
					<th colspan="5">Match</th>
				</tr>
				<tr>
					<th>Team A</th>
					<th>Team B</th>
					<th>&nbsp;</th>
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
					<td class="table-secondary p-0"></td>
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
								<td><?php echo $team1[$i]; ?></td>
								<td>
									<div class="form-inline justify-content-between">
										<select class="form-control">
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
										</select>
										:
										<select class="form-control">
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
										</select>
									</div>
								</td>
								<td><?php echo $team2[$i]; ?></td>
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
					<td></td>
					<td>1st</td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td>2nd</td>
					<td></td>
				</tr>
			</tbody>
		</table>
	</div>
</body>
<style>
	table {
		table-layout: fixed;
	}
</style>
</html>