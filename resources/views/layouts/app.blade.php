<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logos/favicon.png') }}" />

    <!-- Core Css -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />
    <link rel="stylesheet" href="{{ asset('libs/quill/dist/quill.snow.css') }}" />
    <link rel="stylesheet" href="{{ asset('libs/dropzone/dist/min/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('libs/sweetalert2/dist/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/owl.carousel/dist/assets/owl.carousel.min.css') }}">

    <title>Pratrade</title>
    <style>
        body {
            font-family: "Noto Sans Thai", serif !important;
        }

        .error {
            color: var(--bs-danger);
            display: block;
        }

        .validate {
            border-color: var(--bs-success) !important;
        }

        /* สำหรับ Input */
        input.is-invalid,
        select.is-invalid,
        textarea.is-invalid,
        input.error,
        select.error {
            border-color: var(--bs-form-invalid-border-color);
            padding-right: calc(1.5em + 16px);
            background-repeat: no-repeat;
            background-position: right calc(.375em + 4px) center;
            background-size: calc(.75em + 8px) calc(.75em + 8px);
        }

        /* สำหรับ Select2 */
        .select2-container.is-invalid .select2-selection {
            border-color: var(--bs-form-invalid-border-color);
            padding-right: calc(1.5em + 16px);
            background-repeat: no-repeat;
            background-position: right calc(.375em + 4px) center;
            background-size: calc(.75em + 8px) calc(.75em + 8px);
        }

        /* ข้อความแจ้งเตือน */
        .form-text.text-danger {
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .cover-image {
            width: 100%;
            height: 500px;
            object-fit: cover;
            /* ทำให้ภาพขยายหรือย่อจนเต็มกรอบ */
        }

        .cover-image-mini {
            width: 100%;
            height: 77px;
            object-fit: cover;
            /* ทำให้ภาพขยายหรือย่อจนเต็มกรอบ */
        }

        /* ใช้ media queries สำหรับขนาดหน้าจอที่ต่างกัน */
        @media (max-width: 768px) {
            .cover-image {
                height: 350px;
                /* ขนาดของภาพบนมือถือ */
            }

            .cover-image-mini {
                height: 45px;
            }
        }
        .dataTables_length{
            margin-bottom: 25px
        }

        .level-0 td:first-child {
            padding-left: 16px;
        }
        .level-1 td:first-child {
            padding-left: 80px;
        }
        .level-2 td:first-child {
            padding-left: 150px; /* เยื้อง 20px สำหรับ Lv1 */
        }
        .level-3 td:first-child {
            padding-left:220px; /* เยื้อง 40px สำหรับ Lv2 */
        }
        .level-4 td:first-child {
            padding-left: 290px; /* เยื้อง 60px สำหรับ Lv3 */
        }
    </style>
</head>

<body class="link-sidebar">
    <!-- Preloader -->
    <div class="preloader">
        <img src="{{ asset('images/logos/favicon.png') }}" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <div id="main-wrapper">
        @include('partials.sidebar')
        <div class="page-wrapper">
            @include('partials.navbar')

            <div class="body-wrapper">
                <div class="container-fluid" id="contentbody">
                    @yield('content')
                </div>
            </div>
        </div>

        @include('partials.shopping_cart')
    </div>
    <div class="dark-transparent sidebartoggler"></div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <script src="{{ asset('js/vendor.min.js') }}"></script>

    <!-- Import Js Files -->
    <script src="{{ asset('libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('js/theme/app.init.js') }}"></script>
    <script src="{{ asset('js/theme/theme.js') }}"></script>
    <script src="{{ asset('js/theme/app.min.js') }}"></script>
    <script src="{{ asset('js/theme/sidebarmenu.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

    <script src="{{ asset('libs/dropzone/dist/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('libs/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('libs/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('js/forms/select2.init.js') }}"></script>
    <script src="{{ asset('libs/jquery.repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('libs/jquery-validation/dist/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/forms/repeater-init.js') }}"></script>
    <script src="{{ asset('js/extra-libs/jqbootstrapvalidation/validation.js') }} "></script>
    <script src="{{ asset('js/plugins/bootstrap-validation-init.js') }}"></script>
    <script src="{{ asset('js/plugins/toastr-init.js') }}"></script>
    <script src="{{ asset('libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('libs/owl.carousel/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset(path: 'js/apps/productDetail.js') }}"></script>
    <script src="{{ asset('libs/inputmask/dist/jquery.inputmask.min.js')}}"></script>
    <script src="{{ asset('js/forms/mask.init.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/uuid@8.3.2/dist/umd/uuid.min.js"></script>
    {{-- <script src="{{ asset('js/datatable/datatable-basic.init.js') }}"></script> --}}
    <script>
        $(document).on('keypress', function(event) {
            if (event.keyCode === 13) { // keyCode 13 คือปุ่ม Enter
                event.preventDefault(); // ป้องกันไม่ให้ฟอร์มส่งข้อมูล
            }
        });
    </script>
    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif
    
        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    
        @if (session('info'))
            toastr.info("{{ session('info') }}");
        @endif
    
        @if (session('warning'))
            toastr.warning("{{ session('warning') }}");
        @endif
    </script>
    @stack('scripts')
</body>

</html>
