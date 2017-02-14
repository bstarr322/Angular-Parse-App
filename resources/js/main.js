'use strict';

require.config({
    urlArgs: "vol=150513",
    waitSeconds: 5000,
    paths: {
        jquery: 'libs/jquery/jquery.min',
        jqueryui: '//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min',
        jqueryVisible: 'libs/jquery/jquery.visible.min',
        bootstrap: 'libs/bootstrap/bootstrap.min',
        facebook: 'https://connect.facebook.net/en_US/all',
        twitter: 'https://platform.twitter.com/widgets',
        angular: 'libs/angularjs/angular.min',
        angularRoute: 'libs/angularjs/angular-route.min',
        angularResource: 'libs/angularjs/angular-resource.min',
        angularAnimate: 'libs/angularjs/angular-animate.min',
        angularSanitate: 'libs/angularjs/angular-sanitize.min',
        angularTouch: 'libs/angularjs/angular-touch.min',
        angularitics: 'libs/angularjs/angulartics',
        angulariticsGa: 'libs/angularjs/angulartics-ga',
        datePicker: 'libs/bootstrap/bootstrap-datepicker',
        moment: 'libs/moment.min',
        livestamp: 'libs/livestamp.min',
        parse: 'libs/parse.min',
        pars: 'pars',
        googleAnalytics:   [
            "https://www.google-analytics.com/analytics",
            'libs/js/google-analytics'
        ]
    },
    baseUrl: 'resources/js/',
    shim: {
        'jquery': { exports: 'jQuery' },
        'jqueryui': ['jquery'],
        'jqueryVisible': ['jquery'],
        'bootstrap': ['jquery'],
        'facebook' : { exports: 'FB', dep: ['parse']},
        'twitter' : { exports: 'twttr'},
        'angular': { exports: 'angular' },
        'angularRoute': ['angular'],
        'angularResource': ['angular'],
        'angularAnimate': ['angular'],
        'angularSanitate': ['angular'],
        'angularTouch': ['angular'],
        angularitics: ['angular'],
        angulariticsGa: ['angular'],
        'datePicker': ['angular', 'bootstrap'],
        'moment': { exports: 'moment' },
        'livestamp': ['jquery', 'moment'],
        'parse': { exports: 'Parse' },
        'pars':   ['parse', 'facebook'],
        'googleAnalytics':  { exports: "ga" }
    },
    priority: [
        'jquery',
        'angular',
        'parse',
        'twitter',
        "facebook"
    ]
});

require([
    'jquery',
    'angular',
    'pars',
    'twitter',
    'eventbus',
    'app',
    'conf',
    'routes',
    'controllers/controllers',
    'services/services',
    'directives/directives',
    'filters/filters'
], function ($, angular, FB, Parse, twttr) {

    $(function () {
        angular.bootstrap(document, ['app']);
    });

});