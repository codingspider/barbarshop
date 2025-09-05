
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('admin/assets/favicon.ico') }}" type="image/x-icon">

    <!-- plugin css file  -->
    <link rel="stylesheet" href="{{ asset('admin/assets/plugin/datatables/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/plugin/datatables/dataTables.bootstrap5.min.css') }}"> 
    
    <!-- project css file  -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/cryptoon.style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/toastr.min.css') }}">
</head>
<body>
    <div id="cryptoon-layout" class="theme-orange">
        
        <!-- sidebar -->
        @include('admin.partials.sidebar')

        <!-- main body area -->
        <div class="main px-lg-4 px-md-4">

            <!-- Body: Header -->
            @include('admin.partials.header')

            <!-- Body: Body -->
            <div class="body d-flex py-3"> 
                <div class="container-xxl">

                    @yield('content')

                </div>
            </div>
        
            <!-- Modal Custom Settings-->
            @include('admin.partials.footer')      
            
        </div>     
    
    </div>

    <!-- Jquery Core Js -->
    <script src="{{ asset('admin/assets/bundles/libscripts.bundle.js') }}"></script>

    <!-- Plugin Js -->
    <script src="{{ asset('admin/assets/bundles/dataTables.bundle.js') }}"></script>
    <script src="{{ asset('admin/assets/bundles/apexcharts.bundle.js') }}"></script>
    <script src="{{ asset('admin/assets/js/toastr.min.js') }}"></script>

    <!-- Jquery Page Js -->
    <script src="{{ asset('admin/assets/js/template.js') }}"></script>
    <script src="{{ asset('admin/assets/js/page/index.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            @if(Session::has('success'))
                toastr.success("{{ Session::get('success') }}");
            @endif

            @if(Session::has('error'))
                toastr.error("{{ Session::get('error') }}");
            @endif

            @if(Session::has('info'))
                toastr.info("{{ Session::get('info') }}");
            @endif

            @if(Session::has('warning'))
                toastr.warning("{{ Session::get('warning') }}");
            @endif
        });
    </script>

</body>

</html> 