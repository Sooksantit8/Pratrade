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
                        <div class="row">
                            <div class="mb-3 form-group">
                                <label class="form-label">ชื่อสินค้า<span class="text-danger">*</span>
                                </label>
                                <div class="controls">
                                    <input type="text" class="form-control" required name="Product_name"
                                        aria-autocomplete="none" id="Product_name" maxlength="100" value="{{$product->Product_Name ?? ""}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 form-group">
                                    <label class="form-label">รุ่นสินค้า
                                    </label>
                                    <div class="controls">
                                        <input type="text" class="form-control" name="Product_model"
                                            aria-autocomplete="none" id="Product_model" maxlength="45" value="{{$product->Product_model ?? ""}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 form-group">
                                    <label class="form-label">เนื้อ
                                    </label>
                                    <div class="controls">
                                        <input type="text" class="form-control" name="Product_materials"
                                            aria-autocomplete="none" id="Product_materials" maxlength="45" value="{{$product->Product_model ?? ""}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 form-group">
                                    <label class="form-label">ผู้สร้าง
                                    </label>
                                    <div class="controls">
                                        <input type="text" class="form-control" name="Manufacturer"
                                            aria-autocomplete="none" id="Manufacturer" maxlength="100" value="{{$product->Manufacturer ?? ""}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 form-group">
                                    <label class="form-label">ปีที่สร้าง
                                    </label>
                                    <div class="controls">
                                        <input type="number" class="form-control" name="Year_manufacture"
                                            aria-autocomplete="none" id="Year_manufacture" maxlength="4" value="{{$product->Year_manufacture ?? ""}}">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <label class="form-label">หมวดหมู่สินค้า</label><span class="text-danger">*</span>
                        <div class="mb-3 Category">

                            <select class="select2 form-control" multiple="multiple" id="Category" name="Category"
                                required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->ID }}">{{ $category->Category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-7 form-group">
                            <label class="form-label">ราคาสินค้า <span class="text-danger">*</span>
                            </label>
                            <div class="controls">
                                <input type="number" value="{{$product->Price ?? ""}}" class="form-control" required name="Price" aria-autocomplete="none">
                            </div>
                        </div>
                        <div class="mb-7 form-group">
                            <label class="form-label">จำนวนสินค้า <span class="text-danger">*</span>
                            </label>
                            <div class="controls">
                                <input type="number" class="form-control" required name="Stock_qty"
                                    aria-autocomplete="none" value="{{$product->Stock_qty ?? ""}}">
                            </div>
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
                                            <input type="radio" class="form-check-input preoderstatus" name="Preorder"
                                                id="{{ $preorder->Lookup_code }}" value="{{ $preorder->Lookup_code }}"
                                                @if ($preorder->Lookup_code == ($product->Preorder ?? "PRE1")) checked @endif
                                                onclick = "enable_disable_required(this)">
                                            <span class="fs-4 text-dark">{{ $preorder->Lookup_name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade mt-7" id="nav-PRE2" role="tabpanel"
                                    aria-labelledby="nav-PRE2" tabindex="0">
                                    <div class="mb-7 form-group">
                                        <label class="form-label">วันที่พร้อมจำหน่าย <span class="text-danger">*</span>
                                        </label>
                                        <div class="controls">
                                            <input type="date" class="form-control" name="Preorder_date"
                                            id="Preorder_date"
                                            value="{{ ($product->Preorder_date ?? "") ? \Carbon\Carbon::parse($product->Preorder_date)->format('Y-m-d') : '' }}"
                                            required aria-autocomplete="none">
                                        </div>
                                    </div>
                                    <div class="mb-7 form-group">
                                        <label class="form-label">ราคาสั่งจอง <span class="text-danger">*</span>
                                        </label>
                                        <div class="controls">
                                            <input type="number" class="form-control" id="Price_Preorder"
                                                name="Price_Preorder" value="{{$product->Price_Preorder ?? ""}}" aria-autocomplete="none">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-7">
                            <label class="form-label">การชำระเงิน</label><span class="text-danger">*</span>
                            <nav>
                                <div class="nav nav-tabs justify-content-between align-items-center gap-9" id="nav-tab"
                                    role="tablist">
                                    @if ($mypackage->Central_Function ?? 1 == 1)
                                        <label for="use"
                                            class="form-check-label form-check p-3  border gap-2 rounded-2 d-flex flex-fill justify-content-center cursor-pointer"
                                            data-bs-toggle="tab" data-bs-target="#nav-use" aria-controls="nav-use">
                                            <input type="radio" class="form-check-input" name="UseCentralfunction" onclick="checkbookbank(this)"
                                                id="use" value="use" @if (isset($product->Use_Central_function) && $product->Use_Central_function == 1) checked @endif>
                                            <span class="fs-4 text-dark">ชำระเงินผ่านบัญชีกลาง</span>
                                        </label>
                                    @endif
                                    <label for="notuse"
                                        class="form-check-label form-check p-3  border gap-2 rounded-2 d-flex flex-fill justify-content-center cursor-pointer"
                                        data-bs-toggle="tab" data-bs-target="#nav-notuse" aria-controls="nav-notuse">
                                        <input type="radio" class="form-check-input" name="UseCentralfunction" @if (isset($product->Use_Central_function) && $product->Use_Central_function == 0) checked @endif onclick="checkbookbank(this)"
                                            id="notuse" value="notuse">
                                        <span class="fs-4 text-dark">ชำระผ่านบัญชีตนเอง</span>
                                    </label>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade mt-7" id="nav-notuse" role="tabpanel"
                                    aria-labelledby="nav-notuse" tabindex="0">
                                    @if ($bookbank->count() > 1)
                                        <div class="mb-7 form-group">
                                            <label class="form-label">หมายเลขบัญชี
                                            </label>
                                            <div class="controls">
                                                <div id="bookbankcontent">
                                                    <select class="form-select mr-sm-2  mb-2" id="bookbank"
                                                        name="bookbank" required>
                                                        <option value="">--เลือกข้อมูล--</option>
                                                        @foreach ($bookbank as $item)
                                                            <option value="{{ $item->ID }}">
                                                                {{ $item->Bookbanknumber }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="mb-7 form-group">
                                            <label class="form-label">หมายเลขบัญชี <span class="text-danger">*</span>
                                            </label>
                                            <div class="controls">
                                                <input type="text" class="form-control bank-inputmask"
                                                    aria-autocomplete="none" required name="Bookbanknumber"
                                                    aria-autocomplete="none">
                                            </div>
                                        </div>
                                        <div class="mb-7 form-group">
                                            <label class="form-label">ชื่อบัญชี <span class="text-danger">*</span>
                                            </label>
                                            <div class="controls">
                                                <input type="text" class="form-control" required name="Bookbankname"
                                                    aria-autocomplete="none" maxlength="45">
                                            </div>
                                        </div>
                                        <div class="mb-7 form-group">
                                            <label class="form-label">ธนาคาร <span class="text-danger">*</span>
                                            </label>
                                            <div class="controls">
                                                <input type="text" class="form-control" required name="Bankname"
                                                    aria-autocomplete="none" maxlength="45">
                                            </div>
                                        </div>
                                        <input type="hidden" class="form-control" required name="From"
                                            id="From" aria-autocomplete="none" readonly maxlength="45">
                                        <div class="mb-7 form-group">
                                            <label class="form-label">QR CODE <span class="text-danger">*</span>
                                            </label>
                                            <div class="controls">
                                                <input class="form-control" type="file" name="Path_Image" required>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3 form-group">
                            <label class="form-label">ซื้อมาจาก
                            </label>
                            <div class="controls">
                                <input type="text" class="form-control" name="Bought_from" aria-autocomplete="none"
                                    id="Bought_from" maxlength="100" value="{{$product->Bought_from ?? ""}}">
                            </div>
                        </div>
                        <div class="mb-7 form-group">
                            <label class="form-label">ราคาที่ซื้อมา
                            </label>
                            <div class="controls">
                                <input type="number" class="form-control" value="{{$product->Purchase_price ?? ""}}" name="Purchase_price" id="Purchase_price"
                                    aria-autocomplete="none">
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

        let existingContent = @json(($product->Description ?? "")); // โหลดเนื้อหาจากฐานข้อมูล
        quill.root.innerHTML = existingContent; // ใส่ค่าใน Editor

        // ปิดการ auto-discover ของ Dropzone
        Dropzone.autoDiscover = false;

        // กำหนด Dropzone
        Dropzone.autoDiscover = false;

        var deletedFiles = []; // เก็บรายการไฟล์ที่ถูกลบ (แต่ยังไม่ส่งไปลบจริง)

        var myDropzone = new Dropzone("#my-dropzone", {
            url: "/upload", // เปลี่ยนเป็น URL ที่ใช้งานจริง
            autoProcessQueue: false, // อัปโหลดเมื่อกด submit เท่านั้น
            maxFiles: 5,
            maxFilesize: 10, // MB
            acceptedFiles: ".jpg,.png,.jpeg",
            addRemoveLinks: true,
            dictDefaultMessage: "ลากและวางไฟล์ที่นี่ หรือคลิกเพื่อเลือกไฟล์",
            init: function () {
                let dropzoneInstance = this;
                let existingFiles = @json($images ?? []);

                if (existingFiles.length > 0) {
                    existingFiles.forEach(function (file) {
                        let mockFile = { id: file.id,name: file.name, size: file.size, url: file.url };

                        dropzoneInstance.emit("addedfile", mockFile);
                        dropzoneInstance.emit("thumbnail", mockFile, file.url);
                        dropzoneInstance.emit("complete", mockFile);

                        // 🛠 ป้องกันไม่ให้ Dropzone ลบไฟล์เก่าอัตโนมัติ
                        mockFile.accepted = true;
                        dropzoneInstance.files.push(mockFile);
                    });
                }

                this.on("removedfile", function (file) {
                    if (file.id) { // ถ้ามี id
                        deletedFiles.push(file.id); // เพิ่ม id ของไฟล์ที่ถูกลบลงใน deletedFiles
                    }
                });
            }
        });


        $(document).ready(function() {
            $(".preoderstatus:checked").click()
            let selectedCategories = @json($product_category ?? []);
            
            $(".select2").select2();

            if(selectedCategories.length > 0){
                $("#Category").val(selectedCategories).trigger("change");
            }
            
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
                $("#Price_Preorder").attr('required', 'required');
            } else {
                $("#Preorder_date").removeAttr('required');
                $("#Preorder_date").val("");

                $("#Price_Preorder").removeAttr('required');
                $("#Price_Preorder").val("");
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
                    var UseCentralfunction = $("input[name='UseCentralfunction']:checked").val() ?? "";

                    if(UseCentralfunction == ""){
                        toastr.info(
                        "กรุณาเลือกวิธีชำระเงิน", {
                            positionClass: "toastr toast-top-right",
                            containerId: "toast-top-right",
                        }
                    );
                    }
                    // ดึง CSRF token จาก meta tag
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                    // ดึงข้อมูลที่กรอกในฟอร์ม
                    var formData = new FormData();
                    formData.append("_token", csrfToken); // เพิ่ม CSRF token
                    formData.append("ID", '{{$product->ID ?? ""}}');
                    formData.append("Product_name", $("#Product_name").val());
                    formData.append("Category", $("#Category").val());
                    formData.append("Price", $("input[name='Price']").val());
                    formData.append("Stock_qty", $("input[name='Stock_qty']").val());
                    formData.append("Preorder", $("input[name='Preorder']:checked").val());
                    formData.append("Preorder_date", $("#Preorder_date").val());
                    formData.append("Price_Preorder", $("#Price_Preorder").val());
                    formData.append("Product_model", $("#Product_model").val());
                    formData.append("Product_materials", $("#Product_materials").val());
                    formData.append("Manufacturer", $("#Manufacturer").val());
                    formData.append("Year_manufacture", $("#Year_manufacture").val());
                    formData.append("Bought_from", $("#Bought_from").val());
                    formData.append("Purchase_price", $("#Purchase_price").val());
                    formData.append("UseCentralfunction", $("input[name='UseCentralfunction']:checked").val());
                    formData.append("bookbank", $("#bookbank").val() ?? "");
                    formData.append("Bookbanknumber", $("input[name='Bookbanknumber']").val());
                    formData.append("Bookbankname", $("input[name='Bookbankname']").val());
                    formData.append("Bankname", $("input[name='Bankname']").val());
                    formData.append("Path_Image", $("#formaddbookbank")[0]);
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

        function checkbookbank(el){
            if ($(el).val() == "notuse") {
                $("input[name='Bookbanknumber']").attr('required', 'required');
                $("input[name='Bookbankname']").attr('required', 'required');
                $("input[name='Bankname']").attr('required', 'required');
                $("input[name='Path_Image']").attr('required', 'required');
                $("#bookbank").attr('required', 'required');
            } else {
                $("input[name='Bookbanknumber']").removeAttr('required');
                $("input[name='Bookbankname']").removeAttr('required');
                $("input[name='Bankname']").removeAttr('required');
                $("input[name='Path_Image']").removeAttr('required');

                $("input[name='Bookbanknumber']").val('');
                $("input[name='Bookbankname']").val('');
                $("input[name='Bankname']").val('');
                $("input[name='Path_Image']").val('');
                $("#bookbank").val('');
            }
        }
    </script>
@endpush
