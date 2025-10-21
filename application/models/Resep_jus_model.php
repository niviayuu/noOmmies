<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resep_jus_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Get all recipes with details
    public function get_all() {
        $this->db->select('resep_jus.*, produk_jus.nama_produk, bahan_baku.nama_bahan, bahan_baku.stok');
        $this->db->from('resep_jus');
        $this->db->join('produk_jus', 'produk_jus.id = resep_jus.produk_id');
        $this->db->join('bahan_baku', 'bahan_baku.id = resep_jus.bahan_id');
        $this->db->order_by('produk_jus.nama_produk', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    // Get recipe by ID
    public function get_by_id($id) {
        $this->db->select('resep_jus.*, produk_jus.nama_produk, bahan_baku.nama_bahan');
        $this->db->from('resep_jus');
        $this->db->join('produk_jus', 'produk_jus.id = resep_jus.produk_id');
        $this->db->join('bahan_baku', 'bahan_baku.id = resep_jus.bahan_id');
        $this->db->where('resep_jus.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    // Get recipes by product ID
    public function get_by_produk($produk_id) {
        $this->db->select('resep_jus.*, bahan_baku.nama_bahan, bahan_baku.satuan, bahan_baku.stok');
        $this->db->from('resep_jus');
        $this->db->join('bahan_baku', 'bahan_baku.id = resep_jus.bahan_id');
        $this->db->where('resep_jus.produk_id', $produk_id);
        $query = $this->db->get();
        return $query->result();
    }

    // Get recipes by ingredient ID
    public function get_by_bahan($bahan_id) {
        $this->db->select('resep_jus.*, produk_jus.nama_produk');
        $this->db->from('resep_jus');
        $this->db->join('produk_jus', 'produk_jus.id = resep_jus.produk_id');
        $this->db->where('resep_jus.bahan_id', $bahan_id);
        $query = $this->db->get();
        return $query->result();
    }

    // Insert new recipe
    public function insert($data) {
        return $this->db->insert('resep_jus', $data);
    }

    // Update recipe
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('resep_jus', $data);
    }

    // Delete recipe
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('resep_jus');
    }

    // Delete all recipes for a product
    public function delete_by_produk($produk_id) {
        $this->db->where('produk_id', $produk_id);
        return $this->db->delete('resep_jus');
    }

    // Check if recipe exists
    public function exists($produk_id, $bahan_id, $exclude_id = null) {
        $this->db->where('produk_id', $produk_id);
        $this->db->where('bahan_id', $bahan_id);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        $query = $this->db->get('resep_jus');
        return $query->num_rows() > 0;
    }

    // Get total recipes
    public function count_recipes() {
        return $this->db->count_all('resep_jus');
    }
}

