@forelse ($products as $product)
    <div class="col-md-4 px-5">
        <!--begin::Story-->
        <div class="text-center mb-10 mb-md-0">
            <!--begin::Illustration-->
            <img src="{{ $product->getImage() }}" class="mh-200px mb-9" alt="" />
            <!--end::Illustration-->
            <!--begin::Heading-->
            <div class="d-flex flex-center mb-5">
                <!--begin::Badge-->
                <span class="badge badge-circle badge-light-success fw-bolder p-5 me-3 fs-3"></span>
                <!--end::Badge-->
                <!--begin::Title-->
                <div class="fs-5 fs-lg-3 fw-bolder text-dark">{{ $product->name }}</div>
                <!--end::Title-->
            </div>
            <!--end::Heading-->
            <!--begin::Description-->
            <div class="fw-bold fs-6 fs-lg-4 text-muted">{{ $product->price }}</div>
            @auth
                <a href="{{ route('product.checkout', [$product->id, $laty, $lony]) }}?qty=1" class="btn btn-sm btn-primary">Beli</a>
                <a href="{{ route('product.detail', $product->id) }}" class="btn btn-sm btn-primary">Lihat</a>
            @else
                <button type="button" class="btn btn-sm btn-secondary disabled" disabled>Beli</button>
                <a href="{{ route('product.detail', $product->id) }}" class="btn btn-sm btn-primary">Lihat</a>
            @endauth
            <!--end::Description-->
        </div>
        <!--end::Story-->
    </div>
@empty
    <h4 class="fs-2hx text-dark mb-5" style="text-align:center" data-kt-scroll-offset="{default: 100, lg: 150}">
        Tidak ada Produk Disekitar mu!!
    </h4>
@endforelse
