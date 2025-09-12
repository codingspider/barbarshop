<div class="row">
    <!-- Left Column (Queue Card) -->
    <div class="col-md-6 col-lg-6">
        <div class="small-ghost text-center">
            <div style="font-size:34px;font-weight:700">
                <span id="ahead_people">{{ $datas['waiting']}}</span>
            </div>
            <div style="margin-top:6px;color:#6b7280;font-size:14px">
                <strong>{{ __('messages.people') }}</strong>
                {{ __('messages.ahead') }}
            </div>
            <div style="margin-top:12px;color:#9ca3af">
                {{ __('messages.approx') }}, {{ $datas['time']}} {{ __('messages.min')}}
            </div>
        </div>
    </div>

    <!-- Right Column (Cart & Checkout) -->
    <div class="col-md-6 col-lg-6">
        <form action="#" id="cartForm" class="d-flex flex-column gap-3">

            <!-- Order summary -->
            <div class="small-ghost">

                <div class="d-flex justify-content-between small text-muted mb-1">
                    <div><span class="service_name"></span></div>
                    <div><span class="service_price">0</span></div>
                </div>
                
                <div class="addonsData">

                </div>
                
                <div class="d-flex justify-content-between small text-muted mb-1">
                    <div>{{ __('messages.subtotal') }}</div>
                    <div><span class="cart-subtotal">0</span></div>
                </div>

                <hr>
                <div class="d-flex justify-content-between fw-semibold">
                    <div>{{ __('messages.total') }}</div>
                    <div><span class="cart-total">0</span></div>
                </div>
            </div>

            <!-- Checkout box -->
            @if(\Auth::guard('user')->user())
            <div class="small-ghost text-center mt-3">
                <button type="submit" id="submitCartBtn" class="btn btn-success w-100">{{ __('messages.checkout')}}</button>
            </div>
            @endif

        </form>
    </div>
</div>
