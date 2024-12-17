document.addEventListener('DOMContentLoaded', () => {
    // Sidebar Toggle Functionality
    const sidebar = document.querySelector('.sidebar');
    const content = document.querySelector('.content');
    const sidebarToggle = document.createElement('button');

    // Create sidebar toggle button
    sidebarToggle.classList.add('sidebar-toggle');
    sidebarToggle.innerHTML = '<span>☰</span>';
    document.body.appendChild(sidebarToggle);

    // Toggle sidebar functionality
    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        content.classList.toggle('sidebar-collapsed');

        // Update toggle button text based on sidebar state
        sidebarToggle.querySelector('span').textContent = 
            sidebar.classList.contains('collapsed') ? '☰' : '✕';
    });

    // Set current date in the welcome message
    const currentDateElement = document.getElementById('current-date');
    if (currentDateElement) {
        currentDateElement.textContent = new Date().toLocaleDateString();
    }

    // Mood Chart Initialization
    const moodCanvas = document.getElementById('moodCanvas');
    if (moodCanvas) {
        const ctx = moodCanvas.getContext('2d');
        
        // Ensure Chart.js is loaded
        if (typeof Chart !== 'undefined') {
            // Prepare mood data
            const moodData = {
                labels: chartLabels || [], // Use a default empty array if chartLabels is not defined
                datasets: [{
                    label: 'Mood Trend',
                    data: chartData || [], // Use a default empty array if chartData is not defined
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            };

            // Chart configuration
            const chartConfig = {
                type: 'line',
                data: moodData,
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    const moods = ['', 'Sad', 'Neutral', 'Happy'];
                                    return moods[value] || '';
                                }
                            },
                            min: 0,
                            max: 3
                        }
                    }
                }
            };

            // Create the chart
            new Chart(ctx, chartConfig);
        } else {
            console.error('Chart.js is not loaded');
        }
    }
});
