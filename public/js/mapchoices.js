
function initialize() {

    // checking if user has Chrome as browser
    // RF took this from
    // http://stackoverflow.com/questions/4565112/javascript-how-to-find-out-if-the-user-browser-is-chrome/13348618#13348618
    var isChromium = window.chrome,
    winNav = window.navigator,
    vendorName = winNav.vendor,
    isOpera = winNav.userAgent.indexOf("OPR") > -1,
    isIEedge = winNav.userAgent.indexOf("Edge") > -1,
    isIOSChrome = winNav.userAgent.match("CriOS");

    if(isIOSChrome){
       // is Google Chrome on IOS

       // let's use city center as map center
       var myCenter = new google.maps.LatLng(61.497971, 23.762586);
       var marker;
       var mapProp = {
                     center: new google.maps.LatLng(61.497971, 23.762586),
                     zoom:14,
                     mapTypeId:google.maps.MapTypeId.ROADMAP
                     };
       var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
       var marker = new google.maps.Marker({
                                         position: myCenter,
                                         animation: google.maps.Animation.BOUNCE
                                         });       
       
       marker.setMap(map);

    }
    else if(isChromium !== null && isChromium !== undefined && vendorName === "Google Inc." && isOpera == false && isIEedge == false)
    {
       // is Google Chrome

       // let's use city center as map center
       var myCenter = new google.maps.LatLng(61.497971, 23.762586);
       var marker;
       var mapProp = {
                     center: new google.maps.LatLng(61.497971, 23.762586),
                     zoom:14,
                     mapTypeId:google.maps.MapTypeId.ROADMAP
                     };
       var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
       var marker = new google.maps.Marker({
                                         position: myCenter,
                                         animation: google.maps.Animation.BOUNCE
                                         });
       
       marker.setMap(map);
    }
    else
    {
       // not Google Chrome

       // we can use the user's location
       if (navigator.geolocation){

            navigator.geolocation.getCurrentPosition( function (position) {
                var coords = position.coords;
                var myCenter = new google.maps.LatLng( coords.latitude, coords.longitude );
                var marker;
                var mapProp = {
                    center: new google.maps.LatLng( coords.latitude, coords.longitude ),
                    zoom: 14,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
                var marker = new google.maps.Marker({
                    position: myCenter,
                    animation: google.maps.Animation.BOUNCE
                });
                marker.setMap(map);
                var infoWindow = new google.maps.InfoWindow({
                    content: "You are here!"
                });
                infoWindow.open(map, marker);
            });
        }
    }
}
