$(document).ready(function() {
    //Side Navigation initialize
    $('.button-collapse').sideNav({
        menuWidth: 240,
        edge: 'left',
        closeOnClick: true,
        draggable: true
    });

});
var journeyApp = new angular.module('journeyApp', []);
journeyApp.controller('MenuController', function($scope, $http) {
    $scope.logout = function() {
        var request = $http({
            method: "post",
            url: "../services.php?action=logout",
            data: {}
        });
        request.then(
            function successCallback(response) {
                if (response.data.status == 1) {
                    window.location = './login.html';
                } else {
                    Materialize.toast('Ups something went wrong! Errormessage: ' + response.data.statusText, 4000);
                }
            },
            function errorCallback(response) {
                Materialize.toast('Ups something went wrong! Errormessage: ' + response.statusText, 4000);
            }
        );
    }
});

journeyApp.controller('AllPicturesController', function($scope, $http) {
    /*$http.get('../services.php?action=getJourneys', function(response) {
        if (response.data.status == 1) {
            $scope.uploads = response.data.uploads;
        } else {
            Materialize.toast('Ups something went wrong! Couldn\'t load pictures.', 4000);
        }
    });*/
    $scope.uploads = [{
            "id": "298",
            "lat": "-41.082791",
            "lng": "8.9823719",
            "image": "../img/298.jpg",
            "createdAt": "2016-05-12 12:00",
            "comment": "Dies ist die Beschreibung des Bildes, hier kann drinn stehen was will",
            "favorite": "true"
        },
        {
            "id": "298",
            "lat": "-41.082791",
            "lng": "8.9823719",
            "image": "../img/298.jpg",
            "createdAt": "2016-05-12 12:00",
            "comment": "Dies ist die Beschreibung des Bildes, hier kann drinn stehen was will",
            "favorite": "true"
        },
        {
            "id": "298",
            "lat": "-41.082791",
            "lng": "8.9823719",
            "image": "../img/298.jpg",
            "createdAt": "2016-05-12 12:00",
            "comment": "Dies ist die Beschreibung des Bildes, hier kann drinn stehen was will",
            "favorite": "true"
        }
    ];

    $scope.openImage = function(id) {
        console.log(id);
    };
});