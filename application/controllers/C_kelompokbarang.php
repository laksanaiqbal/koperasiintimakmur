<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class C_kelompokbarang extends CI_Controller
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
        $this->load->model('M_kelompokbarang');
    }

    public function index()
    {
        $data = array(
            'title_form' => 'Report || Kelompok Barang',
            'url_back'   => site_url('C_kelompokbarang')
        );
        $this->load->view('template/header');
        $this->load->view('kelompokbarang/index', $data);
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
        $list = $this->M_kelompokbarang->get_datatables($params);
        // $kuya=$this->input->post('txt_status');
        // die(var_dump($list));
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $listdata) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $listdata->kodeklmpk;
            $row[] = $listdata->namaklmpk . '<p>
            <a class="btn btn-pill btn-outline-primary btn-air-primary btn-xs" href="javascript:void(0)" title="Edit data" onclick="edit_data(' . "'" . $listdata->kodeklmpk . "'" . ')"><i class="fa fa-edit"></i> </a>
            <a class="btn btn-pill btn-outline-danger btn-air-danger btn-xs" href="javascript:void(0)" title="Delete Permanen" onclick="delete_data(' . "'" . $listdata->kodeklmpk . "'" . ')"><i class="fa fa-trash-o"></i> </a>';
            $row[] = $listdata->jumlah;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_kelompokbarang->count_all($params),
            "recordsFiltered" => $this->M_kelompokbarang->count_filtered($params),
            "data" => $data,
        );
        // die(var_dump($output));
        echo json_encode($output);
    }
    public function ajax_edit($kodeklmpk)
    {
        $data = $this->M_kelompokbarang->get_by_id($kodeklmpk);
        echo json_encode($data);
    }
    public function input_proses()
    {
        $post_data  = $this->input->post();
        $this->form_validation->set_rules('txt_input_kodeklmpk', 'Input Kode', 'required');
        $this->form_validation->set_rules('txt_input_namaklmpk', 'Input Nama', 'required');
        $this->form_validation->set_rules('txt_input_dept', 'Input dept', 'unrequired');

        if ($this->form_validation->run() == false) {
            $out['is_error']       = true;
            $out['error_message']  = validation_errors();
        } else {
            $save_data = array(
                'kodeklmpk' => $post_data['txt_input_kodeklmpk'],
                'namaklmpk' => $post_data['txt_input_namaklmpk'],
                'kodedept' => '01',
            );
            //Save Pegawai
            $this->M_kelompokbarang->save($save_data);
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
        $this->form_validation->set_rules('kodeklmpk', 'Input Kode', 'required');
        $this->form_validation->set_rules('namaklmpk', 'Input Nama', 'required');
        $this->form_validation->set_rules('txt_input_dept', 'Input dept', 'unrequired');
        if ($this->form_validation->run() == false) {
            $out['is_error']       = true;
            $out['error_message']  = validation_errors();
        } else {
            $save_data = array(
                'kodeklmpk' => $post_data['kodeklmpk'],
                'namaklmpk' => $post_data['namaklmpk'],
                'kodedept' => '01',
            );

            // die(var_dump($post_data['txt_input_kodebrg']));
            $this->M_kelompokbarang->update(array('kodeklmpk' => $this->input->post('kodeklmpk')), $save_data);
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
    public function delete_permanen($kodeklmpk)
    {
        $this->M_kelompokbarang->delete_by_id($kodeklmpk);
        echo json_encode(array("kodeklmpk" => NULL));
        $SQLmas = $this->db->query("SELECT * from inv.kelompok");
        if ($SQLmas->num_rows() == '') {
            $this->db->query("ALTER TABLE inv.kelompok");
            $this->session->redirect('kelompok');
        }
    }
}
