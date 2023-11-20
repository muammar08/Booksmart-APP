<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booksmart</title>
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
        <form id="registerForm" class="bg-white rounded-5 shadow-lg ps-5 pe-5 pt-4 pb-4 " action="http://localhost:8000/api/register" method="post">
            @csrf
            <div class="container form-group">
                <h6 class="font-clr" style="font-weight:bold; font-size:30px;">Sign Up</h6>
                <p class="text-dark ">please input your data to make an account</p>
                <div id="errorMessages" class="text-danger" style="display: none;"></div>
                <div class="form-group pt-3">
                    <input class="form-control rounded-3" type="email" name="email" value="{{ old('email') }}" placeholder="input your email addres" required>
                </div>
                <div class="form-group pt-3">
                    <input class="form-control rounded-3" type="text" name="name" placeholder="input your nickname" required>
                </div>
                <div class="form-group pt-3 ">
                    <input class="form-control rounded-3" type="password" name="password" placeholder="input your password" required>
                </div>
                <button type="submit" class="btn container mt-4 mb-3 text-white fw-bold" style="background-color:#8752F9;">
                    Confirm
                </button>
                <p class="" style="font-size:12px;">already have an account? <a class="font-clr fw-bold" style="text-decoration:none" href="/login">Sign In</a></p>
            </div>
        </form>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script>
    document.getElementById('registerForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Mencegah form dikirimkan secara normal

        const form = event.target;
        const formData = new FormData(form);

        fetch('/api/register', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (data.redirect){
                    window.location.href = '/login?success_message=' + encodeURIComponent(data.message); // Redirect ke halaman login jika berhasil
                } else {
                    const errorMessagesElement = document.getElementById('errorMessages');
                    errorMessagesElement.innerHTML = ''; // Bersihkan pesan kesalahan sebelumnya
                    for (const errorField in data.errors) {
                        const errors = data.errors[errorField];
                        const errorMessage = errors[0]; // Ambil pesan kesalahan pertama
                        const inputField = document.querySelector(`[name="${errorField}"]`);
                        inputField.classList.add('is-invalid'); // Tambahkan class is-invalid ke input field
                        errorMessagesElement.innerHTML += `<p>${errorMessage}</p>`;
                    }
                    errorMessagesElement.style.display = 'block'; // Tampilkan pesan kesalahan
                }
            } else if(data.errorCode && data.errorCode === 'email_taken') {
                Swal.fire({
                    icon: 'error',
                    title: 'Email Already Taken',
                    text: 'The provided email is already registered. Please use a different email address.',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Username or Password Min 6 and Max 20',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('An error occurred:', error);
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>