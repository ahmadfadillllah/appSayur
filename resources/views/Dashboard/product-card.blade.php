@forelse ($products as $product)
    <div class="col-md-4 px-5">
        <!--begin::Story-->
        <div class="text-center mb-10 mb-md-0">
            <!--begin::Illustration-->
            <img src="{{ $product->getImage() }}" class="mh-200px mb-9" alt="" />
            <!--end::Illustration-->
            <!--begin::Heading-->
            <div class="d-flex flex-center mb-2">
                <!--begin::Badge-->
                {{-- <span class="badge badge-circle badge-light-success fw-bolder p-5 me-3 fs-3"></span> --}}
                <!--end::Badge-->
                <!--begin::Title-->
                <div class="fs-5 fs-lg-3 fw-bolder text-dark">{{ $product->name }}</div>
                <!--end::Title-->
            </div>
            <!--end::Heading-->
            <!--begin::Description-->
            <div class="fw-bold fs-6 fs-lg-4 text-muted mb-3">RP. {{ $product->price }} | Stock {{ $product->stock }}
            </div>

            @auth
                <form action="{{ route('product.add') }}" method="get" style="display: inline-block">
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="qty" value="1">
                    <button type="submit" class="btn btn-sm btn-primary">Add to cart</button>
                </form>

                {{-- <a href="{{ route('product.checkout', [$product->id, $laty, $lony]) }}?qty=1" class="btn btn-sm btn-primary">Beli</a> --}}
                <a href="{{ route('product.detail', $product->id) }}" class="btn btn-sm btn-primary">Show</a>

            @else
                <button type="button" disabled class="btn btn-sm btn-primary">Add to cart</button>

                {{-- <button type="button" class="btn btn-sm btn-secondary disabled" disabled>Beli</button> --}}
                <a href="{{ route('product.detail', $product->id) }}" class="btn btn-sm btn-primary">Show</a>
            @endauth

            <div id="p{{ $product->id }}" class="modal-dialog d-none">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="btn-close" data-izimodal-close=""
                            data-izimodal-transitionout="bounceOutDown" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Modal body text goes here.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-izimodal-close=""
                            data-izimodal-transitionout="bounceOutDown">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>

            <!--end::Description-->
        </div>
        <!--end::Story-->
    </div>
@empty
    <h4 class="fs-2hx text-dark mb-5" style="text-align:center" data-kt-scroll-offset="{default: 100, lg: 150}">
        Tidak ada Produk Disekitar mu!! <button class="btn btn-primary btn-sm" type="button"
            onclick="getLocationCustomer()">refresh</button>
    </h4>
@endforelse
