@extends('layouts.app') <!-- ชื่อ Layout -->

@section('content')
<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">เพิ่มหมายเลขบัญชีกลาง</h4>
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
@php
    $id = $bookbank->ID ?? '';
    $url = route('bookbank.insertBookbank'); // กำหนด URL สำหรับ insert

    // ถ้ามี ID ก็จะเปลี่ยน URL เป็น URL สำหรับ update
    if ($id != '') {
        $url = route('bookbank.update', ['id' => $bookbank->ID]);
    }
@endphp
<form id="formaddbookbank" action="{{ $url }}" enctype="multipart/form-data" novalidate>
    <div class="card">
        <div class="card-body">
            <div class="mb-7 form-group">
                <label class="form-label">หมายเลขบัญชี <span class="text-danger">*</span>
                </label>
                <div class="controls">
                    <input type="text" class="form-control bank-inputmask" aria-autocomplete="none" required
                        name="Bookbanknumber" value="{{ $bookbank->Bookbanknumber ?? '' }}" aria-autocomplete="none">
                </div>
            </div>
            <div class="mb-7 form-group">
                <label class="form-label">ชื่อบัญชี <span class="text-danger">*</span>
                </label>
                <div class="controls">
                    <input type="text" class="form-control" required name="Bookbankname"
                        value="{{ $bookbank->Bookbankname ?? '' }}" aria-autocomplete="none" maxlength="45">
                </div>
            </div>
            <div class="mb-7 form-group">
                <label class="form-label">ธนาคาร <span class="text-danger">*</span>
                </label>
                <div class="controls">
                    <input type="text" class="form-control" required name="Bankname"
                        value="{{ $bookbank->Bankname ?? '' }}" aria-autocomplete="none" maxlength="45">
                </div>
            </div>
            <input type="hidden" class="form-control" required name="From" id="From"
                value="{{ $bookbank->From ?? $From }}" aria-autocomplete="none" readonly maxlength="45">
            <div class="mb-7 form-group">
                <label class="form-label">QR CODE <span class="text-danger">*</span>
                </label>
                <div class="controls">
                    <input class="form-control" type="file" name="Path_Image" required>
                </div>
            </div>
            @if (($bookbank->Path_Image ?? '') != '')
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <div class="card mt-3">
                            <div class="card-body border-bottom">
                                <img src="{{ asset('storage/' . $bookbank->Path_Image)}}" alt="modernize-img" height="360"
                                    class="rounded-4 img-fluid mb-4">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4"></div>
                </div>
            @endif
        </div>
    </div>
</form>

<div class="action-btn layout-top-spacing mb-7 d-flex align-items-center justify-content-end flex-wrap gap-6">
    <button id="savedata" class="btn waves-effect waves-light btn-primary mb-2">
        บันทึกข้อมูล
    </button>
</div>
@endsection

@push('scripts')
    <script>
        $("#savedata").click(function (event) {
            var Isvalid = $("#formaddbookbank").valid()
            var form = $("#formaddbookbank")[0]; // ดึงฟอร์มจาก DOM
            var formData = new FormData(form); // สร้าง FormData สำหรับส่งไฟล์
            if (Isvalid) {
                // ส่งข้อมูลไปยัง Backend
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: $("#formaddbookbank").attr("action"), // URL สำหรับการบันทึกข้อมูล
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'สำเร็จ!',
                                text: response.message,
                                showConfirmButton: false
                            }).then(() => {
                                if($("#From").val() == 'admin'){
                                    window.location.href = "{{ route('bookbank.index') }}";
                                }else{
                                    window.location.href = "{{ route('bookbank.bookbanuser') }}";
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'ผิดพลาด!',
                                text: response.message,
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        toastr.error("ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้", {
                            positionClass: "toastr toast-top-right",
                            containerId: "toast-top-right",
                        });
                    }
                });
            }
        });
    </script>
@endpush