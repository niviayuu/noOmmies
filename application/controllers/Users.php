<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

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
        
        $this->load->model('User_model');
        $this->load->model('Notifikasi_model');
    }

    // List all users
    public function index() {
        $data['title'] = 'Manajemen User';
        $data['users'] = $this->User_model->get_all();
        $data['notifications'] = $this->get_notifications();
        $data['unread_count'] = $this->count_unread_notifications();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('users/index', $data);
        $this->load->view('templates/footer');
    }

    // Add new user
    public function tambah() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('role', 'Role', 'required');

            if ($this->form_validation->run()) {
                $data = array(
                    'nama_lengkap' => $this->input->post('nama_lengkap'),
                    'email' => $this->input->post('email'),
                    'password' => $this->input->post('password'),
                    'role' => $this->input->post('role'),
                    'no_hp' => $this->input->post('no_hp'),
                    'status' => $this->input->post('status') ?: 'active'
                );

                if ($this->User_model->insert($data)) {
                    $this->session->set_flashdata('success', 'User berhasil ditambahkan!');
                    redirect('users');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menambahkan user!');
                }
            }
        }

        $data['title'] = 'Tambah User';
        $data['notifications'] = $this->get_notifications();
        $data['unread_count'] = $this->count_unread_notifications();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('users/form', $data);
        $this->load->view('templates/footer');
    }

    // Edit user
    public function edit($id) {
        $data['user'] = $this->User_model->get_by_id($id);
        
        if (!$data['user']) {
            $this->session->set_flashdata('error', 'User tidak ditemukan!');
            redirect('users');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('role', 'Role', 'required');

            // Check if email is unique (exclude current user)
            if ($this->User_model->email_exists($this->input->post('email'), $id)) {
                $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
            }

            if ($this->form_validation->run()) {
                $update_data = array(
                    'nama_lengkap' => $this->input->post('nama_lengkap'),
                    'email' => $this->input->post('email'),
                    'role' => $this->input->post('role'),
                    'no_hp' => $this->input->post('no_hp'),
                    'status' => $this->input->post('status')
                );

                // Only update password if provided
                if ($this->input->post('password')) {
                    $update_data['password'] = $this->input->post('password');
                }

                if ($this->User_model->update($id, $update_data)) {
                    $this->session->set_flashdata('success', 'User berhasil diupdate!');
                    redirect('users');
                } else {
                    $this->session->set_flashdata('error', 'Gagal mengupdate user!');
                }
            }
        }

        $data['title'] = 'Edit User';
        $data['notifications'] = $this->get_notifications();
        $data['unread_count'] = $this->count_unread_notifications();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('users/form', $data);
        $this->load->view('templates/footer');
    }

    // Delete user
    public function hapus($id) {
        // Prevent deleting self
        $user_id = $this->session->userdata('user_id');
        if ($id == $user_id) {
            $this->session->set_flashdata('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
            redirect('users');
        }

        if ($this->User_model->delete($id)) {
            $this->session->set_flashdata('success', 'User berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus user!');
        }
        redirect('users');
    }

    // Activate user (approve registration)
    public function activate($id) {
        $data = ['status' => 'active'];
        
        if ($this->User_model->update($id, $data)) {
            $this->session->set_flashdata('success', 'User berhasil diaktifkan!');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengaktifkan user!');
        }
        redirect('users');
    }

    // Deactivate user
    public function deactivate($id) {
        // Prevent deactivating self
        $user_id = $this->session->userdata('user_id');
        if ($id == $user_id) {
            $this->session->set_flashdata('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri!');
            redirect('users');
        }

        $data = ['status' => 'inactive'];
        
        if ($this->User_model->update($id, $data)) {
            $this->session->set_flashdata('success', 'User berhasil dinonaktifkan!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menonaktifkan user!');
        }
        redirect('users');
    }

    // Profile page
    public function profile() {
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->User_model->get_by_id($user_id);
        $data['title'] = 'Profil Saya';
        $data['notifications'] = $this->get_notifications();
        $data['unread_count'] = $this->count_unread_notifications();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('users/profile', $data);
        $this->load->view('templates/footer');
    }

    // Update profile
    public function update_profile() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

            if ($this->form_validation->run()) {
                $user_id = $this->session->userdata('user_id');
                $update_data = array(
                    'nama_lengkap' => $this->input->post('nama_lengkap'),
                    'email' => $this->input->post('email'),
                    'no_hp' => $this->input->post('no_hp')
                );

                // Only update password if provided
                if ($this->input->post('password')) {
                    $update_data['password'] = $this->input->post('password');
                }

                if ($this->User_model->update($user_id, $update_data)) {
                    // Update session data
                    $this->session->set_userdata('nama_lengkap', $update_data['nama_lengkap']);
                    $this->session->set_userdata('email', $update_data['email']);
                    
                    $this->session->set_flashdata('success', 'Profil berhasil diupdate!');
                } else {
                    $this->session->set_flashdata('error', 'Gagal mengupdate profil!');
                }
            }
        }
        
        redirect('users/profile');
    }

    // Helper methods for notifications
    protected function get_notifications($limit = 5) {
        return $this->Notifikasi_model->get_unread($limit);
    }

    protected function count_unread_notifications() {
        return $this->Notifikasi_model->count_unread();
    }
}

