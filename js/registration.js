var journeyApp = new angular.module('journeyApp', ['ngFileUpload']);

journeyApp.controller('RegistrationFormController', ['$scope', 'Upload', '$timeout', function($scope, Upload, $timeout) {
    $scope.submit = function(file) {
        file.upload = Upload.upload({
            url: '../services.php?action=registration',
            method: 'POST',
            file: file,
            data: {
                prename: $('#givenname').val(),
                name: $('#surname').val(),
                email: $('#email').val(),
                password: $('#password').val()
            }
        });
        file.upload.then(function(response) {
            $timeout(function() {
                file.result = response.data;
                if (response.data.status == 1) {
                    window.location = './allPictures.html';
                } else {
                    Materialize.toast('Ups something went wrong! Errormessage: ' + response.data.statusText, 4000);
                }
            });
        }, function(response) {
            if (response) {
                Materialize.toast('Ups something went wrong!', 4000);
            }
        }, function(evt) {

        });
    }
}]);