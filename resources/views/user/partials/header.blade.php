<div class="d-flex align-items-center">
    <div class="d-flex align-items-center">
        <div class="rounded-circle d-flex align-items-center justify-content-center"
            style="width:36px;height:36px;background:#f3f4f6;border:1px solid #ececec;margin-right:12px">
            🏠
        </div>
        <div>
            <div style="font-size:14px;font-weight:700">THE MODERN MAN</div>
            <div style="font-size:11px;letter-spacing:0.08em;color:#6b7280">BARGERSHOP</div>
        </div>
    </div>
    <div class="flex-grow-1"></div>
    <div class="text-end">
        @if(\Auth::guard('user')->user())
        <a class="btn btn-sm btn-danger" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
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


        <div class="d-inline-flex gap-2 align-items-center d-none d-md-inline-block">
            <button type="button" title="{{ __('messages.full_screen') }}" class="btn btn-sm btn-secondary"
                id="fullscreen-btn">
                <i class="fa fa-window-maximize fa-lg"></i>
                <span>{{ __('messages.full_screen') }}</span>
            </button>
        </div>

        @if(\Auth::guard('user')->user()?->user_type == 'user')
        <br>
        <div class="d-none d-md-inline-block">
            <div style="font-size:13px;color:#6b7280">{{ __('messages.today_total_sales') }}</div>
            <div style="font-size:18px;font-weight:700">$3,620.00</div>
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
        <br>
        <div class="dropdown mt-2 d-none d-md-inline-block">
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