<div class="row">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group row">
                <label class="form-label text-end col-md-6">Name:</label>
                <div class="col-md-6">
                    <p>{{$user->Firstname}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group row">
                <label class="form-label text-end col-md-6">Lastname:</label>
                <div class="col-md-6">
                    <p>{{$user->Lastname}}</p>
                </div>
            </div>
        </div>
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
    </div>
    @if (($packagehis->Payslip ?? '') != '')
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-3">
                    <div class="card-body border-bottom">
                        <img src="{{ asset('storage/' . $packagehis->Payslip)}}" alt="modernize-img"
                            class="rounded-4 img-fluid mb-4">
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>