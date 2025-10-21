<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Get all suppliers
    public function get_all($status = null) {
        if ($status) {
            $this->db->where('status', $status);
        }
        $this->db->order_by('nama_supplier', 'ASC');
        $query = $this->db->get('supplier');
        return $query->result();
    }

    // Get supplier by ID
    public function get_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('supplier');
        return $query->row();
    }

    // Insert new supplier
    public function insert($data) {
        return $this->db->insert('supplier', $data);
    }

    // Update supplier
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('supplier', $data);
    }

    // Delete supplier (soft delete)
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->update('supplier', ['status' => 'inactive']);
    }

    // Hard delete supplier
    public function hard_delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('supplier');
    }

    // Search suppliers
    public function search($keyword) {
        $this->db->like('nama_supplier', $keyword);
        $this->db->or_like('alamat', $keyword);
        $this->db->or_like('no_telepon', $keyword);
        $this->db->where('status', 'active');
        $query = $this->db->get('supplier');
        return $query->result();
    }

    // Get active suppliers for dropdown
    public function get_dropdown() {
        $this->db->select('id, nama_supplier');
        $this->db->where('status', 'active');
        $this->db->order_by('nama_supplier', 'ASC');
        $query = $this->db->get('supplier');
        
        $dropdown = [];
        foreach ($query->result() as $row) {
            $dropdown[$row->id] = $row->nama_supplier;
        }
        
        return $dropdown;
    }

    // Count suppliers
    public function count_suppliers() {
        $this->db->where('status', 'active');
        return $this->db->count_all_results('supplier');
    }
}

