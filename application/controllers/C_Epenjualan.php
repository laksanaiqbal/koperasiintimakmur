<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class C_Epenjualan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //check user login
        if ($this->session->userdata('IS_LOGIN') == FALSE) {
            redirect('auth');
        }
        $this->load->library('pdf');
        $this->load->library('encryption');
        $this->load->model('M_satuan');
        $this->load->model('M_suplier');
        $this->load->model('M_masterbarang');
        $this->load->model('M_kelompokbarang');
        $this->load->model('M_pembelian');
        $this->load->model('M_customer');
        $this->load->model('M_penjualan');
        $this->load->model('M_detailpenjualan');
    }
    public function index()
    {
        $data = array(
            'title_form' => 'Entry Penjualan',
            'url_back'   => site_url('C_Epenjualan')
        );
        $data['datasat'] = $this->M_satuan->getdata();
        $data['databarang'] = $this->M_masterbarang->getdata();
        $data['datacus'] = $this->M_customer->getdata();
        $data['datasup'] = $this->M_suplier->getdata();
        $data['datakelompok'] = $this->M_kelompokbarang->getdata();
        $data['pembelian'] = $this->M_pembelian->getdata();
        $data['sum'] = $this->M_penjualan->get_sum();

        $this->load->view('template/header');
        $this->load->view('Epenjualan/index', $data);
        $this->load->view('template/footer');
    }


    public function ajax_list()
    {
        $start  = $_REQUEST['start']; //tambahan limit
        $length = $_REQUEST['length'];
        $params = array();
        if ($this->input->post('txt_nmkary')) {
            $params['txt_nmkary'] = $this->input->post('txt_nmkary');
        }
        if ($length != -1) {
            $params['limit'] = $length; //tambahan limit
            $params['start'] = $start;
        }

        $list = $this->M_penjualan->get_datatables($params);
        // $kuya=$this->input->post('txt_status');
        // die(var_dump($list));
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $listdata) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $listdata->id_detail;
            $row[] = $listdata->id_jual;
            $row[] = $listdata->namabrg;
            $row[] = $listdata->kode_detail;
            $row[] = $listdata->hjual;
            $row[] = $listdata->qty;
            $row[] = $listdata->total;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_penjualan->count_all($params),
            "recordsFiltered" => $this->M_penjualan->count_filtered($params),
            "data" => $data,
        );
        // die(var_dump($output));
        echo json_encode($output);
    }
    public function ajax_list_detail($id_jual)
    {
        $list = $this->M_penjualan->get_detail($id_jual);
        // $kuya=$this->input->post('txt_status');
        die(var_dump($list));
        $data = array();
        foreach ($list as $listdata) {
            $row = array();
            $row[] = $listdata->kode_detail;
            $row[] = $listdata->barcode;
            $row[] = $listdata->namabrg;
            $row[] = $listdata->harga_beli;
            $row[] = $listdata->harga_jual;
            $row[] = $listdata->qty;
            $row[] = $listdata->total;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_penjualan->count_all($params),
            "recordsFiltered" => $this->M_penjualan->count_filtered($params),
            "data" => $data,
        );
        // die(var_dump($output));
        echo json_encode($output);
    }

    public function input_proses()
    {
        $post_data  = $this->input->post();
        $this->form_validation->set_rules('layanan', 'Input Layanan', 'required');
        $this->form_validation->set_rules('kodebrg', 'Input Kode');
        $this->form_validation->set_rules('hjual', 'Input hargajual', 'required');
        $this->form_validation->set_rules('jumlah', 'Input jumlah', 'required');
        $this->form_validation->set_rules('stokbaru', 'Input Stokbaru', 'required');


        if ($this->form_validation->run() == false) {
            $out['is_error']       = true;
            $out['error_message']  = validation_errors();
        } else {
            $kodebrg = $this->input->post('kodebrg');
            $qty = $this->input->post('jumlah');
            $hjual = $this->input->post('hjual');
            $total = $qty * $hjual;
            $save_data = array(
                'id_servis' => $post_data['layanan'],
                'id_barang' => $post_data['kodebrg'],
                'kode_detail' => 'DJ' . $kodebrg,
                'hjual' => $post_data['hjual'],
                'qty' => $post_data['jumlah'],
                'total' => $total,
            );

            $this->M_penjualan->save($save_data);
            $save_stok = array(
                'stokawal' => $post_data['stokbaru'],
            );

            $this->M_masterbarang->update_stok(array('kodebrg' => $this->input->post('kodebrg')), $save_stok);

            if ($this->db->trans_status() == FALSE) {
                $this->db->trans_rollback();
                $out['is_error']       = False;
                $out['error_message']  = "database error";
            } else {
                $this->db->trans_commit();
                $out['is_error']       = false;
                $out['succes_message']  = "Good luck Bro, Input data berhasil";
            }
        }
        //Save Master Barang Logs

        echo json_encode($out);
    }
    public function simpan_penjualan()
    {
        $post_data  = $this->input->post();

        $this->form_validation->set_rules('diskon', 'Input Diskon');
        $this->form_validation->set_rules('total', 'Input total', 'required');
        $this->form_validation->set_rules('metode', 'Input metode', 'required');
        $this->form_validation->set_rules('bayar', 'Input Bayar', 'required');
        $this->form_validation->set_rules('kembalian', 'Input kembalian');


        if ($this->form_validation->run() == false) {
            $out['is_error']       = true;
            $out['error_message']  = validation_errors();
        } else {

            $this->db->select("RIGHT (inv.penjualan.kode_jual, 7) as kode_jual", false);
            $this->db->order_by("kode_jual", "DESC");
            $this->db->limit(1);
            $query = $this->db->get('penjualan');
            if ($query->num_rows() <> 0) {
                $data = $query->row();
                $kode = intval($data->kode_jual) + 1;
            } else {
                $kode = 1;
            }
            date_default_timezone_set('Asia/Jakarta');
            $kodeinvoice = "POS" . date('YmdHis');
            $kode_jual = str_pad($kode, 7, "0", STR_PAD_LEFT);
            $total = $this->input->post('total');
            $bayar = $this->input->post('bayar');
            $kembalian = $bayar - $total;
            $save_data = array(
                'kode_jual' => 'KJ-' . $kode_jual,
                'id_user' => $this->session->userdata('ID'),
                'invoice' => $kodeinvoice,
                'id_karyawan' => $post_data['namacus'],
                'g_total' => $post_data['total'],
                'metode' => $post_data['metode'],
                'bayar' => $post_data['bayar'],
                'kembalian' => $kembalian,
                'tgl' => date('Y-m-d H:i:s'),
            );
            $this->M_penjualan->save_penjualan($save_data);

            $idjual = "select max(id_penjualan) as id_penjualan from penjualan";
            $id = implode($this->db->query($idjual)->row_array());
            $sql = "update detail_penjualan set id_jual = '$id' where id_jual='0'";
            $this->db->query($sql);
            if ($this->db->trans_status() == FALSE) {
                $this->db->trans_rollback();
                $out['is_error']       = False;
                $out['error_message']  = "database error";
            } else {
                $this->db->trans_commit();
                $out['is_error']       = false;
                $out['succes_message']  = "Good luck Bro, Input data berhasil";
            }
        }
        //Save Master Barang Logs

        echo json_encode($out);
    }
}
