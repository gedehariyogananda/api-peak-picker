<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Admin System | 3Funding</title>
    <link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/auth.css') }}" />
    <link
        rel=""
        href="assets/images/logos.png"
        type="image/png"
    />
</head>

<body>
<div id="auth">
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="auth-logo">
                    <a href="{{ route('login') }}"
                    ><img src="assets/images/logos.png" alt="Logo"
                        /></a>
                </div>
                <h1 class="auth-title">Log in.</h1>
                <p class="auth-subtitle mb-5">
                    Log in with your admin account to entry the admin panel.
                </p>
                @if (Session::has('error'))
                    <div class="alert alert-danger">
                        <strong>{{ Session::get('error') }}</strong>
                    </div>
                @endif
                <form action="{{ route('loginPost') }}" method="POST">
                    @csrf
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input
                            type="email"
                            class="form-control form-control-xl"
                            placeholder="Email"
                            name="email_user"
                        />
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input
                            type="password"
                            class="form-control form-control-xl"
                            placeholder="Password"
                            name="password_user"
                        />
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5" type="submit">
                        Log in
                    </button>
                </form>
            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right"></div>
        </div>
    </div>
</div>
</body>
</html>
