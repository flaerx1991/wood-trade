/////////////map

if(document.body.contains(document.querySelector(".wt-map-container"))){

    var map;
  
    function initialize() {
      // Create a simple map.
      map = new google.maps.Map(document.getElementById('map'), {
        zoom: 16,
        mapId: "7af374cea034b8b5",
        mapTypeControl: !1,
        fullscreenControl: !1,
        disableDefaultUI: !0,
        scrollwheel: !1,
        draggable: 0, 
        zoomControl: !1,
        disableDoubleClickZoom: !0,
        draggableCursor: "default",
        center: { lat: 51.2175369, lng: 27.6651079 }
      });
      const image = "/libs/img/map-marker.png";
      new google.maps.Marker({
  
        position: { lat: 51.21780000624493, lng: 27.666730058195895 },
        map,
        icon: image,
        title: "WOOD TRADE ltd",
      });
    }
    google.maps.event.addDomListener(window, 'load', initialize);
  
  }