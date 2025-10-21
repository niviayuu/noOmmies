<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bahan_baku_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Get all bahan baku with supplier info
    public function get_all() {
        $this->db->select('bahan_baku.*, supplier.nama_supplier');
        $this->db->from('bahan_baku');
        $this->db->join('supplier', 'supplier.id = bahan_baku.supplier_id', 'left');
        $this->db->order_by('bahan_baku.nama_bahan', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    // Get bahan baku by ID
    public function get_by_id($id) {
        $this->db->select('bahan_baku.*, supplier.nama_supplier');
        $this->db->from('bahan_baku');
        $this->db->join('supplier', 'supplier.id = bahan_baku.supplier_id', 'left');
        $this->db->where('bahan_baku.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    // Insert new bahan baku
    public function insert($data) {
        return $this->db->insert('bahan_baku', $data);
    }

    // Update bahan baku
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('bahan_baku', $data);
    }

    // Delete bahan baku
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('bahan_baku');
    }

    // Get bahan baku with low stock
    public function get_low_stock() {
        $this->db->select('bahan_baku.*, supplier.nama_supplier');
        $this->db->from('bahan_baku');
        $this->db->join('supplier', 'supplier.id = bahan_baku.supplier_id', 'left');
        $this->db->where('bahan_baku.stok <=', 'bahan_baku.stok_minimum', false);
        $this->db->order_by('bahan_baku.stok', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    // Get bahan baku near expiry (within 7 days)
    public function get_near_expiry($days = 7) {
        $this->db->select('bahan_baku.*, supplier.nama_supplier, DATEDIFF(bahan_baku.tanggal_expired, CURDATE()) as hari_tersisa', false);
        $this->db->from('bahan_baku');
        $this->db->join('supplier', 'supplier.id = bahan_baku.supplier_id', 'left');
        $this->db->where('bahan_baku.tanggal_expired IS NOT NULL');
        $this->db->where('DATEDIFF(bahan_baku.tanggal_expired, CURDATE()) <=', $days);
        $this->db->where('DATEDIFF(bahan_baku.tanggal_expired, CURDATE()) >=', 0);
        $this->db->order_by('bahan_baku.tanggal_expired', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    // Get dropdown for forms
    public function get_dropdown() {
        $this->db->select('id, CONCAT(nama_bahan, " (", stok, " ", satuan, ")") as nama', false);
        $this->db->order_by('nama_bahan', 'ASC');
        $query = $this->db->get('bahan_baku');
        
        $dropdown = [];
        foreach ($query->result() as $row) {
            $dropdown[$row->id] = $row->nama;
        }
        
        return $dropdown;
    }

    // Update stock
    public function update_stock($id, $jumlah, $operation = 'add') {
        $bahan = $this->get_by_id($id);
        if (!$bahan) {
            return false;
        }

        if ($operation == 'add') {
            $new_stock = $bahan->stok + $jumlah;
        } else {
            $new_stock = $bahan->stok - $jumlah;
        }

        $this->db->where('id', $id);
        return $this->db->update('bahan_baku', ['stok' => $new_stock]);
    }

    // Search bahan baku
    public function search($keyword) {
        $this->db->select('bahan_baku.*, supplier.nama_supplier');
        $this->db->from('bahan_baku');
        $this->db->join('supplier', 'supplier.id = bahan_baku.supplier_id', 'left');
        $this->db->like('bahan_baku.nama_bahan', $keyword);
        $this->db->or_like('supplier.nama_supplier', $keyword);
        $query = $this->db->get();
        return $query->result();
    }

    // Count total bahan
    public function count_bahan() {
        return $this->db->count_all('bahan_baku');
    }

    // Count low stock items
    public function count_low_stock() {
        $this->db->where('stok <=', 'stok_minimum', false);
        return $this->db->count_all_results('bahan_baku');
    }
}

