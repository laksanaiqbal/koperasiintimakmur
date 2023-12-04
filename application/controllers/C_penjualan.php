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
        $this->load->model('M_daftardepartemen');
    }
    public function index()
    {
        $data = array(
            'title_form' => '<i class="fa fa-arrow-circle-right"></i> Penjualan',
            'url_back'   => site_url('C_penjualan')
        );
        $data['datasat'] = $this->M_satuan->getdata();
        $data['databarang'] = $this->M_masterbarang->getdata();
        $data['datasup'] = $this->M_suplier->getdata();
        $data['datakelompok'] = $this->M_kelompokbarang->getdata();
        $data['Epenjualan'] = $this->M_penjualan->getdata();
        $data['sum'] = $this->M_penjualan->get_sum();
        $data['datacus'] = $this->M_customer->getdata();
        $data['datacabang'] = $this->M_daftardepartemen->getdata();



        $this->load->view('template/header');
        $this->load->view('penjualan/index', $data);
        $this->load->view('template/footer');
    }

    public function ajax_list()
    {
        $start  = $_REQUEST['start']; //tambahan limit
        $length = $_REQUEST['length'];
        $params = array();
        if ($this->input->post('nojual')) {
            $params['nojual'] = $this->input->post('nojual');
        }
        if ($this->input->post('kodecus')) {
            $params['kodecus'] = $this->input->post('kodecus');
        }
        if ($this->input->post('txt_tgl_start')) {
            $params['txt_tgl_start'] = $this->input->post('txt_tgl_start');
        }
        if ($this->input->post('txt_tgl_end')) {
            $params['txt_tgl_end'] = $this->input->post('txt_tgl_end');
        }

        if ($length != -1) {
            $params['limit'] = $length; //tambahan limit
            $params['start'] = $start;
        }

        $list = $this->M_Dpenjualan->get_datatables($params);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $listdata) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $listdata->nojual;
            $row[] = $listdata->namacus;
            $row[] = $listdata->jenis;
            $row[] = $listdata->tanggal;
            $row[] = $listdata->jam;
            $row[] = $listdata->subtotal;
            $row[] = '<a class="btn btn-pill btn-outline-warning btn-air-warning btn-xs" href="javascript:void(0)" title="Detail Beli" onclick="detail(' . "'" . $listdata->nojual . "'" . ')"><i class="fa fa-toggle-down"></i> </a>';
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
            $row[] = $listdata->iddjual;
            $row[] = $listdata->namabrg;
            $row[] = $listdata->hjual1;
            $row[] = $listdata->qtyjual;
            $row[] = $listdata->brutto;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_detailpenjualan->count_all($params),
            "recordsFiltered" => $this->M_detailpenjualan->count_filtered($params),
            "data" => $data,
        );
        // die(var_dump($output));
        echo json_encode($output);
    }
    public function ajax_list_Epenjualan()
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
        $list = $this->M_penjualan->get_datatables($params);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $listdata) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $listdata->iddjual;
            $row[] = $listdata->namabrg;
            $row[] = $listdata->hjual1;
            $row[] = $listdata->qtyjual;
            $row[] = $listdata->brutto;
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
    public function ajax_detail($iddjual)
    {
        $data = $this->M_detailpenjualan->get_by_id($iddjual);
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
        $this->form_validation->set_rules('namacust', 'Input Customer');


        if ($this->form_validation->run() == false) {
            $out['is_error']       = true;
            $out['error_message']  = validation_errors();
        } else {

            $this->db->select("RIGHT (inv.hjual.nojual, 7) as nojual", false);
            $this->db->order_by("nojual", "DESC");
            $this->db->limit(1);
            $query = $this->db->get('hjual');
            if ($query->num_rows() <> 0) {
                $data = $query->row();
                $kode = intval($data->nojual) + 1;
            } else {
                $kode = 1;
            }
            date_default_timezone_set('Asia/Jakarta');
            // $kodeinvoice = "POS" . date('YmdHis');
            $kode_jual = str_pad($kode, 7, "0", STR_PAD_LEFT);
            $total = $this->input->post('total');
            $bayar = $this->input->post('bayar');
            $kembalian = $bayar - $total;
            $save_data = array(
                // 'id_user' => $this->session->userdata('ID'),
                // 'invoice' => $kodeinvoice,
                'kodecus' => $post_data['namacust'],
                'subtotal' => $post_data['total'],
                'jenis' => $post_data['payments'],
                'bayar' => $post_data['bayar'],
                'idcabang' => $post_data['cabangs'],
                'sisabayar' => $kembalian,
                'tanggal' => date('Y-m-d'),
                'jam' => date('H:i:s'),
            );
            $this->M_penjualan->save_penjualan($save_data);

            $idjual = "select max(nojual) as nojual from hjual";
            $id = implode($this->db->query($idjual)->row_array());
            $sql = "update djual set nojual = '$id' where nojual='0'";
            $this->db->query($sql);

            $idcabang = "select max(idcabang) as idcabang from hjual";
            $idss = implode($this->db->query($idcabang)->row_array());
            $sqlss = "update djual set idcabang = '$idss' where idcabang='0'";
            $this->db->query($sqlss);

            $idcus = "select max(kodecus) as kodecus from hjual";
            $ids = implode($this->db->query($idcus)->row_array());
            $sqls = "update djual set kodecus = '$ids' where kodecus='0'";
            $this->db->query($sqls);

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
            $microtime = substr((string)microtime(), 1, 8);
            $date = trim($microtime, ".");
            $qty = $this->input->post('jumlah');
            $hjual = $this->input->post('hjual');
            $total = $qty * $hjual;
            $save_data = array(
                'unit' => $post_data['layanan'],
                'kodebrg' => $post_data['kodebrg'],
                'hjual1' => $post_data['hjual'],
                'qtyjual' => $post_data['jumlah'],
                'brutto' => $total,
                'tanggal' => date('Y-m-d'),
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
}
