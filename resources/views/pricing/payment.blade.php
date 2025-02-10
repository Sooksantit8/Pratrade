<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">ชำระเงิน</h4>
            </div>
            <div class="col-3">
                <div class="text-center mb-n5">
                    <img src="{{ asset('images/breadcrumb/ChatBc.png') }}" alt="modernize-img" class="img-fluid mb-n4" />
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
        <div class="mb-7 form-group">
            <label class="form-label">แนบสลิป <span class="text-danger">*</span>
            </label>
            <div class="controls">
                <input class="form-control" type="file" name="Path_Image" required>
            </div>
        </div>
    </div>
</div>
<div class="action-btn layout-top-spacing mb-7 d-flex align-items-center justify-content-end flex-wrap gap-6">
    <button id="savedata" class="btn waves-effect waves-light btn-primary mb-2">
        บันทึกข้อมูล
    </button>
</div>