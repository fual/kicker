<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="inc/libs/bootstrap/js/bootstrap.min.js"></script>
<script>
	$(function() {
		$("#inputTournament").change(function() {
			updateTeamOptions();
		});
		/* updateTeamOptions: manage team names select options on tournament change */
		var $options = $("#inputTeam1 options");
		function updateTeamOptions() {
			var tournament = $("#inputTournament").val();
			$("#inputTeam1 option, #inputTeam2 option").removeAttr("style");
			$("#inputTeam1 [data-tournament!=" + tournament + "], #inputTeam2 [data-tournament!=" + tournament + "]").hide();
		}
		$("form").submit(function() {
			var data = $(this).serialize();
			$.ajax({
				type: "POST",
				url: "procedures/addResult.php",
				data: data
			});
		});
	});
</script>