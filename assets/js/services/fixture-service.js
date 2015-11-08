(function(){
	angular.module('fixture-service',[]).
	factory('FixtureService',function(){
		var fix = 0;
		var setFix = function(newFix) {
			console.log(fix);
			fix = newFix;
			return fix;
		};

		var checkFix = function(isFix) {
			return isFix===fix;
		}

		var prevFix = function() {
			fix -= 1;
		} 
		var nextFix = function() {
			fix += 1;
		}  
		return {
			setFix: setFix,
			checkFix: checkFix,
			prevFix: prevFix,
			nextFix: nextFix,
		}
	});
})();