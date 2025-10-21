<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Waste extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Waste_model');
        $this->load->model('Bahan_baku_model');
        $this->load->model('Produk_jus_model');
        $this->load->model('Notifikasi_model');
        $this->load->library('form_validation');
        
        // Bypass login untuk testing
        if (!$this->session->userdata('user_id')) {
            $this->session->set_userdata('user_id', 1);
            $this->session->set_userdata('role', 'admin');
            $this->session->set_userdata('nama_lengkap', 'Administrator');
        }
    }

    public function index() {
        $data['title'] = 'Manajemen Waste';
        $data['waste_records'] = $this->Waste_model->get_all();
        $data['statistics'] = $this->Waste_model->get_statistics();
        $data['categories'] = $this->Waste_model->get_categories();
        $data['unread_notifications'] = $this->Notifikasi_model->count_unread();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('waste/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah() {
        $data['title'] = 'Tambah Waste';
        $data['categories'] = $this->Waste_model->get_categories();
        $data['bahan_baku'] = $this->Bahan_baku_model->get_all();
        $data['produk_jus'] = $this->Produk_jus_model->get_all();
        $data['unread_notifications'] = $this->Notifikasi_model->count_unread();
        
        $this->form_validation->set_rules('tanggal_waste', 'Tanggal Waste', 'required');
        $this->form_validation->set_rules('kategori_id', 'Kategori', 'required');
        $this->form_validation->set_rules('nama_item', 'Nama Item', 'required');
        $this->form_validation->set_rules('jumlah_waste', 'Jumlah Waste', 'required|numeric');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');
        $this->form_validation->set_rules('harga_per_satuan', 'Harga per Satuan', 'required|numeric');
        $this->form_validation->set_rules('alasan_waste', 'Alasan Waste', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('waste/form', $data);
            $this->load->view('templates/footer');
        } else {
            $data_waste = array(
                'tanggal_waste' => $this->input->post('tanggal_waste'),
                'kategori_id' => $this->input->post('kategori_id'),
                'bahan_baku_id' => $this->input->post('bahan_baku_id') ?: null,
                'produk_jus_id' => $this->input->post('produk_jus_id') ?: null,
                'nama_item' => $this->input->post('nama_item'),
                'jumlah_waste' => $this->input->post('jumlah_waste'),
                'satuan' => $this->input->post('satuan'),
                'harga_per_satuan' => $this->input->post('harga_per_satuan'),
                'alasan_waste' => $this->input->post('alasan_waste'),
                'status' => 'pending',
                'created_by' => $this->session->userdata('user_id')
            );

            if ($this->Waste_model->insert($data_waste)) {
                $this->session->set_flashdata('success', 'Data waste berhasil ditambahkan');
                redirect('waste');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan data waste');
                redirect('waste/tambah');
            }
        }
    }

    public function edit($id) {
        $data['title'] = 'Edit Waste';
        $data['waste'] = $this->Waste_model->get_by_id($id);
        $data['categories'] = $this->Waste_model->get_categories();
        $data['bahan_baku'] = $this->Bahan_baku_model->get_all();
        $data['produk_jus'] = $this->Produk_jus_model->get_all();
        $data['unread_notifications'] = $this->Notifikasi_model->count_unread();
        
        if (!$data['waste']) {
            show_404();
        }

        $this->form_validation->set_rules('tanggal_waste', 'Tanggal Waste', 'required');
        $this->form_validation->set_rules('kategori_id', 'Kategori', 'required');
        $this->form_validation->set_rules('nama_item', 'Nama Item', 'required');
        $this->form_validation->set_rules('jumlah_waste', 'Jumlah Waste', 'required|numeric');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');
        $this->form_validation->set_rules('harga_per_satuan', 'Harga per Satuan', 'required|numeric');
        $this->form_validation->set_rules('alasan_waste', 'Alasan Waste', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('waste/form', $data);
            $this->load->view('templates/footer');
        } else {
            $data_waste = array(
                'tanggal_waste' => $this->input->post('tanggal_waste'),
                'kategori_id' => $this->input->post('kategori_id'),
                'bahan_baku_id' => $this->input->post('bahan_baku_id') ?: null,
                'produk_jus_id' => $this->input->post('produk_jus_id') ?: null,
                'nama_item' => $this->input->post('nama_item'),
                'jumlah_waste' => $this->input->post('jumlah_waste'),
                'satuan' => $this->input->post('satuan'),
                'harga_per_satuan' => $this->input->post('harga_per_satuan'),
                'alasan_waste' => $this->input->post('alasan_waste')
            );

            if ($this->Waste_model->update($id, $data_waste)) {
                $this->session->set_flashdata('success', 'Data waste berhasil diupdate');
                redirect('waste');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengupdate data waste');
                redirect('waste/edit/' . $id);
            }
        }
    }

    public function detail($id) {
        $data['title'] = 'Detail Waste';
        $data['waste'] = $this->Waste_model->get_by_id($id);
        $data['disposal_records'] = $this->Waste_model->get_disposal_records($id);
        $data['unread_notifications'] = $this->Notifikasi_model->count_unread();
        
        if (!$data['waste']) {
            show_404();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('waste/detail', $data);
        $this->load->view('templates/footer');
    }

    public function hapus($id) {
        if ($this->Waste_model->delete($id)) {
            $this->session->set_flashdata('success', 'Data waste berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data waste');
        }
        redirect('waste');
    }

    public function approve($id) {
        if ($this->Waste_model->approve($id, $this->session->userdata('user_id'))) {
            $this->session->set_flashdata('success', 'Waste berhasil disetujui');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyetujui waste');
        }
        redirect('waste');
    }

    public function reject($id) {
        if ($this->Waste_model->reject($id, $this->session->userdata('user_id'))) {
            $this->session->set_flashdata('success', 'Waste berhasil ditolak');
        } else {
            $this->session->set_flashdata('error', 'Gagal menolak waste');
        }
        redirect('waste');
    }

    public function disposal($id) {
        $data['title'] = 'Tambah Disposal';
        $data['waste'] = $this->Waste_model->get_by_id($id);
        $data['unread_notifications'] = $this->Notifikasi_model->count_unread();
        
        if (!$data['waste']) {
            show_404();
        }

        $this->form_validation->set_rules('tanggal_disposal', 'Tanggal Disposal', 'required');
        $this->form_validation->set_rules('metode_disposal', 'Metode Disposal', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('waste/disposal_form', $data);
            $this->load->view('templates/footer');
        } else {
            $data_disposal = array(
                'waste_id' => $id,
                'tanggal_disposal' => $this->input->post('tanggal_disposal'),
                'metode_disposal' => $this->input->post('metode_disposal'),
                'lokasi_disposal' => $this->input->post('lokasi_disposal'),
                'nama_penerima' => $this->input->post('nama_penerima'),
                'kontak_penerima' => $this->input->post('kontak_penerima'),
                'catatan_disposal' => $this->input->post('catatan_disposal'),
                'created_by' => $this->session->userdata('user_id')
            );

            if ($this->Waste_model->insert_disposal($data_disposal)) {
                $this->session->set_flashdata('success', 'Data disposal berhasil ditambahkan');
                redirect('waste/detail/' . $id);
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan data disposal');
                redirect('waste/disposal/' . $id);
            }
        }
    }

    public function filter() {
        $status = $this->input->get('status');
        $category = $this->input->get('category');
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        
        $data['title'] = 'Manajemen Waste';
        $data['categories'] = $this->Waste_model->get_categories();
        $data['unread_notifications'] = $this->Notifikasi_model->count_unread();
        
        // Apply filters
        if ($status) {
            $data['waste_records'] = $this->Waste_model->get_by_status($status);
        } elseif ($category) {
            $data['waste_records'] = $this->Waste_model->get_by_category($category);
        } elseif ($start_date && $end_date) {
            $data['waste_records'] = $this->Waste_model->get_by_date_range($start_date, $end_date);
        } else {
            $data['waste_records'] = $this->Waste_model->get_all();
        }
        
        $data['statistics'] = $this->Waste_model->get_statistics();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('waste/index', $data);
        $this->load->view('templates/footer');
    }

    public function search() {
        $keyword = $this->input->get('keyword');
        
        $data['title'] = 'Hasil Pencarian Waste';
        $data['waste_records'] = $this->Waste_model->search($keyword);
        $data['categories'] = $this->Waste_model->get_categories();
        $data['statistics'] = $this->Waste_model->get_statistics();
        $data['unread_notifications'] = $this->Notifikasi_model->count_unread();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('waste/index', $data);
        $this->load->view('templates/footer');
    }

    public function export() {
        $format = $this->input->get('format');
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        
        if ($start_date && $end_date) {
            $data['waste_records'] = $this->Waste_model->get_by_date_range($start_date, $end_date);
        } else {
            $data['waste_records'] = $this->Waste_model->get_all();
        }
        
        if ($format == 'excel') {
            $this->load->view('waste/export_excel', $data);
        } else {
            $this->load->view('waste/export_pdf', $data);
        }
    }

    public function get_item_details() {
        $type = $this->input->post('type');
        $id = $this->input->post('id');
        
        if ($type == 'bahan_baku' && $id) {
            $item = $this->Bahan_baku_model->get_by_id($id);
            echo json_encode(array(
                'nama' => $item->nama_bahan,
                'satuan' => $item->satuan,
                'harga' => $item->harga_satuan
            ));
        } elseif ($type == 'produk_jus' && $id) {
            $item = $this->Produk_jus_model->get_by_id($id);
            echo json_encode(array(
                'nama' => $item->nama_produk,
                'satuan' => 'botol',
                'harga' => $item->harga_jual
            ));
        }
    }
}
