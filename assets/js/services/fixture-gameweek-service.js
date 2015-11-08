(function(){
	angular.module("fixture-gameweek-service",[]).
	factory('FixtureGwkService', ['$rootScope','GameweekJsonFactory','$http',function($rootScope, GameweekJsonFactory,$http){
		return service = {
			getGwk: function(gwk){
				promise = $http.get('jsons/fixtures/fixtures06.json');
				return promise;
			},
			getGwks: function(gwk) {
				d= [gwk-1,gwk,gwk+1];
				var d = d.map(function(i) {
					i = (i<10) ? "0"+i : i;
					return i;
				})

				promises = d.map(function(i){
					return $http({
						url   : 'jsons/fixtures/fixtures'+i+'.json',
						method: 'GET',
					});
					return response.data
				});
				return promises;
			}
		}
	}]);
})();