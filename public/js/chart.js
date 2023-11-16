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