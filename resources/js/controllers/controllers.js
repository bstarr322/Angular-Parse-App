var adminEmailAddress = "info@doyourownmortgage.com";

define(['jquery', 'app', 'parse', 'bootstrap'], function ($, app, Parse) {

// === CONTROLLERS OBJECT
var controllers = {};
	controllers.DebugCtrl = ["$rootScope", "$scope",  function($rootScope, $scope){
    	$scope.application = {};
        $scope.assets = {};
        $scope.liabilities = {};
        $scope.loadingA = false;
        $scope.saved = false;
        $scope.isSaved = function(){
            return $scope.saved === true;
        };
        $scope.isLoaded = function(){
            return $scope.loadingA === true;
        };
        $scope.createAdmin = function(data){
			Parse.Cloud.run('addToRole', {
				email: data.email.$modelValue
			}, {
				success: function(result) {
						
				},
				error: function(error) {

				}
			});
        };
    }];
    controllers.LandingCtrl = ['$rootScope', '$scope', '$location', 'Mortage',  function($rootScope, $scope, $location, Mortage){

        $scope.finished = false;
        $scope.isFinished = function(){
            return $scope.finished == true;
        }

        $scope.amount =  Mortage.get("amount");

        $scope.$watch('amount', function(val) {
            if(val != "" && val != null){
                val = val.replace(/\$|,/g,'');

                if(val == "")
                    val = 0;

                Mortage.set("amount", parseFloat(val));
            }
        });

        init();
        function init(){

            var loc = $location.path().split("/");

            if(loc[1] == "r" && typeof loc[2] != "undefined" && loc[2] != "")
                localStorage.dyomReferal = loc[2];
        }

    }];
    controllers.DashboardCtrl = ["$rootScope", "$scope", '$routeParams', 'Application', 'User',  function($rootScope, $scope, $routeParams, Application, User){

        $scope.activityLimit = 5;
        $scope.increaseActivityLimit = function(){
            $scope.activityLimit =  $scope.activityLimit + 5;
        };

        $scope.referallsLimit = 3;
        $scope.increaseReferallsLimit = function(){
            $scope.referallsLimit =  $scope.referallsLimit + 3;
        };

        $scope.page = {
            active: "",
            isActive: function(ind){
                return this.active === ind;
            }
        };
        $rootScope.$on("logout", function(val){
            $rootScope.next("");
        });
        $scope.fileModel = null;
        $scope.uploadFile = function() {
            var filesUpload = $("#profileImg")[0];
            if (filesUpload.files.length > 0) {
                var fileSize = filesUpload.files[0].size;
                if(fileSize>4000000){
                    alert('Please select smaller img.');
                }else{
                    $scope.fileUploading = true;
                    var file = filesUpload.files[0];
                    var name = $rootScope.sessionUser.id+".png";

                    User.saveImg(file, name).then(function(){
                        $scope.fileUploading = false;
                    });
                }
            }
        };
        $scope.fileUploading = false;
        $scope.isFileUploading = function(){
            return $scope.fileUploading === true;
        }
        $scope.UserApplication = null;
        $scope.referalApplication = null;
        $scope.editMyApplication = function(){
                $scope.UserApplication.set("ApplicationStatus", 0);
                $scope.UserApplication.set("submited", false);
                $scope.UserApplication.save(null, {
                    success: function(rsp) {
                        $scope.$apply(function(){
                            $rootScope.next("apply-now");
                        });
                    },
                    error: function(rsp, error) { }
                });
        };
        $scope.rSending = false;
        $scope.isRSendign = function(){
            return $scope.rSending === true;
        };
        $scope.sendRefferal = function(data){
                var email = data.remail.$viewValue;
                $scope.rSending = true;
                Application.findByUser($rootScope.sessionUser).then(function(data){
                    var cashback = 0;
                    if(data.has("CashBack"))
                        cashback = data.get("CashBack");
                    Parse.Cloud.run('sendMailReferral', {
                        email: email,
                        pimg: User.getProfileImage(),
                        name: User.getName(),
                        cashback: cashback,
                        uid: $rootScope.sessionUser.id
                    }, {
                        success: function(result) {
                            $scope.rSending = false;
                            $scope.remail = "";
                            $scope.$apply();
                        },
                        error: function(error) {
                            $scope.rSending = false;
                            $scope.$apply();
                        }
                    });
                });
        };

        $scope.publishOnFb = function(){
            if($rootScope.sessionUser!=null) {
            FB.ui({
                method: 'share',
                href: 'https://www.doyourownmortgage.com/r/' + $rootScope.sessionUser.id
            }, function(response){});
            }
        };

        $scope.publishOnTwitter = function(){
           var url = "";

           if($rootScope.sessionUser!=null)
            url = "https://twitter.com/intent/tweet?text="+encodeURIComponent("Join me on DYOM and get cashback!")+"&url="+encodeURIComponent('https://www.doyourownmortgage.com/r/' + $rootScope.sessionUser.id);

           return url;
        };
        
        $scope.publishOnLn = function(){
           var url = "";

           if($rootScope.sessionUser!=null)
		   url = "https://www.linkedin.com/shareArticle?mini=true&title="+encodeURIComponent("Do Your Own Mortgage")+"&summary="+encodeURIComponent("Join me on DYOM and get cashback!")+"&source=doyourownmortgage.com&url="+encodeURIComponent('https://www.doyourownmortgage.com/r/'+$rootScope.sessionUser.id);
           return url;
        };

        $scope.userReferals = [];
        $scope.referall = null;
        $scope.activity = [];
        $scope.admins = [];
        $scope.removeAdmin = function(ind){
            Parse.Cloud.run('removeAdmin', {
                user: $scope.admins[ind].id
            }, {
                success: function(result) {
                    $scope.admins.splice(ind, 1);
                    $scope.$apply();
                },
                error: function(error) {
                }
            });
        };
        $scope.addAdmin = function(data){
            User.addAdmin(data).then(function(data){
                $scope.admins.push(data);
            });
        };

        $scope.applications = [];
        $scope.listOffset = 0;
        $scope.listLimit = 5;
        $scope.count = 0;
        $scope.load = false;
        $scope.listOrder = 1;
        $scope.searchByFName = "";
        $scope.searchByNumber = "";
        $scope.searchByMortype = "";
        $scope.searchByApplicationDate = "";
        $scope.searchByClosingDate = "";

        $scope.$watch("searchByFName", function(){
            $scope.listOffset = 0;
            $scope.getList();
        });

        $scope.$watch("searchByNumber", function(){
            $scope.listOffset = 0;
            $scope.getList();
        });

        $scope.$watch("searchByMortype", function(){
            $scope.listOffset = 0;
            $scope.getList();
        });

        $scope.$watch("searchByApplicationDate", function(){
            $scope.listOffset = 0;
            $scope.getList();
        });

        $scope.$watch("searchByClosingDate", function(){
            $scope.listOffset = 0;
            $scope.getList();
        });

        $scope.isload = function(){
            return $scope.load == true;
        };
        $scope.removeApplication = function ($index) {
        	var areYouSure = confirm("Are you sure you want to delete this application?");
        	if(areYouSure) {
            	$scope.applications.splice($index, 1);
            }
        };
        $scope.counting = function(){
            Application.count().then(function(count) {
                $scope.count = count;
            });
        };
        $scope.getList = function(){
            $scope.load = true;
            Application.getList($scope.listOffset, $scope.listLimit, $scope.listOrder, $scope.searchByFName, $scope.searchByNumber, $scope.searchByMortype, $scope.searchByApplicationDate, $scope.searchByClosingDate).then(function(aApplications) {
                $scope.applications = aApplications;
                $scope.load = false;
            });
        };
        $scope.isPagination = function(){
            return $scope.count > $scope.listLimit;
        };
        $scope.increaseOffset = function(){
            $scope.listOffset = $scope.listOffset+1;
        };
        $scope.decreaseOffset = function(){
            $scope.listOffset = $scope.listOffset-1;
        };
        $scope.numPages = function () {
            $scope.pages =  Math.ceil($scope.count / $scope.listLimit);
            return new Array($scope.pages );
        };
        $scope.setOffset = function(i){
            $scope.listOffset = i;
        };

        $scope.setNew = function(val, id){
          $scope[id] = val;
        };

        $scope.$watch("listOrder", function(){
            $scope.listOffset = 0;
            $scope.getList();
        });

        $scope.$watch("listLimit", function(){
            $scope.listOffset = 0;
            $scope.getList();
        });
        $scope.$watch("listOffset", function(){
            $scope.getList();
        });

        init();
        function init(){

            if($routeParams.id)
               $scope.page.active = $routeParams.id;
            else
                $scope.page.active = "main";

            if(!$routeParams.id){
                User.getMyActivity().then(function(data){
                    $scope.activity = data;
                });
            }

            if($routeParams.id && $routeParams.id == "edit-profile"){
                $scope.ufname = $rootScope.sessionUser.get("firstName");
                $scope.ulname = $rootScope.sessionUser.get("lastName");
                $scope.uaddress = $rootScope.sessionUser.get("address");
                $scope.uaddress2 = $rootScope.sessionUser.get("address2");
                $scope.upostal = $rootScope.sessionUser.get("postal");
                $scope.ucity = $rootScope.sessionUser.get("city");
                $scope.uprovince = $rootScope.sessionUser.get("province");
            }

            if($scope.UserApplication == null) {
                Application.findByUser($rootScope.sessionUser).then(function(data){
                    $scope.UserApplication = data;
                });
            }

            if($routeParams.id && $routeParams.secId && $routeParams.id == "my-referal-status" && $routeParams.secId != "") {
                Parse.Cloud.run('getUser', {
                    user: $routeParams.secId
                }, {
                    success: function(result) {
                        $scope.referall = result;
                        Application.findByUser(result).then(function(data){
                            $scope.referalApplication = data;
                        });
                    },
                    error: function(error) {
                        $rootScope.next("dashboard");
                    }
                });
            }

            if($routeParams.id && $routeParams.id == "manage-admins") {
                $rootScope.userHandler.checkAccess("Administrator").then(function(rsp){
                    if(!rsp)
                        $rootScope.next("dashboard");
                    else {
                        Parse.Cloud.run('getAdmins', {}, {
                            success: function(result) {
                                $scope.admins = result;
                                $scope.$apply();
                            },
                            error: function(error) {}
                        });
                    }

                });
            }

            if($routeParams.id && $routeParams.id == "manage-applications") {
                $rootScope.userHandler.checkAccess("Administrator").then(function(rsp){
                    if(!rsp)
                        $rootScope.next("dashboard");
                    else {
                        $scope.counting();
                        $scope.getList();
                    }

                });
            }

            User.getMyReferals().then(function(result){
                $scope.userReferals = result;
            });
        }

    }];
    controllers.AdminCtrl = ['$rootScope', '$scope', '$routeParams', 'Application',  function($rootScope, $scope, $routeParams, Application){
        $scope.application = {};
        $scope.assets = {};
        $scope.liabilities = {};
        $scope.loadingA = false;
        $scope.saved = false;
        $scope.isSaved = function(){
            return $scope.saved === true;
        };
        $scope.isLoaded = function(){
            return $scope.loadingA === true;
        };
        $scope.saveApplication = function(){
                $scope.loadingA = true;
                $scope.saved = false;
                $scope.application.set("ApplicationStatus", parseInt( $scope.application.get("ApplicationStatus") ) );
                $scope.application.save(null,{
                    success : function(data){

                        $scope.$apply(function(){
                            $scope.loadingA = false;
                            $scope.saved = true;
                            $scope.application = data;
                        });
                    },
                    error: function(error){
                    }
                });
        };

        init();
        function init(){

            if(typeof $routeParams.id != "undefined" && $routeParams.id!="") {
                Application.findById($routeParams.id).then(function(aApplications) {
                    $scope.application = aApplications;
                    if(aApplications.has('Assets'))
                        $scope.assets = JSON.parse(aApplications.get('Assets'));
                    if(aApplications.has('Liabilities'))
                        $scope.liabilities = JSON.parse(aApplications.get('Liabilities'));
                });
            }
            else
                $rootScope.next("dashboard/manage-applications");
        }

    }];
    controllers.ApplicationCtrl = ['$rootScope', '$scope', '$location', '$timeout', '$filter', 'Application', 'Mortage', 'User', '$analytics',
        function($rootScope, $scope, $location, $timeout, $filter, Application, Mortage, User, $analytics){
        $scope.apassword = "";
        $scope.arpassword = "";
        $scope.rSending = false;
        $scope.isRSendign = function(){
            return $scope.rSending === true;
        };
        $scope.sendRefferal = function(data){
            var email = data.remail.$viewValue;
            $scope.rSending = true;
            Application.findByUser($rootScope.sessionUser).then(function(data){
                var cashback = 0;
                if(data.has("CashBack"))
                    cashback = data.get("CashBack");
                Parse.Cloud.run('sendMailReferral', {
                    email: email,
                    pimg: User.getProfileImage(),
                    name: User.getName(),
                    cashback: cashback,
                    uid: $rootScope.sessionUser.id
                }, {
                    success: function(result) {
                        $scope.rSending = false;
                        $scope.remail = "";
                        $scope.$apply();
                    },
                    error: function(error) {
                        $scope.rSending = false;
                        $scope.$apply();
                    }
                });
            });
        };
        $scope.publishOnFb = function(){
            if($rootScope.sessionUser!=null) {
                FB.ui({
                    method: 'send',
                    link: 'https://www.doyourownmortgage.com/r/' + $rootScope.sessionUser.id
                });
            }
        };
        $scope.publishOnTwitter = function(){
            var url = "";

            if($rootScope.sessionUser!=null)
                url = "https://twitter.com/intent/tweet?text="+encodeURIComponent("Join me on DYOM and get cashback!")+"&url="+encodeURIComponent('http://www.doyourownmortgage.com/r/' + $rootScope.sessionUser.id);

            return url;
        };
        $scope.liabilitiesVals = {
            "debts" : [
                {
                    where: "",
                    description: "",
                    balance: ""
                }
            ],
            "creditCards": [
                {
                    where: "",
                    description: "",
                    balance: ""
                }
            ],
            "owingautomobile":[
                {
                    where: "",
                    description: "",
                    balance: ""
                }
            ],
            "mortages":[
                {
                    where: "",
                    description: "",
                    balance: ""
                }
            ],
            "financeCompany":[
                {
                    where: "",
                    description: "",
                    balance: ""
                }
            ],
            "alimonyChild":[
                {
                    where: "",
                    description: "",
                    balance: ""
                }
            ]
        };
        $scope.assetsVals = {
            "cash" : [
                {
                    where: "",
                    description: "",
                    val: ""
                }
            ],
            "gifts" : [
                {
                    where: "",
                    description: "",
                    val: ""
                }
            ],
            "equity" : [
                {
                    where: "",
                    description: "",
                    val: ""
                }
            ],
            "deposit" : [
                {
                    where: "",
                    description: "",
                    val: ""
                }
            ],
            "automobile" : [
                {
                    where: "",
                    description: "",
                    val: ""
                }
            ],
            "valueHome" : [
                {
                    where: "",
                    description: "",
                    val: ""
                }
            ],
            "stocks" : [
                {
                    where: "",
                    description: "",
                    val: ""
                }
            ],
            "rrsp": [
                {
                    where: "",
                    description: "",
                    val: ""
                }
            ],
            "otherAssets" : [
                {
                    where: "",
                    description: "",
                    val: ""
                }
            ]
        };
        $scope.assets = [];

        $rootScope.$on("logout", function(val){
            $rootScope.next("");
        });

        $scope.Application = new Application();
        $scope.Application.ApplicationStatus = 0;
        $scope.AppReady = false;
        $scope.appStep = 0;
        $scope.steps = {
            1 : false,
            2 : false,
            3:  false,
            4:  false,
            5:  false,
            6:  false,
            7:  false,
            8:  false
        };

        if($rootScope.sessionUser){

            Application.findByUser($rootScope.sessionUser).then(
                function(App){
                    if(App) {
                        // User already has an APP
                        $scope.Application = App;

                        if(App.get("ApplicationStatus") > 0 && App.get("submited")== true)
                            $rootScope.next("dashboard/my-application-status");
                        else {
                            if(App.has("AppStep")) {
                                for(var i=0; i<=App.get("AppStep"); i++){
                                    $scope.steps[i] = true;
                                    $scope.setStep(i);
                                }
                            }
                        }


                        if(Mortage.get("change")==true && Mortage.get("amount")!=null){
                            $scope.Application.MortageTerm =  Mortage.get("period");
                            $scope.Application.MortageType = Mortage.get("type");
                            $scope.Application.PurchasePrice = Mortage.get("amount");
                            $scope.Application.NewMortageValueRefinance =  Mortage.get("amount");
                            $scope.Application.ExistingMortageValue =  Mortage.get("amount");
                            $scope.Application.TotalFoundsRequired =  Mortage.get("amount");
                        }
                        else {
                            Mortage.setArray([
                                ["period",  App.get("MortageTerm")],
                                ["type",  App.get("MortageType")],
                                ["amount",  App.get("PurchasePrice")]
                            ]);
                        }

                        if(!App.has("Personal1Email"))
                            $scope.Application.Personal1Email = $scope.sessionUser.get("email");

                        if(App.has("Assets")){
                            var _Assets = JSON.parse(App.Assets);
                            for (var key in _Assets) {
                                $scope.assetsVals[key] = _Assets[key];
                                if(_Assets[key][0].val!="")
                                    $scope.assets.push( sub[key]);
                            }
                        }

                        $scope.calculateMonthlyPayment();
                        $scope.AppReady = true;
                        setTimeout(function(){ saveApp() },  40000);
                    }
                    else {
                        var List = Parse.Object.extend("List");
                        var list = new List();
                        list.save(null, {
                            success: function(rsp) {
                                $scope.Application.set("list", rsp.id)
                            }
                        });
                        $scope.Application.set("user", $rootScope.sessionUser);
                        $scope.Application.MortagePaymentAmount = 0;
                        $scope.Application.PaymentSchedule = "Monthly";
                        $scope.Application.MortageRate = Mortage.getRate();
                        $scope.Application.MortageTerm =  Mortage.get("period");
                        $scope.Application.MortageType = Mortage.get("type");

                        if(Mortage.get("amount")!=0){
                            $scope.Application.CashBack = Mortage.get('rebate');
                            $scope.Application.PurchasePrice = Mortage.get("amount");
                            $scope.Application.NewMortageValueRefinance =  Mortage.get("amount");
                            $scope.Application.ExistingMortageValue =  Mortage.get("amount");
                            $scope.Application.TotalFoundsRequired =  Mortage.get("amount");
                        }

                        $scope.AppReady = true;
                        setTimeout(function(){ saveApp() },  40000);
                    }
                },
                function(error){
                    var List = Parse.Object.extend("List");
                    var list = new List();
                    list.save(null, {
                        success: function(rsp) {
                            $scope.Application.set("list", rsp.id)
                        }
                    });
                    $scope.Application.set("user", $rootScope.sessionUser);
                    $scope.Application.MortagePaymentAmount = 0;
                    $scope.Application.PaymentSchedule = "Monthly";
                    $scope.Application.MortageRate = Mortage.getRate();
                    $scope.Application.MortageTerm =  Mortage.get("period");
                    $scope.Application.MortageType = Mortage.get("type");

                    if(Mortage.get("amount")!=0){
                        $scope.Application.CashBack = Mortage.get('rebate');
                        $scope.Application.PurchasePrice = Mortage.get("amount");
                        $scope.Application.NewMortageValueRefinance =  Mortage.get("amount");
                        $scope.Application.ExistingMortageValue =  Mortage.get("amount");
                        $scope.Application.TotalFoundsRequired =  Mortage.get("amount");
                    }
                    $scope.AppReady = true;
                    setTimeout(function(){ saveApp() },  40000);
                }
            );
        }
        else {

            $scope.Application.MortagePaymentAmount = 0;
            $scope.Application.PaymentSchedule = "Monthly";
            $scope.Application.MortageRate = Mortage.getRate();
            $scope.Application.MortageTerm =  Mortage.get("period");
            $scope.Application.MortageType = Mortage.get("type");

            if(Mortage.get("amount")!=0){
                $scope.Application.CashBack = Mortage.get('rebate');
                $scope.Application.PurchasePrice = Mortage.get("amount");
                $scope.Application.NewMortageValueRefinance =  Mortage.get("amount");
                $scope.Application.ExistingMortageValue =  Mortage.get("amount");
                $scope.Application.TotalFoundsRequired =  Mortage.get("amount");
            }

            $scope.AppReady = true;

            $rootScope.$watch("sessionUser", function(val){

                if(val!=null){

                    Application.findByUser(val).then(
                        function(App){
                            if(App) {
                                $scope.Application = App;

                                if(App.get("ApplicationStatus") > 0 && App.get("submited")== true)
                                    $rootScope.next("dashboard/my-application-status");
                                else {
                                    if(App.has("AppStep")) {
                                        for(var i=0; i<=App.get("AppStep"); i++){
                                            $scope.steps[i] = true;
                                            $scope.setStep(i);
                                        }
                                    }
                                }

                                        if(Mortage.get("change")==true && Mortage.get("amount")!=null){
                                            $scope.Application.MortageRate = Mortage.getRate();

                                            $scope.Application.MortageTerm =  Mortage.get("period");

                                            $scope.Application.MortageType = Mortage.get("type");

                                            $scope.Application.PurchasePrice = Mortage.get("amount");
                                            $scope.Application.NewMortageValueRefinance =  Mortage.get("amount");
                                            $scope.Application.ExistingMortageValue =  Mortage.get("amount");
                                            $scope.Application.TotalFoundsRequired =  Mortage.get("amount");

                                        }
                                        else {
                                            Mortage.setArray([
                                                ["period",  App.get("MortageTerm")],
                                                ["type",  App.get("MortageType")],
                                                ["amount",  App.get("PurchasePrice")]
                                            ]);
                                        }

                                        if(!App.has("Personal1Email"))
                                            $scope.Application.Personal1Email = $scope.sessionUser.get("email");

//                                        if(App.has("Liabilities")){
//                                            var _Liabilities = JSON.parse(App.Liabilities);
//                                            for (var key in _Liabilities) {
//                                                $scope.liabilitiesVals[key] = _Liabilities[key];
//
//                                                if(_Liabilities[key][0].balance!="")
//                                                    $scope.assets.push( sub[key]);
//                                            }
//                                        }

                                        if(App.has("Assets")){
                                            var _Assets = JSON.parse(App.Assets);

                                            for (var key in _Assets) {
                                                $scope.assetsVals[key] = _Assets[key];
                                                if(_Assets[key][0].val!="")
                                                    $scope.assets.push( sub[key]);

                                            }
                                        }
                                        $scope.calculateMonthlyPayment();
                                        setTimeout(function(){saveApp()}, 20000);
                            }
                            else {
                                var List = Parse.Object.extend("List");
                                var list = new List();
                                list.save(null, {
                                    success: function(rsp) {
                                        $scope.Application.set("list", rsp.id)
                                    }
                                });
                                $scope.Application.set("user", $rootScope.sessionUser);
                                setTimeout(function(){saveApp()}, 20000);
                            }
                        },
                        function(error){
                            $scope.Application.set("user", $rootScope.sessionUser);
                            setTimeout(function(){saveApp()}, 20000);
                        });


            }
        });

    }

        $rootScope.$watch("pushSave", function(val){
            if(val)
                $scope.saveApp();
        });

        // END of user handling functions
        $scope.autoSaving = false;
        $scope.isAppSaving = function(){
          return $scope.autoSaving == true;
        };
        function saveApp (){
            $scope.saveApp();
        }

        $scope.isSave = false;
        $scope.isSaved = function(){
            return $scope.isSave === true;
        }

        $scope.saveApp = function(){
            if(!$scope.autoSaving && !$scope.successSubmit && $rootScope.sessionUser!=null){
                $scope.autoSaving = true;
//                $scope.Application.Liabilities= JSON.stringify($scope.liabilitiesVals);
                $scope.Application.Assets = JSON.stringify($scope.assetsVals);
                $scope.Application.save(null, {
                    success: function(rsp) {
                        $scope.Application = rsp;
                        $scope.$apply(function(){
                            $scope.autoSaving = false;
                            $scope.isSave = true;
                            $rootScope.autoSaving = false;
                            $rootScope.isSave = true;
                            $rootScope.pushSave = false;
                        });
                    },
                    error: function(rsp, error) {
                        $scope.$apply(function(){
                            $scope.autoSaving = false;
                        });
                    }
                });

                if(!$scope.Application.submited)
                    setTimeout(function(){saveApp()}, 20000);
            }
        };

        var sub = {
            "cash" : "Cash",
            "deposit" : "Deposit",
            "automobile" : "Automobile",
            "valueHome" : "ValueHome",
            "stocks" : "Stocks",
            "rrsp": "RRSP",
            "otherAssets" : "OtherAssets",
            "debts" : "Debts",
            "creditCards": "CreditCards",
            "owingautomobile":"Owingautomobile",
            "mortages":"Mortages",
            "financeCompany":"FinanceCompany",
            "alimonyChild":"AlimonyChild"
        };

        $scope.getFullMorgage = function(){
            return parseFloat($scope.Application.MortageInsurance.replace(/\$|,/g,''))+parseFloat($scope.Application.PurchasePrice.replace(/\$|,/g,''))
        };

        $scope.$watch("Application.MortageTerm", function(val){
            if($scope.AppReady){
                Mortage.setPeriod("period", val);
                $scope.Application.MortageRate = Mortage.getRate();
                $scope.calculateMonthlyPayment();
            }
        });
        $scope.$watch("Application.MortageType", function(val){
            if($scope.AppReady){
                Mortage.setPeriod("type", val);
                if(val=="Variable") {
                    Mortage.setPeriod("period", "5 Year Term");
                    $scope.Application.MortageTerm = "5 Year Term";
                }
                $scope.Application.MortageRate = Mortage.getRate();
                $scope.calculateMonthlyPayment();
            }
        });
        $scope.$watch("Application.MortageTerm", function(val){
            if($scope.AppReady){
                Mortage.setPeriod("period", val);
                if(val!="5 Year Term") {
                    Mortage.setPeriod("type", "Fixed");
                    $scope.Application.MortageType = "Fixed";
                }
                $scope.Application.MortageRate = Mortage.getRate();
                $scope.calculateMonthlyPayment();
            }
        });
        $scope.$watch("Application.PurchaseDownPercent", function(val){
            if(val!=null
                && val.length>1
                && val!="other"
                && $scope.AppReady) {
                if($scope.Application.has("MortagePurchaseNew") && $scope.Application.MortagePurchaseNew.length>2)
                    $scope.Application.MortagePurchaseDownPayment = $filter('noFractionCurrency')( $scope.Application.MortagePurchaseNew.replace(/\$|,/g,'') * parseFloat(val) );
                else if($scope.Application.has("MortagePurchaseDownPayment"))
                    $scope.Application.MortagePurchaseDownPayment = $filter('noFractionCurrency')( Mortage.get("amount").replace(/\$|,/g,'') * parseFloat(val) );
            }
        });
        $scope.$watch("Application.MortagePurchaseDownPayment", function(val){
            if($scope.AppReady
                && val != null
                && val.length>1
                && ($scope.Application.get('MortagePurpose') == "Purchase" || $scope.Application.get('MortagePurpose') == "Pre-Approval")){

                    if($scope.Application.has("MortagePurchaseNew") && $scope.Application.MortagePurchaseNew.length>2){
                        var newVal = parseFloat($scope.Application.MortagePurchaseNew.replace(/\$|,/g,''))-(val.replace(/\$|,/g,''));
                        Mortage.set("amount", newVal);
                        $scope.Application.CashBack = Mortage.get('rebate');
                        $scope.Application.NewMortageValueRefinance =  $filter('noFractionCurrency')(newVal);
                        $scope.Application.ExistingMortageValue =  $filter('noFractionCurrency')(newVal);
                        $scope.Application.TotalFoundsRequired =  $filter('noFractionCurrency')(newVal);
                    }

                    $scope.calculateMonthlyPayment();
            }
        });
        $scope.$watch("Application.PurchasePrice", function(val){
            if(val!=null
                && val.length > 1
                && !$rootScope.isFocoused2
                && $scope.AppReady) {
                Mortage.set("amount", val.replace(/\$|,/g,''));
                $scope.Application.CashBack = Mortage.get('rebate');
                $scope.Application.NewMortageValueRefinance =  val;
                $scope.Application.ExistingMortageValue =  val;
                $scope.Application.TotalFoundsRequired =  val;

                if($scope.Application.has("MortagePurchaseNew")
                    && $scope.Application.MortagePurchaseNew.length < 2
                    && $scope.Application.PurchaseDownPercent != 'other'
                    && Mortage.get("amount").replace(/\$|,/g,'').length>0
                    && $scope.Application.PurchaseDownPercent!=""){

                    //$scope.Application.MortagePurchaseDownPayment = $filter('noFractionCurrency')( Mortage.get("amount").replace(/\$|,/g,'') * parseFloat($scope.Application.PurchaseDownPercent) );

                    var mortgageAmount = Mortage.get("amount").replace(/\$|,/g,'');

                    if(mortgageAmount >= 1000000) {
                        $scope.Application.MortagePurchaseMinDownPayment = $filter('noFractionCurrency')( mortgageAmount * parseFloat(0.2) );
                    }
                    else if(mortgageAmount > 500000 && mortgageAmount < 1000000) {
                        var additionalMortgage = mortgageAmount - 500000;
                        $scope.Application.MortagePurchaseMinDownPayment = $filter('noFractionCurrency')( 500000 * parseFloat(0.05) ) + $filter('noFractionCurrency')( additionalMortgage * parseFloat(0.1) );
                    }
                    else if(mortgageAmount <= 500000) {
                        $scope.Application.MortagePurchaseMinDownPayment = $filter('noFractionCurrency')( mortgageAmount * parseFloat(0.05) );
                    }
                    if($scope.Application.has("ManualDownPayment")) {
                        if(parseInt($scope.Application.ManualDownPayment.replace(/\$|,/g,'')) > parseInt($scope.Application.MortagePurchaseMinDownPayment.replace(/\$|,/g,''))) {
                            $scope.Application.MortagePurchaseDownPayment = $scope.Application.ManualDownPayment;
                        } else {
                            $scope.Application.MortagePurchaseDownPayment = $scope.Application.MortagePurchaseMinDownPayment;
                        }
                    } else {
                        $scope.Application.MortagePurchaseDownPayment = $scope.Application.MortagePurchaseMinDownPayment;
                    }
                }

                if($rootScope.isFocoused && !$rootScope.isFocoused3) {
                    $scope.Application.MortagePurchaseNew = "";
                }


                $scope.calculateMonthlyPayment();
            }
        });
        $scope.$watch("Application.MortagePurchaseNew", function(val){
                if(val!=null
                    && val.length > 1
                    && !$rootScope.isFocoused
                    && $scope.AppReady) {

                    var amount = parseFloat( val.replace(/\$|,/g,'') );

                    if($scope.Application.MortagePurchaseNew.length > 1
                        && $scope.Application.PurchaseDownPercent != 'other'
                        && $scope.Application.PurchaseDownPercent!=""){
                        //$scope.Application.MortagePurchaseDownPayment = $filter('noFractionCurrency')( $scope.Application.MortagePurchaseNew.replace(/\$|,/g,'') * parseFloat($scope.Application.PurchaseDownPercent) );
                        var mortgageAmount = Mortage.get("amount").replace(/\$|,/g,'');
                        if(mortgageAmount >= 1000000) {
                            $scope.Application.MortagePurchaseMinDownPayment = $filter('noFractionCurrency')( mortgageAmount * parseFloat(0.2) );
                        }
                        else if(mortgageAmount > 500000 && mortgageAmount < 1000000) {
                            var additionalMortgage = mortgageAmount - 500000;
                            $scope.Application.MortagePurchaseMinDownPayment = $filter('noFractionCurrency')( 500000 * parseFloat(0.05) ) + $filter('noFractionCurrency')( additionalMortgage * parseFloat(0.1) );
                        }
                        else if(mortgageAmount <= 500000) {
                            $scope.Application.MortagePurchaseMinDownPayment = $filter('noFractionCurrency')( mortgageAmount * parseFloat(0.05) );
                        }

                        if($scope.Application.has("ManualDownPayment")) {
                            if(parseInt($scope.Application.ManualDownPayment.replace(/\$|,/g,'')) > parseInt($scope.Application.MortagePurchaseMinDownPayment.replace(/\$|,/g,''))) {
                                $scope.Application.MortagePurchaseDownPayment = $scope.Application.ManualDownPayment;
                            } else {
                                $scope.Application.MortagePurchaseDownPayment = $scope.Application.MortagePurchaseMinDownPayment;
                            }
                        } else {
                            $scope.Application.MortagePurchaseDownPayment = $scope.Application.MortagePurchaseMinDownPayment;
                        }
                    }

                    amount = amount - parseFloat( $scope.Application.MortagePurchaseDownPayment.replace(/\$|,/g,'') );

                    Mortage.set("amount", amount);
                    $scope.Application.CashBack = Mortage.get('rebate');
                    $scope.Application.PurchasePrice = $filter('noFractionCurrency')(amount);
                    $scope.Application.NewMortageValueRefinance =   $filter('noFractionCurrency')(amount);
                    $scope.Application.ExistingMortageValue =   $filter('noFractionCurrency')(amount);
                    $scope.Application.TotalFoundsRequired =   $filter('noFractionCurrency')(amount);

                    $scope.calculateMonthlyPayment();

                }
            });


            $scope.$watch("Application.ManualDownPayment", function(val){
                if(val!=null
                    && val.length > 1
                    && !$rootScope.isFocoused
                    && $scope.AppReady) {
                    var mortgageAmount = Mortage.get("amount").replace(/\$|,/g,'');
                    if(mortgageAmount >= 1000000) {
                        $scope.Application.MortagePurchaseMinDownPayment = $filter('noFractionCurrency')( mortgageAmount * parseFloat(0.2) );
                    }
                    else if(mortgageAmount > 500000 && mortgageAmount < 1000000) {
                        var additionalMortgage = mortgageAmount - 500000;
                        $scope.Application.MortagePurchaseMinDownPayment = $filter('noFractionCurrency')( 500000 * parseFloat(0.05) ) + $filter('noFractionCurrency')( additionalMortgage * parseFloat(0.1) );
                    }
                    else if(mortgageAmount <= 500000) {
                        $scope.Application.MortagePurchaseMinDownPayment = $filter('noFractionCurrency')( mortgageAmount * parseFloat(0.05) );
                    }

                    if($scope.Application.has("ManualDownPayment")) {
                        if(parseInt($scope.Application.ManualDownPayment.replace(/\$|,/g,'')) > parseInt($scope.Application.MortagePurchaseMinDownPayment.replace(/\$|,/g,''))) {
                            $scope.Application.MortagePurchaseDownPayment = $scope.Application.ManualDownPayment;
                        } else {
                            $scope.Application.MortagePurchaseDownPayment = $scope.Application.MortagePurchaseMinDownPayment;
                        }
                    } else {
                        $scope.Application.MortagePurchaseDownPayment = $scope.Application.MortagePurchaseMinDownPayment;
                    }
                    $scope.calculateMonthlyPayment();

                }
            });




        $scope.$watch("Application.NewMortageValueRefinance", function(val){
            if(val!=null
                && val.length > 1
                && !$rootScope.isFocoused2
                && $scope.AppReady) {
                Mortage.set("amount", val.replace(/\$|,/g,''));
                $scope.Application.CashBack = Mortage.get('rebate');
                $scope.Application.PurchasePrice =  val;
                $scope.Application.ExistingMortageValue =  val;
                $scope.Application.TotalFoundsRequired =  val;
//                $scope.Application.MortagePurchaseNew = "";
                $scope.calculateMonthlyPayment();

            }
        });
        $scope.$watch("Application.ExistingMortageValue", function(val){
            if(val!=null
                && val.length > 1
                && !$rootScope.isFocoused2
                && $scope.AppReady) {
                Mortage.set("amount", val.replace(/\$|,/g,''));
                $scope.Application.CashBack = Mortage.get('rebate');
                $scope.Application.NewMortageValueRefinance =  val;
                $scope.Application.PurchasePrice =  val;
                $scope.Application.TotalFoundsRequired =  val;
//                $scope.Application.MortagePurchaseNew = "";
                $scope.calculateMonthlyPayment();
            }
        });
        $scope.$watch("Application.TotalFoundsRequired", function(val){
            if(val!=null
                && val.length > 1
                && !$rootScope.isFocoused2
                && $scope.AppReady) {
                Mortage.set("amount", val.replace(/\$|,/g,''));
                $scope.Application.CashBack = Mortage.get('rebate');
                $scope.Application.NewMortageValueRefinance =  val;
                $scope.Application.ExistingMortageValue =  val;
                $scope.Application.PurchasePrice =  val;
//                $scope.Application.MortagePurchaseNew = "";
                $scope.calculateMonthlyPayment();
            }
        });
        $scope.$watch("Application.MortageAmortization", function(val){
            if(val!=null && $scope.AppReady) {
                $scope.calculateMonthlyPayment();
            }
        });
        $scope.$watch("Application.PaymentSchedule", function(val){
            if(val!=null && $scope.AppReady) {
                $scope.calculateMonthlyPayment();
            }
        });
        $scope.$watch("Application.MortagePurpose", function(val){
            if(val!=null && $scope.AppReady) {
                $scope.calculateMonthlyPayment();
            }
        });
        $scope.calculateMonthlyPayment = function(){

            if($scope.Application.has('PurchasePrice') && $scope.Application.has('MortagePurchaseDownPayment')){

                if( $scope.Application.get('MortagePurpose') == "Purchase" || $scope.Application.get('MortagePurpose') == "Pre-Approval") {

                    var downPayment = parseFloat( $scope.Application.get('MortagePurchaseDownPayment').replace(/\$|,/g,'') ),
                        percentage = 0.0315,
                        c = parseFloat($scope.Application.get('PurchasePrice').replace(/\$|,/g,''));

                        if($scope.Application.MortagePurchaseNew.length>1)
                            c = parseFloat($scope.Application.get('MortagePurchaseNew').replace(/\$|,/g,''));

                        var calculatedP = downPayment/c;


                    if(calculatedP<0.2) {

                    	if(calculatedP >= 0.15) {
                    		percentage = 0.018;
                    	} else if (calculatedP < 0.15 && calculatedP >= 0.1) {
                    		percentage = 0.024;
                    	} else if (calculatedP < 0.1 && calculatedP >= 0.05) {
                    		percentage = 0.0315;
                    	}

                        $scope.Application.set("MortageInsurance", ( parseFloat($scope.Application.get('PurchasePrice').replace(/\$|,/g,'')) *percentage).toFixed(4));
                    }
                    else
                        $scope.Application.set("MortageInsurance", "");

                }
            }

            if($scope.Application.has('MortageAmortization') &&
                $scope.Application.has('MortageRate') &&
                $scope.Application.has('PurchasePrice')){

                var a = $scope.Application.get('MortageAmortization').split(" "),
                    n = parseFloat(a[0]);
                    annualInterest = (parseFloat($scope.Application.get('MortageRate'))/100).toFixed(10);

                    p = 0;
                    yearlyPayments = 0;

                if($scope.Application.has('PurchasePrice') && $scope.Application.get('PurchasePrice').length>0)
                    p = parseFloat($scope.Application.get('PurchasePrice').replace(/\$|,/g,''));

                if( ($scope.Application.get('MortagePurpose') == "Purchase" || $scope.Application.get('MortagePurpose') == "Pre-Approval")
                    && !$scope.Application.has('MortagePurchaseNew')) {
                    p = p-parseFloat( $scope.Application.get('MortagePurchaseDownPayment').replace(/\$|,/g,'') );
                }

                if($scope.Application.has("MortageInsurance") && $scope.Application.get("MortageInsurance").length>1)
                    p = p+parseFloat($scope.Application.get('MortageInsurance').replace(/\$|,/g,''));
                else
                    $scope.Application.set("MortageInsurance", "");



				
				var frequency;

				if( $scope.Application.get('PaymentSchedule') == "Monthly") {
					frequency = 12;
                } else if( $scope.Application.get('PaymentSchedule') == "Bi-weekly") {
                	frequency = 26.071428571428573;
                } else if( $scope.Application.get('PaymentSchedule') == "Weekly") {
                	frequency = 52.142857142857146;
                }
                
                var pvFactor = (1 - Math.pow( Math.pow(1 + annualInterest / 2, 2 / frequency), -frequency * n)) / (Math.pow(1 +annualInterest / 2,  2 / frequency) - 1);
								
				var tPayment = +(( p / pvFactor).toFixed(2));			
										
				payment = Math.round(tPayment, 1);
                $scope.Application.set('MortagePaymentAmount', payment);
            }
            else
                $scope.Application.set('MortagePaymentAmount', 0 );
        };
        $scope.isValidStep = function(ind){
            return $scope.steps[ind] === true;
        };
        $scope.$watchCollection("Application", function(){

                if($scope.Application.has("MortagePurpose") &&
                    $scope.Application.has("MortageType") &&
                    $scope.Application.has("MortageTerm") &&
                    $scope.Application.has("MortageRate") &&
                    $scope.Application.has("MortageOwnProperties") &&
                    $scope.Application.has("MortageAmortization") &&
                    $scope.Application.has("PaymentSchedule") &&
                    $scope.Application.get("MortagePurpose").length>0 &&
                    $scope.Application.get("MortageType").length>0 &&
                    $scope.Application.get("MortageTerm").length>0 &&
                    $scope.Application.get("MortageOwnProperties").length>0 &&
                    $scope.Application.get("MortageRate").length>0 &&
                    $scope.Application.get("MortageAmortization").length>0 &&
                    $scope.Application.get("PaymentSchedule").length>0) {


                    if($scope.Application.get("MortagePurpose") == 'Purchase' ||
                        $scope.Application.get("MortagePurpose") == 'Pre-Approval') {

                        var price = parseInt($scope.Application.get("PurchasePrice").replace(/\$|,/g,''));

                        if($scope.Application.has("PurchasePrice") &&
                            (price>=50000 && price<=5000000) &&
                            $scope.Application.has("MortagePurchaseDownPayment") &&
                            $scope.Application.get("PurchasePrice").length>0 &&
                            $scope.Application.get("MortagePurchaseDownPayment").length>0){

                                if( ($scope.Application.get("MortageMLS")=="Y" && $scope.Application.has("MortageMLSNumber") && $scope.Application.get("MortageMLSNumber").length>0 ) || $scope.Application.get("MortageMLS")=="N") {
                                    if(!$scope.steps[1]) {
                                        $scope.steps[1] = true;
                                    }
                                }
                                else {
                                    if($scope.steps[1]) {
                                        $scope.steps[1] = false;
                                    }
                                }

                        }
                        else {
                            if($scope.steps[1]) {
                                $scope.steps[1] = false;
//                                $scope.progress = $scope.progress-20;
                            }
                        }

                    }

                    if($scope.Application.get("MortagePurpose") == 'Refinance'){

                        var e1 = parseInt($scope.Application.NewMortageValueRefinance.replace(/\$|,/g,''));
                        var e2 = parseInt($scope.Application.AppraisedValue.replace(/\$|,/g,''));

                        var price = e2*0.8;

                        if($scope.Application.has("AppraisedValue") &&
                            (price>=e1) &&
                            $scope.Application.has("ExistingMortageValueRefinance") &&
                            $scope.Application.has("NewMortageValueRefinance") &&
                            $scope.Application.get("AppraisedValue").length>0 &&
                            $scope.Application.get("ExistingMortageValueRefinance").length>0 &&
                            $scope.Application.get("NewMortageValueRefinance").length>0){
                                if(!$scope.steps[1]) {
                                    $scope.steps[1] = true;
//                                    $scope.progress = $scope.progress+20;
                                }
                        }
                        else {
                            if($scope.steps[1]) {
                                $scope.steps[1] = false;
//                                $scope.progress = $scope.progress-20;
                            }
                        }

                    }

                    if($scope.Application.get("MortagePurpose") == 'Switch'){

                        var e1 = parseInt($scope.Application.AppraisedValue.replace(/\$|,/g,''));
                        var e2 = parseInt($scope.Application.ExistingMortageValue.replace(/\$|,/g,''));

                        if($scope.Application.has("AppraisedValue") &&
                            (e1>e2) &&
                            $scope.Application.has("ExistingMortageValue") &&
                            $scope.Application.has("MaturityDate") &&
                            $scope.Application.get("AppraisedValue").length>0 &&
                            $scope.Application.get("ExistingMortageValue").length>0 &&
                            $scope.Application.get("MaturityDate").length>0){
                            if(!$scope.steps[1]) {
                                $scope.steps[1] = true;
//                                $scope.progress = $scope.progress+20;
                            }
                        }
                        else {
                            if($scope.steps[1]) {
                                $scope.steps[1] = false;
//                                $scope.progress = $scope.progress-20;
                            }
                        }

                    }

                    if($scope.Application.get("MortagePurpose") == 'Construction'){
                        var price = parseInt($scope.Application.get("TotalFoundsRequired").replace(/\$|,/g,''));

                        if($scope.Application.has("PurchasePriceConstruction") &&
                            (price>=50000 && price<=5000000) &&
                            $scope.Application.has("ApprovedPermits") &&
                            $scope.Application.has("ConstructionBudget") &&
                            $scope.Application.has("TotalFoundsRequired") &&
                            $scope.Application.get("PurchasePriceConstruction").length>0 &&
                            $scope.Application.get("ApprovedPermits").length>0 &&
                            $scope.Application.get("ConstructionBudget").length>0 &&
                            $scope.Application.get("TotalFoundsRequired").length>0){
                            if(!$scope.steps[1]) {
                                $scope.steps[1] = true;
//                                $scope.progress = $scope.progress+20;
                            }
                        }
                        else {
                            if($scope.steps[1]) {
                                $scope.steps[1] = false;
//                                $scope.progress = $scope.progress-20;
                            }
                        }
                    }

                }
                else {
                    if($scope.steps[1]) {
                        $scope.steps[1] = false;
//                        $scope.progress = $scope.progress-20;
                    }
                }

            if($scope.Application.has("Personal1Fname") &&
                $scope.Application.has("Personal1Lname") &&
                $scope.Application.has("Personal1BirthMonth") &&
                $scope.Application.has("Personal1BirthDay") &&
                $scope.Application.has("Personal1BirthYear") &&
                $scope.Application.has("Personal1Email") &&
                $scope.validateEmail($scope.Application.get("Personal1Email")) &&
                $scope.Application.get("Personal1Fname").length>1 &&
                $scope.Application.get("Personal1Lname").length>1 &&
                $scope.Application.get("Personal1BirthMonth").length>0 &&
                $scope.Application.get("Personal1BirthDay").length>0 &&
                $scope.Application.get("Personal1BirthYear").length>0 &&
                ( new Date().getFullYear() - $scope.Application.get("Personal1BirthYear") >= 18 ) &&
                $scope.Application.get("Personal1Email").length > 0){

                    if(!$scope.steps[2]) {
                        $scope.steps[2] = true;
    //                    $scope.progress = $scope.progress+20;
                    }


            }
            else {
                if($scope.steps[2]) {
                    $scope.steps[2] = false;
//                    $scope.progress = $scope.progress-20;
                }
            }

            if($scope.Application.has("Personal1Street1") &&
                $scope.Application.has("Personal1City") &&
                $scope.Application.has("Personal1Province") &&
                $scope.Application.has("Personal1Postal") &&
                $scope.Application.has("Personal1ResidentalStatus") &&
                $scope.Application.get("Personal1Street1").length>2 &&
                $scope.Application.get("Personal1City").length>2 &&
                $scope.Application.get("Personal1Province").length>0 &&
                $scope.Application.get("Personal1Postal").length==7 &&
                $scope.Application.get("Personal1ResidentalStatus").length>0){

                if(!$scope.steps[3]) {
                    $scope.steps[3] = true;
//                    $scope.progress = $scope.progress+20;
                }

            }
            else {
                if($scope.steps[3]) {
                    $scope.steps[3] = false;
//                    $scope.progress = $scope.progress-20;
                }
            }

            if($scope.Application.has("Personal1SelfEmployed") &&
                $scope.Application.has("Personal1Income") &&
                $scope.Application.get("Personal1SelfEmployed").length>0 &&
                $scope.Application.get("Personal1Income").length>2){

                if(!$scope.steps[4]) {
                    $scope.steps[4] = true;
//                    $scope.progress = $scope.progress+20;
                }

            }
            else {
                if($scope.steps[4]) {
                    $scope.steps[4] = false;
//                    $scope.progress = $scope.progress-20;
                }
            }

            if($scope.Application.get("Application2")){

                if($scope.Application.has("Personal2Fname") &&
                    $scope.Application.has("Personal2Lname") &&
                    $scope.Application.has("Personal2Email") &&
                    $scope.Application.has("Personal2Relationship") &&
                    $scope.Application.get("Personal2Fname").length>2 &&
                    $scope.Application.get("Personal2Lname").length>2 &&
                    $scope.Application.get("Personal2Email").length>0 &&
                    $scope.validateEmail($scope.Application.get("Personal2Email")) &&
                    $scope.Application.get("Personal2Relationship").length>0){

                    if(!$scope.steps[5]) {
                        $scope.steps[5] = true;
//                        $scope.progress = $scope.progress+4;
                    }

                }
                else {
                    if($scope.steps[5]) {
                        $scope.steps[5] = false;
//                        $scope.progress = $scope.progress-4;
                    }
                }


                if($scope.Application.has("Personal2Street1") &&
                    $scope.Application.has("Personal2City") &&
                    $scope.Application.has("Personal2Province") &&
                    $scope.Application.has("Personal2Postal") &&
                    $scope.Application.get("Personal2Street1").length>2 &&
                    $scope.Application.get("Personal2City").length>2 &&
                    $scope.Application.get("Personal2Province").length>0 &&
                    $scope.Application.get("Personal2Postal").length==6){

                    if(!$scope.steps[6]) {
                        $scope.steps[6] = true;
//                        $scope.progress = $scope.progress+4;
                    }

                }
                else {
                    if($scope.steps[6]) {
                        $scope.steps[6] = false;
//                        $scope.progress = $scope.progress-4;
                    }
                }

                if($scope.Application.has("Personal2SelfEmployed") &&
                    $scope.Application.has("Personal2Income") &&
                    $scope.Application.get("Personal2SelfEmployed").length>0 &&
                    $scope.Application.get("Personal2Income").length>2){

                    if(!$scope.steps[7]) {
                        $scope.steps[7] = true;
//                        $scope.progress = $scope.progress+2;
                    }

                }
                else {
                    if($scope.steps[7]) {
                        $scope.steps[7] = false;
//                        $scope.progress = $scope.progress-2;
                    }
                }

            }

            if($scope.Application.has("PropertyStreet1") &&
                $scope.Application.has("PropertyCity") &&
                $scope.Application.has("PropertyProvince") &&
                $scope.Application.get("PropertyStreet1").length>2 &&
                $scope.Application.get("PropertyCity").length>2 &&
                $scope.Application.get("PropertyProvince").length>0){

                if(!$scope.steps[8]) {
                    $scope.steps[8] = true;
//                    $scope.progress = $scope.progress+20;
                }

            }
            else {
                if($scope.steps[8]) {
                    $scope.steps[8] = false;
//                    $scope.progress = $scope.progress-20;
                }
            }

        });
        $scope.progress = 0;
        $scope.isStep = function(ind){
             return $scope.appStep === ind;
        };
        $scope.$watch("appStep", function(new_val){
            if(new_val==0)
                $scope.progress = 0;
            if(new_val==1)
                $scope.progress = 9;
            if(new_val==2)
                $scope.progress = 18;
            if(new_val==3)
                $scope.progress = 27;
            if(new_val==4)
                $scope.progress = 36;
            if(new_val==5)
                $scope.progress = 45;
            if(new_val==6)
                $scope.progress = 54;
            if(new_val==7)
                $scope.progress = 63;
            if(new_val==8)
                $scope.progress = 72;
            if(new_val==9)
                $scope.progress = 81;
            if(new_val==10)
                $scope.progress = 90;
            if(new_val==11)
                $scope.progress = 100;

            $scope.Application.set("AppStep", new_val);
        });
        $scope.setStep = function(ind){

            var proced = false;

            if($scope.steps[1] == true &&
                $scope.steps[2] == true  &&
                $scope.steps[3] == true &&
                $scope.steps[4] == true &&
                $scope.steps[8] == true){

                    proced = true;
            }
            else {

                if(ind==0 )
                    proced = true;

                if(ind==1 &&
                    $scope.steps[1] == true)
                    proced = true;

                if(ind==2 &&
                    $scope.steps[1] == true &&
                    $scope.steps[2] == true)
                    proced = true;

                if(ind==3 &&
                    $scope.steps[1] == true &&
                    $scope.steps[2] == true &&
                    $scope.steps[3] == true)
                    proced = true;

                if(ind>3 && ind<8 &&
                    $scope.steps[1] == true &&
                    $scope.steps[2] == true &&
                    $scope.steps[3] == true &&
                    $scope.steps[4] == true)
                    proced = true;

                if(ind<7 &&
                    $scope.steps[1] == true &&
                    $scope.steps[2] == true &&
                    $scope.steps[3] == true &&
                    $scope.steps[4] == true &&
                    $scope.steps[8] == true)
                    proced = true;


            }



            if(proced){
                $('html, body').animate({
                    scrollTop: 0
                }, 500);
                $scope.appStep = ind;
            }

        };
        $scope.changeHappen = false;
        $scope.registerError = false;
        $scope.increaseStep = function(){
            var proced = false;

            var ind = $scope.appStep+1;

            if($scope.steps[1] == true &&
                $scope.steps[2] == true  &&
                $scope.steps[3] == true &&
                $scope.steps[4] == true &&
                $scope.steps[8] == true){

                proced = true;
            }
            else {

                if(ind==1 &&
                    $scope.steps[1] == true){
                    proced = true;
                }
                if(ind==2 &&
                    $scope.steps[1] == true &&
                    $scope.steps[2] == true) {

                    if($("input[name='Application.Personal1HomePhone']").hasClass('ng-invalid') ) {
                    	$scope.registerError = true;
                    	$("input[name='Application.Personal1HomePhone']").addClass('ng-dirty');
                    } else if($rootScope.sessionUser==null) {
                        if($scope.apassword.length>=6
                            && !$("#regWithEmail").hasClass('ng-invalid-unique')
                            && !$("#repPass").hasClass('ng-invalid-unique')){
                            var data = {};
                            data.email = $scope.Application.get("Personal1Email");
                            data.firstName = $scope.Application.get("Personal1Fname");
                            data.lastName = $scope.Application.get("Personal1Lname");
                            data.password = $scope.inAppForm.apassword.$viewValue;
                            $rootScope.userHandler.registerClean(data);
                            proced = true;
                            $scope.registerError = false;
                        }
                        else
                            $scope.registerError = true;
                    }
                    else
                        proced = true;
                }
                else if(ind==2 &&
                    $scope.steps[1] == true &&
                    $scope.steps[2] == false) {
                    $scope.registerError = true;
                }

                if(ind==3 &&
                    $scope.steps[1] == true &&
                    $scope.steps[2] == true &&
                    $scope.steps[3] == true) {

                    if($rootScope.sessionUser!=null) {
                            var data = {};
                            data.uaddress = $scope.Application.get("Personal1Street1");
                            if($scope.Application.has("Personal1Street2"))
                                data.uaddress2 = $scope.Application.get("Personal1Street2");
                            else
                                data.uaddress2 = "";
                            data.ucity = $scope.Application.get("Personal1City");
                            data.uprovince = $scope.Application.get("Personal1Province");
                            data.upostal = $scope.Application.get("Personal1Postal");
                            $rootScope.userHandler.updateClean(data);
                    }

                    proced = true;
                }


                if(ind>3 && ind<8 &&
                    $scope.steps[1] == true &&
                    $scope.steps[2] == true &&
                    $scope.steps[3] == true &&
                    $scope.steps[4] == true)
                    proced = true;

                if(ind<7 &&
                    $scope.steps[1] == true &&
                    $scope.steps[2] == true &&
                    $scope.steps[3] == true &&
                    $scope.steps[4] == true &&
                    $scope.steps[8] == true)
                    proced = true;


            }

            if(proced){
                $('html, body').animate({
                    scrollTop: 0
                }, 500);


                if($scope.appStep == 8 || ($scope.Application.get("MortagePurpose") == 'Refinance' && $scope.appStep == 7))
                    $scope.appStep = 10;
                else
                    $scope.appStep++;

                $scope.trackEvents();

                $scope.changeHappen = true;
            }
        };

        $scope.trackEvents = function(){

            var lbl = [
                "Mortage Details",
                "Personal information",
                "Address information",
                "Employment information",
                "Personal information2",
                "Address information2",
                "Employment information2",
                "Property Information",
                "Financial Information",
                "Financial Information",
                "Other Information",
                "Submit application"
            ];

            $analytics.eventTrack('Application', {  category: lbl[$scope.appStep], label: 'Mowing thru steps' });
        };

        $scope.decreaseStep = function(){
            $('html, body').animate({
                scrollTop: 0
            }, 500);

            if($scope.Application.get("MortagePurpose") == 'Refinance' && $scope.appStep == 10)
                $scope.appStep = 7;
            else if($scope.appStep == 10 && $scope.Application.get("MortagePurpose") != 'Refinance')
                $scope.appStep = 8;
            else
                $scope.appStep--;

            $scope.changeHappen = true;
        };

        $("a").on("click", function(){
            $rootScope.$apply(function(){
                $rootScope.linksIsClicked = true;
            });
        });

        $scope.$on('$locationChangeStart', function(event, newUrl, oldUrl) {
            if ($scope.appStep>0 && $scope.changeHappen && !$scope.successSubmit && !$rootScope.linksIsClicked) {
                event.preventDefault();
                $scope.decreaseStep();
            }
            else
                $rootScope.linksIsClicked = false;
        });

        $scope.validateEmail = function(email){
            return /^([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22))*\x40([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d))*$/.test( email );
        };

        $scope.appLoading = false;
        $scope.isAppLoading = function(){
            return $scope.appLoading;
        };
        $scope.isApplicationValid = function(){
            var rsp = 0;
            angular.forEach($scope.steps, function(value, key){
                if(value==true)
                    rsp++;
            });

            return rsp>=5;
        };
        $scope.submitApplication = function(){
                $scope.appLoading = true;
                $scope.Application.submited = true;
                $scope.Application.ApplicationStatus = 1;
//                $scope.Application.Liabilities= JSON.stringify($scope.liabilitiesVals);
                $scope.Application.Assets = JSON.stringify($scope.assetsVals);
                if(!$scope.Application.has("refId")){
                    Parse.Cloud.run('getRefId', {}).then(function(refId){
                        $scope.Application.set("refId", refId);
                        $scope.Application.save(null, {
                            success: function(rsp) {

                                $('html, body').animate({
                                    scrollTop: 0
                                }, 1000);

                                $scope.$apply(function(){
                                    $scope.changeHappen = true;
                                    $scope.appLoading = false;
                                    $scope.successSubmit = true;
                                    $analytics.eventTrack('Application', {  category: 'Application Submited', label: refId });
                                });


                                Parse.Cloud.run('sendMail', {
                                    email: rsp.get("Personal1Email"),
                                    name: rsp.get("Personal1Fname")+" "+rsp.get("Personal1Lname"),
                                    appId: rsp.get('refId')
                                }, {
                                    success: function(result) { },
                                    error: function(error) {}
                                });

                            },
                            error: function(rsp, error) {
                                $scope.$apply(function(){
                                    $scope.appLoading = false;
                                    $scope.error = error.message;
                                });
                            }
                        });
                    });
                }
                else {
                    $scope.Application.save(null, {
                    success: function(rsp) {

                        $('html, body').animate({
                            scrollTop: 0
                        }, 1000);


                        $scope.$apply(function(){
                            $scope.changeHappen = true;
                            $scope.appLoading = false;
                            $scope.successSubmit = true;
                            $analytics.eventTrack('Application', {  category: 'Application Submited', label: $scope.Application.get("refId")});
                        });

//
                        Parse.Cloud.run('sendMail', {
                            email: rsp.get("Personal1Email"),
                            name: rsp.get("Personal1Fname")+" "+rsp.get("Personal1Lname"),
                            appId: rsp.get('refId')
                        }, {
                            success: function(result) { },
                            error: function(error) {}
                        });

                    },
                    error: function(rsp, error) {
                        $scope.$apply(function(){
                            $scope.appLoading = false;
                            $scope.error = error.message;
                        });
                    }
                });
                }
        };
        $scope.copyAddresss = function(ind){
                $scope.Application.Personal2Street1 = $scope.Application.get("Personal1Street1");
                $scope.Application.Personal2Street2 = $scope.Application.get("Personal1Street2");
                $scope.Application.Personal2City = $scope.Application.get("Personal1City");
                $scope.Application.Personal2Province = $scope.Application.get("Personal1Province");
                $scope.Application.Personal2Postal = $scope.Application.get("Personal1Postal");
        };
        $scope.copyAddresss2 = function(ind){
            $scope.Application.PropertyStreet1 = $scope.Application.get("Personal1Street1");
            $scope.Application.PropertyStreet2 = $scope.Application.get("Personal1Street2");
            $scope.Application.PropertyCity = $scope.Application.get("Personal1City");
            $scope.Application.PropertyProvince = $scope.Application.get("Personal1Province");
            $scope.Application.PropertyPostal = $scope.Application.get("Personal1Postal");
        };
        $scope.sections = {
            "mortage" : false,
            "personal1" : false,
            "employment1" : false,
            "personal2": false,
            "employment2" : false,
            "property" : false,
            "other" : false,
            "cash" : false,
            "deposit" : false,
            "automobile" : false,
            "valueHome" : false,
            "stocks": false,
            "rrsp" : false,
            "otherAssets" : false,
            "debts": false,
            "creditCards": false,
            "owingautomobile":false,
            "mortages" : false,
            "financeCompany":false,
            "alimonyChild":false
        };
        $scope.toggleSections = function(ind){
            angular.forEach($scope.sections, function(value, key){
                if(key===ind)
                    $scope.sections[ind] = true;
                else
                    $scope.sections[key] = false;
            });
        };
        $scope.isToggleSection = function(ind){
            return $scope.sections[ind] === true;
        }
        $scope.isAssets = function(){
            return $scope.assets.length > 0;
        };
        var obj = null;
        $scope.pushAsset = function(val){
            if(val!="" && $scope.assets.indexOf(val)==-1){
                $scope.assets.push(val);
            }
            $scope.assestsMenu = "";
            obj = val;

            setTimeout(scrollTo, 200);
        };
        var scrollTo = function (){
            var val = obj;
            var el = $('#box_'+val);
            var elOffset = el.offset().top;
            var elHeight = el.height();
            var windowHeight = $(window).height();
            var offset;

            if (elHeight < windowHeight) {
                offset = elOffset - ((windowHeight / 2) - (elHeight / 2));
            }
            else {
                offset = elOffset;
            }

            $('html, body').animate({scrollTop:offset}, 700, function(){
                $('#box_'+val+' input:eq(0)').focus();
            });
        }
        $scope.isInAsset = function(val){
            return $scope.assets.indexOf(val) > -1;
        };
        $scope.removeAssets = function(val){
            $scope.assets.splice($scope.assets.indexOf(val), 1);
        };
        $scope.addAssestsVal = function(val){
            $scope.assetsVals[val].push({
                where: "",
                description: "",
                val: ""
            });
        };
        $scope.removeAssestsVal = function(val){
            var new_array = [];
            angular.forEach($scope.assetsVals[val], function(value, key){
                if($scope.assetsVals[val].length>1 &&
                    (value.where != "" ||
                        value.description != "" ||
                        value.val != ""))
                    new_array.push(value);
            });
            $scope.assetsVals[val] = [];
            if(new_array.length == 0)
                $scope.addAssestsVal(val);
            else
                $scope.assetsVals[val] = new_array;

        };
        $scope.addLiabilities = function(val){
            $scope.liabilitiesVals[val].push({
                where: "",
                description: "",
                balance: ""
            });
        };
        $scope.removeLiabilities = function(val){
            var new_array = [];
            angular.forEach($scope.liabilitiesVals[val], function(value, key){
                if($scope.liabilitiesVals[val].length>1 &&
                    (value.where != "" ||
                        value.description != "" ||
                        value.balance != ""))
                    new_array.push(value);
            });
            $scope.liabilitiesVals[val] = [];
            if(new_array.length == 0)
                $scope.addLiabilities(val);
            else
                $scope.liabilitiesVals[val] = new_array;

        };

    }];
    controllers.ContactUsController = ['$rootScope', '$scope', '$window', '$location', function($rootScope, $scope, $window, $location){
		var recipientEmails = [];
		var adminEmail = { name: 'admin', email: adminEmailAddress };
		
		var success = true;
		
		recipientEmails.push(adminEmail);
		
		$scope.sendContact = function(data){
			if(data.sendMeACopy.$viewValue == true){
				recipientEmails.push({ name: data.uName.$viewValue, email: data.uEmail.$viewValue });
			}
			
			Parse.Cloud.run('sendAdminContactMail', {
				name: data.uName.$viewValue,
				email: data.uEmail.$viewValue,
				text: data.uText.$viewValue,
				recipients: recipientEmails
			}, {
			success: function(result) {
				$('.header-contact-us .text-success').css("display","block");
			 },
			error: function(error) {
				$('.header-contact-us .text-warning').css("display","block");
			}
			});
		
			Parse.Cloud.run('sendThankYouContactMail', {
				name: data.uName.$viewValue,
				email: data.uEmail.$viewValue,
			}, {
			success: function(result) {
			 },
			error: function(error) {
			}
			});
        };
    }];

    controllers.StaticCtrl = ['$rootScope', '$scope', '$window', '$location', function($rootScope, $scope, $window, $location){

        $rootScope.$on("login", function(val){
            if($location.path() == "/become-partner")
                $rootScope.next("dashboard");
        });


        $scope.faqIndex = -1;
        $scope.isFaqIndex = function(id){
            return $scope.faqIndex == id;
        };
        $scope.setFaq = function(id){
            if($scope.faqIndex == id )
                $scope.faqIndex = -1;
            else
                $scope.faqIndex = id;
        };

        $scope.faqs = [
            {
                "title" : "Q: What is Do Your Own Mortgage?",
                "desc"  : "A: Do Your Own Mortgage is a self-service mortgage website that allows you to take control of your mortgage application and receive cash back on all mortgage products.  By doing your own mortgage, you will be able to track the progress of your application every step of the way through your private dashboard."
            },
            {
                "title" : "Q: How long will it take to complete my application?",
                "desc"  : "A: The application will take approximately 10 minutes to complete on your computer, tablet or smart phone."
            },
            {
                "title" : "Q: Is my information secure?",
                "desc"  : "A: Yes, protecting your privacy and safeguarding your financial information is extremely  importance to us. While most companies use a 128-bit encryption, we use 256-bit SSL encryption.  Your information will only be shared with parties pertinent to your mortgage approval ie: Bank & Trust Companies, Insurers, Lawyers and Credit Bureau Agency’s."
            },
            {
                "title" : "Q: Are there any fees for doing my mortgage with you?",
                "desc"  : "A: In most cases no. Do Your Own Mortgage will not charge any broker fees for its services.  In some cases where your credit score is below 650, some lenders may charge a premium or lender fee. Our goal and priority is to find you the best mortgage and pay you cash back based on the term and mortgage amount you selected."
            },
            {
                "title" : "Q: How is cash back calculated?",
                "desc"  : "A: Cash back is calculated based on your mortgage amount. We pay you a percentage that is based on the term you select and the size of your mortgage."
            },
            {
                "title" : "Q: When will I get my cash back?",
                "desc"  : "A: Cash back is payable on the 15th and 30th of the month that your mortgage has been funded."
            },
            {
                "title" : "Q: How do I check the status of my application?",
                "desc"  : "A: During the application process, you were asked to register your email address.  This email will provide you with access to your dashboard once you log in from our website."
            },
            {
                "title" : "Q: How do I get in touch with a DYOM agent?",
                "desc"  : "A: Please feel free to email us at <a href='mailto:info@doyourownmortgage.com'>info@doyourownmortgage.com</a> or give us a call at 647-931-DYOM (3966) or Toll Free at: 1-800-298-DYOM (3966)"
            },
            {
                "title" : "Q: How is DYOM different from a bank?",
                "desc"  : "A: What sets us apart from a traditional bank is that we have access to over 50 competing institutions, which include: Credit Unions, Trust Companies, Banks, Regional and Private Lenders.   We use all of our resources to find you the best deal and top it off with a great cash back!"
            }
        ];

        angular.element($window).bind("scroll", function() {
            if($rootScope.isActiveHow()){

                if($('body').scrollTop() > $('.partner-howItworks').height()+50) {
                    $rootScope.isHow = false;
                    $rootScope.$apply();
                }

            }
        });


    }];

// ==== REGISTER CONTROLLERS IN ANGULAJRS APP
app.controller(controllers);

});
