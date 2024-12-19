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

    
});
