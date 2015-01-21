var workoutFilters = angular.module('workoutFilters', []);

workoutFilters
.filter("asDate", function () {
    return function (input) {
    	input = new Date(input).toISOString();
    	return input;
    }
});