@extends('layouts.app') <!-- ชื่อ Layout -->

@section('content')
<div class="">
    <div class="row my-sm-5 my-4">
        @foreach ($package as $item)
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card p-7 mb-0 rounded-3 border">
                    <h3 class="fs-6 fw-bolder mb-0">{{$item->Package_Name}}</h3>
                    <h3 class="fs-3 fw-normal mt-sm-7 mt-3 text-muted">
                        @if ($item->Price == 0)
                            <span class="fs-10 fw-bolder text-dark">Free</span>
                        @else
                            <span class="fs-10 fw-bolder text-dark">฿{{ number_format($item->Price)}}</span>/
                            {{$item->lookupTypePost->Lookup_name}}
                        @endif

                    </h3>
                    <div class="my-sm-7 my-3 d-flex flex-column gap-3">
                        <div class="d-flex gap-2">
                            @if ($item->Qty_Post == 0)
                                <img src="{{asset('images/frontend-pages/icon-circle-x.svg') }}" alt="">
                                <p class="fs-3 fw-bold mb-0 text-muted">ไม่สามารถเพิ่มรายการสินค้าได้</p>
                            @else
                                <img src="{{asset('images/frontend-pages/icon-circle-check.svg') }}" alt="">
                                <p class="fs-3 fw-bold text-dark mb-0">เพิ่มสินค้าได้ {{number_format($item->Qty_Post)}}
                                    รายการ/{{$item->lookupTypePost->Lookup_name}}</p>
                            @endif
                        </div>
                        <div class="d-flex gap-2">
                            @if ($item->Central_Function == false)
                                <img src="{{asset('images/frontend-pages/icon-circle-x.svg') }}" alt="">
                                <p class="fs-3 fw-bold mb-0 text-muted">ไม่สามารถชำระเงินผ่านตัวกลาง</p>
                            @else
                                <img src="{{asset('images/frontend-pages/icon-circle-check.svg') }}" alt="">
                                <p class="fs-3 fw-bold text-dark mb-0">สามารถชำระเงินผ่านตัวกลาง</p>
                            @endif
                        </div>
                    </div>
                    @if ($item->Price == 0)
                        @if ($package_history->where('Package',$item->ID)->count() > 0)
                            <button  class="btn btn-primary"  disabled="true">ใช้งานไปแล้ว</button>
                        @else
                            <button  class="btn btn-primary" onclick="payment('{{$item->ID}}')">ทดลองใช้งาน</button>
                        @endif
                        
                    @else
                        <a href="javascript:void(0)" class="btn btn-primary" onclick="purpayment('{{$item->ID}}')">ชำระเงิน</a>
                    @endif

                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@push('scripts')
    <script>
        function payment(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "/user/paymentPackage/"+id, // ใช้ route เพื่อใส่ค่า id ใน URL
                type: "POST",
                data: {
                    packageid : id
                },
                success: function (response) {
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
                error: function (xhr, status, error) {
                    toastr.error("ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้", {
                        positionClass: "toastr toast-top-right",
                        containerId: "toast-top-right",
                    });
                }
            });
        }

        function purpayment(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "/user/purpayment/"+id, // ใช้ route เพื่อใส่ค่า id ใน URL
                type: "POST",
                data: {
                    packageid : id
                },
                success: function (response) {
                    $("#contentbody").html(response);
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