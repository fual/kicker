<form method="post" action="" id="fillLineup" class="mt-4">
	<table class="table table-striped table-sm">
		<thead class="thead-dark">
			<th><?php echo $team1; ?></th>
			<th><?php echo $team2; ?></th>
		</thead>
		<tbody>
		    <?php
		    	$m = ["D1", "D2", "S1", "S2", "D3"];
	    		foreach ($m as $game):
		    ?>
	    	<tr>
	    		<td colspan="2"><?php echo $game; ?></td>
			</tr>
		    <tr>
		    	<?php for ($i = 1; $i < 3; $i++): ?>
		    	<td>
		    		<?php for ($p = 1; $p < (strpos($game, "D") !== false ? 3 : 2); $p++): ?>
		    		<select class="custom-select my-1" name="<?php echo "t".$i.strtolower($game)."p".$p; ?>">
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
		</tbody>
	</table>
	<div class="text-left">
		<ul class="list-unstyled small" style="columns: 2;">
			<li id="d12">D1, D2 - 4 разных игрока</li>
			<li id="sd3">S1, S2, D3 - 4 разных игрока</li>
			<li id="min">минимум - 4 игрока</li>
			<li id="max">максимум - 7 игроков</li>
			<li>заполняется вслепую</li>
			<li>2 монетки:
				<ol>
					<li>сторона на всю игру</li>
					<li>право первой подачи</li>
				</ol>
			</li>
		</ul>
		<button type="submit" class="btn btn-success mt-3" disabled="true">Подтвердить</button>
	</div>
</form>