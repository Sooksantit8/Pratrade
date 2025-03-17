@extends('layouts.app') <!-- ชื่อ Layout -->

@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">รายการที่ลงประกาศ</h4>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="{{ asset('images/breadcrumb/ChatBc.png') }}" alt="modernize-img" class="img-fluid mb-n4">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="datatables">
        <div class="card card-body">
            <div class="row">
                <div class="col-md-3 col-xl-3">
                    <form class="position-relative">
                        <input type="text" class="form-control product-search ps-5 mb-1 mt-1"
                            id="input-search-Productname" placeholder="ค้นหาสินค้า">
                        <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                    </form>
                </div>
                <div class="col-md-3 col-xl-3">
                    <form class="position-relative">
                        <select class="form-select mr-sm-2  mb-1 mt-1" id="input-search-statusproduct">
                            <option value="">--สถานะสินค้า--</option>
                            @foreach ($preorders as $item)
                                <option value="{{ $item->Lookup_code }}">
                                    {{ $item->Lookup_name }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <div class="col-md-6 col-xl-6 text-end d-flex justify-content-md-start justify-content-center">
                    <a href="javascript:void(0)" id="btn-search"
                        class="btn btn-primary d-flex align-items-center mb-1 mt-1">
                        <i class="ti ti-search text-white me-1 fs-5"></i>ค้นหา
                    </a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="ProductTable" class="table table-striped table-bordered text-nowrap align-middle"
                        style="width: 100%">
                        <thead>
                            <tr>
                                <th>ชื่อสินค้า</th>
                                <th>ราคาสินค้า</th>
                                <th>จำนวนสินค้า</th>
                                <th>สถานะสินค้า</th>
                                <th>สถานะการสั่งจอง</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            const table = $('#ProductTable').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: "{{ route('product.data') }}",
                    data: function(d) {
                        // ส่งค่า input filters ไปที่ server
                        d.search_productname = $('#input-search-Productname').val();
                        d.search_statusproduct = $("#input-search-statusproduct").val();
                    },
                },
                columns: [{
                        data: 'Product_Name',
                        name: 'Product_Name'
                    },
                    {
                        data: 'Price',
                        name: 'Price'
                    },
                    {
                        data: 'Stock_qty',
                        name: 'Stock_qty'
                    },
                    {
                        data: 'Preorderstatus',
                        name: 'Preorderstatus'
                    },
                    {
                        data: 'Substatusproduct',
                        name: 'Substatusproduct',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                ],
                columnDefs: [{
                        width: '5%',
                        targets: 5
                    }, // กำหนดขนาดแบบเฉพาะเจาะจง
                    {
                        targets: [1, 2], // คอลัมน์ที่ต้องการจัด format
                        render: function(data, type, row) {
                            if (type === 'display' || type === 'filter') {
                                return parseFloat(data).toLocaleString('en-US', {
                                    minimumFractionDigits: 2
                                });
                            }
                            return data;
                        },
                        className: 'text-end' // จัดให้ชิดขวา
                    }
                ],
            });
            $("#btn-search").click(function() {
                table.draw();
            });
        });
    </script>
@endpush
