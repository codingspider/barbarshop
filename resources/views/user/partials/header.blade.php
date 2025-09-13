<div class="d-flex nav justify-content-between align-items-center flex-wrap px-3 px-md-4">
    <!-- Left Section (Logo + App Name) -->
    <div class="d-flex align-items-center">
        <div class="rounded-circle d-flex align-items-center justify-content-center">
            @if($siteLogo)
            <img src="{{ $siteLogo }}" alt="Site Logo" height="30">
            @endif
        </div>
        <div class="ms-2">
            <div style="font-size:14px; font-weight:700;">{{ config('app.name') }}</div>
            <!-- <div style="font-size:11px; letter-spacing:0.08em; color:#6b7280;">{{ config('app.name') }}</div> -->
        </div>
    </div>

    <!-- Right Section -->
    <div class="d-flex align-items-center gap-3 mt-2 mt-md-0">
        @if(\Auth::guard('user')->user())
        <a class="btn btn-sm btn-danger" href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            {{ __('messages.signout') }}
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
        @if(\Auth::guard('user')->user()?->user_type == 'user')
        <div class="d-none d-md-block text-end">
            <div style="font-size:13px;color:#6b7280">{{ __('messages.today_total_sales') }}</div>
            <div style="font-size:18px;font-weight:700">{{ formatPrice($payments)}}</div>
            <input type="hidden" id="default_currency" value="{{ defaultCurrency() }}">
        </div>
        @else
        @php
            $user = \Auth::guard('user')->user();
            $today_tickets = \App\Models\Ticket::whereDate('finished_at', \Carbon\Carbon::today())->where('assigned_barber_id', $user->id)->pluck('id');
            $sells = \App\Models\Order::whereIn('ticket_id', $today_tickets)->sum('total');
        @endphp
        
        <div class="d-none d-md-block text-end">
            <div class="form-check form-switch">
            <input class="form-check-input user-status-toggle" 
                    type="checkbox" 
                    id="userStatus{{ $user->id }}" 
                    data-id="{{ $user->id }}" 
                    {{ $user->status == 'active' ? 'checked' : '' }}>
                    <label class="form-check-label user_status" for="userStatus{{ $user->id }}">
                        {{ $user->status == 'active' ? __('messages.available') : __('messages.unavailable') }}
                    </label>
            </div>
        </div>
        <div class="d-none d-md-block text-end">
            <div style="font-size:13px;color:#6b7280">{{ __('messages.today_total_sales') }}</div>
            <div style="font-size:18px;font-weight:700">{{ formatPrice($sells)}}</div>
            <input type="hidden" id="default_currency" value="{{ defaultCurrency() }}">
        </div>
        @endif
    </div>
</div>