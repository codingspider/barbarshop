<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Barbershop POS — Static</title>
  <link href="{{ asset('admin/assets/css/bootstrap.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('admin/assets/css/toastr.min.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css">
  <script src="{{ asset('admin/assets/js/screenfull.min.js') }}"  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <link href="{{ asset('admin/assets/css/select2.min.css') }}" rel="stylesheet" />
  @yield('extra_css')
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    :root{--panel-w:1100px;}
    body{background:#fafafa;}
    /* Tablet-like frame similar to reference */

    .inner-pad{background:#fff;border-radius:14px;padding:18px;}
    .service-card{border-radius:12px;overflow:hidden;border:1px solid #eee;background:#fff}
    .service-card img{width:100%;height:140px;object-fit:cover;display:block}
    .service-body{padding:10px 12px}
    .service-title{font-size:15px;font-weight:600;color:#111}
    .service-price{font-size:13px;color:#6b7280}
    .small-ghost{border-radius:12px;border:1px solid #eee;padding:14px}
    .right-col .small-ghost{background:#fff}
    .vertical-left{position:absolute;left:36px;top:120px}
    /* make layout stable */
    @media (max-width:1160px){:root{--panel-w:980px}}
    .select2-container--default .select2-selection--single{
      height: 38px;
    }
  </style>
</head>
<body class="d-flex align-items-center justify-content-center p-3">
  <div class="position-relative device-frame container">
    <div class="inner-pad">
      <!-- Top bar -->
      @include('user.customer_modal')
      @include('user.partials.header')

      <!-- Tabs -->
      <div class="mt-4">
        <ul class="nav" style="border-bottom:1px solid #eee">
          @if(\Auth::guard('user')->user()?->user_type == 'customer')
          <li class="nav-item"><a style="margin-right: 10px" class="nav-link px-0 pb-2 text-muted" href="#">Dashboard</a></li>
          <li class="nav-item"><a style="margin-right: 10px" class="nav-link px-0 pb-2 text-muted" href="#">Bookings</a></li>
          <li class="nav-item"><a style="margin-right: 10px" class="nav-link active px-0 pb-2" href="#" style="color:#111;font-weight:500">Services</a></li>
          <li class="nav-item"><a style="margin-right: 10px" class="nav-link px-0 pb-2 text-muted" href="#">Reports</a></li>
          @elseif(\Auth::guard('user')->user()?->user_type == 'user')
          <li class="nav-item"><a style="margin-right: 10px" class="nav-link px-0 pb-2 text-muted" href="#">Dashboard</a></li>
          <li class="nav-item"><a style="margin-right: 10px" class="nav-link px-0 pb-2 text-muted" href="#">Appointments</a></li>
          <li class="nav-item"><a style="margin-right: 10px" class="nav-link px-0 pb-2 text-muted" href="#">Manage Services</a></li>
          <li class="nav-item"><a style="margin-right: 10px" class="nav-link px-0 pb-2 text-muted" href="#">Reports</a></li>
          <li class="nav-item"><a style="margin-right: 10px" class="nav-link active px-0 pb-2" href="#" style="color:#111;font-weight:500">Services</a></li>
          @else
          <li class="nav-item"><a style="margin-right: 10px" class="nav-link active px-0 pb-2" href="{{ url('/') }}" style="color:#111;font-weight:500">Services</a></li>
          @endif
        </ul>
      </div>

      <div class="row g-4 mt-2">
        <!-- left tiny column for cart icon (vertical) -->
        @if(url()->current() != 'login')
        <div class="col-auto d-none d-md-block" style="width:56px;">
          <div class="d-flex flex-column align-items-start" style="height:100%">
            <div class="position-relative" style="width:48px;height:48px;border-radius:12px;background:#ffffff;border:1px solid #e0e0e0;display:flex;justify-content:center;align-items:center;box-shadow:0 2px 6px rgba(0,0,0,0.1);cursor:pointer;transition:all 0.3s ease;">
              🛒
              <span class="cart-count" style="position:absolute;top:-6px;right:-6px;background:#ff4757;color:#fff;font-size:12px;font-weight:bold;width:20px;height:20px;display:flex;align-items:center;justify-content:center;border-radius:50%;box-shadow:0 2px 4px rgba(0,0,0,0.2);">
                0
              </span>
            </div>
          </div>
        </div>

        @endif

        @yield('content')

      </div>
    </div>
  </div>
  <script src="{{ asset('admin/assets/js/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ asset('admin/assets/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('admin/assets/js/toastr.min.js') }}"></script>
  <script src="{{ asset('admin/assets/js/select2.min.js') }}"></script>
  <script src="{{ asset('cart/cart.js') }}"></script>
  <script src="{{ asset('cart/app.js') }}"></script>

  @yield('extra_js')
<script>
$(document).ready(function(){
    $('button#fullscreen-btn').click(function(e) {
        e.preventDefault();
        const element = document.getElementById('myElement') || document.documentElement;
        if (screenfull.isEnabled) {
            screenfull.toggle(element);
        } else {
            console.log('Fullscreen API not enabled in this browser.');
        }
    });

    $('.select2').select2();
});

</script>
</body>
</html>