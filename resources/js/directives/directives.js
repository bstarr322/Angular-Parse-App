define(['jquery', 'app', "facebook", "twitter", "jqueryVisible", 'bootstrap', 'datePicker', 'moment', 'livestamp'], function ($, app, FB, twttr) {

// === DIRECTIVES OBJECT
    var directives = {};

    directives.preventDef = [function(){
        return function(scope, element, attrs) {
            element.bind("click", function(event) {
                event.preventDefault();
            });
        };
    }];
    directives.ngMakefocus = ['$rootScope', function($rootScope){
        return function(scope, element, attrs) {
            element.bind("blur", function() {
                $rootScope.isFocoused = false;
            });
            element.bind("focus", function() {
                $rootScope.isFocoused = true;
            });
        };
    }];
    directives.ngMakefocussecond = ['$rootScope', function($rootScope){
        return function(scope, element, attrs) {
            element.bind("blur", function() {
                $rootScope.isFocoused2 = false;
            });
            element.bind("focus", function() {
                $rootScope.isFocoused2 = true;
            });
        };
    }];
    directives.ngMakefocusthird = ['$rootScope', function($rootScope){
        return function(scope, element, attrs) {
            element.bind("blur", function() {
                $rootScope.isFocoused3 = false;
            });
            element.bind("focus", function() {
                $rootScope.isFocoused3 = true;
            });
        };
    }];
    directives.ngReferalshow = ['$rootScope', function($rootScope){
        return function(scope, element, attrs) {
                $(element).popover({
                    content: "Share this link with your friends and you can get $500 cash back",
                    placement: "top",
                    trigger: "manual"
                });

                element.bind("click", function(event) {
                    $(element).popover("hide");
                });

                setTimeout(function(){
                    if(!$rootScope.sessionUser.has("popUpShowed")) {
                        $(element).popover("show");
                        $rootScope.sessionUser.set("popUpShowed", true);
                        $rootScope.sessionUser.save(null, {
                            success: function(user) {
                                $rootScope.sessionUser = user;
                                $rootScope.$apply();
                            },
                            error: function(user, error) {}
                        });
                    }

                }, 1000)
        };
    }];

    directives.ngLimitations = ['$rootScope', function($rootScope){
        return function(scope, element, attrs) {
            $(element).popover({
                content: "Please enter an amount between $50,000 - $5,000,000",
                placement: "top",
                trigger: "manual"
            });

            var showed = false;

            setInterval(function(){

                if(element.val().length>0 && !$rootScope.isFocoused2){

                    var val = parseInt(element.val().replace(/\$|,/g,''));

                    if((val<50000 || val>5000000) && !showed){
//                        $(element).popover('show').addClass("ng-invalid");
                        $(element).addClass("ng-invalid");
                        showed = true;
                    }

                    if(val<=5000000 && val>=50000 && showed){
//                        $(element).popover('hide').removeClass("ng-invalid");
                        $(element).removeClass("ng-invalid");
                        showed = false;
                    }
                }
            }, 1000);

            $(element).on("mouseenter", function() {
                if($(this).hasClass("ng-invalid"))
                    $(element).popover('show');

            }).on("mouseleave", function() {
                    $(element).popover('hide');
            });

            element.bind("keypress", function(event) {
                    var key = (event.which) ? event.which : event.keyCode;
                    var val = parseInt(element.val().replace(/\$|,/g,''));

                    if(val>5000000 && !showed){
                        $(element).addClass("ng-invalid");
                        showed = true;
                        if( key != 8 && key != 46 )
                            return false;
                    }

                    if(val<=5000000 && showed){
                        $(element).removeClass("ng-invalid");
                        showed = false;
                    }

            });

            element.bind("blur", function() {
                var val = parseInt(element.val().replace(/\$|,/g,''));

                if(val>5000000 && !showed){
                    $(element).addClass("ng-invalid");
                    showed = true;
                }

                if(val<=5000000 && showed){
                    $(element).removeClass("ng-invalid");
                    showed = false;
                }

                if(val<50000)
                    $(element).addClass("ng-invalid");
                else if(val>=50000 && val<=5000000)
                    $(element).removeClass("ng-invalid");
            });
        };
    }];
    directives.ngLimitations2 = [function(){
        return {
            restrict: 'A',
            scope:true,
            require: 'ngModel',
            link: function (scope, element , attrs,control) {
                $(element).popover({
                    content: "Mortgage amount must be less than 80% of the total estimated value",
                    placement: "top",
                    trigger: "manual"
                });

                var showed = false;

                setInterval(function(){
// maybe need to check if things are null before using .length
				var ngModelLength = false;
                     if(typeof attrs.ngModel != "undefined" && typeof attrs.ngLimitations2 != "undefined" && scope.$eval(attrs.ngModel) != null && scope.$eval(attrs.ngLimitations2) != null && scope.$eval(attrs.ngModel).length>0 && scope.$eval(attrs.ngLimitations2).length>0){
                        var e1 = parseInt(scope.$eval(attrs.ngModel).replace(/\$|,/g,''));
                        var e2 = parseInt(scope.$eval(attrs.ngLimitations2).replace(/\$|,/g,''));
                        var val = e2*0.8;

                        if(val<e1 && !showed){
                            $(element).addClass("ng-invalid");
                            showed = true;
                        }

                        if(val>=e1 && showed){
                            $(element).removeClass("ng-invalid");
                            showed = false;
                        }
                    }
                }, 1000);

                $(element).on("mouseenter", function() {
                    if($(this).hasClass("ng-invalid"))
                        $(element).popover('show');

                }).on("mouseleave", function() {
                        $(element).popover('hide');
                    });

                element.bind("keypress", function(event) {
                    if(typeof attrs.ngModel != "undefined" && typeof attrs.ngLimitations2 != "undefined" && scope.$eval(attrs.ngModel).length>0 && scope.$eval(attrs.ngLimitations2).length>0){
                    var key = (event.which) ? event.which : event.keyCode;
                    var e1 = parseInt(scope.$eval(attrs.ngModel).replace(/\$|,/g,''));
                    var e2 = parseInt(scope.$eval(attrs.ngLimitations2).replace(/\$|,/g,''));

                    var val = e2*0.8;

                    if(val<e1 && !showed){
                        $(element).addClass("ng-invalid");
                        showed = true;
                        if( key != 8 && key != 46 )
                            return false;
                    }

                    if(val>=e1 && showed){
                        $(element).removeClass("ng-invalid");
                        showed = false;
                    }
                    }
                });

                element.bind("blur", function() {
                    if(typeof attrs.ngModel != "undefined" && typeof attrs.ngLimitations2 != "undefined" && scope.$eval(attrs.ngModel).length>0 && scope.$eval(attrs.ngLimitations2).length>0){
                    var e1 = parseInt(scope.$eval(attrs.ngModel).replace(/\$|,/g,''));
                    var e2 = parseInt(scope.$eval(attrs.ngLimitations2).replace(/\$|,/g,''));

                    var val = e2*0.8;

                    if(val<e1 && !showed){
                        $(element).addClass("ng-invalid");
                        showed = true;
                    }

                    if(val>=e1 && showed){
                        $(element).removeClass("ng-invalid");
                        showed = false;
                    }

                    if(val<e1)
                        $(element).addClass("ng-invalid");
                    else if(val>=e1)
                        $(element).removeClass("ng-invalid");
                    }
                });
            }
        }
    }];
    directives.isRole = ['$rootScope',function($rootScope){
        return function(scope, element, attrs) {
            $rootScope.userHandler.checkAccess(attrs.isRole).then(function(rsp){
                if(!rsp)
                    element.addClass("ng-hide");
                else
                    element.removeClass("ng-hide");
            });
        };
    }];
    directives.isNotRole = ['$rootScope',function($rootScope){
        return function(scope, element, attrs) {
            $rootScope.userHandler.checkAccess(attrs.isNotRole).then(function(rsp){
                if(rsp)
                    element.addClass("ng-hide");
                else
                    element.removeClass("ng-hide");
            });
        };
    }];
    directives.popOver = [function(){
        return function(scope, element, attrs) {
            $(element).popover({
                title: attrs.title,
                content: attrs.content,
                trigger: attrs.trigger,
                placement: attrs.placement
            })
        };
    }];
    directives.ngCalendar = [function(){
        return function(scope, element, attrs) {
            $(element).datepicker({
                startview: attrs.view,
                format: 'mm/dd/yyyy',
                autoclose: true
            });

            $(element).on("change", function(){
                scope.$apply();
            });
        };
    }];
    directives.ngYearslimit = [function(){
        return function(scope, element, attrs) {
            $(element).popover({
                content: "The applicant must be 18 years of age or older to apply",
                placement: "top",
                trigger: "manual",
                template: '<div style="width: 300px" class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
            });

            setTimeout(function(){
                if($(element).val().length > 0){
                var isLimited = new Date().getFullYear() - $(element).val() >= 18;
                if(!isLimited)
                    $(element).addClass('ng-invalid');
                else
                    $(element).removeClass('ng-invalid');
                }
                else
                    $(element).addClass('ng-invalid');
            }, 3000);

            $(element).on("mouseenter", function() {
                if($(this).hasClass("ng-invalid"))
                    $(element).popover('show');

            }).on("mouseleave", function() {
                    $(element).popover('hide');
                });

            $(element).on("change", function(){
                var isLimited = new Date().getFullYear() - $(element).val() >= 18;
                if(!isLimited)
                    $(element).addClass('ng-invalid');
                else
                    $(element).removeClass('ng-invalid');
            });
        };
    }];

    directives.ngDownPaymentTip = ['$rootScope', function($rootScope){
        return function(scope, element, attrs) {

            $(element).popover({
                content: "Most lenders require a minimum of ten days’ notice, prior to closing. A DYOM representative will contact you to review your options.",
                placement: "top",
                trigger: "manual"
            });

            $(element).on("mouseenter", function() {
                if($(this).hasClass("ng-invalid"))
                    $(element).popover('show');

            }).on("mouseleave", function() {
                $(element).popover('hide');
            });
        };
    }];

    directives.ngClosingdate = ['$rootScope', function($rootScope){
        return function(scope, element, attrs) {

            $(element).popover({
                content: "Most lenders require a minimum of ten days’ notice, prior to closing. A DYOM representative will contact you to review your options.",
                placement: "top",
                trigger: "manual"
            });

            $(element).on("mouseenter", function() {
                if($(this).hasClass("ng-invalid"))
                    $(element).popover('show');

            }).on("mouseleave", function() {
                    $(element).popover('hide');
                });

            $(element).on("change", function(){
                var val = $(this).val().split("/");
                var selectedTimestamp = new Date(val[2], val[0] - 1, val[1]).getTime();
                var timestamp = new Date();

                var b = 1;
                var c = 0;
                for(var i=0; i<30; i++){
                    if(b<16){
                        var myDate = new Date(timestamp);
                        myDate.setDate(timestamp.getDate()+i);

                        if(myDate.getDay() != 6 && myDate.getDay() != 0)
                            b++;

                        c++;
                    }
                }

                timestamp = new Date().getTime() + (c * 24 * 60 * 60 * 1000);

                if(selectedTimestamp < timestamp) {
                    $(element).addClass("invalid");
                    $rootScope.$apply(function(){
                        $rootScope.closeDate = false;
                    });
                }
                else {
                    $(element).removeClass("invalid");
                    $rootScope.$apply(function(){
                        $rootScope.closeDate = true;
                    });
                }


            }).on("focus", function(){
                    $(element).popover('hide');
            });



            $(element).datepicker({
                startview: attrs.view,
                format: 'mm/dd/yyyy',
                autoclose: true,
                startDate: '1d'
            })
        };
    }];
    directives.ngCurrency = ['$filter', function($filter){
        return function(scope, element, attrs) {
            element.bind("keypress", function(e) {
                if (e.which != 8 && e.which != 36 && e.which != 46 && e.which != 44 && e.which != 0 && (e.which < 48 || e.which > 57))
                    return false;
            });

            element.bind("change input", function(){
                if(element.val().length>1)
                    element.val($filter('noFractionCurrency')(element.val().replace(/\$|,/g,'')));
                else if(element.val().length<2)
                   element.val("$"+element.val().replace(/\$|,/g,''));
            });

        };
    }];
    directives.ngLimitiinc = ['$filter', function($filter){
        return function(scope, element, attrs) {
            element.bind("keydown", function(e) {
                e = e || window.event;
                var charCode = (typeof e.which == "number") ? e.which : e.keyCode;

                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                    // Allow: Ctrl+A
                    (e.keyCode == 65 && e.ctrlKey === true) ||
                    // Allow: home, end, left, right, down, up
                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                    // let it happen, don't do anything
                    return;
                }

                // Ensure that it is a number and stop the keypress
                if (((e.shiftKey || (charCode < 48 || charCode > 57)) && (charCode < 96 || charCode > 105)) || element.val().length>=10)
                    e.preventDefault();

            });
        };
    }];
    directives.ngPostal = [function(){
        return function(scope, element, attrs) {

            element.bind("keyup keypress", function(e) {

                e = e || window.event;
                var charCode = (typeof e.which == "number") ? e.which : e.keyCode;

                element.val( element.val().toUpperCase() );

                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                    // Allow: Ctrl+A
                    (e.keyCode == 65 && e.ctrlKey === true) ||
                    // Allow: home, end, left, right, down, up
                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                    // let it happen, don't do anything
                    return;
                }

                if(element.val().length==3 && e.which != 8 && e.which != 46)
                    element.val(element.val()+" ");

                if ( (element.val().length==1 || element.val().length==4 || element.val().length==6)
                    && (charCode > 31 && (charCode < 48 || charCode > 57)) )
                    return false;

                if ( (element.val().length==0 || element.val().length==2 || element.val().length==5 || element.val().length==7)
                    && ( charCode > 31 && (charCode < 65 || charCode > 90) &&
                    (charCode < 97 || charCode > 122)) )
                    return false;

                if(element.val().length>=7)
                    return false;
            });

        };
    }];
    directives.ngPhone = ['$filter', function($filter){
        return function(scope, element, attrs) {
            element.bind("keydown  keypress", function(e) {
                e = e || window.event;
                var charCode = (typeof e.which == "number") ? e.which : e.keyCode;

                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                    // Allow: Ctrl+A
                    (e.keyCode == 65 && e.ctrlKey === true) ||
                    // Allow: home, end, left, right, down, up
                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                    // let it happen, don't do anything
                    return;
                }

                // Ensure that it is a number and stop the keypress
                if (((e.shiftKey || (charCode < 48 || charCode > 57)) && (charCode < 96 || charCode > 105)) || element.val().length>=14)
                    e.preventDefault();

                if(element.val().length==0 && e.which != 8 && e.which != 46)
                    element.val("("+element.val());

                if(element.val().length==4 && e.which != 8 && e.which != 46)
                    element.val(element.val()+") ");

                if(element.val().length==9 && e.which != 8 && e.which != 46)
                    element.val(element.val()+" ");

            });

        };
    }];
    directives.ngMls = ['$filter', function($filter){
        return function(scope, element, attrs) {
            element.bind("keydown  keypress", function(e) {
                if(element.val().length>7) {
                    e.preventDefault();
                    return false;
                }

            });
        };
    }];
    directives.ngSin = ['$filter', function($filter){
        return function(scope, element, attrs) {
            element.bind("keydown  keypress", function(e) {

                e = e || window.event;
                var charCode = (typeof e.which == "number") ? e.which : e.keyCode;

                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                    // Allow: Ctrl+A
                    (e.keyCode == 65 && e.ctrlKey === true) ||
                    // Allow: home, end, left, right, down, up
                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                    // let it happen, don't do anything
                    return;
                }

                if (((e.shiftKey || (charCode < 48 || charCode > 57)) && (charCode < 96 || charCode > 105)) || element.val().length>=11)
                    e.preventDefault();

                if(element.val().length==3 && e.which != 8 && e.which != 46)
                    element.val(element.val()+"-");

                if(element.val().length==7 && e.which != 8 && e.which != 46)
                    element.val(element.val()+"-");
            });

        };
    }];
    directives.ngPercentage = [function(){
        return function(scope, element, attrs) {

            element.bind("keypress", function(e) {
                if (e.which != 8 && e.which != 36 && e.which != 46 && e.which != 44 && e.which != 0 && (e.which < 48 || e.which > 57))
                    return false;

                if(element.val().length==8)
                    return false;
            });

            element.bind("keydown", function(e) {
                var key = event.keyCode || event.charCode;

                if( key == 8 || key == 46 )
                    element.val(element.val().substring(0, element.val().length-1));
            });

            element.bind("change input", function(){

                var strLength= element.val().length;
                if(strLength>1)
                    element.val(element.val().replace(/%/g,'')+"%");
                else if(strLength<2)
                    element.val(element.val().replace(/%/g,'')+"%");
            });

        };
    }];
    directives.scrollAnimate = [function(){
        return function(scope, element, attrs) {
            $(window).scroll(function() {
               if($(element).visible(true))
                    element.addClass(attrs.scrollAnimate);
            });
        };
    }];
    directives.navCheck = ['$rootScope', '$location', function($rootScope, $location){
        return function(scope, element, attrs) {
            $(window).scroll(function() {
                if($(window).scrollTop()>30)
                    element.addClass("nav-scrolled");
                else
                    element.removeClass("nav-scrolled");
            });

            function check(){
                if($location.path() == "/" || $location.path() == "/become-partner" || $location.path() == "/contact-us" || $location.path() == "/how-it-works")
                    element.removeClass("appl-nav");
                else
                    element.addClass("appl-nav");
            }

            $rootScope.$on("$routeChangeSuccess", function (event, next, current) {
                check();
            });
        };
    }];
    directives.ngFixedbox = [function(){
        return function(scope, element, attrs) {
            $(window).scroll(function() {
                if($(window).scrollTop()>100) {
                    element.addClass("fixedBox");
                    element.css("top", $(window).scrollTop()-82);
                }
                else
                    element.removeClass("fixedBox");
            });
        };
    }];
    directives.ngNav = [function() {
        return {
            replace: true,
            restrict: 'A',
            templateUrl: 'resources/views/nav.html'
        }
    }];
    directives.ngModalst = [function() {
        return {
            replace: true,
            restrict: 'A',
            templateUrl: 'resources/views/modals.html'
        }
    }];
    directives.ngFoot = [function() {
        return {
            replace: true,
            restrict: 'A',
            templateUrl: 'resources/views/foot.html'
        }
    }];
    directives.ngLike = ['$timeout', function($timeout){
        return function($scope, element, attr){
            var start = function(){
                var html = '<div class="fb-like" data-href="https://www.facebook.com/doyourownmortgage" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>';
                $(element).html(html)
                FB.XFBML.parse(element.parent()[0]);
            };

            $timeout(start,1000);
        };
    }];
    directives.twitter = ['$timeout', function($timeout){
        return {
            link: function(scope, element, attr) {
                var start =  function() {
                    twttr.widgets.createFollowButton(
                        attr.url,
                        element[0],
                        function(el) {}, {
                            count: 'none'
                        }
                    );
                };

                $timeout(start,1000);
            }
        }
    }];
    directives.passwordMatch = [function () {
        return {
            restrict: 'A',
            scope:true,
            require: 'ngModel',
            link: function (scope, elem , attrs,control) {
                var checker = function () {


                    var e1 = scope.$eval(attrs.ngModel);

                    var e2 = scope.$eval(attrs.passwordMatch);
                    return e1 == e2;
                };
                scope.$watch(checker, function (n) {
                    control.$setValidity("unique", n);
                });
            }
        };
    }];
    directives.closeOut = ['$rootScope', '$document', function ($rootScope, $document){
        return {
            restrict: 'A',
            link: function (scope, element, attr) {

                function onDocumentClick()
                {
                    scope.togleDrop3  = false;
                    $document.unbind('click', onDocumentClick);
                    scope.$apply();
                }

                element.bind('click', function (event){
                    event.stopPropagation();
                    $document.bind('click', onDocumentClick);
                });

            }
        };
    }];
    directives.selectOnClick = [ function() {
        return {
            restrict: 'A',
            link: function (scope, element, attrs) {
                element.on('click', function () {
                    this.select();
                });
            }
        };
    }];
    directives.ngUnique = ['$rootScope',function($rootScope){
        return {
            restrict: 'A',
            require: 'ngModel',
            link: function (scope, element, attrs, ngModel) {
                element.bind('blur', function (e) {
                    if (!ngModel || !element.val()) return;
                    var currentValue = element.val();
                    $rootScope.userHandler.checkUniq(currentValue).then(
                        function(unique){
                            if (currentValue == element.val()) {
                                ngModel.$setValidity('unique', unique);
                            }
                        }
                    );
                });
            }
        }
    }];
    directives.ngUniquetype = ['$rootScope', '$timeout', function($rootScope, $timeout){
        return {
            restrict: 'A',
            require: 'ngModel',
            link: function (scope, element, attrs, ngModel) {
                var checkMail;
                element.bind("keypress", function(){
                    $timeout.cancel(checkMail);

                    checkMail = $timeout(function() {
                        if (!ngModel || !element.val()) return;
                        var currentValue = element.val();
                        $rootScope.userHandler.checkUniq(currentValue).then(
                            function(unique){
                                if (currentValue == element.val()) {
                                    ngModel.$setValidity('unique', unique);
                                }
                            }
                        );
                    }, 200);

                });
                element.bind('blur', function () {
                    if (!ngModel || !element.val()) return;
                    var currentValue = element.val();
                    $rootScope.userHandler.checkUniq(currentValue).then(
                        function(unique){
                            if (currentValue == element.val()) {
                                ngModel.$setValidity('unique', unique);
                            }
                        }
                    );
                });

            }
        }
    }];
    directives.ngExist = ['$rootScope',function($rootScope){
        return {
            restrict: 'A',
            require: 'ngModel',
            link: function (scope, element, attrs, ngModel) {
                element.bind('blur', function (e) {
                    if (!ngModel || !element.val()) return;
                    var currentValue = element.val();
                    $rootScope.userHandler.checkUniq(currentValue).then(
                        function(unique){
                            unique = !unique;
                            if (currentValue == element.val()) {
                                ngModel.$setValidity('unique', unique);
                            }
                        }
                    );
                });
            }
        }
    }];

// ==== REGISTER DIRECTIVES IN ANGULAR APP
    app.directive(directives);

});