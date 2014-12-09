angular.module('workoutControllers')
.controller('WorkoutCtrl', ['$scope', 'Exercises', '$routeParams', function($scope, Exercises, $routeParams) {
	$scope.FormData = {};
	$scope.FormData.WorkoutID = $routeParams.wid;

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
} ]);