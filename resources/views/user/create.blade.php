@extends('layouts.app') <!-- ชื่อ Layout -->

@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">เพิ่ม User</h4>
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
        $id = $user->ID ?? '';
        $url = route('user.insertUser'); // กำหนด URL สำหรับ insert

        // ถ้ามี ID ก็จะเปลี่ยน URL เป็น URL สำหรับ update
        if ($id != '') {
            $url = route('user.update', ['id' => $user->ID]);
        }
    @endphp
    <div class="card">
        <div class="card-body">
            <form id="formadduser" novalidate>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-4 form-group">
                            <label class="form-label">Username<span class="text-danger">*</span>
                            </label>
                            <div class="controls">
                                <input type="text" class="form-control" required name="Username" aria-autocomplete="none"
                                    id="Username" value="{{$user->Username ?? ''}}" maxlength="45">
                            </div>
                        </div>
                    </div>
                    @if ($id != "")
                        <div class="col-md-6">
                            <div class="mb-4 form-group">
                                <label class="form-label">Password
                                </label>
                                <div class="controls">
                                    <input type="password" class="form-control" name="Password"
                                        aria-autocomplete="none" id="Password" maxlength="45">
                                </div>
                            </div>
                        </div>          
                    @else
                        <div class="col-md-6">
                            <div class="mb-4 form-group">
                                <label class="form-label">Password<span class="text-danger">*</span>
                                </label>
                                <div class="controls">
                                    <input type="password" class="form-control" required name="Password"
                                        aria-autocomplete="none" id="Password" maxlength="45">
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-6">
                        <div class="mb-4 form-group">
                            <label class="form-label">ชื่อ<span class="text-danger">*</span>
                            </label>
                            <div class="controls">
                                <input type="text" class="form-control" required name="Firstname"
                                    aria-autocomplete="none" id="Firstname" value="{{$user->Firstname ?? ''}}" maxlength="45">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4 form-group">
                            <label class="form-label">นามสกุล<span class="text-danger">*</span>
                            </label>
                            <div class="controls">
                                <input type="text" class="form-control" required name="Lastname" aria-autocomplete="none"
                                    id="Lastname" value="{{$user->Lastname ?? ''}}" maxlength="45">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4 form-group">
                            <label class="form-label"> เบอร์โทร<small class="text-muted ms-2">0xxxxxxxxx</small><span
                                    class="text-danger">*</span>
                            </label>
                            <div class="controls">
                                <input type="text" class="form-control xphone-inputmask" required name="Tel"
                                    aria-autocomplete="none" value="{{$user->Tel ?? ''}}" id="Tel" maxlength="10">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4 form-group">
                            <label class="form-label">Email <small class="text-muted ms-2">xxx@xxx.xxx</small>
                            </label>
                            <div class="controls">
                                <input type="text" class="form-control email-inputmask" name="Email"
                                    aria-autocomplete="none" id="Email" value="{{$user->Email ?? ''}}" maxlength="45">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-7">
                    <label class="form-label">สิทธิการใช้งาน</label><span class="text-danger">*</span>
                    <nav>
                        <div class="nav nav-tabs justify-content-between align-items-center gap-9" id="nav-tab"
                            role="tablist">
                            @foreach ($Permissions as $permission)
                                <label for="{{ $permission->Permission_Code }}"
                                    class="form-check-label form-check p-3  border gap-2 rounded-2 d-flex flex-fill justify-content-center cursor-pointer"
                                    id="customControlValidation2" id="nav-tab-{{ $permission->Permission_Code }}"
                                    data-bs-toggle="tab" data-bs-target="#nav-{{ $permission->Permission_Code }}"
                                    aria-controls="nav-{{ $permission->Permission_Code }}">
                                    <input type="radio" class="form-check-input" name="Permission_Code"
                                        id="{{ $permission->Permission_Code }}" value="{{ $permission->Permission_Code }}"
                                        @if ($permission->Permission_Code == ($user->Permission_Code ?? 'P01')) checked @endif
                                        onclick = "enable_disable_required(this,'{{ $permission->Required_Package }}')">
                                    <span class="fs-4 text-dark">{{ $permission->Permission_Name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        @foreach ($Permissions->Where('Required_Package', true) as $permission)
                            <div class="tab-pane fade mt-7" id="nav-{{ $permission->Permission_Code }}" role="tabpanel"
                                aria-labelledby="nav-{{ $permission->Permission_Code }}" tabindex="0">
                                <div class="mb-7 form-group">
                                    <label class="form-label">แพ็คเก็จ<span class="text-danger">*</span>
                                    </label>
                                    <div class="controls">
                                        <select class="form-select mr-sm-2  mb-2" id="Package" name="Package">
                                            <option value="">--เลือกข้อมูล--</option>
                                            @foreach ($Packages as $item)
                                                <option value="{{ $item->ID }}"
                                                    {{ $item->ID == ($user->Package ?? '') ? 'selected' : '' }}>
                                                    {{ $item->Package_Name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="action-btn layout-top-spacing mb-7 d-flex align-items-center justify-content-end flex-wrap gap-6">
        <button id="savedata" class="btn waves-effect waves-light btn-primary mb-2">
            บันทึกข้อมูล
        </button>
    </div>
@endsection

@push('scripts')
    <script>
        function enable_disable_required(el, Required_Package) {
            if (Required_Package == "1") {
                $("#Package").attr('required', 'required');
            } else {
                $("#Package").removeAttr('required');
                $("#Package").val("");
            }
        }
        $("#savedata").click(function(event) {
            var Isvalid = $("#formadduser").valid()
            if (Isvalid) {
                // รวบรวมข้อมูลฟอร์ม
                var formData = $("#formadduser").serialize(); // ดึงข้อมูลฟอร์มทั้งหมด
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
                                window.location.href = "{{ route('user.index') }}";
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
