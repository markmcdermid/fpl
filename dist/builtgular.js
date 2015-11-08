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
	.controller('FixturePitchesController',['$rootScope', 'GameweekJsonFactory', '$stateParams', '$scope', 'PlayerJsonService',function($rootScope,GameweekJsonFactory, $stateParams, $scope, PlayerJsonService){
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
	}]);
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
	.controller('HeadCtrl', ['$rootScope','$scope','UserService',function($rootScope,$scope,UserService) {
		
		$rootScope.addModal = function () {
			$rootScope.modal=1;
		}

		$scope.loggedIn = UserService.loggedIn;

		$scope.fbLogin = UserService.fbLogin;

		$scope.logout = UserService.logout;
	}]);

})();
(function(){
	angular.module("live-controller",[])
	.controller('LiveController', ['$scope','$firebaseArray',function($scope, $firebaseArray) {
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

	}]);
})();
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
(function(){
	angular.module("enter-submit-directive",[]).
	directive('enterSubmit', function () {
    return {
      restrict: 'A',
      link: function (scope, elem, attrs) {
       
        elem.bind('keydown', function(event) {
          var code = event.keyCode || event.which;
                  
          if (code === 13) {
            if (!event.shiftKey) {
              event.preventDefault();
              scope.$apply(attrs.enterSubmit);
            }
          }
        });
      }
    }
  });

})();
(function(){
	angular.module("gameweek-directive",[])
	.directive('gameweek', function() {
		return {
			restrict: 'E',
			templateUrl: 'templates/gameweek.html',
			controller: ['$scope','$rootScope','GameweekJsonFactory',function($scope, $rootScope, GameweekJsonFactory){
				$scope.nextGwk = function() {
					GameweekJsonFactory.nextGwk();
				}
				$scope.previousGwk = function() {
					GameweekJsonFactory.previousGwk();
				}
			}],
			controllerAs: 'gameweek',
		};
	});
})();
(function(){
	angular.module("live-player-container-directive",[]).
	directive('livePlayerContainer', function() {
		return {
			restrict: 'E',
			templateUrl: 'templates/live-player-container.html',
			controller: ['$scope',function($scope){
				$scope.width = 100/$scope.line.length+'%';
			}], 
			controllerAs: 'pitch',
		};
	});

})();
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
(function(){
	angular.module("pitches-directive",[]).
		directive('pitches', function() {
		return {
			restrict: 'E',
			templateUrl: 'templates/pitches.html',

		};
	});
})();
(function(){
	angular.module("player-container-directive",[]).
	directive('playerContainer', function() {
		return {
			restrict: 'E',
			templateUrl: 'templates/player-container.html',
			controller: function($scope){
				$scope.width = 100/$scope.line.length+'%';
			}, 
			controllerAs: 'pitch',
		};
	});

})();
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
(function(){
	angular.module("compare-teams-service",[])
	.factory('CompareTeamsService', ['$rootScope','$http',function($rootScope,$http){

		return {
			getTeamFix:function() {
				$rootScope.loading = true;
				return $http.get('jsons/fixturesall.json').then(function(d){
					$rootScope.loading = false;
					return d.data;
				});
			}
		}
}]);
})();
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
(function(){
	angular.module("fixture-gameweek-service",[]).
	factory('FixtureGwkService', ['$rootScope','GameweekJsonFactory','$http',function($rootScope, GameweekJsonFactory,$http){
		return service = {
			getGwk: function(gwk){
				promise = $http.get('jsons/fixtures/fixtures06.json');
				return promise;
			},
			getGwks: function(gwk) {
				d= [gwk-1,gwk,gwk+1];
				var d = d.map(function(i) {
					i = (i<10) ? "0"+i : i;
					return i;
				})

				promises = d.map(function(i){
					return $http({
						url   : 'jsons/fixtures/fixtures'+i+'.json',
						method: 'GET',
					});
					return response.data
				});
				return promises;
			}
		}
	}]);
})();
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
	(function(){
		angular.module('user-service',[]).
		factory('UserService',['$rootScope',function($rootScope){
			var sdo = {
				fbLogin: function() {
					var sdo = this;
					var ref = new Firebase("https://glaring-torch-9680.firebaseIO.com/chat");
					ref.authWithOAuthPopup("facebook",function(error,authData) {
						if (error) {
							console.log ("Login Failed!", error);
						} else {
							console.log("Authenticated successfully with payload:", authData);
							$rootScope.$broadcast('auth-event-success');
						}
					},{
						scope: "email"
					});
				},
				getUserInfo: function() {
					// Create a callback which logs the current auth state
					// Register the callback to be fired every time auth state changes
					var ref = new Firebase("https://glaring-torch-9680.firebaseIO.com/chat");
					ref.onAuth(this.authDataCallback);
				},

				authDataCallback: function(authData) {
					if (authData) {
						console.log("User " + authData.uid + " is logged in with " + authData.provider);
						if (authData.facebook){
							var user = {};
							var fbAuth = authData.facebook;
							user.name = fbAuth.displayName.split(' ')[0];
							user.email= fbAuth.email;
							user.imgSrc= fbAuth.profileImageURL;
							user.uid = authData.uid;
							$rootScope.userDing = user;
						}
					} else {
						console.log("User is logged out");
						$rootScope.userDing = undefined;
						console.log($rootScope.userDing);
					}
				},
				logout: function() {
					var ref = new Firebase("https://glaring-torch-9680.firebaseIO.com/chat");
					ref.unauth();
					$rootScope.userDing = undefined;
				}

			}
			return sdo;
		}]);
})();