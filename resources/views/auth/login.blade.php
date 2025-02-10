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
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logos/favicon.png') }}') }}" />

    <!-- Core Css -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />
    <link rel="stylesheet" href="{{ asset('libs/quill/dist/quill.snow.css') }}" />
    <link rel="stylesheet" href="{{ asset('libs/dropzone/dist/min/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('libs/sweetalert2/dist/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/owl.carousel/dist/assets/owl.carousel.min.css') }}">

    <title>Pratrade</title>
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <img src="{{ asset('images/logos/favicon.png') }}" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <div id="main-wrapper" class="auth-customizer-none">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 w-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3 auth-card">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="../main/index.html"
                                    class="text-nowrap logo-img text-center d-block mb-5 w-100">
                                    <img src="{{ asset('images/logos/dark-logo.svg') }}" class="dark-logo"
                                        alt="Logo-Dark" />
                                    <img src="{{ asset('images/logos/light-logo.svg') }}" class="light-logo"
                                        alt="Logo-light" />
                                </a>
                                <div class="row">
                                    <div class="col-12">
                                        <a class="btn text-dark border fw-normal d-flex align-items-center justify-content-center rounded-2 py-8"
                                            href="{{ route('auth.facebook') }}" role="button">
                                            <img src="{{ asset('images/svgs/facebook-icon.svg') }}" alt="modernize-img"
                                                class="img-fluid me-2" width="18" height="18">
                                            <span class="flex-shrink-0">เข้าสู่ระบบด้วย Facebook</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="position-relative text-center my-4">
                                    <p
                                        class="mb-0 fs-4 px-3 d-inline-block bg-body text-dark z-index-5 position-relative">
                                        Login
                                    </p>
                                    <span
                                        class="border-top w-100 position-absolute top-50 start-50 translate-middle"></span>
                                </div>
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="Username" class="form-label">Username/Email</label>
                                        <input type="text" class="form-control" id="Username" name="Username" required
                                            aria-describedby="emailHelp">
                                    </div>
                                    <div class="mb-4">
                                        <label for="Password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="Password" name="Password" required>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <a class="text-primary fw-medium"
                                            href="../main/authentication-forgot-password.html">ลืมรหัสผ่าน ?</a>
                                    </div>
                                    <button type="submit"
                                        class="btn btn-primary w-100 py-8 mb-4 rounded-2">Login</button>
                                </form>
                                <div class="d-flex align-items-center justify-content-center">
                                    <a class="text-primary fw-medium ms-2"
                                        href="../main/authentication-register.html">ลงทะเบียนเข้าใช้งาน</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Import Js Files -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('js/theme/app.init.js') }}"></script>
    <script src="{{ asset('js/theme/theme.js') }}"></script>
    <script src="{{ asset('js/theme/app.min.js') }}"></script>
    <script src="{{ asset('js/plugins/toastr-init.js') }}"></script>
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
</body>

</html>