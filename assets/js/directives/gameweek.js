(function(){
	angular.module("gameweek-directive",[])
	.directive('gameweek', function() {
		return {
			restrict: 'E',
			templateUrl: 'templates/gameweek.html',
			controller: ['$scope','$rootScope','GameweekJsonFactory',function($scope, $rootScope, GameweekJsonFactory){
				$scope.nextGwk = function() {
					GameweekJsonFactory.nextGwk();
				}
				$scope.previousGwk = function() {
					GameweekJsonFactory.previousGwk();
				}
			}],
			controllerAs: 'gameweek',
		};
	});
})();