(function(){
	"use strict";
	var app = angular.module('fpl', [

		'angular.filter',
		'ui.router',
		'fpl-chat',
		'rzModule',

		'compare-teams-controller',
		'fixtures-controller',
		'fixture-pitches-controller',
		'header-controller',
		'live-controller',

		'fixture-service',
		'fixture-gameweek-service',
		'compare-teams-service',
		'player-json-service',
		'fixture-difficulty-service',
		'gameweek-json-service',
		'user-service',
		
		'gameweek-directive',
		'wrap-directive',
		'modal-directive',
		'pitches-directive',
		'player-container-directive',
		'live-player-container-directive',
		'animation-directive',
		'enter-submit-directive',

		'luegg.directives',
		]);

	app.run(['$rootScope', 'GameweekJsonFactory','UserService', function($rootScope,GameweekJsonFactory,UserService) {
		UserService.getUserInfo();
		GameweekJsonFactory.async();
		$rootScope.$on('auth-event-success',function(){
			$rootScope.$digest();
		});
	}])

	app.config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider) {
		$urlRouterProvider.otherwise('/');
		$stateProvider
		.state('app',{
			url: '/',
			views: {
				'header': {
					templateUrl: 'templates/partials/header.html',
					controller: 'HeadCtrl'
				},
				'content': {
					templateUrl: 'templates/partials/content.html'
				},
				'footer': {
					templateUrl: 'templates/partials/footer.html'
				}
			}
		})
		.state('app.compareteams', {
			url: 'compare-teams',
			views: {
				'content@': {
					templateUrl: 'templates/compare-teams.html',
					controller: 'CompareTeamsController',
					controllerAs: 'compTeam',
				}
			},
			resolve: {
				compareTeams: function(CompareTeamsService) {
					return CompareTeamsService.getTeamFix();
				}
			}
		})
		.state('app.compare', {
			url: 'live',
			views: {
				'content@': {
					templateUrl: 'templates/fixture-pitches.html',
					controller: 'LiveController',

				}
			},
		})
		.state('app.chat', {
			url: 'chat',
			views: {
				'content@': {
					templateUrl: 'templates/chat.html',
					controller:'ChatController',
				}
			},
		})
		.state('app.fix', {
			views: {
				'content@': {
					templateUrl: 'templates/fixtures.html'
				}
			},
		})
		.state('app.fix.list', {
			url:'fixtures',
			views: {
				'columnone@app.fix': {
					templateUrl: 'templates/fixture-list.html',
					controller: 'FixturesController',
					controllerAs: 'fixture'
				}
			},
		})
		.state('app.fix.list.pitch', {
			url: '/{gwk}/{idA}vs{idB}',
			views: {
				'columntwo@app.fix': {
					templateUrl: 'templates/fixture-pitches.html',
					controller: 'FixturePitchesController',
				}
			}
		})
	}]);

})();