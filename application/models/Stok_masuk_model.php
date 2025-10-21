<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stok_masuk_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Get all stock entries
    public function get_all($limit = null, $offset = 0) {
        $this->db->select('stok_masuk.*, bahan_baku.nama_bahan, bahan_baku.satuan, supplier.nama_supplier, users.nama_lengkap');
        $this->db->from('stok_masuk');
        $this->db->join('bahan_baku', 'bahan_baku.id = stok_masuk.bahan_id');
        $this->db->join('supplier', 'supplier.id = stok_masuk.supplier_id', 'left');
        $this->db->join('users', 'users.id = stok_masuk.created_by', 'left');
        $this->db->order_by('stok_masuk.tanggal_masuk', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        $query = $this->db->get();
        return $query->result();
    }

    // Get stock entry by ID
    public function get_by_id($id) {
        $this->db->select('stok_masuk.*, bahan_baku.nama_bahan, bahan_baku.satuan, supplier.nama_supplier, users.nama_lengkap');
        $this->db->from('stok_masuk');
        $this->db->join('bahan_baku', 'bahan_baku.id = stok_masuk.bahan_id');
        $this->db->join('supplier', 'supplier.id = stok_masuk.supplier_id', 'left');
        $this->db->join('users', 'users.id = stok_masuk.created_by', 'left');
        $this->db->where('stok_masuk.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    // Insert new stock entry
    public function insert($data) {
        return $this->db->insert('stok_masuk', $data);
    }

    // Update stock entry
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('stok_masuk', $data);
    }

    // Delete stock entry
    public function delete($id) {
        // First, get the stock entry to reverse the stock update
        $stok = $this->get_by_id($id);
        
        if ($stok) {
            // Reduce the stock back
            $this->db->where('id', $stok->bahan_id);
            $this->db->set('stok', 'stok - ' . $stok->jumlah, false);
            $this->db->update('bahan_baku');
            
            // Delete the entry
            $this->db->where('id', $id);
            return $this->db->delete('stok_masuk');
        }
        
        return false;
    }

    // Get stock entries by date range
    public function get_by_date_range($start_date, $end_date) {
        $this->db->select('stok_masuk.*, bahan_baku.nama_bahan, bahan_baku.satuan, supplier.nama_supplier, users.nama_lengkap');
        $this->db->from('stok_masuk');
        $this->db->join('bahan_baku', 'bahan_baku.id = stok_masuk.bahan_id');
        $this->db->join('supplier', 'supplier.id = stok_masuk.supplier_id', 'left');
        $this->db->join('users', 'users.id = stok_masuk.created_by', 'left');
        $this->db->where('stok_masuk.tanggal_masuk >=', $start_date);
        $this->db->where('stok_masuk.tanggal_masuk <=', $end_date);
        $this->db->order_by('stok_masuk.tanggal_masuk', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    // Get stock entries by supplier
    public function get_by_supplier($supplier_id) {
        $this->db->select('stok_masuk.*, bahan_baku.nama_bahan, bahan_baku.satuan');
        $this->db->from('stok_masuk');
        $this->db->join('bahan_baku', 'bahan_baku.id = stok_masuk.bahan_id');
        $this->db->where('stok_masuk.supplier_id', $supplier_id);
        $this->db->order_by('stok_masuk.tanggal_masuk', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    // Get stock entries by ingredient
    public function get_by_bahan($bahan_id) {
        $this->db->select('stok_masuk.*, supplier.nama_supplier, users.nama_lengkap');
        $this->db->from('stok_masuk');
        $this->db->join('supplier', 'supplier.id = stok_masuk.supplier_id', 'left');
        $this->db->join('users', 'users.id = stok_masuk.created_by', 'left');
        $this->db->where('stok_masuk.bahan_id', $bahan_id);
        $this->db->order_by('stok_masuk.tanggal_masuk', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    // Calculate total purchase value
    public function get_total_purchase($start_date = null, $end_date = null) {
        $this->db->select_sum('total_harga');
        
        if ($start_date && $end_date) {
            $this->db->where('tanggal_masuk >=', $start_date);
            $this->db->where('tanggal_masuk <=', $end_date);
        }
        
        $query = $this->db->get('stok_masuk');
        $result = $query->row();
        return $result->total_harga ? $result->total_harga : 0;
    }

    // Count total stock entries
    public function count_entries() {
        return $this->db->count_all('stok_masuk');
    }

    // Get last input date
    public function get_last_input_date() {
        $this->db->select('tanggal_masuk');
        $this->db->order_by('tanggal_masuk', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('stok_masuk');
        $result = $query->row();
        return $result ? $result->tanggal_masuk : null;
    }
}

