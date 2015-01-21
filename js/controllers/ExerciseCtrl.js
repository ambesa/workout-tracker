angular.module('workoutControllers')
.controller('ExerciseCtrl', ['$scope', 'Workouts', 'Sets', '$routeParams', function($scope, Workouts, Sets, $routeParams) {
	$scope.WorkoutID = $routeParams.wid;
	$scope.FormData = {};

	$scope.loadWorkoutInfo = function() {
	};

	$scope.loadSets = function() {
		Sets.get( { wid: $routeParams.wid, eid: $routeParams.eid }, function(data) {
    		$scope.sets = data.sets;
    		console.log(sets);
		});
		Workouts.get( { wid: $routeParams.wid }, function(data) {
    		$scope.workout = data.workout;
    		console.log(data);
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
	};

	$scope.delete = function($sid) {
		Sets.delete({ wid: $routeParams.wid, eid: $routeParams.eid, sid: $sid}, function() {
			$scope.loadSets();
		});
	};

	$scope.loadSets();
	$scope.loadWorkoutInfo();
  
} ]);