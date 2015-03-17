var requirementApp = angular.module('requirementApp', ['ngRoute']);

requirementApp.config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
    $routeProvider
        .when('/list',{
            title: 'View Requirement',
            templateUrl: base_url +'/requirements/list',
            controller:'requirementController'
        })
        .when('/add', {
            title: 'Add Requirement',
            templateUrl: base_url + '/requirements/add',
            controller: 'requirementAddCtrl'
        })
        .when('/edit/:id', {
            title: 'Edit Requirement',
            templateUrl: base_url + '/requirements/add',
            controller: 'requirementAddCtrl'
        })
        .otherwise({
            redirectTo: '/list'
        });
}]);

requirementApp.factory('requirementService', ['$http', '$rootScope', function($http, $rootScope) {
    var requirements = [];
    return {
        getRequirements: function () {
            return $http({
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                url: base_url + 'req-list',
                method: "GET"
            })
            .success(function (jsonData) {
                if (jsonData) {
                    requirements = jsonData.data;
                }
                else {
                    requirements = {};
                }
                // quiz = addData;
                $rootScope.$broadcast('handleProjectsBroadcast', requirements);
            });
        },
        saveRequirement: function (requirementData) {
            return $http({
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                url: base_url + 'req-list',
                method: "POST",
                data: $.param(requirementData)
            })
            .success(function (requirementData) {
            });
        },
        getRequirement: function (requirement_id) {
            return $http({
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                url: base_url + 'req-list/' + requirement_id + '/edit',
                method: "GET"
            })
            .success(function (requirementData) {
            });
        },
        updateRequirement: function (requirement_id, requirementData) {
            return $http({
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                url: base_url + 'req-list/' + requirement_id,
                method: "PUT",
                data: $.param(requirementData)
            })
            .success(function (requirementData) {
            });
        }
    }
}]);

requirementApp.controller('mainCtrl', ['$scope', 'requirementService',  function($scope, requirementService) {

}]);

requirementApp.controller('requirementController', ['$scope', 'requirementService',  function($scope, requirementService) {

     $scope.name = 'Urmi';
     requirementService.getRequirements().then(function(requirementData) {
        $scope.requirements = requirementData.data;
         //console.log(requirementData);
     });


}]);

requirementApp.controller('requirementAddCtrl', ['$scope', 'requirementService' , '$routeParams', '$location',  function($scope, requirementService, $routeParams, $location) {
    $scope.requirement ={};
    $scope.submitClicked = false;
    if($routeParams.id) {
        //Call For Edit
        var requirementId = $scope.requirement.id = $routeParams.id;
        requirementService.getRequirement(requirementId).then(function(requirementData) {
            if(requirementData.data) {
                $scope.requirement = requirementData.data;
            }
        });

        $scope.save_requirement = function() {
            $scope.submitClicked = true;
            if($scope.addRequirementForm.$invalid) {
                console.log($scope.addRequirementForm);

            }else {
                requirementService.updateRequirement(requirementId, $scope.requirement).then(function (requirementData) {
                    $location.path('/');
                });
            }
        }
    }else {
        console.log('In add');
        //Call For Add
        $scope.save_requirement = function () {
            $scope.submitClicked = true;
            console.log('In save add');
            if($scope.addRequirementForm.$invalid) {
                console.log('In if');
                console.log('IF'+$scope.addRequirementForm);

            }else {
                console.log('In Else');
                console.log('Else'+$scope.addRequirementForm);
                requirementService.saveRequirement($scope.requirement).then(function (requirementData) {
                    $location.path('/');
                });
            }
        }
    }

}]);