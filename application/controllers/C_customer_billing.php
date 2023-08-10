<?php
defined('BASEPATH') or exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class C_customer_billing extends CI_Controller
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
        $this->load->model('M_customer_billing');
	}

	public function index()
	{
		$data = array(
			'title_form' => 'Report || Customers Billing',
			'url_back'   => site_url('C_tagihan_karyawan')
		);
		$this->load->view('template/header');
		$this->load->view('customer_billing/index', $data);		
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

            if ($length != -1) {
                $params['limit'] = $length; //tambahan limit
                $params['start'] = $start;
            }
            $list = $this->M_customer_billing->get_datatables($params);
            // $kuya=$this->input->post('txt_status');
            // die(var_dump($kuya));
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
                    $row[] = $listdata->kodecus ;
                    $row[] = $listdata->namacus;
					$row[] =  number_format($listdata->TotPembelian);
                    $row[] =  number_format($listdata->TotBayar);
                    $row[] =  number_format($listdata->TotHutang);                
                $data[] = $row;
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->M_customer_billing->count_all($params),
                "recordsFiltered" => $this->M_customer_billing->count_filtered($params),
                "data" => $data,
            );
        // die(var_dump($output));
        echo json_encode($output);
    }
}