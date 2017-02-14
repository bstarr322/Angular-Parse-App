define(['jquery', 'app','parse','services/services'], function ($,  app, Parse) {
    return app.run(['$rootScope', '$location', '$window', '$route', 'User', 'Mortage',  function ($rootScope, $location, $window, $route, User, Mortage) {

		var logoutTimoutInMinutes = 10;
		var isLocalStorageImplemented = false;
		
		if(typeof(Storage) !== "undefined") {
			isLocalStorageImplemented = true;
		}

        $rootScope.sessionUser = User.current();
        $rootScope.userHandler = User;
        $rootScope.closeDate = true;

        if($rootScope.sessionUser){
            $rootScope.sessionUser.fetch({
                success: function(user) {
                    $rootScope.sessionUser = user;
                    $rootScope.$apply();
                    // if logged in and localstorage is supported, check their auto logout tracker
					if(isLocalStorageImplemented) {
						if(localStorage['DYOMLoggedTracker'] == null) {
							localStorage['DYOMLoggedTracker'] = new Date().getTime();
						} else {
							var previousActionTime = localStorage['DYOMLoggedTracker'];
							
							var difference = new Date().getTime() - previousActionTime;
							if(difference > (60000 * logoutTimoutInMinutes)) {
								logout();
							} else {
								localStorage['DYOMLoggedTracker'] = new Date().getTime();
							}
						}
					}
                }
            });

            if($rootScope.sessionUser.has('referal')){
                Parse.Cloud.run('getUser', {
                    user: $rootScope.sessionUser.get('referal').id
                }, {
                    success: function(result) {
                        $rootScope.referal = result;
                        $rootScope.$apply();
                    },
                    error: function(error) {}
                });
            }
        }

        $rootScope.$watch("sessionUser", function(val){
            if(val!=null){
            	if(isLocalStorageImplemented){
					if(localStorage['DYOMLoggedTracker'] == null) {
						localStorage['DYOMLoggedTracker'] = new Date().getTime();
					}
				}
                if($rootScope.sessionUser.has('referal')){
                    Parse.Cloud.run('getUser', {
                        user: $rootScope.sessionUser.get('referal').id
                    }, {
                        success: function(result) {
                            $rootScope.referal = result;
                            $rootScope.$apply();
                        },
                        error: function(error) {}
                    });
                }
            } else {
            	localStorage.removeItem('DYOMLoggedTracker');
            }
        });

        $rootScope.togleDrop3 = false;

        $rootScope.processAuth = function(authResult) {
            if(authResult['access_token']) {
                $scope.signedIn = true;
            } else if(authResult['error']) {
                $scope.signedIn = false;
            }
        };

        var logOutEvent = 'logout';
        var logOutArgs = ['arg'];

        $rootScope.$broadcast(logOutEvent, logOutArgs);

        var loginEvents = 'login';
        var loginArgs = ['arg'];


        $rootScope.$broadcast(loginEvents, loginArgs);

        /* MAIN CTRL */
        $rootScope.isThis = function(id){
            return $location.path() == id;
        };
        $rootScope.isThisFirst = function(id){
            var loca = $location.path().split("/");
            return loca[1] == id;
        };
        $rootScope.next = function(val){
            $rootScope.linksIsClicked = true;
            $location.path("/"+val);
        };
        $rootScope.setMortage = function(attribute, value) {
            return Mortage.set(attribute, value);
        };
        $rootScope.getMortage = function(attribute) {
            return Mortage.get(attribute);
        };
        $rootScope.getRate = function(){
            return Mortage.getRate();
        };

        $rootScope.nav = false;
        $rootScope.togleNav = function(){
            $rootScope.nav = !$rootScope.nav;
        };
        $rootScope.isNavActive = function(){
            return $rootScope.nav === true;
        };


        $rootScope.pushSave = false;
        $rootScope.saveAppR = function(){
            $rootScope.pushSave = true;
        };
        $rootScope.autoSaving = false;
        $rootScope.isAppSavingR = function(){
            return $rootScope.autoSaving == true;
        };
        $rootScope.isSave = false;
        $rootScope.isSavedR = function(){
            return $rootScope.isSave === true;
        }

        $rootScope.isHow = false;
        $rootScope.isActiveHow = function(){
            return $rootScope.isHow === true;
        };
        $rootScope.setHow = function(){
            $rootScope.isHow =  !$rootScope.isHow;
        }

        $rootScope.errors = {
            errors: {
                fbLogin : {
                    text: "User don't exist. Register first.",
                    show: false
                },
                fbLoginExist : {
                    text: "User exist. Login and link accounts.",
                    show: false
                },
                updateBasicInfo : {
                    text: "Updated!",
                    show: false
                },
                updatePasswordInfo : {
                    text: "Changed!",
                    show: false
                },
                googleLogin : {
                    text: "User don't exist. Register first.",
                    show: false
                },
                googleLoginExist : {
                    text: "User exist. Login and link accounts.",
                    show: false
                }
            },
            isLive: function(ind){
                return this.errors[ind].show === true;
            },
            get: function(ind){
                return this.errors[ind].text;
            },
            set: function(ind, val){
                this.errors[ind].show = val;
            }
        };

        /* #MAIN CTRL */
        var Rates = Parse.Object.extend("rates");
        var query = new Parse.Query(Rates);
        query.find({
            success: function(objects) {
                for(var i=0; i<objects.length; i++){
                    var obj = objects[i];
                    Mortage.setRebate(obj.get("years"), obj.get("rate"));

                    if(obj.get("years") == 5)
                        Mortage.set("variable", obj.get("variableRate"))
                }
            }
        });

        $rootScope.linksIsClicked = false;

        $rootScope.$on("$routeChangeStart", function (event, next, current) {

           if(next.authenticate){

               if($rootScope.sessionUser){

                   if(next.role){

                       User.checkAccess(next.role).then(function(rsp){
                           if(!rsp)
                               $location.path("/");
                       });

                   }
               }
               else {
                   $location.path("/");
                   $("#login").modal("show");
               }
           }

        });

        $rootScope.isFocoused = false;
        $rootScope.isFocoused2 = false;
        $rootScope.isFocoused3 = false;

        $rootScope.$on("$routeChangeSuccess", function (event, next, current) {
            $('html, body').scrollTop(0);
        });
        
        function logout() {
			Parse.User.logOut();
			$rootScope.sessionUser =  null;
			$rootScope.$emit("logout");
			if(isLocalStorageImplemented){
				localStorage.removeItem['DYOMLoggedTracker'];
			}
			$route.reload();
        }

		var idleTime = 0;

        var idleInterval = setInterval(timerIncrement, 60000);

        $(document).mousemove(function (e) {
            idleTime = 0;
        });
        $(document).keypress(function (e) {
            idleTime = 0;
        });
        
        // when the user leaves, save the time they left
		$window.onbeforeunload = function () {
			if(isLocalStorageImplemented && ($rootScope.sessionUser != null)) {
				localStorage['DYOMLoggedTracker'] = new Date().getTime();
			}
		}; 
        
        // Timing out while the page is open (within one session)
        function timerIncrement() {
            idleTime += 1;
            if (idleTime >= logoutTimoutInMinutes) {
				logout();
            }
        }
        
    }]);
});