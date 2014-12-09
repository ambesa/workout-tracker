angular.module('workoutControllers')
.controller('WorkoutLogCtrl', ['$scope', 'Workouts', function($scope, Workouts) {
	Workouts.get(function(data) {
		$scope.workouts = data.workouts;
	});
} ]);