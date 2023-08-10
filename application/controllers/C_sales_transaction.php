<?php
defined('BASEPATH') or exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class C_sales_transaction extends CI_Controller
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
        $this->load->model('M_sales_transaction');
	}

	public function index()
	{
		$data = array(
			'title_form' => 'Report || Sales Details',
			'url_back'   => site_url('C_persentase_karyawan')
		);
		$this->load->view('template/header');
		$this->load->view('sales_transaction/index', $data);		
		$this->load->view('template/footer');
		
	}
	public function ajax_list()
    {
        
            $start  = $_REQUEST['start']; //tambahan limit
            $length = $_REQUEST['length'];
            $params = array();
            if ($this->input->post('txt_tgl_start')) {
                $params['txt_tgl_start'] = $this->input->post('txt_tgl_start');
            }
            if ($this->input->post('txt_tgl_end')) {
                $params['txt_tgl_end'] = $this->input->post('txt_tgl_end');
            }
            if ($this->input->post('txt_nmkary')) {
                $params['txt_nmkary'] = $this->input->post('txt_nmkary');
            }
            if ($this->input->post('txt_status')=='') {
                $params['txt_status'] = 0;
            }elseif($this->input->post('txt_status')==1){
                $params['txt_status'] = 1;
            }elseif($this->input->post('txt_status')==2){
                $params['txt_status'] = 2;
            }elseif($this->input->post('txt_status')==0){
                $params['txt_status'] = 0;
            }
            if ($length != -1) {
                $params['limit'] = $length; //tambahan limit
                $params['start'] = $start;
            }
            $list = $this->M_sales_transaction->get_datatables($params);
            // $params['txt_status'] = intval($this->input->post('txt_status'));
            // die(var_dump( $this->input->post('txt_status')));
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $listdata) {
                $no++;
                $row = array();
                $row[] = $no;
                    if ($this->input->post('txt_tgl_start')=="" && $this->input->post('txt_tgl_end')=="") {

                    $row[] ='Current Month';
                    
                    }elseif($this->input->post('txt_tgl_start')<>"" && $this->input->post('txt_tgl_end')==""){ 

                    $row[] =date('d F Y',strtotime($this->input->post('txt_tgl_start')));

                    }elseif($this->input->post('txt_tgl_start')=="" && $this->input->post('txt_tgl_end')<>""){

                    $row[] ='Until - '.date('d F Y',strtotime($this->input->post('txt_tgl_end')));

                    }elseif($this->input->post('txt_tgl_start')<>"" && $this->input->post('txt_tgl_end')<>""){

                    $row[] =date('d F Y',strtotime($this->input->post('txt_tgl_start'))).' Until '.date('d F Y',strtotime($this->input->post('txt_tgl_end')));

                    }
                    $row[] = $listdata->IDTrans ;
                    $row[] = $listdata->TglTrans;
					$row[] = $listdata->JamTrans;
                    $row[] = $listdata->JthTempo;
                    $row[] = $listdata->KDCust;
                    $row[] = $listdata->NamaCust;
                    $row[] =  $listdata->KDBrg;
                    $row[] = $listdata->NMBrg ;
					$row[] = $listdata->Unit;
                    $row[] = $listdata->QTY;
                    $row[] =  number_format($listdata->HRG_Jual);
                    $row[] =  number_format($listdata->HPP);
                    $row[] =  number_format($listdata->TotPembelian);
                    $row[] =  number_format($listdata->TotalHPP);
                    $row[] =  number_format($listdata->ProfitRP);
                    $row[] =  $listdata->ProfitPersen .'%';
                    $row[] = $listdata->STATUS;
                
                $data[] = $row;
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->M_sales_transaction->count_all($params),
                "recordsFiltered" => $this->M_sales_transaction->count_filtered($params),
                "data" => $data,
            );
        // die(var_dump($output));
        echo json_encode($output);
    }
}