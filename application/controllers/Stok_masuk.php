<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stok_masuk extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        
        $this->load->model('Stok_masuk_model');
        $this->load->model('Bahan_baku_model');
        $this->load->model('Supplier_model');
    }

    // List all stock entries
    public function index() {
        $data['title'] = 'Data Stok Masuk';
        $data['stok_list'] = $this->Stok_masuk_model->get_all();
        $data['notifications'] = $this->get_notifications();
        $data['unread_count'] = $this->count_unread_notifications();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('stok_masuk/index', $data);
        $this->load->view('templates/footer');
    }

    // Add new stock entry
    public function tambah() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('bahan_id', 'Bahan Baku', 'required');
            $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric');
            $this->form_validation->set_rules('harga_satuan', 'Harga Satuan', 'required|numeric');
            $this->form_validation->set_rules('tanggal_masuk', 'Tanggal Masuk', 'required');

            if ($this->form_validation->run()) {
                $jumlah = $this->input->post('jumlah');
                $harga_satuan = $this->input->post('harga_satuan');
                
                $data = array(
                    'bahan_id' => $this->input->post('bahan_id'),
                    'supplier_id' => $this->input->post('supplier_id') ?: null,
                    'jumlah' => $jumlah,
                    'harga_satuan' => $harga_satuan,
                    'total_harga' => $jumlah * $harga_satuan,
                    'tanggal_masuk' => $this->input->post('tanggal_masuk'),
                    'tanggal_expired' => $this->input->post('tanggal_expired') ?: null,
                    'no_faktur' => $this->input->post('no_faktur'),
                    'keterangan' => $this->input->post('keterangan'),
                    'created_by' => $this->session->userdata('user_id')
                );

                if ($this->Stok_masuk_model->insert($data)) {
                    $this->session->set_flashdata('success', 'Data stok masuk berhasil ditambahkan! Stok bahan telah diperbarui.');
                    redirect('stok_masuk');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menambahkan data stok masuk!');
                }
            }
        }

        $data['title'] = 'Tambah Stok Masuk';
        $data['bahan_list'] = $this->Bahan_baku_model->get_all();
        $data['suppliers'] = $this->Supplier_model->get_dropdown();
        $data['notifications'] = $this->get_notifications();
        $data['unread_count'] = $this->count_unread_notifications();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('stok_masuk/form', $data);
        $this->load->view('templates/footer');
    }

    // View stock entry detail
    public function detail($id) {
        $data['stok'] = $this->Stok_masuk_model->get_by_id($id);
        
        if (!$data['stok']) {
            $this->session->set_flashdata('error', 'Data stok masuk tidak ditemukan!');
            redirect('stok_masuk');
        }

        $data['title'] = 'Detail Stok Masuk';
        $data['notifications'] = $this->get_notifications();
        $data['unread_count'] = $this->count_unread_notifications();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('stok_masuk/detail', $data);
        $this->load->view('templates/footer');
    }

    // Delete stock entry
    public function hapus($id) {
        if ($this->Stok_masuk_model->delete($id)) {
            $this->session->set_flashdata('success', 'Data stok masuk berhasil dihapus dan stok bahan telah dikurangi!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data stok masuk!');
        }
        redirect('stok_masuk');
    }
    
    // Helper methods for notifications
    private function get_notifications() {
        $this->load->model('Notifikasi_model');
        return $this->Notifikasi_model->get_all();
    }
    
    private function count_unread_notifications() {
        $this->load->model('Notifikasi_model');
        return $this->Notifikasi_model->count_unread();
    }
}

