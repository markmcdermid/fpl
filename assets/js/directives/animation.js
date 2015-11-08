(function(){
	angular.module("animation-directive",[]).
	directive('loginAnimate',['$rootScope', function($rootScope) {
		return {
			link: function(sc, el, attr) {
				$rootScope.$on('auth-event-success',function(){
					el.addClass('success');
				})
			}

		};
	}]);
})();