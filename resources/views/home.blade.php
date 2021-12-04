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
         <link rel="stylesheet" href="{{ URL::asset('css/home.css'); }}">
     
         <!--Fonts-->
         <link rel="preconnect" href="https://fonts.googleapis.com">
         <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
         <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
     
         <!--JavaScript-->
         <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
         <script src="https://kit.fontawesome.com/f9d308f07e.js" crossorigin="anonymous"></script>
    </head>
    <body class="home">
        <div class="home__container">
            <div class="left__box">
                <h1>Create Post</h1>
                <div class="line__small mt-4"></div>
                <div class="form__container mt-4">
                    <form id="postForm">
                        @csrf
                        <div class="form-floating mb-4">
                            <input type="text" class="form-control" id="floatingTitle" placeholder="Title" name="title" required>
                            <label for="floatingTitle">Title</label>
                        </div>
                        <div class="form-floating" style="height: 100%">
                            <textarea name="content" id="floatingContent" style="height: 100% !important;" class="form-control" placeholder="Post's content" required></textarea>
                            <label for="floatingContent">Content</label>
                        </div>
                        <button class="postBtn mt-4">Post</button>
                    </form>
                </div>
            </div>
            <div class="line__big"></div>
            <div class="right__box">
                <div class="post__search">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Search posts via title" aria-label="Search posts" aria-describedby="button-search" id="searchBar">
                        <button class="btn btn-outline-secondary ms-2" type="button" id="button-search"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                <div class="post__container">
                    <ul class="post__list">
                    </ul>
                </div>
            </div>
        </div>
        <button class="logoutBtn">Logout</button>
        <script>
            $(function() {
                $(function () {
                    $.ajaxSetup({
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('X-CSRF-TOKEN', "{{csrf_token()}}");
                        }
                    });
                    $.ajax({
                        url: "/post",
                        type: "GET",
                        success: function (response) {
                            if (response) {
                                $.each(response, function (key, value) {
                                    const title = value.title;
                                    const content = value.content;
                                    const id = value.id;

                                    $(".post__list").append(
                                        `
                                        <li class="post__item mb-4">
                                            <div class="post__content">
                                                <div class="post__header">
                                                    <h4>${title}</h4>
                                                    <div class="post__action">
                                                        <i class="fas fa-paper-plane me-2"></i>
                                                        <i class="fas fa-pen me-2"></i>
                                                        <i class="fas fa-trash-alt"></i>
                                                        <input type="hidden" value="${id}" name="id" class="postID">
                                                    </div>
                                                </div>
                                                <p class="mt-2">${content}</p>
                                            </div>
                                        </li>
                                        `
                                    )
                                });
                            }
                        }
                    });

                    $(".logoutBtn").on("click", function () {
                        $.ajax({
                            url: "/logout",
                            type: "GET",
                        }).done(function (data) {
                            location.href = "/";
                        });
                    });
                    $(".postBtn").on("click", function (event) {
                        event.preventDefault();
                        var postData = {
                            "title": $("#floatingTitle").val(),
                            "content": $("#floatingContent").val(),
                            // "_token": "{{ csrf_token() }}"
                        };
                        $.ajax({
                            url: "/post",
                            data: JSON.stringify(postData),
                            dataType: "json",
                            contentType: "application/json",
                            type: "POST",
                            cache: false,
                            processData: false,
                            success: function (response) {
                                location.reload();
                            },
                            error: function(xhr, ajaxOptions, throwError) {
                                alert(throwError);
                            }
                        });
                    });
                    $(document).on("click", ".fa-pen", function () {
                        var title = $(this).closest(".post__header").find("h4");
                        var content = $(this).closest(".post__content").find("p");
                        var updateBtn = $(this).closest(".post__action").find(".fa-paper-plane");
                        
                        if (typeof title.attr("contenteditable") == "undefined" || title.attr("contenteditable") == "false") {
                            title.css("border-bottom", "2px solid #5E81AC");
                            content.css("border-bottom", "2px solid #5E81AC");
                            title.attr("contenteditable", "true");
                            content.attr("contenteditable", "true");
                            updateBtn.css("display", "inline-block");

                        } else {
                            title.css("border-bottom", "none");
                            content.css("border-bottom", "none");
                            title.attr("contenteditable", "false");
                            content.attr("contenteditable", "false");
                            updateBtn.css("display", "none");
                        }
                    });
                    $(document).on("click", ".fa-trash-alt", function () {
                        const id = $(this).closest(".post__action").find(".postID").val();
                        $.ajax({
                            url: `/post/${id}`,
                            type: "DELETE",
                            success: function (response) {
                                location.reload();
                            },
                            error: function(xhr, ajaxOptions, throwError) {
                                alert(throwError);
                            }
                        });
                    });
                    $(document).on("click", ".fa-paper-plane", function () {
                        const id = $(this).closest(".post__action").find(".postID").val();
                        const title = $(this).closest(".post__header").find("h4").prop("innerText");
                        const content = $(this).closest(".post__content").find("p").prop("innerText");
                        
                        const postData = {
                            "title": title,
                            "content": content
                        };

                        $.ajax({
                            url: `/post/${id}`,
                            type: "PUT",
                            data: JSON.stringify(postData),
                            dataType: "json",
                            contentType: "application/json",
                            processData: false,
                            success: function (response) {
                                location.reload();
                            },
                            error: function(xhr, ajaxOptions, throwError) {
                                alert(throwError);
                            }
                        })
                    });
                    $(document).on("click", "#button-search", function () {
                        var searchText = $("#searchBar").val().toLowerCase();
                        $(".post__list li").each(function () {
                            if ($(this).find(".post__header h4").html().toLowerCase().search(searchText) > -1) {
                                $(this).show();
                            } else {
                                $(this).hide();
                            }
                        })
                    });
                });
            });
        </script>
    </body>
</html>