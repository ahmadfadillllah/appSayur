function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    var loc1 = document.getElementById('location');
    loc1.value = position.coords.latitude + "|" + position.coords.longitude;
    console.log(loc1.value);
}

function getLocationCustomer() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPositionCustomer);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPositionCustomer(position) {

    var loc1 = position.coords.latitude + "|" + position.coords.longitude;
    return loc1;
}
