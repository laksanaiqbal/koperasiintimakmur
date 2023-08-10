<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class C_customer extends CI_Controller
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
        $this->load->model('M_customer');
    }

    public function index()
    {
        $data = array(
            'title_form' => 'Report || customer',
            'url_back'   => site_url('C_customer')
        );
        $this->load->view('template/header');
        $this->load->view('customer/index', $data);
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
        $list = $this->M_customer->get_datatables($params);
        // $kuya=$this->input->post('txt_status');
        // die(var_dump($list));
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $listdata) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $listdata->kodecus;
            $row[] = $listdata->namacus;
            $row[] = $listdata->alamat;
            $row[] = $listdata->kota;
            $row[] = $listdata->hp;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_customer->count_all($params),
            "recordsFiltered" => $this->M_customer->count_filtered($params),
            "data" => $data,
        );
        // die(var_dump($output));
        echo json_encode($output);
    }
}
