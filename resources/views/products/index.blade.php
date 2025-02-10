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
                        <img src="{{ asset('images/breadcrumb/ChatBc.png') }}" alt="modernize-img" class="img-fluid mb-n4">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card position-relative overflow-hidden">
        <div class="shop-part d-flex w-100">
            <div class="shop-filters flex-shrink-0 border-end d-none d-lg-block">
                <ul class="list-group pt-2 border-bottom rounded-0">
                    <h6 class="my-3 mx-4">หมวดหมู่สินค้า</h6>
                    @foreach ($categories as $category)
                        <li class="list-group-item border-0 p-0 mx-4 mb-2">
                            <a class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1"
                                href="javascript:void(0)">
                                <i class="ti ti-category fs-5"></i>{{ $category->Category_name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
                <ul class="list-group pt-2 border-bottom rounded-0">
                    <h6 class="my-3 mx-4">การเรียงข้อมูล</h6>
                    <li class="list-group-item border-0 p-0 mx-4 mb-2">
                        <a class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1"
                            href="javascript:void(0)">
                            <i class="ti ti-ad-2 fs-5"></i>ใหม่ที่สุด
                        </a>
                    </li>
                    <li class="list-group-item border-0 p-0 mx-4 mb-2">
                        <a class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1"
                            href="javascript:void(0)">
                            <i class="ti ti-sort-ascending-2 fs-5"></i>ราคา: สูง-ต่ำ
                        </a>
                    </li>
                    <li class="list-group-item border-0 p-0 mx-4 mb-2">
                        <a class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1"
                            href="javascript:void(0)">
                            <i class="ti ti-sort-descending-2 fs-5"></i>
                            ราคา: ต่ำ-สูง
                        </a>
                    </li>
                </ul>
                <div class="p-4">
                    <a href="javascript:void(0)" class="btn btn-primary w-100">ล้าง การกรองข้อมูล</a>
                </div>
            </div>
            <div class="card-body p-4 pb-0">
                <div class="d-flex justify-content-between align-items-center gap-6 mb-4">
                    <a class="btn btn-primary d-lg-none d-flex" data-bs-toggle="offcanvas" href="#filtercategory"
                        role="button" aria-controls="filtercategory">
                        <i class="ti ti-filter fs-6"></i>
                    </a>
                    <h5 class="fs-5 mb-0 d-none d-lg-block">สินค้า</h5>
                    <form class="position-relative">
                        <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh"
                            placeholder="ค้นหา สินค้า" aria-autocomplete="none">
                        <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                    </form>
                </div>
                <div id="cardContainer" class="row">
                </div>
                <div id="loading" style="display: none; text-align: center;">
                    <span>Loading...</span>
                </div>
            </div>
            <div class="offcanvas offcanvas-start" tabindex="-1" id="filtercategory" aria-labelledby="filtercategoryLabel">
                <div class="offcanvas-body shop-filters w-100 p-0">
                    <ul class="list-group pt-2 border-bottom rounded-0">
                        <h6 class="my-3 mx-4">หมวดหมู่สินค้า</h6>
                        @foreach ($categories as $category)
                            <li class="list-group-item border-0 p-0 mx-4 mb-2">
                                <a class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1"
                                    href="javascript:void(0)">
                                    <i class="ti ti-category fs-5"></i>{{ $category->Category_name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <ul class="list-group pt-2 border-bottom rounded-0">
                        <h6 class="my-3 mx-4">การเรียงข้อมูล</h6>
                        <li class="list-group-item border-0 p-0 mx-4 mb-2">
                            <a class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1"
                                href="javascript:void(0)">
                                <i class="ti ti-ad-2 fs-5"></i>ใหม่ที่สุด
                            </a>
                        </li>
                        <li class="list-group-item border-0 p-0 mx-4 mb-2">
                            <a class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1"
                                href="javascript:void(0)">
                                <i class="ti ti-sort-ascending-2 fs-5"></i>ราคา: สูง-ต่ำ
                            </a>
                        </li>
                        <li class="list-group-item border-0 p-0 mx-4 mb-2">
                            <a class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-6 rounded-1"
                                href="javascript:void(0)">
                                <i class="ti ti-sort-descending-2 fs-5"></i>
                                ราคา: ต่ำ-สูง
                            </a>
                        </li>
                    </ul>
                    <div class="p-4">
                        <a href="javascript:void(0)" class="btn btn-primary w-100">ล้าง การกรองข้อมูล</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '/product/tableproduct',
                type: 'GET',
                success: function(data) {
                    $("#cardContainer").html(data)
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });
        $(document).ready(function() {
            let page = 1; // หน้าแรก
            let isLoading = false; // สถานะการโหลดข้อมูล

            $(window).on('scroll', function() {
                // ตรวจสอบว่าเลื่อนถึงจุดสิ้นสุดของหน้าแล้วหรือยัง
                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 50) {
                    if (!isLoading) {
                        page++;
                        loadMoreProducts(page);
                    }
                }
            });

            // $('#cardContainer').on('scroll', function() {
            //     const container = $(this);

            //     // ตรวจสอบว่าถึงจุดสิ้นสุดแล้วหรือยัง
            //     if (container.scrollTop() + container.innerHeight() >= container[0].scrollHeight - 50) {
            //         if (!isLoading) {
            //             page++;
            //             loadMoreProducts(page);
            //         }
            //     }
            // });

            function loadMoreProducts(page) {
                isLoading = true;
                $('#loading').show();

                $.ajax({
                    url: `/product/tableproduct?page=${page}`, // URL ของ API
                    type: 'GET',
                    success: function(data) {
                        if (data.trim() === '') {
                            // ไม่มีข้อมูลเพิ่มเติม
                            $('#loading').hide();
                        } else {
                            $('#cardContainer').append(data);
                            isLoading = false;
                            $('#loading').hide();
                        }
                    },
                    error: function() {
                        alert('Error loading more products.');
                        isLoading = false;
                        $('#loading').hide();
                    }
                });
            }
        });
    </script>
@endpush
