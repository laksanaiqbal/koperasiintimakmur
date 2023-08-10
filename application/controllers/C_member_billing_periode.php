<?php
defined('BASEPATH') or exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class C_member_billing_periode extends CI_Controller
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
        $this->load->model('M_member_billing_periode');
	}

	public function index()
	{
		$data = array(
			'title_form' => 'Report || My Billing',
			'url_back'   => site_url('C_member_billing_periode')
		);
		$this->load->view('template/header_member');
		$this->load->view('member_billing_periode/index', $data);		
		$this->load->view('template/footer');
		
	}
	public function ajax_list()
    {
            $start  = $_REQUEST['start']; //tambahan limit
            $length = $_REQUEST['length'];
            $params = array();
            if ($this->input->post('txt_cari_bln')) {
                $params['txt_cari_bln'] = $this->input->post('txt_cari_bln');
            }
            if ($this->input->post('txt_cari_thn')) {
                $params['txt_cari_thn'] = $this->input->post('txt_cari_thn');
            }           

            if ($length != -1) {
                $params['limit'] = $length; //tambahan limit
                $params['start'] = $start;
            }
            $list = $this->M_member_billing_periode->get_datatables($params);
            // $kuya=$this->input->post('txt_cari_bln');
            // die(var_dump($kuya));
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $listdata) {
                $row = array();
					$row[] =  '<a class="btn btn-pill btn-outline-info btn-air-info btn-xs" href="javascript:void(0)" title="Hmmm , Gw Beli Apaan Aja Ya !!!???" onclick="view_details(' . "'" . $listdata->kodecus . "'" . ')">'.number_format($listdata->TotPembelian).'
                         </a>';
                    $row[] =  number_format($listdata->TotBayar);
                    $row[] =  '<a class="btn btn-pill btn-outline-info btn-air-info btn-xs" title="Ternyata Baru Segini Total Hutang Gwa!!!">'.number_format($listdata->TotHutang).'
                         </a>';                
                $data[] = $row;
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->M_member_billing_periode->count_all($params),
                "recordsFiltered" => $this->M_member_billing_periode->count_filtered($params),
                "data" => $data,
            );
        // die(var_dump($output));
        echo json_encode($output);
    }
     public function ajax_purch_details($id)
    {
        $data = $this->M_member_billing_periode->get_detail_kodecus($id);
        echo json_encode($data);
    }
    public function ajax_list_detail()
    {
            $start  = $_REQUEST['start']; //tambahan limit
            $length = $_REQUEST['length'];
            $params = array();
             if ($this->input->post('bulan_temp')) {
                $params['bulan_temp'] = $this->input->post('bulan_temp');
            }
            if ($this->input->post('txt_year_periode')) {
                $params['txt_year_periode'] = $this->input->post('txt_year_periode');
            }           

            if ($length != -1) {
                $params['limit'] = $length; //tambahan limit
                $params['start'] = $start;
            }
            $list = $this->M_member_billing_periode->get_datatables_detail($params);
            // $kuya=$this->input->post('txt_status');
            // die(var_dump($kuya));
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $listdata) {
                $no++;
                $row = array();
                $row[] = $no;                    
                    // $row[] = $listdata->IDTrans ;
                    $row[] = $listdata->TglTrans;
					// $row[] =  $listdata->KDBrg;
                    $row[] =  $listdata->NMBrg;
                    $row[] =  $listdata->Unit;
                    $row[] =  $listdata->QTY;
                    $row[] =  number_format($listdata->HRG_Jual);
                    $row[] =  number_format($listdata->TotPembelian);                
                $data[] = $row;
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->M_member_billing_periode->count_all_detail($params),
                "recordsFiltered" => $this->M_member_billing_periode->count_filtered_detail($params),
                "data" => $data,
            );
        // die(var_dump($output));
        echo json_encode($output);
    }
}