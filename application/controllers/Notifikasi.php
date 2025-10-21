<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifikasi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // Set fake session untuk testing (TEMPORARY)
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_userdata(array(
                'user_id' => 1,
                'nama_lengkap' => 'Administrator',
                'email' => 'admin@kedaijus.com',
                'role' => 'admin',
                'logged_in' => TRUE
            ));
        }
        
        $this->load->model('Notifikasi_model');
    }

    // List all notifications
    public function index() {
        $status = $this->input->get('status');
        
        $data['title'] = 'Notifikasi';
        
        if ($status == 'unread') {
            $data['notifications'] = $this->Notifikasi_model->get_unread();
        } elseif ($status == 'read') {
            $data['notifications'] = $this->Notifikasi_model->get_read();
        } else {
            $data['notifications'] = $this->Notifikasi_model->get_all();
        }
        
        $data['unread_count'] = $this->Notifikasi_model->count_unread();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('notifikasi/index', $data);
        $this->load->view('templates/footer');
    }

    // Mark notification as read
    public function mark_read($id) {
        $this->Notifikasi_model->mark_as_read($id);
        
        // Get redirect URL from referer
        $redirect = $this->input->server('HTTP_REFERER') ?: 'notifikasi';
        redirect($redirect);
    }

    // Mark all as read
    public function mark_all_read() {
        $this->Notifikasi_model->mark_all_as_read();
        $this->session->set_flashdata('success', 'Semua notifikasi telah ditandai sebagai dibaca!');
        redirect('notifikasi');
    }

    // Delete notification
    public function hapus($id) {
        if ($this->Notifikasi_model->delete($id)) {
            $this->session->set_flashdata('success', 'Notifikasi berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus notifikasi!');
        }
        redirect('notifikasi');
    }

    // Get unread notifications (AJAX)
    public function get_unread() {
        $notifications = $this->Notifikasi_model->get_unread(10);
        $count = $this->Notifikasi_model->count_unread();
        
        echo json_encode([
            'success' => true,
            'notifications' => $notifications,
            'count' => $count
        ]);
    }
}

