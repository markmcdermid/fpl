(function(){
	angular.module("compare-teams-controller",[])
	.controller('CompareTeamsController',['$rootScope','$scope','compareTeams', function($rootScope,$scope,compareTeams) {
		$scope.teamFixtures = compareTeams;
		console.log($scope.fixtures);
		$scope.gwkSlider = $rootScope.gwk-1;
	}]);

})();
(function(){
	angular.module("fixture-pitches-controller",[])
	.controller('FixturePitchesController',function($rootScope,GameweekJsonFactory, $stateParams, $scope, PlayerJsonService){
		if ($scope.players === undefined) {
			$rootScope.loading = true;
			PlayerJsonService.getPlayers()
			.then(
				function (data) {
					if ($stateParams.idA) {
					var home = data[$stateParams.idA];
					var away = data[$stateParams.idB];
					$rootScope.loading = false;
					$scope.playersHome = home;
					$scope.playersAway = away.reverse();
					$scope.homeLength = 100/home.length+'%';
					$scope.awayLength = 100/away.length+'%';
				}
				});
		}

		$scope.pitchHide = function () {
			$rootScope.pitchHidden = true;
		}
	});
})();
(function(){
	angular.module("fixtures-controller",[])
	.controller('FixturesController',['GameweekJsonFactory','$rootScope','$scope','FixtureService', 'FixtureGwkService', '$state',function(GameweekJsonFactory,$rootScope, $scope, FixtureService, FixtureGwkService, $state) {

		$scope.fixtureState = function(a,b,gwk) {
			$rootScope.pitchHidden = false;
			$state.go('app.fix.list.pitch', {
				idA: a,
				idB: b,
				gwk: gwk
			});
		}

		$scope.pitchHide = function () {
			$rootScope.pitchHidden = true;
		}

		GameweekJsonFactory.async().then(function(){
			$scope.$watch('gwk',function(){
				var potato = FixtureGwkService.getGwks($scope.gwk);
				potato[1].then(function(d){
					$scope.fixtures = d.data;
				});

			});
		});

	}]);
})();
(function(){
	angular.module("header-controller",[])
	.controller('HeadCtrl', function($rootScope,$scope,UserService) {
		
		$rootScope.addModal = function () {
			$rootScope.modal=1;
		}

		$scope.loggedIn = UserService.loggedIn;

		$scope.fbLogin = UserService.fbLogin;

		$scope.logout = UserService.logout;
	});

})();
(function(){
	angular.module("live-controller",[])
	.controller('LiveController', function($scope, $firebaseArray, $timeout) {
		var ref = new Firebase("https://glaring-torch-9680.firebaseIO.com/live/16");
		var ref2 = new Firebase("https://glaring-torch-9680.firebaseIO.com/live/11");
		var array1 = $firebaseArray(ref);
		var array2 = $firebaseArray(ref2);

		array1.$loaded().then(function(data) {
			$scope.homeLength = 100/data.length+'%';
			$scope.playersHome=data;
		});

		array2.$loaded().then(function(data) {
			$scope.awayLength = 100/data.length+'%';
			$scope.playersAway= data.reverse();
			console.log(data);
		});


		$scope.count = function(count) {
			var counts = [];
			for (var i = 0; i < count; i++) {
				counts.push(i);
			}
			return counts;
		}

	});
})();