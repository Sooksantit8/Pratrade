<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">ชำระเงิน</h4>
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
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="form-label text-end col-md-6">แพ็คเกจ:</label>
                    <div class="col-md-6">
                        <p>{{$package->Package_Name}}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="form-label text-end col-md-6">ราคา:</label>
                    <div class="col-md-6">
                        <p>{{number_format($package->Price)}} บาท</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="form-label text-end col-md-6">หมายเลขบัญชี:</label>
                    <div class="col-md-6">
                        <p>{{$bookbank->Bookbanknumber}}</p>
                    </div>
                </div>
            </div>
            <!--/span-->
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="form-label text-end  col-md-6">ชื่อบัญชี:</label>
                    <div class="col-md-6">
                        <p>{{$bookbank->Bookbankname}}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="form-label text-end col-md-6">ธนาคาร:</label>
                    <div class="col-md-6">
                        <p>{{$bookbank->Bankname}}</p>
                    </div>
                </div>
            </div>
            <!--/span-->
        </div>
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
        <form id="formpurpayment" action="{{ route('user.Insertpurpayment', ['id' => $package->ID]) }}"
            enctype="multipart/form-data" novalidate>
            <div class="mb-7 form-group">
                <label class="form-label">แนบสลิป <span class="text-danger">*</span>
                </label>
                <div class="controls">
                    <input class="form-control" type="file" name="Path_Image" required>
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

<script>
    $("#savedata").click(function (event) {
        var Isvalid = $("#formpurpayment").valid()
        if (Isvalid) {
            var form = $("#formpurpayment")[0]; // ดึงฟอร์มจาก DOM
            var formData = new FormData(form); // สร้าง FormData สำหรับส่งไฟล์
            // ส่งข้อมูลผ่าน Ajax
            $.ajax({
                url: $("#formpurpayment").attr("action"),
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'สำเร็จ!',
                            text: response.message,
                            showConfirmButton: true
                        }).then(() => {
                            window.location.href = "{{ route('product.pricing') }}";
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'ผิดพลาด!',
                            text: response.message,
                        });
                    }
                },
                error: function (xhr) {
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