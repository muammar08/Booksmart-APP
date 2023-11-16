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

    <!-- JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Font Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <script src="sweetalert2.min.js"></script>
    <link rel="stylesheet" href="sweetalert2.min.css">

</head>
<body class="bg-img">

    @include('layout.navbar1')

    <div class="flex container justify-content-center text-center margin">
        <div class="row">
            <div class="col-7">
                <input id="search" name="search" class="form-control  fontAwesome rounded-4 p-2 mb-3" type="text" placeholder="&#xf002; Search">
            </div>
            <div class="col">

            </div>
        </div>
        <div class="row justify-content-md-start pt-3">
            <div class="col col-lg-2 text-start">
                <a href="/createlist"><button class="btn text-white p-2 font1 pe-4 ps-4 shadow fw-bold fs-5" style="background-color:#8752F9;">
                    <i class="fa-solid fa-square-plus"></i>&nbsp; Create
                </button></a>
            </div>
            <div class=" col col-lg-2 text-start">
                <select class="border-clr rounded-3 p-2 font-clr font1 shadow fw-bold fs-5 mb-5" name="filter" id="filter">
                    <option disabled selected class="font1 font-clr">Platform</option>
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
        </div>
        <div class="table table-responsive">
            <table class="rounded rounded-4 overflow-hidden table align-middle shadow font1 table-striped table-hover">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Link</th>
                        <th>Platform</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="dataall">
                </tbody>
                <tbody id="searching" class="searchingdata"></tbody>
            </table>
        </div>
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
    .then(response => {
        if (response.status === 401) {
            // Token has expired, redirect to login page
            localStorage.removeItem("bearer_token");
            window.location.href = "/login";
        }
        return response.json();
    })
    .then(data => {
        console.log(data);
        document.querySelector("#user").value = data.data.id;
    })
    .catch(error => {
        console.log(error);
    });

    // Fetch bookmarks data
    fetch('http://localhost:8000/api/bookmarks', {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (response.status === 401) {
            // Token has expired, redirect to login page
            localStorage.removeItem("bearer_token");
            window.location.href = "/login";
        }
        return response.json();
    })
    .then(data => {
        console.log(data);
        const bookmarks = data.data;

        let bookmarksHTML = '';

        bookmarks.forEach(bookmark => {
            const date = new Date(bookmark.created_at);
            const formattedDate = `${date.getDate()}-${date.getMonth() + 1}-${date.getFullYear()}`;

            bookmarksHTML += `
                <tr>
                    <td scope="row">${bookmark.title}</td>
                    <td class="ellipsis" onclick="toggleText(this)">
                        <a href="${bookmark.url}" target="_blank">${bookmark.url}</a>
                    </td>
                    <td>${bookmark.platform}</td>
                    <td>${formattedDate}</td>
                    <td>
                        <a href="editlist/${bookmark.id}" type="button" dusk="edit-button" name="edit" class="text-success" style="text-decoration:none;">
                            <i class="fa-solid fa-pen">&ensp;</i>
                        </a>
                        <a class="text-danger delete-btn" data-id="${bookmark.id}" style="text-decoration:none;">
                            <i class="fa-solid fa-trash">&ensp;</i>
                        </a>
                    </td>
                </tr>
            `;
        });

        document.querySelector("tbody").innerHTML = bookmarksHTML;

        // Search bookmark
        document.querySelector("#search").addEventListener("keyup", function(event) {
            event.preventDefault();

            const search = event.target.value.toLowerCase().trim();
            const filteredBookmarks = bookmarks.filter(bookmark => {
                const dates = new Date(bookmark.created_at);
                const formattedDates = `${dates.getDate()}-${dates.getMonth() + 1}-${dates.getFullYear()}`;

                return bookmark.title.toLowerCase().includes(search) ||
                       bookmark.url.toLowerCase().includes(search) ||
                       bookmark.platform.toLowerCase().includes(search) ||
                       formattedDates.toLowerCase().includes(search);
            });

            let filteredBookmarksHTML = '';

            filteredBookmarks.forEach(bookmark => {
                const date = new Date(bookmark.created_at);
                const formattedDate = `${date.getDate()}-${date.getMonth() + 1}-${date.getFullYear()}`;

                filteredBookmarksHTML += `
                    <tr>
                        <td scope="row">${bookmark.title}</td>
                        <td class="ellipsis" onclick="toggleText(this)">
                            <a href="${bookmark.url}" target="_blank">${bookmark.url}</a>
                        </td>
                        <td>${bookmark.platform}</td>
                        <td>${formattedDate}</td>
                        <td>
                            <a href="editlist/${bookmark.id}" class="text-success" style="text-decoration:none;">
                                <i class="fa-solid fa-pen">&ensp;</i>
                            </a>
                            <a class="text-danger delete-btn" dusk="dlt-button" data-id="${bookmark.id}" style="text-decoration:none;">
                                <i class="fa-solid fa-trash">&ensp;</i>
                            </a>
                        </td>
                    </tr>
                `;
            });

            document.querySelector(".dataall").innerHTML = filteredBookmarksHTML;
        });

        //Filter By Platform
        document.querySelector("#filter").addEventListener("change", function(event) {
            event.preventDefault();

            const selectedPlatform = event.target.value.toLowerCase().trim();
            let filteredBookmarks = [];

            if (selectedPlatform === "all") {
                // Tampilkan semua bookmark jika "All" dipilih
                filteredBookmarks = bookmarks;
            } else {
                // Filter bookmark berdasarkan platform yang dipilih
                filteredBookmarks = bookmarks.filter(bookmark => {
                    console.log(bookmarks);
                    return bookmark.platform.toLowerCase().includes(selectedPlatform);
                });
            }

            let filteredBookmarksHTML = '';

            filteredBookmarks.forEach(bookmark => {
                const date = new Date(bookmark.created_at);
                const formattedDate = `${date.getDate()}-${date.getMonth() + 1}-${date.getFullYear()}`;

                filteredBookmarksHTML += `
                    <tr>
                        <td scope="row">${bookmark.title}</td>
                        <td class="ellipsis" onclick="toggleText(this)">
                            <a href="${bookmark.url}" target="_blank">${bookmark.url}</a>
                        </td>
                        <td>${bookmark.platform}</td>
                        <td>${formattedDate}</td>
                        <td>
                            <a href="editlist/${bookmark.id}" class="text-success" style="text-decoration:none;">
                                <i class="fa-solid fa-pen">&ensp;</i>
                            </a>
                            <a class="text-danger delete-btn" dusk="dlt-button" data-id="${bookmark.id}" style="text-decoration:none;">
                                <i class="fa-solid fa-trash">&ensp;</i>
                            </a>
                        </td>
                    </tr>
                `;
            });
            document.querySelector(".dataall").innerHTML = filteredBookmarksHTML;
        });

        // Delete bookmark
        document.querySelector(".dataall").addEventListener("click", function(event) {
            if (event.target.classList.contains("fa-trash")) {
                event.stopPropagation(); // Prevent default link behavior

                const bookmarkId = event.target.parentElement.getAttribute("data-id");

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send delete request to the server
                        fetch(`http://localhost:8000/api/delete/${bookmarkId}`, {
                            method: 'DELETE',
                            headers: {
                                'Authorization': `Bearer ${token}`,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'Bookmark has been deleted.',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 1500,
                            });
                            // You might want to refresh the page or update the list
                            const deletedRow = event.target.parentElement.closest("tr");
                            deletedRow.remove();
                        })
                        .catch(error => {
                            console.log(error);
                        });
                    }
                });
            }
        });
    })

</script>


<script>
    function toggleText(element) {
        element.classList.toggle('expanded');
    }
</script>

</body>
</html>