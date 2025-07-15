<nav class="navbar bg-body-tertiary fixed-top">
    <div class="container-fluid">
        <div>
            {{-- <a class="navbar-brand" href="#">Offcanvas navbar</a> --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="mx-2">
            <span>
                {{ session('user.name') }} {{ session('user.surname') }}
                ({{ session('department.department_name') }})
            </span>
            <a class=" align-items-center" href="{{ route('logout') }}">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
            </a>
        </div>
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar"
            aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><img src="{{ asset('images/logo1.png') }}"
                        width="200px"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('form_scan') ? ' active' : '' }}" aria-current="page"
                            href="{{ url('/form_scan') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('import_data') ? ' active' : '' }}"
                            href="{{ url('/import_data') }}">Import Data & OnHand</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="#">Store Onhand</a>
                    </li> --}}
                </ul>
            </div>
        </div>
    </div>
</nav>
