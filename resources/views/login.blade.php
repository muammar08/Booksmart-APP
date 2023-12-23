<!doctype html>
<html lang="en">
<head>
    <script>
        if(localStorage.getItem("bearer_token") != null){
        window.location.href = "/dashboard";
    }
    </script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BookSmart</title>
    <link rel="icon" href="{{ url('img/favicon.ico') }}">
    <link href="css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,900;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <!-- Font Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

</head>
<body class="bg-img">

    <nav class="navbar navbar-expand-lg sticky-top  font1 " style="background-color: #C0A3FD;">
        <div class="container" >
            <a class="navbar-brand text-light fs-2 fw-bolder" href="/">BookSmart</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link text-dark" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                <a class="nav-link text-dark" href="/stat">Statistic</a>
                </li>
            </ul>
            </div>
        </div>
    </nav>

    <div class="d-flex justify-content-center text-center margin rounded-5 container">
        <form id="loginForm" class="bg-white rounded-5 shadow-lg ps-5 pe-5 pt-4 pb-4 " action="http://localhost:8000/api/login" method="post">
            @csrf
            <div class="container form-group">
                <h6 class="font-clr" style="font-weight:bold; font-size:30px;">Welcome Back</h6>
                <p class="text-dark ">please input your data to gain access</p>
                @if(request('success_message'))
                    <div class="alert alert-success p-2 ">
                        {{ request('success_message') }}
                    </div>
                @endif
                <div id="errorMessages" class="alert alert-danger p-2" style="display: none;"></div>
                <div class="form-group pt-3">
                    <!-- <span class="icon"><i class="fa-regular fa-envelope"></i></span> -->
                    <input class="form-control rounded-3 fontAwesome" type="email" name="email" id="email"  placeholder="&#xf0e0; &nbsp; input your email addres">
                </div>
                <div class="form-group pt-3 ">
                    <input class="form-control rounded-3 fontAwesome" type="password" name="password" id="password" placeholder="&#xf023; &nbsp; input your password">
                </div>
                <button type="submit" id="confirm" name="confirm" class="btn container mt-4 mb-3 text-white fw-bold" style="background-color:#8752F9;">
                    Confirm
                </button>
                <p class="mb-0 pb-0" style="font-size:12px;">Not registered? <a class="font-clr fw-bold" style="text-decoration:none" href="/signup">Create an account </a><br>---or---</p>
                <a href="/auth/google/" id='googleLogin' class="mt-0 pt-0" style="text-decoration:none;"> 
                    <button class="btn text-dark fontAwesome" style="border:none;">
                        Login With Google <i class="fa-brands fa-google"></i>
                    </button>
                </a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/c2f1264f7f.js" crossorigin="anonymous"></script>

<script>
    document.getElementById('loginForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const form = event.target;
        const formData = new FormData(form);

        fetch('/api/login', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Jika login berhasil, arahkan pengguna ke halaman dashboard
                const token = data.token;
                localStorage.setItem('bearer_token', token);
                window.location.href = '/dashboard'; // Arahkan ke halaman dashboard
            } else {
                // Jika login gagal, tampilkan pesan kesalahan di halaman login jika ada
                Swal.fire({
                    icon: "error",
                    title: "Email or Password Incorrect",
                    text: "Something went wrong!",
                });
            }
        })
        .catch(error => {
            console.error('An error occurred:', error);
        });
    });

    document.getElementById('googleLogin').addEventListener('click', function(event) {
        event.preventDefault();

        try {
            // Redirect to the Google authentication page
            window.location.href = '/auth/google/';

        } catch (error) {
            console.error('An error occurred:', error);
        }
    });

</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</body>
</html>