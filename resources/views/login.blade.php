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
    <div class="login__container">
        <h1>Login</h1>
        <div class="line__small"></div>
        <div class="login__form__container mt-4">
            <form id="loginForm">
                @csrf
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="floatingEmail" placeholder="name@example.com" name="email">
                    <label for="floatingEmail">Email address</label>
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
                    <label for="floatingPassword">Password</label>
                </div>
            </form>
        </div>
        <div class="line__small mt-4"></div>
        <div class="alert mt-4" role="alert"></div>
        <a href="/auth/register" class="mt-3">Register an account</a>
        <button type="submit" class="loginBtn mt-3">Login</button>
    </div>
    <script>
        $(function() {
            $.ajaxSetup({
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', "{{csrf_token()}}");
                }
            });
            $(".loginBtn").on("click", function () {
                var loginData = {
                    "email": $("#floatingEmail").val(),
                    "password": $("#floatingPassword").val(),
                };
                $.ajax({
                    url: "/auth/login",
                    data: JSON.stringify(loginData),
                    dataType: "json",
                    contentType: "application/json; charset=utf-8",
                    type: "POST",
                    cache: false,
                    processData: false,
                    statusCode: {
                        401: function (response) {
                            $(".alert").removeClass("alert-show");
                            var res = response.responseJSON;
                            $(".alert").addClass("alert-show");
                            $(".form-control").addClass("is-invalid");
                            $(".alert").html(res.error);
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