var workoutApp = angular.module('workout', ['ngRoute', 'ngResource', 'workoutControllers', 'workoutFilters', 'ui.bootstrap.datetimepicker']);
workoutApp.config(['$routeProvider',
	function($routeProvider) {
	  $routeProvider.
	    when('/workouts', {
	      templateUrl: 'partials/workout-log.html',
	      controller: 'WorkoutLogCtrl'
	    }).
	    when('/workout/:wid', {
	      templateUrl: 'partials/workout.html',
	      controller: 'WorkoutCtrl'
	    }).
	    when('/workout/:wid/exercise/:eid', {
	      templateUrl: 'partials/exercise.html',
	      controller: 'ExerciseCtrl'
	    }).
	    otherwise({
	      redirectTo: '/workouts'
	    });
	}]
);