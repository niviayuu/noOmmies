<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_jus_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Get all products
    public function get_all($status = null) {
        if ($status) {
            $this->db->where('status', $status);
        }
        $this->db->order_by('nama_produk', 'ASC');
        $query = $this->db->get('produk_jus');
        return $query->result();
    }

    // Get product by ID
    public function get_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('produk_jus');
        return $query->row();
    }

    // Get product with recipes
    public function get_with_recipes($id) {
        $produk = $this->get_by_id($id);
        
        if ($produk) {
            $this->db->select('resep_jus.*, bahan_baku.nama_bahan, bahan_baku.stok');
            $this->db->from('resep_jus');
            $this->db->join('bahan_baku', 'bahan_baku.id = resep_jus.bahan_id');
            $this->db->where('resep_jus.produk_id', $id);
            $query = $this->db->get();
            $produk->resep = $query->result();
        }
        
        return $produk;
    }

    // Insert new product
    public function insert($data) {
        return $this->db->insert('produk_jus', $data);
    }

    // Update product
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('produk_jus', $data);
    }

    // Delete product (soft delete)
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->update('produk_jus', ['status' => 'inactive']);
    }

    // Hard delete product
    public function hard_delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('produk_jus');
    }

    // Get dropdown for forms
    public function get_dropdown($status = 'active') {
        $this->db->select('id, CONCAT(nama_produk, " - ", kategori, " (", ukuran, ") - Rp ", FORMAT(harga, 0)) as nama', false);
        $this->db->where('status', $status);
        $this->db->order_by('nama_produk', 'ASC');
        $query = $this->db->get('produk_jus');
        
        $dropdown = [];
        foreach ($query->result() as $row) {
            $dropdown[$row->id] = $row->nama;
        }
        
        return $dropdown;
    }

    // Search products
    public function search($keyword) {
        $this->db->like('nama_produk', $keyword);
        $this->db->or_like('kategori', $keyword);
        $this->db->or_like('deskripsi', $keyword);
        $query = $this->db->get('produk_jus');
        return $query->result();
    }

    // Get products by category
    public function get_by_category($kategori) {
        $this->db->where('kategori', $kategori);
        $this->db->where('status', 'active');
        $this->db->order_by('nama_produk', 'ASC');
        $query = $this->db->get('produk_jus');
        return $query->result();
    }

    // Check if product can be made (enough stock)
    public function can_be_made($produk_id, $quantity = 1) {
        $this->db->select('resep_jus.*, bahan_baku.stok');
        $this->db->from('resep_jus');
        $this->db->join('bahan_baku', 'bahan_baku.id = resep_jus.bahan_id');
        $this->db->where('resep_jus.produk_id', $produk_id);
        $query = $this->db->get();
        $resep = $query->result();
        
        foreach ($resep as $item) {
            if ($item->stok < ($item->jumlah * $quantity)) {
                return false;
            }
        }
        
        return true;
    }

    // Count products
    public function count_products($status = 'active') {
        $this->db->where('status', $status);
        return $this->db->count_all_results('produk_jus');
    }
}

