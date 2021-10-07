function initMap() {
    // The location of Uluru
    const uluru = { lat: 49.1472876876214, lng: 15.002055632555555 };
    // The map, centered at Uluru
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 17,
        center: uluru,
    });
    // The marker, positioned at Uluru
    const marker = new google.maps.Marker({
        position: uluru,
        map: map,
    });
}

document.addEventListener("DOMContentLoaded", function(event) {
    initMap();
});