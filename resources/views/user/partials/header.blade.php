<div class="d-flex nav justify-content-between align-items-center flex-wrap px-3 px-md-4">
    <!-- Left Section (Logo + App Name) -->
    <div class="d-flex align-items-center">
        <div class="rounded-circle d-flex align-items-center justify-content-center">
            @if($siteLogo)
            <img src="{{ $siteLogo }}" alt="Site Logo" height="30">
            @endif
        </div>
        <div class="ms-2">
            <div style="font-size:14px; font-weight:700;">{{ env('APP_NAME') }}</div>
            <div style="font-size:11px; letter-spacing:0.08em; color:#6b7280;">BARGERSHOP</div>
        </div>
    </div>

    <!-- Right Section -->
    <div class="d-flex align-items-center gap-3 mt-2 mt-md-0">
        @if(\Auth::guard('user')->user())
        <a class="btn btn-sm btn-danger" href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Signout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
        @else
        <a href="{{ route('login') }}" class="btn btn-primary">
            {{ __('messages.sign_in') }}
        </a>
        @endif

        <!-- Fullscreen Button -->
        <div class="d-none d-md-inline-flex align-items-center">
            <button type="button" title="{{ __('messages.full_screen') }}" class="btn btn-sm btn-secondary"
                id="fullscreen-btn">
                <i class="fa fa-window-maximize fa-lg"></i>
                <span>{{ __('messages.full_screen') }}</span>
            </button>
        </div>

        <!-- User Type Specific -->
        @if(\Auth::guard('user')->user()?->user_type == 'user')
        <div class="d-none d-md-block text-end">
            <div style="font-size:13px;color:#6b7280">{{ __('messages.today_total_sales') }}</div>
            <div style="font-size:18px;font-weight:700">{{ formatPrice($payments)}}</div>
        </div>
        @else
        @php
        $flags = [
        'en' => 'GB.png',
        'ar' => 'AR.png',
        'fr' => 'FR.png',
        ];
        $currentLocale = app()->getLocale();
        $currentFlag = $flags[$currentLocale] ?? 'GB.png';
        @endphp
        <div class="dropdown d-none d-md-inline-block">
            <button class="btn btn-light dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown"
                aria-expanded="false">
                <img src="{{ asset('admin/assets/images/flag/' . $currentFlag) }}" alt="" width="20" class="me-1">
                {{ __('messages.language')}}
            </button>
            <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                <li>
                    <a class="dropdown-item" href="{{ route('lang.switch', 'en') }}">
                        <img src="{{ asset('admin/assets/images/flag/GB.png') }}" alt="" width="20" class="me-1">
                        {{ __('messages.english')}}
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('lang.switch', 'ar') }}">
                        <img src="{{ asset('admin/assets/images/flag/AR.png') }}" alt="" width="20" class="me-1">
                        {{__('messages.arabic')}}
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('lang.switch', 'fr') }}">
                        <img src="{{ asset('admin/assets/images/flag/FR.png') }}" alt="" width="20" class="me-1">
                        {{__('messages.french')}}
                    </a>
                </li>
            </ul>
        </div>
        @endif
    </div>
</div>