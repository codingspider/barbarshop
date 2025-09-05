<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>::Cryptoon:: Signin</title>
    <link rel="icon" href="{{ asset('admin/assets/favicon.ico') }}" type="image/x-icon"> <!-- Favicon-->

    <!-- project css file  -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/cryptoon.style.min.css') }}">
</head>

<body>
    <div id="cryptoon-layout" class="theme-orange">

        <!-- main body area -->
        <div class="container-fluid vh-100 d-flex align-items-center justify-content-center bg-light">
    <div class="row w-100">
        <!-- Login Form -->
        <div class="col-lg-6 d-flex align-items-center justify-content-center">
            <div class="card shadow-sm border-0 rounded-4 p-4" style="width: 100%; max-width: 450px;">
                <div class="card-body">
                    <h2 class="text-center mb-3">Welcome Back</h2>
                    <p class="text-center text-muted mb-4">Sign in to your admin account</p>

                    <form method="POST" action="{{ route('admin.login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input id="email" type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                name="password" required>
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Remember Me
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>

                        <div class="text-center">
                            <a href="{{ route('password.request') }}" class="text-decoration-none">Forgot password?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Image / Illustration -->
        <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center bg-primary rounded-end">
            <div class="text-center text-white px-4">
                <h2>Admin Panel</h2>
                <p class="lead">Manage your application efficiently and securely</p>
                <img src="{{ asset('admin/assets/images/qr-code.png') }}" alt="QR Code" class="img-fluid mt-3" style="max-width: 200px;">
            </div>
        </div>
    </div>
</div>

    </div>
</body>

</html>