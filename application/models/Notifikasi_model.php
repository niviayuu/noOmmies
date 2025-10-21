<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifikasi_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Get all notifications
    public function get_all($status = null, $limit = null) {
        if ($status) {
            $this->db->where('status', $status);
        }
        $this->db->order_by('created_at', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit);
        }
        
        $query = $this->db->get('notifikasi');
        return $query->result();
    }

    // Get notification by ID
    public function get_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('notifikasi');
        return $query->row();
    }

    // Get notifications by type
    public function get_by_type($tipe, $status = null) {
        $this->db->where('tipe', $tipe);
        if ($status) {
            $this->db->where('status', $status);
        }
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('notifikasi');
        return $query->result();
    }

    // Get unread notifications
    public function get_unread($limit = null) {
        $this->db->where('status', 'unread');
        $this->db->order_by('created_at', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit);
        }
        
        $query = $this->db->get('notifikasi');
        return $query->result();
    }

    // Get read notifications
    public function get_read($limit = null) {
        $this->db->where('status', 'read');
        $this->db->order_by('created_at', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit);
        }
        
        $query = $this->db->get('notifikasi');
        return $query->result();
    }

    // Insert new notification
    public function insert($data) {
        return $this->db->insert('notifikasi', $data);
    }

    // Mark as read
    public function mark_as_read($id) {
        $this->db->where('id', $id);
        return $this->db->update('notifikasi', ['status' => 'read']);
    }

    // Mark all as read
    public function mark_all_as_read() {
        $this->db->where('status', 'unread');
        return $this->db->update('notifikasi', ['status' => 'read']);
    }

    // Delete notification
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('notifikasi');
    }

    // Delete old notifications (older than X days)
    public function delete_old($days = 30) {
        $this->db->where('created_at <', date('Y-m-d H:i:s', strtotime("-{$days} days")));
        return $this->db->delete('notifikasi');
    }

    // Count unread notifications
    public function count_unread() {
        $this->db->where('status', 'unread');
        return $this->db->count_all_results('notifikasi');
    }

    // Generate stock low notifications
    public function generate_stock_notifications() {
        // Get low stock items
        $this->db->select('id, nama_bahan, stok, satuan, stok_minimum');
        $this->db->where('stok <=', 'stok_minimum', false);
        $query = $this->db->get('bahan_baku');
        $low_stock_items = $query->result();
        
        foreach ($low_stock_items as $item) {
            // Check if notification already exists today
            $this->db->where('tipe', 'stok_menipis');
            $this->db->like('pesan', $item->nama_bahan);
            $this->db->where('DATE(created_at)', date('Y-m-d'));
            $exists = $this->db->count_all_results('notifikasi');
            
            if ($exists == 0) {
                $data = [
                    'tipe' => 'stok_menipis',
                    'judul' => 'Stok Bahan Menipis!',
                    'pesan' => "Bahan '{$item->nama_bahan}' tersisa {$item->stok} {$item->satuan}. Stok minimum: {$item->stok_minimum} {$item->satuan}. Segera lakukan pembelian!",
                    'status' => 'unread'
                ];
                $this->insert($data);
            }
        }
    }

    // Generate expiry notifications
    public function generate_expiry_notifications($days = 3) {
        // Get items near expiry
        $this->db->select('id, nama_bahan, tanggal_expired, DATEDIFF(tanggal_expired, CURDATE()) as hari_tersisa', false);
        $this->db->where('tanggal_expired IS NOT NULL');
        $this->db->where('DATEDIFF(tanggal_expired, CURDATE()) <=', $days);
        $this->db->where('DATEDIFF(tanggal_expired, CURDATE()) >=', 0);
        $query = $this->db->get('bahan_baku');
        $expiring_items = $query->result();
        
        foreach ($expiring_items as $item) {
            // Check if notification already exists today
            $this->db->where('tipe', 'expired');
            $this->db->like('pesan', $item->nama_bahan);
            $this->db->where('DATE(created_at)', date('Y-m-d'));
            $exists = $this->db->count_all_results('notifikasi');
            
            if ($exists == 0) {
                $data = [
                    'tipe' => 'expired',
                    'judul' => 'Bahan Mendekati Expired!',
                    'pesan' => "Bahan '{$item->nama_bahan}' akan expired dalam {$item->hari_tersisa} hari (tanggal: {$item->tanggal_expired}). Segera gunakan atau buang!",
                    'status' => 'unread'
                ];
                $this->insert($data);
            }
        }
    }

    // Generate reminder notification
    public function generate_reminder($message) {
        $data = [
            'tipe' => 'pengingat_input',
            'judul' => 'Pengingat Input Bahan',
            'pesan' => $message,
            'status' => 'unread'
        ];
        return $this->insert($data);
    }
}

