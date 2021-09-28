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

getLocationCustomer();


function getLocationCustomer() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPositionCustomer);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPositionCustomer(position) {

    var loc1 = position.coords.latitude + "|" + position.coords.longitude;
    $.ajax({
        type: "GET",
        url: `http://127.0.0.1:8000/getLocation/${position.coords.latitude}/${position.coords.longitude}`,
        cache: false,
        success: function(data){
            //console.log(data);
            var dataProduk = document.getElementById("data");
            var object = JSON.parse(data);
            // console.log(object);

            if(object.length === 0){
                var notif = `<h4 class="fs-2hx text-dark mb-5" style="text-align:center" data-kt-scroll-offset="{default: 100, lg: 150}">Tidak ada Produk Disekitar mu!!</h4>`;
                $("#data").append(notif);
                return;
            }

            for(var i = 0; i < object.length; i++){
                // console.log(object[i]);

                var card = `<div class="col-md-4 px-5">
                    <!--begin::Story-->
                    <div class="text-center mb-10 mb-md-0">
                        <!--begin::Illustration-->
                        <img src="http://127.0.0.1:8000/img/${object[i].image}" class="mh-200px mb-9" alt="" />
                        <!--end::Illustration-->
                        <!--begin::Heading-->
                        <div class="d-flex flex-center mb-5">
                            <!--begin::Badge-->
                            <span class="badge badge-circle badge-light-success fw-bolder p-5 me-3 fs-3"></span>
                            <!--end::Badge-->
                            <!--begin::Title-->
                            <div class="fs-5 fs-lg-3 fw-bolder text-dark">${object[i].name}</div>
                            <!--end::Title-->
                        </div>
                        <!--end::Heading-->
                        <!--begin::Description-->
                        <div class="fw-bold fs-6 fs-lg-4 text-muted">${object[i].price}</div>
                        <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app" id="kt_toolbar_primary_button">Beli</a>
                        <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app" id="kt_toolbar_primary_button">Lihat</a>
                        <!--end::Description-->
                    </div>
                    <!--end::Story-->
                </div>`;
                $("#data").append(card);
            }
        }
        });
    return loc1;

}

