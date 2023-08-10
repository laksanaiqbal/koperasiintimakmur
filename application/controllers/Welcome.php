<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		//check user login
		if ($this->session->userdata('IS_LOGIN') == FALSE) {
			redirect('auth');
		}
		//$this->load->model('chart_model');
		$this->load->library('pdf');
        $this->load->library('encryption');
        $this->load->model('M_member_billing');
	}

	public function index()
	{
		$data = array(
			'title_form' => 'DASHBOARD',
			'url_back'   => site_url('welcome')
		);
		$data2 = array(
			'title_form' => 'MEMBER DASHBOARD',
			'url_back'   => site_url('welcome')
		);
		
		if ($this->session->userdata('APP_OWNER') == 1 && $this->session->userdata('APP_ID')==2) {
			$this->load->view('template/header');
			$this->load->view('main_dashboard', $data);
			$this->load->view('template/footer');
		} elseif ($this->session->userdata('USER_NAME') == 'Administrator') {
            $this->load->view('template/header');
			$this->load->view('main_dashboard', $data);
			$this->load->view('template/footer');
		}else{
            $this->load->view('template/header_member');
			$this->load->view('dashboard/anggota_dashboard', $data2);
			$this->load->view('template/footer');
        }
		
	}
	public function ajax_list()
    {
        
            $start  = $_REQUEST['start']; //tambahan limit
            $length = $_REQUEST['length'];
            $params = array();
            if ($length != -1) {
                $params['limit'] = $length; //tambahan limit
                $params['start'] = $start;
            }
            $list = $this->M_member_billing->get_datatables($params);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $listdata) {
                // $no++;
                $row = array();
                // $row[] = $no;
					$row[] =  number_format($listdata->TotPembelian);
                    $row[] =  number_format($listdata->TotBayar);
                    $row[] =  number_format($listdata->TotHutang);                
                $data[] = $row;
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->M_member_billing->count_all($params),
                "recordsFiltered" => $this->M_member_billing->count_filtered($params),
                "data" => $data,
            );
        echo json_encode($output);
    }
}