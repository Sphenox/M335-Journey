var map;
var markers;
$(document).ready(function() {
    //Side Navigation initialize
    $('.button-collapse').sideNav({
        menuWidth: 280,
        edge: 'left',
        closeOnClick: true,
        draggable: true
    });
    markers = new Array();
    $('.modal').modal();
});
var journeyApp = new angular.module('journeyApp', ['ngFileUpload']);
journeyApp.controller('MenuController', function($scope, $http) {
    var request = $http({
        method: "post",
        url: "../services.php?action=showUser",
        data: {}
    });
    request.then(
        function successCallback(response) {
            if (response.data.status == 1) {
                $('#menu-username').text(response.data.prename + " " + response.data.name);
                $('#menu-email').text(response.data.email);
                $('#menu-image').attr('src', "../" + response.data.userImage);
            } else {
                window.location = "../html/login.html";
                Materialize.toast('Ups something went wrong with your profile!', 4000);
            }
        },
        function errorCallback(response) {
            window.location = "../html/login.html";
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
    $http.get('../services.php?action=getAllJourneys').then(function(response) {
        if (response.data.status == 1) {
            $scope.uploads = response.data.uploads;
        } else {
            Materialize.toast('Ups something went wrong! Couldn\'t load pictures.', 4000);
        }
    });

    //Beispieldaten --> nach Anbindung an Backend entfernen!
    /*$scope.uploads = [{
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
    ];*/

    $scope.openImage = function(card) {
        $http.post('../services.php?action=getJourney', { id: card.upload.id }, {
            headers: { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;' }
        }).then(function successCallback(response) {
            if (response.status == 200 && response.data.status == 1) {
                $('#modal-id').val(response.data.id);
                $('#modal-comment').text(response.data.comment);
                $('#modal-image').attr('src', "../" + response.data.image);
                if (response.data.favorite == "false") {
                    $('#modal-favorite').text('star_border');
                } else {
                    $('#modal-favorite').text('star');
                }
                deleteMarkers()
                var _markers = new Array();
                _markers.push(new google.maps.LatLng(response.data.lat, response.data.lng));
                initialize(response.data.lat, response.data.lng, _markers);
                $('#imageView').modal('open');
            } else {
                Materialize.toast('Ups something went wrong! Couldn\'t load pictures.', 4000);
                return false;
            }
        });

        //Beispieldaten --> nach Anbindung an Backend entfernen!
        /*$('#modal-id').val(1243);
        $('#modal-comment').text('irgend ein Text');
        $('#modal-image').attr('src', '../img/298.jpg');
        if (1) {
            $('#modal-favorite').text('star_border');
        } else {
            $('#modal-favorite').text('star');
        }
        deleteMarkers()
        var _markers = new Array();
        _markers.push(new google.maps.LatLng(46.818188, 8.227512));
        initialize(46.818188, 8.227512, _markers);
        $('#imageView').modal('open');*/
    };
});

journeyApp.controller('ImageViewController', function($scope, $http) {

    $scope.toFavorite = function() {
        var _id = $("#modal-id").val();
        console.log(_id);
        $http.post('../services.php?action=toggleFavorite', { id: _id }, {
            headers: { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;' }
        }).then(function successCallback(response) {
            console.log(response);
            if (response.status == 200 && response.data.status == 1) {
                if ($('#modal-favorite').text() == "star") {
                    $('#modal-favorite').text('star_border');
                } else {
                    $('#modal-favorite').text('star');
                }
            } else {
                Materialize.toast('Ups something went wrong! Couldn\'t toggle the favorite.', 4000);
            }
        });

        //Beispieldaten --> nach Anbindung an Backend entfernen!
        /*if ($('#modal-favorite').text() == "star") {
            $('#modal-favorite').text('star_border');
        } else {
            $('#modal-favorite').text('star');
        }*/
    }
});

journeyApp.controller('FavoritesController', function($scope, $http) {
    $http.get('../services.php?action=getFavorites').then(function(response) {
        if (response.data.status == 1) {
            $scope.uploads = response.data.uploads;
        } else {
            Materialize.toast('Ups something went wrong! Couldn\'t load pictures.', 4000);
        }
    });

    //Beispieldaten --> nach Anbindung an Backend entfernen!
    /*$scope.uploads = [{
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
    ];*/

    $scope.openImage = function(card) {
        console.log(card);
        $http.post('../services.php?action=getJourney', { "id": card.upload.id }, {
            headers: { 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;' }
        }).then(function successCallback(response) {
            if (response.status == 200 && response.data.status == 1) {
                console.log(response);
                $('#modal-id').val(response.data.id);
                $('#modal-comment').text(response.data.comment);
                $('#modal-image').attr('src', "../" + response.data.image);
                if (response.data.favorite == 0) {
                    $('#modal-favorite').text('star_border');
                } else {
                    $('#modal-favorite').text('star');
                }
                deleteMarkers();
                var _markers = new Array();
                _markers.push(new google.maps.LatLng(response.data.lat, response.data.lng));
                initialize(response.data.lat, response.data.lng, _markers);
                $('#imageView').modal('open');
            } else {
                console.log(response);
                Materialize.toast('Ups something went wrong! Couldn\'t load pictures.', 4000);
                return false;
            }
        });

        //Beispieldaten --> nach Anbindung an Backend entfernen!
        /*$('#modal-id').val(1243);
        $('#modal-comment').text('irgend ein Text');
        $('#modal-image').attr('src', '../img/298.jpg');
        if (1) {
            $('#modal-favorite').text('star_border');
        } else {
            $('#modal-favorite').text('star');
        }
        deleteMarkers();
        var _markers = new Array();
        _markers.push(new google.maps.LatLng(46.818188, 8.227512));
        initialize(46.818188, 8.227512, _markers);
        $('#imageView').modal('open');*/
    };
});

journeyApp.controller('AllPlacesController', function($scope, $http) {
    $http.get('../services.php?action=getJourneys').then(function(response) {
        if (response.data.status == 1) {
            var _markers = new Array();
            $.each(response.data.uploads, function(index, upload) {
                _markers.push(new google.maps.LatLng(upload.lat, upload.lng));
            });
            initialize(0, 0, _markers, 1);
        } else {
            Materialize.toast('Ups something went wrong! Couldn\'t load pictures.', 4000);
        }
    });
});

journeyApp.controller('NewPictureFormController', ['$scope', 'Upload', '$timeout', function($scope, Upload, $timeout) {
    var options = {
        enableHighAccuracy: true
    };

    navigator.geolocation.getCurrentPosition(function(pos) {
            $scope.position = { "lat": pos.coords.latitude, "lng": pos.coords.longitude };
            var _markers = new Array();
            _markers.push(new google.maps.LatLng($scope.position.lat, $scope.position.lng));
            initialize($scope.position.lat, $scope.position.lng, _markers, 12);
        },
        function(error) {
            Materialize.toast('Ups something went wrong! Failed to get location.', 4000);
        }, options);

    $scope.submit = function(file) {
            file.upload = Upload.upload({
                url: '../services.php?action=newJourney',
                method: 'POST',
                file: file,
                data: {
                    lat: $scope.position.lat,
                    lng: $scope.position.lng,
                    comment: $('#newPicture-description').val(),
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
        /*$scope.submit = function() {
            var request = $http({
                method: "post",
                url: "../services.php?action=newJourney",
                datat: {
                    "lat": "-41.082791",
                    "lng": "8.9823719",
                    "image": "/PATH/TO/IMG",
                    "comment": $("#newPicture-description").val()
                }
            });
            request.then(function successCallback(response) {
                window.location = '../html/allPictures.html';
            }, function errorCallback(response) {
                Materialize.toast('Ups something went wrong! Couldn\'t create picture.', 4000);
            });
        }*/
}]);

function initialize(_lat, _lng, _markers, _zoom = 8) {
    map = null;
    map = new google.maps.Map(document.getElementById('modal-map'), {
        zoom: _zoom,
        center: new google.maps.LatLng(_lat, _lng),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    $.each(_markers, function(index, marker) {
        setMarker(marker);
    });
    google.maps.event.addListenerOnce(map, 'idle', function() {
        google.maps.event.trigger(map, 'resize');
    });
}

function setMarker(location) {
    newMarker = new google.maps.Marker({
        position: location,
        map: map
    });
    markers.push(newMarker);
}

function deleteMarkers() {
    markers = new Array();
}