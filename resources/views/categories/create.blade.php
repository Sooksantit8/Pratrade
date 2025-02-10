@extends('layouts.app') <!-- ชื่อ Layout -->

@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">เพิ่มหมวดหมู่สินค้า</h4>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="{{ asset('images/breadcrumb/ChatBc.png') }}" alt="modernize-img" class="img-fluid mb-n4" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
        $id = $categories->ID ?? '';
        $url = route('categories.insertCategory'); // กำหนด URL สำหรับ insert

        // ถ้ามี ID ก็จะเปลี่ยน URL เป็น URL สำหรับ update
        if ($id != '') {
            $url = route('categories.update', ['id' => $categories->ID]);
        }
    @endphp
    <form id="formaddcategory" action="{{ $url }}" enctype="multipart/form-data" novalidate>
        <div class="card">
            <div class="card-body">
                <div class="mb-7 form-group">
                    <label class="form-label">หมวดหมู่สินค้า <span class="text-danger">*</span>
                    </label>
                    <div class="controls">
                        <input type="text" class="form-control" required name="Category_name"
                            value="{{ $categories->Category_name ?? '' }}" aria-autocomplete="none" maxlength="45">
                    </div>
                </div>
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
        $("#savedata").click(function(event) {
            var Isvalid = $("#formaddcategory").valid()
            if (Isvalid) {
                var formData = $("#formaddcategory").serialize(); // ดึงข้อมูลฟอร์มทั้งหมด
                // ส่งข้อมูลผ่าน Ajax
                $.ajax({
                    url: "{{ $url }}",
                    method: "POST",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'สำเร็จ!',
                                text: response.message,
                                showConfirmButton: true
                            }).then(() => {
                                window.location.href = "{{ route('categories.index') }}";
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'ผิดพลาด!',
                                text: response.message,
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาด!',
                            text: xhr.responseJSON.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล',
                        });
                    }
                });
            }
        });
    </script>
@endpush
