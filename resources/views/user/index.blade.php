@extends('layouts.app') <!-- ชื่อ Layout -->

@section('content')
<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">User</h4>
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
<div class="card card-body">
    <div class="row">
        <div class="col-md-3 col-xl-3">
            <div class="position-relative">
                <input type="text" class="form-control ps-5 mb-1 mt-1" id="input-search-Username" name="search_Username"
                    placeholder="ค้นหาUsername">
                <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
            </div>
        </div>
        <div class="col-md-3 col-xl-3">
            <div class="position-relative">
                <input type="text" class="form-control ps-5 mb-1 mt-1" id="input-search-Name" name="search_Name"
                    placeholder="ค้นหาชื่อ-นามสกุล">
                <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
            </div>
        </div>
        <div class="col-md-3 col-xl-3">
            <div class="position-relative">
                <input type="text" class="form-control xphone-inputmask ps-5 mb-1 mt-1" id="input-search-Tel"
                    name="search_Tel" placeholder="ค้นหาเบอร์โทร">
                <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
            </div>
        </div>
        <div class="col-md-3 col-xl-3 text-end d-flex justify-content-md-start justify-content-center">
            <a href="javascript:void(0)" id="btn-search" class="btn btn-primary d-flex align-items-center mb-1 mt-1">
                <i class="ti ti-search text-white me-1 fs-5"></i>ค้นหา
            </a>
        </div>
    </div>
</div>
<ul class="nav nav-pills p-3 mb-3 rounded align-items-center card flex-row">
    <li class="nav-item">
        <a href="javascript:void(0)" class="
                      nav-link
                    gap-6
                      note-link
                      d-flex
                      align-items-center
                      justify-content-center
                      px-3 px-md-3
                      active
                    " value="">
            <i class="ti ti-list fill-white"></i>
            <span class="d-none d-md-block fw-medium">ทั้งหมด</span>
        </a>
    </li>
    @foreach ($StatusUser as $item)
        <li class="nav-item">
            <a href="javascript:void(0)" class="
                              nav-link
                             gap-6
                              note-link
                              d-flex
                              align-items-center
                              justify-content-center
                              px-3 px-md-3
                            " value="{{ $item->Status_Code }}">
                <i class="{{ $item->Icon }} fill-white"></i>
                <span class="d-none d-md-block fw-medium">{{ $item->Status_Name }}</span>
            </a>
        </li>
    @endforeach
    <li class="nav-item ms-auto">
        <a href="{{ route('user.create') }}" class="btn btn-primary d-flex align-items-center px-3 gap-6"
            id="add-notes">
            เพิ่ม User
        </a>
    </li>
</ul>
<div class="datatables">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="userTable" class="table table-striped table-bordered text-nowrap align-middle"
                    style="width: 100%">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>ชื่อ</th>
                            <th>นามสกุล</th>
                            <th>เบอร์โทร</th>
                            <th>Email</th>
                            <th>สิทธิการใช้งาน</th>
                            <th>แพ็คเกจ</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="detail-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="scroll-long-inner-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">
                    รายระเอียด
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="detailcontent">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-primary-subtle text-primary  waves-effect text-start">
                    อนุมัติ
                </button>
                <button type="button" class="btn bg-danger-subtle text-danger  waves-effect text-start">
                    ไม่อนุมัติ
                </button>
                <button type="button" class="btn bg-secondary-subtle text-secondary  waves-effect text-start"
                    data-bs-dismiss="modal">
                    ปิด
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            // Initialize DataTable
            const userTable = $('#userTable').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: "{{ route('user.data') }}",
                    data: function (d) {
                        d.status = $('.note-link.active').attr('value'); // ส่งสถานะปัจจุบัน
                        d.username = $('#input-search-Username').val(); // ค้นหาจาก Username
                        d.name = $('#input-search-Name').val(); // ค้นหาจาก ชื่อ-นามสกุล
                        d.tel = $('#input-search-Tel').val(); // ค้นหาจากเบอร์โทร
                    }
                },
                columns: [{
                    data: 'Username',
                    name: 'Username'
                },
                {
                    data: 'Firstname',
                    name: 'Firstname'
                },
                {
                    data: 'Lastname',
                    name: 'Lastname'
                },
                {
                    data: 'Tel',
                    name: 'Tel'
                },
                {
                    data: 'Email',
                    name: 'Email'
                },
                {
                    data: 'permission_name',
                    name: 'permission.Permission_Name'
                },
                {
                    data: 'package_name',
                    name: 'package.Package_Name',
                    orderable: false,
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
                ]
            });

            // Handle nav-link click
            $('.note-link').click(function () {
                $('.note-link').removeClass('active');
                $(this).addClass('active');

                // Reload DataTable
                userTable.ajax.reload();
            });

            // Handle search button click
            $('#btn-search').click(function () {
                // Reload DataTable with search filters
                userTable.ajax.reload();
            });
        });

        function detailuser(id) {
            $.ajax({
                url: "/user/detail/"+id, // ใช้ route เพื่อใส่ค่า id ใน URL
                type: "GET",
                success: function (response) {
                    $("#detailcontent").html(response);
                    $("#detail-modal").modal("show")
                },
                error: function (xhr, status, error) {
                    toastr.error("ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้", {
                        positionClass: "toastr toast-top-right",
                        containerId: "toast-top-right",
                    });
                }
            });
        }
    </script>
@endpush