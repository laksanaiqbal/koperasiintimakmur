<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class C_suplier extends CI_Controller
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
        $this->load->model('M_suplier');
        $this->load->model('M_suplier_logger');
    }

    public function index()
    {
        $data = array(
            'title_form' => 'Daftar Suplier',
            'url_back'   => site_url('C_suplier')
        );
        $this->load->view('template/header');
        $this->load->view('suplier/index', $data);
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
        $list = $this->M_suplier->get_datatables($params);
        // $kuya=$this->input->post('txt_status');
        // die(var_dump($list));
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $listdata) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] =  '<p>
            <a class="btn btn-pill btn-outline-primary btn-air-primary btn-xs" href="javascript:void(0)" title="Edit data" onclick="edit_data(' . "'" . $listdata->kodesup . "'" . ')"><i class="fa fa-edit"></i> </a>
            <a class="btn btn-pill btn-outline-danger btn-air-danger btn-xs" href="javascript:void(0)" title="Delete Permanen" onclick="delete_data(' . "'" . $listdata->kodesup . "'" . ')"><i class="fa fa-trash-o"></i> </a>
            <a class="btn btn-pill btn-outline-info btn-air-info btn-xs" href="javascript:void(0)" title="Log data"  onclick="data_logger(' . "'" . $listdata->kodesup . "'" . ')"><i class="fa fa-rotate-left"></i> </a>';
            $row[] = $listdata->kodesup;
            $row[] = $listdata->namasup;
            $row[] = $listdata->atasnama;
            $row[] = $listdata->Bank;
            $row[] = $listdata->ACBank;
            $row[] = $listdata->namaproduk;
            $row[] = $listdata->alamat;
            $row[] = $listdata->telepon;
            $row[] = $listdata->nilai;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_suplier->count_all($params),
            "recordsFiltered" => $this->M_suplier->count_filtered($params),
            "data" => $data,
        );
        // die(var_dump($output));
        echo json_encode($output);
    }
    public function ajax_edit($kodesup)
    {
        $data = $this->M_suplier->get_by_id($kodesup);
        echo json_encode($data);
    }
    public function ajax_logger_edit($kodesup)
    {
        $data = $this->M_suplier_logger->get_by_id($kodesup);
        echo json_encode($data);
    }
    public function input_proses()
    {
        $post_data  = $this->input->post();
        $this->form_validation->set_rules('kodesup', 'Input Kode', 'required');
        $this->form_validation->set_rules('namasup', 'Input Suplier', 'required');
        $this->form_validation->set_rules('atasnama', 'Input Atas Nama', 'required');
        $this->form_validation->set_rules('bank', 'Input Bank', 'required');
        $this->form_validation->set_rules('ACBank', 'Input ACBank', 'required');
        $this->form_validation->set_rules('alamat', 'Input alamat', 'required');
        $this->form_validation->set_rules('namaproduk', 'Input namaproduk', 'required');
        $this->form_validation->set_rules('hp', 'Input Nomor HP', 'required');
        $this->form_validation->set_rules('nilai', 'Input Nilai HP', 'required');

        if ($this->form_validation->run() == false) {
            $out['is_error']       = true;
            $out['error_message']  = validation_errors();
        } else {
            $save_data = array(
                'kodesup' => $post_data['kodesup'],
                'namasup' => $post_data['namasup'],
                'atasnama' => $post_data['atasnama'],
                'Bank' => $post_data['bank'],
                'ACBank' => $post_data['ACBank'],
                'alamat' => $post_data['alamat'],
                'namaproduk' => $post_data['namaproduk'],
                'telepon' => $post_data['hp'],
                'nilai' => $post_data['nilai'],
            );
            $Nomor = $this->db->query("SELECT max(a.kodesup) as Max_Number FROM inv.suplier a");
            foreach ($Nomor->result() as $rows) {
                $save_logs = array(
                    'USER_ID' => $this->session->userdata('ID'),
                    'USER_NAME' => $this->session->userdata('USER_NAME'),
                    'EMP_NAME' => $this->session->userdata('NAMA'),
                    'TABLE_NAME' => 'inv.suplier',
                    'TRANS_ID' =>  $post_data['kodesup'],
                    'TRANS_DESC' =>  $post_data['namasup'],
                    'CREATE_SYSTEM' =>  date('Y-m-d H:i:s'),
                    'ACTIONS' => 'INPUT'
                );
            }
            //Save Pegawai
            $this->M_suplier->save($save_data);
            $this->M_suplier->save_log($save_logs);
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
        $this->form_validation->set_rules('txt_input_kodesup', 'Input Kode', 'required');
        $this->form_validation->set_rules('txt_input_namasup', 'Input Suplier', 'required');
        $this->form_validation->set_rules('txt_input_atasnama', 'Input Atas Nama', 'required');
        $this->form_validation->set_rules('txt_input_Bank', 'Input Bank', 'required');
        $this->form_validation->set_rules('txt_input_ACBank', 'Input ACBank', 'required');
        $this->form_validation->set_rules('txt_input_alamat', 'Input alamat', 'required');
        $this->form_validation->set_rules('txt_input_namaproduk', 'Input namaproduk', 'required');
        $this->form_validation->set_rules('txt_input_hp', 'Input Nomor HP', 'required');
        $this->form_validation->set_rules('txt_input_nilai', 'Input Nilai HP', 'required');
        if ($this->form_validation->run() == false) {
            $out['is_error']       = true;
            $out['error_message']  = validation_errors();
        } else {
            $save_data = array(
                'kodesup' => $post_data['txt_input_kodesup'],
                'namasup' => $post_data['txt_input_namasup'],
                'atasnama' => $post_data['txt_input_atasnama'],
                'Bank' => $post_data['txt_input_Bank'],
                'ACBank' => $post_data['txt_input_ACBank'],
                'alamat' => $post_data['txt_input_alamat'],
                'namaproduk' => $post_data['txt_input_namaproduk'],
                'telepon' => $post_data['txt_input_hp'],
                'nilai' => $post_data['txt_input_nilai'],
            );
            $save_logs = array(
                'USER_ID' => $this->session->userdata('ID'),
                'USER_NAME' => $this->session->userdata('USER_NAME'),
                'EMP_NAME' => $this->session->userdata('NAMA'),
                'TABLE_NAME' => 'inv.suplier',
                'TRANS_ID' =>  $post_data['txt_input_kodesup'],
                'TRANS_DESC' =>  $post_data['txt_input_namasup'],
                'CREATE_SYSTEM' =>  date('Y-m-d H:i:s'),
                'ACTIONS' => 'UPDATES'
            );
            // die(var_dump($post_data['txt_input_kodebrg']));
            $this->M_suplier->update(array('kodesup' => $this->input->post('txt_input_kodesup')), $save_data);
            $this->M_suplier->save_log($save_logs);
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
        $list = $this->M_suplier_logger->get_datatables($params);
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
            "recordsTotal" => $this->M_suplier_logger->count_all(),
            "recordsFiltered" => $this->M_suplier_logger->count_filtered($params),
            "data" => $data,
        );
        echo json_encode($output);
        // exit;
    }
    public function delete_permanen($kodesup)
    {
        $this->M_suplier->delete_by_id($kodesup);
        echo json_encode(array("kodesup" => NULL));
        $SQLmas = $this->db->query("SELECT * from inv.suplier");
        if ($SQLmas->num_rows() == '') {
            $this->db->query("ALTER TABLE inv.suplier");
            $this->session->redirect('suplier');
        }
    }
}
