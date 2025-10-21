<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Get all users
    public function get_all($status = null) {
        if ($status) {
            $this->db->where('status', $status);
        }
        $query = $this->db->get('users');
        return $query->result();
    }

    // Get user by ID
    public function get_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('users');
        return $query->row();
    }

    // Get user by email
    public function get_by_email($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->row();
    }

    // Check login credentials
    public function login($email, $password) {
        $user = $this->get_by_email($email);
        
        if ($user && $user->status == 'active') {
            if (password_verify($password, $user->password)) {
                return $user;
            }
        }
        
        return false;
    }

    // Insert new user
    public function insert($data) {
        // Hash password before insert
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }
        
        return $this->db->insert('users', $data);
    }

    // Update user
    public function update($id, $data) {
        // Hash password if being updated
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        } else {
            unset($data['password']);
        }
        
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    // Delete user (soft delete by changing status)
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->update('users', ['status' => 'inactive']);
    }

    // Hard delete user
    public function hard_delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('users');
    }

    // Check if email exists
    public function email_exists($email, $exclude_id = null) {
        $this->db->where('email', $email);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        $query = $this->db->get('users');
        return $query->num_rows() > 0;
    }

    // Get users by role
    public function get_by_role($role) {
        $this->db->where('role', $role);
        $this->db->where('status', 'active');
        $query = $this->db->get('users');
        return $query->result();
    }

    // Count users
    public function count_users($role = null) {
        if ($role) {
            $this->db->where('role', $role);
        }
        $this->db->where('status', 'active');
        return $this->db->count_all_results('users');
    }
}

