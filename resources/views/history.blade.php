@extends('master')

@section('title')
{{ trans('messages.title') }}
@endsection

@section('head')
  <link rel="stylesheet" href="/css/bootstrap-datetimepicker.css" />
  <script type="text/javascript" src="/js/bootstrap-datetimepicker.js"
          charset="UTF-8"></script>
@endsection

@section('langmenu')
    @parent
@endsection

@section('heading')
    <h2>{{ trans('messages.heading') }}
        <small> - {{ trans('messages.history') }}</small></h2>
@endsection

@section('navbar')
    <ul class="nav nav-pills">
        <li><a href="/index">{{ trans('messages.live') }}</a></li>
        <li class="active"><a href="/history">{{ trans('messages.history') }}</a></li>
    <!--  <li><a href="/stats">{{ trans('messages.statistics') }}</a></li> -->
    </ul>
@endsection

@section('content')
<!-- ===== THE DATE AND TIME PICKER CALENDAR TOOL =============== -->
<div class="searchgroup">
  <div class="row">
    <form action="#" method="post">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group col-xs-offset-1 col-xs-10" >
          <div class='input-group date' id='datetimepicker1'>
            <input type='text' size="15" class="form-control"
                   name="searchtime" placeholder="Valitse / Choose >" readonly/>
            <span class="input-group-addon">
              <span class="glyphicon glyphicon-calendar"></span>
            </span>
          </div>
        </div>
    </form>
  </div>
</div>

<!-- ======== THE MAP ============================================= -->
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCwn6RrBRdFr83YTjdYguEoH7oOt6EoM8Q&callback=initialize"
async defer></script>
<!-- The map code is brought from an external js file -->

<script>
var x= <?= $coord; ?>;//--- the variable contains the coordinates from the csv file sent from the back end
 var FromEndDate = new Date();
        $(function () {
          $('#datetimepicker1').datetimepicker({
                    startDate: "-3m",
                    endDate: FromEndDate,
                    pickerPosition: "bottom-left",
                    autoclose: true,
                    todayBtn: true,
                    weekStart: 1,
                    language: '{{$lang = Cookie::get('lang')}}'
                    });
        });
function createMarker(latlng, device, detector, direction){
var west = {
      url: '/west.png',
      scaledSize: new google.maps.Size(30, 30),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(0, 0)
      };
      var north = {
      url: '/north.png',
      scaledSize: new google.maps.Size(30, 30),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(0, 0)
      };
      var east = {
      url: '/east.png',
      scaledSize: new google.maps.Size(30, 30),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(0, 0)
      };
      var south = {
      url: '/south.png',
      scaledSize: new google.maps.Size(30, 30),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(0, 0)
      };
      var southeast = {
      url: '/southeast.png',
      scaledSize: new google.maps.Size(30, 30),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(0, 0)
      };
      var southwest = {
      url: '/southwest.png',
      scaledSize: new google.maps.Size(30, 30),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(0, 0)
      };
      var northwest = {
      url: '/northwest.png',
      scaledSize: new google.maps.Size(30, 30),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(0, 0)
      };
      var northeast = {
      url: '/northeast.png',
      scaledSize: new google.maps.Size(30, 30),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(0, 0)
      };
    var marker = new google.maps.Marker({
      map: map,
      position: latlng,
      title: "Info",
      });
    switch (direction) {
          case 'north':
                       marker.setIcon(north);
                       break;
          case 'northwest':
                       marker.setIcon(northwest);
                       break;
          case 'east':
                       marker.setIcon(east);
                       break;
          case 'northeast':
                       marker.setIcon(northeast);
                       break;
          case 'south':
                       marker.setIcon(south);
                       break;
          case 'southeast':
                       marker.setIcon(southeast);
                       break;
          case 'southwest':
                       marker.setIcon(southwest);
                       break;
          case 'west':
                       marker.setIcon(west);
                       break;
        }
   //This event expects a click on a marker
   // When this event is fired the infowindow content is created
   // and the infowindow is opened
  google.maps.event.addListener(marker, 'click', function() {
   var date = $("#datetimepicker1").data("datetimepicker").getDate(), formatted = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate()   ,
   time= date.getHours() + ":" + ( (date.getMinutes()<10?'0':'') + date.getMinutes() ) ;
   var trafficAmount="";
   var avgWaitingTime="";
    var request=$.get('/dataFunction/'+device+'/'+ detector+'/'+formatted+'/'+time);
   request.done(function(response) {
      // Variable to define the HTML content to be inserted in the infowindow
      var iwContent = '<div id="content">'+
        '<h1>{{ trans('messages.info') }}</h1>'+
        '<p> {{ trans('messages.trafAmount') }}' +
        response[0].trafficAmount +
        '{{ trans('messages.trafAmountUnit') }}</p>' +
        '<p>{{ trans('messages.avgWait') }}' +
        response[1].avgWaitingTime +
        '{{ trans('messages.avgWaitUnit') }}</p>' +
        '<p>{{ trans('messages.queue') }}'+ response[1].queueLength +
        '{{ trans('messages.queueUnit') }}</p>'+
        '<p>{{ trans('messages.vehicles') }}'+ response[1].vehicleCount +
        '{{ trans('messages.vehiclesUnit') }}</p>'+
        '<a href="/stats?date=' + formatted + '&time=' + time +
        '&device='+device + '&detector='
        + detector + '">{{ trans('messages.learnMore') }}</a>'+'</div>';
      // including content to the infowindow
      infoWindow.setContent(iwContent);
      // opening the infowindow in the current map and at the current marker location
      infoWindow.open(map, marker); });
   });
}
function displayMarkers(){
   
   // For loop that runs through the info in the csv file making it possible to createMarker function to create the markers
   for (var i = 1; i < x.length; i++){
      var latlng = new google.maps.LatLng(x[i][2], x[i][3]);
      createMarker(latlng, x[i][0], x[i][1],x[i][4]);

   }
   
}
function initialize() {
   var mapOptions = {
      center: new google.maps.LatLng(61.497971, 23.762586),
      zoom: 14,
      mapTypeId: 'roadmap',
   };
   map = new google.maps.Map(document.getElementById('googleMap'), mapOptions);
   var image = {
    url: '/traffic-light-icon1.png',
    scaledSize: new google.maps.Size(30, 30),
    origin: new google.maps.Point(0, 0),
    anchor: new google.maps.Point(0, 0)
    };
   // a new Info Window is created
   infoWindow = new google.maps.InfoWindow();
   // Event that closes the InfoWindow with a click on the map
   google.maps.event.addListener(map, 'click', function() {
      infoWindow.close();
   });
   // Finally displayMarkers() function is called to begin the markers creation
   displayMarkers();
}
</script>

<!-- The map code is loaded into here -->
<div id="googleMap" style="width:100%;height:450px"></div>
@endsection
