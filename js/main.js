var map;
var marker;
$(document).ready(function() {
    //Side Navigation initialize
    $('.button-collapse').sideNav({
        menuWidth: 240,
        edge: 'left',
        closeOnClick: true,
        draggable: true
    });
    $('.modal').modal();
});
var journeyApp = new angular.module('journeyApp', []);
journeyApp.controller('MenuController', function($scope, $http) {
    var request = $http({
        method: "post",
        url: "../services.php?action=showUser",
        data: {}
    });
    request.then(
        function successCallback(response) {
            console.log(response);
            if (response.data.status == 1) {
                $('#menu-username').val(response.data.prename + " " + response.data.name);
                $('#menu-email').val(response.data.email);
            } else {
                Materialize.toast('Ups something went wrong with your profile!', 4000);
            }
        },
        function errorCallback(response) {
            Materialize.toast('Ups something went wrong!', 4000);
        }
    );

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

    //Beispieldaten --> nach Anbindung an Backend entfernen!
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

    $scope.openImage = function(card) {
        /*$http.post('../services.php?action=getJourney', { id: card.data.id }, {
            headers: { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;' }
        }).then(function successCallback(response) {
            if (response.status == 1 && response.data.status == 1) {
                $('#modal-id').val(response.data.id);
                $('#modal-comment').text(response.data.comment);
                $('#modal-image').attr('src', response.data.image);
                if (response.data.favorite == 0) {
                    $('#modal-favorite').text('star_border');
                } else {
                    $('#modal-favorite').text('star');
                }
                initialize(response.data.lat, response.data.lng);
                $('#imageView').modal('open');
            } else {
                Materialize.toast('Ups something went wrong! Couldn\'t load pictures.', 4000);
                return false;
            }
        });*/

        //Beispieldaten --> nach Anbindung an Backend entfernen!
        $('#modal-id').val(1243);
        $('#modal-comment').text('irgend ein Text');
        $('#modal-image').attr('src', '../img/298.jpg');
        if (1) {
            $('#modal-favorite').text('star_border');
        } else {
            $('#modal-favorite').text('star');
        }
        initialize(46.818188, 8.227512);
        $('#imageView').modal('open');
    };
});

journeyApp.controller('ImageViewController', function($scope, $http) {
    $scope.toFavorite = function(card) {

        /*$http.post('../services.php?action=setFavorite', { id: card.data.id }, {
            headers: { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;' }
        }).then(function successCallback(response) {
            if (response.status == 1 && response.data.status == 1) {
                if ($('#modal-favorite').text() == "star") {
                    $('#modal-favorite').text('star_border');
                } else {
                    $('#modal-favorite').text('star');
                }
            } else {
                Materialize.toast('Ups something went wrong! Couldn\'t load pictures.', 4000);
                return false;
            }
        });*/

        //Beispieldaten --> nach Anbindung an Backend entfernen!
        if ($('#modal-favorite').text() == "star") {
            $('#modal-favorite').text('star_border');
        } else {
            $('#modal-favorite').text('star');
        }
    }
});

journeyApp.controller('FavoritesController', function($scope, $http) {
    /*$http.get('../services.php?action=getFavorites', function(response) {
        if (response.data.status == 1) {
            $scope.uploads = response.data.uploads;
        } else {
            Materialize.toast('Ups something went wrong! Couldn\'t load pictures.', 4000);
        }
    });*/

    //Beispieldaten --> nach Anbindung an Backend entfernen!
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
        }
    ];

    $scope.openImage = function(card) {
        /*$http.post('../services.php?action=getJourney', { id: card.data.id }, {
            headers: { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;' }
        }).then(function successCallback(response) {
            if (response.status == 1 && response.data.status == 1) {
                $('#modal-id').val(response.data.id);
                $('#modal-comment').text(response.data.comment);
                $('#modal-image').attr('src', response.data.image);
                if (response.data.favorite == 0) {
                    $('#modal-favorite').text('star_border');
                } else {
                    $('#modal-favorite').text('star');
                }
                initialize(response.data.lat, response.data.lng);
                $('#imageView').modal('open');
            } else {
                Materialize.toast('Ups something went wrong! Couldn\'t load pictures.', 4000);
                return false;
            }
        });*/

        //Beispieldaten --> nach Anbindung an Backend entfernen!
        $('#modal-id').val(1243);
        $('#modal-comment').text('irgend ein Text');
        $('#modal-image').attr('src', '../img/298.jpg');
        if (1) {
            $('#modal-favorite').text('star_border');
        } else {
            $('#modal-favorite').text('star');
        }
        initialize(46.818188, 8.227512);
        $('#imageView').modal('open');
    };
});

journeyApp.controller('AllPlacesController', function($scope, $http) {
    $http.get('../services.php?action=getJourneys', function(response) {
        if (response.data.status == 1) {
            $.each(response.data.uploads, function(index, upload) {

            });
        } else {
            Materialize.toast('Ups something went wrong! Couldn\'t load pictures.', 4000);
        }
    });
});

function initialize(_lat, _lng) {
    map = null;
    map = new google.maps.Map(document.getElementById('modal-map'), {
        zoom: 8,
        center: new google.maps.LatLng(_lat, _lng),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    setMarker(new google.maps.LatLng(_lat, _lng));
    google.maps.event.addListenerOnce(map, 'idle', function() {
        google.maps.event.trigger(map, 'resize');
    });
}

function setMarker(location) {
    deleteMarker();
    newMarker = new google.maps.Marker({
        position: location,
        map: map
    });
    marker = newMarker;
}

function deleteMarker() {
    if (marker && map) {
        marker.setMap(map);
        marker = {};
    }
}