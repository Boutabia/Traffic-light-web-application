@extends('master')

@section('title')
    {{ trans('messages.title') }}
@endsection

@section('langmenu')
    @parent
@endsection

@section('heading')
    <h2>{{ trans('messages.heading') }}</h2>
@endsection

@section('navbar')
    <ul class="nav nav-pills">
        <li class="active"><a href="/index">{{ trans('messages.live') }}</a></li>
        <li><a href="history">{{ trans('messages.history') }}</a></li>
    <!-- <li><a href="stats">{{ trans('messages.statistics') }}</a></li> -->
    </ul>
@endsection

@section('content')
    <!-- ======== page last updated and refresh =========================== -->
    <div class="updatetime">
        <div class="time">
            <p style="line-height: 30px; text-align: center">{{ trans('messages.updatetime') }}
                <script type="text/javascript">
                    var t = new Date()
                    document.write(t.getHours())
                    document.write(":")
                    document.write( ( (t.getMinutes()<10?'0':'') + t.getMinutes() ) )
                </script>
            </p>
        </div>
        <div class="refreshbtn">
            <button type="button" class="btn btn-warning" onclick="history.go(0)">
                <span class="glyphicon glyphicon-refresh"></span></button>
            <script>
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip()
                })
            </script>
            <img src="/icons/northGreen.png" data-toggle="tooltip" data-placement="bottom" title="{{ trans('messages.avgWait') }} 0-20s" style="height: 20px; width: 20px">
            <img src="/icons/northYellow.png" data-toggle="tooltip" data-placement="bottom" title="{{ trans('messages.avgWait') }} 20-30s" style="height: 20px; width: 20px">
            <img src="/icons/northRed.png" data-toggle="tooltip" data-placement="bottom" title="{{ trans('messages.avgWait') }} >30s" style="height: 20px; width: 20px">
        </div>
    </div>
<!-- ======== THE MAP ============================================= -->
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCwn6RrBRdFr83YTjdYguEoH7oOt6EoM8Q&callback=initialize" async defer></script>

<!-- The map code -->
<script>

  var coordinates= <?= $json; ?>; //getting the json data sent from the back end  
  var x = Object.keys(coordinates).length;
  //console.log(Object.keys(coordinates).length); // this a verification measure to check if we get response from the API
  var contentString =""; //-- a variable where to put the info window content
  var language = "{{ $lang = Cookie::get('lang') }}";

function initialize() {

    var myCenter = new google.maps.LatLng(61.498255, 23.773280);
    var mapProp = {
                   center: new google.maps.LatLng(61.497971, 23.762586),
                   zoom:14,
                    mapTypeId:google.maps.MapTypeId.ROADMAP
                  };
    var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);

