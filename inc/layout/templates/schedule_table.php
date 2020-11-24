<?
$selectTournamentsQuery = "select * from tournaments";
    $sth = $db->prepare($selectTournamentsQuery);
    $sth->execute();
    $tournaments = $sth->fetchAll();
?>
<div class="d-flex mt-3 align-items-center">
	<label for="teamFilter" class="col-form-label">Фильтр по команде:</label>
	<select class="custom-select w-50 ml-4" id="teamFilter" name="search">
		<option value="0">Команда ...</option>
		<?php foreach ($teams as $team): ?>
			<option value="<?php echo $team['name']; ?>"<?php if (isset($_GET['search']) && $_GET['search'] == $team['name']) echo " selected"; ?>>
				<?php echo $team['name']; ?>
			</option>
		<?php endforeach; ?>
	</select>
	<button class="btn btn-danger my-1 ml-3" id="clearTeamFilter">
	    <i class="fas fa-times"></i>
	</button>
</div>
<ul class="list-unstyled list-inline mt-3 small">
	<li class="list-inline-item">Легенда:</li>
	<li class="list-inline-item">
		<i class="fas fa-edit"></i> - редактировать,
	</li>
	<li class="list-inline-item">
		<i class="fas fa-eraser"></i> - очистить,
	</li>
	<li class="list-inline-item">
		<i class="fas fa-save"></i> - сохранить,
	</li>
	<li class="list-inline-item">
		<i class="fas fa-times"></i> - вернуться.
	</li>
</ul>
<div class="table-responsive">
  	<table class="table table-hover text-center table-sm" id="schedule">
  		<thead class="thead-dark">
  			<tr>
  				<th>Див.</th>
  				<th>Команды</th>
  				<th>Место</th>
  				<th>Дата</th>
  				<th>Время</th>
  			</tr>
  		</thead>
  		<tbody>
  			<?php if (!sizeof($schedule)): ?>
		  			</tbody>
		  		</table>
  			<?php else: ?>
		  	<?php $i = -1; $j = 1; ?>
			<?php foreach ($schedule as $game):
				$tournamentKey = array_search($game['tournament_id'], array_column($tournaments, 'tournament_id'));
				$tournamentName = $tournaments[$tournamentKey]['tournament_description'];
			?>
		  		<?php if ($i != $game['tour']): ?>
					<?php $i = $game['tour']; ?>
		  			<tr>
		  				<td colspan="5" class="font-italic text-left text-md-center">
		  					<?php echo $game['tour']; ?> тур <span class="px-3">-</span> <?php echo $game['date_start']
		  					. "-" . $game['date_end']; ?>
	  					</td>
		  			</tr>
		  		<?php endif; ?>
		  		<tr>
					<td title="<?=$tournamentName?>">
						<?=$tournamentName?>
	  				</td>
		  			<td><?php echo $game['team_name1']; ?> - <?php echo $game['team_name2']; ?></td>
		  			<td>
						<select class="custom-select" name="place">
							<option value="0">Место ...</option>
							<?php foreach ($places as $place): ?>
								<option value="<?php echo $place['place_id']; ?>"<?php if ($game['place_id'] == $place['place_id']) echo " selected"; ?>>
									<?php echo $place['name']; ?>
								</option>
							<?php endforeach; ?>
						</select>
	  					<span class="schedule-place">
	  						<?php if (isset($game['place_id'])): ?>
		  						<?php foreach ($places as $place): ?>
			  						<?php if ($place['place_id'] == $game['place_id']) echo $place['name']; ?>
			  					<?php endforeach; ?>
			  				<?php else: ?>
			  					-
			  				<?php endif; ?>
  						</span>
					</td>
		  			<td>
						<input type="date" class="form-control" name="date" id="date<?php echo $j++;?>"
						<?php if (isset($game['date'])) echo " value='" . $game['date'] . "'";?> autocomplete="off">
	  					<span class="schedule-date">
	  						<?php if (isset($game['date'])): ?>
	  							<?php echo date_format(date_create($game['date']), "j.m"); ?>
  							<?php else: ?>
  								-
  							<?php endif; ?>
  						</span>
					</td>
					<td>
						<input type="time" class="form-control" name="time" <?php if (isset($game['time'])) echo " value='" . $game['time'] . "'";?>>
	  					<span class="schedule-time">
	  						<?php if (isset($game['time'])): ?>
	  							<?php echo $game['time']; ?>
  							<?php else: ?>
  								-
  							<?php endif; ?>
  						</span>
					</td>
					<td class="border-0">
						<input type="hidden" class="form-control" name="id" value="<?php echo $game['id']; ?>">
						<button class="btn btn-light border-secondary ml-1" data-action="scheduleEdit" title="Редактировать">
							<i class="fas fa-edit"></i>
						</button>
						<button class="btn btn-light border-secondary ml-1 my-1" data-action="scheduleClear" title="Очистить">
							<i class="fas fa-eraser"></i>
						</button>
						<button class="btn btn-success ml-1 my-1" data-action="scheduleSubmit" title="Сохранить">
							<i class="fas fa-save"></i>
						</button>
						<button class="btn btn-danger ml-1 my-1" data-action="scheduleQuit" title="Вернуться">
							<i class="fas fa-times"></i>
						</button>
					</td>
		  		</tr>
		  	<?php endforeach; ?>
		  	<?php endif; ?>
		</tbody>
	</table>
</div>