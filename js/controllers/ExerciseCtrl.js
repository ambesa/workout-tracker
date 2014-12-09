angular.module('workoutControllers')
.controller('ExerciseCtrl', ['$scope', 'Sets', '$routeParams', function($scope, Sets, $routeParams) {
	$scope.WorkoutID = $routeParams.wid;
	$scope.FormData = {};

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