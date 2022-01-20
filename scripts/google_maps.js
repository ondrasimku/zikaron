function initMap() {
    console.log(latitude);
    console.log(longitude);
    // The location of Uluru
    const uluru = { lat: latitude, lng: longitude };
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

document.addEventListener("DOMContentLoaded", initMap);