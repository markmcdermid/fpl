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