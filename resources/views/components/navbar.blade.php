<div class="navbar-header">
    <div class="d-flex">
        <!-- LOGO -->
        <div class="navbar-brand-box">
            <a href="{{ url('/dashboard') }}" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="{{ asset ('assets/images/logo-sm.png') }}" alt="logo-sm" height="22">
                </span>
                <span class="logo-lg">
                    <img src="{{ asset ('assets/images/logo-dark.png') }}" alt="logo-dark" height="20">
                </span>
            </a>
        </div>
        <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
            <i class="ri-menu-2-line align-middle"></i>
        </button>
    </div>

    <div class="d-flex">
        <div class="dropdown d-inline-block user-dropdown">
            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="rounded-circle header-profile-user" src="{{ asset ('assets/images/users/avatar-1.jpg') }}"
                    alt="Header Avatar">
                <span class="d-none d-xl-inline-block ms-1">{{ Auth::user()->nama }}</span>
                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <!-- item-->
                {{-- <a class="dropdown-item" href="#"><i class="ri-user-line align-middle me-1"></i> Profile</a> --}}
                {{-- <a class="dropdown-item" href="#"><i class="ri-lock-unlock-line align-middle me-1"></i> Lock screen</a> --}}
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" href="{{ route('logout') }}"><i class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout</a>
            </div>
        </div>
    </div>
</div>