<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class C_masterbarang extends CI_Controller
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
        $this->load->model('M_masterbarang');
        $this->load->model('M_kelompokbarang');
        $this->load->model('M_daftardepartemen');
        $this->load->model('M_satuan');
    }

    public function index()
    {
        $data = array(
            'title_form' => 'Report || Master Barang',
            'url_back'   => site_url('C_masterbarang')
        );
        $data['datakelompok'] = $this->M_masterbarang->getdata();
        $data['datadept'] = $this->M_daftardepartemen->getdata();
        $data['datasat'] = $this->M_satuan->getdata();
        $this->load->view('template/header');
        $this->load->view('masterbarang/index', $data);
        $this->load->view('template/footer');
    }

    public function input_proses()
    {


        $post_data  = $this->input->post();
        $this->form_validation->set_rules('txt_input_kodebrg', 'Input Kode', 'required');
        $this->form_validation->set_rules('txt_input_barcode', 'Input Barcode', 'required');
        $this->form_validation->set_rules('txt_input_kelompok', 'Input Kelompok', 'required');
        $this->form_validation->set_rules('txt_input_dept', 'Input dept', 'unrequired');
        $this->form_validation->set_rules('txt_input_satuan', 'Input satuan', 'required');
        $this->form_validation->set_rules('txt_input_namabrg', 'Input Nama', 'required');
        $this->form_validation->set_rules('txt_input_stokakhir', 'Input Stok', 'required');
        $this->form_validation->set_rules('txt_input_hpp', 'Input HPP', 'required');
        $this->form_validation->set_rules('txt_input_hjual', 'Input Price', 'required');
        $this->form_validation->set_rules('gambar1', 'Input Gambar', 'unrequired');

        if ($this->form_validation->run() == false) {
            $out['is_error']       = true;
            $out['error_message']  = validation_errors();
        } else {
            $gambar1 = $_FILES['gambar1']['tmp_name'];
            $txt_input_kodebrg = $this->input->post('txt_input_kodebrg');
            $target_file = './upload/barang/';
            $imagePath = $target_file . $txt_input_kodebrg . ".png";
            move_uploaded_file($gambar1, $imagePath);
            $save_data = array(
                'gambar1' => $imagePath,
                'kodebrg' => $post_data['txt_input_kodebrg'],
                'barcode' => $post_data['txt_input_barcode'],
                'kodeklmpk' => $post_data['txt_input_kelompok'],
                'kodedept' => 01,
                'kodesat' => $post_data['txt_input_satuan'],
                'namabrg' => $post_data['txt_input_namabrg'],
                'stokakhir' => $post_data['txt_input_stokakhir'],
                'hpp' => $post_data['txt_input_hpp'],
                'hjual1' => $post_data['txt_input_hjual'],
            );



            //Save Lima Er Event
            $this->M_masterbarang->save($save_data);
            if ($this->db->trans_status() == FALSE) {
                $this->db->trans_rollback();
                $out['is_error']       = true;
                $out['error_message']  = "database error";
            } else {
                $this->db->trans_commit();
                $out['is_error']       = false;
                $out['succes_message']  = "Good luck Bro, Input data berhasil";
            }
        }

        echo json_encode($out);
        $Nomor = $this->db->query("SELECT max(a.kodebrg) as Max_Number FROM inv.barang a");
        foreach ($Nomor->result() as $rows) {
            $save_logs = array(
                'USER_NAME' => $this->session->userdata('USER_NAME'),
                'TABLE_NAME' => 'inv.barang',
                'TRANS_ID' =>  $post_data['txt_input_kodebrg'],
                'TRANS_DESC' =>  $post_data['txt_input_barcode'],
                'TRANS_DESC' =>  $post_data['txt_input_kelompok'],
                'TRANS_DESC' =>  $post_data['txt_input_satuan'],
                'TRANS_DESC' =>  $post_data['txt_input_namabrg'],
                'TRANS_DESC' =>  $post_data['txt_input_stokakhir'],
                'TRANS_DESC' =>  $post_data['txt_input_hpp'],
                'TRANS_DESC' =>  $post_data['txt_input_hjual'],
                'ACTIONS' => 'INPUT'
            );
        }
    }


    public function ajax_edit($kodebrg)
    {
        $data = $this->M_masterbarang->get_by_id($kodebrg);
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
        $list = $this->M_masterbarang->get_datatables($params);
        // $kuya=$this->input->post('txt_status');
        // die(var_dump($list));
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $listdata) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $listdata->kodebrg . ' <p>
            <a class="btn btn-pill btn-outline-primary btn-air-primary btn-xs" href="javascript:void(0)" title="Edit data" onclick="edit_data(' . "'" . $listdata->kodebrg . "'" . ')"><i class="fa fa-edit"></i> </a>
            <a class="btn btn-pill btn-outline-danger btn-air-danger btn-xs" href="javascript:void(0)" title="Delete Permanen" onclick="delete_data(' . "'" . $listdata->kodebrg . "'" . ')"><i class="fa fa-trash-o"></i> </a>';
            $row[] = $listdata->barcode;
            $row[] = $listdata->namabrg;
            $row[] = $listdata->stokakhir;
            $row[] = $listdata->hpp;
            $row[] = $listdata->hjual1;
            $row[] = $listdata->profit;
            $row[] = $listdata->TotAsset;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_masterbarang->count_all(),
            "recordsFiltered" => $this->M_masterbarang->count_filtered($params),
            "data" => $data,
        );
        // die(var_dump($output));
        echo json_encode($output);
    }
    public function update_proses()
    {
        $this->load->library('form_validation');
        $out['is_error']       = true;
        $out['error_message']  = "";
        $post_data  = $this->input->post();
        $this->form_validation->set_rules('txt_input_kodebrg', 'Input Kode', 'required');
        $this->form_validation->set_rules('txt_input_barcode', 'Input Barcode', 'required');
        $this->form_validation->set_rules('txt_input_kelompok', 'Input Kelompok', 'required');
        $this->form_validation->set_rules('txt_input_dept', 'Input dept', 'unrequired');
        $this->form_validation->set_rules('txt_input_satuan', 'Input satuan', 'required');
        $this->form_validation->set_rules('txt_input_namabrg', 'Input Nama', 'required');
        $this->form_validation->set_rules('txt_input_stokakhir', 'Input Stok', 'required');
        $this->form_validation->set_rules('txt_input_hpp', 'Input HPP', 'required');
        $this->form_validation->set_rules('txt_input_hjual', 'Input Price', 'required');
        $this->form_validation->set_rules('gambar1', 'Input Gambar', 'unrequired');

        if ($this->form_validation->run() == false) {
            $out['is_error']       = true;
            $out['error_message']  = validation_errors();
        } else {
            $gambar1 = $_FILES['gambar1']['tmp_name'];
            $txt_input_kodebrg = $this->input->post('txt_input_kodebrg');
            $target_file = 'upload/barang/';
            $imagePath =  $txt_input_kodebrg . ".png";
            move_uploaded_file($gambar1, $imagePath);
            $save_data = array(
                'gambar1' => $imagePath,
                'kodebrg' => $post_data['txt_input_kodebrg'],
                'barcode' => $post_data['txt_input_barcode'],
                'kodeklmpk' => $post_data['txt_input_kelompok'],
                'kodedept' => 01,
                'kodesat' => $post_data['txt_input_satuan'],
                'namabrg' => $post_data['txt_input_namabrg'],
                'stokakhir' => $post_data['txt_input_stokakhir'],
                'hpp' => $post_data['txt_input_hpp'],
                'hjual1' => $post_data['txt_input_hjual'],
            );

            // die(var_dump($post_data['txt_input_kodebrg']));
            $this->M_masterbarang->update(array('kodebrg' => $this->input->post('txt_input_kodebrg')), $save_data);
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
    public function delete_permanen($kodebrg)
    {
        $item = $this->M_masterbarang->get_by_id($kodebrg);
        if ($item->gambar1 != NULL) {
            $target_file = './upload/barang/' . $item->kodebrg . ".png";
            unlink($target_file);
        }

        $this->M_masterbarang->delete_by_id($kodebrg);
        echo json_encode(array("kodebrg" => NULL));
        $SQLmas = $this->db->query("SELECT * from inv.barang");
        if ($SQLmas->num_rows() == '') {
            $this->db->query("ALTER TABLE inv.barang");
            $this->session->redirect('C_masterbarang');
        }
    }
}
