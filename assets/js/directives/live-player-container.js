(function(){
	angular.module("live-player-container-directive",[]).
	directive('livePlayerContainer', function() {
		return {
			restrict: 'E',
			templateUrl: 'templates/live-player-container.html',
			controller: ['$scope',function($scope){
				$scope.width = 100/$scope.line.length+'%';
			}], 
			controllerAs: 'pitch',
		};
	});

})();