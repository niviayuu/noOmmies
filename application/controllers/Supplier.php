<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        
        $this->load->model('Supplier_model');
    }

    // List all suppliers
    public function index() {
        $data['title'] = 'Data Supplier';
        $data['suppliers'] = $this->Supplier_model->get_all();
        $data['notifications'] = $this->get_notifications();
        $data['unread_count'] = $this->count_unread_notifications();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('supplier/index', $data);
        $this->load->view('templates/footer');
    }

    // Add new supplier
    public function tambah() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('nama_supplier', 'Nama Supplier', 'required');
            $this->form_validation->set_rules('no_telepon', 'No HP', 'required');

            if ($this->form_validation->run()) {
                $data = array(
                    'nama_supplier' => $this->input->post('nama_supplier'),
                    'alamat' => $this->input->post('alamat'),
                    'no_telepon' => $this->input->post('no_telepon'),
                    'email' => $this->input->post('email'),
                    'keterangan' => $this->input->post('keterangan'),
                    'status' => 'active'
                );

                if ($this->Supplier_model->insert($data)) {
                    $this->session->set_flashdata('success', 'Data supplier berhasil ditambahkan!');
                    redirect('supplier');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menambahkan data supplier!');
                }
            }
        }

        $data['title'] = 'Tambah Supplier';
        $data['notifications'] = $this->get_notifications();
        $data['unread_count'] = $this->count_unread_notifications();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('supplier/form', $data);
        $this->load->view('templates/footer');
    }

    // Edit supplier
    public function edit($id) {
        $data['supplier'] = $this->Supplier_model->get_by_id($id);
        
        if (!$data['supplier']) {
            $this->session->set_flashdata('error', 'Data supplier tidak ditemukan!');
            redirect('supplier');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('nama_supplier', 'Nama Supplier', 'required');
            $this->form_validation->set_rules('no_telepon', 'No HP', 'required');

            if ($this->form_validation->run()) {
                $update_data = array(
                    'nama_supplier' => $this->input->post('nama_supplier'),
                    'alamat' => $this->input->post('alamat'),
                    'no_telepon' => $this->input->post('no_telepon'),
                    'email' => $this->input->post('email'),
                    'keterangan' => $this->input->post('keterangan'),
                    'status' => $this->input->post('status')
                );

                if ($this->Supplier_model->update($id, $update_data)) {
                    $this->session->set_flashdata('success', 'Data supplier berhasil diupdate!');
                    redirect('supplier');
                } else {
                    $this->session->set_flashdata('error', 'Gagal mengupdate data supplier!');
                }
            }
        }

        $data['title'] = 'Edit Supplier';
        $data['notifications'] = $this->get_notifications();
        $data['unread_count'] = $this->count_unread_notifications();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('supplier/form', $data);
        $this->load->view('templates/footer');
    }

    // Delete supplier
    public function hapus($id) {
        if ($this->Supplier_model->delete($id)) {
            $this->session->set_flashdata('success', 'Data supplier berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data supplier!');
        }
        redirect('supplier');
    }

    // View supplier detail
    public function detail($id) {
        $data['supplier'] = $this->Supplier_model->get_by_id($id);
        
        if (!$data['supplier']) {
            $this->session->set_flashdata('error', 'Data supplier tidak ditemukan!');
            redirect('supplier');
        }

        $data['title'] = 'Detail Supplier';
        $data['notifications'] = $this->get_notifications();
        $data['unread_count'] = $this->count_unread_notifications();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('supplier/detail', $data);
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