//--------Defining the icons used for markers in the map
//------ 24 icons representing color coding yellow, green, red and 8 directions.

    var westGreen = {
                      url: '/icons/westGreen.png',
                      scaledSize: new google.maps.Size(30, 30),
                      origin: new google.maps.Point(0, 0),
                      anchor: new google.maps.Point(0, 0)
                    };
    var northGreen = {
                       url: '/icons/northGreen.png',
                       scaledSize: new google.maps.Size(30, 30),
                       origin: new google.maps.Point(0, 0),
                       anchor: new google.maps.Point(0, 0)
                     };
    var eastGreen = {
                      url: '/icons/eastGreen.png',
                      scaledSize: new google.maps.Size(30, 30),
                      origin: new google.maps.Point(0, 0),
                      anchor: new google.maps.Point(0, 0)
                    };
    var southGreen = {
                       url: '/icons/southGreen.png',  
                       scaledSize: new google.maps.Size(30, 30),
                       origin: new google.maps.Point(0, 0),
                       anchor: new google.maps.Point(0, 0)
                     };
    var southeastGreen = {
                           url: '/icons/southeastGreen.png',
                           scaledSize: new google.maps.Size(30, 30),
                           origin: new google.maps.Point(0, 0),
                           anchor: new google.maps.Point(0, 0)
                         };
    var southwestGreen = {
                           url: '/icons/southwestGreen.png',
                           scaledSize: new google.maps.Size(30, 30),
                           origin: new google.maps.Point(0, 0),
                           anchor: new google.maps.Point(0, 0)
                         };
    var northwestGreen = {
                           url: '/icons/northwestGreen.png',
                           scaledSize: new google.maps.Size(30, 30),
                           origin: new google.maps.Point(0, 0),
                           anchor: new google.maps.Point(0, 0)
                         };
    var northeastGreen = {
                           url: '/icons/northeastGreen.png',
                           scaledSize: new google.maps.Size(30, 30),
                           origin: new google.maps.Point(0, 0),
                           anchor: new google.maps.Point(0, 0)
                         };
    var westRed = {
                    url: '/icons/westRed.png',
                    scaledSize: new google.maps.Size(30, 30),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(0, 0)
                  };
    var northRed = {
                     url: '/icons/northRed.png',
                     scaledSize: new google.maps.Size(30, 30),
                     origin: new google.maps.Point(0, 0),
                     anchor: new google.maps.Point(0, 0)
                    };
    var eastRed = {
                    url: '/icons/eastRed.png',
                    scaledSize: new google.maps.Size(30, 30),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(0, 0)
                  };
    var southRed = {
                     url: '/icons/southRed.png',
                     scaledSize: new google.maps.Size(30, 30),
                     origin: new google.maps.Point(0, 0),
                     anchor: new google.maps.Point(0, 0)
                   };
    var southeastRed = {
                         url: '/icons/southeastRed.png',
                         scaledSize: new google.maps.Size(30, 30),
                         origin: new google.maps.Point(0, 0),
                         anchor: new google.maps.Point(0, 0)
                        };
    var southwestRed = {
                         url: '/icons/southwestRed.png',
                         scaledSize: new google.maps.Size(30, 30),
                         origin: new google.maps.Point(0, 0),
                         anchor: new google.maps.Point(0, 0)
                       };
    var northwestRed = {
                         url: '/icons/northwestRed.png',
                         scaledSize: new google.maps.Size(30, 30),
                         origin: new google.maps.Point(0, 0),
                         anchor: new google.maps.Point(0, 0)
                       };
    var northeastRed = {
                         url: '/icons/northeastRed.png',
                         scaledSize: new google.maps.Size(30, 30),
                         origin: new google.maps.Point(0, 0),
                         anchor: new google.maps.Point(0, 0)
                       };
    var westYellow = {
                       url: '/icons/westYellow.png',
                       scaledSize: new google.maps.Size(30, 30),
                       origin: new google.maps.Point(0, 0),
                       anchor: new google.maps.Point(0, 0)
                      };
    var northYellow = {
                        url: '/icons/northYellow.png',
                        scaledSize: new google.maps.Size(30, 30),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(0, 0)
                      };
    var eastYellow = {
                       url: '/icons/eastYellow.png',
                       scaledSize: new google.maps.Size(30, 30),
                       origin: new google.maps.Point(0, 0),
                       anchor: new google.maps.Point(0, 0)
                     };
    var southYellow = {
                        url: '/icons/southYellow.png',
                        scaledSize: new google.maps.Size(30, 30),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(0, 0)
                      };
    var southeastYellow = {
                            url: '/icons/southeastYellow.png',
                            scaledSize: new google.maps.Size(30, 30),
                            origin: new google.maps.Point(0, 0),
                            anchor: new google.maps.Point(0, 0)
                          };
    var southwestYellow = {
                            url: '/icons/southwestYellow.png',
                            scaledSize: new google.maps.Size(30, 30),
                            origin: new google.maps.Point(0, 0),
                            anchor: new google.maps.Point(0, 0)
                          };
    var northwestYellow = {
                            url: '/icons/northwestYellow.png',
                            scaledSize: new google.maps.Size(30, 30),
                            origin: new google.maps.Point(0, 0),
                            anchor: new google.maps.Point(0, 0)
                          };
    var northeastYellow = {
                            url: '/icons/northeastYellow.png',
                            scaledSize: new google.maps.Size(30, 30),
                            origin: new google.maps.Point(0, 0),
                            anchor: new google.maps.Point(0, 0)
                          };

      
    var infowindow = new google.maps.InfoWindow();
	



    //for loop to show all the markers in the map using the coordinates and avg waiting time
    for (var i = 1; i < x; i++) {
      if (coordinates[i]!= undefined ){
        if (coordinates[i].avgtime!= null) {
          var avgTime=coordinates[i].avgtime.toFixed(1);    // toFixed is used to show only one digit after the decimal point
        }
        else avgTime="Data not available";
        contentString ='<div class="gm-style-iw" id="iw-container">'+
          '<h1 id="iw-title" class="bg-primary">{{ trans('messages.info') }}</h1>' +
          '<p><b>{{ trans('messages.trafAmount') }}</b>' +
          coordinates[i].tAmount + '{{ trans('messages.trafAmountUnit') }}</p>'+

          '<p><b>{{ trans('messages.avgWait') }}</b>'+ avgTime +
          '{{ trans('messages.avgWaitUnit') }}</p>' + 
           '<p><b> Queue Length:</b>'+ coordinates[i].queueLength+ ' meters </p>'+
           '<p> <b>Vehicle count:</b>'+ coordinates[i].vehicleCount+ ' vehicles </p>'

          '<p><b>{{ trans('messages.avgWait') }}</b>'+ avgTime +
          '{{ trans('messages.avgWaitUnit') }}</p>' +
           '<p><b>{{ trans('messages.queue') }}</b>'+ coordinates[i].queueLength +
           '{{ trans('messages.queueUnit') }}</p>'+
           '<p>{{ trans('messages.vehicles') }}'+ coordinates[i].vehicleCount +
           '{{ trans('messages.vehiclesUnit') }}</p>'

          '</div>';

      //-- getting the coordinates of the marker from the coordinates which represents combined data sent from the back end
        var trafficLightMarker = new google.maps.Marker({
        position: {lat: parseFloat(coordinates[i].lat), lng: parseFloat(coordinates[i].long)},
        map: map,
        });
       switch (coordinates[i].direction) {
          case 'north':
                       if(parseFloat(avgTime)> 30) trafficLightMarker.setIcon(northRed);
                        else if(parseFloat(avgTime)>20) trafficLightMarker.setIcon(northYellow);
                          else trafficLightMarker.setIcon(northGreen);
                       break;
          case 'northwest':
                       if(parseFloat(avgTime)> 30) trafficLightMarker.setIcon(northwestRed);
                        else if(parseFloat(avgTime)>20) trafficLightMarker.setIcon(northwestYellow);
                          else trafficLightMarker.setIcon(northwestGreen);
                       break;
          case 'east':
                       if(parseFloat(avgTime)> 30) trafficLightMarker.setIcon(eastRed);
                        else if(parseFloat(avgTime)>20) trafficLightMarker.setIcon(eastYellow);
                          else trafficLightMarker.setIcon(eastGreen);
                       break;
          case 'northeast':
                       if(parseFloat(avgTime)> 30) trafficLightMarker.setIcon(northeastRed);
                        else if(parseFloat(avgTime)>20) trafficLightMarker.setIcon(northeastYellow);
                          else trafficLightMarker.setIcon(northeastGreen);
                       break;
          case 'south':
                       if(parseFloat(avgTime)> 30) trafficLightMarker.setIcon(southRed);
                        else if(parseFloat(avgTime)>20) trafficLightMarker.setIcon(southYellow);
                          else trafficLightMarker.setIcon(southGreen);
                       break;
          case 'southeast':
                       if(parseFloat(avgTime)> 30) trafficLightMarker.setIcon(southeastRed);
                        else if(parseFloat(avgTime)>20) trafficLightMarker.setIcon(southeastYellow);
                          else trafficLightMarker.setIcon(southeastGreen);
                       break;
          case 'southwest':
                       if(parseFloat(avgTime)> 30) trafficLightMarker.setIcon(southwestRed);
                        else if(parseFloat(avgTime)>20) trafficLightMarker.setIcon(southwestYellow);
                          else trafficLightMarker.setIcon(southwestGreen);
                       break;
          case 'west':
                       if(parseFloat(avgTime)> 30) trafficLightMarker.setIcon(westRed);
                        else if(parseFloat(avgTime)>20) trafficLightMarker.setIcon(westYellow);
                          else trafficLightMarker.setIcon(westGreen);
                       break;


        }
//---- showing the info window when the user clicks on the marker
  google.maps.event.addListener(trafficLightMarker, 'click',(

        function(trafficLightMarker, contentString) {
          return function() {
            infowindow.setContent(contentString);
            infowindow.open(map, trafficLightMarker);
          }
        })
          (trafficLightMarker, contentString));

    }
    }
   //--- event to close the info window if the map is clicked
   google.maps.event.addListener(map, 'click', function() {
      infowindow.close();
   });

 google.maps.event.addDomListener(window, 'load', initialize);
}
</script>

<!-- The map code is loaded into here -->
<div id="googleMap" style="width:100%;height:500px"></div>

@endsection
