<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Waste_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Get all waste records
    public function get_all($limit = null, $offset = null) {
        $this->db->select('wm.*, wc.nama_kategori, u1.nama_lengkap as created_by_name, u2.nama_lengkap as approved_by_name');
        $this->db->from('waste_management wm');
        $this->db->join('waste_categories wc', 'wm.kategori_id = wc.id', 'left');
        $this->db->join('users u1', 'wm.created_by = u1.id', 'left');
        $this->db->join('users u2', 'wm.approved_by = u2.id', 'left');
        $this->db->order_by('wm.tanggal_waste', 'DESC');
        $this->db->order_by('wm.created_at', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get()->result();
    }

    // Get waste by ID
    public function get_by_id($id) {
        $this->db->select('wm.*, wc.nama_kategori, bb.nama_bahan, pj.nama_produk, u1.nama_lengkap as created_by_name, u2.nama_lengkap as approved_by_name');
        $this->db->from('waste_management wm');
        $this->db->join('waste_categories wc', 'wm.kategori_id = wc.id', 'left');
        $this->db->join('bahan_baku bb', 'wm.bahan_baku_id = bb.id', 'left');
        $this->db->join('produk_jus pj', 'wm.produk_jus_id = pj.id', 'left');
        $this->db->join('users u1', 'wm.created_by = u1.id', 'left');
        $this->db->join('users u2', 'wm.approved_by = u2.id', 'left');
        $this->db->where('wm.id', $id);
        
        return $this->db->get()->row();
    }

    // Insert new waste record
    public function insert($data) {
        $this->db->insert('waste_management', $data);
        return $this->db->insert_id();
    }

    // Update waste record
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('waste_management', $data);
    }

    // Delete waste record
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('waste_management');
    }

    // Get waste categories
    public function get_categories() {
        return $this->db->get('waste_categories')->result();
    }

    // Get waste by status
    public function get_by_status($status) {
        $this->db->select('wm.*, wc.nama_kategori, u1.nama_lengkap as created_by_name');
        $this->db->from('waste_management wm');
        $this->db->join('waste_categories wc', 'wm.kategori_id = wc.id', 'left');
        $this->db->join('users u1', 'wm.created_by = u1.id', 'left');
        $this->db->where('wm.status', $status);
        $this->db->order_by('wm.tanggal_waste', 'DESC');
        
        return $this->db->get()->result();
    }

    // Get waste statistics
    public function get_statistics() {
        $stats = array();
        
        // Total waste records
        $stats['total_waste'] = $this->db->count_all('waste_management');
        
        // Total value of waste
        $this->db->select_sum('total_nilai_waste');
        $result = $this->db->get('waste_management')->row();
        $stats['total_value'] = $result->total_nilai_waste ?: 0;
        
        // Pending waste
        $stats['pending_waste'] = $this->db->where('status', 'pending')->count_all_results('waste_management');
        
        // Approved waste
        $stats['approved_waste'] = $this->db->where('status', 'approved')->count_all_results('waste_management');
        
        // Rejected waste
        $stats['rejected_waste'] = $this->db->where('status', 'rejected')->count_all_results('waste_management');
        
        return $stats;
    }

    // Get waste by date range
    public function get_by_date_range($start_date, $end_date) {
        $this->db->select('wm.*, wc.nama_kategori, u1.nama_lengkap as created_by_name');
        $this->db->from('waste_management wm');
        $this->db->join('waste_categories wc', 'wm.kategori_id = wc.id', 'left');
        $this->db->join('users u1', 'wm.created_by = u1.id', 'left');
        $this->db->where('wm.tanggal_waste >=', $start_date);
        $this->db->where('wm.tanggal_waste <=', $end_date);
        $this->db->order_by('wm.tanggal_waste', 'DESC');
        
        return $this->db->get()->result();
    }

    // Get waste by category
    public function get_by_category($category_id) {
        $this->db->select('wm.*, wc.nama_kategori, u1.nama_lengkap as created_by_name');
        $this->db->from('waste_management wm');
        $this->db->join('waste_categories wc', 'wm.kategori_id = wc.id', 'left');
        $this->db->join('users u1', 'wm.created_by = u1.id', 'left');
        $this->db->where('wm.kategori_id', $category_id);
        $this->db->order_by('wm.tanggal_waste', 'DESC');
        
        return $this->db->get()->result();
    }

    // Approve waste record
    public function approve($id, $approved_by) {
        $data = array(
            'status' => 'approved',
            'approved_by' => $approved_by,
            'approved_at' => date('Y-m-d H:i:s')
        );
        
        $this->db->where('id', $id);
        return $this->db->update('waste_management', $data);
    }

    // Reject waste record
    public function reject($id, $approved_by) {
        $data = array(
            'status' => 'rejected',
            'approved_by' => $approved_by,
            'approved_at' => date('Y-m-d H:i:s')
        );
        
        $this->db->where('id', $id);
        return $this->db->update('waste_management', $data);
    }

    // Get waste disposal records
    public function get_disposal_records($waste_id = null) {
        $this->db->select('wd.*, wm.nama_item, wc.nama_kategori, u.nama_lengkap as disposal_by_name');
        $this->db->from('waste_disposal wd');
        $this->db->join('waste_management wm', 'wd.waste_id = wm.id', 'left');
        $this->db->join('waste_categories wc', 'wm.kategori_id = wc.id', 'left');
        $this->db->join('users u', 'wd.created_by = u.id', 'left');
        
        if ($waste_id) {
            $this->db->where('wd.waste_id', $waste_id);
        }
        
        $this->db->order_by('wd.tanggal_disposal', 'DESC');
        
        return $this->db->get()->result();
    }

    // Insert waste disposal record
    public function insert_disposal($data) {
        $this->db->insert('waste_disposal', $data);
        return $this->db->insert_id();
    }

    // Get monthly waste report
    public function get_monthly_report($year, $month) {
        $this->db->select('wc.nama_kategori, SUM(wm.jumlah_waste) as total_jumlah, SUM(wm.total_nilai_waste) as total_nilai, COUNT(wm.id) as total_record');
        $this->db->from('waste_management wm');
        $this->db->join('waste_categories wc', 'wm.kategori_id = wc.id', 'left');
        $this->db->where('YEAR(wm.tanggal_waste)', $year);
        $this->db->where('MONTH(wm.tanggal_waste)', $month);
        $this->db->where('wm.status', 'approved');
        $this->db->group_by('wc.id');
        $this->db->order_by('total_nilai', 'DESC');
        
        return $this->db->get()->result();
    }

    // Get top waste categories
    public function get_top_categories($limit = 5) {
        $this->db->select('wc.nama_kategori, SUM(wm.total_nilai_waste) as total_nilai, COUNT(wm.id) as total_record');
        $this->db->from('waste_management wm');
        $this->db->join('waste_categories wc', 'wm.kategori_id = wc.id', 'left');
        $this->db->where('wm.status', 'approved');
        $this->db->group_by('wc.id');
        $this->db->order_by('total_nilai', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get()->result();
    }

    // Search waste records
    public function search($keyword) {
        $this->db->select('wm.*, wc.nama_kategori, u1.nama_lengkap as created_by_name');
        $this->db->from('waste_management wm');
        $this->db->join('waste_categories wc', 'wm.kategori_id = wc.id', 'left');
        $this->db->join('users u1', 'wm.created_by = u1.id', 'left');
        $this->db->like('wm.nama_item', $keyword);
        $this->db->or_like('wc.nama_kategori', $keyword);
        $this->db->or_like('wm.alasan_waste', $keyword);
        $this->db->order_by('wm.tanggal_waste', 'DESC');
        
        return $this->db->get()->result();
    }
}
