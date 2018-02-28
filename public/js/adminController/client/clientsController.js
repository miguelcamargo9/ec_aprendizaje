/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var appClient = angular.module('appClient', ['ngSanitize', 'ui.select'], function ($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

/**
 * AngularJS default filter with the following expression:
 * "person in people | filter: {name: $select.search, age: $select.search}"
 * performs an AND between 'name: $select.search' and 'age: $select.search'.
 * We want to perform an OR.
 */
appClient.filter('propsFilter', function () {
    return function (items, props) {
        var out = [];

        if (angular.isArray(items)) {
            var keys = Object.keys(props);

            items.forEach(function (item) {
                var itemMatches = false;

                for (var i = 0; i < keys.length; i++) {
                    var prop = keys[i];
                    var text = props[prop].toLowerCase();
                    if (item[prop].toString().toLowerCase().indexOf(text) !== -1) {
                        itemMatches = true;
                        break;
                    }
                }

                if (itemMatches) {
                    out.push(item);
                }
            });
        } else {
            // Let the output be the input untouched
            out = items;
        }

        return out;
    };
});

appClient.controller('clientsCtrl', ['$scope', 'clientsFactory', '$timeout', '$window', function ($scope, clientsFactory, $timeout, $window) {
        $scope.error = {};

        $scope.children = [{
                error: {}
            }];

        $scope.addNewChild = function () {
            $scope.children.push({
                error: {}
            });
        };

        $scope.removeNewChild = function (index) {
            if (index !== 0) {
                $scope.children.splice(index, 1);
            }
        };

        $scope.showAddChild = function (child) {
            return child.id === $scope.children[$scope.children.length - 1].id;
        };

        $scope.dateFormat = function (date) {
            var year = date.getFullYear();
            var month = date.getMonth() + 1;
            var dt = date.getDate();

            if (dt < 10) {
                dt = '0' + dt;
            }
            if (month < 10) {
                month = '0' + month;
            }

            return year + '-' + month + '-' + dt;
        };

        $scope.createClient = function () {
            clientsFactory.createClient($scope.name, $scope.lastname, $scope.identification_number, $scope.email, $scope.namesecond,
                    $scope.lastnamesecond, $scope.identification_number_second, $scope.email_second, $scope.children).success(function (data) {
                if (data.success) {
                    $scope.success = data.msj;
                    $timeout(function () {
                        $window.location.href = '/admin/client/list';
                    }, 2000);
                } else {
                    $scope.error.msjs = data;
                }
            });
        };

        $scope.editClient = function () {
            clientsFactory.editClient($scope.idfather, $scope.iduser, $scope.idusertwo, $scope.name, $scope.lastname, $scope.identification_number, $scope.email,
                    $scope.namesecond, $scope.lastnamesecond, $scope.identification_number_second, $scope.email_second, $scope.children).success(function (data) {
                if (data.success) {
                    $scope.success = data.msj;
                    $timeout(function () {
                        $window.location.href = '/admin/client/list';
                    }, 2000);
                } else {
                    $scope.error.msjs = data;
                }
            });
        };

        $scope.deleteClient = function () {
            clientsFactory.deleteClient($scope.idfather, $scope.iduser, $scope.idusertwo).success(function (data) {
                if (data.success) {
                    $scope.success = data.msj;
                    $timeout(function () {
                        $window.location.href = '/admin/client/list';
                    }, 2000);
                } else {
                    $scope.error.msjs = data;
                }
            });
        };

        $scope.validate = function (action) {
            $scope.error = {};
            $scope.noerror = true;
            if (!$scope.name) {
                $scope.error.name = true;
                $scope.noerror = false;
            }
            if (action === 'add') {
                if (!$scope.lastname) {
                    $scope.error.lastname = true;
                    $scope.noerror = false;
                }
            }
            if (!$scope.identification_number) {
                $scope.error.identification_number = true;
                $scope.noerror = false;
            }
            if (!$scope.email) {
                $scope.error.email = true;
                $scope.noerror = false;
            }
            if (($scope.lastnamesecond || $scope.identification_number_second || $scope.email_second) && !$scope.namesecond) {
                $scope.error.namesecond = true;
                $scope.namesecond = false;
            }
            if (action === 'add') {
                if (($scope.namesecond || $scope.identification_number_second || $scope.email_second) && !$scope.lastnamesecond) {
                    $scope.error.lastnamesecond = true;
                    $scope.noerror = false;
                }
            }
            if (($scope.namesecond || $scope.lastnamesecond || $scope.email_second) && !$scope.identification_number_second) {
                $scope.error.identification_number_second = true;
                $scope.noerror = false;
            }
            if (($scope.namesecond || $scope.lastnamesecond || $scope.identification_number_second) && !$scope.email_second) {
                $scope.error.email_second = true;
                $scope.noerror = false;
            }
            if (action === 'edit') {
                if (!$scope.namesecond && !$scope.identification_number_second && !$scope.email_second && !$scope.lastnamesecond) {
                    delete $scope.namesecond;
                    delete $scope.identification_number_second;
                    delete $scope.email_second; 
                    delete $scope.lastnamesecond;
                }
            }

            angular.forEach($scope.children, function (child, key) {
                if (!child.name) {
                    child.error.name = true;
                    child.noerror = false;
                }
            });

            if ($scope.noerror) {
                if (action === 'add') {
                    $scope.createClient();
                }
                if (action === 'edit') {
                    $scope.editClient();
                }
            }
        };
    }]);


