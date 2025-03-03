<div class="offcanvas-body h-100 px-4 pt-0" data-simplebar>
    <ul class="mb-0">
        @php
            $i = 0;
        @endphp
        @foreach ($cartProducts->groupby('Shop_ID') as $item)
            <a href="../main/page-user-profile.html" class="d-flex align-items-center pb-9 position-relative">
                <div class="text-bg-light rounded-1 me-3 p-6 d-flex align-items-center justify-content-center">
                    <img src="{{ asset('images/svgs/icon-dd-cart.svg') }}" alt="modernize-img" class="img-fluid"
                        width="24" height="24">
                </div>
                <div>
                    <h6 class="mb-1 fw-semibold fs-3">
                        ซื้อจาก : {{ $item->first()->shop->Firstname }}
                    </h6>
                    <span class="fs-2 d-block text-body-secondary">ดูสินค้าเพิ่มเติม</span>
                </div>
            </a>
            @foreach ($cartProducts->where('Shop_ID', $item->first()->Shop_ID) as $item_product)
                <li class="pb-7">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('storage/' . $item_product->product->images->first()->Path_Image) }}" width="95" height="75"
                            class="rounded-1 me-9 flex-shrink-0" alt="modernize-img" />
                        <div>
                            <h6 class="mb-1" style="width: 155px !important;">{{$item_product->product->Product_Name}}</h6>
                            <div class="d-flex align-items-center justify-content-between mt-2">
                                <h6 class="fs-2 fw-semibold mb-0 text-muted">฿{{ number_format($item_product->product->Price) }}</h6>
                                <div class="input-group input-group-sm w-50">
                                    <button class="btn border-0 round-20 minus p-0 bg-success-subtle text-success"
                                        type="button">
                                        -
                                    </button>
                                    <input type="text"
                                        class="form-control round-20 bg-transparent text-muted fs-2 border-0 text-center qty"
                                        placeholder="" aria-label="Example text with button addon"
                                        aria-describedby="add{{$i}}" value="{{$item_product->Qty}}" max="{{$item_product->product->Stock_qty}}"/>
                                    <button class="btn text-success bg-success-subtle p-0 round-20 border-0 add"
                                        type="button">
                                        +
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                @php
                    $i++;
                @endphp
            @endforeach
        @endforeach
    </ul>
    <div class="align-bottom">
        <div class="d-flex align-items-center pb-7">
            <span class="text-dark fs-3">Sub Total</span>
            <div class="ms-auto">
                <span class="text-dark fw-semibold fs-3">$2530</span>
            </div>
        </div>
        <div class="d-flex align-items-center pb-7">
            <span class="text-dark fs-3">Total</span>
            <div class="ms-auto">
                <span class="text-dark fw-semibold fs-3">$6830</span>
            </div>
        </div>
        <a href="../main/eco-checkout.html" class="btn btn-outline-primary w-100">ชำระเงิน</a>
    </div>
</div>
<script>
$(document).ready(function () {
  $(".minus, .add").on("click", function () {
    var qtyInput = $(this).closest("div").find(".qty");
    var maxqty = qtyInput.attr("max");
    var currentVal = parseInt(qtyInput.val());
    var isAdd = $(this).hasClass("add");

    if (!isNaN(currentVal)) {
      qtyInput.val(isAdd ? ++currentVal : currentVal > 0 ? --currentVal : currentVal);
    }

    checkQty(maxqty,qtyInput)
  });
});
</script>
