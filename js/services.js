workoutApp.factory('Workouts', ['$resource', function($resource) {
  return $resource('services/workouts/:wid');
}]);

workoutApp.factory('Exercises', ['$resource', function($resource) {
  return $resource('services/workouts/:wid/exercises/:eid');
}]);

workoutApp.factory('Sets', ['$resource', function($resource) {
  return $resource('services/workouts/:wid/exercises/:eid/sets/:sid');
}]);