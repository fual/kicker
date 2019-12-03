<form method="post" action="/procedures/addResultAmateurs.php" id="addResultAmateurs" class="mt-4">
	<input type="hidden" name="subfolder" value="<?php echo $subfolder;?>">
	<input type="hidden" name="tournament_id" value="<?php echo $tournament_id;?>">
	<input type="hidden" name="team1_id" value="<?php echo $team1_id;?>">
	<input type="hidden" name="team2_id" value="<?php echo $team2_id;?>">
	<table class="table table-striped table-sm">
		<thead class="thead-dark">
			<th colspan="2"><?php echo $team1; ?></th>
			<th colspan="2"><?php echo $team2; ?></th>
		</thead>
		<tbody>
			<?php $matches = ["d1", "d2", "s1", "s2", "d3", "d4"]; ?>
			<?php $tabIndex = 1; ?>
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
						<?php $isTech = !is_numeric($_POST["t1".$match."p1"]); ?>
			   			<input type="number" class="form-control<?php if ($isTech) echo " tech"; ?>"
						   	name="g1t1<?php echo $match; ?>" placeholder="0" tabindex="<?php echo $tabIndex; ?>"<?php if ($isTech) echo " value='" . ($_POST["t1".$match."p1"] == "win" ? "5" : "0") . "' readonly"; ?>>
			   			<input type="number" class="form-control mt-1<?php if ($isTech) echo " tech"; ?>"
						   	name="g2t1<?php echo $match; ?>" placeholder="0" tabindex="<?php echo $tabIndex + 2; ?>"<?php if ($isTech) echo " value='" . ($_POST["t1".$match."p1"] == "win" ? "5" : "0") . "' readonly"; ?>>
			   		</td>
			   		<td>
			   			<input type="number" class="form-control<?php if ($isTech) echo " tech"; ?>"
						   	name="g1t2<?php echo $match; ?>" placeholder="0" tabindex="<?php echo $tabIndex + 1; ?>"<?php if ($isTech) echo " value='" . ($_POST["t2".$match."p1"] == "win" ? "5" : "0") . "' readonly"; ?>>
			   			<input type="number" class="form-control mt-1<?php if ($isTech) echo " tech"; ?>"
						   	name="g2t2<?php echo $match; ?>" placeholder="0" tabindex="<?php echo $tabIndex + 3; ?>"<?php if ($isTech) echo " value='" . ($_POST["t2".$match."p1"] == "win" ? "5" : "0") . "' readonly"; ?>>
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
			   	<?php $tabIndex += 4; ?>
			<?php endforeach; ?>
   		   	<tr>
   		   		<td></td>
   		   		<td class="py-4">
   		   			<input type="hidden" placeholder="0" name="t1score" value="0">
   					<output id="t1score" class="lead">0</output>
   				</td>
   		   		<td class="py-4">
   		   			<input type="hidden" placeholder="0" name="t2score" value="0">
   		   			<output id="t2score" class="lead">0</output>
   		   		</td>
   		   		<td></td>
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