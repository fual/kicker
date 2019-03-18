<ul class="list-unstyled list-inline mt-4 small">
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
		  	<?php $i = 1; ?>
		  	<?php foreach ($schedule as $game): ?>
		  		<?php if ($i == $game['tour']): ?>
		  			<tr>
		  				<td colspan="5" class="font-italic text-left text-md-center">
		  					<?php echo $i++; ?> тур <span class="px-3">-</span> <?php echo $game['date_start']
		  					. "-" . $game['date_end']; ?>
	  					</td>
		  			</tr>
		  		<?php endif; ?>
		  		<tr>
		  			<td><?php echo ($game['tournament_id'] == "1" ? "П" : "В"); ?></td>
		  			<td><?php echo $game['team_name1']; ?> - <?php echo $game['team_name2']; ?></td>
		  			<td>
						<select class="form-control" name="place" id="place">
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
						<input type="date" class="form-control" name="date" id="date"<?php if (isset($game['date'])) echo " value='" . $game['date'] . "'";?>>
	  					<span class="schedule-date">
	  						<?php if (isset($game['date'])): ?>
	  							<?php echo date_format(date_create($game['date']), "j.m"); ?>
  							<?php else: ?>
  								-
  							<?php endif; ?>
  						</span>
					</td>
					<td>
						<input type="time" class="form-control" name="time" id="time"<?php if (isset($game['time'])) echo " value='" . $game['time'] . "'";?>>
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
		</tbody>
	</table>
</div>