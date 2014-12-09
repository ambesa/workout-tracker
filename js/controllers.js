angular.module('workoutControllers', [])

.controller('WorkoutLogCtrl', ['$scope', 'Workouts', function($scope, Workouts) {
	$scope.FormData = {};
	$scope.view = 'list';

	$scope.loadWorkouts = function() {
		Workouts.get(function(data) {
			$scope.workouts = data.workouts;
		});
	};

	$scope.submit = function() {
		if ($scope.FormData.Date) {
			var $param = {
				"StartDate": $scope.FormData.Date,
				"EndDate": $scope.FormData.Date,
				"Location": $scope.FormData.Location,
				"Notes": $scope.FormData.Notes,
			};
			$scope.workouts.push($param);
			Workouts.save({}, $param, function() {
				$scope.loadWorkouts();
			});
			$scope.FormData.Date = '';
			$scope.FormData.Time = '';
			$scope.FormData.Location = '';
			$scope.FormData.Notes = '';
		}
	};

	$scope.delete = function($sid) {
		Workouts.delete({ wid: $routeParams.wid}, function() {
			$scope.loadWorkouts();
		});
	};

	$scope.loadWorkouts();
} ])

.controller('WorkoutCtrl', ['$scope', 'Exercises', '$routeParams', function($scope, Exercises, $routeParams) {
	$scope.FormData = {};
	$scope.FormData.WorkoutID = $routeParams.wid;
	$scope.view = 'list';

	$scope.loadExercises = function() {
		Exercises.get({ wid: $routeParams.wid }, function(data) {
	    	$scope.exercises = data.exercises;
		});
	}

	$scope.submit = function() {
		if ($scope.FormData.ExerciseName) {
			var $param = {
				"ExerciseName": $scope.FormData.ExerciseName
			};
			Exercises.save({ wid: $routeParams.wid}, $param, function() {
				$scope.loadExercises();
			});
			$scope.FormData.ExerciseName = ''
		}
	};

	$scope.delete = function($eid) {
		console.log($eid);
		Exercises.delete({ wid: $routeParams.wid, eid: $eid}, function() {
			$scope.loadExercises();
		});
	};

	$scope.loadExercises();
} ])

.controller('ExerciseCtrl', ['$scope', 'Sets', '$routeParams', function($scope, Sets, $routeParams) {
	$scope.WorkoutID = $routeParams.wid;
	$scope.FormData = {};
	$scope.view = 'list';

	$scope.loadSets = function() {
		Sets.get( { wid: $routeParams.wid, eid: $routeParams.eid }, function(data) {
    		$scope.sets = data.sets;
		});
	};

	$scope.submit = function() {
		if ($scope.FormData.Quantity && $scope.FormData.Repetition) {
			var $param = {
				"Quantity": $scope.FormData.Quantity,
				"Repetition": $scope.FormData.Repetition,
			};
			Sets.save({ wid: $routeParams.wid, eid: $routeParams.eid}, $param, function() {
				$scope.loadSets();
			});
			$scope.FormData.Quantity = '';
			$scope.FormData.Repetition = '';
		}
	};

	$scope.delete = function($sid) {
		Sets.delete({ wid: $routeParams.wid, eid: $routeParams.eid, sid: $sid}, function() {
			$scope.loadSets();
		});
	};

	$scope.loadSets();
} ]);