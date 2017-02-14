define(['app', 'controllers/controllers', 'services/services'], function (app) {
    return app.config(['$routeProvider', '$locationProvider',
        function($routeProvider, $locationProvider ) {
            $routeProvider.
                when('/debug', {
                    templateUrl: 'resources/views/debug.html',
                    controller: 'DebugCtrl',
                    authenticate: false
                }).
                when('/', {
                    templateUrl: 'resources/views/landing.html',
                    controller: 'LandingCtrl',
                    authenticate: false
                }).
                when('/r/:id', {
                    templateUrl: 'resources/views/landing.html',
                    controller: 'LandingCtrl',
                    authenticate: false
                }).
                when('/apply-now', {
                    templateUrl: 'resources/views/application.html',
                    controller: 'ApplicationCtrl',
                    authenticate: false,
                    role: false
                }).
                when('/dashboard', {
                    templateUrl: 'resources/views/dashboard.html',
                    controller: 'DashboardCtrl',
                    authenticate: true,
                    role: false
                }).
                when('/dashboard/:id', {
                    templateUrl: 'resources/views/dashboard.html',
                    controller: 'DashboardCtrl',
                    authenticate: true,
                    role: false
                }).
                when('/dashboard/:id/:secId', {
                    templateUrl: 'resources/views/dashboard.html',
                    controller: 'DashboardCtrl',
                    authenticate: true,
                    role: false
                }).
                when('/application/:id', {
                    templateUrl: 'resources/views/admin.html',
                    controller: 'AdminCtrl',
                    authenticate: true,
                    role: "Administrator"
                }).
                when('/how-it-works', {
                    templateUrl: 'resources/views/works.html',
                    controller: 'StaticCtrl',
                    authenticate: false
                }).
                when('/contact-us', {
                    templateUrl: 'resources/views/contact-us.html',
                    controller: 'ContactUsController',
                    authcontente: false
                }).
                when('/privacy', {
                    templateUrl: 'resources/views/privacy.html',
                    controller: 'StaticCtrl',
                    authenticate: false
                }).
                when('/become-partner', {
                    templateUrl: 'resources/views/becomePartner.html',
                    controller: 'StaticCtrl',
                    authenticate: false
                }).
                when('/disclaimer', {
                    templateUrl: 'resources/views/disclaimer.html',
                    controller: 'StaticCtrl',
                    authenticate: false
                }).
                otherwise({
                    redirectTo: '/',
                    authenticate: false
                });

            $locationProvider
                .html5Mode(true)
                .hashPrefix('!');
        }]);
});
