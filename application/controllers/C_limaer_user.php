<?php
defined('BASEPATH') or exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class C_limaer_user extends CI_Controller
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
        $this->load->model('M_limaer_user');
	}

	public function index()
	{
		$data = array(
			'title_form' => 'Master Data || Users',
			'url_back'   => site_url('limaer_user')
		);
		$this->load->view('template/header');
		$this->load->view('users/index', $data);		
		$this->load->view('template/footer');
		
	}
	public function ajax_list()
    {
        
            $start  = $_REQUEST['start']; //tambahan limit
            $length = $_REQUEST['length'];
            $params = array();
            if ($this->input->post('txt_username')) {
                $params['txt_username'] = $this->input->post('txt_username');
            }
            if ($this->input->post('txt_nmkary')) {
                $params['txt_nmkary'] = $this->input->post('txt_nmkary');
            }
            if ($length != -1) {
                $params['limit'] = $length; //tambahan limit
                $params['start'] = $start;
            }
            $list = $this->M_limaer_user->get_datatables($params);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $listdata) {
                $no++;
                $row = array();
                $row[] = $no;
                if ($listdata->STATUS == 0) {
                    $row[] = $listdata->USER_NAME . ' <p>
				<a class="btn btn-pill btn-outline-primary btn-air-primary btn-xs" href="javascript:void(0)" title="Edit" onclick="edit_data(' . "'" . $listdata->ID . "'" . ')"><i class="fa fa-edit"></i> </a>
				<a class="btn btn-pill btn-outline-warning btn-air-warning btn-xs" href="javascript:void(0)" title="Disable Data" onclick="disable_data(' . "'" . $listdata->ID . "'" . ')"><i class="fa fa-trash-o"></i> </a>';
                    $row[] = $listdata->EMAIL;
					$row[] = $listdata->LEVEL;
                    $row[] = $listdata->Nama;
                    $row[] = $listdata->JABATAN;
                    $row[] = $listdata->Namaunit;
                    $row[] = 'Active';
                } else {
                    $row[] = $listdata->USER_NAME;
                    $row[] = $listdata->EMAIL;
					$row[] = $listdata->LEVEL;
                    $row[] = $listdata->Nama;
                    $row[] = $listdata->JABATAN;
                    $row[] = $listdata->Namaunit;
                    $row[] =
                        'Not Active' . ' <p>
				<a class="btn btn-pill btn-outline-primary btn-air-primary btn-xs" href="javascript:void(0)" title="Recovery" onclick="recover(' . "'" . $listdata->ID . "'" . ')"><i class="fa fa-recycle"></i> </a>
				<a class="btn btn-pill btn-outline-danger btn-air-danger btn-xs" href="javascript:void(0)" title="Delete Permanen" onclick="delete_data(' . "'" . $listdata->ID . "'" . ')"><i class="fa fa-trash-o"></i> </a>';
                }
                $data[] = $row;
            }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->M_limaer_user->count_all(),
                "recordsFiltered" => $this->M_limaer_user->count_filtered($params),
                "data" => $data,
            );
        // die(var_dump($output));
        echo json_encode($output);
    }
}