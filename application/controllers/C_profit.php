<?php
defined('BASEPATH') or exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class C_profit extends CI_Controller
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
        $this->load->model('M_profit');
	}

	public function index()
	{
		$data = array(
			'title_form' => 'Report || Sales By Date ',
			'url_back'   => site_url('C_profit')
		);
		$this->load->view('template/header');
		$this->load->view('profit/index', $data);		
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
            if ($length != -1) {
                $params['limit'] = $length; //tambahan limit
                $params['start'] = $start;
            }
            $list = $this->M_profit->get_datatables($params);
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
                    $row[] = date('d F Y',strtotime($listdata->tanggal));
                    $row[] = number_format($listdata->SubTotal);
                    $row[] = number_format($listdata->THpp);
                    $row[] = number_format($listdata->ProfitRp);
                    $row[] = $listdata->ProfitPersen ;                   
                
                $data[] = $row;
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->M_profit->count_all($params),
                "recordsFiltered" => $this->M_profit->count_filtered($params),
                "data" => $data,
            );
        // die(var_dump($output));
        echo json_encode($output);
    }
}