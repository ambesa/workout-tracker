angular.module('workoutControllers', [])
.controller('WorkoutLogCtrl', ['$scope', 'Workouts', 'All', function($scope, Workouts, All) {
	$scope.FormData = {};
	$scope.view = 'list';

	$scope.loadWorkouts = function() {
		/*Workouts.get(function(data) {
			$scope.workouts = data.workouts;
		});*/
		All.get(function(data) {
			$scope.workouts = data.workouts;
		})
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