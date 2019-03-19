$(function() {
	if ($("#result").is(":visible")) {
		setTimeout(function() {
			$("#result").slideToggle();
		}, 3000);
	}
	$(document).on({
		ajaxStart: function() { $('body').addClass('loading'); },
		ajaxStop: function() { $('body').removeClass('loading'); }
	});
	$("#addResult select, #addResult input").change(function() {
		if (isValid($("#inputTournament").val()))
			$(".btn").attr("disabled", false);
		else
			$(".btn").attr("disabled", true);
	});
	function isValid(inpTourn) {
		switch (inpTourn) {
			case "1":
				if ($("#inputTeam11").val() == "0" || $("#inputTeam12").val() == "0" || $("#inputTeam11").val() == $("#inputTeam12").val() || !$("#inputScore1").val().length || !$("#inputScore2").val().length || (+$("#inputScore1").val() + +$("#inputScore2").val()) > 79 || (+$("#inputScore1").val() + +$("#inputScore2").val()) < 40 || (+$("#inputScore1").val() != 40 && +$("#inputScore2").val() != 40))
					return (0);
				break ;
			case "2":
				if ($("#inputTeam21").val() == "0" || $("#inputTeam22").val() == "0" || $("#inputTeam21").val() == $("#inputTeam22").val() || !$("#inputScore1").val().length || !$("#inputScore2").val().length || (+$("#inputScore1").val() + +$("#inputScore2").val()) > 79 || (+$("#inputScore1").val() + +$("#inputScore2").val()) < 40 || (+$("#inputScore1").val() != 40 && +$("#inputScore2").val() != 40))
					return (0);
				break ;
			default:
				if (!$("#inputScore1").val().length || !$("#inputScore2").val().length 
					|| (+$("#inputScore1").val() + +$("#inputScore2").val()) > 79 
					|| (+$("#inputScore1").val() + +$("#inputScore2").val()) < 40 
					|| (+$("#inputScore1").val() != 40 && +$("#inputScore2").val() != 40))
					return (0);
				break;
		}
		return (1);
	}
	$("#inputTournament").change(function() {
		$("#score, #firstDiv, #secondDiv").hide();
		$("#inputTeam11, #inputTeam12, #inputTeam21, #inputTeam22").each(function() {
			$(this).val($(this).find("option:first").val());
		});
		if ($(this).val() != "Дивизион...") {
			if ($(this).val() == "1")
				$("#firstDiv").show();
			else
				$("#secondDiv").show();
			$("#score").show();
		}
	});
	$("#addResult").submit(function() {
		var data = $(this).serialize();
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "POST",
			url: "procedures/addResult.php",
			data: data
		}).done(function(data) {
			console.log(data);
			if (data == "success")
				window.location = "/?result=success";
			else
				window.location = "/?result=error&code=" + data;
		}).fail(function() {		
			window.location = "/?result=error&code=3";
		});
		return false;
	});
	$("#editResult input").change(function() {
		if (isValid(0))
			$(".btn").attr("disabled", false);
		else
			$(".btn").attr("disabled", true);
	});
	$("#editResult").submit(function() {
		var data = $(this).serialize();
		$(".btn").attr("disabled", true);
		$.ajax({
			type: "POST",
			url: "procedures/editResult.php",
			data: data
		}).done(function(data) {
			if (data == "success")
				window.location = "/?result=success&code=1";
			else
				window.location = "/?result=error&code=" + data;
		}).fail(function() {		
			window.location = "/?result=error&code=3";
		});
		return false;
	});
	$("#deleteResult").submit(function() {
		var data = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "procedures/deleteResult.php",
			data: data
		}).done(function(data) {
			if (data == "success")
				window.location = "/?result=success&code=2";
			else
				window.location = "/?result=error&code=" + data;
		}).fail(function() {		
			window.location = "/?result=error&code=3";
		});
		return false;
	});
	$("[data-action='scheduleEdit']").click(function() {
		$(this).parents("tr").find(".schedule-place, .schedule-date, .schedule-time").hide();
		$(this).parents("tr").find(".form-control:not([type='hidden']), [data-action='scheduleClear'], [data-action='scheduleSubmit'], [data-action='scheduleQuit']")
			.show();
		$(this).hide();
	});
	$("[data-action='scheduleQuit']").click(function() {
		$(this).parents("tr").find(".schedule-place, .schedule-date, .schedule-time, [data-action='scheduleEdit']").show();
		$(this).parents("tr").find(".form-control:not([type='hidden']), [data-action='scheduleClear'], [data-action='scheduleSubmit']")
			.hide();
		$(this).hide();
	});
	$("[data-action='scheduleClear']").click(function() {
		$(this).parents("tr").find("input.form-control:not([type='hidden'])").val("");
		$(this).parents("tr").find("select").val("0");
	});
	$("[data-action='scheduleSubmit']").click(function() {
		var data = $(this).parents("tr").find(".form-control").serialize();
		console.log(data);
		$.ajax({
			type: "POST",
			url: "procedures/updateSchedule.php",
			data: data
		}).done(function(data) {
			if (data == "success")
				window.location = "/schedule.php?result=success&code=1";
			else
				window.location = "/schedule.php?result=error&code=3";
		}).fail(function() {		
			window.location = "/schedule.php?result=error&code=3";
		});
		return false;
	});
	$("#teamFilter").change(function() {
		var data = $(this).serialize();
		window.location = "/schedule?" + data;
	});
});