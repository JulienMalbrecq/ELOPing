var pingApp = angular.module('pingApp', [
    'ngRoute',
    'ngTouch',
    'pingControllers'
]);

pingApp.config(['$routeProvider',
    function($routeProvider) {
        $routeProvider.
            when('/', {
                templateUrl: 'partials/players.html',
                controller: 'PingPlayersCtrl'
            }).
            when('/counter', {
                templateUrl: 'partials/counter.html',
                controller: 'PingCounterCtrl'
            }).
            when('/winner', {
                templateUrl: 'partials/winner.html',
                controller: 'PingWinnerCtrl'
            }).
            otherwise({
                redirectTo: '/counter'
            });
        }
    ]).
    directive('team', function() {
        return {
            restrict: 'E',
            scope: {
                team: '=model',
                addPoint: '&'
            },
            templateUrl: 'partials/tags/team.html'
        };
    });