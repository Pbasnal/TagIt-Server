<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>gmap</title>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key={{$APP_KEY}}&libraries=places"></script>
</head>

<style type="text/css">
    #map-container 
    {
      float: left;
      background-color: black;
    }

    #map-canvas 
    {
      height: 500px;
      width: 800px;
    }

    #place-types 
    {
        float: left;
    }

    #place-types ul li 
    {
        list-style: none;
    }

</style>

<body>
    <div>
        <input type="text" id="search">
        <input id="find-places" type="button" name="Find" value="Find">

        <!-- map centre, bounds, radius and query string default is post
        {!! Form::open(array('url' => 'tag', 'method' => 'post')) !!}
            {!! Form::label('email', 'E-Mail Address'); !!}
            {!! Form::text('username', 'example'); !!}
        {!! Form::close() !!} -->
        <input id="tag-place" type="button" name="tag" value="Tag">
    </div>
    <div id="map-container">
        <div id="map-canvas"></div>
    </div>

  <script>
        var lat = 17.4631839; 
        var lng = 78.35364379999999; 
        var home_coordinates = new google.maps.LatLng(lat, lng); //set default coordinates
        var marker;
        var map_options = 
        {
            center: new google.maps.LatLng(lat, lng), //set map center
            zoom: 17, //set zoom level to 17
            mapTypeId: google.maps.MapTypeId.ROADMAP //set map type to road map
        };

        var map = new google.maps.Map(document.getElementById('map-canvas'), map_options);
        google.maps.event.addListener(map, 'click', touch);

        function touch(e)
        {
            console.log("Touch");
            addNormalMarker(map, e.latLng, 'TagIt');
        }

        function addTag()
        {
            console.log(marker);

            removeMarkers(); //remove the current place type markers from the map
            var mapCenter = map.getCenter();

            var formData = {
                'name'      : marker.title,
                'tags'      : '#new #place',
                'comments'  : 'this is a new place',
                'images'    : 'later',
                'location'  : {
                                'lat': marker.position.lat(),
                                'lng': marker.position.lng()
                              },
                'portal'    : 'later',
            };

            console.log(formData);

            //make a request to the server for the matching places
            $.ajax({
                type: 'POST',
                url: '/api/tag',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'requestData': formData
                },
                success: function(results)
                {
                    console.log('stored:', results);
                },
                error: function (data) 
                {
                    console.log('Error in store:', data);
                }
            });


        }
        var addNormalMarker = function AddNormalMarker(Map, latLng, title)
        {       
            console.log("Add normal marker");
            marker = new google.maps.Marker(
                {
                    position: latLng,
                    map: Map,
                    title: title
                });
            
            function addTag(marker)
            {
                console.log(marker);
            }

            function addInfoWindowAndPlace(Map, marker)
            {
                marker.addListener('click', 
                    function(e)
                    {
                        var infoWindow = new google.maps.InfoWindow;
                        var htmlContent = '<h3><center> Marker </center></h3><a onClick="addTag()">Tag this location</a>';
                        infoWindow.setContent(htmlContent);
                        infoWindow.open(Map, marker);
                    });
            }



            addInfoWindowAndPlace(Map, marker);
            
            new google.maps.event.trigger( marker, 'click' );
        }


        var input = document.getElementById('search'); //get element to use as input for autocomplete

        var markers_array = [];

        function removeMarkers()
        {
            for(i = 0; i < markers_array.length; i++)
            {
                markers_array[i].setMap(null);
            }
        }

        function addMarkers(response)
        {
          var response_data = JSON.parse(response);

          if(response_data.results)
          {
            var results = response_data.results;
            var result_count = results.length;

            for(var x = 0; x < result_count; x++)
            {
              //get coordinates of the place
              var lat = results[x]['geometry']['location']['lat'];
              var lng = results[x]['geometry']['location']['lng'];

              //create a new infowindow
              var infowindow = new google.maps.InfoWindow();

              //plot the marker into the map
              marker = new google.maps.Marker({
                position: new google.maps.LatLng(lat, lng),
                map: map,
                icon: results[x]['icon']
              });

              markers_array.push(marker);

              //assign an infowindow to the marker so that when its clicked it shows the name of the place
              google.maps.event.addListener(marker, 'click', (function(marker, x)
              {
                return function()
                {
                  infowindow.setContent("<div class='no-scroll'><strong>" + results[x]['name'] + "</strong><br>" + results[x]['vicinity'] + "</div>");
                  infowindow.open(map, marker);
                }
              })(marker, x));
            }
          }
        }

        var obj = {!! $dummyPlaces !!};
        
        //console.log(JSON.stringify(obj));

        addMarkers(JSON.stringify(obj));









        $('#find-places').click(function()
        {
            //var lat = home_marker.getPosition().lat();
            //var lng = home_marker.getPosition().lng();

            var place_types = [];

            removeMarkers(); //remove the current place type markers from the map
            var mapCenter = map.getCenter();
            var mapBounds = map.getBounds();

            var formData = {
                'query': $("#search").val(),
                'center': {
                    'lat': mapCenter.lat(),
                    'lng': mapCenter.lng()
                },
                'bounds': {
                    'NEPoint': {
                        'lat': mapBounds.getNorthEast().lat(),
                        'lng': mapBounds.getNorthEast().lng()
                    },
                    'SWPoint': {
                        'lat': mapBounds.getSouthWest().lat(),
                        'lng': mapBounds.getSouthWest().lng()
                    }
                }
            };

            console.log(formData);

            //make a request to the server for the matching places
            $.ajax({
                type: 'POST',
                url: 'tag/search',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'requestData': formData
                },
                success: function(results)
                {
                    console.log("Response from server");
                    if(results)
                    {
                        console.log("in if");
                        console.log(results.length);
                        var result_count = results.length;

                        for(var x = 0; x < result_count; x++)
                        {
                            //get coordinates of the place
                            console.log(results[x]['geometry']);

                            if(results[x]['geometry'] != undefined || results[x]['geometry'] != null)
                            {
                                var lat = results[x]['geometry']['location']['lat'];
                                var lng = results[x]['geometry']['location']['lng'];
                            }
                            else if (results[x]['location'] != undefined || results[x]['location'] != null)
                            {
                                var lat = results[x]['location']['lat'];
                                var lng = results[x]['location']['lng'];
                            }
                            else
                                continue;

                            //create a new infowindow
                            var infowindow = new google.maps.InfoWindow();

                            //plot the marker into the map
                            marker = new google.maps.Marker({
                                position: new google.maps.LatLng(lat, lng),
                                map: map,
                                icon: results[x]['icon']    
                            });

                            markers_array.push(marker);

                            //assign an infowindow to the marker so that when its clicked it shows the name of the place
                            google.maps.event.addListener(marker, 'click', (function(marker, x)
                            {
                                return function()
                                {
                                    infowindow.setContent("<div class='no-scroll'><strong>" + results[x]['name'] + "</strong><br>" + results[x]['comments'] + "</div>");
                                    infowindow.open(map, marker);
                                }
                            })(marker, x));
                        }
                    }
                },
                error: function (data) 
                {
                    console.log('Error:', data);
                }
            });
        });



        $('#tag-place').click(function()
        {
            removeMarkers(); //remove the current place type markers from the map
            var mapCenter = map.getCenter();

            var formData = {
                'name'      : 'New Place',
                'tags'      : '#new #place',
                'comments'  : 'this is a new place',
                'images'    : 'later',
                'location'  : {
                                'lat': mapCenter.lat(),
                                'lng': mapCenter.lng()
                              },
            };

            console.log(formData);

            //make a request to the server for the matching places
            $.ajax({
                type: 'get',
                url: 'tag/create',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'requestData': formData
                },
                success: function(results)
                {
                    console.log('stored:', results);
                },
                error: function (data) 
                {
                    console.log('Error in store:', data);
                }
            });
        });



        
  </script>
</body>
</html>