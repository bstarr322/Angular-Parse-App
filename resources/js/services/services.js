define(['jquery', 'app', 'bootstrap'], function ($, app) {

// === SERVICES OBJECT
    var factories = {};

    factories.Mortage = ['$q', '$filter', function($q, $filter){
        var factory = {};

        var rebates = {
            "1 Year Term" : {
                "name"      : "1 Year Term",
                "percent"   : 0.35,
                "rate"      : 0.289
            },
            "2 Year Term" :{
                "name"      : "2 Year Term",
                "percent"   : 0.4,
                "rate"      : 0.234
            },
            "3 Year Term" :{
                "name"      : "3 Year Term",
                "percent"   : 0.5,
                "rate"      : 0.269
            },
            "4 Year Term" :{
                "name"      : "4 Year Term",
                "percent"   : 0.5,
                "rate"      : 0.277
            },
            "5 Year Term" :{
                "name"      : "5 Year Term",
                "percent"   : 0.6,
                "rate"      : 0.299
            },
            "7 Year Term" :{
                "name"      : "7 Year Term",
                "percent"   : 0.6,
                "rate"      : 0.379
            },
            "10 Year Term" :{
                "name"      : "10 Year Term",
                "percent"   : 0.65,
                "rate"      : 0.439
            }
        };

        factory.setRebate = function(id, rate){
            rebates[id+" Year Term"].rate = rate;
        };


        var mortage = {
            "amount" : null,
            "rebate" : 0,
            "period" : "5 Year Term",
            "type": "Variable",
            "change": false,
            "variable": 0
        };

        factory.set = function(attribute, value) {
            mortage[attribute] = value;

            if(attribute=="type" && value=="Variable")
                mortage["period"] = "5 Year Term";

            if(attribute=="period" && value!="5 Year Term")
                mortage['type'] = "Fixed";

            mortage.change = true;
            factory.calculate();
        };

        factory.setPeriod = function(attribute, value) {
            mortage[attribute] = value;
            factory.calculate();
        };

        factory.getRate = function(){
            var rate = 0;
            if(typeof mortage.period != "undefined"){
                rate = parseFloat(rebates[mortage.period].rate*10);
                rate = rate.toFixed(10);
                rate =  rate.substring(0, rate.length-8);

            if(mortage.type=="Variable") {
                rate = parseFloat(mortage.variable*10);
                rate = rate.toFixed(10);
                rate =  rate.substring(0, rate.length-8);
            }
            }
            return rate+"%";
        };

        factory.setArray = function(arry){
            for(var i=0; i<arry.length; i++){
                mortage[arry[i][0]] = arry[i][1];
            }
            factory.calculate();
        };

        factory.get = function(attribute){
            if(attribute=="amount") {
                if(mortage[attribute]!=null)
                    return  $filter('noFractionCurrency')(mortage[attribute]);
                else
                    return null;
            }
            else
                return  mortage[attribute];
        };

        factory.calculate = function(){
            if(mortage.amount!=null && typeof mortage.period != "undefined")
                mortage.rebate = (mortage.amount * rebates[mortage.period].percent) / 100;
            else
                mortage.rebate = 0;
        };

        return factory;
    }];
    factories.User = ['$rootScope', '$q', function($rootScope, $q){
        var clientId = '203010354813-t9n1rpb13bglgmga5bjj5app64jn6e59.apps.googleusercontent.com',
            scopes = 'https://www.googleapis.com/auth/userinfo.email',
            apiKey = 'AIzaSyBYBGOobPKECrd_0d34vj7_-5w9wNNCufs',
            defered = $q.defer(),
            domain = 'http://www.doyourownmortgage.com';

        var User = Parse.User.extend(
            {},
            {
                checkAccess: function(roleName){
                    var defer = $q.defer();

                    if(Parse.User.current()){

                        var queryRole = new Parse.Query(Parse.Role);
                        queryRole.equalTo('name', roleName);
                        queryRole.first({
                            success: function(result) {
                                var adminRelation = new Parse.Relation(result, 'users');
                                var queryAdmins = adminRelation.query();

                                queryAdmins.equalTo('objectId', Parse.User.current().id);
                                queryAdmins.first({
                                    success: function(result) {
                                        var rsp = result ? true : false;
                                        defer.resolve(rsp);
                                    }
                                });

                            },
                            error: function(error) {
                                defer.resolve(false);
                            }
                        });

                    }
                    else
                        defer.resolve(false);

                    return defer.promise;
                },
                getName: function(){
                    if(Parse.User.current()){
                        return Parse.User.current().has("firstName") && Parse.User.current().get("firstName").length > 0 ? Parse.User.current().get("firstName") : "User";
                    }
                    else
                        return "User";
                },
                getMyActivity: function(){
                    var defer = $q.defer();
                    if(Parse.User.current()){
                        var _Activity = Parse.Object.extend("Activity");
                        var Query = new Parse.Query(_Activity);
                        Query.equalTo("user", Parse.User.current());
                        Query.descending("createdAt")
                        Query.find({
                            success: function(data) {
                                var activities = [];

                                for(var i=0; i<data.length; i++){
                                    var activity = data[i];
                                    var msg = activity.get("message");
                                    var rgx = activity.get("regex");

                                    for(var b=0; b<rgx.length; b++){
                                        msg = msg.replace(rgx[b].key, rgx[b].text);
                                    }

                                    activities.push({txt: msg, alert: activity.get("alert")});

                                }

                                defer.resolve(activities);
                            },
                            error: function(error){
                                defer.resolve([]);
                            }
                        });
                    }
                    else
                        defer.resolve([]);

                    return defer.promise;
                },
                getMyReferals: function(){
                    var defer = $q.defer();
                    if(Parse.User.current()){
                        var userQuery = new Parse.Query(Parse.User);
                        userQuery.equalTo("referal", Parse.User.current());
                        userQuery.find({
                            success: function(results) {
                                defer.resolve(results);
                            },
                            error: function(error){
                                defer.resolve([]);
                            }
                        });
                    }
                    else
                        defer.resolve([]);

                    return defer.promise;
                },
                getProfileImage: function(){
                    if(Parse.User.current()){

                        if(Parse.User.current().has("profileImg") && Parse.User.current().get("profileImg")!="")
                            return Parse.User.current().get("profileImg").url().replace("http://", "https://s3.amazonaws.com/");
                        else if(Parse.User.current().has("facebookId") && Parse.User.current().get("facebookId").length > 0 && !Parse.User.current().has("profileImg"))
                            return "https://graph.facebook.com/"+Parse.User.current().get("facebookId")+"/picture?width=125&height=125";
                        else
                            return "https://www.doyourownmortgage.com/resources/img/user-placeholder.png";
                    }
                    else
                        return "https://www.doyourownmortgage.com/resources/img/user-placeholder.png";
                },
                logMeOut: function(){
                      Parse.User.logOut();
                      $rootScope.sessionUser =  this.current();
                      $rootScope.$emit("logout");
                },
                forgotPass: function(data){

                    Parse.User.requestPasswordReset(data.email.$viewValue, {
                        success: function() {
                            $rootScope.resetSuccess = true;
                            $rootScope.resetError = false;
                            $rootScope.$apply();
                        },
                        error: function(error) {
                            $rootScope.resetSuccess = false;
                            $rootScope.resetError = true;
                            $rootScope.$apply();
                        }
                    });

                },
                logMein: function(data){

                    Parse.User.logIn(data.email.$viewValue, data.password.$viewValue, {
                        success: function(user) {
                            $rootScope.sessionUser = user;
                            $rootScope.$emit("login");
                            $rootScope.$apply();
                            $("#login").modal("hide");
                        },
                        error: function(user, error) {
                            $rootScope.loginError = error.message;
                            $rootScope.$apply();

                            if (!$("#login .modal-dialog").hasClass("shake")) {
                                $("#login .modal-dialog").addClass("shake");
                            } else {
                                $("#login .modal-dialog").removeClass("shake");
                                setTimeout(function() {
                                    $("#login .modal-dialog").addClass("shake");
                                }, 100);
                            }

                        }
                    });

                },
                checkUniq: function(email){
                    var defer = $q.defer();
                    Parse.Cloud.run('getUserEmail', {
                        email: email
                    }, {
                        success: function(result) {
                           if(typeof result != "undefined")
                                defer.resolve(false);
                           else
                                defer.resolve(true);
                        },
                        error: function(error) {
                            defer.resolve(true);
                        }
                    });

                    return defer.promise;
                },
                registerClean: function(data){

                    var newUser = new User();
                    newUser.set("username", data.email);
                    newUser.set("email", data.email);
                    newUser.set("firstName", data.firstName);
                    newUser.set("lastName", data.lastName);
                    newUser.set("password", data.password);
                    newUser.set("rebates", 0);

                    if(typeof localStorage['dyomReferal'] != "undefined" && localStorage['dyomReferal'] !=""){
                        var userPointer = new Parse.User();
                        userPointer.id = localStorage['dyomReferal'];
                        newUser.set("referal", userPointer);
                        localStorage.removeItem('dyomReferal');
                    }

                    newUser.signUp(null, {
                        success: function(user) {
                            $rootScope.sessionUser = user;
                            $rootScope.$emit("login");
                            $rootScope.$apply();
                        },
                        error: function(user, error) {
                            // alert("Error: " + error.code + " " + error.message);
                        }
                    });
                },
                updateClean: function(data){

                    var user = Parse.User.current();
                    user.set("address", data.uaddress);
                    user.set("address2", data.uaddress2);
                    user.set("postal", data.upostal);
                    user.set("city", data.ucity);
                    user.set("province", data.uprovince);

                    user.save(null, {
                        success: function(user) {
                            $rootScope.sessionUser = user;
                            $rootScope.errors.set("updateBasicInfo", true);
                            $rootScope.$apply();

                            setTimeout(function(){
                                $rootScope.errors.set("updateBasicInfo", false);
                                $rootScope.$apply();
                            }, 4000);

                        },
                        error: function(user, error) {
                        }
                    });
                },
                register: function(data){

                    var newUser = new User();
                    newUser.set("username", data.email.$viewValue);
                    newUser.set("email", data.email.$viewValue);
                    newUser.set("firstName", data.ufname.$viewValue);
                    newUser.set("lastName", data.ulname.$viewValue);
                    newUser.set("password", data.password.$viewValue);
                    newUser.set("newsletter", data.news.$viewValue);
                    newUser.set("rebates", 0);

                    if(typeof localStorage['dyomReferal'] != "undefined" && localStorage['dyomReferal'] !=""){
                            var userPointer = new Parse.User();
                            userPointer.id = localStorage['dyomReferal'];
                            newUser.set("referal", userPointer);
                            localStorage.removeItem('dyomReferal');
                    }

                    newUser.signUp(null, {
                        success: function(user) {
                            $rootScope.sessionUser = user;
                            $rootScope.$emit("login");
                            $rootScope.$apply();
                            $("#register").modal("hide");
                        },
                        error: function(user, error) {
                           // alert("Error: " + error.code + " " + error.message);
                        }
                    });
                },
                update: function(data){

                    var user = Parse.User.current();
                    user.set("firstName", data.ufname.$viewValue);
                    user.set("lastName", data.ulname.$viewValue);
                    user.set("address", data.uaddress.$viewValue);
                    user.set("address2", data.uaddress2.$viewValue);
                    user.set("postal", data.upostal.$viewValue);
                    user.set("city", data.ucity.$viewValue);
                    user.set("province", data.uprovince.$viewValue);



                    user.save(null, {
                        success: function(user) {
                            $rootScope.sessionUser = user;
                            $rootScope.errors.set("updateBasicInfo", true);
                            $rootScope.$apply();

                            setTimeout(function(){
                                $rootScope.errors.set("updateBasicInfo", false);
                                $rootScope.$apply();
                            }, 4000);

                        },
                        error: function(user, error) {
                        }
                    });
                },
                signupFB: function(){
                    FB.getLoginStatus(function(response) {
                        if (response.status === 'connected') {
                            FB.api('/me', function(response) {


                                var query = new Parse.Query(Parse.User);
                                query.equalTo('email', response.email);
                                query.first().then(function(result) {

                                    if(result) {

                                        if(result.get('facebookId') == response.id) {


                                            Parse.FacebookUtils.logIn(null, {
                                                success: function(user) {
                                                    $rootScope.errors.set("fbLogin", false);
                                                    $rootScope.sessionUser = user;
                                                    $rootScope.$emit("login");
                                                    $rootScope.$apply();
                                                    $("#login").modal("hide");
                                                },
                                                error: function(user, error) {
                                                }
                                            });

                                        } else {

                                            $rootScope.errors.set("fbLoginExist", true);
                                            $rootScope.$apply();

                                            setTimeout(function(){
                                                $rootScope.errors.set("fbLoginExist", false);
                                                $rootScope.$apply();
                                            }, 4000);

                                        }

                                    } else {
                                        var user = new User();

                                        user.set("username", response.email);
                                        user.set("email", response.email);
                                        user.set("firstName", response.first_name);
                                        user.set("lastName", response.last_name);
                                        user.set("password", Math.random().toString(36).slice(-8));
                                        user.set("newsletter", true );
                                        user.set("facebookId", response.id );
                                        user.set("rebates", 0);

                                        if(typeof localStorage.dyomReferal != "undefined" && localStorage.dyomReferal !=""){
                                            var userPointer = new Parse.User();
                                            userPointer.id = localStorage.dyomReferal;
                                            user.set("referal", userPointer);
                                            localStorage.removeItem('dyomReferal');
                                        }

                                        user.signUp(null, {}).then(function(user) {
                                            Parse.FacebookUtils.link(user, null, {});
                                            $rootScope.sessionUser = user;
                                            $rootScope.$emit("login");
                                            $rootScope.$apply();
                                            $("#register").modal("hide");
                                        });

                                    }

                                });

                            });

                        } else {
                            FB.login(function(response) {

                                if (response.authResponse) {
                                    // Grab FB users info
                                    FB.api('/me', function(response) {


                                        var query = new Parse.Query(Parse.User);
                                        query.equalTo('email', response.email);
                                        query.first().then(function(result) {

                                            if(result) {

                                                if(result.get('facebookId') == response.id) {


                                                    Parse.FacebookUtils.logIn(null, {
                                                        success: function(user) {
                                                            $rootScope.errors.set("fbLogin", false);
                                                            $rootScope.sessionUser = user;
                                                            $rootScope.$emit("login");
                                                            $rootScope.$apply();
                                                            $("#login").modal("hide");
                                                        },
                                                        error: function(user, error) {
                                                        }
                                                    });

                                                } else {

                                                    $rootScope.errors.set("fbLoginExist", true);
                                                    $rootScope.$apply();

                                                    setTimeout(function(){
                                                        $rootScope.errors.set("fbLoginExist", false);
                                                        $rootScope.$apply();
                                                    }, 4000);

                                                }

                                            } else {
                                                var user = new User();

                                                user.set("username", response.email);
                                                user.set("email", response.email);
                                                user.set("firstName", response.first_name);
                                                user.set("lastName", response.last_name);
                                                user.set("password", Math.random().toString(36).slice(-8));
                                                user.set("newsletter", true );
                                                user.set("facebookId", response.id );
                                                user.set("rebates", 0);

                                                if(typeof localStorage.dyomReferal != "undefined" && localStorage.dyomReferal !=""){
                                                    var userPointer = new Parse.User();
                                                    userPointer.id = localStorage.dyomReferal;
                                                    user.set("referal", userPointer);
                                                    localStorage.removeItem('dyomReferal');
                                                }

                                                user.signUp(null, {}).then(function(user) {
                                                    Parse.FacebookUtils.link(user, null, {});
                                                    $rootScope.sessionUser = user;
                                                    $rootScope.$emit("login");
                                                    $rootScope.$apply();
                                                    $("#register").modal("hide");
                                                });

                                            }

                                        });

                                    });

                                }

                            }, {scope: 'email'});
                        }
                    });

                },
                loginFB: function(){
                    FB.getLoginStatus(function(response) {
                        if (response.status === 'connected') {

                            FB.api('/me', function(response) {


                                var query = new Parse.Query(Parse.User);
                                query.equalTo('facebookId', response.id);
                                query.first().then(function(result) {

                                    if(result) {


                                            Parse.FacebookUtils.logIn(null, {
                                                success: function(user) {
                                                    $rootScope.errors.set("fbLogin", false);
                                                    $rootScope.sessionUser = user;
                                                    $rootScope.$emit("login");
                                                    $rootScope.$apply();
                                                    $("#login").modal("hide");
                                                },
                                                error: function(user, error) {
                                                }
                                            });


                                    } else {

                                        $rootScope.errors.set("fbLogin", true);
                                        $rootScope.$apply();

                                        setTimeout(function(){
                                            $rootScope.errors.set("fbLogin", false);
                                            $rootScope.$apply();
                                        }, 4000);


                                    }

                                });

                            });

                        } else {
                            FB.login(function(response) {

                                if (response.authResponse) {

                                    // Grab FB users info
                                    FB.api('/me', function(response) {


                                        var query = new Parse.Query(Parse.User);
                                        query.equalTo('email', response.email);
                                        query.first().then(function(result) {

                                            if(result) {

                                                if(result.get('facebookId') == response.id) {


                                                    Parse.FacebookUtils.logIn(null, {
                                                        success: function(user) {
                                                            $rootScope.errors.set("fbLogin", false);
                                                            $rootScope.sessionUser = user;
                                                            $rootScope.$emit("login");
                                                            $rootScope.$apply();
                                                            $("#login").modal("hide");
                                                        },
                                                        error: function(user, error) {
                                                        }
                                                    });

                                                } else {

                                                    $rootScope.errors.set("fbLoginExist", true);
                                                    $rootScope.$apply();

                                                    setTimeout(function(){
                                                        $rootScope.errors.set("fbLoginExist", false);
                                                        $rootScope.$apply();
                                                    }, 4000);

                                                }

                                            } else {

                                                $rootScope.errors.set("fbLogin", true);
                                                $rootScope.$apply();

                                                setTimeout(function(){
                                                    $rootScope.errors.set("fbLogin", false);
                                                    $rootScope.$apply();
                                                }, 4000);


                                            }

                                        });

                                    });

                                }

                            }, {scope: 'email'});
                        }
                    });
                },
                linkFB: function(){
                    if (!Parse.FacebookUtils.isLinked(Parse.User.current())) {
                        Parse.FacebookUtils.link(Parse.User.current(), null, {
                            success: function(user) {
                                FB.api('/me', function(response) {
                                    user.set("facebookId", response.id );
                                    user.save(null, {
                                        success: function(user) {
                                            $rootScope.sessionUser = user;
                                            $rootScope.$apply();
                                        },
                                        error: function(user, error) {
                                        }
                                    });
                                });
                            },
                            error: function(user, error) {

                            }
                        });
                    }
                    else {
                        Parse.FacebookUtils.unlink(Parse.User.current(), {
                            success: function(user) {
                                user.unset("facebookId")
                                user.save(null, {
                                    success: function(user) {
                                        $rootScope.sessionUser = user;
                                        $rootScope.$apply();
                                    },
                                    error: function(user, error) {
                                    }
                                });
                            }
                        });
                    }
                },
                saveImg: function(file, name){
                    var defer = $q.defer();

                    var parseFile = new Parse.File(name, file);
                    parseFile.save().then(function(parseFile) {

                            var url = parseFile.url();
                            var user = Parse.User.current();
                            user.set("profileImgLarge", url);
                            user.save(null, {
                                success: function(user) {
                                    $rootScope.sessionUser = user;
                                    $rootScope.$apply();
                                    defer.resolve("true");
                                },
                                error: function(user, error) {
                                }
                            });

                        },
                        function(error) {
                    });

                    return defer.promise;
                },
                changePassword: function(data){
                    var user = Parse.User.current();
                    user.set("password",data.npassword.$viewValue);
                    user.save(null, {
                        success: function(user) {
                            $rootScope.sessionUser = user;
                            $rootScope.errors.set("updatePasswordInfo", true);
                            $rootScope.$apply();

                            setTimeout(function(){
                                $rootScope.errors.set("updatePasswordInfo", false);
                                $rootScope.$apply();
                            }, 4000);

                        },
                        error: function(user, error) {
                        }
                    });
                },
                loginGoogle: function(){
                    gapi.auth.authorize({ client_id: clientId, scope: scopes, immediate: false, hd: domain }, this.handleAuthResultLogin);
                    return defered.promise;
                },
                registerGoogle: function(){
                    gapi.auth.authorize({ client_id: clientId, scope: scopes, immediate: false, hd: domain }, this.handleAuthResultRegister);
                    return defered.promise;
                },
                linkGoogle: function(){
                    var user = Parse.User.current();
                    if(user.has("googleId")){
                        user.unset("googleId");
                        user.save(null, {
                            success: function(user) {
                                var tokenStorage = Parse.Object.extend('TokenStorage');
                                var queryToken = new Parse.Query(tokenStorage);
                                queryToken.equalTo('user', user);
                                queryToken.first().then(function(result) {

                                    result.destroy().then(function(){
                                        $rootScope.sessionUser = user;
                                        $rootScope.$apply();
                                    });

                                });
                            },
                            error: function(user, error) {
                            }
                        });
                    }
                    else {
                        gapi.auth.authorize({ client_id: clientId, scope: scopes, immediate: false, hd: domain }, this.handleAuthResultLink);
                        return defered.promise;
                    }
                },
                handleAuthResultLogin: function(authResult) {
                    if (authResult && !authResult.error) {
                        gapi.client.load('oauth2', 'v2', function () {
                            var request = gapi.client.oauth2.userinfo.get();
                            request.execute(function (resp) {

                                    var query = new Parse.Query(Parse.User);
                                    query.equalTo('email', resp.email);
                                    query.first().then(function(result) {

                                        if(result) {

                                            if(result.get('googleId') == resp.id) {

                                                var tokenStorage = Parse.Object.extend('TokenStorage');
                                                var queryToken = new Parse.Query(tokenStorage);
                                                queryToken.equalTo('user', result);
                                                queryToken.first().then(function(result) {

                                                        Parse.Cloud.run('getUserSessionToken', {
                                                            user: result.get("user").id
                                                        }, {
                                                            success: function(result) {
                                                                Parse.User.become(result).then(function (user) {
                                                                        $rootScope.errors.set("googleLogin", false);
                                                                        $rootScope.sessionUser = user;
                                                                        $rootScope.$emit("login");
                                                                        defered.resolve(true);
                                                                        $rootScope.$apply();
                                                                        $("#login").modal("hide");
                                                                    },
                                                                    function (error) {
                                                                        $rootScope.errors.set("googleLogin", true);
                                                                        defered.resolve(true);
                                                                        $rootScope.$apply();

                                                                        setTimeout(function(){
                                                                            $rootScope.errors.set("googleLogin", false);
                                                                            $rootScope.$apply();
                                                                        }, 4000);
                                                                    });
                                                            },
                                                            error: function(error) {
                                                                $rootScope.errors.set("googleLogin", true);
                                                                defered.resolve(true);
                                                                $rootScope.$apply();

                                                                setTimeout(function(){
                                                                    $rootScope.errors.set("googleLogin", false);
                                                                    $rootScope.$apply();
                                                                }, 4000);
                                                            }
                                                        });


                                                },
                                                function(err){

                                                    $rootScope.errors.set("googleLogin", true);
                                                    defered.resolve(true);
                                                    $rootScope.$apply();

                                                    setTimeout(function(){
                                                        $rootScope.errors.set("googleLogin", false);
                                                        $rootScope.$apply();
                                                    }, 4000);

                                                });

                                            } else {

                                                $rootScope.errors.set("googleLoginExist", true);
                                                defered.resolve(true);
                                                $rootScope.$apply();

                                                setTimeout(function(){
                                                    $rootScope.errors.set("googleLoginExist", false);
                                                    $rootScope.$apply();
                                                }, 4000);

                                            }

                                        } else {

                                            $rootScope.errors.set("googleLogin", true);
                                            defered.resolve(true);
                                            $rootScope.$apply();

                                            setTimeout(function(){
                                                $rootScope.errors.set("googleLogin", false);
                                                $rootScope.$apply();
                                            }, 4000);

                                        }

                                    });
                            });
                        });
                    } else
                        defered.reject('error');
                },
                handleAuthResultLink: function(authResult) {
                    if (authResult && !authResult.error) {
                        gapi.client.load('oauth2', 'v2', function () {
                            var request = gapi.client.oauth2.userinfo.get();
                            request.execute(function (resp) {

                                var tokenStorage = Parse.Object.extend('TokenStorage');
                                var token = new tokenStorage();
                                    token.set("user", Parse.User.current());
                                    token.set("googleId", resp.id);
                                    token.set("token", authResult.access_token);

                                    token.save().then(function(){
                                        var user = Parse.User.current();
                                        user.set("googleId", resp.id);

                                        user.save(null, {
                                            success: function(user) {
                                                $rootScope.sessionUser = user;
                                                $rootScope.$emit("login");
                                                defered.resolve(true);
                                                $rootScope.$apply();
                                            },
                                            error: function(user, error) {
                                            }
                                        });
                                    });


                            });
                        });
                    } else
                        defered.reject('error');
                },
                handleAuthResultRegister: function(authResult) {
                    if (authResult && !authResult.error) {
                        gapi.client.load('oauth2', 'v2', function () {
                            var request = gapi.client.oauth2.userinfo.get();
                            request.execute(function (resp) {

                                var query = new Parse.Query(Parse.User);
                                query.equalTo('email', resp.email);
                                query.first().then(function(result) {

                                    if(result) {

                                        $rootScope.errors.set("googleLoginExist", true);
                                        defered.resolve(true);
                                        $rootScope.$apply();

                                        setTimeout(function(){
                                            $rootScope.errors.set("googleLoginExist", false);
                                            $rootScope.$apply();
                                        }, 4000);


                                    } else {

                                        var user = new User();

                                        user.set("username", resp.email);
                                        user.set("email", resp.email);
                                        var name = resp.name.split(" ");
                                        user.set("firstName", name[0]);
                                        user.set("lastName", name[1]);
                                        user.set("password", Math.random().toString(36).slice(-8));
                                        user.set("newsletter", true );
                                        user.set("googleId", resp.id );
                                        user.set("rebates", 0);

                                        if(typeof localStorage.dyomReferal != "undefined" && localStorage.dyomReferal !=""){
                                            var userPointer = new Parse.User();
                                            userPointer.id = localStorage.dyomReferal;
                                            user.set("referal", userPointer);
                                        }

                                        user.signUp(null, {}).then(function(user) {
                                            var tokenStorage = Parse.Object.extend('TokenStorage');
                                            var token = new tokenStorage();
                                            token.set("user", user);
                                            token.set("googleId", resp.id);
                                            token.set("token", authResult.access_token);

                                            token.save().then(function(){
                                                $rootScope.sessionUser = user;
                                                $rootScope.$emit("login");
                                                $rootScope.$apply();
                                                $("#register").modal("hide");
                                            });


                                        });

                                    }

                                });
                            });
                        });
                    } else
                        defered.reject('error');
                },
                addAdmin: function(data){
                    var defer = $q.defer();
                    Parse.Cloud.run('addToRole', {
                        email: data.adminMail.$viewValue
                    }, {
                        success: function(result) {
                                defer.resolve(result);
                        },
                        error: function(error) {
                            defer.resolve(false);
                        }
                    });
                    return defer.promise;
                }
             }
        );

        handleClientLoad();
        function handleClientLoad () {
            gapi.client.setApiKey(apiKey);
            gapi.auth.init(function () { });
        };


        Object.defineProperty(User.prototype, "email", {
            get: function() {
                return this.get("email");
            },
            set: function(aValue) {
                this.set("email", aValue);
            }
        });
        Object.defineProperty(User.prototype, "firstName", {
            get: function() {
                return this.get("firstName");
            },
            set: function(aValue) {
                this.set("firstName", aValue);
            }
        });
        Object.defineProperty(User.prototype, "lastName", {
            get: function() {
                return this.get("lastName");
            },
            set: function(aValue) {
                this.set("lastName", aValue);
            }
        });
        Object.defineProperty(User.prototype, "newsletter", {
            get: function() {
                return this.get("newsletter");
            },
            set: function(aValue) {
                this.set("newsletter", aValue);
            }
        });
        Object.defineProperty(User.prototype, "address", {
            get: function() {
                return this.get("address");
            },
            set: function(aValue) {
                this.set("address", aValue);
            }
        });
        Object.defineProperty(User.prototype, "address2", {
            get: function() {
                return this.get("address2");
            },
            set: function(aValue) {
                this.set("address2", aValue);
            }
        });
        Object.defineProperty(User.prototype, "city", {
            get: function() {
                return this.get("city");
            },
            set: function(aValue) {
                this.set("city", aValue);
            }
        });
        Object.defineProperty(User.prototype, "postal", {
            get: function() {
                return this.get("postal");
            },
            set: function(aValue) {
                this.set("postal", aValue);
            }
        });
        Object.defineProperty(User.prototype, "province", {
            get: function() {
                return this.get("province");
            },
            set: function(aValue) {
                this.set("province", aValue);
            }
        });

        return User;
    }];
    factories.Application = ['$q', '$rootScope', 'Mortage', function($q, $rootScope, Mortage){
        var _Application = Parse.Object.extend("Applications", {}, {
            getList : function(page, limit, order, searchByFName, searchByNumber, morType, AppDate, ClosingDate) {
                var defer = $q.defer();
                var skip = page*limit;

                var query = new Parse.Query(this);
                    query.limit(limit);
                    query.skip(skip);

                    if(searchByFName!=""){
                        query.contains("searchName", searchByFName.toLowerCase());
                    }

                    if(searchByNumber!=""){
                        query.contains("refId", searchByNumber);
                    }

                    if(morType!=""){
                        query.equalTo("MortageType", morType);
                    }

                    if(ClosingDate!=""){
                        query.equalTo("ClosingDate", ClosingDate);
                    }

                    if(AppDate!=""){
                        var d = AppDate.split("/"),
                            ds = new Date(d[2], parseInt(d[0])-1, d[1], 0, 0),
                            de = new Date(d[2], parseInt(d[0])-1, d[1], 23, 59);

                        query.lessThanOrEqualTo("updatedAt", de);
                        query.greaterThanOrEqualTo("updatedAt", ds);
                    }

                    if(order==1)
                        query.descending("createdAt");
                    else
                        query.ascending("createdAt");

                query.find({
                    success : function(aApplications) {
                        defer.resolve(aApplications);
                        $rootScope.$apply();
                    },
                    error : function(aError) {
                        defer.reject(aError);
                        $rootScope.$apply();
                    }
                });

                return defer.promise;
            },
            count : function(){
                var defer = $q.defer();
                var query = new Parse.Query(this);
                query.count({
                    success : function(count) {
                        defer.resolve(count);
                        $rootScope.$apply();
                    },
                    error : function(aError) {
                        defer.reject(aError);
                        $rootScope.$apply();
                    }
                });

                return defer.promise;
            },
            findById : function(id){
                var defer = $q.defer();

                var query = new Parse.Query(this);

                query.get(id, {
                    success: function(application) {
                        defer.resolve(application);
                        $rootScope.$apply();
                    },
                    error: function(aError) {
                        defer.resolve(count);
                        $rootScope.$apply();
                    }
                });

                return defer.promise;
            },
            findByUser : function(user){
                var defer = $q.defer();

                var query = new Parse.Query(this);
                    query.equalTo("user", user);

                query.first({
                    success: function(application) {
                        defer.resolve(application);
                        $rootScope.$apply();
                    },
                    error: function(aError) {
                        defer.resolve(count);
                        $rootScope.$apply();
                    }
                });

                return defer.promise;
            }
        });

        Object.defineProperty(_Application.prototype, "MortagePurpose", {
            get: function() {
                return this.get("MortagePurpose");
            },
            set: function(aValue) {
                this.set("MortagePurpose", aValue);
            }
        })
        Object.defineProperty(_Application.prototype, "MortageType", {
            get: function() {
                return this.get("MortageType");
            },
            set: function(aValue) {
                this.set("MortageType", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "MortageTerm", {
            get: function() {
                return this.get("MortageTerm");
            },
            set: function(aValue) {
                this.set("MortageTerm", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "MortageRate", {
            get: function() {
                return this.get("MortageRate");
            },
            set: function(aValue) {
                this.set("MortageRate", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "MortageAmortization", {
            get: function() {
                return this.get("MortageAmortization");
            },
            set: function(aValue) {
                this.set("MortageAmortization", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "PurchaseDownPercent", {
            get: function() {
                return this.get("PurchaseDownPercent");
            },
            set: function(aValue) {
                this.set("PurchaseDownPercent", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "PurchasePrice", {
            get: function() {
                return this.get("PurchasePrice");
            },
            set: function(aValue) {
                this.set("PurchasePrice", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "MortagePurchaseDownPayment", {
            get: function() {
                return this.get("MortagePurchaseDownPayment");
            },
            set: function(aValue) {
                this.set("MortagePurchaseDownPayment", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "MortageMLS", {
            get: function() {
                return this.get("MortageMLS");
            },
            set: function(aValue) {
                this.set("MortageMLS", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "MortageMLSNumber", {
            get: function() {
                return this.get("MortageMLSNumber");
            },
            set: function(aValue) {
                this.set("MortageMLSNumber", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "ClosingDate", {
            get: function() {
                return this.get("ClosingDate");
            },
            set: function(aValue) {
                this.set("ClosingDate", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "AppraisedValue", {
            get: function() {
                return this.get("AppraisedValue");
            },
            set: function(aValue) {
                this.set("AppraisedValue", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "ExistingMortageValue", {
            get: function() {
                return this.get("ExistingMortageValue");
            },
            set: function(aValue) {
                this.set("ExistingMortageValue", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "ExistingMortageValueRefinance", {
            get: function() {
                return this.get("ExistingMortageValueRefinance");
            },
            set: function(aValue) {
                this.set("ExistingMortageValueRefinance", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "NewMortageValueRefinance", {
            get: function() {
                return this.get("NewMortageValueRefinance");
            },
            set: function(aValue) {
                this.set("NewMortageValueRefinance", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "MaturityDate", {
            get: function() {
                return this.get("MaturityDate");
            },
            set: function(aValue) {
                this.set("MaturityDate", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "PurchasePriceConstruction", {
            get: function() {
                return this.get("PurchasePriceConstruction");
            },
            set: function(aValue) {
                this.set("PurchasePriceConstruction", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "ApprovedPermits", {
            get: function() {
                return this.get("ApprovedPermits");
            },
            set: function(aValue) {
                this.set("ApprovedPermits", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "ConstructionBudget", {
            get: function() {
                return this.get("ConstructionBudget");
            },
            set: function(aValue) {
                this.set("ConstructionBudget", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "TotalFoundsRequired", {
            get: function() {
                return this.get("TotalFoundsRequired");
            },
            set: function(aValue) {
                this.set("TotalFoundsRequired", aValue);
            }
        });

        Object.defineProperty(_Application.prototype, "Personal1Title", {
            get: function() {
                return this.get("Personal1Title");
            },
            set: function(aValue) {
                this.set("Personal1Title", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal1Fname", {
            get: function() {
                return this.get("Personal1Fname");
            },
            set: function(aValue) {
                this.set("Personal1Fname", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal1Lname", {
            get: function() {
                return this.get("Personal1Lname");
            },
            set: function(aValue) {
                this.set("Personal1Lname", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal1Initial", {
            get: function() {
                return this.get("Personal1Initial");
            },
            set: function(aValue) {
                this.set("Personal1Initial", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal1BirthMonth", {
            get: function() {
                return this.get("Personal1BirthMonth");
            },
            set: function(aValue) {
                this.set("Personal1BirthMonth", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal1BirthDay", {
            get: function() {
                return this.get("Personal1BirthDay");
            },
            set: function(aValue) {
                this.set("Personal1BirthDay", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal1BirthYear", {
            get: function() {
                return this.get("Personal1BirthYear");
            },
            set: function(aValue) {
                this.set("Personal1BirthYear", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal1SIN", {
            get: function() {
                return this.get("Personal1SIN");
            },
            set: function(aValue) {
                this.set("Personal1SIN", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal1HomePhone", {
            get: function() {
                return this.get("Personal1HomePhone");
            },
            set: function(aValue) {
                this.set("Personal1HomePhone", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal1WorkPhone", {
            get: function() {
                return this.get("Personal1WorkPhone");
            },
            set: function(aValue) {
                this.set("Personal1WorkPhone", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal1Email", {
            get: function() {
                return this.get("Personal1Email");
            },
            set: function(aValue) {
                this.set("Personal1Email", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal1Communication", {
            get: function() {
                return this.get("Personal1Communication");
            },
            set: function(aValue) {
                this.set("Personal1Communication", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal1CommunicationTime", {
            get: function() {
                return this.get("Personal1CommunicationTime");
            },
            set: function(aValue) {
                this.set("Personal1CommunicationTime", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal1CommunicationDays", {
            get: function() {
                return this.get("Personal1CommunicationDays");
            },
            set: function(aValue) {
                this.set("Personal1CommunicationDays", aValue);
            }
        });

        Object.defineProperty(_Application.prototype, "Personal1Street1", {
            get: function() {
                return this.get("Personal1Street1");
            },
            set: function(aValue) {
                this.set("Personal1Street1", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal1Street2", {
            get: function() {
                return this.get("Personal1Street2");
            },
            set: function(aValue) {
                this.set("Personal1Street2", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal1City", {
            get: function() {
                return this.get("Personal1City");
            },
            set: function(aValue) {
                this.set("Personal1City", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal1Province", {
            get: function() {
                return this.get("Personal1Province");
            },
            set: function(aValue) {
                this.set("Personal1Province", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal1Postal", {
            get: function() {
                return this.get("Personal1Postal");
            },
            set: function(aValue) {
                this.set("Personal1Postal", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal1ResidentalStatus", {
            get: function() {
                return this.get("Personal1ResidentalStatus");
            },
            set: function(aValue) {
                this.set("Personal1ResidentalStatus", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal1MonthlyRent", {
            get: function() {
                return this.get("Personal1MonthlyRent");
            },
            set: function(aValue) {
                this.set("Personal1MonthlyRent", aValue);
            }
        });

        Object.defineProperty(_Application.prototype, "Personal1CompanyName", {
            get: function() {
                return this.get("Personal1CompanyName");
            },
            set: function(aValue) {
                this.set("Personal1CompanyName", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal1SelfEmployed", {
            get: function() {
                return this.get("Personal1SelfEmployed");
            },
            set: function(aValue) {
                this.set("Personal1SelfEmployed", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal1Income", {
            get: function() {
                return this.get("Personal1Income");
            },
            set: function(aValue) {
                this.set("Personal1Income", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal1IncomeType", {
            get: function() {
                return this.get("Personal1IncomeType");
            },
            set: function(aValue) {
                this.set("Personal1IncomeType", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal1IncomeOther", {
            get: function() {
                return this.get("Personal1IncomeOther");
            },
            set: function(aValue) {
                this.set("Personal1IncomeOther", aValue);
            }
        });

        Object.defineProperty(_Application.prototype, "Personal2Title", {
            get: function() {
                return this.get("Personal2Title");
            },
            set: function(aValue) {
                this.set("Personal2Title", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal2Fname", {
            get: function() {
                return this.get("Personal2Fname");
            },
            set: function(aValue) {
                this.set("Personal2Fname", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal2Lname", {
            get: function() {
                return this.get("Personal2Lname");
            },
            set: function(aValue) {
                this.set("Personal2Lname", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal2BirthMonth", {
            get: function() {
                return this.get("Personal2BirthMonth");
            },
            set: function(aValue) {
                this.set("Personal2BirthMonth", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal2BirthDay", {
            get: function() {
                return this.get("Personal2BirthDay");
            },
            set: function(aValue) {
                this.set("Personal2BirthDay", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal2BirthYear", {
            get: function() {
                return this.get("Personal2BirthYear");
            },
            set: function(aValue) {
                this.set("Personal2BirthYear", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal2SIN", {
            get: function() {
                return this.get("Personal2SIN");
            },
            set: function(aValue) {
                this.set("Personal2SIN", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal2HomePhone", {
            get: function() {
                return this.get("Personal2HomePhone");
            },
            set: function(aValue) {
                this.set("Personal2HomePhone", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal2WorkPhone", {
            get: function() {
                return this.get("Personal2WorkPhone");
            },
            set: function(aValue) {
                this.set("Personal2WorkPhone", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal2Email", {
            get: function() {
                return this.get("Personal2Email");
            },
            set: function(aValue) {
                this.set("Personal2Email", aValue);
            }
        });

        Object.defineProperty(_Application.prototype, "Personal2Street1", {
            get: function() {
                return this.get("Personal2Street1");
            },
            set: function(aValue) {
                this.set("Personal2Street1", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal2Street2", {
            get: function() {
                return this.get("Personal2Street2");
            },
            set: function(aValue) {
                this.set("Personal2Street2", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal2City", {
            get: function() {
                return this.get("Personal2City");
            },
            set: function(aValue) {
                this.set("Personal2City", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal2Province", {
            get: function() {
                return this.get("Personal2Province");
            },
            set: function(aValue) {
                this.set("Personal2Province", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal2Postal", {
            get: function() {
                return this.get("Personal2Postal");
            },
            set: function(aValue) {
                this.set("Personal2Postal", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal2ResidentalStatus", {
            get: function() {
                return this.get("Personal2ResidentalStatus");
            },
            set: function(aValue) {
                this.set("Personal2ResidentalStatus", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal2MonthlyRent", {
            get: function() {
                return this.get("Personal2MonthlyRent");
            },
            set: function(aValue) {
                this.set("Personal2MonthlyRent", aValue);
            }
        });

        Object.defineProperty(_Application.prototype, "Personal2CompanyName", {
            get: function() {
                return this.get("Personal2CompanyName");
            },
            set: function(aValue) {
                this.set("Personal2CompanyName", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal2SelfEmployed", {
            get: function() {
                return this.get("Personal2SelfEmployed");
            },
            set: function(aValue) {
                this.set("Personal2SelfEmployed", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal2Income", {
            get: function() {
                return this.get("Personal2Income");
            },
            set: function(aValue) {
                this.set("Personal2Income", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal2IncomeType", {
            get: function() {
                return this.get("Personal2IncomeType");
            },
            set: function(aValue) {
                this.set("Personal2IncomeType", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal2IncomeOther", {
            get: function() {
                return this.get("Personal2IncomeOther");
            },
            set: function(aValue) {
                this.set("Personal2IncomeOther", aValue);
            }
        });

        Object.defineProperty(_Application.prototype, "PropertyStreet1", {
            get: function() {
                return this.get("PropertyStreet1");
            },
            set: function(aValue) {
                this.set("PropertyStreet1", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "PropertyStreet2", {
            get: function() {
                return this.get("PropertyStreet2");
            },
            set: function(aValue) {
                this.set("PropertyStreet2", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "PropertyCity", {
            get: function() {
                return this.get("PropertyCity");
            },
            set: function(aValue) {
                this.set("PropertyCity", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "PropertyProvince", {
            get: function() {
                return this.get("PropertyProvince");
            },
            set: function(aValue) {
                this.set("PropertyProvince", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "PropertyPostal", {
            get: function() {
                return this.get("PropertyPostal");
            },
            set: function(aValue) {
                this.set("PropertyPostal", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "PropertyType", {
            get: function() {
                return this.get("PropertyType");
            },
            set: function(aValue) {
                this.set("PropertyType", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "PropertyLivingArea", {
            get: function() {
                return this.get("PropertyLivingArea");
            },
            set: function(aValue) {
                this.set("PropertyLivingArea", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "PropertyLivingAreaUnit", {
            get: function() {
                return this.get("PropertyLivingAreaUnit");
            },
            set: function(aValue) {
                this.set("PropertyLivingAreaUnit", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "PropertyDwellingStyle", {
            get: function() {
                return this.get("PropertyDwellingStyle");
            },
            set: function(aValue) {
                this.set("PropertyDwellingStyle", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "PropertyGarageType", {
            get: function() {
                return this.get("PropertyGarageType");
            },
            set: function(aValue) {
                this.set("PropertyGarageType", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "PropertyGarageSize", {
            get: function() {
                return this.get("PropertyGarageSize");
            },
            set: function(aValue) {
                this.set("PropertyGarageSize", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "PropertyOccupiedBy", {
            get: function() {
                return this.get("PropertyOccupiedBy");
            },
            set: function(aValue) {
                this.set("PropertyOccupiedBy", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "PropertyMore", {
            get: function() {
                return this.get("PropertyMore");
            },
            set: function(aValue) {
                this.set("PropertyMore", aValue);
            }
        });

        Object.defineProperty(_Application.prototype, "Liabilities", {
            get: function() {
                return this.get("Liabilities");
            },
            set: function(aValue) {
                this.set("Liabilities", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Assets", {
            get: function() {
                return this.get("Assets");
            },
            set: function(aValue) {
                this.set("Assets", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "RealEstateAgent", {
            get: function() {
                return this.get("RealEstateAgent");
            },
            set: function(aValue) {
                this.set("RealEstateAgent", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "RealEstateOffice", {
            get: function() {
                return this.get("RealEstateOffice");
            },
            set: function(aValue) {
                this.set("RealEstateOffice", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "OtherInfo", {
            get: function() {
                return this.get("OtherInfo");
            },
            set: function(aValue) {
                this.set("OtherInfo", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Application2", {
            get: function() {
                return this.get("Application2");
            },
            set: function(aValue) {
                this.set("Application2", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "submited", {
            get: function() {
                return this.get("submited");
            },
            set: function(aValue) {
                this.set("submited", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "user", {
            get: function() {
                return this.get("user");
            },
            set: function(aValue) {
                this.set("user", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "MortageRateType", {
            get: function() {
                return this.get("MortageRateType");
            },
            set: function(aValue) {
                this.set("MortageRateType", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal1MonthlyMortgagePayment", {
            get: function() {
                return this.get("Personal1MonthlyMortgagePayment");
            },
            set: function(aValue) {
                this.set("Personal1MonthlyMortgagePayment", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Personal1Month2yMortgagePayment", {
            get: function() {
                return this.get("Personal1Month2yMortgagePayment");
            },
            set: function(aValue) {
                this.set("Personal1Month2yMortgagePayment", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "PaymentSchedule", {
            get: function() {
                return this.get("PaymentSchedule");
            },
            set: function(aValue) {
                this.set("PaymentSchedule", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "CashBack", {
            get: function() {
                return this.get("CashBack");
            },
            set: function(aValue) {
                this.set("CashBack", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "ApplicationStatus", {
            get: function() {
                return this.get("ApplicationStatus");
            },
            set: function(aValue) {
                this.set("ApplicationStatus", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "RealEstateAgentEmail", {
            get: function() {
                return this.get("RealEstateAgentEmail");
            },
            set: function(aValue) {
                this.set("RealEstateAgentEmail", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "RealEstateAgentPhone", {
            get: function() {
                return this.get("RealEstateAgentPhone");
            },
            set: function(aValue) {
                this.set("RealEstateAgentPhone", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "Solicitor", {
            get: function() {
                return this.get("Solicitor");
            },
            set: function(aValue) {
                this.set("Solicitor", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "SolicitorPhone", {
            get: function() {
                return this.get("SolicitorPhone");
            },
            set: function(aValue) {
                this.set("SolicitorPhone", aValue);
            }
        });
        Object.defineProperty(_Application.prototype, "SolicitorEmail", {
            get: function() {
                return this.get("SolicitorEmail");
            },
            set: function(aValue) {
                this.set("SolicitorEmail", aValue);
            }
        });

        Object.defineProperty(_Application.prototype, "MortageOwnProperties", {
            get: function() {
                return this.get("MortageOwnProperties");
            },
            set: function(aValue) {
                this.set("MortageOwnProperties", aValue);
            }
        });

        Object.defineProperty(_Application.prototype, "MortageInsurance", {
            get: function() {
                return this.get("MortageInsurance");
            },
            set: function(aValue) {
                this.set("MortageInsurance", aValue);
            }
        });

        Object.defineProperty(_Application.prototype, "Personal2Relationship", {
            get: function() {
                return this.get("Personal2Relationship");
            },
            set: function(aValue) {
                this.set("Personal2Relationship", aValue);
            }
        });

        Object.defineProperty(_Application.prototype, "MortagePurchaseNew", {
            get: function() {
                return this.get("MortagePurchaseNew");
            },
            set: function(aValue) {
                this.set("MortagePurchaseNew", aValue);
            }
        });

        Object.defineProperty(_Application.prototype, "refId", {
            get: function() {
                return this.get("refId");
            },
            set: function(aValue) {
                this.set("refId", aValue);
            }
        });

        Object.defineProperty(_Application.prototype, "IINC", {
            get: function() {
                return this.get("IINC");
            },
            set: function(aValue) {
                this.set("IINC", aValue);
            }
        });


        return _Application;
    }];

// ==== REGISTER SERVICES IN ANGULAJRS APP
    app.factory(factories);

});