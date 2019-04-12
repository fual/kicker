<form method="post" action="procedures/addResult.php" id="addResult" class="mt-4">
	<input type="hidden" name="tournament_id" value="<?php echo $tournament_id;?>">
	<input type="hidden" name="team1_id" value="<?php echo $team1_id;?>">
	<input type="hidden" name="team2_id" value="<?php echo $team2_id;?>">
	<table class="table table-striped table-sm">
		<thead class="thead-dark">
			<th colspan="2"><?php echo $team1; ?></th>
			<th colspan="2"><?php echo $team2; ?></th>
		</thead>
		<tbody>
			<?php for ($i = 1; $i < 3; $i++): ?>
			<tr>
				<td colspan="4">D1</td>
			</tr>
		   	<tr>
		   		<td class="text-left">
		   			<input type="hidden" name="t1d1p1" value="<?php echo $_POST['t1d1p1']; ?>">
		   			<input type="hidden" name="t1d1p2" value="<?php echo $_POST['t1d1p2']; ?>">
		   			<?php echo find_player_name_by_id($_POST['t1d1p1'], $players) . "<br>" . find_player_name_by_id($_POST['t1d1p2'], $players); ?>
	   			</td>
		   		<td>
		   			<input type="number" class="form-control" name="r<?php echo $i; ?>t1d1" placeholder="<?php if ($i == 2) echo 0; else echo "max 4"; ;?>"<?php if ($i == 2) echo " disabled";?>>
		   		</td>
		   		<td>
		   			<input type="number" class="form-control" name="r<?php echo $i; ?>t2d1" placeholder="<?php if ($i == 2) echo 0; else echo "max 4"; ;?>"<?php if ($i == 2) echo " disabled";?>>
		   		</td>
		   		<td class="text-right">
		   			<input type="hidden" name="t2d1p1" value="<?php echo $_POST['t2d1p1']; ?>">
		   			<input type="hidden" name="t2d1p2" value="<?php echo $_POST['t2d1p2']; ?>">
		   			<?php echo find_player_name_by_id($_POST['t2d1p1'], $players) . "<br>" . find_player_name_by_id($_POST['t2d1p2'], $players); ?>
	   			</td>
		   	</tr>
		   	<tr>
		   		<td colspan="4">D2</td>
		   	</tr>
		   	<tr>
		   		<td class="text-left">
		   			<input type="hidden" name="t1d2p1" value="<?php echo $_POST['t1d2p1']; ?>">
		   			<input type="hidden" name="t1d2p2" value="<?php echo $_POST['t1d2p2']; ?>">
		   			<?php echo find_player_name_by_id($_POST['t1d2p1'], $players) . "<br>" . find_player_name_by_id($_POST['t1d2p2'], $players); ?>
	   			</td>
		   		<td>
		   			<input type="number" class="form-control" name="r<?php echo $i; ?>t1d2" placeholder="0" disabled>
		   		</td>
		   		<td>
		   			<input type="number" class="form-control" name="r<?php echo $i; ?>t2d2" placeholder="0" disabled>
		   		</td>
		   		<td class="text-right">
		   			<input type="hidden" name="t2d2p1" value="<?php echo $_POST['t2d2p1']; ?>">
		   			<input type="hidden" name="t2d2p2" value="<?php echo $_POST['t2d2p2']; ?>">
		   			<?php echo find_player_name_by_id($_POST['t2d2p1'], $players) . "<br>" . find_player_name_by_id($_POST['t2d2p2'], $players); ?>
		   		</td>
		   	</tr>
		   	<tr>
		   		<td colspan="4">S1</td>
		   	</tr>
		   	<tr>
		   		<td class="text-left">
		   			<input type="hidden" name="t1s1p1" value="<?php echo $_POST['t1s1p1']; ?>">
		   			<?php echo find_player_name_by_id($_POST['t1s1p1'], $players); ?>
	   			</td>
		   		<td>
		   			<input type="number" class="form-control" name="r<?php echo $i; ?>t1s1" placeholder="0" disabled>
		   		</td>
		   		<td>
		   			<input type="number" class="form-control" name="r<?php echo $i; ?>t2s1" placeholder="0" disabled>
		   		</td>
		   		<td class="text-right">
		   			<input type="hidden" name="t2s1p1" value="<?php echo $_POST['t2s1p1']; ?>">
		   			<?php echo find_player_name_by_id($_POST['t2s1p1'], $players); ?>
	   			</td>
		   	</tr>
		   	<tr>
		   		<td colspan="4">S2</td>
		   	</tr>
		   	<tr>
		   		<td class="text-left">
		   			<input type="hidden" name="t1s2p1" value="<?php echo $_POST['t1s2p1']; ?>">
		   			<?php echo find_player_name_by_id($_POST['t1s2p1'], $players); ?>
	   			</td>
		   		<td>
		   			<input type="number" class="form-control" name="r<?php echo $i; ?>t1s2" placeholder="0" disabled>
		   		</td>
		   		<td>
		   			<input type="number" class="form-control" name="r<?php echo $i; ?>t2s2" placeholder="0" disabled>
		   		</td>
		   		<td class="text-right">
		   			<input type="hidden" name="t2s2p1" value="<?php echo $_POST['t2s2p1']; ?>">
		   			<?php echo find_player_name_by_id($_POST['t2s2p1'], $players); ?>
	   			</td>
		   	</tr>
		   	<tr>
		   		<td colspan="4">D3</td>
		   	</tr>
		   	<tr>
		   		<td class="text-left">
		   			<input type="hidden" name="t1d3p1" value="<?php echo $_POST['t1d3p1']; ?>">
		   			<input type="hidden" name="t1d3p2" value="<?php echo $_POST['t1d3p2']; ?>">
		   			<?php echo find_player_name_by_id($_POST['t1d3p1'], $players) . "<br>" . find_player_name_by_id($_POST['t1d3p2'], $players); ?>
	   			</td>
		   		<td>
		   			<input type="number" class="form-control" name="r<?php echo $i; ?>t1d3" placeholder="0" disabled>
		   		</td>
		   		<td>
		   			<input type="number" class="form-control" name="r<?php echo $i; ?>t2d3" placeholder="0" disabled>
		   		</td>
		   		<td class="text-right">
		   			<input type="hidden" name="t2d3p1" value="<?php echo $_POST['t2d3p1']; ?>">
		   			<input type="hidden" name="t2d3p2" value="<?php echo $_POST['t2d3p2']; ?>">
		   			<?php echo find_player_name_by_id($_POST['t2d3p1'], $players) . "<br>" . find_player_name_by_id($_POST['t2d3p2'], $players); ?>
		   		</td>
		   	</tr>
		   	<?php endfor; ?>
		   	<tr>
		   		<td>
		   			<span class="mr-2 my-1">T/O:</span>
		   			<button type="button" class="btn btn-light border-secondary my-1" id="t11">1</button>
		   			<button type="button" class="btn btn-light border-secondary my-1" id="t12">2</button>
		   		</td>
		   		<td class="py-4">
		   			<input type="hidden" placeholder="0" name="t1score">
					<output id="t1score" class="lead">0</output>
				</td>
		   		<td class="py-4">
		   			<input type="hidden" placeholder="0" name="t2score">
		   			<output id="t2score" class="lead">0</output>
		   		</td>
		   		<td>
		   			<span class="mr-2 my-1">T/O:</span>
		   			<button type="button" class="btn btn-light border-secondary my-1" id="t21">1</button>
		   			<button type="button" class="btn btn-light border-secondary my-1" id="t22">2</button>
		   		</td>
		   	</tr>
		</tbody>
	</table>
	<div class="form-row mt-5">
		<div class="col-auto ml-2">
			<button type="submit" class="btn btn-success" disabled="true">
				<span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
				Отправить
			</button>
		</div>
	</div>
</form>