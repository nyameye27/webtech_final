

// Fetch data from the PHP file
fetch('../backend/analytics_reporting.php')
    .then(response => response.json())  // Parse JSON response
    .then(userGrowthData => {
        // Prepare the data for Chart.js
        const months = userGrowthData.map(item => item.month);
        const userCount = userGrowthData.map(item => item.user_count);

        // Create the user growth chart using Chart.js
        const ctxUserGrowth = document.getElementById('userGrowthChart').getContext('2d');
        const userGrowthChart = new Chart(ctxUserGrowth, {
            type: 'line',  // Type of chart (line chart in this case)
            data: {
                labels: months,  // X-axis labels (months)
                datasets: [{
                    label: 'User Growth',
                    data: userCount,  // Y-axis data (user counts)
                    borderColor: 'blue',
                    fill: false
                }]
            },
            options: {}  // Chart options
        });
    })
    .catch(error => console.error('Error fetching user growth data:', error));
