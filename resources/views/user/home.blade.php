@extends('user.layouts.app')
@section('content')
<div class="col-md-8 col-lg-8">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3" id="products-container">
        <!-- 1 -->
    </div>
</div>

<!-- right column (fixed width) -->
<div class="col-md-4 col-lg-3">
    <div class="d-flex flex-column gap-3">
        <form action="#" id="cartForm">
        <div class="mb-3">
            <label for="customerSelect">{{ __('messages.customer')}}</label>
            <div class="input-group">
                <select class="form-select select2" id="customerSelect" name="customer_id">
                    <option value="">{{ __('messages.select') }}</option>
                    @foreach($customers ?? [] as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }} {{ $customer->phone }}</option>
                    @endforeach
                </select>
                <button type="button" class="btn btn-outline-primary" id="addCustomerBtn">
                {{ __('messages.add') }}
                </button>
            </div>
        </div>
        <!-- queue card -->
        <div class="small-ghost text-center">
            <div style="font-size:34px;font-weight:700"><span id="ahead_people">0</span></div>
            <div style="margin-top:6px;color:#6b7280;font-size:14px"><strong>{{ __('messages.people') }}</strong> {{ __('messages.ahead') }}</div>
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
        <div class="small-ghost text-center mt-3">
            <button type="submit" id="submitCartBtn" class="btn btn-success w-100">Checkout</button>
        </div>
        </form>

    </div>
</div>
@endsection