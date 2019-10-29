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
		var season = $(this).find("[name='season']").val();

		$.ajax({
			type: "POST",
			url: "procedures/checkTeams.php",
			data: data
		}).done(function(res) {
			if (res == "success") {
				window.location = "/input.php?" + data;			}
			else
				window.location = "/input.php?tournament=" + tournament + "&result=error&code=2&rounds=" + res;
		}).fail(function() {
			window.location = "/input.php?tournament=" + tournament + "&result=error&code=3";
		});
		return false;
	});
	// Lineup Pros
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
			$(".btn[type='submit']").attr("disabled", false);
		else {
			$(".btn[type='submit']").attr("disabled", true);
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
	$("#hide1, #hide2").click(function() {
		var $elemsToHide = $(this).attr("id") == "hide1" ? $("[name^='t1']") : $("[name^='t2']");
		$elemsToHide.css("visibility", "hidden");
		$("#hideRow").addClass("hidden").hide();
		return false;
	});
	$("#t11, #t12, #t21, #t22").click(function() {
		$(this).toggleClass("pressed");
		$(this).parent().focus();
	});
	// Lineup Amateurs
	$("#fillLineupAmateurs select").change(function() {
		$("#fillLineupAmateurs select").removeClass("border-danger");
		$("#d12, #d34, #s12, #one").removeClass("text-danger");
		// проверить, что d1 и d2 - разные пары
		var t1d1 = [$("[name='t1d1p1']").val(), $("[name='t1d1p2']").val()];
		var t2d1 = [$("[name='t2d1p1']").val(), $("[name='t2d1p2']").val()];
		var t1d2 = [$("[name='t1d2p1']").val(), $("[name='t1d2p2']").val()];
		var t2d2 = [$("[name='t2d2p1']").val(), $("[name='t2d2p2']").val()];
		var t1d12 = [$("[name='t1d1p1']").val(), $("[name='t1d1p2']").val(), $("[name='t1d2p1']").val(), $("[name='t1d2p2']").val()];
		var t2d12 = [$("[name='t2d1p1']").val(), $("[name='t2d1p2']").val(), $("[name='t2d2p1']").val(), $("[name='t2d2p2']").val()];
		var t1d12_valid = unique(t1d1).length == 2 && unique(t1d2).length == 2 && unique(t1d12).length >= 3 && $.inArray("0", t1d12) < 0;
		var t2d12_valid = unique(t2d1).length == 2 && unique(t2d2).length == 2 && unique(t2d12).length >= 3 && $.inArray("0", t2d12) < 0;
		if (!t1d12_valid && $.inArray("0", t1d12) < 0) {
			$("[name^='t1d1'], [name^='t1d2']").addClass("border-danger");
			$("#d12").addClass("text-danger");
		}
		if (!t2d12_valid && $.inArray("0", t2d12) < 0) {
			$("[name^='t2d1'], [name^='t2d2']").addClass("border-danger");
			$("#d12").addClass("text-danger");
		}
		var d12_valid = t1d12_valid && t2d12_valid;
		// проверить, что d3 и d4 - разные пары
		var t1d3 = [$("[name='t1d3p1']").val(), $("[name='t1d3p2']").val()];
		var t2d3 = [$("[name='t2d3p1']").val(), $("[name='t2d3p2']").val()];
		var t1d4 = [$("[name='t1d4p1']").val(), $("[name='t1d4p2']").val()];
		var t2d4 = [$("[name='t2d4p1']").val(), $("[name='t2d4p2']").val()];
		var t1d34 = [$("[name='t1d3p1']").val(), $("[name='t1d3p2']").val(), $("[name='t1d4p1']").val(), $("[name='t1d4p2']").val()];
		var t2d34 = [$("[name='t2d3p1']").val(), $("[name='t2d3p2']").val(), $("[name='t2d4p1']").val(), $("[name='t2d4p2']").val()];
		var t1d34_valid = unique(t1d3).length == 2 && unique(t1d4).length == 2 && unique(t1d34).length >= 3 && $.inArray("0", t1d34) < 0;
		var t2d34_valid = unique(t2d3).length == 2 && unique(t2d4).length == 2 && unique(t2d34).length >= 3 && $.inArray("0", t2d34) < 0;
		if (!t1d34_valid && $.inArray("0", t1d34) < 0) {
			$("[name^='t1d3'], [name^='t1d4']").addClass("border-danger");
			$("#d34").addClass("text-danger");
		}
		if (!t2d34_valid && $.inArray("0", t2d34) < 0) {
			$("[name^='t2d3'], [name^='t2d4']").addClass("border-danger");
			$("#d34").addClass("text-danger");
		}
		var d34_valid = t1d34_valid && t2d34_valid;
		// проверить, чтобы одиночки разные
		var t1s12 = [$("[name='t1s1p1']").val(), $("[name='t1s2p1']").val()];
		var t2s12 = [$("[name='t2s1p1']").val(), $("[name='t2s2p1']").val()];
		var t1s12_valid = unique(t1s12).length == 2 && $.inArray("0", t1s12) < 0;
		var t2s12_valid = unique(t2s12).length == 2 && $.inArray("0", t2s12) < 0;
		if (!t1s12_valid && $.inArray("0", t1s12) < 0) {
			$("[name^='t1s1'], [name^='t1s2']").addClass("border-danger");
			$("#s12").addClass("text-danger");
		}
		if (!t2s12_valid && $.inArray("0", t2s12) < 0) {
			$("[name^='t2s1'], [name^='t2s2']").addClass("border-danger");
			$("#s12").addClass("text-danger");
		}
		var s12_valid = t1s12_valid && t2s12_valid;
		// проверить, чтобы каждый игрок не более 2 игр
		var t1one_valid = check_one("t1");
		var t2one_valid = check_one("t2");
		var one_valid = t1one_valid && t2one_valid;
		if (t1d12_valid && t1d34_valid && t1s12_valid && t1one_valid && !$("#hide2").is(":visible") && !$("#hideRow").hasClass("hidden")) {
			$("#hideRow, #hide1").show();
			$("#hide1").attr("disabled", false);
		}
		if (t2d12_valid && t2d34_valid && t2s12_valid && t1one_valid && !$("#hide1").is(":visible") && !$("#hideRow").hasClass("hidden")) {
			$("#hideRow, #hide2").show();
			$("#hide2").attr("disabled", false);
			console.log(1);
		}
		if (one_valid && d12_valid && d34_valid && s12_valid)
			$(".btn[type='submit']").attr("disabled", false);
		else
			$(".btn[type='submit']").attr("disabled", true);
	});
	function check_one(team) {
		var $team = $("[name^='" + team + "']");
		var count = {};
		$team.each(function() {
			var changed = 0;
			for (key in count) {
				if ($(this).val() == key) {
					count[key]++;
					changed = 1;
					break ;
				}
			}
			if (!changed)
				count[$(this).val()] = 1;
		});
		var valid = true;
		for (key in count) {
			if (key == 0)
				continue ;
			if (count[key] >= 3) {
				valid = false;
				// подсветить ошибки
				$("select").each(function() {
					if ($(this).val() == key) {
						$(this).addClass("border-danger");
						$("#one").addClass("text-danger");
					}
				});
			}
		}
		return (valid);
	}
	// Add Result Pros
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
	// Add Result Amateurs
	$("#addResultAmateurs .form-control").change(function() {
		if ($(this).val() > 5) $(this).val(5);
		if ($(this).val() < 0) $(this).val(0);
		if ($(this).val() < 5 && $(this).val() > 0)
			if (~$(this).attr("name").indexOf("t1")) {
				var $t2 = $("[name='" + $(this).attr("name").replace("t1", "t2") + "']");
				$t2.val(5);
			} else {
				var $t1 = $("[name='" + $(this).attr("name").replace("t2", "t1") + "']");
				$t1.val(5);
			}
		if ($(this).val() >= 5)
			if (~$(this).attr("name").indexOf("t1")) {
				var $t2 = $("[name='" + $(this).attr("name").replace("t1", "t2") + "']");
				if ($t2.val() == 5) $t2.val(4);
			} else {
				var $t1 = $("[name='" + $(this).attr("name").replace("t2", "t1") + "']");
				if ($t1.val() == 5) $t1.val(4);
			}
		updateSumAmateurs();
		if (allPlayed())
			$(".btn[type='submit']").attr("disabled", false);
		else
			$(".btn[type='submit']").attr("disabled", true);
		function updateSumAmateurs() {
			var t1score = 0, t2score = 0;
			var matches = ["d1", "d2", "s1", "s2", "d3", "d4"];
			matches.forEach(function(entry) {
				var played = 0;
				var t1_won = 0;
				$(".form-control[name$='" + entry + "']").each(function() {
					if ($(this).val() != 0 || $("[name='"
						+ (~$(this).attr("name").indexOf("t1") ? 
							$(this).attr("name").replace("t1", "t2") : $(this).attr("name").replace("t2", "t1")) 
						+ "']").val() != 0) {
						played++;
						if (~$(this).attr("name").indexOf("t1"))
							if ($(this).val() == 5)
								t1_won++;
					}
				});
				if (played == 4)
					if (t1_won == 2)
						t1score++;
					else if (t1_won == 0)
						t2score++;
			});
			$("#t1score, [name='t1score']").val(t1score);
			$("#t2score, [name='t2score']").val(t2score);
		}
		function allPlayed() {
			var played = 0;
			$(".form-control").each(function() {
				if ($(this).val() != 0 || $("[name='"
					+ (~$(this).attr("name").indexOf("t1") ? 
						$(this).attr("name").replace("t1", "t2") : $(this).attr("name").replace("t2", "t1")) 
					+ "']").val() != 0) {
					played++;
				}
			});
			return (played == 24);
		}
	});
	$("#addResult, #addResultAmateurs").submit(function() {
		$(".btn[type='submit']").attr("disabled", true).find(".spinner-border").removeClass("d-none");
	});
	// Schedule
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
});