<!-- Sidebar Start -->
<aside class="left-sidebar with-vertical">
    <div><!-- ---------------------------------- -->
        <!-- Start Vertical Layout Sidebar -->
        <!-- ---------------------------------- -->
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="../main/index.html" class="text-nowrap logo-img">
                <img src="{{ asset('images/logos/dark-logo.svg') }}" class="dark-logo" alt="Logo-Dark" />
                <img src="{{ asset('images/logos/light-logo.svg') }}" class="light-logo" alt="Logo-light" />
            </a>
            <a href="javascript:void(0)" class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
                <i class="ti ti-x"></i>
            </a>
        </div>

        <nav class="sidebar-nav scroll-sidebar" data-simplebar>
            <ul id="sidebarnav">
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('home') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-aperture"></i>
                        </span>
                        <span class="hide-menu">รายการพระเครื่อง</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('product.create') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-message-2-share"></i>
                        </span>
                        <span class="hide-menu">ลงประกาศ</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('product.create') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-history"></i>
                        </span>
                        <span class="hide-menu">ประวัติการเช่าพระ</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('product.create') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-category"></i>
                        </span>
                        <span class="hide-menu">รายการที่ลงประกาศ</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('bookbank.bookbanuser') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-book-2"></i>
                        </span>
                        <span class="hide-menu">หมายเลขบัญชีรับเงิน</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('product.create') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-list"></i>
                        </span>
                        <span class="hide-menu">รายการผู้เช่าพระ</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('product.create') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-phone"></i>
                        </span>
                        <span class="hide-menu">ติดต่อเรา</span>
                    </a>
                </li>
                @if(Auth::check() && Auth::user()->Permission_Code == 'P01')
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Master</span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('categories.index') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-category-2"></i>
                        </span>
                        <span class="hide-menu">หมวดหมู่สินค้า</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('package.index') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-packages"></i>
                        </span>
                        <span class="hide-menu">แพ็คเกจ</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('bookbank.index') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-building-bank"></i>
                        </span>
                        <span class="hide-menu">หมายเลขบัญชีกลาง</span>
                    </a>
                </li>

                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Administrator</span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('user.index') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-users"></i>
                        </span>
                        <span class="hide-menu">User</span>
                    </a>
                </li>
                @endif
            </ul>
        </nav>

        <div class="fixed-profile p-3 mx-4 mb-2 bg-secondary-subtle rounded mt-3">
            <div class="hstack gap-3">
                <div class="john-img">
                    <img src="{{ asset('images/profile/user-1.jpg') }}" class="rounded-circle" width="40"
                        height="40" alt="modernize-img" />
                </div>
                <div class="john-title">
                    <h6 class="mb-0 fs-4 fw-semibold">Mathew</h6>
                    <span class="fs-2">Designer</span>
                </div>
                <button class="border-0 bg-transparent text-primary ms-auto" tabindex="0" type="button"
                    aria-label="logout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="logout" onclick="event.preventDefault(); $('#logout-form').submit();">
                    <i class="ti ti-power fs-6"></i>
                </button>
            </div>
        </div>

        <!-- ---------------------------------- -->
        <!-- Start Vertical Layout Sidebar -->
        <!-- ---------------------------------- -->
    </div>
</aside>
<!--  Sidebar End -->
