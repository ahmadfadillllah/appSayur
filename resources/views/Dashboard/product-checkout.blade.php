<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <base href="">
    <title>Checkout Produk - {{ $product->name }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="{{ asset('admin/dist/assets') }}/media/logos/favicon.ico" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{ asset('admin/dist/assets') }}/plugins/global/plugins.bundle.css" rel="stylesheet"
        type="text/css" />

    <link href="{{ asset('admin/dist/assets') }}/css/style.bundle.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css"
        integrity="sha384-jLKHWM3JRmfMU0A5x5AkjWkw/EYfGUAGagvnfryNV3F9VqM98XiIH7VBGVoxVSc7" crossorigin="anonymous">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/product.css') }}">


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous" defer>
    </script>



    <!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" data-bs-spy="scroll" data-bs-target="#kt_landing_menu" data-bs-offset="200"
    class="bg-white position-relative">
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Header Section-->
        <div class="mb-0" id="home">
            <!--begin::Wrapper-->
            <div class="bgi-no-repeat bgi-size-contain bgi-position-x-center bgi-position-y-bottom landing-dark-bg"
                style="background-image: url({{ asset('admin/dist/assets') }}/media/svg/illustrations/vegetables.png)">
                <!--begin::Header-->
                <div class="landing-header" data-kt-sticky="true" data-kt-sticky-name="landing-header"
                    data-kt-sticky-offset="{default: '200px', lg: '300px'}">
                    <!--begin::Container-->
                    <div class="container">
                        <!--begin::Wrapper-->
                        <div class="d-flex align-items-center justify-content-between">
                            <!--begin::Logo-->
                            <div class="d-flex align-items-center flex-equal">
                                <!--begin::Mobile menu toggle-->
                                <button class="btn btn-icon btn-active-color-primary me-3 d-flex d-lg-none"
                                    id="kt_landing_menu_toggle">
                                    <!--begin::Svg Icon | path: icons/duotone/Text/Menu.svg-->
                                    <span class="svg-icon svg-icon-2hx">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                            viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <rect fill="#000000" x="4" y="5" width="16" height="3" rx="1.5" />
                                                <path
                                                    d="M5.5,15 L18.5,15 C19.3284271,15 20,15.6715729 20,16.5 C20,17.3284271 19.3284271,18 18.5,18 L5.5,18 C4.67157288,18 4,17.3284271 4,16.5 C4,15.6715729 4.67157288,15 5.5,15 Z M5.5,10 L18.5,10 C19.3284271,10 20,10.6715729 20,11.5 C20,12.3284271 19.3284271,13 18.5,13 L5.5,13 C4.67157288,13 4,12.3284271 4,11.5 C4,10.6715729 4.67157288,10 5.5,10 Z"
                                                    fill="#000000" opacity="0.3" />
                                            </g>
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </button>
                                <!--end::Mobile menu toggle-->
                                <!--begin::Logo image-->
                                <a href="javascript:void(0);">
                                    <h1><span
                                            style="background: linear-gradient(to right, #12CE5D 0%, #FFD80C 100%);-webkit-background-clip: text;-webkit-text-fill-color: transparent;">
                                            <span id="kt_landing_hero_text">Sayur-sayuran</span>
                                        </span></h1>
                                </a>
                                <!--end::Logo image-->
                            </div>
                            <!--end::Logo-->
                            <!--begin::Menu wrapper-->
                            <div class="d-lg-block" id="kt_header_nav_wrapper">
                                <div class="d-lg-block p-5 p-lg-0" data-kt-drawer="true"
                                    data-kt-drawer-name="landing-menu"
                                    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
                                    data-kt-drawer-width="200px" data-kt-drawer-direction="start"
                                    data-kt-drawer-toggle="#kt_landing_menu_toggle" data-kt-swapper="true"
                                    data-kt-swapper-mode="prepend"
                                    data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav_wrapper'}">
                                    <!--begin::Menu-->
                                    <div class="menu menu-column flex-nowrap menu-rounded menu-lg-row menu-title-gray-500 menu-state-title-primary nav nav-flush fs-5 fw-bold"
                                        id="kt_landing_menu">
                                        <!--begin::Menu item-->
                                        <div class="menu-item">
                                            <!--begin::Menu link-->
                                            <a class="menu-link nav-link active py-3 px-4 px-xxl-6"
                                                href="{{ route('dashboard') }}" data-kt-scroll-toggle="true"
                                                data-kt-drawer-dismiss="true">Home</a>
                                            <!--end::Menu link-->
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item">
                                            <!--begin::Menu link-->
                                            <a class="menu-link nav-link py-3 px-4 px-xxl-6"
                                                href="{{ route('product') }}" data-kt-scroll-toggle="true"
                                                data-kt-drawer-dismiss="true">Produk Terdekat</a>
                                            <!--end::Menu link-->
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item">
                                            <!--begin::Menu link-->
                                            <a class="menu-link nav-link py-3 px-4 px-xxl-6" href="#transaksi"
                                                data-kt-scroll-toggle="true" data-kt-drawer-dismiss="true">Transaksi</a>
                                            <!--end::Menu link-->
                                        </div>
                                        <!--begin::Menu item-->
                                        <div class="menu-item">
                                            <!--begin::Menu link-->
                                            <a class="menu-link nav-link py-3 px-4 px-xxl-6" href="{{ route('user.cart') }}"
                                                data-kt-scroll-toggle="true" data-kt-drawer-dismiss="true">Keranjang</a>
                                            <!--end::Menu link-->
                                        </div>
                                    </div>
                                    <!--end::Menu-->
                                </div>
                            </div>
                            <!--end::Menu wrapper-->
                            <!--begin::Toolbar-->
                            @guest
                                <div class="flex-equal text-end ms-1">
                                    <a href="{{ route('login') }}" class="btn btn-secondary">Masuk</a> &nbsp;&nbsp;&nbsp;
                                    <a href="{{ route('register') }}" class="btn btn-success">Daftar</a>
                                </div>
                            @endguest
                            <!--end::Toolbar-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Header-->
            </div>
            <!--end::Wrapper-->
            <!--begin::Curve bottom-->
            <div class="landing-curve landing-dark-color mb-10 mb-lg-20">
                <svg viewBox="15 12 1470 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M0 11C3.93573 11.3356 7.85984 11.6689 11.7725 12H1488.16C1492.1 11.6689 1496.04 11.3356 1500 11V12H1488.16C913.668 60.3476 586.282 60.6117 11.7725 12H0V11Z"
                        fill="currentColor"></path>
                </svg>
            </div>
            <!--end::Curve bottom-->
        </div>
        <!--end::Header Section-->
        <!--begin::How It Works Section-->
        <div class="mb-n10 mb-lg-n20 z-index-2">
            <!--begin::Container-->
            <div class="container">

                {{-- begin::content --}}

                <div class="row">

                    <div class="col-md-5">
                        <div class="card text-dark bg-light mb-2 mt-2">
                            <div class="card-body p-3">
                                <h3 class="card-title text-secondary text-bold"><i class="fa fa-shopping-cart"
                                        style="font-size: 20px"></i> Detail pesanan</h3>
                                <hr class="mt-3">

                                @php
                                    $total_harga = 0;
                                @endphp

                                @foreach ($carts as $cart)
                                    @php
                                        $cart_product = $cart->product;
                                        $total_harga += $cart->price;
                                    @endphp
                                    <div class="cart-products">
                                        <div class="card-product">
                                            <img src="{{ $cart_product->getImage() }}" alt="img" width="100px">
                                            <div class="card-info">
                                                <div>
                                                    <h5>{{ $cart->name }}(x{{ $cart->quantity }})</h5>
                                                    <h6>Stock {{ $cart_product->stock }}</h6>
                                                    <h6>QTY {{ $qty }}</h6>
                                                </div>
                                                <div class="text-end">
                                                    <b class="d-block">RP.
                                                        {{ $cart->price }}(x{{ $cart->quantity }})</b>
                                                    <hr class="mt-2 mb-1">
                                                    <b class="d-block">RP.
                                                        {{ $cart->price * $cart->quantity }}</b>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="mt-2 d-flex justify-content-between px-2">
                                    <h5>Total Harga Barang</h5>
                                    <b>RP. {{ $total_harga }}</b>
                                </div>

                                <div class="mt-2 d-flex justify-content-between px-2">
                                    <h5>Onkos kirim</h5>
                                    <b>RP. {{ $onkir }}</b>
                                </div>

                                <hr class="mt-2">

                                <div class="d-flex justify-content-between px-2">
                                    <h5>Total</h5>
                                    <b>RP. {{ $total_harga + $onkir }}</b>
                                </div>

                            </div>
                        </div>
                        {{-- <div class="card text-dark bg-light mb-2 mt-4">
                            <div class="card-body p-3">
                                <form class="row" method="GET"
                                    action="{{ route('product.checkout', [$product->id, $lat, $lon]) }}">
                                    <div class="col-9">
                                        <input type="number" class="form-control w-100" id="qty" name="qty"
                                            placeholder="QTY" value="{{ $qty }}">
                                    </div>
                                    <div class="col-3">
                                        <button type="submit" class="btn btn-primary btn-sm btn-block">Update</button>
                                    </div>
                                </form>

                            </div>
                        </div> --}}
                    </div>

                    <div class="col-md-7">
                        <div class="card text-dark bg-light mb-2 mt-2">
                            <div class="card-body p-3">
                                <h3 class="card-title text-secondary text-bold"><i class="fa fa-user"
                                        style="font-size: 20px"></i> Info pembeli</h3>
                                <hr class="mt-3">

                                <form method="POST" action="{{ route('product.checkout.beli') }}">
                                    @method('POST')
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    @error('product_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <input type="hidden" name="qty" value="{{ $qty }}">
                                    @error('qty')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <input type="hidden" name="onkir" value="{{ $onkir }}">
                                    @error('onkir')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <input type="hidden" name="total_harga"
                                        value="{{ $product->price * $qty + $onkir }}">
                                    @error('total_harga')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                    <input type="hidden" name="lat_lon" value="{{ "$lat|$lon" }}">
                                    @error('lat_lon')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                    <div class="mb-3">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name"
                                            value="{{ old('first_name') ?? $fake->first_name }}">
                                        @error('first_name')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name"
                                            value="{{ old('last_name') ?? $fake->last_name }}">
                                        @error('last_name')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="noxtel" class="form-label">Nomor telpone</label>
                                        <input type="text" class="form-control" id="noxtel" name="nomor_telp"
                                            value="{{ old('nomor_telp') ?? $fake->nomor_telp }}">
                                        @error('nomor_telp')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email"
                                            value="{{ $fake->email }}" name="email">
                                        @error('email')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <input type="text" class="form-control" id="alamat" name="alamat"
                                            value="{{ old('alamat') ?? $fake->alamat_tujuan }}">
                                        @error('alamat')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="postal_code" class="form-label">Code Pos</label>
                                        <input type="text" class="form-control" id="postal_code" name="postal_code"
                                            value="{{ old('postal_code') ?? $fake->postal_code }}">
                                        @error('postal_code')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="city" class="form-label">Kota</label>
                                        <input type="text" class="form-control" id="city" name="city"
                                            value="{{ old('city') ?? $fake->city }}">
                                        @error('city')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="latlon" class="form-label">Latitude and longitude</label>
                                        <input type="text" class="form-control" id="latlon"
                                            value="{{ "@$lat,$lon" }}" disabled>
                                    </div>

                                    <div class="mb-3">
                                        <label for="note" class="form-label">Catatan</label>
                                        <textarea class="form-control" id="note" rows="3"
                                            name="note">{{ old('note') ?? $fake->catatan }}</textarea>
                                        @error('note')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-sm">
                                        Checkout
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>

                </div>

                {{-- end::content --}}

                <!--begin::Product slider-->
                <div class="tns tns-default">
                    <!--begin::Slider button-->
                    <button class="btn btn-icon btn-active-color-primary" id="kt_team_slider_next1">
                    </button>
                    <!--end::Slider button-->
                </div>
                <!--end::Product slider-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::How It Works Section-->

        <!--begin::Scrolltop-->
        <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
            <!--begin::Svg Icon | path: icons/duotone/Navigation/Up-2.svg-->
            <span class="svg-icon">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                    height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24" />
                        <rect fill="#000000" opacity="0.5" x="11" y="10" width="2" height="10" rx="1" />
                        <path
                            d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z"
                            fill="#000000" fill-rule="nonzero" />
                    </g>
                </svg>
            </span>
            <!--end::Svg Icon-->
        </div>
        <!--end::Scrolltop-->
    </div>
    <!--end::Main-->
</body>
<!--end::Body-->

</html>
