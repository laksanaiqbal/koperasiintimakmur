<?php
defined('BASEPATH') or exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class C_sales_items extends CI_Controller
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
        $this->load->model('M_sales_items');
	}

	public function index()
	{
		$data = array(
			'title_form' => 'Report || Sales By Item',
			'url_back'   => site_url('C_sales_items')
		);
		$this->load->view('template/header');
		$this->load->view('sales_items/index', $data);		
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
            $list = $this->M_sales_items->get_datatables($params);
            // $kuya=$this->input->post('txt_status');
            // die(var_dump($list));
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
                    $row[] = $listdata->kodebrg ;
                    $row[] = $listdata->namabrg;
					// $row[] = number_format($listdata->HPPRata);
                    // $row[] = number_format($listdata->HrgJualRata);
                    $row[] = $listdata->namasat;
                    $row[] = $listdata->QTYJual;
                    $row[] = number_format($listdata->TotModalHPP);
                    $row[] = number_format($listdata->TotJual);
                    $row[] = number_format($listdata->TotProfit);
                    $row[] = $listdata->PersenProfit ;                   
                
                $data[] = $row;
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->M_sales_items->count_all($params),
                "recordsFiltered" => $this->M_sales_items->count_filtered($params),
                "data" => $data,
            );
        // die(var_dump($output));
        echo json_encode($output);
    }
}