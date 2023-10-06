<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class C_Dpembelian extends CI_Controller
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
        $this->load->model('M_Dpembelian');
    }
    public function index()
    {
        $data = array(
            'title_form' => 'Pembelian',
            'url_back'   => site_url('C_pembelian')
        );
        $data['datasat'] = $this->M_satuan->getdata();
        $data['databarang'] = $this->M_masterbarang->getdata();
        $data['datasup'] = $this->M_suplier->getdata();
        $data['datakelompok'] = $this->M_kelompokbarang->getdata();
        $data['Epembelian'] = $this->M_Epembelian->getdata();
        $data['sum'] = $this->M_Epembelian->get_sum();

        $this->load->view('template/header');
        $this->load->view('pembelian/index', $data);
        $this->load->view('template/footer');
    }
    public function ajax_detailbeli($id_pembelian)
    {
        $data = $this->M_pembelian->get_by_id($id_pembelian);
        echo json_encode($data);
    }

    public function ajax_list_pembelian()
    {
        $start  = $_REQUEST['start']; //tambahan limit
        $length = $_REQUEST['length'];
        $params = array();
        if ($this->input->post('id_pembelian')) {
            $params['id_pembelian'] = $this->input->post('id_pembelian');
        }
        if ($length != -1) {
            $params['limit'] = $length; //tambahan limit
            $params['start'] = $start;
        }

        $list = $this->M_Dpembelian->get_datatables($params);
        $data = array();
        foreach ($list as $listdata) {
            $row = array();
            $row[] = $listdata->kode_beli;
            $row[] = $listdata->faktur_beli;
            $row[] = $listdata->tgl_faktur;
            $row[] = $listdata->diskon;
            $row[] = $listdata->g_total;
            $row[] = $listdata->metode;
            $row[] = '<a class="btn btn-pill btn-outline-primary btn-air-success btn-xs" href="javascript:void(0)" title="Recovery Data" onclick="detailbeli(' . "'" . $listdata->id_pembelian . "'" . ')"><i class="fa fa-search"></i> </a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_pembelian->count_all($params),
            "recordsFiltered" => $this->M_pembelian->count_filtered($params),
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
        if ($this->input->post('pembelian')) {
            $params['pembelian'] = $this->input->post('pembelian');
        }
        if ($length != -1) {
            $params['limit'] = $length; //tambahan limit
            $params['start'] = $start;
        }

        $list = $this->M_pembelian->get_datatabless($params);
        $data = array();
        foreach ($list as $listdata) {
            $row = array();
            $row[] = $listdata->id_pembelian;
            $row[] = $listdata->id_barang;
            $row[] = $listdata->kode_detail;
            $row[] = $listdata->qty;
            $row[] = $listdata->total;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_Dpembelian->count_all($params),
            "recordsFiltered" => $this->M_Dpembelian->count_filtered($params),
            "data" => $data,
        );
        // die(var_dump($output));
        echo json_encode($output);
    }
}
