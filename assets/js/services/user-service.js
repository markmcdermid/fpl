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