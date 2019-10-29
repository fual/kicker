<?php if (!isset($tournament_id)): ?>
<form method="GET" action="" id="chooseTournament" class="mt-4">
	<div class="mb-2">
		<label class="sr-only" for="inputTournament">Выберите дивизион</label>
		<select class="custom-select" id="inputTournament" name="tournament" required>
		    <option selected value="0">Дивизион...</option>
		    <?php foreach ($tournaments as $tournament): ?>
		    <option value="<?php echo $tournament['id']; ?>">
		    	<?php echo $tournament['name']; ?>
		    </option>
		    <?php endforeach; ?>
		</select>
	</div>
	<div class="text-left mt-3">
		<button type="submit" class="btn btn-success" disabled="true">Подтвердить</button>
	</div>
</form>
<?php endif;?>
<?php if (isset($tournament_id) && !isset($team1) && !isset($team2)): ?>
<form method="GET" action="" id="chooseTeams" class="mt-4">
	<input type="hidden" name="tournament" value="<?php echo $tournament_id; ?>">
	<div class="form-row">
		<?php for ($j = 1; $j < 3; $j++): ?>
		<div class="col-md my-1">
			<select class="custom-select" id="inputTeam<?php echo $j; ?>" name="team<?php echo $j; ?>" required>
			    <option value="0" selected>Команда <?php echo $j; ?>...</option>
				<?php foreach ($teams as $team): ?>
					<?php echo "<option value='" . $team['id'] . "'>" . $team['name'] . "</option>"; ?>
				<?php endforeach; ?>
			</select>
		</div>
		<?php endfor; ?>
	</div>
	<div class="text-left mt-3">
		<button type="submit" class="btn btn-success" disabled="true">Подтвердить</button>
	</div>
</form>
<?php endif; ?>