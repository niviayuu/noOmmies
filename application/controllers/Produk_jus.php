<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_jus extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        
        $this->load->model('Produk_jus_model');
        $this->load->model('Resep_jus_model');
        $this->load->model('Bahan_baku_model');
    }

    // List all products
    public function index() {
        $data['title'] = 'Data Produk Jus';
        $data['products'] = $this->Produk_jus_model->get_all();
        $data['notifications'] = $this->get_notifications();
        $data['unread_count'] = $this->count_unread_notifications();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('produk_jus/index', $data);
        $this->load->view('templates/footer');
    }

    // Add new product
    public function tambah() {
        // Check role for adding products - only admin and owner can add
        $this->check_role(['admin', 'owner']);

        if ($this->input->post()) {
            $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required');
            $this->form_validation->set_rules('kategori', 'Kategori', 'required');
            $this->form_validation->set_rules('ukuran', 'Ukuran', 'required');
            $this->form_validation->set_rules('harga', 'Harga', 'required|numeric');

            if ($this->form_validation->run()) {
                $data = array(
                    'nama_produk' => $this->input->post('nama_produk'),
                    'kategori' => $this->input->post('kategori'),
                    'ukuran' => $this->input->post('ukuran'),
                    'harga' => $this->input->post('harga'),
                    'deskripsi' => $this->input->post('deskripsi'),
                    'status' => 'active'
                );

                if ($this->Produk_jus_model->insert($data)) {
                    $this->session->set_flashdata('success', 'Data produk berhasil ditambahkan!');
                    redirect('produk_jus');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menambahkan data produk!');
                }
            }
        }

        $data['title'] = 'Tambah Produk Jus';
        $data['notifications'] = $this->get_notifications();
        $data['unread_count'] = $this->count_unread_notifications();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('produk_jus/form', $data);
        $this->load->view('templates/footer');
    }

    // Edit product
    public function edit($id) {
        $this->check_role(['admin', 'owner']);

        $data['produk'] = $this->Produk_jus_model->get_by_id($id);
        
        if (!$data['produk']) {
            $this->session->set_flashdata('error', 'Data produk tidak ditemukan!');
            redirect('produk_jus');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required');
            $this->form_validation->set_rules('kategori', 'Kategori', 'required');
            $this->form_validation->set_rules('ukuran', 'Ukuran', 'required');
            $this->form_validation->set_rules('harga', 'Harga', 'required|numeric');

            if ($this->form_validation->run()) {
                $update_data = array(
                    'nama_produk' => $this->input->post('nama_produk'),
                    'kategori' => $this->input->post('kategori'),
                    'ukuran' => $this->input->post('ukuran'),
                    'harga' => $this->input->post('harga'),
                    'deskripsi' => $this->input->post('deskripsi'),
                    'status' => $this->input->post('status')
                );

                if ($this->Produk_jus_model->update($id, $update_data)) {
                    $this->session->set_flashdata('success', 'Data produk berhasil diupdate!');
                    redirect('produk_jus');
                } else {
                    $this->session->set_flashdata('error', 'Gagal mengupdate data produk!');
                }
            }
        }

        $data['title'] = 'Edit Produk Jus';
        $data['notifications'] = $this->get_notifications();
        $data['unread_count'] = $this->count_unread_notifications();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('produk_jus/form', $data);
        $this->load->view('templates/footer');
    }

    // Delete product
    public function hapus($id) {
        $this->check_role(['admin', 'owner']);

        if ($this->Produk_jus_model->delete($id)) {
            $this->session->set_flashdata('success', 'Data produk berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data produk!');
        }
        redirect('produk_jus');
    }

    // View product detail with recipes
    public function detail($id) {
        $data['produk'] = $this->Produk_jus_model->get_with_recipes($id);
        
        if (!$data['produk']) {
            $this->session->set_flashdata('error', 'Data produk tidak ditemukan!');
            redirect('produk_jus');
        }

        $data['title'] = 'Detail Produk';
        $data['notifications'] = $this->get_notifications();
        $data['unread_count'] = $this->count_unread_notifications();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('produk_jus/detail', $data);
        $this->load->view('templates/footer');
    }

    // Manage recipes for a product
    public function resep($id) {
        $this->check_role(['admin', 'owner']);

        $data['produk'] = $this->Produk_jus_model->get_by_id($id);
        
        if (!$data['produk']) {
            $this->session->set_flashdata('error', 'Data produk tidak ditemukan!');
            redirect('produk_jus');
        }

        $data['resep'] = $this->Resep_jus_model->get_by_produk($id);
        $data['bahan_list'] = $this->Bahan_baku_model->get_dropdown();

        $data['title'] = 'Resep ' . $data['produk']->nama_produk;
        $data['notifications'] = $this->get_notifications();
        $data['unread_count'] = $this->count_unread_notifications();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('produk_jus/resep', $data);
        $this->load->view('templates/footer');
    }

    // Add recipe item
    public function tambah_resep($produk_id) {
        $this->check_role(['admin', 'owner']);

        if ($this->input->post()) {
            $data = array(
                'produk_id' => $produk_id,
                'bahan_id' => $this->input->post('bahan_id'),
                'jumlah' => $this->input->post('jumlah'),
                'satuan' => $this->input->post('satuan'),
                'keterangan' => $this->input->post('keterangan')
            );

            if ($this->Resep_jus_model->insert($data)) {
                $this->session->set_flashdata('success', 'Resep berhasil ditambahkan!');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan resep!');
            }
        }

        redirect('produk_jus/resep/' . $produk_id);
    }

    // Delete recipe item
    public function hapus_resep($id, $produk_id) {
        $this->check_role(['admin', 'owner']);

        if ($this->Resep_jus_model->delete($id)) {
            $this->session->set_flashdata('success', 'Resep berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus resep!');
        }
        redirect('produk_jus/resep/' . $produk_id);
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
    
    // Check user role for access control
    private function check_role($allowed_roles) {
        $user_role = $this->session->userdata('role');
        
        if (!in_array($user_role, $allowed_roles)) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk melakukan tindakan ini!');
            redirect('dashboard');
        }
    }
}

