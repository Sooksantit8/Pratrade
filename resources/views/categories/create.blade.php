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
        $id = $categories->first()->ID ?? ''; // ใช้ 'id' จากฐานข้อมูล
        $url = route('categories.insertCategory'); // URL สำหรับ insert

        // ถ้ามี id ก็จะเปลี่ยน URL เป็น URL สำหรับ update
        if ($id != '') {
            $url = route('categories.update', ['id' => $categories->first()->ID]);
        }
    @endphp

    <form id="formaddcategory" action="{{ $url }}" method="POST" novalidate>
        <div class="table-responsive mb-4 border rounded-1">
            <table class="table text-nowrap mb-0 align-middle" id="categoryTable">
                <thead>
                    <tr>
                        <th>หมวดหมู่หลัก</th>
                        <th width="5%"></th>
                        <th width="5%"></th>
                    </tr>
                </thead>
                <tbody>
                    @if (($ID ?? '') != '')
                        <tr class="level-0">
                            <td class="category-name">
                                <input type="hidden" name="Sortorder[{{ $ID }}]" class="form-control Sortorder"
                                    required aria-autocomplete="none" readonly>
                                <input type="hidden" name="Main_id" class="form-control" required aria-autocomplete="none"
                                    value="{{ $ID }}" readonly>
                                <input type="hidden" name="Parent_id[{{ $ID }}]" data-id="{{ $ID }}"
                                    class="form-control Parent_id" required aria-autocomplete="none" readonly>
                                <input type="text" name="Category_name[{{ $ID }}]"
                                    class="form-control Category_name" required aria-autocomplete="none">
                                <input type="hidden" name="Level[{{ $ID }}]" class="form-control Level" required
                                    aria-autocomplete="none" readonly value="0">
                            </td>
                            <td>
                                <div class="action-btn">
                                    <a href="javascript:void(0)" class="text-dark delete ms-2 add-level">
                                        <i class="ti ti-plus"></i>
                                    </a>
                                </div>
                            </td>
                            <td>
                            </td>
                        </tr>
                    @else
                        @foreach ($categories as $category)
                            <tr class="level-{{ $category->Level }}">
                                <td class="category-name">
                                    <input type="hidden" name="Sortorder[{{ $category->ID }}]"
                                        class="form-control Sortorder" required aria-autocomplete="none" readonly>
                                    <input type="hidden" name="Main_id" class="form-control" required
                                        aria-autocomplete="none" value="{{ $category->ID }}" readonly>
                                    <input type="hidden" name="Parent_id[{{ $category->ID }}]"
                                        data-id="{{ $category->ID }}" value="{{ $category->Parent_id }}"
                                        class="form-control Parent_id" required aria-autocomplete="none" readonly>
                                    <input type="text" name="Category_name[{{ $category->ID }}]"
                                        value="{{ $category->Category_name }}" class="form-control Category_name" required
                                        aria-autocomplete="none">
                                    <input type="hidden" name="Level[{{ $category->ID }}]" value="{{ $category->Level }}"
                                        class="form-control Level" required aria-autocomplete="none" readonly
                                        value="0">
                                </td>
                                <td>
                                    <div class="action-btn">
                                        <a href="javascript:void(0)" class="text-dark delete ms-2 add-level">
                                            <i class="ti ti-plus"></i>
                                        </a>
                                    </div>

                                </td>
                                @if ($category->Level != 0)
                                    <td>
                                        <div class="action-btn">
                                            <a href="javascript:void(0)" class="text-dark delete ms-2 delete-row">
                                                <i class="ti ti-trash fs-5"></i>
                                            </a>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @endif

                </tbody>
            </table>
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
        $(document).ready(function() {
            $(document).on('click', '.add-level', function() {
                var level = $(this).closest('tr').find(".Level").val(); // รับค่า Level
                var newLevel = parseInt(level) + 1;

                var parent_id = $(this).closest('tr').find(".Parent_id").attr("data-id");
                var uniqueId = uuid.v4();

                var newRow = `
                        <tr class="level-${newLevel}">
                            <td class="category-name">
                                <input type="hidden" name="Sortorder[${uniqueId}]" class="form-control Sortorder" required aria-autocomplete="none"
                                    readonly>
                                <input type="hidden" name="Parent_id[${uniqueId}]" value="${parent_id}" data-id="${uniqueId}" class="form-control Parent_id" required aria-autocomplete="none"
                                    readonly>
                                <input type="text" name="Category_name[${uniqueId}]" class="form-control Category_name" required
                                    aria-autocomplete="none">
                                <input type="hidden" name="Level[${uniqueId}]" value="${newLevel}" class="form-control Level" required aria-autocomplete="none"
                                    readonly value="${newLevel}">
                            </td>
                            <td>
                                <a href="javascript:void(0)" class="text-dark delete ms-2 add-level">
                                    <i class="ti ti-plus"></i>
                                </a>
                            </td>
                            <td>
                                <div class="action-btn">
                                    <a href="javascript:void(0)" class="text-dark delete ms-2 delete-row">
                                        <i class="ti ti-trash fs-5"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    `;

                $(this).closest('tr').after(newRow);
            });

            $(document).on('click', '.delete-row', function() {
                var level = $(this).closest('tr').attr('class').split('-')[1];
                var currentRow = $(this).closest('tr');

                currentRow.nextAll().each(function() {
                    var nextLevel = $(this).attr('class').split('-')[1];
                    if (parseInt(nextLevel) > parseInt(level)) {
                        $(this).remove();
                    } else {
                        return false;
                    }
                });

                currentRow.remove();
            });
        });

        $("#savedata").click(function(event) {
            var Isvalid = $("#formaddcategory").valid()
            if (Isvalid) {
                $('#categoryTable tbody tr').each(function(index, element) {
                    $(element).find('.Sortorder').val(index);
                });
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
