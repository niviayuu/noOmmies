<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        
        $this->load->model('Penjualan_model');
        $this->load->model('Stok_masuk_model');
        $this->load->model('Bahan_baku_model');
        $this->load->model('Waste_model');
        $this->load->model('Notifikasi_model');
    }

    // Main report page
    public function index() {
        $data['title'] = 'Laporan';
        $data['notifications'] = $this->get_notifications();
        $data['unread_count'] = $this->count_unread_notifications();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('laporan/index', $data);
        $this->load->view('templates/footer');
    }

    // Sales report
    public function penjualan() {
        $start_date = $this->input->get('start_date') ?: date('Y-m-01');
        $end_date = $this->input->get('end_date') ?: date('Y-m-t');

        $data['title'] = 'Laporan Penjualan';
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['penjualan_list'] = $this->Penjualan_model->get_by_date_range($start_date, $end_date);
        $data['total_pendapatan'] = $this->Penjualan_model->get_total_sales($start_date, $end_date);
        $data['total_transaksi'] = $this->Penjualan_model->count_sales($start_date, $end_date);
        $data['best_selling'] = $this->Penjualan_model->get_best_selling(10, $start_date, $end_date);
        $data['notifications'] = $this->get_notifications();
        $data['unread_count'] = $this->count_unread_notifications();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('laporan/penjualan', $data);
        $this->load->view('templates/footer');
    }

    // Purchase report
    public function pembelian() {
        $start_date = $this->input->get('start_date') ?: date('Y-m-01');
        $end_date = $this->input->get('end_date') ?: date('Y-m-t');

        $data['title'] = 'Laporan Pembelian';
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['pembelian_list'] = $this->Stok_masuk_model->get_by_date_range($start_date, $end_date);
        $data['total_pembelian'] = $this->Stok_masuk_model->get_total_purchase($start_date, $end_date);
        $data['notifications'] = $this->get_notifications();
        $data['unread_count'] = $this->count_unread_notifications();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('laporan/pembelian', $data);
        $this->load->view('templates/footer');
    }

    // Stock report
    public function stok() {
        $data['title'] = 'Laporan Stok';
        $data['bahan_list'] = $this->Bahan_baku_model->get_all();
        $data['low_stock'] = $this->Bahan_baku_model->get_low_stock();
        $data['near_expiry'] = $this->Bahan_baku_model->get_near_expiry(7);
        $data['notifications'] = $this->get_notifications();
        $data['unread_count'] = $this->count_unread_notifications();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('laporan/stok', $data);
        $this->load->view('templates/footer');
    }

    // Daily sales report
    public function harian() {
        $date = $this->input->get('date') ?: date('Y-m-d');

        $data['title'] = 'Laporan Penjualan Harian';
        $data['date'] = $date;
        $data['penjualan_list'] = $this->Penjualan_model->get_by_date($date);
        $data['daily_report'] = $this->Penjualan_model->get_daily_report($date);
        $data['notifications'] = $this->get_notifications();
        $data['unread_count'] = $this->count_unread_notifications();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('laporan/harian', $data);
        $this->load->view('templates/footer');
    }

    // Waste report
    public function waste() {
        $start_date = $this->input->get('start_date') ?: date('Y-m-01');
        $end_date = $this->input->get('end_date') ?: date('Y-m-t');
        $category = $this->input->get('category');

        $data['title'] = 'Laporan Waste';
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['category'] = $category;
        
        // Get waste records based on filters
        if ($category) {
            $data['waste_records'] = $this->Waste_model->get_by_category($category);
        } else {
            $data['waste_records'] = $this->Waste_model->get_by_date_range($start_date, $end_date);
        }
        
        $data['statistics'] = $this->Waste_model->get_statistics();
        $data['categories'] = $this->Waste_model->get_categories();
        $data['top_categories'] = $this->Waste_model->get_top_categories(5);
        $data['notifications'] = $this->get_notifications();
        $data['unread_count'] = $this->count_unread_notifications();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('laporan/waste', $data);
        $this->load->view('templates/footer');
    }

    // Helper methods untuk notifikasi
    private function get_notifications($limit = 5) {
        return $this->Notifikasi_model->get_unread($limit);
    }

    private function count_unread_notifications() {
        return $this->Notifikasi_model->count_unread();
    }
}

