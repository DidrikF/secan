<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
        </script>

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="css/app.css">
        
    </head>

    <body>

        <button id="show-login-button" class="button button--primary">Login</button>
        <button id="show-register-button" class="button button--primary">Register</button>
        <div id="go-to-secan-placeholder"></div>
        

        <div id="login-form" class="modal --hide">
            <div class="modal__content">
                <button id="hide-login-button" class="button button--danger">X</button>
                <form class="form" onsubmit="event.preventDefault()"">
                    <div class="form__group">
                        <input id="login-email" class="form__input" name="email" type="email" value="didrik@test.com" placeholder="Email" required autofocus>
                        <div>
                            <span id="login-email-error" class="form__error"></span>
                        </div>
                    </div>
                    <div class="form__group">
                        <input id="login-password" class="form__input" name="password" type="password" value="password123" placeholder="Password" required>
                        <div>
                            <span id="login-password-error" class="form__error"></span>
                        </div>
                    </div>
                    <div>
                        <span id="login-root-error" class="form__error"></span>
                    </div>
                    <button id="submit-login-button" class="button button--primary" type="submit">Log in</button>

                </form>
            </div>
        </div>

        <div id="register-form" class="modal --hide">
            <div class="modal__content">
                <button id="hide-register-button" class="button button--danger">X</button>
                <form class="form" onsubmit="event.preventDefault()"">
                    <div class="form__group">
                        <input id="register-name" class="form__input" name="name" type="text" placeholder="Name" required autofocus>
                        <span id="register-name-error" class="form__error"></span>
                    </div>
                    <div class="form__group">
                        <input id="register-email" class="form__input" name="register-email" type="email" placeholder="Email" required>
                        <span id="register-email-error" class="form__error"></span>
                    </div>
                    <div class="form__group">
                        <input id="register-username" class="form__input" name="username" type="text" placeholder="Username" required>
                        <span id="register-username-error" class="form__error"></span>
                    </div>
                    <div class="form__group">
                        <input id="register-password" class="form__input" name="register-password" type="password" placeholder="Password" required>
                        <span id="register-password-error" class="form__error"></span>
                    </div>

                    <button id="submit-register-button" class="button button--primary" type="submit">Log in</button>

                </form>
            </div>
        </div>
        


        <h1>Welcome to the Security Analysis Web Application</h1>

        <p>
            Highlight the site and its features...
        </p>



        
        <script src="js/frontPageApp.js"></script>
    </body>
</html>
