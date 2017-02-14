define([
    'angularRoute',
    'angularResource',
    'angularAnimate',
    'angularSanitate',
    'angularTouch',
    'angularitics',
    'angulariticsGa'
], function () {
    return angular.module("app", [
        'ngRoute',
        'ngResource',
        'ngAnimate',
        'ngSanitize',
        'ngTouch',
        'angulartics',
        'angulartics.google.analytics'
    ]);
});