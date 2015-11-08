(function(){
	angular.module("fixture-difficulty-service",[]).
	service('FixtureDifficultyService',function(){
		var difficulty = {'-5':'vvvh','-4': 'vvh','-3':'vh', '-2':'h', '-1':'qh', '0':'m', '1':'qe', '2':'e', '3':'ve', '4': 'vve', '5': 'vvve' };
		var getDifficulty = function(teamDif, oppDif, hora) {
			var result=teamDif-oppDif;
			if (hora === "H") {
				result+=1;
			} else {
				result-=1;
			}
			return difficulty[result]; 
		};
		return {
			getDifficulty: getDifficulty
		}
	});
})();