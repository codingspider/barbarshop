<div class="modal fade right" id="Settingmodal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog  modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body custom_setting">
                <div class="py-2 py-md-2 me-0 border-end">
                    <div class="d-flex flex-column h-100">
                        <!-- Logo -->
                        <a href="{{ route('admin.dashboard') }}" class="mb-0 brand-icon">
                            <span class="logo-icon">
                                <i class="fa fa-gg-circle fs-3"></i>
                            </span>
                            <span class="logo-text">{{ env('APP_NAME') }}</span>
                        </a>
                        <!-- Sidebar -->
                        <div class="bg-light vh-100 p-3" style="width: 250px;">
                            <h5 class="mb-4">Admin Panel</h5>
                            <ul class="nav flex-column">
                                <li class="nav-item mb-2">
                                    <a class="nav-link active" href="{{ route('admin.dashboard') }}">
                                        Dashboard
                                    </a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a class="nav-link" href="{{ route('admin.users.index') }}">
                                        Users
                                    </a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a class="nav-link" href="{{ route('admin.currencies.index') }}">
                                        Currencies
                                    </a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a class="nav-link" href="{{ route('admin.services.index') }}">
                                        Services
                                    </a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a class="nav-link" href="{{ route('admin.addons.index') }}">
                                        Addons
                                    </a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a class="nav-link" href="{{ route('admin.app-management') }}">
                                        App Management
                                    </a>
                                </li>
                                <li class="nav-item mb-2">
                                    <a class="nav-link" href="{{ route('admin.barbers.index') }}">
                                        Barbers
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>