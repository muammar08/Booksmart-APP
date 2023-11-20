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
    <title>Booksmart</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,900;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Font Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

</head>
<body class="bg-img">

    @include('layout.navbar')

    <section id="home">
        <div class="container flex justify-content-center margin font1" >
            <div class="row container">
                <div class="col ps-5">
                    <h6 class="container" style="font-weight:400; font-size:30px; color:#F381D3;">Hallo selamat datang di BookSmart</h6>
                    <h3 class="text-dark container" style="font-weight:900; font-size:40px;">Simpan dan temukan bookmark dengan mudah disini</h3>
                    <p class="text-dark container">daftar sekarang gratis</p>
                    <div class="container">
                        <a class="" style="text-decoration:none" href="/signup">
                            <button class="text-white btn rounded-3 pb-2 pt-2 pe-4 ps-4 shadow" style="background-color:#8752F9; font-weight:400; font-size:18px;">
                                Sign Up
                            </button>
                        </a>
                        <a  href="/login">
                            <button class="rounded-3 bg-white border-clr shadow font-clr pb-2 pt-2 pe-4 ps-4 ms-4">
                                Login
                            </button>
                        </a>
                    </div>
                </div>
                <div class="col text-center ps-5 pe-5">
                    <img class="image" src="img/roket.png" alt="" width="70%">
                </div>
            </div>
        </div>
    </section>

    <section id="about">
        <div class="container flex justify-content-center margin font1" >
            <div class="row ">
                <div class="col text-center">
                    <img class="" src="img/tab.png" alt="" width="">
                </div>
                <div class="col ps-3">
                    <h3 class="text-dark pb-5 text-start" style="font-weight:800; font-size:35px;">Simpan, Edit, Hapus Bookmark</h3>
                    <p class=" text-dark ">web ini menyediakan fitur untuk menyimpan link link bookmark dari berbagai sosial media. Anda juga dapat mengubah maupun menghapus link yang sudah anda simpan.</p>
                </div>
            </div>
            <div class="row container padding">
                <div class="col ">
                    <h3 class="text-dark pb-5 text-start" style="font-weight:800; font-size:35px;">Cari Bookmark</h3>
                    <p class=" text-dark ">web ini juga menyediakan fitur search untuk anda mencari bookmark yang telah anda simpan. anda juga dapat menggunakan fitur filtering untuk memudahkan anda mencari di antara list list bookmark anda.</p>
                </div>
                <div class="col text-center">
                    <img class="" src="img/buku.png" alt="" width="">
                </div>
            </div>
        </div>
    </section>

    <section id="footer" class="margin">
        <div class="pt-4" style="background: #E0D2FD;">
            <div class="container">
                <div class=" fs-1 fw-bolder font1" style="color: #8752F9;">BookSmart</div>
                <div style="color: #777777;">
                    <p class="mb-1"><i class="fa-regular fa-envelope"></i>&nbsp; hafizulakbar60@gmail.com</p>
                    <p class="mt-1 mb-2"><i class="fa-regular fa-envelope"></i>&nbsp; yasir.muammar08@gmail.com</p>
                    <p><i class="fa-solid fa-phone"></i>&nbsp; 082286130481</p>
                    <p>https://booksmart.my.id/</p>
                </div>
            </div>
            <div style="background: #C0A3FD;">
                <div class="d-flex justify-content-center p-2 text-light">
                    <p class="mt-4 text-dark"><i class="fa-regular fa-copyright">&nbsp;copyright. All right reserved.</i></p>
                </div>
            </div>
        </div>
    </section>  

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>
</html>