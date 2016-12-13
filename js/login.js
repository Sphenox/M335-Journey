var journeyApp = new angular.module('journeyApp', []);

journeyApp.controller('LoginFormController', function($scope, $http) {
    $scope.submit = function() {
        var request = $http({
            method: "post",
            url: "../services.php?action=login",
            data: {
                email: $('#email').val(),
                password: $('#password').val()
            }
        });
        request.success = function(response) {
            if (response.status == 1) {
                window.location = './dashboard.html';
            } else {
                Materialize.toast('Username or password are wrong!', 4000);
            }
        }
        request.error = function(response) {
            Materialize.toast('Ups something went wrong! Errormessage: ' + response.statusText, 4000);
        }
    }
    $scope.register = function() {
        window.location = './registration.html';
    }
});