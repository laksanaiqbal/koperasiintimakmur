<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class C_stok extends CI_Controller
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
        $this->load->model('M_stock');
    }

    public function index()
    {
        $data = array(
            'title_form' => ' <i class="fa fa-arrow-circle-right"></i> Items Stock',
            'url_back'   => site_url('C_stok')
        );
        $this->load->view('template/header');
        $this->load->view('stok/index', $data);
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
        $list = $this->M_stock->get_datatables($params);
        // $kuya=$this->input->post('txt_status');
        // die(var_dump($list));
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $listdata) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $listdata->kodebrg;
            $row[] = $listdata->namabrg;
            $row[] = $listdata->stokawal;
            $row[] = $listdata->stokmin;
            $row[] = ($listdata->stokmax);
            $row[] = ($listdata->stokakhir);
            $row[] = ($listdata->namasat);
            $row[] = number_format($listdata->hpp);
            $row[] = number_format($listdata->hjual1);
            $row[] = number_format($listdata->profit);
            $row[] = number_format($listdata->TotAsset);

            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_stock->count_all($params),
            "recordsFiltered" => $this->M_stock->count_filtered($params),
            "data" => $data,
        );
        // die(var_dump($output));
        echo json_encode($output);
    }
}
