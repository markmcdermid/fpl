(function(){
	angular.module("wrap-directive",[])
	.directive('wrap', function(){
		return {
			restrict: 'E',
			templateUrl: 'templates/wrap.html',
			controller: function() {
				this.wrap = 1;
				this.selectWrap = function(setWrap) {
					this.wrap = setWrap;
				};
				this.isSelected = function(checkWrap) {
					return this.wrap === checkWrap;
				};
			},
			controllerAs: 'wrap'
		};
	});
})();