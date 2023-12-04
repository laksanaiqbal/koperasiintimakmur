<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class C_satuan extends CI_Controller
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
        $this->load->model('M_satuan');
    }

    public function index()
    {
        $data = array(
            'title_form' => '<i class="fa fa-arrow-circle-right"></i> Satuan',
            'url_back'   => site_url('C_satuan')
        );
        $this->load->view('template/header');
        $this->load->view('satuan/index', $data);
        $this->load->view('template/footer');
    }
    public function ajax_edit($kodesat)
    {
        $data = $this->M_satuan->get_by_id($kodesat);
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
        $list = $this->M_satuan->get_datatables($params);
        // $kuya=$this->input->post('txt_status');
        // die(var_dump($list));
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $listdata) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $listdata->kodesat;
            $row[] = $listdata->namasat . '<p>
            <a class="btn btn-pill btn-outline-primary btn-air-primary btn-xs" href="javascript:void(0)" title="Edit data" onclick="edit_data(' . "'" . $listdata->kodesat . "'" . ')"><i class="fa fa-edit"></i> </a>
            <a class="btn btn-pill btn-outline-danger btn-air-danger btn-xs" href="javascript:void(0)" title="Delete Permanen" onclick="delete_data(' . "'" . $listdata->kodesat . "'" . ')"><i class="fa fa-trash-o"></i> </a>';;
            $row[] = $listdata->jumpcs;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_satuan->count_all($params),
            "recordsFiltered" => $this->M_satuan->count_filtered($params),
            "data" => $data,
        );
        // die(var_dump($output));
        echo json_encode($output);
    }
    public function input_proses()
    {
        $post_data  = $this->input->post();
        $this->form_validation->set_rules('txt_input_kodesat', 'Input Kode', 'required');
        $this->form_validation->set_rules('txt_input_namasat', 'Input Nama', 'required');
        if ($this->form_validation->run() == false) {
            $out['is_error']       = true;
            $out['error_message']  = validation_errors();
        } else {
            $save_data = array(
                'kodesat' => $post_data['txt_input_kodesat'],
                'namasat' => $post_data['txt_input_namasat'],
            );
            //Save Pegawai
            $this->M_satuan->save($save_data);
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
        $this->form_validation->set_rules('kodesat', 'Input Kode', 'required');
        $this->form_validation->set_rules('namasat', 'Input Nama', 'required');
        $this->form_validation->set_rules('jumlah', 'Input Jumlah', 'required');
        if ($this->form_validation->run() == false) {
            $out['is_error']       = true;
            $out['error_message']  = validation_errors();
        } else {
            $save_data = array(
                'kodesat' => $post_data['kodesat'],
                'namasat' => $post_data['namasat'],
            );

            // die(var_dump($post_data['txt_input_kodebrg']));
            $this->M_satuan->update(array('kodesat' => $this->input->post('kodesat')), $save_data);
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
    public function delete_permanen($kodesat)
    {
        $this->M_satuan->delete_by_id($kodesat);
        echo json_encode(array("kodesat" => NULL));
        $SQLmas = $this->db->query("SELECT * from inv.satuan");
        if ($SQLmas->num_rows() == '') {
            $this->db->query("ALTER TABLE inv.satuan");
            $this->session->redirect('satuan');
        }
    }
}
