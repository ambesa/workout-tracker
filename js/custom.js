jQuery(document).ready(function($) {
	$(".alert").hide();

	$(".clickable-row").click(function(e) {
		if ($(e.target).hasClass('btn')) {
			return;
		}
		window.document.location = $(this).data("url");
	});
  
	$(".workout-edit, .exercise-edit, .set-edit").click(function(e) {
		console.log("Editing...");
		window.document.location = $(this).data("url");
	});
  
	$(".workout-remove, .exercise-remove, .set-remove").click(function(e) {
		console.log("Removing...");
		window.document.location = $(this).data("url");
	});

	function getQueryParams(qs) {
	    qs = qs.split("+").join(" ");
	    var params = {},
	        tokens,
	        re = /[?&]?([^=]+)=([^&]*)/g;

	    while (tokens = re.exec(qs)) {
	        params[decodeURIComponent(tokens[1])]
	            = decodeURIComponent(tokens[2]);
	    }

	    return params;
	}

	var $_GET = getQueryParams(document.location.search);

	$("form#addExerciseInfo").submit(function (e){
		e.preventDefault();
		var _workout_id = $_GET["workout_id"];
		var _exercise_id = $_GET["exercise_id"];
		var _quantity = $("input[name='sets-quantity']").val();
		var _repetitions = $("input[name='sets-repetitions']").val();
		var data = { 
			addExerciseInfo: 0, 
			workout_id: $_GET["workout_id"], 
			exercise_id: $_GET["exercise_id"], 
			quantity: $("input[name='sets-quantity']").val(), 
			repetitions: $("input[name='sets-repetitions']").val() };
		$.ajax({
			dataType: "json",
			type: "POST",
			url: "index.php?action=getExerciseInfo",
			data: data,
			success: function(data) {
				var row_data = '<tr class="set-new" style="display:none;"><td>' + data.SetID + 
					'</td><td>' + data.ExerciseID + 
					'</td><td>' + data.SetOrder + 
					'</td><td>' + data.Quantity +
					'</td><td>' + data.Repetitions +
					'</td><td><button type="button" class="set-edit btn btn-default" data-url="?action=editSet&set_id='+ data.SetID + '&exercise_id='+ data.ExerciseID + '&workout_id=' + $_GET['workout_id'] + '">' +
					'<span class="glyphicon glyphicon-edit"></span> Edit' + 
					'</button><button type="button" class="set-remove btn btn-default" data-url="?action=removeSet&set_id='+ data.SetID +'&exercise_id='+ data.ExerciseID +'&workout_id='+$_GET['workout_id']+'">' + 
					'<span class="glyphicon glyphicon-remove"></span> Remove' +
					'</button></td></tr>';
				if (!$(".sets-data-table").length) {
					var table_html = '<table class="table sets-data-table">' + 
						'<tr><th>SetID</th><th>ExerciseID</th><th>SetOrder</th><th>Quantity</th><th>Repetitions</th><th>Action</th></tr>' + 
						'</table>';
					$(".no-data-table").remove();
					$("#data-container").append(table_html);
				}
				$(row_data).appendTo(".sets-data-table").addClass("success").fadeTo(500, 1).slideDown(1000);
				window.setTimeout(function() {
					$(".set-new").removeClass('success', 4000);
				}, 2500);
				alert("Successfully added!","success");
			},
			error: function(data) {
				console.log(data);
				alert("Failed to add!","danger");
			}
		});
		return false;
	});

	$("form#addWorkoutInfo").submit(function (e){
		e.preventDefault();
		var _workout_id = $_GET["workout_id"];
		var _exercise_id = $_GET["exercise_id"];
		var data = { 
			addWorkoutInfo: 0, 
			workout_id: $_GET["workout_id"], 
			exercise_name: $("input[name='exercises-exercise-name']").val() };
		$.ajax({
			dataType: "json",
			type: "POST",
			url: "index.php?action=getWorkoutInfo",
			data: data,
			success: function(data) {
				var row_data = '<tr class="exercise-new clickable-row" style="display:none;"data-url="?action=getExerciseInfo&exercise_id=' + data.ExerciseID + '&workout_id=' + data.WorkoutID + '"><td>' + data.ExerciseID + 
					'</td><td>' + data.WorkoutID + 
					'</td><td>' + data.ExerciseOrder +
					'</td><td>' + data.ExerciseName +
					'</td><td><button type="button" class="set-edit btn btn-default" data-url="?action=editExercise&exercise_id='+ data.ExerciseID + '&workout_id=' + data.WorkoutID + '">' +
					'<span class="glyphicon glyphicon-edit"></span> Edit' + 
					'</button><button type="button" class="set-remove btn btn-default" data-url="?action=editExercise&exercise_id='+ data.ExerciseID +'&workout_id='+ data.WorkoutID +'">' + 
					'<span class="glyphicon glyphicon-remove"></span> Remove' +
					'</button></td></tr>';
				if (!$(".exercises-data-table").length) {
					var table_html = '<table class="table exercises-data-table">' + 
						'<tr><th>ExerciseID</th><th>WorkoutID</th><th>ExerciseOrder</th><th>ExerciseName</th><th>Action</th></tr>' +
						'</table>';
					$(".no-data-table").remove();
					$("#data-container").append(table_html);
				}
				$(row_data).appendTo(".exercises-data-table").addClass("success").fadeTo(500, 1).slideDown(1000);
				window.setTimeout(function() {
					$(".exercise-new").removeClass('success', 4000);
				}, 2500);
				alert("Successfully added!","success");
			},
			error: function(data) {
				console.log(data);
				alert("Failed to add!","danger");
			}
		});
		return false;
	});

	$("form#addWorkoutLog").submit(function (e){
		e.preventDefault();
		var data = { 
			addWorkoutLog: 0, 
			start_date: $("input[name='workoutlog-start-date']").val(), 
			start_time: $("input[name='workoutlog-start-time']").val(), 
			end_time: $("input[name='workoutlog-end-time']").val(), 
			location: $("input[name='workoutlog-location']").val(), 
			notes: $("input[name='workoutlog-notes']").val()
		};
		$.ajax({
			dataType: "json",
			type: "POST",
			url: "index.php?action=getWorkoutLog",
			data: data,
			success: function(data) {
				var row_data = '<tr class="exercise-new clickable-row" style="display:none;"data-url="?action=getWorkoutInfo&workout_id=' + data.WorkoutID + '"><td>' + data.WorkoutID + 
					'</td><td>' + data.StartDate +
					'</td><td>' + data.Location +
					'</td><td>' + data.Notes +
					'</td><td><button type="button" class="set-edit btn btn-default" data-url="?action=editExercise&exercise_id='+ data.ExerciseID + '&workout_id=' + data.WorkoutID + '">' +
					'<span class="glyphicon glyphicon-edit"></span> Edit' + 
					'</button><button type="button" class="set-remove btn btn-default" data-url="?action=editExercise&exercise_id='+ data.ExerciseID +'&workout_id='+ data.WorkoutID +'">' + 
					'<span class="glyphicon glyphicon-remove"></span> Remove' +
					'</button></td></tr>';
				if ($(".workoutlog-data-table").length) {
					$(row_data).appendTo(".workoutlog-data-table").addClass("success").fadeTo(500, 1).slideDown(1000);
				} else {
					var table_html = '<table class="table workoutlog-data-table">' + 
						'<tr><th>WorkoutID</th><th>Date</th><th>Location</th><th>Notes</th><th>Action</th></tr>' +
						'</table>';
					$(".no-data-table").remove();
					$("#data-container").append(table_html);
					$(row_data).appendTo(".workoutlog-data-table").addClass("success").fadeTo(500, 1).slideDown(1000);
				}
				window.setTimeout(function() {
					$(".exercise-new").removeClass('success', 4000);
				}, 2500);
				alert("Successfully added!","success");
			},
			error: function(data) {
				console.log(data);
				alert("Failed to add!","danger");
			}
		});
		return false;
	});

	function alert(message, alertType) {
		var alert = '<div class="col-md-4 alert alert-dismissable alert-'+alertType+'">'+
			'<button type="button" class="close" data-dismiss="alert"'+
			'aria-hidden="true">'+
			'&times;'+
			'</button>'+
			'<span class="alert-message">'+message+'</span>'+
			'</div>';
		$(alert).prependTo(".content-main").fadeTo(500,1).slideDown(700);
		window.setTimeout(function() {
			$(".alert").fadeTo(500, 0).slideUp(500, function(){
				$(this).remove(); 
			});
		}, 5000);
	} // end alert()

});