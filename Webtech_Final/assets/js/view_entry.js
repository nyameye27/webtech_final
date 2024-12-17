document.addEventListener('DOMContentLoaded', () => {
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
});