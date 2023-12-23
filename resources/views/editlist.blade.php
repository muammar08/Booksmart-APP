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
    <title>BookSmart</title>
    <link rel="icon" href="{{ url('img/favicon.ico') }}">
    <link href="/css/style.css" rel="stylesheet">
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
        <form id="editForm" class=" bg-white rounded-5 shadow-lg ps-5 pe-5 pt-3 pb-3 ">
            <div class="container form-group">
                <h6 class="font-clr" style="font-weight:bold; font-size:30px;">Edit List</h6>
                <input type="text" name="id" id="id" value="" hidden>
                <div class="form-group pt-3">
                    <input class=" form-control rounded-3 pe-5 ps-5" type="text" name="title" id="title" placeholder="Subject" required>
                </div>
                <div class="form-group pt-3">
                    <input class="form-control rounded-3 pe-5 ps-5" type="text" name="url" id="url" placeholder="Link" required required pattern="https?://.*"> 
                </div>
                <div class="form-group pt-3 ">
                    <select class="form-select form-control rounded-3 pe-5 ps-5" style="opacity:0.5;" name="platform" id="platform">
                        <option disabled selected>Platform</option>
                        <option class="font-clr" value="Instagram">Instagram</option>
                        <option class="font-clr" value="Tiktok">TikTok</option>
                        <option class="font-clr" value="Twitter">Twitter</option>
                        <option class="font-clr" value="Facebook">Facebook</option>
                        <option class="font-clr" value="Youtube">Youtube</option>
                        <option class="font-clr" value="Telegram">Telegram</option>
                        <option class="font-clr" value="Discord">Discord</option>
                        <option class="font-clr" value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <input type="text" name="user_id" id="user" value="" hidden>
                <button type="submit" id="confirmBtn"  class="btn container mt-4 mb-3 text-white fw-bold first" style="background-color:#8752F9;">
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
    
    fetch('/api/get_user', {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        document.querySelector("#user").value = data.data.id;
    })
    .catch(error => {
        console.log(error);
    });

    document.addEventListener("DOMContentLoaded", function() {
        
        fetch('/api/bookmarks/' + window.location.pathname.split("/").pop(), {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            document.querySelector("#id").value = data.id;
            document.querySelector("input[name='title']").value = data.title;
            document.querySelector("input[name='url']").value = data.url;
            document.querySelector("select[name='platform']").value = data.platform;
        })
        .catch(error => {
            console.log(error);
        });
    });

    const editForm = document.getElementById("editForm");

    editForm.addEventListener("submit", function(event){
        event.preventDefault();

        const formData = new URLSearchParams(new FormData(editForm));
        const bookmarkId = window.location.pathname.split("/").pop();

        fetch(`/api/update/${bookmarkId}`, {
            method : "PUT",
            headers : {
                "Authorization" : `Bearer ${token}`,
                'Content-Type': "application/x-www-form-urlencoded"
            },
            body: formData.toString(),
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            Swal.fire({
                icon: 'success',
                title: 'Your work has been saved',
                showConfirmButton: false,
                timer: 1800
            });
            window.location.href = "/dashboard";
        })
        .catch(error => {
            console.log(error);
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