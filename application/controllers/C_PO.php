<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class C_PO extends CI_Controller
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
        $this->load->model('M_PO');
        $this->load->model('M_satuan');
        $this->load->model('M_suplier');
        $this->load->model('M_masterbarang');
        $this->load->model('M_kelompokbarang');
    }
    public function index()
    {
        $data = array(
            'title_form' => 'Pre-Order',
            'url_back'   => site_url('C_PO')
        );
        $data['datasat'] = $this->M_satuan->getdata();
        $data['datasup'] = $this->M_suplier->getdata();
        $data['datakelompok'] = $this->M_kelompokbarang->getdata();


        $this->load->view('template/header');
        $this->load->view('PO/index', $data);
        $this->load->view('template/footer');
    }
    public function ajax_edit($noorder)
    {
        $data = $this->M_PO->get_by_id($noorder);
        echo json_encode($data);
    }
    public function ajax_logger_edit($noorder)
    {
        $data = $this->M_PO_logger->get_by_id($noorder);
        echo json_encode($data);
    }
    public function ajax_openimage($noorder)
    {
        $data = $this->M_PO->get_by_id($noorder);
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
        $list = $this->M_PO->get_datatables($params);
        // $kuya=$this->input->post('txt_status');
        // die(var_dump($list));
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $listdata) {
            if ($listdata->status == 1) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $listdata->noorder;
                $row[] = $listdata->namabrg;
                $row[] = $listdata->qtyorder;
                $row[] = $listdata->namaklmpk;
                $row[] = $listdata->namasat;
                $row[] = $listdata->namasup;
                $row[] = $listdata->rbeli;
                $row[] = '<span style="color:white" class="badge bg-warning">PO</span>' . '<p>
                <a class="btn btn-pill btn-outline-success btn-air-success btn-xs" href="javascript:void(0)" title="approval Data" onclick="approval(' . "'" . $listdata->noorder . "'" . ')"><i class="fa fa-check"></i></a>
                <a class="btn btn-pill btn-outline-danger btn-air-warning btn-xs" href="javascript:void(0)" title="Rejected" onclick="Rejected(' . "'" . $listdata->noorder . "'" . ')"><i class="fa fa-xing"></i> </a>
                <a class="btn btn-pill btn-outline-warning btn-air-warning btn-xs openimage" href="javascript:void(0)" title="Open Image" onclick="openimage(' . "'" . $listdata->noorder . "'" . ')"><i class="fa fa-image"></i></a>';
                $data[] = $row;
            }
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_PO->count_all($params),
            "recordsFiltered" => $this->M_PO->count_filtered($params),
            "data" => $data,
        );
        // die(var_dump($output));
        echo json_encode($output);
    }
    // public function ajax_logger()
    // {
    //     $start  = $_REQUEST['start']; //tambahan limit
    //     $length = $_REQUEST['length'];
    //     $params = array();
    //     if ($this->input->post('txt_transID')) {
    //         $params['txt_transID'] = $this->input->post('txt_transID');
    //     }
    //     if ($length != -1) {
    //         $params['limit'] = $length; //tambahan limit
    //         $params['start'] = $start;
    //     }
    //     $list = $this->M_PO_logger->get_datatables($params);
    //     $data = array();
    //     $no = $_POST['start'];
    //     foreach ($list as $listdata) {
    //         $no++;
    //         $row = array();
    //         $row[] = $no;
    //         $row[] = $listdata->ACTIONS;
    //         $row[] = $listdata->USER_NAME;
    //         $row[] = $listdata->EMP_NAME;
    //         $row[] = $listdata->CREATE_DB;
    //         $row[] = $listdata->CREATE_SYSTEM;
    //         $data[] = $row;
    //     }
    //     $output = array(
    //         "draw" => $_POST['draw'],
    //         "recordsTotal" => $this->M_PO_logger->count_all(),
    //         "recordsFiltered" => $this->M_PO_logger->count_filtered($params),
    //         "data" => $data,
    //     );
    //     echo json_encode($output);
    //     // exit;
    // }
    public function input_proses()
    {
        $post_data  = $this->input->post();
        $this->form_validation->set_rules('txt_input_kodebrg', 'Input Kode', 'required');
        $this->form_validation->set_rules('txt_input_namabrg', 'Input Nama', 'required');
        $this->form_validation->set_rules('txt_input_qtyorder', 'Input qtyorder', 'required');
        $this->form_validation->set_rules('txt_input_satorder', 'Input Satuan', 'required');
        $this->form_validation->set_rules('txt_input_kelompok', 'Input Kelompok', 'required');
        $this->form_validation->set_rules('txt_input_suplier', 'Input Suplier', 'required');
        $this->form_validation->set_rules('txt_input_status', 'Input status', 'unrequired');
        $this->form_validation->set_rules('txt_input_hbeli', 'Input Hbeli', 'required');
        $this->form_validation->set_rules('gambar', 'Input Gambar', 'unrequired');


        if ($this->form_validation->run() == false) {
            $out['is_error']       = true;
            $out['error_message']  = validation_errors();
        } else {
            $gambar = $_FILES['gambar']['tmp_name'];
            $txt_input_kodebrg = $this->input->post('txt_input_kodebrg');
            $target_file = './assets/barang/';
            $imagePath = $target_file . $txt_input_kodebrg . ".png";
            $imagename = $txt_input_kodebrg . ".png";
            move_uploaded_file($gambar, $imagePath);
            $save_data = array(
                'kodebrg' => $post_data['txt_input_kodebrg'],
                'namabrg' => $post_data['txt_input_namabrg'],
                'qtyorder' => $post_data['txt_input_qtyorder'],
                'kodeklmpk' => $post_data['txt_input_kelompok'],
                'satorder' => $post_data['txt_input_satorder'],
                'sup' => $post_data['txt_input_suplier'],
                'rbeli' => $post_data['txt_input_hbeli'],
                'status' => '1',
                'gambar' => $imagename,
            );
            $Nomor = $this->db->query("SELECT max(a.noorder) as Max_Number FROM inv.dorder a");
            foreach ($Nomor->result() as $rows) {
                $save_logs = array(
                    'USER_ID' => $this->session->userdata('ID'),
                    'USER_NAME' => $this->session->userdata('USER_NAME'),
                    'EMP_NAME' => $this->session->userdata('NAMA'),
                    'TABLE_NAME' => 'inv.dorder',
                    'TRANS_ID' =>  $post_data['txt_input_kodebrg'],
                    'TRANS_DESC' =>  $post_data['txt_input_namabrg'],
                    'CREATE_SYSTEM' =>  date('Y-m-d H:i:s'),
                    'ACTIONS' => 'INPUT'
                );
            }
            //Save Pegawai
            $this->M_PO->save($save_data);
            // $this->M_PO->save_log($save_logs);

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
        $this->form_validation->set_rules('txt_input_noorder', 'Input Kode', 'required');
        $this->form_validation->set_rules('txt_input_namabrg', 'Input Nama', 'required');
        $this->form_validation->set_rules('txt_input_qtyorder', 'Input qtyorder', 'required');
        $this->form_validation->set_rules('txt_input_satorder', 'Input Satuan', 'required');
        $this->form_validation->set_rules('txt_input_rbeli', 'Input Suplier', 'required');
        $this->form_validation->set_rules('txt_input_status', 'Input status', 'unrequired');

        if ($this->form_validation->run() == false) {
            $out['is_error']       = true;
            $out['error_message']  = validation_errors();
        } else {
            $save_data = array(
                'noorder' => $post_data['txt_input_noorder'],
                'namabrg' => $post_data['txt_input_namabrg'],
                'qtyorder' => $post_data['txt_input_qtyorder'],
                'satorder' => $post_data['txt_input_satorder'],
                'rbeli' => $post_data['txt_input_rbeli'],
                'status' => '1'
            );
            $save_logs = array(
                'USER_ID' => $this->session->userdata('ID'),
                'USER_NAME' => $this->session->userdata('USER_NAME'),
                'EMP_NAME' => $this->session->userdata('NAMA'),
                'TABLE_NAME' => 'inv.dorder',
                'TRANS_ID' =>  $post_data['txt_input_noorder'],
                'TRANS_DESC' =>  $post_data['txt_input_namabrg'],
                'CREATE_SYSTEM' =>  date('Y-m-d H:i:s'),
                'ACTIONS' => 'UPDATES'
            );

            // die(var_dump($post_data['txt_input_kodebrg']));
            $this->M_PO->update(array('noorder' => $this->input->post('txt_input_noorder')), $save_data);
            // $this->M_PO->save_log($save_logs);

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
    public function delete_permanen($noorder)
    {
        $this->M_PO->delete_by_id($noorder);
        echo json_encode(array("noorder" => NULL));
        $SQLmas = $this->db->query("SELECT * from inv.PO");
        if ($SQLmas->num_rows() == '') {
            $this->db->query("ALTER TABLE inv.PO");
            $this->session->redirect('C_PO');
        }
    }
    public function approval($noorder)
    {
        $message['is_error']       = true;
        $message['succes_message']  = "";
        if (!empty($noorder)) {
            $save_data = array(
                'status' => '2',
            );
            $PO = $this->db->query("SELECT a.namabrg,a.kodeklmpk, a.kodebrg,a.rbeli,a.sup, a.qtyorder, a.satorder, a.gambar FROM inv.dorder a where a.noorder='" . $noorder . "'");
            foreach ($PO->result() as $row) {
                $save_data_barang = array(
                    'kodebrg' => $row->kodebrg,
                    'namabrg' => $row->namabrg,
                    'stokawal' => $row->qtyorder,
                    'kodesat' => $row->satorder,
                    'kodeklmpk' => $row->kodeklmpk,
                    'status' => '3',
                    'hpp' => $row->rbeli,
                    'kodesup' => $row->sup,
                    'gambar1' => $row->gambar,
                );
            }
            // $evdesc = $this->db->query("SELECT a.namabrg FROM inv.dorder a where a.noorder='" . $noorder . "'");
            // foreach ($evdesc->result() as $row) {
            //     $save_logs = array(
            //         'USER_ID' => $this->session->userdata('ID'),
            //         'USER_NAME' => $this->session->userdata('USER_NAME'),
            //         'EMP_NAME' => $this->session->userdata('NAMA'),
            //         'TABLE_NAME' => 'inv.dorder',
            //         'TRANS_ID' =>  $noorder,
            //         'TRANS_DESC' =>  $row->namabrg,
            //         'CREATE_SYSTEM' =>  date('Y-m-d H:i:s'),
            //         'ACTIONS' => 'approval'
            //     );
            // }

            // die(var_dump($post_data['txt_input_noorder']));
            $this->M_masterbarang->save($save_data_barang);
            $this->M_PO->update(array('noorder' => $noorder), $save_data);
            // $this->M_masterbarang->save_log($save_logs);
            $message['is_error']       = false;
            $message['succes_message']  = "Approval data success";
        } else {
            $message['is_error']       = true;
            $message['error_message']  = "Errr!!!";
        }

        echo json_encode($message);
    }
    public function Rejected($noorder)
    {
        $message['is_error']       = true;
        $message['succes_message']  = "";
        if (!empty($noorder)) {
            $save_data = array(
                'status' => '3',
            );
            // $evdesc = $this->db->query("SELECT a.namabrg FROM inv.dorder a where a.noorder='" . $noorder . "'");
            // foreach ($evdesc->result() as $row) {
            //     $save_logs = array(
            //         'USER_ID' => $this->session->userdata('ID'),
            //         'USER_NAME' => $this->session->userdata('USER_NAME'),
            //         'EMP_NAME' => $this->session->userdata('NAMA'),
            //         'TABLE_NAME' => 'inv.dorder',
            //         'TRANS_ID' =>  $noorder,
            //         'TRANS_DESC' =>  $row->namabrg,
            //         'CREATE_SYSTEM' =>  date('Y-m-d H:i:s'),
            //         'ACTIONS' => 'approval'
            //     );
            // }

            // die(var_dump($post_data['txt_input_noorder']));
            $this->M_PO->update(array('noorder' => $noorder), $save_data);
            // $this->M_masterbarang->save_log($save_logs);
            $message['is_error']       = false;
            $message['succes_message']  = "Rejected data success";
        } else {
            $message['is_error']       = true;
            $message['error_message']  = "Errr!!!";
        }

        echo json_encode($message);
    }
}
