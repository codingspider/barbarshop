<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>@yield('title')</title>
  @if($siteFavicon)
  <link rel="icon" href="{{ $siteFavicon }}" type="image/png">
  @endif
  <link href="{{ asset('admin/assets/css/bootstrap.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('admin/assets/css/toastr.min.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css">
  <script src="{{ asset('admin/assets/js/screenfull.min.js') }}" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <link href="{{ asset('admin/assets/css/select2.min.css') }}" rel="stylesheet" />
  @stack('extra_css')
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    :root {
        --panel-w: 1100px; 
    }

    body {
        background: #fafafa;
    }

    /* Main responsive container */
    .main-wrapper {
        width: 1100px; /* Fixed width for desktop */
        margin: 0 auto; /* Center horizontally */
        background: #fff;
        border-radius: 14px;
        padding: 18px;
    }

    /* Tablet view */
    @media (max-width: 1024px) {
        .main-wrapper {
            width: 900px; /* Fixed width for tablet */
            padding: 16px;
        }
    }

    /* Mobile view */
    @media (max-width: 768px) {
        .main-wrapper {
            width: 100%; /* Full width on mobile */
            padding: 12px;
            border-radius: 10px;
        }
    }


    .service-card {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #eee;
        background: #fff;
    }

    .service-card img {
        width: 100%;
        height: 140px;
        object-fit: cover;
        display: block;
    }

    .service-body {
        padding: 10px 12px;
    }

    .service-title {
        font-size: 15px;
        font-weight: 600;
        color: #111;
    }

    .service-price {
        font-size: 13px;
        color: #6b7280;
    }

    .small-ghost {
        border-radius: 12px;
        border: 1px solid #eee;
        padding: 14px;
    }

    .right-col .small-ghost {
        background: #fff;
    }

    .nav-link.active {
        color: #0d6efd !important;
        font-weight: 600;
        border-bottom: 2px solid #0d6efd;
    }
  </style>
</head>
<body class="align-items-center justify-content-center p-3">
  <div class="position-relative device-frame">
    <div class="main-wrapper">
      @include('user.customer_modal')
      @include('user.partials.header')

      <!-- Navigation -->
      @include('user.partials.nav')

      <div class="row g-4 mt-2">
        <!-- Cart column -->
        <div class="col-auto cart_count" style="width:56px; display:none">
          <div class="d-flex flex-column align-items-start" style="height:100%">
            <div class="position-relative" style="width:48px;height:48px;border-radius:12px;background:#ffffff;border:1px solid #e0e0e0;display:flex;justify-content:center;align-items:center;box-shadow:0 2px 6px rgba(0,0,0,0.1);cursor:pointer;transition:all 0.3s ease;">
              🛒
              <span class="cart-count" style="position:absolute;top:-6px;right:-6px;background:#ff4757;color:#fff;font-size:12px;font-weight:bold;width:20px;height:20px;display:flex;align-items:center;justify-content:center;border-radius:50%;box-shadow:0 2px 4px rgba(0,0,0,0.2);">
                0
              </span>
            </div>
          </div>
        </div>
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
  <script src="{{ asset('js/front.js') }}"></script>
  @stack('extra_js')
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
<script>
$(document).on('change', '.user-status-toggle', function() {
    let userId = $(this).data('id');
    let status = $(this).is(':checked') ? 'active' : 'inactive';

    $.ajax({
        url: '/user/status/' + userId,
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            status: status
        },
        success: function(response) {
          if(status == 'active'){
          $('.user_status').text('Available');
          }else{
            $('.user_status').text('Unavailable');
          }
        },
        error: function() {
            alert('Error updating status');
        }
    });
});
</script>

</body>
</html>
