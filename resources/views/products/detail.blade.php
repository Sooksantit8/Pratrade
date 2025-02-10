@extends('layouts.app') <!-- ชื่อ Layout -->

@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">รายละเอียดสินค้า</h4>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="{{ asset('images/breadcrumb/ChatBc.png')}}" alt="modernize-img" class="img-fluid mb-n4" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="shop-detail">
        <div class="card shadow-none border">
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-lg-6">
                        <div id="sync1" class="owl-carousel owl-theme">
                            @foreach ($product->images as $image)
                                <div class="item rounded-4 overflow-hidden">
                                <img src="{{ asset('storage/' . $image->Path_Image) }}" alt="modernize-img" class="img-fluid cover-image">
                            </div>
                            @endforeach
                        </div>

                        <div id="sync2" class="owl-carousel owl-theme">
                            @foreach ($product->images as $image)
                                <div class="item rounded-4 overflow-hidden">
                                <img src="{{ asset('storage/' . $image->Path_Image) }}" alt="modernize-img" class="img-fluid cover-image-mini">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="shop-content">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <span class="badge text-bg-success fs-2 fw-semibold">In Stock</span>
                                <span class="fs-2">books</span>
                            </div>
                            <h4 class="mb-3">{{$product->Product_name}}</h4>
                            <p class="mb-3">หมวดหมู่สินค้า​: {{ $category_names }}</p>
                            <h4>
                                
                                ฿{{ number_format($product->Price) }}
                            </h4>
                            <div class="d-flex align-items-center gap-8 pb-3 border-bottom">
                            </div>
                            <div class="d-flex align-items-center gap-7 pb-7 mb-7 border-bottom mt-4">
                                <h6 class="mb-0 fs-4">จำนวน:</h6>
                                <div class="input-group input-group-sm rounded">
                                    <button
                                        class="btn minus min-width-40 py-0 border-end border-muted fs-5 border-end-0 text-muted"
                                        type="button" id="add1">
                                        <i class="ti ti-minus"></i>
                                    </button>
                                    <input type="text"
                                        class="min-width-40 flex-grow-0 border border-muted text-muted fs-4 fw-semibold form-control text-center qty"
                                        placeholder="" aria-label="Example text with button addon"
                                        aria-describedby="add1" value="1">
                                    <button
                                        class="btn min-width-40 py-0 border border-muted fs-5 border-start-0 text-muted add"
                                        type="button" id="addo2">
                                        <i class="ti ti-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="d-sm-flex align-items-center gap-6 pt-8 mb-7">
                                <a href="javascript:void(0)" class="btn d-block btn-primary px-5 py-8 mb-6 mb-sm-0">ซื้อสินค้า</a>
                                <a href="javascript:void(0)" class="btn d-block btn-danger px-7 py-8">เพิ่มไปยังรถเข็น</a>
                            </div>
                            <p class="mb-0">Dispatched in 2-3 weeks</p>
                            <a href="javascript:void(0)">Why the longer time for delivery?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow-none border">
            <div class="card-body p-4">
                <ul class="nav nav-pills user-profile-tab border-bottom" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link position-relative rounded-0 active d-flex align-items-center justify-content-center bg-transparent fs-3 py-6"
                            id="pills-description-tab" data-bs-toggle="pill" data-bs-target="#pills-description"
                            type="button" role="tab" aria-controls="pills-description" aria-selected="true">
                            รายละเอียดสินค้า
                        </button>
                    </li>
                </ul>
                <div class="tab-content pt-4" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-description" role="tabpanel"
                        aria-labelledby="pills-description-tab" tabindex="0">
                        {!! $product->Description !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="related-products pt-7">
            <h4 class="mb-3 fw-semibold">Related Products</h4>
            <div class="row">
                <div class="col-sm-6 col-xl-3">
                    <div class="card hover-img overflow-hidden">
                        <div class="position-relative">
                            <a href="javascript:void(0)">
                                <img src="{{ asset('images/products/s2.jpg')}}" class="card-img-top" alt="modernize-img">
                            </a>
                        </div>
                        <div class="card-body pt-3 p-4">
                            <h6 class="fs-4">Body Lotion</h6>
                            <div class="d-flex align-items-center justify-content-between">
                                <h6 class="fs-4 mb-0">$89 <span class="ms-2 fw-normal text-muted fs-3">
                                        <del>$99</del>
                                    </span>
                                </h6>
                                <ul class="list-unstyled d-flex align-items-center mb-0">
                                    <li>
                                        <a class="me-1" href="javascript:void(0)">
                                            <i class="ti ti-star text-warning"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="me-1" href="javascript:void(0)">
                                            <i class="ti ti-star text-warning"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="me-1" href="javascript:void(0)">
                                            <i class="ti ti-star text-warning"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="me-1" href="javascript:void(0)">
                                            <i class="ti ti-star text-warning"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <i class="ti ti-star text-warning"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="card hover-img overflow-hidden">
                        <div class="position-relative">
                            <a href="javascript:void(0)">
                                <img src="{{ asset('images/products/s4.jpg')}}" class="card-img-top" alt="modernize-img">
                            </a>
                        </div>
                        <div class="card-body pt-3 p-4">
                            <h6 class="fs-4">Glossy Solution</h6>
                            <div class="d-flex align-items-center justify-content-between">
                                <h6 class="fs-4 mb-0">$50 <span class="ms-2 fw-normal text-muted fs-3">
                                        <del>$65</del>
                                    </span>
                                </h6>
                                <ul class="list-unstyled d-flex align-items-center mb-0">
                                    <li>
                                        <a class="me-1" href="javascript:void(0)">
                                            <i class="ti ti-star text-warning"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="me-1" href="javascript:void(0)">
                                            <i class="ti ti-star text-warning"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="me-1" href="javascript:void(0)">
                                            <i class="ti ti-star text-warning"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="me-1" href="javascript:void(0)">
                                            <i class="ti ti-star text-warning"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <i class="ti ti-star text-warning"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="card hover-img overflow-hidden">
                        <div class="position-relative">
                            <a href="javascript:void(0)">
                                <img src="{{ asset('images/products/s5.jpg')}}" class="card-img-top" alt="modernize-img">
                            </a>
                        </div>
                        <div class="card-body pt-3 p-4">
                            <h6 class="fs-4">Derma-E</h6>
                            <div class="d-flex align-items-center justify-content-between">
                                <h6 class="fs-4 mb-0">$650 <span class="ms-2 fw-normal text-muted fs-3">
                                        <del>$900</del>
                                    </span>
                                </h6>
                                <ul class="list-unstyled d-flex align-items-center mb-0">
                                    <li>
                                        <a class="me-1" href="javascript:void(0)">
                                            <i class="ti ti-star text-warning"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="me-1" href="javascript:void(0)">
                                            <i class="ti ti-star text-warning"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="me-1" href="javascript:void(0)">
                                            <i class="ti ti-star text-warning"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="me-1" href="javascript:void(0)">
                                            <i class="ti ti-star text-warning"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <i class="ti ti-star text-warning"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="card hover-img overflow-hidden">
                        <div class="position-relative">
                            <a href="javascript:void(0)">
                                <img src="{{ asset('images/products/s6.jpg')}}" class="card-img-top" alt="modernize-img">
                            </a>
                        </div>
                        <div class="card-body pt-3 p-4">
                            <h6 class="fs-4">SockSoho</h6>
                            <div class="d-flex align-items-center justify-content-between">
                                <h6 class="fs-4 mb-0">$25 <span class="ms-2 fw-normal text-muted fs-3">
                                        <del>$31</del>
                                    </span>
                                </h6>
                                <ul class="list-unstyled d-flex align-items-center mb-0">
                                    <li>
                                        <a class="me-1" href="javascript:void(0)">
                                            <i class="ti ti-star text-warning"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="me-1" href="javascript:void(0)">
                                            <i class="ti ti-star text-warning"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="me-1" href="javascript:void(0)">
                                            <i class="ti ti-star text-warning"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="me-1" href="javascript:void(0)">
                                            <i class="ti ti-star text-warning"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">
                                            <i class="ti ti-star text-warning"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
