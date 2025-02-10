@extends('layouts.app') <!-- ชื่อ Layout -->

@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">เพิ่มแพ็คเกจ</h4>
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
        $id = $package->ID ?? '';
        $url = route('package.insertPackage'); // กำหนด URL สำหรับ insert

        // ถ้ามี ID ก็จะเปลี่ยน URL เป็น URL สำหรับ update
        if ($id != '') {
            $url = route('package.update', ['id' => $package->ID]);
        }
    @endphp
    <form id="formaddpackage" action="{{ $url }}" novalidate>
        <div class="card">
            <div class="card-body">
                <div class="mb-7 form-group">
                    <label class="form-label">ชื่อแพ็คเกจ <span class="text-danger">*</span>
                    </label>
                    <div class="controls">
                        <input type="text" class="form-control" required name="Package_Name"
                            value="{{ $package->Package_Name ?? '' }}" aria-autocomplete="none">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-7 form-group">
                                <label class="form-label">ราคา <span class="text-danger">*</span>
                                </label>
                                <div class="controls">
                                    <input type="number" class="form-control" required name="Price"
                                        value="{{ $package->Price ?? '' }}" aria-autocomplete="none">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-7 form-group">
                                <label class="form-label">จำนวนโพส
                                </label>
                                <div class="controls">
                                    <input type="number" class="form-control" name="Qty_Post"
                                        value="{{ $package->Qty_Post ?? '' }}" aria-autocomplete="none">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-7 form-group">
                                <label class="form-label">ต่อ วัน/เดือน/ปี
                                </label>
                                <div class="controls">
                                    <select class="form-select mr-sm-2  mb-2" id="Type_Post" name="Type_Post">
                                        <option value="">--เลือกข้อมูล--</option>
                                        @foreach ($Type_Post as $item)
                                            <option value="{{ $item->Lookup_code }}"
                                                {{ $item->Lookup_code == ($package->Type_Post ?? '') ? 'selected' : '' }}>
                                                {{ $item->Lookup_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <label class="form-label">ฟังก์ชันชำระเงินผ่านตัวกลาง</label><span class="text-danger">*</span>
                <nav>
                    <div class="nav nav-tabs justify-content-between align-items-center gap-9" id="nav-tab"
                        role="tablist">
                        <label for="No"
                            class="form-check-label form-check p-3  border gap-2 rounded-2 d-flex flex-fill justify-content-center cursor-pointer"
                            id="customControlValidation2" id="nav-tab-No" data-bs-toggle="tab" data-bs-target="#nav-No"
                            aria-controls="nav-No">
                            <input type="radio" class="form-check-input" id="No" value="0"  @if (($package->Central_Function ?? '') == false || ($package->Central_Function ?? '') == '') checked @endif
                                name="Central_Function">
                            <span class="fs-4 text-dark">ไม่สามารถใช้งานได้</span>
                        </label>
                        <label for="Yes"
                            class="form-check-label form-check p-3  border gap-2 rounded-2 d-flex flex-fill justify-content-center cursor-pointer"
                            id="customControlValidation2" id="nav-tab-Yes" data-bs-toggle="tab" data-bs-target="#nav-Yes"
                            aria-controls="nav-Yes">
                            <input type="radio" class="form-check-input" id="Yes" value="1" @if (($package->Central_Function ?? '') == true) checked @endif
                                name="Central_Function">
                            <span class="fs-4 text-dark">สามารถใช้งานได้</span>
                        </label>
                    </div>
                </nav>
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
            var Isvalid = $("#formaddpackage").valid()
            if (Isvalid) {
                // รวบรวมข้อมูลฟอร์ม
                var formData = $("#formaddpackage").serialize(); // ดึงข้อมูลฟอร์มทั้งหมด
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
                                window.location.href = "{{ route('package.index') }}";
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
