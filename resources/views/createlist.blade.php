<!doctype html>
<html lang="en">
<head>
    <script>
        if(localStorage.getItem("bearer_token") == null){
        window.location.href = "/login";
    }
    </script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,900;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <!-- Font Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

</head>
<body class="bg-img">

    @include('layout.navbar1')

    <div class="d-flex justify-content-center text-center margin rounded-5 container">
        <form class=" bg-white rounded-5 shadow-lg ps-5 pe-5 pt-3 pb-3 " action="http://localhost:8000/api/create" method="post">
            <div class="container form-group">
                <h6 class="font-clr" style="font-weight:bold; font-size:30px;">Create List</h6>
                <div class="form-group pt-3">
                    <input class=" form-control rounded-3 pe-5 ps-5" type="text" name="title" placeholder="Subject" required>
                </div>
                <div class="form-group pt-3">
                <input class="form-control rounded-3 pe-5 ps-5" type="url" name="url" placeholder="Link" required required pattern="https?://.*"> 
                </div>
                <div class="form-group pt-3 ">
                    <select class="form-select form-control rounded-3 pe-5 ps-5" style="opacity:0.5;" name="platform" id="">
                        <option disabled selected>Platform</option>
                        <option class="font-clr" value="instagram">Instagram</option>
                        <option class="font-clr" value="tiktok">TikTok</option>
                        <option class="font-clr" value="twitter">Twitter</option>
                        <option class="font-clr" value="facebook">Facebook</option>
                        <option class="font-clr" value="youtube">Youtube</option>
                        <option class="font-clr" value="telegram">Telegram</option>
                        <option class="font-clr" value="discord">Discord</option>
                        <option class="font-clr" value="lainnya">Lainnya</option>
                    </select>
                </div>
                <input type="text" name="user_id" id="user" value="" hidden>
                <button type="submit"  class="btn container mt-4 mb-3 text-white fw-bold first" style="background-color:#8752F9;">
                    Confirm
                </button>
            </div>
        </form>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/c2f1264f7f.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const token = localStorage.getItem("bearer_token");

    // Fetch user data
    fetch('http://localhost:8000/api/get_user', {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        document.querySelector("#user").value = data.data.id;
    })
    .catch(error => {
        console.log(error);
    });

    // Event listener for form submission
    document.querySelector("form").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent default form submission

        fetch('http://localhost:8000/api/create', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                // Provide the data you want to send
                title: document.querySelector('[name="title"]').value,
                url: document.querySelector('[name="url"]').value,
                platform: document.querySelector('[name="platform"]').value,
                user_id: document.querySelector('[name="user_id"]').value
            })
        })
        .then(response => response.json())
        .then(data => {
            // Show success message using Swal or other method
            Swal.fire({
                icon: 'success',
                title: 'Your link has been saved',
                showConfirmButton: false,
                timer: 1500
            });
            window.location.href = "/dashboard";
        })
        .catch(error => {
            // Show error message using Swal or other method
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
            });
        });
    });


    var base64Url = token.split('.')[1];
    var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
        }).join(''));

        var exp = JSON.parse(jsonPayload);
        var date = new Date(0);
        date.setUTCSeconds(exp.exp);

        var now = new Date();
        if(date < now){
            window.location.href = "/login";
        }
</script>
</body>
</html>