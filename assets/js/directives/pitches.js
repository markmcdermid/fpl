(function(){
	angular.module("pitches-directive",[]).
		directive('pitches', function() {
		return {
			restrict: 'E',
			templateUrl: 'templates/pitches.html',

		};
	});
})();