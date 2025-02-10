@extends('layouts.app') <!-- ชื่อ Layout -->

@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">ลงประกาศ</h4>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="{{ asset('images/breadcrumb/ChatBc.png') }}" alt="modernize-img" class="img-fluid mb-n4" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <form id="formaddproduct" novalidate>
            <div class="col-lg-12 ">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-4 form-group">
                            <label class="form-label">ชื่อสินค้า<span class="text-danger">*</span>
                            </label>
                            <div class="controls">
                                <input type="text" name="text" class="form-control" required name="Product_name"
                                    aria-autocomplete="none" id="Product_name" maxlength="100">
                            </div>
                            <p class="fs-2">ต้องระบุชื่อผลิตภัณฑ์และแนะนำให้ไม่ซ้ำกัน</p>
                        </div>
                        <div class="mb-4 form-group Category">
                            <label class="form-label">หมวดหมู่สินค้า</label><span class="text-danger">*</span>
                            <select class="select2 form-control" multiple="multiple" id="Category" name="Category"
                                required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->ID }}">{{ $category->Category_name }}</option>
                                @endforeach
                            </select>
                            <p class="fs-2 mb-0">
                                เพิ่มหมวดหมู่สินค้า
                            </p>
                        </div>
                        <div class="mb-7 form-group">
                            <label class="form-label">ราคาสินค้า <span class="text-danger">*</span>
                            </label>
                            <div class="controls">
                                <input type="number" class="form-control" required name="Price" aria-autocomplete="none">
                            </div>
                            <p class="fs-2">กำหนดราคาสินค้า</p>
                        </div>
                        <div class="mb-7 form-group">
                            <label class="form-label">จำนวนสินค้า <span class="text-danger">*</span>
                            </label>
                            <div class="controls">
                                <input type="number" class="form-control" required name="Stock_qty"
                                    aria-autocomplete="none">
                            </div>
                            <p class="fs-2">กำหนดจำนวนสินค้า</p>
                        </div>
                        <div class="mb-7">
                            <label class="form-label">สถานะสินค้า</label><span class="text-danger">*</span>
                            <nav>
                                <div class="nav nav-tabs justify-content-between align-items-center gap-9" id="nav-tab"
                                    role="tablist">
                                    @foreach ($preorders as $preorder)
                                        <label for="{{ $preorder->Lookup_code }}"
                                            class="form-check-label form-check p-3  border gap-2 rounded-2 d-flex flex-fill justify-content-center cursor-pointer"
                                            id="customControlValidation2" id="nav-tab-{{ $preorder->Lookup_code }}"
                                            data-bs-toggle="tab" data-bs-target="#nav-{{ $preorder->Lookup_code }}"
                                            aria-controls="nav-{{ $preorder->Lookup_code }}">
                                            <input type="radio" class="form-check-input" name="Preorder"
                                                id="{{ $preorder->Lookup_code }}" value="{{ $preorder->Lookup_code }}"
                                                @if ($preorder->Lookup_code == 'PRE1') checked @endif
                                                onclick = "enable_disable_required(this)">
                                            <span class="fs-4 text-dark">{{ $preorder->Lookup_name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade mt-7" id="nav-PRE2" role="tabpanel" aria-labelledby="nav-PRE2"
                                    tabindex="0">
                                    <div class="mb-7 form-group">
                                        <label class="form-label">วันที่พร้อมจำหน่าย <span class="text-danger">*</span>
                                        </label>
                                        <div class="controls">
                                            <input type="date" class="form-control" name="Preorder_date"
                                                id="Preorder_date" required aria-autocomplete="none">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="Description">
                            <label class="form-label">รายละเอียดสินค้า</label><span class="text-danger">*</span>
                            <div id="editor">
                            </div>
                            <p class="fs-2 mb-0">กำหนดคำอธิบายให้กับผลิตภัณฑ์เพื่อให้มองเห็นได้ดีขึ้น</p>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <label class="form-label">รูปสินค้า <span class="text-danger">*</span>
                        </label>

                        <div class="dropzone dz-clickable mb-2" id="my-dropzone">
                            <div class="dz-default dz-message">
                                <button class="dz-button" type="button">วางไฟล์ที่นี่
                                    เพื่ออัปโหลด</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="action-btn layout-top-spacing mb-7 d-flex align-items-center justify-content-end flex-wrap gap-6">
                    <button id="savedata" type="button"
                        class="btn rounded-pill waves-effect waves-light btn-primary mb-2">
                        บันทึกข้อมูล
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('libs/quill/dist/quill.min.js') }}"></script>
    <script>
        var quill = new Quill("#editor", {
            theme: "snow",
        });

        // ปิดการ auto-discover ของ Dropzone
        Dropzone.autoDiscover = false;

        // กำหนด Dropzone
        var myDropzone = new Dropzone("#my-dropzone", {
            url: "/upload", // URL สำหรับอัปโหลดไฟล์ (ต้องเปลี่ยนตาม Backend)
            autoProcessQueue: false, // อัปโหลดเมื่อกด submit เท่านั้น
            maxFiles: 5,
            maxFilesize: 10, // ขนาดไฟล์สูงสุด (MB)
            acceptedFiles: ".jpg,.png,.jpeg", // ประเภทไฟล์
            addRemoveLinks: true,
            dictDefaultMessage: "ลากและวางไฟล์ที่นี่ หรือคลิกเพื่อเลือกไฟล์",
        });


        $(document).ready(function() {
            $(".select2").select2();
            $("#formaddproduct").validate({
                errorPlacement: function(error, element) {
                    if (element.hasClass("select2-hidden-accessible")) {
                        element.next(".select2-container").addClass("is-invalid");
                        error.insertAfter(element.next(".select2-container"));
                    } else {
                        element.addClass("is-invalid");
                        error.insertAfter(element);
                    }
                },
                success: function(label, element) {
                    if ($(element).hasClass("select2-hidden-accessible")) {
                        $(element).next(".select2-container").removeClass("is-invalid");
                    } else {
                        $(element).removeClass("is-invalid");
                    }
                },
            });
        });


        // รีเซ็ตกรอบสีแดงเมื่อผู้ใช้เลือกค่าใน Select2
        $(".select2").on("change", function() {
            // ตรวจสอบว่า Select2 ที่ถูกเลือกแล้ว
            if ($(this).valid()) {
                $(this).next(".select2-container").removeClass("is-invalid"); // ลบกรอบสีแดง
                $(this).next(".select2-container").find(".error").remove(); // ลบข้อความ error
            } else {
                $(this).next(".select2-container").addClass("is-invalid");
            }
        });

        function enable_disable_required(el) {
            if ($(el).val() == "PRE2") {
                $("#Preorder_date").attr('required', 'required');
            } else {
                $("#Preorder_date").removeAttr('required');
                $("#Preorder_date").val("");
            }
        }


        $("#savedata").click(function() {
            var Isvalid = $("#formaddproduct").valid()
            if (Isvalid) {
                var editorContent = quill.getText().trim(); // หรือใช้ quill.root.innerHTML

                if (editorContent === "") {
                    toastr.info(
                        "กรุณากรอกรายละเอียดสินค้า", {
                            positionClass: "toastr toast-top-right",
                            containerId: "toast-top-right",
                        }
                    );
                } else if (myDropzone.files.length === 0) {
                    toastr.info(
                        "กรุณาแนบรูปภาพสินค้า", {
                            positionClass: "toastr toast-top-right",
                            containerId: "toast-top-right",
                        }
                    );
                } else {
                    // ดึง CSRF token จาก meta tag
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                    // ดึงข้อมูลที่กรอกในฟอร์ม
                    var formData = new FormData();
                    formData.append("_token", csrfToken); // เพิ่ม CSRF token
                    formData.append("Product_name", $("#Product_name").val());
                    formData.append("Category", $("#Category").val());
                    formData.append("Price", $("input[name='Price']").val());
                    formData.append("Stock_qty", $("input[name='Stock_qty']").val());
                    formData.append("Preorder", $("input[name='Preorder']:checked").val());
                    formData.append("Preorder_date", $("#Preorder_date").val());
                    formData.append("Description", quill.root.innerHTML); // ข้อมูลจาก Quill Editor

                    // ส่งข้อมูลไฟล์ที่อัปโหลดจาก Dropzone
                    myDropzone.files.forEach(function(file) {
                        formData.append("images[]", file);
                    });

                    // ส่งข้อมูลไปยัง Backend
                    $.ajax({
                        url: "/product/insertProduct", // URL สำหรับการบันทึกข้อมูล
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'สำเร็จ!',
                                    text: response.message,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.href = "{{ route('product.create') }}";
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'ผิดพลาด!',
                                    text: response.message,
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            toastr.error("ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้", {
                                positionClass: "toastr toast-top-right",
                                containerId: "toast-top-right",
                            });
                        }
                    });
                }
            }
        })
    </script>
@endpush
