<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detail_penjualan_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Get all details
    public function get_all() {
        $this->db->select('detail_penjualan.*, produk_jus.nama_produk, penjualan.no_transaksi');
        $this->db->from('detail_penjualan');
        $this->db->join('produk_jus', 'produk_jus.id = detail_penjualan.produk_id');
        $this->db->join('penjualan', 'penjualan.id = detail_penjualan.penjualan_id');
        $query = $this->db->get();
        return $query->result();
    }

    // Get details by sale ID
    public function get_by_penjualan($penjualan_id) {
        $this->db->select('detail_penjualan.*, produk_jus.nama_produk, produk_jus.kategori, produk_jus.ukuran');
        $this->db->from('detail_penjualan');
        $this->db->join('produk_jus', 'produk_jus.id = detail_penjualan.produk_id');
        $this->db->where('detail_penjualan.penjualan_id', $penjualan_id);
        $query = $this->db->get();
        return $query->result();
    }

    // Insert detail
    public function insert($data) {
        return $this->db->insert('detail_penjualan', $data);
    }

    // Delete detail
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('detail_penjualan');
    }

    // Delete all details for a sale
    public function delete_by_penjualan($penjualan_id) {
        $this->db->where('penjualan_id', $penjualan_id);
        return $this->db->delete('detail_penjualan');
    }
}

