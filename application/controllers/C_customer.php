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
        $this->load->model('M_customer_logger');
    }

    public function index()
    {
        $data = array(
            'title_form' => 'Customer',
            'url_back'   => site_url('C_customer')
        );
        $this->load->view('template/header');
        $this->load->view('customer/index', $data);
        $this->load->view('template/footer');
    }
    public function ajax_edit($kodecus)
    {
        $data = $this->M_customer->get_by_id($kodecus);
        echo json_encode($data);
    }
    public function ajax_logger_edit($kodecus)
    {
        $data = $this->M_customer_logger->get_by_id($kodecus);
        echo json_encode($data);
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
            $row[] = '<p>
            <a class="btn btn-pill btn-outline-primary btn-air-primary btn-xs" href="javascript:void(0)" title="Edit data" onclick="edit_data(' . "'" . $listdata->kodecus . "'" . ')"><i class="fa fa-edit"></i> </a>
            <a class="btn btn-pill btn-outline-danger btn-air-danger btn-xs" href="javascript:void(0)" title="Delete Permanen" onclick="delete_data(' . "'" . $listdata->kodecus . "'" . ')"><i class="fa fa-trash-o"></i> </a></p>
            <a class="btn btn-pill btn-outline-info btn-air-info btn-xs" href="javascript:void(0)" title="Log data"  onclick="data_logger(' . "'" . $listdata->kodecus . "'" . ')"><i class="fa fa-rotate-left"></i> </a>';
            $row[] = $listdata->kodecus;
            $row[] = $listdata->namacus;
            $row[] = $listdata->alamat;
            $row[] = $listdata->kota;
            $row[] = $listdata->hp;
            $row[] = $listdata->batas;
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
    public function ajax_logger()
    {
        $start  = $_REQUEST['start']; //tambahan limit
        $length = $_REQUEST['length'];
        $params = array();
        if ($this->input->post('txt_transID')) {
            $params['txt_transID'] = $this->input->post('txt_transID');
        }
        if ($length != -1) {
            $params['limit'] = $length; //tambahan limit
            $params['start'] = $start;
        }
        $list = $this->M_customer_logger->get_datatables($params);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $listdata) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $listdata->ACTIONS;
            $row[] = $listdata->USER_NAME;
            $row[] = $listdata->EMP_NAME;
            $row[] = $listdata->CREATE_DB;
            $row[] = $listdata->CREATE_SYSTEM;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_customer_logger->count_all(),
            "recordsFiltered" => $this->M_customer_logger->count_filtered($params),
            "data" => $data,
        );
        echo json_encode($output);
        // exit;
    }
    public function input_proses()
    {
        $post_data  = $this->input->post();
        $this->form_validation->set_rules('txt_input_kodecus', 'Input Kode', 'required');
        $this->form_validation->set_rules('txt_input_namacus', 'Input Nama', 'required');
        $this->form_validation->set_rules('txt_input_alamat', 'Input alamat', 'required');
        $this->form_validation->set_rules('txt_input_posisi', 'Input jabatan', 'required');
        $this->form_validation->set_rules('txt_input_hp', 'Input Nomor HP', 'required');
        $this->form_validation->set_rules('txt_input_limit', 'Input Debit Limit HP', 'required');


        if ($this->form_validation->run() == false) {
            $out['is_error']       = true;
            $out['error_message']  = validation_errors();
        } else {
            $save_data = array(
                'kodecus' => $post_data['txt_input_kodecus'],
                'namacus' => $post_data['txt_input_namacus'],
                'alamat' => $post_data['txt_input_alamat'],
                'kota' => $post_data['txt_input_posisi'],
                'hp' => $post_data['txt_input_hp'],
                'batas' => $post_data['txt_input_limit'],
            );
            $Nomor = $this->db->query("SELECT max(a.kodecus) as Max_Number FROM inv.customer a");
            foreach ($Nomor->result() as $rows) {
                $save_logs = array(
                    'USER_ID' => $this->session->userdata('ID'),
                    'USER_NAME' => $this->session->userdata('USER_NAME'),
                    'EMP_NAME' => $this->session->userdata('NAMA'),
                    'TABLE_NAME' => 'inv.customer',
                    'TRANS_ID' =>  $post_data['txt_input_kodecus'],
                    'TRANS_DESC' =>  $post_data['txt_input_namacus'],
                    'CREATE_SYSTEM' =>  date('Y-m-d H:i:s'),
                    'ACTIONS' => 'INPUT'
                );
            }
            //Save Pegawai
            $this->M_customer->save($save_data);
            $this->M_customer->save_log($save_logs);

            if ($this->db->trans_status() == FALSE) {
                $this->db->trans_rollback();
                $out['is_error']       = False;
                $out['error_message']  = "database error";
            } else {
                $this->db->trans_commit();
                $out['is_error']       = false;
                $out['succes_message']  = "Good luck Bro, Input data berhasil";
            }
        }
        //Save Master Barang Logs

        echo json_encode($out);
    }
    public function update_proses()
    {
        $this->load->library('form_validation');
        $out['is_error']       = true;
        $out['error_message']  = "";
        $post_data  = $this->input->post();
        $this->form_validation->set_rules('kodecus', 'Input Kode', 'required');
        $this->form_validation->set_rules('namacus', 'Input Nama', 'required');
        $this->form_validation->set_rules('alamat', 'Input alamat', 'required');
        $this->form_validation->set_rules('jabatan', 'Input jabatan', 'required');
        $this->form_validation->set_rules('hp', 'Input Nomor HP', 'required');
        $this->form_validation->set_rules('limit', 'Input Nomor HP', 'required');


        if ($this->form_validation->run() == false) {
            $out['is_error']       = true;
            $out['error_message']  = validation_errors();
        } else {
            $save_data = array(
                'kodecus' => $post_data['kodecus'],
                'namacus' => $post_data['namacus'],
                'alamat' => $post_data['alamat'],
                'kota' => $post_data['jabatan'],
                'hp' => $post_data['hp'],
                'batas' => $post_data['limit'],

            );
            $save_logs = array(
                'USER_ID' => $this->session->userdata('ID'),
                'USER_NAME' => $this->session->userdata('USER_NAME'),
                'EMP_NAME' => $this->session->userdata('NAMA'),
                'TABLE_NAME' => 'inv.customer',
                'TRANS_ID' =>  $post_data['kodecus'],
                'TRANS_DESC' =>  $post_data['namacus'],
                'CREATE_SYSTEM' =>  date('Y-m-d H:i:s'),
                'ACTIONS' => 'UPDATES'
            );

            // die(var_dump($post_data['txt_input_kodebrg']));
            $this->M_customer->update(array('kodecus' => $this->input->post('kodecus')), $save_data);
            $this->M_customer->save_log($save_logs);

            if ($this->db->trans_status() == FALSE) {
                $this->db->trans_rollback();
                $out['is_error']       = true;
                $out['error_message']  = "database error";
            } else {
                $this->db->trans_commit();
                $out['is_error']       = false;
                $out['succes_message']  = "Good luck Bro, Update data berhasil .";
            }
        }
        echo json_encode($out);
    }
    public function delete_permanen($kodecus)
    {
        $this->M_customer->delete_by_id($kodecus);
        echo json_encode(array("kodecus" => NULL));
        $SQLmas = $this->db->query("SELECT * from inv.customer");
        if ($SQLmas->num_rows() == '') {
            $this->db->query("ALTER TABLE inv.customer");
            $this->session->redirect('C_customer');
        }
    }
}
