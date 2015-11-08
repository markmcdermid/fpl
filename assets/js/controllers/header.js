(function(){
	angular.module("header-controller",[])
	.controller('HeadCtrl', ['$rootScope','$scope','UserService',function($rootScope,$scope,UserService) {
		
		$rootScope.addModal = function () {
			$rootScope.modal=1;
		}

		$scope.loggedIn = UserService.loggedIn;

		$scope.fbLogin = UserService.fbLogin;

		$scope.logout = UserService.logout;
	}]);

})();