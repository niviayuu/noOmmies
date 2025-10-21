<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        
        $this->load->model('Penjualan_model');
        $this->load->model('Detail_penjualan_model');
        $this->load->model('Produk_jus_model');
        $this->load->model('Notifikasi_model');
    }

    // List all sales
    public function index() {
        $data['title'] = 'Data Penjualan';
        $data['penjualan'] = $this->Penjualan_model->get_all();
        $data['notifications'] = $this->get_notifications();
        $data['unread_count'] = $this->count_unread_notifications();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('penjualan/index', $data);
        $this->load->view('templates/footer');
    }

    // Add new sale form
    public function form() {
        $data['title'] = 'Tambah Penjualan';
        $data['produk_jus'] = $this->Produk_jus_model->get_all();
        $data['notifications'] = $this->get_notifications();
        $data['unread_count'] = $this->count_unread_notifications();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('penjualan/form', $data);
        $this->load->view('templates/footer');
    }

    // Add new sale
    public function tambah() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('tanggal_transaksi', 'Tanggal Transaksi', 'required');
            $this->form_validation->set_rules('metode_pembayaran', 'Metode Pembayaran', 'required');

            if ($this->form_validation->run()) {
                // Get cart data from session
                $cart = $this->session->userdata('cart');
                
                if (!$cart || count($cart) == 0) {
                    $this->session->set_flashdata('error', 'Keranjang kosong! Tambahkan produk terlebih dahulu.');
                    redirect('penjualan/tambah');
                }

                // Calculate total
                $total = 0;
                $details = [];
                
                foreach ($cart as $item) {
                    $subtotal = $item['harga'] * $item['qty'];
                    $total += $subtotal;
                    
                    $details[] = [
                        'produk_id' => $item['produk_id'],
                        'jumlah' => $item['qty'],
                        'harga_satuan' => $item['harga'],
                        'subtotal' => $subtotal
                    ];
                }

                // Prepare sale data
                $data_penjualan = [
                    'tanggal_transaksi' => $this->input->post('tanggal_transaksi'),
                    'total_harga' => $total,
                    'metode_pembayaran' => $this->input->post('metode_pembayaran'),
                    'nama_pembeli' => $this->input->post('nama_pembeli'),
                    'user_id' => $this->user_id,
                    'keterangan' => $this->input->post('keterangan')
                ];

                $penjualan_id = $this->Penjualan_model->insert($data_penjualan, $details);

                if ($penjualan_id) {
                    // Clear cart
                    $this->session->unset_userdata('cart');
                    
                    $this->session->set_flashdata('success', 'Transaksi penjualan berhasil! Stok bahan telah dikurangi otomatis.');
                    redirect('penjualan/detail/' . $penjualan_id);
                } else {
                    $this->session->set_flashdata('error', 'Gagal menyimpan transaksi penjualan!');
                }
            }
        }

        $data['title'] = 'Tambah Penjualan';
        $data['products'] = $this->Produk_jus_model->get_all('active');
        $data['cart'] = $this->session->userdata('cart') ?: [];
        $data['notifications'] = $this->get_notifications();
        $data['unread_count'] = $this->count_unread_notifications();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('penjualan/form', $data);
        $this->load->view('templates/footer');
    }

    // Add product to cart
    public function add_to_cart() {
        $produk_id = $this->input->post('produk_id');
        $qty = $this->input->post('qty') ?: 1;

        $produk = $this->Produk_jus_model->get_by_id($produk_id);

        if (!$produk) {
            echo json_encode(['success' => false, 'message' => 'Produk tidak ditemukan!']);
            return;
        }

        // Check if product can be made
        if (!$this->Produk_jus_model->can_be_made($produk_id, $qty)) {
            echo json_encode(['success' => false, 'message' => 'Stok bahan tidak cukup untuk membuat produk ini!']);
            return;
        }

        // Get current cart
        $cart = $this->session->userdata('cart') ?: [];

        // Check if product already in cart
        $found = false;
        foreach ($cart as &$item) {
            if ($item['produk_id'] == $produk_id) {
                $item['qty'] += $qty;
                $found = true;
                break;
            }
        }

        // If not found, add new item
        if (!$found) {
            $cart[] = [
                'produk_id' => $produk->id,
                'nama_produk' => $produk->nama_produk,
                'harga' => $produk->harga,
                'qty' => $qty
            ];
        }

        // Save to session
        $this->session->set_userdata('cart', $cart);

        echo json_encode(['success' => true, 'message' => 'Produk berhasil ditambahkan ke keranjang!']);
    }

    // Remove from cart
    public function remove_from_cart($index) {
        $cart = $this->session->userdata('cart') ?: [];
        
        if (isset($cart[$index])) {
            unset($cart[$index]);
            $cart = array_values($cart); // Reindex array
            $this->session->set_userdata('cart', $cart);
            $this->session->set_flashdata('success', 'Item berhasil dihapus dari keranjang!');
        }

        redirect('penjualan/tambah');
    }

    // Clear cart
    public function clear_cart() {
        $this->session->unset_userdata('cart');
        $this->session->set_flashdata('success', 'Keranjang berhasil dikosongkan!');
        redirect('penjualan/tambah');
    }

    // Save sale via AJAX
    public function simpan() {
        header('Content-Type: application/json');
        
        try {
            $tanggal_penjualan = $this->input->post('tanggal_penjualan');
            $nama_customer = $this->input->post('nama_customer');
            $no_hp = $this->input->post('no_hp');
            $alamat = $this->input->post('alamat');
            $detail_items = $this->input->post('detail_items');

            if (empty($detail_items) || !is_array($detail_items)) {
                throw new Exception('Detail items tidak boleh kosong');
            }

            // Generate transaction number
            $no_transaksi = 'TRX' . date('Ymd') . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

            // Calculate total
            $total_harga = 0;
            $total_item = 0;
            foreach ($detail_items as $item) {
                $total_harga += $item['subtotal'];
                $total_item += $item['jumlah'];
            }

            // Prepare sale data
            $data_penjualan = [
                'no_transaksi' => $no_transaksi,
                'tanggal_transaksi' => $tanggal_penjualan,
                'nama_pembeli' => $nama_customer,
                'total_harga' => $total_harga,
                'metode_pembayaran' => 'cash',
                'user_id' => $this->session->userdata('user_id'),
                'keterangan' => 'Transaksi dari form penjualan'
            ];

            // Prepare detail items
            $detail_items_data = [];
            foreach ($detail_items as $item) {
                $detail_items_data[] = [
                    'produk_id' => $item['produk_id'],
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $item['harga_satuan'],
                    'subtotal' => $item['subtotal']
                ];
            }

            // Insert sale with details
            $penjualan_id = $this->Penjualan_model->insert($data_penjualan, $detail_items_data);

            if (!$penjualan_id) {
                throw new Exception('Gagal menyimpan data penjualan');
            }

            echo json_encode([
                'success' => true,
                'message' => 'Penjualan berhasil disimpan',
                'penjualan_id' => $penjualan_id
            ]);

        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    // View sale detail
    public function detail($id) {
        $data['penjualan'] = $this->Penjualan_model->get_by_id($id);
        
        if (!$data['penjualan']) {
            $this->session->set_flashdata('error', 'Data penjualan tidak ditemukan!');
            redirect('penjualan');
        }

        // Get detail penjualan with product info
        $this->db->select('detail_penjualan.*, produk_jus.nama_produk');
        $this->db->from('detail_penjualan');
        $this->db->join('produk_jus', 'produk_jus.id = detail_penjualan.produk_id');
        $this->db->where('detail_penjualan.penjualan_id', $id);
        $query = $this->db->get();
        $data['detail_penjualan'] = $query->result();

        $data['title'] = 'Detail Penjualan';
        $data['notifications'] = $this->get_notifications();
        $data['unread_count'] = $this->count_unread_notifications();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('penjualan/detail', $data);
        $this->load->view('templates/footer');
    }

    // Print invoice
    public function invoice($id) {
        $data['penjualan'] = $this->Penjualan_model->get_with_details($id);
        
        if (!$data['penjualan']) {
            $this->session->set_flashdata('error', 'Data penjualan tidak ditemukan!');
            redirect('penjualan');
        }

        $data['title'] = 'Invoice #' . $data['penjualan']->no_transaksi;
        
        $this->load->view('penjualan/invoice', $data);
    }

    // Delete sale
    public function hapus($id) {
        $this->check_role(['admin', 'owner']);

        if ($this->Penjualan_model->delete($id)) {
            $this->session->set_flashdata('success', 'Data penjualan berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data penjualan!');
        }
        redirect('penjualan');
    }

    // Helper methods untuk notifikasi
    private function get_notifications($limit = 5) {
        return $this->Notifikasi_model->get_unread($limit);
    }

    private function count_unread_notifications() {
        return $this->Notifikasi_model->count_unread();
    }
}

