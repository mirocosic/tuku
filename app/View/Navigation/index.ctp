 <?php echo $this->element('Menu');?>
<div id="map-canvas" style="position:fixed; top:0; left:0; width:100%; height:100%;"></div>

<div id="NavigateForm">
    <form id="calculate-route" name="calculate-route" action="#" method="get">
        <label for="from">From:</label>
        <input type="text" id="from" name="from" required="required" placeholder="An address" size="30" />
        <a id="from-link" href="#">Get my position</a>
        <br />

        <label for="to">To:</label>
        <input type="text" id="to" name="to" required="required" placeholder="Another address" size="30" />
        <a id="to-link" href="#">Get my position</a>
        <br />

        <input type="submit" />
        <input type="reset" />
     </form>
</div>



<script>
    var map;
    
    var isPushEnabled = false;
    
    window.addEventListener('load', function() {
        var pushButton = document.querySelector('.js-push-button');  
        pushButton.addEventListener('click', function() {  
            if (isPushEnabled) {
                unsubscribe();  
            } else {  
                subscribe();  
            }  
        });

        // Check that service workers are supported, if so, progressively  
        // enhance and add push messaging support, otherwise continue without it.  
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/service-worker.js')  
            .then(initialiseState);  
        } else {  
            console.warn('Service workers aren\'t supported in this browser.');  
        }  
    });
    
    function initialiseState() {  
    // Are Notifications supported in the service worker?  
    if (!('showNotification' in ServiceWorkerRegistration.prototype)) {  
      console.warn('Notifications aren\'t supported.');  
      return;  
    }

    // Check the current Notification permission.  
    // If its denied, it's a permanent block until the  
    // user changes the permission  
    if (Notification.permission === 'denied') {  
      console.warn('The user has blocked notifications.');  
      return;  
    }

    // Check if push messaging is supported  
    if (!('PushManager' in window)) {  
      console.warn('Push messaging isn\'t supported.');  
      return;  
    }

    // We need the service worker registration to check for a subscription  
    navigator.serviceWorker.ready.then(function(serviceWorkerRegistration) {  
      // Do we already have a push message subscription?  
      serviceWorkerRegistration.pushManager.getSubscription()  
        .then(function(subscription) {  
          // Enable any UI which subscribes / unsubscribes from  
          // push messages.  
          var pushButton = document.querySelector('.js-push-button');  
          pushButton.disabled = false;

          if (!subscription) {  
            // We aren't subscribed to push, so set UI  
            // to allow the user to enable push  
            return;  
          }

          // Keep your server in sync with the latest subscriptionId
          sendSubscriptionToServer(subscription);

          // Set your UI to show they have subscribed for  
          // push messages  
          pushButton.textContent = 'Disable Push Messages';  
          isPushEnabled = true;  
        })  
        .catch(function(err) {  
          console.warn('Error during getSubscription()', err);  
        });  
    });  
  }
    function handleNoGeolocation(errorFlag) {
          if (errorFlag) {
            var content = 'Error: The Geolocation service failed.';
          } else {
            var content = 'Error: Your browser doesn\'t support geolocation.';
          }

          var options = {
            map: map,
            position: new google.maps.LatLng(60, 105),
            content: content
          };

          var infowindow = new google.maps.InfoWindow(options);
          map.setCenter(options.position);
        }
    
    function initializeMap() {
        var mapCanvas = document.getElementById('map-canvas');
        var mapOptions = {
            center: new google.maps.LatLng(44.5403, -78.5463),
            zoom: 12,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        map = new google.maps.Map(mapCanvas, mapOptions);
        
         var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(44.5403, -78.5463),
                    map: map});
        
        
            // Try HTML5 geolocation
         if(navigator.geolocation) {
            var options =  {
                enableHighAccuracy: true,
                timeout: 1000,
		maximumAge: 0	
            };
            
            var watchID = navigator.geolocation.watchPosition(function(position) {
             
            // old good way
            //navigator.geolocation.getCurrentPosition(function(position) {
                
                var pos = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({
                    "location": new google.maps.LatLng(position.coords.latitude, position.coords.longitude)
                },function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK){
                        $("#from" ).val(results[0].formatted_address);
                    }else {
                        $("#error").append("Unable to retrieve your address<br />");
                        alert('Geocoder error.');
                    }
                });

                var infowindow = new google.maps.InfoWindow({
                    map: map,
                    position: pos,
                    content: 'Location found using HTML5.'
                });
                
               

                map.setCenter(pos);
                marker.setPosition(pos);
                console.log('watchposition updated.');
                
            }, function() {
              handleNoGeolocation(true);
            },options); // remove options for old good way
          } else {
            // Browser doesn't support Geolocation
            handleNoGeolocation(false);
          }
          
          // navigation
         directionsDisplay = new google.maps.DirectionsRenderer({
            polylineOptions:{strokeColor: "#e65f00", suppressMarkers:true}
        });
        directionsDisplay.setMap(map);
        
        var destination = document.getElementById('to');
        var autocomplete = new google.maps.places.Autocomplete(destination);
    }
    
    function calcRoute(){
        var start = document.getElementById("from").value;
	var end = document.getElementById("to").value;
	var request = {
            origin:start,
            destination:end,
            //waypoints:waypts,
            travelMode: google.maps.DirectionsTravelMode.DRIVING
        };
				
	directionsService.route(request, function(response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
            } else {
                alert('DirectionsService Error.');
            }
	});
    }

    // init navigation object
    var directionsService = new google.maps.DirectionsService();
  
    //start the map
    google.maps.event.addDomListener(window, 'load', initializeMap);
    google.maps.event.addDomListener(window, "resize", function() {
        var center = map.getCenter();
        google.maps.event.trigger(map, "resize");
        map.setCenter(center); 
    });
    /*
    $(document).ready(function(){
        $("#map_canvas").css("position", 'fixed').
            css('top', 0).
            css('left', 0).
            css("width", '100%').
            css("height", '100%');
    google.maps.event.trigger(map, 'resize'); 
    });
    */
</script>

<script>
    $("#calculate-route").submit(function(event) {
        event.preventDefault();
        calcRoute($("#from").val(), $("#to").val());
});
   
</script>