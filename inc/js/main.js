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
	$("#inputTournament").change(function() {
		if ($(this).val() != 0)
			$(".btn").attr("disabled", false);
		else
			$(".btn").attr("disabled", true);
	});
	$("#chooseTeams select").change(function() {
		if ($("#inputTeam1").val() == "0" || $("#inputTeam2").val() == "0" || $("#inputTeam1").val() == $("#inputTeam2").val())
			$(".btn").attr("disabled", true);
		else
			$(".btn").attr("disabled", false);
	});
	$("#chooseTeams").submit(function() {
		var data = $(this).serialize();
		var tournament = $(this).find("[name='tournament']").val();
		$.ajax({
			type: "POST",
			url: "procedures/checkTeams.php",
			data: data
		}).done(function(res) {
			if (res == "success") {
				window.location = "/input.php?" + data;			}
			else
				window.location = "/input.php?tournament=" + tournament + "&result=error&code=2";
		}).fail(function() {
			window.location = "/input.php?tournament=" + tournament + "&result=error&code=3";
		});
		return false;
	});
	$("#fillLineup select").change(function() {
		$("#fillLineup select").removeClass("border-danger");
		$("#min, #max, #d12, #sd3").removeClass("text-danger");
		var t1d12 = [$("[name='t1d1p1']").val(), $("[name='t1d1p2']").val(), $("[name='t1d2p1']").val(), $("[name='t1d2p2']").val()];
		var t1d12_valid = unique(t1d12).length == 4 && $.inArray("0", t1d12) < 0;
		var t2d12 = [$("[name='t2d1p1']").val(), $("[name='t2d1p2']").val(), $("[name='t2d2p1']").val(), $("[name='t2d2p2']").val()];
		var t2d12_valid = unique(t2d12).length == 4 && $.inArray("0", t2d12) < 0;
		var t1sd3 = [$("[name='t1s1p1']").val(), $("[name='t1s2p1']").val(), $("[name='t1d3p1']").val(), $("[name='t1d3p2']").val()];
		var t1sd3_valid = unique(t1sd3).length == 4 && $.inArray("0", t1sd3) < 0;
		var t2sd3 = [$("[name='t2s1p1']").val(), $("[name='t2s2p1']").val(), $("[name='t2d3p1']").val(), $("[name='t2d3p2']").val()];
		var t2sd3_valid = unique(t2sd3).length == 4 && $.inArray("0", t2sd3) < 0;
		var t1_cl = unique(t1d12.concat(t1sd3)).length;
		var t2_cl = unique(t2d12.concat(t2sd3)).length;
		var t1_valid = t1_cl <= 7 && t1_cl >= 4;
		var t2_valid = t2_cl <= 7 && t2_cl >= 4;
		if ((t1_cl <= 3 && t1_cl > 0) || (t2_cl <= 3 && t2_cl > 0))
			$("#min").addClass("text-danger");
		if ((t1_cl >= 8 && t1_cl > 0) || (t2_cl >= 8 && t2_cl > 0))
			$("#max").addClass("text-danger");
		if (t1d12_valid && t1sd3_valid && t2d12_valid && t2sd3_valid && t1_valid && t2_valid)
			$(".btn").attr("disabled", false);
		else {
			$(".btn").attr("disabled", true);
			if ($.inArray("0", t1d12) < 0
				&& checkDoubles($("[name='t1d1p1'], [name='t1d1p2'], [name='t1d2p1'], [name='t1d2p2']"))) {
				$("#d12").addClass("text-danger");
			}
			if ($.inArray("0", t2d12) < 0
				&& checkDoubles($("[name='t2d1p1'], [name='t2d1p2'], [name='t2d2p1'], [name='t2d2p2']")))
				$("#d12").addClass("text-danger");
			if ($.inArray("0", t1sd3) < 0
				&& checkDoubles($("[name='t1s1p1'], [name='t1s2p1'], [name='t1d3p1'], [name='t1d3p2']")))
				$("#sd3").addClass("text-danger");
			if ($.inArray("0", t2sd3) < 0 
					&& checkDoubles($("[name='t2s1p1'], [name='t2s2p1'], [name='t2d3p1'], [name='t2d3p2']")))
				$("#sd3").addClass("text-danger");
			if ($.inArray("0", t1d12) < 0 && $.inArray("0", t1sd3) < 0 && !t1_valid) {
				$("[name='t1d3p2']").addClass("border-danger");
			}
			if ($.inArray("0", t2d12) < 0 && $.inArray("0", t2sd3) < 0 && !t2_valid) {
				$("[name='t2d3p2']").addClass("border-danger");
			}
		}
		if (t1d12_valid && t1sd3_valid && t1_valid && !$("#hide2").is(":visible") && !$("#hideRow").hasClass("hidden")) {
			$("#hideRow, #hide1").show();
			$("#hide1").attr("disabled", false);
		}
		if (t2d12_valid && t2sd3_valid && t2_valid && !$("#hide1").is(":visible") && !$("#hideRow").hasClass("hidden")) {
			$("#hideRow, #hide2").show();
			$("#hide2").attr("disabled", false);
		}
	});
	function unique(arr) {
		var obj = {};
		for (var i = 0; i < arr.length; i++) {
			var str = arr[i];
			obj[str] = true;
		}
		return Object.keys(obj);
	}
	function checkDoubles($obj) {
		var $i1, $i2, $i3, $i4;
		var result = 0;
		$obj.each(function(i, v) {
			switch (i) {
				case 0:
					$i1 = $(v);
					break ;
				case 1:
					$i2 = $(v);
					if ($i1.val() == $i2.val()) {
						$i1.addClass("border-danger");
						$i2.addClass("border-danger");
						result = 1;
					}
					break ;
				case 2:
					$i3 = $(v);
					if ($i1.val() == $i3.val()) {
						$i1.addClass("border-danger");
						$i3.addClass("border-danger");
					}
					if ($i2.val() == $i3.val()) {
						$i2.addClass("border-danger");
						$i3.addClass("border-danger");
					}
					if ($i1.val() == $i3.val() || $i2.val() == $i3.val())
						result = 1;
					break ;
				case 3:
					$i4 = $(v);
					if ($i1.val() == $i4.val()) {
						$i1.addClass("border-danger");
						$i4.addClass("border-danger");
					}
					if ($i2.val() == $i4.val()) {
						$i2.addClass("border-danger");
						$i4.addClass("border-danger");
					}
					if ($i3.val() == $i4.val()) {
						$i3.addClass("border-danger");
						$i4.addClass("border-danger");
					}
					if ($i1.val() == $i4.val() || $i2.val() == $i4.val() || $i3.val() == $i4.val())
						result = 1;
					break ;
			}
		});
		return (result);
	}
	if ($("#addResult").length) {
		updateSum();
		if (isScoreValid())
			$(".btn[type='submit']").attr("disabled", false);
		else
			$(".btn[type='submit']").attr("disabled", true);
		$("#addResult input[disabled]").each(function(i, v) {
			if ($(this).val() != 0 || $(this).parents("tr").find(".form-control").not($(this)).val() != 0)
				$(this).attr("disabled", false);
		});
	}
	$("#addResult .form-control").change(function() {
		var index = $(this).parents("tr").index("tr");
		var cap = index * 2;
		var prevSum1 = prevSum2 = 0;
		$(this).parents("tbody").find("tr").each(function(i, v) {
			if (i == index - 1)
				return false ;
			else if (i != 0 && i % 2) {
				prevSum1 += +$(v).find(".form-control:eq(0)").val();
				prevSum2 += +$(v).find(".form-control:eq(1)").val();
			}
		});
		max = ($(this).index(".form-control") + 1) % 2 ? cap - prevSum1 : cap - prevSum2;
		maxOp = ($(this).index(".form-control") + 1) % 2 ? cap - prevSum2 : cap - prevSum1;
		if ($(this).val() > max)
			$(this).val(max);
		var val = $(this).val();
		if (val != max)
			$(this).parents("tr").find(".form-control").not($(this)).val(maxOp);
		else if (val == max && $(this).parents("tr").find(".form-control").not($(this)).val() == maxOp)
			$(this).parents("tr").find(".form-control").not($(this)).val(maxOp - 1);
		var filled = 0;
		$(this).parents("tr").find(".form-control").each(function () {
			if ($(this).val() != "")
				filled++;
		});
		if (filled == 2) {
			prevSum1 += +$(this).parents("tr").find(".form-control:eq(0)").val();
			prevSum2 += +$(this).parents("tr").find(".form-control:eq(1)").val();
			$(this).parents("tbody").find("tr:eq(" + ($(this).parents("tr").index("tr") + 1) + ") .form-control")
				.attr("disabled", false).each(function(i) {
					var max = !i ? prevSum1 : prevSum2;
					console.log(max);
					$(this).attr("placeholder", "max " + ($(this).parents("tr").index("tr") * 2 - max));
				});
		}
		updateSum();
		if (isScoreValid())
			$(".btn").attr("disabled", false);
		else
			$(".btn").attr("disabled", true);
	});
	function updateSum() {
		var score1 = score2 = 0;
		$("[name^='r1t1'], [name^='r2t1']").each(function() {
			score1 += +$(this).val();
		});
		$("[name^='r1t2'], [name^='r2t2']").each(function() {
			score2 += +$(this).val();
		});
		$("#t1score, [name='t1score']").val(score1);
		$("#t2score, [name='t2score']").val(score2);
	}
	function isScoreValid() {
		if ((+$("#t1score").val() + +$("#t2score").val()) > 79 
			|| (+$("#t1score").val() + +$("#t2score").val()) < 40 
			|| (+$("#t1score").val() != 40 && +$("#t2score").val() != 40))
			return (0);
		return (1);
	}
	$("#addResult").submit(function() {
		$(".btn").attr("disabled", true).find(".spinner-border").removeClass("d-none");
	});
	$("[data-action='scheduleEdit']").click(function() {
		$(this).parents("tr").find(".schedule-place, .schedule-date, .schedule-time").hide();
		$(this).parents("tr").find(".custom-select:not(#teamFilter), .form-control:not([type='hidden']), [data-action='scheduleClear'], [data-action='scheduleSubmit'], [data-action='scheduleQuit']")
			.show();
		$(this).hide();
	});
	$("[data-action='scheduleQuit']").click(function() {
		$(this).parents("tr").find(".schedule-place, .schedule-date, .schedule-time, [data-action='scheduleEdit']").show();
		$(this).parents("tr").find(".custom-select:not(#teamFilter), .form-control:not([type='hidden']), [data-action='scheduleClear'], [data-action='scheduleSubmit']")
			.hide();
		$(this).hide();
	});
	$("[data-action='scheduleClear']").click(function() {
		$(this).parents("tr").find("input.form-control:not([type='hidden'])").val("");
		$(this).parents("tr").find("select").val("0");
	});
	$("[data-action='scheduleSubmit']").click(function() {
		var data = $(this).parents("tr").find(".form-control, .custom-select:not(#teamFilter)").serialize();
		console.log(data);
		$.ajax({
			type: "POST",
			url: "procedures/updateSchedule.php",
			data: data
		}).done(function(data) {
			if (data == "success")
				window.location += "&result=success";
			else
				window.location += "&result=error";
		}).fail(function() {		
			window.location += "&result=error";
		});
		return false;
	});
	if ($(window).width() >= 576) {
		$.datepicker.regional["ru"]["dateFormat"] = "yy-mm-dd";
		$("[name='date']").attr("type", "text").datepicker($.datepicker.regional["ru"]);
	}
	$("#teamFilter").change(function() {
		var data = $(this).serialize();
		var s_url = window.location.search;
		var tournament;
		if (s_url) {
			var $_GET = s_url.substr(1).split("&");
			for (var i = 0; i < $_GET.length; i++)
				if (~$_GET[i].indexOf("tournament")) 
					tournament = $_GET[i];
		} else
			tournament="tournament=pro"
		window.location = "/schedule.php?" + tournament + "&" + data;
	});
	$("#clearTeamFilter").click(function() {
		if ($("#teamFilter").val() == "0")
			return ;
		$("#teamFilter").val("0").trigger("change");
	});
	$("#search1, #search2").submit(function() {
		var search_value = $(this).parent().find(".form-control").val();
		$(this).parents(".table-responsive").find("tbody tr").removeClass("d-none");
		if (!search_value)
			return false;
		$(this).parents(".table-responsive").find("tbody tr").each(function(i, v) {
			var match = 0;
			$(v).find("td").each(function(i,v) {
				if (~$(v).text().toLowerCase().indexOf(search_value.toLowerCase())) {
					match++;
					return false;
				}
			});
			if (!match)
				$(v).addClass("d-none");
		});
		return false;
	});
	$("#clear1, #clear2").click(function() {
		$(this).parent().find(".form-control").val("");
		$(this).parent().submit();
	});
	$("#hide1, #hide2").click(function() {
		var elemsToHide = $(this).attr("id") == "hide1" ? [0, 1, 4, 5, 8, 10, 12, 13] : [2, 3, 6, 7, 9, 11, 14, 15];
		$(this).parents("table").find(".custom-select").each(function(i, v) {
			if (~elemsToHide.indexOf(i))
				$(v).css("visibility", "hidden");
		});
		$("#hideRow").addClass("hidden").hide();
		return false;
	});
	$("#t11, #t12, #t21, #t22").click(function() {
		$(this).toggleClass("pressed");
		$(this).parent().focus();
	});
});