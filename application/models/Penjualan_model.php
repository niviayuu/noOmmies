<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Get all sales
    public function get_all($limit = null, $offset = 0) {
        $this->db->select('penjualan.*, users.nama_lengkap');
        $this->db->from('penjualan');
        $this->db->join('users', 'users.id = penjualan.user_id', 'left');
        $this->db->order_by('penjualan.tanggal_transaksi', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        $query = $this->db->get();
        return $query->result();
    }

    // Get sale by ID
    public function get_by_id($id) {
        $this->db->select('penjualan.*, users.nama_lengkap');
        $this->db->from('penjualan');
        $this->db->join('users', 'users.id = penjualan.user_id', 'left');
        $this->db->where('penjualan.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    // Get sale with details
    public function get_with_details($id) {
        $penjualan = $this->get_by_id($id);
        
        if ($penjualan) {
            $this->db->select('detail_penjualan.*, produk_jus.nama_produk, produk_jus.kategori, produk_jus.ukuran');
            $this->db->from('detail_penjualan');
            $this->db->join('produk_jus', 'produk_jus.id = detail_penjualan.produk_id');
            $this->db->where('detail_penjualan.penjualan_id', $id);
            $query = $this->db->get();
            $penjualan->details = $query->result();
        }
        
        return $penjualan;
    }

    // Insert new sale (with transaction)
    public function insert($data_penjualan, $data_details) {
        $this->db->trans_start();
        
        // Insert penjualan
        $this->db->insert('penjualan', $data_penjualan);
        $penjualan_id = $this->db->insert_id();
        
        // Insert details
        foreach ($data_details as $detail) {
            $detail['penjualan_id'] = $penjualan_id;
            $this->db->insert('detail_penjualan', $detail);
        }
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            return false;
        }
        
        return $penjualan_id;
    }

    // Update sale
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('penjualan', $data);
    }

    // Delete sale (will also delete details due to CASCADE)
    public function delete($id) {
        // Note: Stock will NOT be restored automatically
        // You need to handle stock restoration manually if needed
        $this->db->where('id', $id);
        return $this->db->delete('penjualan');
    }

    // Get sales by date
    public function get_by_date($date) {
        $this->db->select('penjualan.*, users.nama_lengkap');
        $this->db->from('penjualan');
        $this->db->join('users', 'users.id = penjualan.user_id', 'left');
        $this->db->where('DATE(penjualan.tanggal_transaksi)', $date);
        $this->db->order_by('penjualan.tanggal_transaksi', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    // Get sales by date range
    public function get_by_date_range($start_date, $end_date) {
        $this->db->select('penjualan.*, users.nama_lengkap');
        $this->db->from('penjualan');
        $this->db->join('users', 'users.id = penjualan.user_id', 'left');
        $this->db->where('DATE(penjualan.tanggal_transaksi) >=', $start_date);
        $this->db->where('DATE(penjualan.tanggal_transaksi) <=', $end_date);
        $this->db->order_by('penjualan.tanggal_transaksi', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    // Get total sales value
    public function get_total_sales($start_date = null, $end_date = null) {
        $this->db->select_sum('total_harga');
        
        if ($start_date && $end_date) {
            $this->db->where('DATE(tanggal_transaksi) >=', $start_date);
            $this->db->where('DATE(tanggal_transaksi) <=', $end_date);
        }
        
        $query = $this->db->get('penjualan');
        $result = $query->row();
        return $result->total_harga ? $result->total_harga : 0;
    }

    // Count sales
    public function count_sales($start_date = null, $end_date = null) {
        if ($start_date && $end_date) {
            $this->db->where('DATE(tanggal_transaksi) >=', $start_date);
            $this->db->where('DATE(tanggal_transaksi) <=', $end_date);
            return $this->db->count_all_results('penjualan');
        }
        
        return $this->db->count_all('penjualan');
    }

    // Get best selling products
    public function get_best_selling($limit = 10, $start_date = null, $end_date = null) {
        $this->db->select('produk_jus.nama_produk, produk_jus.kategori, SUM(detail_penjualan.jumlah) as total_terjual, SUM(detail_penjualan.subtotal) as total_pendapatan');
        $this->db->from('detail_penjualan');
        $this->db->join('produk_jus', 'produk_jus.id = detail_penjualan.produk_id');
        $this->db->join('penjualan', 'penjualan.id = detail_penjualan.penjualan_id');
        
        if ($start_date && $end_date) {
            $this->db->where('DATE(penjualan.tanggal_transaksi) >=', $start_date);
            $this->db->where('DATE(penjualan.tanggal_transaksi) <=', $end_date);
        }
        
        $this->db->group_by('detail_penjualan.produk_id');
        $this->db->order_by('total_terjual', 'DESC');
        $this->db->limit($limit);
        
        $query = $this->db->get();
        return $query->result();
    }

    // Get daily sales report
    public function get_daily_report($date = null) {
        if (!$date) {
            $date = date('Y-m-d');
        }
        
        $this->db->select('COUNT(id) as total_transaksi, SUM(total_harga) as total_pendapatan, AVG(total_harga) as rata_rata');
        $this->db->where('DATE(tanggal_transaksi)', $date);
        $query = $this->db->get('penjualan');
        return $query->row();
    }
}

