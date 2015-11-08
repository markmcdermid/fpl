var app = angular.module("fpl-chat", ["firebase"]);

app.controller("ChatController", function($rootScope, $scope, $firebaseArray) {
	var ref = new Firebase("https://glaring-torch-9680.firebaseIO.com/chat");
	var query = ref.orderByChild("timestamp").limitToLast(25);
	var arr = $firebaseArray(query);
	$scope.messages = arr;
	$scope.glued = true;

	$scope.edit = function(key) {
		if (!$scope.editing) {
			$scope.editing = true;
		} else {
			$scope.editing = !$scope.editing;
		}
		$scope.selected = key;
	}

	$scope.done = function() {
		$scope.editing = false;
	}
	$scope.remove = function(message) {
		$scope.editing = false;
		arr.$remove(message);
	}

	$scope.addMessage = function() {
		if ($rootScope.userDing) {
			$scope.newMsg = {
				text: $scope.newMessageText,
				timestamp: Firebase.ServerValue.TIMESTAMP,
				user: $rootScope.userDing.name,
				imgSrc: $rootScope.userDing.imgSrc,
				uid: $rootScope.userDing.uid,
			}
			console.log($scope.newMsg);	
		} else {
			$scope.newMsg = {
			text: $scope.newMessageText,
			user : 'Guest',
			timestamp: Firebase.ServerValue.TIMESTAMP,
			imgSrc : 'assets/img/guest.png',
			uid: null
		    }
		    console.log($scope.newMsg);
		}
		$scope.messages.$add($scope.newMsg);
		$scope.newMessageText = '';
	};

});