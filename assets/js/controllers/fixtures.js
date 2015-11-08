(function(){
	angular.module("fixtures-controller",[])
	.controller('FixturesController',['GameweekJsonFactory','$rootScope','$scope','FixtureService', 'FixtureGwkService', '$state',function(GameweekJsonFactory,$rootScope, $scope, FixtureService, FixtureGwkService, $state) {

		$scope.fixtureState = function(a,b,gwk) {
			$rootScope.pitchHidden = false;
			$state.go('app.fix.list.pitch', {
				idA: a,
				idB: b,
				gwk: gwk
			});
		}

		$scope.pitchHide = function () {
			$rootScope.pitchHidden = true;
		}

		GameweekJsonFactory.async().then(function(){
			$scope.$watch('gwk',function(){
				var potato = FixtureGwkService.getGwks($scope.gwk);
				potato[1].then(function(d){
					$scope.fixtures = d.data;
				});

			});
		});

	}]);
})();