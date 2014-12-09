var workoutFilters = angular.module('workoutFilters', []);

workoutFilters
.filter("asDate", function () {
    return function (input) {
        return new Date(input);
    }
});