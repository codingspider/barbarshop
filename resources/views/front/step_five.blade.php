<div class="row">
<div class="col-md-8 col-lg-8">
    <div class="row">
        <!-- 1 -->
        @foreach($services as $service)
        <div class="col-md-4 col-sm-6 mb-3">
            <div class="service-card"
                style="cursor: pointer; transition: transform 0.2s ease, box-shadow 0.2s ease; position: relative; z-index: 1;">
                <img src="{{ Storage::url($service->image) }}" alt="{{ $service->name }}"
                    style="width: 100%; pointer-events: none;">

                <div class="service-body mt-2">
                    <div class="service-title">{{ $service->name }}</div>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <div class="service-price mb-0">{{ formatPrice($service->price) }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- right column (fixed width) -->
<div class="col-md-4 col-lg-4">
    <div class="d-flex flex-column gap-3">
        <form action="#" id="cartForm">
            <!-- queue card -->
            <div class="small-ghost text-center">
                <div style="font-size:34px;font-weight:700"><span id="ahead_people">0</span></div>
                <div style="margin-top:6px;color:#6b7280;font-size:14px"><strong>{{ __('messages.people') }}</strong>
                    {{ __('messages.ahead') }}</div>
                <div style="margin-top:12px;color:#9ca3af">{{ __('approx') }}, 25 min</div>
            </div>

            <!-- order summary -->
            <div class="small-ghost mt-3">
                <div class="d-flex justify-content-between small text-muted mb-1">
                    <table class="table table-bordered" id="cart-table">
                        <tbody>
                        </tbody>
                    </table>
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

            <!-- checkout box -->
            @if(\Auth::guard('user')->user())
            <div class="small-ghost text-center mt-3">
                <button type="submit" id="submitCartBtn" class="btn btn-success w-100">Checkout</button>
            </div>
            @endif
        </form>

    </div>
</div>
</div>