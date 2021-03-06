var journeyApp = new angular.module('journeyApp', ['ngFileUpload']);

journeyApp.controller('MyCtrl', ['$scope', 'Upload', '$timeout', function($scope, Upload, $timeout) {
    $scope.uploadPic = function(file) {
        console.log({ username: $scope.username, file: file });
        file.upload = Upload.upload({
            url: '../services.php?action=registration',
            method: 'POST',
            file: file,
            data: { 'username': $scope.username,
            'targetPath' : 'files/user/'}
        });

        file.upload.then(function(response) {
            $timeout(function() {
                file.result = response.data;
            });

        }, function(response) {
            if (response.status > 0)
                $scope.errorMsg = response.status + ': ' + response.data;

        }, function(evt) {
            // Math.min is to fix IE which reports 200% sometimes
            file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
        });
    }
}]);