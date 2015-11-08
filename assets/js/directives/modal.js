(function(){
	angular.module("modal-directive",[]).
	directive('modal', function() {
		return {
			restrict: 'E',
			templateUrl: 'templates/modal.html',
			controller: ['$firebaseAuth','$scope','$rootScope','UserService',function($firebaseAuth, $scope, $rootScope, UserService) {

				$scope.mdShow = function() {
					return $rootScope.modal===1;
				}

				$scope.fbLogin = function() {
					UserService.fbLogin();
					$scope.provider = 'facebook'
				}
				
				/*$scope.login = function (email, password) {
					auth.$authWithPassword({
						email: email,
						password: password
					}).catch(function(error) {
						console.error("Authentication failed:", error);
					}); 
}*/
}]

};
});
})();