@extends('layouts.app') <!-- ชื่อ Layout -->

@section('content')
<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">หมวดหมู่สินค้า</h4>
            </div>
            <div class="col-3">
                <div class="text-center mb-n5">
                    <img src="{{ asset('images/breadcrumb/ChatBc.png') }}" alt="modernize-img"
                        class="img-fluid mb-n4" />
                </div>
            </div>
        </div>
    </div>
</div>

<div class="datatables">
    <div class="action-btn layout-top-spacing mb-3 d-flex align-items-center justify-content-end flex-wrap gap-6">
        <a href="{{ route('categories.create') }}" class="btn waves-effect waves-light btn-primary mb-2">
            เพิ่มหมวดหมู่สินค้า
        </a>
    </div>
    <div class="card card-body">
        <div class="row">
            <div class="col-md-3 col-xl-3">
                <form class="position-relative">
                    <input type="text" class="form-control product-search ps-5 mb-1 mt-1" id="input-search-categoryname"
                        name="search_categoryname" placeholder="ค้นหาหมวดหมู่สินค้า">
                    <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                </form>
            </div>
            <div class="col-md-8 col-xl-9 text-end d-flex justify-content-md-start justify-content-center">
                <a href="javascript:void(0)" id="btn-search" class="btn btn-primary d-flex align-items-center mb-1 mt-1">
                    <i class="ti ti-search text-white me-1 fs-5"></i>ค้นหา
                </a>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="categoryTable" class="table table-striped table-bordered text-nowrap align-middle"
                    style="width: 100%">
                    <thead>
                        <tr>
                            <th>หมวดหมู่สินค้า</th>
                            <th>จัดการ</th>
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
        $(document).ready(function () {
            const table = $('#categoryTable').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: "{{ route('categories.data') }}",
                    data: function (d) {
                        // ส่งค่า input filters ไปที่ server
                        d.search_categoryname = $('#input-search-categoryname').val();
                    },
                },
                columns: [{
                    data: 'Category_name',
                    name: 'Category_name'
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
                    targets: 1
                }, // กำหนดขนาดแบบเฉพาะเจาะจง
                ],
            });
            $("#btn-search").click(function () {
                table.draw();
            });
        });



        function deletecategory(id) {
            Swal.fire({
                title: "คุณแน่ใจหรือไม่?",
                text: "คุณจะไม่สามารถย้อนกลับสิ่งนี้ได้!",
                type: "warning",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "ยืนยัน",
                cancelButtonText: "ยกเลิก",
                closeOnConfirm: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    // ส่งคำขอลบผ่าน Ajax
                    $.ajax({
                        url: '/categories/destroy/' + id, // แก้ไขเป็น /categories/{id}
                        type: 'DELETE',
                        success: function (response) {
                            if (response.success) {
                                Swal.fire(
                                    response.success,
                                    "",
                                    "success"
                                ).then((result) => {
                                    window.location.href = "{{ route('categories.index') }}";
                                });
                            }
                        },
                        error: function (xhr) {
                            toastr.error("ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้", {
                                positionClass: "toastr toast-top-right",
                                containerId: "toast-top-right",
                            });
                        }
                    });
                }
            });
        }
    </script>
@endpush