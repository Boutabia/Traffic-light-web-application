function createMarker(latlng, device, detector, direction){

var west = {
      url: 'http://traffic-flow.app/west.png',
      // This marker is 00 pixels wide by 30 pixels high.
      scaledSize: new google.maps.Size(30, 30),
      // The origin for this image is (0, 0).
      origin: new google.maps.Point(0, 0),
      // The anchor for this image is the base of the flagpole at (0, 0).
      anchor: new google.maps.Point(0, 0)
      };
      var north = {
      url: 'http://traffic-flow.app/north.png',
      // This marker is 00 pixels wide by 30 pixels high.
      scaledSize: new google.maps.Size(30, 30),
      // The origin for this image is (0, 0).
      origin: new google.maps.Point(0, 0),
      // The anchor for this image is the base of the flagpole at (0, 0).
      anchor: new google.maps.Point(0, 0)
      };
      var east = {
      url: 'http://traffic-flow.app/east.png',
      // This marker is 00 pixels wide by 30 pixels high.
      scaledSize: new google.maps.Size(30, 30),
      // The origin for this image is (0, 0).
      origin: new google.maps.Point(0, 0),
      // The anchor for this image is the base of the flagpole at (0, 0).
      anchor: new google.maps.Point(0, 0)
      };
      var south = {
      url: 'http://traffic-flow.app/south.png',
      // This marker is 00 pixels wide by 30 pixels high.
      scaledSize: new google.maps.Size(30, 30),
      // The origin for this image is (0, 0).
      origin: new google.maps.Point(0, 0),
      // The anchor for this image is the base of the flagpole at (0, 0).
      anchor: new google.maps.Point(0, 0)
      };
      var southeast = {
      url: 'http://traffic-flow.app/southeast.png',
      // This marker is 00 pixels wide by 30 pixels high.
      scaledSize: new google.maps.Size(30, 30),
      // The origin for this image is (0, 0).
      origin: new google.maps.Point(0, 0),
      // The anchor for this image is the base of the flagpole at (0, 0).
      anchor: new google.maps.Point(0, 0)
      };
      var southwest = {
      url: 'http://traffic-flow.app/southwest.png',
      // This marker is 00 pixels wide by 30 pixels high.
      scaledSize: new google.maps.Size(30, 30),
      // The origin for this image is (0, 0).
      origin: new google.maps.Point(0, 0),
      // The anchor for this image is the base of the flagpole at (0, 0).
      anchor: new google.maps.Point(0, 0)
      };
      var northwest = {
      url: 'http://traffic-flow.app/northwest.png',
      // This marker is 00 pixels wide by 30 pixels high.
      scaledSize: new google.maps.Size(30, 30),
      // The origin for this image is (0, 0).
      origin: new google.maps.Point(0, 0),
      // The anchor for this image is the base of the flagpole at (0, 0).
      anchor: new google.maps.Point(0, 0)
      };
      var northeast = {
      url: 'http://traffic-flow.app/northeast.png',
      // This marker is 00 pixels wide by 30 pixels high.
      scaledSize: new google.maps.Size(30, 30),
      // The origin for this image is (0, 0).
      origin: new google.maps.Point(0, 0),
      // The anchor for this image is the base of the flagpole at (0, 0).
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
   time= date.getHours() + ":" + date.getMinutes() ;
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
        '<p> Queue Length:'+ response[1].queueLength+ ' meters </p>'+
           '<p> Vehicle count:'+ response[1].vehicleCount+ ' vehicles </p>'+
        '<a href="/stats?date=' + formatted + '&time=' + time +
        '&device='+device + '&detector='
        + detector + '">{{ trans('messages.learnMore') }}</a>'+'</div>';

      // including content to the infowindow
      infoWindow.setContent(iwContent);

      // opening the infowindow in the current map and at the current marker location
      infoWindow.open(map, marker); });
   });
}