function initMap() {
  const schoolLocation = { lat: 6.3156, lng: -10.8074 };

  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 15,
    center: schoolLocation,
    scrollwheel: false,
    styles: [
      { elementType: "geometry", stylers: [{ color: "#f5f5f5" }] },
      { elementType: "labels.icon", stylers: [{ visibility: "off" }] },
      { elementType: "labels.text.fill", stylers: [{ color: "#616161" }] },
      { elementType: "labels.text.stroke", stylers: [{ color: "#f5f5f5" }] },
      { featureType: "road", elementType: "geometry", stylers: [{ color: "#ffffff" }] },
      { featureType: "water", elementType: "geometry", stylers: [{ color: "#c9c9c9" }] }
    ]
  });

  new google.maps.Marker({
    position: schoolLocation,
    map: map,
    title: "Edmol Baptist School"
  });
}
