/* ============================================================
   KEDAI JUS - CUSTOM SCRIPTS
   ============================================================ */

// Document ready
document.addEventListener('DOMContentLoaded', function() {
    // Initialize functions
    initSidebar();
    initDataTables();
    initDeleteConfirm();
    initNotifications();
    initFormValidation();
    
    // Disable smooth scroll globally
    document.documentElement.style.scrollBehavior = 'auto';
    document.body.style.scrollBehavior = 'auto';
});

// ============================================================
// SIDEBAR TOGGLE
// ============================================================
function initSidebar() {
    const toggleBtn = document.getElementById('sidebar-toggle');
    const sidebar = document.querySelector('.sidebar');
    
    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            sidebar.classList.toggle('active');
        });
    }

    // Handle menu link clicks properly - NO SWIPE VERSION
    const menuLinks = document.querySelectorAll('.sidebar-menu a');
    menuLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            // Only prevent default for special cases (like logout modal)
            if (href === '#' || href.includes('javascript:')) {
                e.preventDefault();
                return;
            }
            
            // For normal navigation, completely prevent any scroll behavior
            if (href && href !== '#') {
                // Prevent all default behaviors
                e.preventDefault();
                e.stopPropagation();
                
                // Remove active class from all links
                menuLinks.forEach(l => l.classList.remove('active'));
                
                // Add active class to clicked link
                this.classList.add('active');
                
                // Force disable scroll behavior
                document.documentElement.style.scrollBehavior = 'auto';
                document.body.style.scrollBehavior = 'auto';
                
                // Store current scroll position
                const currentScrollTop = window.pageYOffset || document.documentElement.scrollTop;
                
                // Navigate immediately without any scroll effects
                setTimeout(() => {
                    window.location.href = href;
                }, 50);
                
                // Prevent any scroll restoration
                if ('scrollRestoration' in history) {
                    history.scrollRestoration = 'manual';
                }
            }
        });
    });

    // Highlight active menu based on current path
    const currentPath = window.location.pathname;
    menuLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href && currentPath.includes(href)) {
            link.classList.add('active');
        }
    });
}

// ============================================================
// DATA TABLES
// ============================================================
function initDataTables() {
    if (typeof $ !== 'undefined' && $.fn.DataTable) {
        $('.data-table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "pageLength": 25,
            "ordering": true,
            "searching": true
        });
    }
}

// ============================================================
// DELETE CONFIRMATION
// ============================================================
function initDeleteConfirm() {
    const deleteButtons = document.querySelectorAll('.btn-delete');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                e.preventDefault();
            }
        });
    });
}

// ============================================================
// NOTIFICATIONS
// ============================================================
function initNotifications() {
    // Auto hide alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        });
    }, 5000);

    // Check for new notifications periodically
    if (document.querySelector('.notification-icon')) {
        setInterval(checkNotifications, 60000); // Every 1 minute
    }
}

function checkNotifications() {
    fetch(baseUrl + 'notifikasi/get_unread')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateNotificationBadge(data.count);
            }
        })
        .catch(error => console.error('Error checking notifications:', error));
}

function updateNotificationBadge(count) {
    const badge = document.querySelector('.notification-badge');
    if (badge) {
        badge.textContent = count;
        badge.style.display = count > 0 ? 'flex' : 'none';
    }
}

// ============================================================
// FORM VALIDATION
// ============================================================
function initFormValidation() {
    const forms = document.querySelectorAll('.needs-validation');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });
}

// ============================================================
// CHART HELPERS
// ============================================================
function createLineChart(elementId, labels, data, label) {
    const ctx = document.getElementById(elementId);
    if (!ctx) return;

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: label,
                data: data,
                borderColor: '#FF6B35',
                backgroundColor: 'rgba(255, 107, 53, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

function createBarChart(elementId, labels, data, label) {
    const ctx = document.getElementById(elementId);
    if (!ctx) return;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: label,
                data: data,
                backgroundColor: [
                    '#FF6B35',
                    '#F7931E',
                    '#28a745',
                    '#17a2b8',
                    '#ffc107'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

// ============================================================
// UTILITY FUNCTIONS
// ============================================================

function formatCurrency(amount) {
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    });
}

// Add to cart (for sales page)
function addToCart(produkId) {
    const qty = document.getElementById('qty_' + produkId)?.value || 1;
    
    fetch(baseUrl + 'penjualan/add_to_cart', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'produk_id=' + produkId + '&qty=' + qty
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan!');
    });
}

// Print function
function printPage() {
    window.print();
}

// Export to PDF (requires jsPDF library)
function exportToPDF(elementId, filename) {
    if (typeof html2pdf === 'undefined') {
        alert('Library PDF tidak tersedia!');
        return;
    }

    const element = document.getElementById(elementId);
    const opt = {
        margin: 10,
        filename: filename + '.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
    };

    html2pdf().set(opt).from(element).save();
}

