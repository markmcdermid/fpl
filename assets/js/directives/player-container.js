(function(){
	angular.module("player-container-directive",[]).
	directive('playerContainer', function() {
		return {
			restrict: 'E',
			templateUrl: 'templates/player-container.html',
			controller: function($scope){
				$scope.width = 100/$scope.line.length+'%';
			}, 
			controllerAs: 'pitch',
		};
	});

})();