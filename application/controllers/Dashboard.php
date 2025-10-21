<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        
        $this->load->model('Bahan_baku_model');
        $this->load->model('Produk_jus_model');
        $this->load->model('Penjualan_model');
        $this->load->model('Stok_masuk_model');
        $this->load->model('Supplier_model');
        $this->load->model('User_model');
        $this->load->model('Notifikasi_model');
    }

    public function index() {
        $data['title'] = 'Dashboard';
        
        // Get statistics
        $data['total_bahan'] = $this->Bahan_baku_model->count_bahan();
        $data['total_produk'] = $this->Produk_jus_model->count_products('active');
        $data['total_supplier'] = $this->Supplier_model->count_suppliers();
        $data['total_users'] = $this->User_model->count_users();
        
        // Low stock items
        $data['low_stock_count'] = $this->Bahan_baku_model->count_low_stock();
        $data['low_stock_items'] = $this->Bahan_baku_model->get_low_stock();
        
        // Items near expiry
        $data['expiring_items'] = $this->Bahan_baku_model->get_near_expiry(7);
        
        // Sales statistics (today)
        $today = date('Y-m-d');
        $data['today_sales'] = $this->Penjualan_model->get_daily_report($today);
        $data['today_transactions'] = $this->Penjualan_model->count_sales($today, $today);
        
        // Sales statistics (this month)
        $first_day = date('Y-m-01');
        $last_day = date('Y-m-t');
        $data['month_sales'] = $this->Penjualan_model->get_total_sales($first_day, $last_day);
        $data['month_transactions'] = $this->Penjualan_model->count_sales($first_day, $last_day);
        
        // Best selling products (this month)
        $data['best_selling'] = $this->Penjualan_model->get_best_selling(5, $first_day, $last_day);
        
        // Recent sales
        $data['recent_sales'] = $this->Penjualan_model->get_all(5);
        
        // Recent stock entries
        $data['recent_stock'] = $this->Stok_masuk_model->get_all(5);
        
        // Notifications
        $data['notifications'] = $this->Notifikasi_model->get_unread(10);
        $data['unread_count'] = $this->Notifikasi_model->count_unread();
        
        // Login notifications
        $data['show_no_input_notification'] = $this->session->userdata('show_no_input_notification');
        $data['days_since_input'] = $this->session->userdata('days_since_input');
        
        // Chart data for sales (last 7 days)
        $chart_labels = [];
        $chart_data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-{$i} days"));
            $chart_labels[] = date('d M', strtotime($date));
            
            $sales = $this->Penjualan_model->get_total_sales($date, $date);
            $chart_data[] = $sales;
        }
        $data['chart_labels'] = $chart_labels;
        $data['chart_data'] = $chart_data;
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer');
    }

    // Dismiss login notifications
    public function dismiss_notification($type) {
        if ($type == 'no_input') {
            $this->session->unset_userdata('show_no_input_notification');
            $this->session->unset_userdata('days_since_input');
        }
        
        echo json_encode(['status' => 'success']);
    }
}

