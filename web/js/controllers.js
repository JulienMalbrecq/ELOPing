var pingControllers = angular.module('pingControllers', []);

pingControllers.controller('PingPlayersCtrl', function ($scope, $rootScope, $location) {
    var playerSeparator = 'et',
        teamSeparator = 'contre';

    $scope.playerInput = "";
    $scope.players = [
        {
            name: 'Julien',
            rating: 1400
        },
        {
            name: 'Vincent',
            rating: 1400
        },
        {
            name: 'Fred',
            rating: 1400
        },
        {
            name: 'Mike',
            rating: 1400
        },
        {
            name: 'Nicolas',
            rating: 1400
        },
        {
            name: 'Nancy',
            rating: 1400
        },
        {
            name: 'Laetitia',
            rating: 1400
        },
        {
            name: 'Tony',
            rating: 1400
        },
        {
            name: 'Sandrine',
            rating: 1400
        }
    ];

    var parseTeams = function (playerString) {
            var teams = [],
                teamStrings = parsePlayerString(playerString),
                i = 0;

            for (; i < 2; i += 1) {
                teams[teams.length] = parseTeamPlayers(teamStrings[i]);
            }

            checkDuplicates(teams);
            return teams;
        },

        checkDuplicates = function (teams) {
            var players = teams[0].concat(teams[1]).sort(function (a, b) { return a.name < b.name ? -1 : 1 }),
                i = 0,
                total = players.length - 1;

            for (; i < total; i += 1) {
                if (players[i].name === players[i+1].name) {
                    throw players[i].name + " ne peut pas jouer dans les deux équipes.";
                }
            }
        },

        parsePlayerString = function (playerString) {
            var teams = playerString.split(' ' + teamSeparator + ' ');

            if (teams.length !== 2) {
                throw "Choisi au moins un adversaire";
            }

            return teams;
        },

        parseTeamPlayers = function (teamString) {
            var players = [],
                playerNames = teamString.split(' ' + playerSeparator + ' ');

            playerNames.forEach(function (name) {
                var found = $scope.players.filter(function (current) {
                    return current.name.toLowerCase() === name.toLowerCase();
                });

                if (found.length !== 1) {
                    throw "Je ne connais pas " + name;
                }

                players = players.concat(found);
            });

            return players;
        };

    $scope.selectPlayers = function () {
        $scope.error = null;

        try {
            $rootScope.teams = parseTeams($scope.playerInput);
            $location.url('/counter');
        } catch (e) {
            $scope.error = e;
        }
    }
});

pingControllers.controller('PingCounterCtrl', function ($scope, $rootScope, $location) {
    if ($scope.teams === undefined) {
        $location.url('/');
    }

    var pointPerSet = 11,
        selectSetWinner = function (team) {
            resetScores();
            team.set += 1;

            if (team.set === 2) {
                $scope.match.winnersTeam = team;
                $rootScope.match = $scope.match;
                $location.url('/winner');
            }
        },

        saveHistoryState = function () {
            $scope.history.push(angular.copy($scope.match));
        },

        resetScores = function () {
            $scope.match.teamA.score = 0;
            $scope.match.teamB.score = 0;

            $scope.match.serviceTeam = $scope.firstServiceTeam === $scope.match.teamA
                ? $scope.match.teamB
                : $scope.match.teamA;
        },

        isTieBreak = function () {
            return $scope.match.teamA.score > pointPerSet - 2 && $scope.match.teamB.score > pointPerSet - 2;
        },

        updateSetWinner = function () {
            var diff = $scope.match.teamA.score - $scope.match.teamB.score;

            if (isTieBreak()) {
                if (diff === 2) {
                    selectSetWinner($scope.match.teamA);
                    return true;
                } else if (diff === -2) {
                    selectSetWinner($scope.match.teamB);
                    return true;
                }
            } else {
                if ($scope.match.teamA.score === pointPerSet) {
                    selectSetWinner($scope.match.teamA);
                    return true;
                } else if ($scope.match.teamB.score === pointPerSet) {
                    selectSetWinner($scope.match.teamB);
                    return true;
                }
            }

            return false;
        },

        updateService = function () {
            var totalPoints = $scope.match.teamA.score + $scope.match.teamB.score;
            if (!isTieBreak() && totalPoints % 2 === 1) {
                return;
            }

            $scope.match.serviceTeam = $scope.match.serviceTeam === $scope.match.teamA
                ? $scope.match.teamB
                : $scope.match.teamA;
        };

    $scope.history = [];
    $scope.match = {
        teamA: {
            name: 'Team Red',
            score: 0,
            set: 0,
            players: $scope.teams[0],
            playerNames: $scope.teams[0].map(function (player) { return player.name }).join(' et ')
        },

        teamB: {
            name: 'Team Purple',
            score: 0,
            set: 0,
            players: $scope.teams[1],
            playerNames: $scope.teams[1].map(function (player) { return player.name }).join(' et ')
        }
    };

    $scope.addPoint = function (team) {
        if (!$scope.match.serviceTeam) {
            $scope.firstServiceTeam = team;
            $scope.match.serviceTeam = team;
        } else {
            team.score += 1;
            updateSetWinner() || updateService();
        }

        saveHistoryState();
    };

    $scope.undo = function () {
        if ($scope.history.length === 1) {
            return;
        }

        $scope.history.pop();
        $scope.match = angular.copy($scope.history[$scope.history.length-1]);
    };

    saveHistoryState();
});
pingControllers.controller('PingWinnerCtrl', function ($scope, $rootScope, $location) {
    if ($scope.match === undefined) {
        $location.url('/');
    }
});