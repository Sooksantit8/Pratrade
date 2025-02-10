@extends('layouts.app') <!-- ชื่อ Layout -->

@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
      <div class="card-body px-4 py-3">
        <div class="row align-items-center">
          <div class="col-9">
            <h4 class="fw-semibold mb-8">Feed</h4>
          </div>
          <div class="col-3">
            <div class="text-center mb-n5">
              <img src="{{ asset('images/breadcrumb/ChatBc.png')}}" alt="modernize-img" class="img-fluid mb-n4">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card position-relative overflow-hidden">
      <div class="shop-part d-flex w-100">
        <div class="shop-filters flex-shrink-0 border-end d-none d-lg-block">
          <ul class="list-group pt-2 border-bottom rounded-0">
            <h6 class="my-3 mx-4">Filter by Category</h6>
            <li class="list-group-item border-0 p-0 mx-4 mb-2">
              <a class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1" href="javascript:void(0)">
                <i class="ti ti-circles fs-5"></i>All
              </a>
            </li>
            <li class="list-group-item border-0 p-0 mx-4 mb-2">
              <a class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1" href="javascript:void(0)">
                <i class="ti ti-hanger fs-5"></i>Fashion
              </a>
            </li>
            <li class="list-group-item border-0 p-0 mx-4 mb-2">
              <a class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1" href="javascript:void(0)">
                <i class="ti ti-notebook fs-5"></i>Books
              </a>
            </li>
            <li class="list-group-item border-0 p-0 mx-4 mb-2">
              <a class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1" href="javascript:void(0)">
                <i class="ti ti-mood-smile fs-5"></i>Toys
              </a>
            </li>
            <li class="list-group-item border-0 p-0 mx-4 mb-2">
              <a class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1" href="javascript:void(0)">
                <i class="ti ti-device-laptop fs-5"></i>Electronics
              </a>
            </li>
          </ul>
          <ul class="list-group pt-2 border-bottom rounded-0">
            <h6 class="my-3 mx-4">Sort By</h6>
            <li class="list-group-item border-0 p-0 mx-4 mb-2">
              <a class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1" href="javascript:void(0)">
                <i class="ti ti-ad-2 fs-5"></i>Newest
              </a>
            </li>
            <li class="list-group-item border-0 p-0 mx-4 mb-2">
              <a class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1" href="javascript:void(0)">
                <i class="ti ti-sort-ascending-2 fs-5"></i>Price: High-Low
              </a>
            </li>
            <li class="list-group-item border-0 p-0 mx-4 mb-2">
              <a class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1" href="javascript:void(0)">
                <i class="ti ti-sort-descending-2 fs-5"></i>
                Price: Low-High
              </a>
            </li>
            <li class="list-group-item border-0 p-0 mx-4 mb-2">
              <a class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1" href="javascript:void(0)">
                <i class="ti ti-ad-2 fs-5"></i>Discounted
              </a>
            </li>
          </ul>
          <div class="by-gender border-bottom rounded-0">
            <h6 class="mt-4 mb-3 mx-4 fw-semibold">By Gender</h6>
            <div class="pb-4 px-4">
              <div class="form-check py-2 mb-0">
                <input class="form-check-input p-2" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked="">
                <label class="form-check-label d-flex align-items-center ps-2" for="exampleRadios1">
                  All
                </label>
              </div>
              <div class="form-check py-2 mb-0">
                <input class="form-check-input p-2" type="radio" name="exampleRadios" id="exampleRadios2" value="option1">
                <label class="form-check-label d-flex align-items-center ps-2" for="exampleRadios2">
                  Men
                </label>
              </div>
              <div class="form-check py-2 mb-0">
                <input class="form-check-input p-2" type="radio" name="exampleRadios" id="exampleRadios3" value="option1">
                <label class="form-check-label d-flex align-items-center ps-2" for="exampleRadios3">
                  Women
                </label>
              </div>
              <div class="form-check py-2 mb-0">
                <input class="form-check-input p-2" type="radio" name="exampleRadios" id="exampleRadios4" value="option1">
                <label class="form-check-label d-flex align-items-center ps-2" for="exampleRadios4">
                  Kids
                </label>
              </div>
            </div>
          </div>
          <div class="by-pricing border-bottom rounded-0">
            <h6 class="mt-4 mb-3 mx-4 fw-semibold">By Pricing</h6>
            <div class="pb-4 px-4">
              <div class="form-check py-2 mb-0">
                <input class="form-check-input p-2" type="radio" name="exampleRadios" id="exampleRadios5" value="option1" checked="">
                <label class="form-check-label d-flex align-items-center ps-2" for="exampleRadios5">
                  All
                </label>
              </div>
              <div class="form-check py-2 mb-0">
                <input class="form-check-input p-2" type="radio" name="exampleRadios" id="exampleRadios6" value="option1">
                <label class="form-check-label d-flex align-items-center ps-2" for="exampleRadios6">
                  0-50
                </label>
              </div>
              <div class="form-check py-2 mb-0">
                <input class="form-check-input p-2" type="radio" name="exampleRadios" id="exampleRadios7" value="option1">
                <label class="form-check-label d-flex align-items-center ps-2" for="exampleRadios7">
                  50-100
                </label>
              </div>
              <div class="form-check py-2 mb-0">
                <input class="form-check-input p-2" type="radio" name="exampleRadios" id="exampleRadios8" value="option1">
                <label class="form-check-label d-flex align-items-center ps-2" for="exampleRadios8">
                  100-200
                </label>
              </div>
              <div class="form-check py-2 mb-0">
                <input class="form-check-input p-2" type="radio" name="exampleRadios" id="exampleRadios9" value="option1">
                <label class="form-check-label d-flex align-items-center ps-2" for="exampleRadios9">
                  Over 200
                </label>
              </div>
            </div>
          </div>
          <div class="by-colors border-bottom rounded-0">
            <h6 class="mt-4 mb-3 mx-4 fw-semibold">By Colors</h6>
            <div class="pb-4 px-4">
              <ul class="list-unstyled d-flex flex-wrap align-items-center gap-2 mb-0">
                <li class="shop-color-list">
                  <a class="shop-colors-item rounded-circle d-block shop-colors-1" href="javascript:void(0)"></a>
                </li>
                <li class="shop-color-list">
                  <a class="shop-colors-item rounded-circle d-block shop-colors-2" href="javascript:void(0)"></a>
                </li>
                <li class="shop-color-list">
                  <a class="shop-colors-item rounded-circle d-block shop-colors-3" href="javascript:void(0)"></a>
                </li>
                <li class="shop-color-list">
                  <a class="shop-colors-item rounded-circle d-block shop-colors-4" href="javascript:void(0)"></a>
                </li>
                <li class="shop-color-list">
                  <a class="shop-colors-item rounded-circle d-block shop-colors-5" href="javascript:void(0)"></a>
                </li>
                <li class="shop-color-list">
                  <a class="shop-colors-item rounded-circle d-block shop-colors-6" href="javascript:void(0)"></a>
                </li>
                <li class="shop-color-list">
                  <a class="shop-colors-item rounded-circle d-block shop-colors-7" href="javascript:void(0)"></a>
                </li>
              </ul>
            </div>
          </div>
          <div class="p-4">
            <a href="javascript:void(0)" class="btn btn-primary w-100">Reset Filters</a>
          </div>
        </div>
        <div class="card-body p-4 pb-0">
          <div class="d-flex justify-content-between align-items-center gap-6 mb-4">
            <a class="btn btn-primary d-lg-none d-flex" data-bs-toggle="offcanvas" href="#filtercategory" role="button" aria-controls="filtercategory">
              <i class="ti ti-filter fs-6"></i>
            </a>
            <h5 class="fs-5 mb-0 d-none d-lg-block">Products</h5>
            <form class="position-relative">
              <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh" placeholder="Search Product">
              <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
            </form>
          </div>
          <div class="row">
            <div class="col-sm-6 col-xxl-4">
              <div class="card hover-img overflow-hidden">
                <div class="position-relative">
                  <a href="../main/eco-shop-detail.html">
                    <img src="{{asset('images/products/s11.jpg')}}" class="card-img-top" alt="modernize-img">
                  </a>
                  <a href="javascript:void(0)" class="text-bg-primary rounded-circle p-2 text-white d-inline-flex position-absolute bottom-0 end-0 mb-n3 me-3" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add To Cart">
                    <i class="ti ti-basket fs-4"></i>
                  </a>
                </div>
                <div class="card-body pt-3 p-4">
                  <h6 class="fs-4">Super Games</h6>
                  <div class="d-flex align-items-center justify-content-between">
                    <h6 class="fs-4 mb-0">$285 <span class="ms-2 fw-normal text-muted fs-3">
                        <del>$345</del>
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
        <div class="offcanvas offcanvas-start" tabindex="-1" id="filtercategory" aria-labelledby="filtercategoryLabel">
          <div class="offcanvas-body shop-filters w-100 p-0">
            <ul class="list-group pt-2 border-bottom rounded-0">
              <h6 class="my-3 mx-4">Filter by Category</h6>
              <li class="list-group-item border-0 p-0 mx-4 mb-2">
                <a class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1" href="javascript:void(0)">
                  <i class="ti ti-circles fs-5"></i>All
                </a>
              </li>
              <li class="list-group-item border-0 p-0 mx-4 mb-2">
                <a class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1" href="javascript:void(0)">
                  <i class="ti ti-hanger fs-5"></i>Fashion
                </a>
              </li>
              <li class="list-group-item border-0 p-0 mx-4 mb-2">
                <a class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1" href="javascript:void(0)">
                  <i class="ti ti-notebook fs-5"></i>
                  Books
                </a>
              </li>
              <li class="list-group-item border-0 p-0 mx-4 mb-2">
                <a class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1" href="javascript:void(0)">
                  <i class="ti ti-mood-smile fs-5"></i>Toys
                </a>
              </li>
              <li class="list-group-item border-0 p-0 mx-4 mb-2">
                <a class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1" href="javascript:void(0)">
                  <i class="ti ti-device-laptop fs-5"></i>Electronics
                </a>
              </li>
            </ul>
            <ul class="list-group pt-2 border-bottom rounded-0">
              <h6 class="my-3 mx-4">Sort By</h6>
              <li class="list-group-item border-0 p-0 mx-4 mb-2">
                <a class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1" href="javascript:void(0)">
                  <i class="ti ti-ad-2 fs-5"></i>Newest
                </a>
              </li>
              <li class="list-group-item border-0 p-0 mx-4 mb-2">
                <a class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1" href="javascript:void(0)">
                  <i class="ti ti-sort-ascending-2 fs-5"></i>Price: High-Low
                </a>
              </li>
              <li class="list-group-item border-0 p-0 mx-4 mb-2">
                <a class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1" href="javascript:void(0)">
                  <i class="ti ti-sort-descending-2 fs-5"></i>
                  Price: Low-High
                </a>
              </li>
              <li class="list-group-item border-0 p-0 mx-4 mb-2">
                <a class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1" href="javascript:void(0)">
                  <i class="ti ti-ad-2 fs-5"></i>Discounted
                </a>
              </li>
            </ul>
            <div class="by-gender border-bottom rounded-0">
              <h6 class="mt-4 mb-3 mx-4 fw-semibold">By Gender</h6>
              <div class="pb-4 px-4">
                <div class="form-check py-2 mb-0">
                  <input class="form-check-input p-2" type="radio" name="exampleRadios" id="exampleRadios10" value="option1" checked="">
                  <label class="form-check-label d-flex align-items-center ps-2" for="exampleRadios10">
                    All
                  </label>
                </div>
                <div class="form-check py-2 mb-0">
                  <input class="form-check-input p-2" type="radio" name="exampleRadios" id="exampleRadios11" value="option1">
                  <label class="form-check-label d-flex align-items-center ps-2" for="exampleRadios11">
                    Men
                  </label>
                </div>
                <div class="form-check py-2 mb-0">
                  <input class="form-check-input p-2" type="radio" name="exampleRadios" id="exampleRadios12" value="option1">
                  <label class="form-check-label d-flex align-items-center ps-2" for="exampleRadios12">
                    Women
                  </label>
                </div>
                <div class="form-check py-2 mb-0">
                  <input class="form-check-input p-2" type="radio" name="exampleRadios" id="exampleRadios13" value="option1">
                  <label class="form-check-label d-flex align-items-center ps-2" for="exampleRadios13">
                    Kids
                  </label>
                </div>
              </div>
            </div>
            <div class="by-pricing border-bottom rounded-0">
              <h6 class="mt-4 mb-3 mx-4 fw-semibold">By Pricing</h6>
              <div class="pb-4 px-4">
                <div class="form-check py-2 mb-0">
                  <input class="form-check-input p-2" type="radio" name="exampleRadios" id="exampleRadios14" value="option1" checked="">
                  <label class="form-check-label d-flex align-items-center ps-2" for="exampleRadios14">
                    All
                  </label>
                </div>
                <div class="form-check py-2 mb-0">
                  <input class="form-check-input p-2" type="radio" name="exampleRadios" id="exampleRadios15" value="option1">
                  <label class="form-check-label d-flex align-items-center ps-2" for="exampleRadios15">
                    0-50
                  </label>
                </div>
                <div class="form-check py-2 mb-0">
                  <input class="form-check-input p-2" type="radio" name="exampleRadios" id="exampleRadios16" value="option1">
                  <label class="form-check-label d-flex align-items-center ps-2" for="exampleRadios16">
                    50-100
                  </label>
                </div>
                <div class="form-check py-2 mb-0">
                  <input class="form-check-input p-2" type="radio" name="exampleRadios" id="exampleRadios17" value="option1">
                  <label class="form-check-label d-flex align-items-center ps-2" for="exampleRadios17">
                    100-200
                  </label>
                </div>
                <div class="form-check py-2 mb-0">
                  <input class="form-check-input p-2" type="radio" name="exampleRadios" id="exampleRadios18" value="option1">
                  <label class="form-check-label d-flex align-items-center ps-2" for="exampleRadios18">
                    Over 200
                  </label>
                </div>
              </div>
            </div>
            <div class="by-colors border-bottom rounded-0">
              <h6 class="mt-4 mb-3 mx-4 fw-semibold">By Colors</h6>
              <div class="pb-4 px-4">
                <ul class="list-unstyled d-flex flex-wrap align-items-center gap-2 mb-0">
                  <li class="shop-color-list">
                    <a class="shop-colors-item rounded-circle d-block shop-colors-1" href="javascript:void(0)"></a>
                  </li>
                  <li class="shop-color-list">
                    <a class="shop-colors-item rounded-circle d-block shop-colors-2" href="javascript:void(0)"></a>
                  </li>
                  <li class="shop-color-list">
                    <a class="shop-colors-item rounded-circle d-block shop-colors-3" href="javascript:void(0)"></a>
                  </li>
                  <li class="shop-color-list">
                    <a class="shop-colors-item rounded-circle d-block shop-colors-4" href="javascript:void(0)"></a>
                  </li>
                  <li class="shop-color-list">
                    <a class="shop-colors-item rounded-circle d-block shop-colors-5" href="javascript:void(0)"></a>
                  </li>
                  <li class="shop-color-list">
                    <a class="shop-colors-item rounded-circle d-block shop-colors-6" href="javascript:void(0)"></a>
                  </li>
                  <li class="shop-color-list">
                    <a class="shop-colors-item rounded-circle d-block shop-colors-7" href="javascript:void(0)"></a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="p-4">
              <a href="javascript:void(0)" class="btn btn-primary w-100">Reset Filters</a>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection