(function(){
	angular.module("player-json-service",[]).
	factory("PlayerJsonService", ['$http',function ($http) {
		var promise;
		if (!promise) {
			return {
				getPlayers: function () {
					return $http.get('jsons/team/teams.json')
					.then(function(response) {
						promise = (response.data);
						return promise;
					});
				}
			}
		}
	}]);
})();