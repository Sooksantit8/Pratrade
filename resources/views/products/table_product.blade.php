@if ($products->count() > 0)
    @foreach ($products as $product)
        <div class="col-sm-6 col-xxl-4">
            <div class="card hover-img overflow-hidden">
                <div class="position-relative">
                    <a href="{{ route('product.detail',['id' => $product->ID]) }}">
                        <img src="{{ asset('storage/' . $product->images->first()->Path_Image) }}" class="card-img-top" alt="modernize-img" style="object-fit: cover; width: 100%; height: 260px;">
                    </a>
                    <a href="javascript:void(0)"
                        class="text-bg-primary rounded-circle p-2 text-white d-inline-flex position-absolute bottom-0 end-0 mb-n3 me-3"
                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add To Cart">
                        <i class="ti ti-basket fs-4"></i>
                    </a>
                </div>
                <div class="card-body pt-3 p-4">
                    <h6 class="fs-4" style="height: 40px">{{ \Illuminate\Support\Str::limit($product->Product_Name, 50, '...') }}</h6>
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="fs-4 mb-0">฿{{ number_format($product->Price) }} <span class="ms-2 fw-normal text-muted fs-3">
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
        @endforeach
    @else
        <div class="alert alert-primary text-center" role="alert">
            ไม่พบข้อมูลสินค้า
        </div>
    @endif
