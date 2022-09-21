<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"><!-- Css Files-->
        <link  href="{{ asset ('css/login.css') }}" rel="stylesheet">
        <title>Sign Up</title>
    </head>

    <body>
        <div class="app-container">
            <div class="login-form-container">
                <form id="signup-form" action="/signup" method="post"><input type="hidden" name="_csrf">
                    <h2>Sign Up</h2>
                    <h4>Dashboard</h4>
                    <div class="input-container"><label for="">Username</label><Label class="second-label">Minimum 5 characters and maximum 8</Label><input class="input username-input" type="text" name="username" required oninvalid="this.setCustomValidity('Enter a valid username')" oninput="this.setCustomValidity('')" minlength="5" maxlength="8" autocomplete="off"><!-- Error Labels--><label class="error-label username-required">required</label></div>
                    <div class="input-container"><label for="">Email </label><input class="input email-input" type="email" name="email" required oninvalid="this.setCustomValidity('Enter a valid email')" oninput="this.setCustomValidity('')" autocomplete="off"><!-- Error Labels--><label class="error-label email-required">required</label></div>
                    <div class="input-container"><label for="">Password</label><label class="second-label">Minimum 6 characters</label><input class="input password-input" type="password" name="password" required oninvalid="this.setCustomValidity('Enter a valid password')" oninput="this.setCustomValidity('')" autocomplete="new-password" minlength="6"><!-- Error Label--><label class="error-label password-required">required</label></div>
                    <div class="error-container error-signup"><span class="error-text"></span></div>
                    <div class="input-container"><input class="input input-submit" type="submit" value="Sign Up"></div>
                    <div class="other-options-container">
                    <div class="signup-redirect"><span>Alredy a member?</span><a href="{{ route('login.index') }}">Sign In</a></div>
                </form>
            </div>
        </div>
    </body>
</html>