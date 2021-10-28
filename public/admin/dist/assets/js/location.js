function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    var loc1 = document.getElementById("location");
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
    const pathname = window.location.pathname;
    let x = '/';
    let arr = pathname.split('/');
    if(arr[1] === 'public') {
        x = '/public/';
    }

    const url = window.location.origin + `${x}getLocation/${position.coords.latitude}/${position.coords.longitude}`;
    console.log(url);
    $.ajax({
        type: "GET",
        url: url,
        cache: true,
        success: function(data) {
            document.getElementById('data').innerHTML = data;
        },
        error: function (params) {
            console.error('Error: ketika mencoba mengambil data produk terdekat');
            console.error(params);
        }
    });
    return loc1;
}

getLocationCustomer();
