(function(){
	angular.module("gameweek-json-service",[])
	.factory('GameweekJsonFactory', ['$rootScope','$http',function($rootScope,$http){
		var promise;
		return service = {
			async: function() {
				if ( !promise ) {
					promise = $http.get('jsons/gameweeks.json').then(function(response){
						d=response.data;
						var date = new Date().getTime();
						for (var i=0; i<d.length; i++) {
							if (date<d[i].start){
								var gwk = d[i].gameweek_id;
								gwk=gwk*1;
								$rootScope.gwk = gwk;
								break;
							}
						}
						return d;
					});
				}
				return promise;
			},
			nextGwk: function() {
				var promise;
				if(!promise){
					promise = this.async().then(function(){
						$rootScope.gwk++;							
					});
				}
				return promise;
			},
			previousGwk: function() {
				var promise;
				if(!promise){
					promise = this.async().then(function(){
						$rootScope.gwk--;							
					});
				}
				return promise;
			}
		}
	}]);
})();