<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
    
        <!--Styles-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="{{ URL::asset('css/login.css'); }}">
    
        <!--Fonts-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    
        <!--JavaScript-->
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
    </head>
    <body class="login">
        <div class="login__container register">
            <h1>Register</h1>
            <div class="line__small"></div>
            <div class="login__form__container mt-4">
                <form id="loginForm">
                    @csrf
                    <div class="row g-2">
                        <div class="col-md me-3">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingName" placeholder="Your name" name="name" required>
                                <label for="floatingName">Name</label>
                                <div class="alert alertName mt-3"></div>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="floatingEmail" placeholder="name@example.com" name="email" required>
                                <label for="floatingEmail">Email address</label>
                                <div class="alert alertEmail mt-3"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md me-3">
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password" required>
                                <label for="floatingPassword">Password</label>
                                <div class="alert alertPassword mt-3"></div>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="floatingRePassword" placeholder="Password confirmation" name="password_confirmation" required>
                                <label for="floatingRePassword">Password confirmation</label>
                                <div class="alert alertRePassword mt-3"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="line__small mt-2"></div>
            <div class="alert mt-4" role="alert"></div>
            <a href="/auth/login" class="mt-3">Login here</a>
            <button type="submit" class="loginBtn mt-3">Register</button>
        </div>
        <script>
            $(function() {
                $(".loginBtn").on("click", function () {
                    var loginData = {
                        "name": $("#floatingName").val(),
                        "email": $("#floatingEmail").val(),
                        "password": $("#floatingPassword").val(),
                        "password_confirmation": $("#floatingRePassword").val(),
                        "_token": "{{ csrf_token() }}"
                    };
                    $.ajax({
                        url: "/auth/register",
                        data: JSON.stringify(loginData),
                        dataType: "json",
                        contentType: "application/json; charset=utf-8",
                        type: "POST",
                        cache: false,
                        processData: false,
                        statusCode: {
                            400: function (response) {
                                $(".alert").removeClass("alert-show");
                                var res = response.responseJSON.error;
                                if (res.name) {
                                    $(".alertName").addClass("alert-show");
                                    $(".alertName").html(res.name);
                                }
                                if (res.email) {
                                    $(".alertEmail").addClass("alert-show");
                                    $(".alertEmail").html(res.email);
                                }
                                if (res.password) {
                                    $(".alertPassword").addClass("alert-show");
                                    $(".alertPassword").html(res.password);
                                }
                                if (res.password_confirmation) {
                                    $(".alertRePassword").addClass("alert-show");
                                    $(".alertRePassword").html(res.password_confirmation);
                                }
                            },
                            200: function (data) {
                                location.href = "/";
                            }
                        },
                    });
                });
            });
        </script>  
    </body>
</html>