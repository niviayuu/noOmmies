<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Base Controller for authenticated pages
 */
class MY_Controller extends CI_Controller {

    protected $user_id;
    protected $user_role;
    protected $user_data;

    public function __construct() {
        parent::__construct();
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu!');
            redirect('auth/login');
        }

        // Set user data
        $this->user_id = $this->session->userdata('user_id');
        $this->user_role = $this->session->userdata('role');
        $this->user_data = $this->session->userdata();

        // Load commonly used models
        $this->load->model('Notifikasi_model');
        
        // Generate notifications
        $this->_generate_notifications();
    }

    /**
     * Check if user has required role
     */
    protected function check_role($allowed_roles = []) {
        if (!in_array($this->user_role, $allowed_roles)) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman ini!');
            redirect('dashboard');
        }
    }

    /**
     * Generate automatic notifications
     */
    private function _generate_notifications() {
        // Generate stock and expiry notifications
        $this->Notifikasi_model->generate_stock_notifications();
        $this->Notifikasi_model->generate_expiry_notifications(3);
    }

    /**
     * Get unread notifications for header
     */
    protected function get_notifications($limit = 5) {
        return $this->Notifikasi_model->get_unread($limit);
    }

    /**
     * Count unread notifications
     */
    protected function count_unread_notifications() {
        return $this->Notifikasi_model->count_unread();
    }
}

/**
 * Admin Controller - Only for admin and owner
 */
class Admin_Controller extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->check_role(['admin', 'owner']);
    }
}

/**
 * Super Admin Controller - Only for admin
 */
class Super_Admin_Controller extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->check_role(['admin']);
    }
}

