(function(){
	angular.module("compare-teams-controller",[])
	.controller('CompareTeamsController',['$rootScope','$scope','compareTeams', function($rootScope,$scope,compareTeams) {
		$scope.teamFixtures = compareTeams;
		console.log($scope.fixtures);
		$scope.gwkSlider = $rootScope.gwk-1;
	}]);

})();