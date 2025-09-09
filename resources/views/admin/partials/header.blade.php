<!-- Body: Header -->
<div class="header">
    <nav class="navbar py-4 bg-light">
        <div class="container-xxl d-flex justify-content-between">

            <!-- Left side (can add logo or menu toggle) -->
            <div class="d-flex align-items-center">
                <a class="navbar-brand" href="#">Admin Panel</a>
            </div>

            <!-- Right side: User Profile & Settings -->
            <div class="d-flex align-items-center">

                <!-- Settings Icon -->
                <div class="me-3">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#Settingmodal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="var(--chart-color1)" class="bi bi-ui-checks-grid" viewBox="0 0 16 16"> <path style="fill:var(--chart-color1)" d="M2 10h3a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1zm9-9h3a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-3a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zm0 9a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1h-3zm0-10a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h3a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2h-3zM2 9a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h3a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H2zm7 2a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-3a2 2 0 0 1-2-2v-3zM0 2a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm5.354.854a.5.5 0 1 0-.708-.708L3 3.793l-.646-.647a.5.5 0 1 0-.708.708l1 1a.5.5 0 0 0 .708 0l2-2z"></path> </svg>
                    </a>
                </div>

                <!-- User Profile Dropdown -->
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle p-0" href="#" role="button" data-bs-toggle="dropdown"
                        data-bs-display="static">
                        <img class="avatar rounded-circle img-thumbnail" src="{{ asset('admin/assets/images/profile_av.svg') }}" alt="profile" width="40">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li class="px-3 py-2">
                            <strong>{{ Auth::guard('admin')->user()->name }}</strong><br>
                            <small>{{ Auth::guard('admin')->user()->email }}</small>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Sign Out
                            </a>
                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </nav>
</div>
