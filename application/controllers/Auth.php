<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Login_model');
		$this->load->library('user_agent');
	}
	public function index()
	{
		$session = $this->session->userdata('IS_LOGIN');

		if ($session == FALSE) {
			$this->load->view('login');
		} else {
			redirect('Welcome');
		}
	}
	public function proses_login()
	{
		//inisiasi
		$message['is_error'] = true;
		$message['error_msg'] = 'Kuya Boss, Belum apa-apa udah error aja, Payah nih Programernya';
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == FALSE) {
			$message['is_error']  = true;
			$message['error_msg'] = validation_errors();
		} else {

			$username = $this->input->post('username');
			$password = ($this->input->post('password'));

			$check_data = $this->Login_model->check_login($username, $password);
			if ($check_data) {
				$row = $check_data;
				$sess_data = array(
					'IS_LOGIN' => true,
					'login' => 'login_admin',
					'ID' => $row->ID,
					'USER_NAME' => $row->USER_NAME,
					'APP_OWNER' => $row->APP_OWNER,
					'APP_ID' => $row->APP_ID,
					'FID' => $row->FID,
					'NIK' => $row->NIK,
					'NIKKary' => $row->NIKKaryawan,
					'NAMA' => $row->Nama,
					'DEPT_NAME' => $row->DEPT_NAME,
					'JABATAN' => $row->JABATAN,
					'browser' => $this->agent->browser() . ' ' . $this->agent->version(),
					'robot' => $this->agent->robot(),
					'mobile' => $this->agent->mobile(),
					'platform' => $this->agent->platform(),
					'agent_string' => $this->agent->agent_string()
				);
				$this->session->set_userdata($sess_data);
				$message['is_error']  = false;
				$message['succes_msg'] = "success";
				$message['redirect']   = site_url('Welcome');
			} else {
				$message['is_error']  = true;
				$message['error_msg'] = "Maaf , Password atau username salah Atau mungkin, silahkan di coba kembali";
				$message['redirect']   = site_url('');
			}
		}
		echo json_encode($message);
	}
	public function Logout()
	{
		$this->session->sess_destroy();
		redirect('auth', 'refresh');
	}
}
