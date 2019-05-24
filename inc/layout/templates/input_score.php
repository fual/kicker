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
			<?php $matches = ["d1", "d2", "s1", "s2", "d3"]; ?>
			<?php $tabIndex = 1; ?>
			<?php for ($i = 1; $i < 3; $i++): ?>
				<?php foreach ($matches as $match): ?>
					<tr>
						<td colspan="4"><?php echo strtoupper($match); ?></td>
					</tr>
				   	<tr>
				   		<td class="text-left">
				   			<input type="hidden" name="t1<?php echo $match; ?>p1" value="<?php echo $_POST['t1'.$match.'p1']; ?>">
				   			<?php if (strpos($match, "s") === false): ?>
				   				<input type="hidden" name="t1<?php echo $match; ?>p2" value="<?php echo $_POST['t1'.$match.'p2']; ?>">
				   			<?php endif; ?>
				   			<?php echo find_player_name_by_id($_POST['t1'.$match.'p1'], $players); ?>
				   			<?php if (strpos($match, "s") === false) echo "<br>" . find_player_name_by_id($_POST['t1'.$match.'p2'], $players); ?>
			   			</td>
				   		<td>
				   			<input type="number" class="form-control" name="r<?php echo $i; ?>t1<?php echo $match; ?>" placeholder="<?php if ($i == 1 && $match == "d1") echo "max 4"; else echo 0; ?>"<?php if (!($i == 1 && $match == "d1")) echo " disabled";?> tabindex="<?php echo $tabIndex++; ?>">
				   		</td>
				   		<td>
				   			<input type="number" class="form-control" name="r<?php echo $i; ?>t2<?php echo $match; ?>" placeholder="<?php if ($i == 1 && $match == "d1") echo "max 4"; else echo 0; ?>"<?php if (!($i == 1 && $match == "d1")) echo " disabled";?> tabindex="<?php echo $tabIndex++; ?>">
				   		</td>
				   		<td class="text-right">
				   			<input type="hidden" name="t2<?php echo $match; ?>p1" value="<?php echo $_POST['t2'.$match.'p1']; ?>">
				   			<?php if (strpos($match, "s") === false): ?>
				   				<input type="hidden" name="t2<?php echo $match; ?>p2" value="<?php echo $_POST['t2'.$match.'p2']; ?>">
				   			<?php endif; ?>
				   			<?php echo find_player_name_by_id($_POST['t2'.$match.'p1'], $players); ?>
				   			<?php if (strpos($match, "s") === false) echo "<br>" . find_player_name_by_id($_POST['t2'.$match.'p2'], $players); ?>
			   			</td>
				   	</tr>
				<?php endforeach; ?>
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