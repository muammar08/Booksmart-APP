<!doctype html>
<html lang="en">
<head>
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

    <div class="font1 text-center mt-4">
        <h1>How Many Bookmark Are There?</h1>
        <h4>Persentage of Platforms Saved</h4>
    </div>


    <div class="container text-center"> <!-- Center the chart horizontally -->
        <div class="justify-content-center"> <!-- Center the chart vertically -->
            <div class="chart-container"> <!-- Limit the chart width -->
                <canvas id="chart"></canvas>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    fetch('http://localhost:8000/api/countPlatform') // Corrected URL
    .then(response => response.json())
    .then(data => {
        const ctx = document.getElementById('chart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Facebook', 'Instagram', 'Twitter', 'Youtube', 'Tiktok', 'Telegram', 'Discord', 'Lainnya'],
                datasets: [{
                    label: 'Bookmark',
                    data: [data.facebook, data.instagram, data.twitter, data.youtube, data.tiktok, data.telegram, data.discord, data.lainnya],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)'
                    ],
                    borderRadius: 10,
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: (context) => {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = context.dataset.data.reduce((acc, curr) => acc + curr, 0);
                                const percentage = ((value / total) * 100).toFixed(2); // Calculate the percentage
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    },
                    legend: {
                        display: true, // Set to true to display the legend
                        position: 'bottom' // Customize the legend position
                    },
                }
            }
        });
    });
</script>

</body>
</html>