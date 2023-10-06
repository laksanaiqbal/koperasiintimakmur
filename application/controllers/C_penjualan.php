<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class C_penjualan extends CI_Controller
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
        $this->load->model('M_Dpenjualan');
        $this->load->model('M_customer');
        $this->load->model('M_penjualan');
        $this->load->model('M_detailpenjualan');
    }
    public function index()
    {
        $data = array(
            'title_form' => 'penjualan',
            'url_back'   => site_url('C_penjualan')
        );
        $data['datasat'] = $this->M_satuan->getdata();
        $data['databarang'] = $this->M_masterbarang->getdata();
        $data['datasup'] = $this->M_suplier->getdata();
        $data['datakelompok'] = $this->M_kelompokbarang->getdata();
        $data['Epenjualan'] = $this->M_penjualan->getdata();
        $data['sum'] = $this->M_penjualan->get_sum();
        $data['datacus'] = $this->M_customer->getdata();


        $this->load->view('template/header');
        $this->load->view('penjualan/index', $data);
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

        $list = $this->M_Dpenjualan->get_datatables($params);
        // $kuya=$this->input->post('txt_status');
        // die(var_dump($list));
        $data = array();
        foreach ($list as $listdata) {
            $row = array();
            $row[] = $listdata->invoice;
            $row[] = $listdata->USER_NAME;
            $row[] = $listdata->namacus;
            $row[] = $listdata->ppn;
            $row[] = $listdata->g_total;
            $row[] = $listdata->metode;
            $row[] = $listdata->tgl;
            $row[] = '<a class="btn btn-pill btn-outline-primary btn-air-primary btn-xs" href="javascript:void(0)" title="Detail Beli" onclick="detail(' . "'" . $listdata->id_penjualan . "'" . ')"><i class="fa fa-search"></i> </a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_Dpenjualan->count_all($params),
            "recordsFiltered" => $this->M_Dpenjualan->count_filtered($params),
            "data" => $data,
        );
        // die(var_dump($output));
        echo json_encode($output);
    }
    public function ajax_list_detail()
    {
        $start  = $_REQUEST['start']; //tambahan limit
        $length = $_REQUEST['length'];
        $params = array();
        if ($this->input->post('txt_transID')) {
            $params['txt_transID'] = $this->input->post('txt_transID');
        }
        if ($length != -1) {
            $params['limit'] = $length; //tambahan limit
            $params['start'] = $start;
        }
        $list = $this->M_detailpenjualan->get_datatables($params);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $listdata) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $listdata->kode_detail;
            $row[] = $listdata->barcode;
            $row[] = $listdata->namabrg;
            $row[] = $listdata->hbeli1;
            $row[] = $listdata->hjual1;
            $row[] = $listdata->qty;
            $row[] = $listdata->total;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_detailpenjualan->count_all(),
            "recordsFiltered" => $this->M_detailpenjualan->count_filtered($params),
            "data" => $data,
        );
        echo json_encode($output);
        // exit;
    }


    public function ajax_list_showbarang()
    {
        $start  = $_REQUEST['start']; //tambahan limit
        $length = $_REQUEST['length'];
        $params = array();
        if ($this->input->post('txt_transID')) {
            $params['txt_transID'] = $this->input->post('txt_transID');
        }
        if ($length != -1) {
            $params['limit'] = $length; //tambahan limit
            $params['start'] = $start;
        }
        $list = $this->M_masterbarang->get_datatabless($params);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $listdata) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $listdata->kodebrg;
            $row[] = $listdata->barcode;
            $row[] = $listdata->namabrg;
            $row[] = $listdata->hpp;
            $row[] = $listdata->hjual1;
            $row[] = '<a href="javascript:void(0)" class="btn btn-primary btn-xs" data-bs-dismiss="modal" title="Pilih Data" onclick="pilihbarang(' . "'" . $listdata->kodebrg . "'" . ')"><i class="fa fa-check-square-o"></i> Select</a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_masterbarang->count_all(),
            "recordsFiltered" => $this->M_masterbarang->count_filtered($params),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function ajax_detail($id_penjualan)
    {
        $data = $this->M_detailpenjualan->get_by_id($id_penjualan);
        echo json_encode($data);
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
