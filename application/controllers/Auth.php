<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Bahan_baku_model');
        $this->load->model('Stok_masuk_model');
        $this->load->model('Notifikasi_model');
    }

    // Login page
    public function login() {
        // Redirect if already logged in
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run()) {
                $email = $this->input->post('email');
                $password = $this->input->post('password');

                $user = $this->User_model->login($email, $password);

                if ($user) {
                    // Set session data
                    $session_data = array(
                        'user_id' => $user->id,
                        'nama_lengkap' => $user->nama_lengkap,
                        'email' => $user->email,
                        'role' => $user->role,
                        'logged_in' => TRUE
                    );
                    $this->session->set_userdata($session_data);

                    // Set success message
                    $this->session->set_flashdata('success', 'Login berhasil! Selamat datang, ' . $user->nama_lengkap);

                    // Check for notifications before redirecting to dashboard
                    $this->_check_login_notifications();

                    // Redirect to dashboard
                    redirect('dashboard');
                } else {
                    $this->session->set_flashdata('error', 'Email atau password salah!');
                }
            }
        }

        $this->load->view('auth/login');
    }

    // Logout
    public function logout() {
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('nama_lengkap');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role');
        $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy();

        $this->session->set_flashdata('success', 'Anda berhasil logout.');
        redirect('auth/login');
    }

    // Register page (can be accessed by anyone, but approval needed)
    public function register() {
        // If already logged in, redirect to dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('password_confirm', 'Konfirmasi Password', 'required|matches[password]');
            $this->form_validation->set_rules('no_hp', 'No HP', 'required');
            $this->form_validation->set_rules('role', 'Role', 'required|in_list[admin,owner,karyawan]');

            if ($this->form_validation->run()) {
                $data = array(
                    'nama_lengkap' => $this->input->post('nama_lengkap'),
                    'email' => $this->input->post('email'),
                    'password' => $this->input->post('password'),
                    'no_hp' => $this->input->post('no_hp'),
                    'role' => $this->input->post('role'),
                    'status' => 'active' // Langsung aktif untuk semua role
                );

                if ($this->User_model->insert($data)) {
                    $this->session->set_flashdata('success', 'Registrasi berhasil! Anda dapat langsung login.');
                    redirect('auth/login');
                } else {
                    $this->session->set_flashdata('error', 'Registrasi gagal! Silakan coba lagi.');
                }
            }
        }

        $this->load->view('auth/register');
    }

    // Forgot password (optional feature)
    public function forgot_password() {
        $this->load->view('auth/forgot_password');
    }

    // Check notifications after login
    private function _check_login_notifications() {
        // Check for no input in last 3 days
        $last_input = $this->Stok_masuk_model->get_last_input_date();
        if ($last_input) {
            $days_since_input = (time() - strtotime($last_input)) / (60 * 60 * 24);
            if ($days_since_input >= 3) {
                $this->session->set_userdata('show_no_input_notification', true);
                $this->session->set_userdata('days_since_input', floor($days_since_input));
            }
        }
    }
}

