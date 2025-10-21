<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bahan_baku extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        
        $this->load->model('Bahan_baku_model');
        $this->load->model('Supplier_model');
    }

    // List all bahan baku
    public function index() {
        $data['title'] = 'Data Bahan Baku';
        $data['bahan_list'] = $this->Bahan_baku_model->get_all();
        $data['notifications'] = $this->get_notifications();
        $data['unread_count'] = $this->count_unread_notifications();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('bahan_baku/index', $data);
        $this->load->view('templates/footer');
    }

    // Add new bahan baku
    public function tambah() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('nama_bahan', 'Nama Bahan', 'required');
            $this->form_validation->set_rules('satuan', 'Satuan', 'required');
            $this->form_validation->set_rules('stok_minimum', 'Stok Minimum', 'required|numeric');

            if ($this->form_validation->run()) {
                $data = array(
                    'supplier_id' => $this->input->post('supplier_id') ?: null,
                    'nama_bahan' => $this->input->post('nama_bahan'),
                    'satuan' => $this->input->post('satuan'),
                    'stok' => $this->input->post('stok') ?: 0,
                    'stok_minimum' => $this->input->post('stok_minimum'),
                    'harga_satuan' => $this->input->post('harga_satuan') ?: 0,
                    'tanggal_expired' => $this->input->post('tanggal_expired') ?: null,
                    'keterangan' => $this->input->post('keterangan')
                );

                if ($this->Bahan_baku_model->insert($data)) {
                    $this->session->set_flashdata('success', 'Data bahan baku berhasil ditambahkan!');
                    redirect('bahan_baku');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menambahkan data bahan baku!');
                }
            }
        }

        $data['title'] = 'Tambah Bahan Baku';
        $data['suppliers'] = $this->Supplier_model->get_dropdown();
        $data['notifications'] = $this->get_notifications();
        $data['unread_count'] = $this->count_unread_notifications();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('bahan_baku/form', $data);
        $this->load->view('templates/footer');
    }

    // Edit bahan baku
    public function edit($id) {
        $data['bahan'] = $this->Bahan_baku_model->get_by_id($id);
        
        if (!$data['bahan']) {
            $this->session->set_flashdata('error', 'Data bahan baku tidak ditemukan!');
            redirect('bahan_baku');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('nama_bahan', 'Nama Bahan', 'required');
            $this->form_validation->set_rules('satuan', 'Satuan', 'required');
            $this->form_validation->set_rules('stok_minimum', 'Stok Minimum', 'required|numeric');

            if ($this->form_validation->run()) {
                $update_data = array(
                    'supplier_id' => $this->input->post('supplier_id') ?: null,
                    'nama_bahan' => $this->input->post('nama_bahan'),
                    'satuan' => $this->input->post('satuan'),
                    'stok_minimum' => $this->input->post('stok_minimum'),
                    'harga_satuan' => $this->input->post('harga_satuan') ?: 0,
                    'tanggal_expired' => $this->input->post('tanggal_expired') ?: null,
                    'keterangan' => $this->input->post('keterangan')
                );

                if ($this->Bahan_baku_model->update($id, $update_data)) {
                    $this->session->set_flashdata('success', 'Data bahan baku berhasil diupdate!');
                    redirect('bahan_baku');
                } else {
                    $this->session->set_flashdata('error', 'Gagal mengupdate data bahan baku!');
                }
            }
        }

        $data['title'] = 'Edit Bahan Baku';
        $data['suppliers'] = $this->Supplier_model->get_dropdown();
        $data['notifications'] = $this->get_notifications();
        $data['unread_count'] = $this->count_unread_notifications();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('bahan_baku/form', $data);
        $this->load->view('templates/footer');
    }

    // Delete bahan baku
    public function hapus($id) {
        if ($this->Bahan_baku_model->delete($id)) {
            $this->session->set_flashdata('success', 'Data bahan baku berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data bahan baku!');
        }
        redirect('bahan_baku');
    }

    // View bahan baku detail
    public function detail($id) {
        $data['bahan'] = $this->Bahan_baku_model->get_by_id($id);
        
        if (!$data['bahan']) {
            $this->session->set_flashdata('error', 'Data bahan baku tidak ditemukan!');
            redirect('bahan_baku');
        }

        // Get stock history
        $this->load->model('Stok_masuk_model');
        $data['stok_history'] = $this->Stok_masuk_model->get_by_bahan($id);

        $data['title'] = 'Detail Bahan Baku';
        $data['notifications'] = $this->get_notifications();
        $data['unread_count'] = $this->count_unread_notifications();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('bahan_baku/detail', $data);
        $this->load->view('templates/footer');
    }

    // Low stock report
    public function stok_menipis() {
        $data['title'] = 'Bahan Stok Menipis';
        $data['bahan_list'] = $this->Bahan_baku_model->get_low_stock();
        $data['notifications'] = $this->get_notifications();
        $data['unread_count'] = $this->count_unread_notifications();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('bahan_baku/low_stock', $data);
        $this->load->view('templates/footer');
    }

    // Near expiry report
    public function mendekati_expired() {
        $data['title'] = 'Bahan Mendekati Expired';
        $data['bahan_list'] = $this->Bahan_baku_model->get_near_expiry(7);
        $data['notifications'] = $this->get_notifications();
        $data['unread_count'] = $this->count_unread_notifications();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('bahan_baku/near_expiry', $data);
        $this->load->view('templates/footer');
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

