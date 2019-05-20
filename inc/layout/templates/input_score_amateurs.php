<form method="post" action="procedures/addResultAmateurs.php" id="addResultAmateurs" class="mt-4">
	<input type="hidden" name="tournament_id" value="<?php echo $tournament_id;?>">
	<input type="hidden" name="team1_id" value="<?php echo $team1_id;?>">
	<input type="hidden" name="team2_id" value="<?php echo $team2_id;?>">
	<table class="table table-striped table-sm">
		<thead class="thead-dark">
			<th colspan="2"><?php echo $team1; ?></th>
			<th colspan="2"><?php echo $team2; ?></th>
		</thead>
		<tbody>
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
		   			<input type="number" class="form-control" name="g1t1d1" placeholder="0" tabindex="1">
		   			<input type="number" class="form-control mt-1" name="g2t1d1" placeholder="0" tabindex="3">
		   		</td>
		   		<td>
		   			<input type="number" class="form-control" name="g1t2d1" placeholder="0" tabindex="2">
		   			<input type="number" class="form-control mt-1" name="g2t2d1" placeholder="0" tabindex="4">
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
		   			<input type="number" class="form-control" name="g1t1d2" placeholder="0" tabindex="5">
		   			<input type="number" class="form-control mt-1" name="g2t1d2" placeholder="0" tabindex="7">
		   		</td>
		   		<td>
		   			<input type="number" class="form-control" name="g1t2d2" placeholder="0" tabindex="6">
		   			<input type="number" class="form-control mt-1" name="g2t2d2" placeholder="0" tabindex="8">
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
		   			<input type="number" class="form-control" name="g1t1s1" placeholder="0" tabindex="9">
		   			<input type="number" class="form-control mt-1" name="g2t1s1" placeholder="0" tabindex="11">
		   		</td>
		   		<td>
		   			<input type="number" class="form-control" name="g1t2s1" placeholder="0" tabindex="10">
		   			<input type="number" class="form-control mt-1" name="g2t2s1" placeholder="0" tabindex="12">
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
		   			<input type="number" class="form-control" name="g1t1s2" placeholder="0" tabindex="13">
		   			<input type="number" class="form-control mt-1" name="g2t1s2" placeholder="0" tabindex="15">
		   		</td>
		   		<td>
		   			<input type="number" class="form-control" name="g1t2s2" placeholder="0" tabindex="14">
		   			<input type="number" class="form-control mt-1" name="g2t2s2" placeholder="0" tabindex="16">
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
		   			<input type="number" class="form-control" name="g1t1d3" placeholder="0" tabindex="17">
		   			<input type="number" class="form-control mt-1" name="g2t1d3" placeholder="0" tabindex="19">
		   		</td>
		   		<td>
		   			<input type="number" class="form-control" name="g1t2d3" placeholder="0" tabindex="18">
		   			<input type="number" class="form-control mt-1" name="g2t2d3" placeholder="0" tabindex="20">
		   		</td>
		   		<td class="text-right">
		   			<input type="hidden" name="t2d3p1" value="<?php echo $_POST['t2d3p1']; ?>">
		   			<input type="hidden" name="t2d3p2" value="<?php echo $_POST['t2d3p2']; ?>">
		   			<?php echo find_player_name_by_id($_POST['t2d3p1'], $players) . "<br>" . find_player_name_by_id($_POST['t2d3p2'], $players); ?>
		   		</td>
		   	</tr>
   		   	<tr>
   		   		<td colspan="4">D4</td>
   		   	</tr>
   		   	<tr>
   		   		<td class="text-left">
   		   			<input type="hidden" name="t1d4p1" value="<?php echo $_POST['t1d4p1']; ?>">
   		   			<input type="hidden" name="t1d4p2" value="<?php echo $_POST['t1d4p2']; ?>">
   		   			<?php echo find_player_name_by_id($_POST['t1d4p1'], $players) . "<br>" . find_player_name_by_id($_POST['t1d4p2'], $players); ?>
   	   			</td>
   		   		<td>
   		   			<input type="number" class="form-control" name="g1t1d4" placeholder="0" tabindex="21">
   		   			<input type="number" class="form-control mt-1" name="g2t1d4" placeholder="0" tabindex="23">
   		   		</td>
   		   		<td>
   		   			<input type="number" class="form-control" name="g1t2d4" placeholder="0" tabindex="22">
   		   			<input type="number" class="form-control mt-1" name="g2t2d4" placeholder="0" tabindex="24">
   		   		</td>
   		   		<td class="text-right">
   		   			<input type="hidden" name="t2d4p1" value="<?php echo $_POST['t2d4p1']; ?>">
   		   			<input type="hidden" name="t2d4p2" value="<?php echo $_POST['t2d4p2']; ?>">
   		   			<?php echo find_player_name_by_id($_POST['t2d4p1'], $players) . "<br>" . find_player_name_by_id($_POST['t2d4p2'], $players); ?>
   		   		</td>
   		   	</tr>
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