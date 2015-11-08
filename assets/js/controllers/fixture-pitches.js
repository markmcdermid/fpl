(function(){
	angular.module("fixture-pitches-controller",[])
	.controller('FixturePitchesController',['$rootScope', 'GameweekJsonFactory', '$stateParams', '$scope', 'PlayerJsonService',function($rootScope,GameweekJsonFactory, $stateParams, $scope, PlayerJsonService){
		if ($scope.players === undefined) {
			$rootScope.loading = true;
			PlayerJsonService.getPlayers()
			.then(
				function (data) {
					if ($stateParams.idA) {
					var home = data[$stateParams.idA];
					var away = data[$stateParams.idB];
					$rootScope.loading = false;
					$scope.playersHome = home;
					$scope.playersAway = away.reverse();
					$scope.homeLength = 100/home.length+'%';
					$scope.awayLength = 100/away.length+'%';
				}
				});
		}

		$scope.pitchHide = function () {
			$rootScope.pitchHidden = true;
		}
	}]);
})();