<nav class="navbar navbar-expand-lg sticky-top  font1 " style="background-color: #C0A3FD;">
    <div class="container" >
        <a class="navbar-brand text-light fs-2 fw-bolder" href="/dashboard">BookSmart</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
            <a class="nav-link text-dark" aria-current="page" href="/dashboard">Home</a>
            </li>
            <li class="nav-item">
            <a type="button" id="btnLogout" class="nav-link text-white" href="">Log out</a>
            </li>
        </ul>
        </div>
    </div>
</nav>
    <script>
    document.querySelector("#btnLogout").addEventListener('click', function(event) {
        event.preventDefault(); // Menghentikan perilaku default dari elemen <a>

        Swal.fire({
            title: 'Are you sure?',
            text: "do you want to log out?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Logged out',
                    'Your account has been logged out',
                    'success'
                );
                
                // Lakukan aksi log out di sini
                localStorage.removeItem('bearer_token');

                // Jika ingin mengarahkan pengguna ke halaman log out
                window.location.href = "/login";
            }
        });
    });
</script>

