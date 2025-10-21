    </div>
</div>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<!-- Custom JS -->
<script src="<?php echo base_url('assets/js/script.js'); ?>"></script>

<style>
/* Simple Logout Modal Styles */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-container {
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    max-width: 400px;
    width: 90%;
}

.modal-header {
    background: #dc3545;
    color: white;
    padding: 20px;
    border-radius: 8px 8px 0 0;
}

.modal-header h4 {
    margin: 0;
    font-size: 18px;
}

.modal-body {
    padding: 20px;
}

.modal-footer {
    padding: 15px 20px;
    background: #f8f9fa;
    border-radius: 0 0 8px 8px;
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}

.modal-footer .btn {
    padding: 8px 16px;
    border-radius: 4px;
    font-size: 14px;
    border: none;
    cursor: pointer;
}

.modal-footer .btn-secondary {
    background: #6c757d;
    color: white;
}

.modal-footer .btn-danger {
    background: #dc3545;
    color: white;
}
</style>

<script>
// Simple Logout Modal Functions
function showLogoutModal() {
    document.getElementById('logoutModal').style.display = 'flex';
}

function hideLogoutModal() {
    document.getElementById('logoutModal').style.display = 'none';
}

function confirmLogout() {
    window.location.href = '<?php echo site_url('auth/logout'); ?>';
}

// Close modal when clicking outside
document.addEventListener('click', function(e) {
    const modal = document.getElementById('logoutModal');
    if (e.target === modal) {
        hideLogoutModal();
    }
});
</script>

