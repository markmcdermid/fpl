(function(){
	angular.module("compare-teams-service",[])
	.factory('CompareTeamsService', ['$rootScope','$http',function($rootScope,$http){

		return {
			getTeamFix:function() {
				$rootScope.loading = true;
				return $http.get('jsons/fixturesall.json').then(function(d){
					$rootScope.loading = false;
					return d.data;
				});
			}
		}
}]);
})();