{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="light" data-bs-theme="light">
<head>
    <meta charset="utf-8" />
    <title>{{ $title ?? 'Login' }} | Strive - Admin & Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Strive Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Strive Team" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- App CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="container-xxl">
    <div class="row vh-100 d-flex justify-content-center">
        <div class="col-12 align-self-center">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4 mx-auto">
                        <div class="card">
                            <div class="card-body p-0 bg-black auth-header-box rounded-top">
                                <div class="text-center p-3">
                                    <a href="{{ url('/') }}" class="logo logo-admin">
                                        <img src="{{ asset('assets/logo.png') }}" height="50" alt="logo" class="auth-logo">
                                    </a>
                                    <h4 class="mt-3 mb-1 fw-semibold text-white fs-18">Let's Get Started</h4>
                                    <p class="text-muted fw-medium mb-0">Sign in to continue to Strive.</p>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <form method="POST" action="#" class="my-4">
                                    @csrf
                                    <div class="form-group mb-2">
                                        <label class="form-label" for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="{{ old('email') }}" required autofocus>
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label" for="password">Password</label>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" required>
                                        @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group row mt-3">
                                        <div class="col-sm-6">
                                            <div class="form-check form-switch form-switch-success">
                                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                                <label class="form-check-label" for="remember">Remember me</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 text-end">
                                            @if (Route::has('password.request'))
                                                <a href="{{ route('password.request') }}" class="text-muted font-13">
                                                    <i class="dripicons-lock"></i> Forgot password?
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group mb-0 row">
                                        <div class="col-12">
                                            <div class="d-grid mt-3">
                                                <button class="btn btn-primary" type="submit">Log In <i class="fas fa-sign-in-alt ms-1"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div> <!-- end card-body -->
                        </div> <!-- end card -->
                    </div> <!-- end col -->
                </div> <!-- end row -->
            </div> <!-- end card-body -->
        </div> <!-- end col -->
    </div> <!-- end row -->
</div> <!-- end container -->

<!-- JS scripts -->
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
</body>
</html>
