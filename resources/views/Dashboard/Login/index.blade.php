<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"><!-- Css Files-->
        <link  href="{{ asset ('css/login.css') }}" rel="stylesheet">
        <link  href="{{ asset ('js/login.js') }}" rel="stylesheet">
        <title>Sign In</title>
    </head>

    <body>
        <div class="app-container">
            <div class="login-form-container">
                <form id="signin-form" method="POST">
                    @csrf
                    <h2>Sign In</h2>
                    <h4>Dashboard</h4><input type="hidden">
                    <div class="input-container"><label for="">Email</label><input class="input" type="text" name="email" autocomplete="off"></div>
                    @error('email')
                        <div class="alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="input-container"><label for="">Password </label><input class="input" type="password" name="password" autocomplete="off"></div>
                    @error('password')
                        <div class="alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="error-container"><span>Incorrect Email or Password</span></div>
                    <div class="success-container"><span>Welcome</span></div>
                    <div class="text-container"><a onclick="forgotForm()" id="forgot-password-btn">Forgot Password?</a></div>
                    <div class="input-container" style="margin: 0px"><input class="input" type="submit" value="Sign In"></div>
                </form>
            </div>
            <div class="forgot-password-container">
                <form id="forgot-password-form">
                    <div class="form-header">
                        <h2>Password Recovery</h2><svg class="close-icon" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 512 512" onclick="forgotForm()">
                            <title>Close</title>
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="40" d="M368 368L144 144M368 144L144 368"></path>
                        </svg>
                    </div><input type="hidden" name="_csrf">
                    <div class="input-container"><label for="">Email</label><input class="input" type="text" name="email" autocomplete="off"></div>
                    <div class="forgot-password-error-container"><span>Incorrect Email</span></div>
                    <div class="forgot-password-success-container"><span>Mail Sent</span></div>
                    <div class="input-container"><input class="input" type="submit" value="Submit"></div>
                </form>
            </div>
        </div>
    </body>
</html>