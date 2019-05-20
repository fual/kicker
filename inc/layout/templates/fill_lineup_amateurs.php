<form method="post" action="" id="fillLineupAmateurs" class="mt-4">
	<table class="table table-striped table-sm">
		<thead class="thead-dark">
			<th><?php echo $team1; ?></th>
			<th><?php echo $team2; ?></th>
		</thead>
		<tbody>
		    <?php
		    	$m = ["D1", "D2", "S1", "S2", "D3", "D4"];
		    	$j = 1;
		    	$z = 11;
	    		foreach ($m as $game):
		    ?>
	    	<tr>
	    		<td colspan="2"><?php echo $game; ?></td>
			</tr>
		    <tr>
		    	<?php for ($i = 1; $i < 3; $i++): ?>
		    	<td>
		    		<?php for ($p = 1; $p < (strpos($game, "D") !== false ? 3 : 2); $p++): ?>
		    		<select class="custom-select my-1" name="<?php echo "t".$i.strtolower($game)."p".$p; ?>"
		    		<?php echo "tabindex='" . ($i == 1 ? $j++ : $z++) . "'"; ?>>
		    			<option value="0">Игрок ...</option>
		    			<?php foreach ($players as $player): ?>
		    				<?php if ($player['team_id'] == ($i == 1 ? $team1_id : $team2_id)): ?>
		    				<option value="<?php echo $player['id']; ?>">
		    					<?php echo $player['second_name'] . " " . $player['first_name']; ?>
	    					</option>
		    				<?php endif; ?>
		    			<?php endforeach; ?>
		    		</select>
			    	<?php endfor; ?>
		    	</td>
				<?php endfor; ?>
			</tr>
			<?php endforeach; ?>
			<tr id="hideRow">
				<td>
					<button class="btn btn-light border-secondary" id="hide1"><i class="fas fa-eye-slash"></i></button>
				</td>
				<td>
					<button class="btn btn-light border-secondary" id="hide2"><i class="fas fa-eye-slash"></i></button>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="text-left">
		<ul class="list-unstyled small lineup-rules">
			<li id="d12">D1, D2 - разные пары</li>
			<li id="d34">D3, D4 - разные пары</li>
			<li id="s12">S1, S2 - 2 разных игрока</li>
			<li id="one">один игрок участвует максимум в двух играх</li>
			<li>гости заполняют первыми</li>
		</ul>
		<button type="submit" class="btn btn-success mt-3" disabled="true">Подтвердить</button>
	</div>
</form>