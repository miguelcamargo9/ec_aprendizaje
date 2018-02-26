/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var appTutor = angular.module('appTutor', ['ngSanitize', 'ui.select'], function ($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

/**
 * AngularJS default filter with the following expression:
 * "person in people | filter: {name: $select.search, age: $select.search}"
 * performs an AND between 'name: $select.search' and 'age: $select.search'.
 * We want to perform an OR.
 */
appTutor.filter('propsFilter', function () {
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

appTutor.controller('tutorsCtrl', ['$scope', 'tutorsFactory', '$timeout', '$window', function ($scope, tutorsFactory, $timeout, $window) {
        $scope.error = {};

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

        $scope.createTutor = function () {
            tutorsFactory.createTutor($scope.name, $scope.lastname, $scope.identification_number, $scope.email, $scope.university,
                    $scope.degree, $scope.semester, $scope.valxhour, $scope.mobile, $scope.accountnumber).success(function (data) {
                if (data.success) {
                    $scope.success = data.msj;
                    $timeout(function () {
                        $window.location.href = '/admin/tutors/list';
                    }, 2000);
                } else {
                    $scope.error.msjs = data;
                }
            });
        };

        $scope.editTutor = function () {
            tutorsFactory.editTutor($scope.idtutor, $scope.iduser, $scope.name, $scope.identification_number, $scope.email, $scope.university,
                    $scope.degree, $scope.semester, $scope.valxhour, $scope.mobile, $scope.accountnumber).success(function (data) {
                if (data.success) {
                    $scope.success = data.msj;
                    $timeout(function () {
                        $window.location.href = '/admin/tutors/list';
                    }, 2000);
                } else {
                    $scope.error.msjs = data;
                }
            });
        };


        $scope.deleteTutor = function () {
            tutorsFactory.deleteTutor($scope.idtutor, $scope.iduser).success(function (data) {
                if (data.success) {
                    $scope.success = data.msj;
                    $timeout(function () {
                        $window.location.href = '/admin/tutors/list';
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
            if (!$scope.university) {
                $scope.error.university = true;
                $scope.noerror = false;
            }
            if (!$scope.degree) {
                $scope.error.degree = true;
                $scope.noerror = false;
            }
            if (!$scope.semester) {
                $scope.error.semester = true;
                $scope.noerror = false;
            }
            if (!$scope.valxhour) {
                $scope.error.valxhour = true;
                $scope.noerror = false;
            }
            if (!$scope.mobile) {
                $scope.error.mobile = true;
                $scope.noerror = false;
            }
            if (!$scope.accountnumber) {
                $scope.error.accountnumber = true;
                $scope.noerror = false;
            }
            if ($scope.noerror) {
                if (action === 'add') {
                    $scope.createTutor();
                }
                if (action === 'edit') {
                    $scope.editTutor();
                }
            }
        };
    }]);


