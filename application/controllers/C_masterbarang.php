<?php
defined('BASEPATH') or exit('No direct script access allowed');

use phpDocumentor\Reflection\Types\Array_;
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
        $this->load->model('M_masterbarang_logger');
        $this->load->model('M_daftardepartemen');
        $this->load->model('M_satuan');
    }

    public function index()
    {
        $data = array(
            'title_form' => '<i class="fa fa-arrow-circle-right"></i> Master Barang',
            'url_back'   => site_url('C_masterbarang'),
        );

        $data['databarang'] = $this->M_masterbarang->getdata();
        $data['datakelompok'] = $this->M_kelompokbarang->getdata();
        $data['datadept'] = $this->M_daftardepartemen->getdata();
        $data['datasat'] = $this->M_satuan->getdata();

        $this->load->view('template/header');
        $this->load->view('masterbarang/index', $data);
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
        $list = $this->M_masterbarang->get_datatables($params);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $listdata) {
            if (!empty($listdata->kodebrg)) {
                $no++;
                $row = array();
                $row[] = $no;
                if ($listdata->status == 1) {
                    $row[] = $listdata->kodebrg . ' <p>
                    <a class="btn btn-pill btn-outline-primary btn-air-primary btn-xs" href="javascript:void(0)" title="Edit data" onclick="edit_data(' . "'" . $listdata->kodebrg . "'" . ')"><i class="fa fa-edit"></i> </a>
                    <a class="btn btn-pill btn-outline-danger btn-air-warning btn-xs" href="javascript:void(0)" title="Cancel Data" onclick="disable_data(' . "'" . $listdata->kodebrg . "'" . ')"><i class="fa fa-xing"></i> </a>
                    <a class="btn btn-pill btn-outline-info btn-air-info btn-xs" href="javascript:void(0)" title="Log data"  onclick="data_logger(' . "'" . $listdata->kodebrg . "'" . ')"><i class="fa fa-rotate-left"></i> </a>
                    <a class="btn btn-pill btn-outline-warning btn-air-warning btn-xs" href="javascript:void(0)" title="Open Image" onclick="showgambar(' . "'" . $listdata->kodebrg . "'" . ')"><i class="fa fa-image"></i></a>';
                    $row[] = $listdata->barcode;
                    $row[] = $listdata->namabrg;
                    $row[] = $listdata->stokawal;
                    $row[] = $listdata->stokmin;
                    $row[] = $listdata->stokmax;
                    $row[] = $listdata->hpp;
                    $row[] = $listdata->hjual1;
                    $row[] = $listdata->profit;
                    if ($listdata->kodekategori == 1) {
                        $row[] = '<span style="color:white" class="badge bg-success"></i>Non-Konsinyasi</span>';
                    } else {
                        $row[] = '<span style="color:white" class="badge bg-danger"></i>Konsinyasi</span>';
                    }
                    $data[] = $row;
                } elseif ($listdata->status == 2) {
                    $row[] = $listdata->kodebrg . ' <p>
                    <a class="btn btn-pill btn-outline-info btn-air-info btn-xs" href="javascript:void(0)" title="Log data"  onclick="data_logger(' . "'" . $listdata->kodebrg . "'" . ')"><i class="fa fa-rotate-left"></i> </a>
                    <a class="btn btn-pill btn-outline-success btn-air-success btn-xs" href="javascript:void(0)" title="Recovery Data" onclick="recover(' . "'" . $listdata->kodebrg . "'" . ')"><i class="fa fa-recycle"></i> </a>
                    <a class="btn btn-pill btn-outline-danger btn-air-danger btn-xs" href="javascript:void(0)" title="Delete Permanen" onclick="delete_data(' . "'" . $listdata->kodebrg . "'" . ')"><i class="fa fa-trash-o"></i> </a>';
                    $row[] = $listdata->barcode;
                    $row[] = $listdata->namabrg;
                    $row[] = $listdata->stokawal;
                    $row[] = $listdata->stokmin;
                    $row[] = $listdata->stokmax;
                    $row[] = $listdata->hpp;
                    $row[] = $listdata->hjual1;
                    $row[] = $listdata->profit;
                    if ($listdata->kodekategori == 1) {
                        $row[] = '<span style="color:white" class="badge bg-success"></i>Non-Konsinyasi</span>';
                    } else {
                        $row[] = '<span style="color:white" class="badge bg-danger"></i>Konsinyasi</span>';
                    }
                    $data[] = $row;
                }
            }
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_masterbarang->count_all(),
            "recordsFiltered" => $this->M_masterbarang->count_filtered($params),
            "data" => $data,
        );
        echo json_encode($output);
        // exit;
    }
    public function ajax_logger_edit($id)
    {
        $data = $this->M_masterbarang_logger->get_by_id($id);
        echo json_encode($data);
    }
    public function ajax_edit($kodebrg)
    {
        $data = $this->M_masterbarang->get_by_id($kodebrg);
        echo json_encode($data);
    }
    public function ajax_showimage($kodebrg)
    {
        $data = $this->M_masterbarang->get_by_id($kodebrg);
        echo json_encode($data);
    }
    public function ajax_openimage($kodebrg)
    {
        $data = $this->M_masterbarang->get_by_id($kodebrg);
        echo json_encode($data);
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
        $list = $this->M_masterbarang_logger->get_datatables($params);
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
            "recordsTotal" => $this->M_masterbarang_logger->count_all(),
            "recordsFiltered" => $this->M_masterbarang_logger->count_filtered($params),
            "data" => $data,
        );
        echo json_encode($output);
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
        $this->form_validation->set_rules('txt_input_stokawal', 'Input Stok', 'required');
        $this->form_validation->set_rules('txt_input_stokmin', 'Input Stok', 'required');
        $this->form_validation->set_rules('txt_input_stokmax', 'Input Stok', 'required');
        $this->form_validation->set_rules('txt_input_hpp', 'Input HPP', 'required');
        $this->form_validation->set_rules('txt_input_hjual', 'Input Price', 'required');
        $this->form_validation->set_rules('txt_input_kodekategori', 'Input Kode Kategori', 'required');
        $this->form_validation->set_rules('gambar1', 'Input Gambar', 'unrequired');

        if ($this->form_validation->run() == false) {
            $out['is_error']       = true;
            $out['error_message']  = validation_errors();
        } else {
            $gambar1 = $_FILES['gambar1']['tmp_name'];
            $txt_input_kodebrg = $this->input->post('txt_input_kodebrg');
            $target_file = './assets/barang/';
            $imagePath = $target_file . $txt_input_kodebrg . ".png";
            $imagename = $txt_input_kodebrg . ".png";
            move_uploaded_file($gambar1, $imagePath);
            $save_data = array(
                'kodebrg' => $post_data['txt_input_kodebrg'],
                'barcode' => $post_data['txt_input_barcode'],
                'kodeklmpk' => $post_data['txt_input_kelompok'],
                'kodedept' => '01',
                'kodesat' => $post_data['txt_input_satuan'],
                'namabrg' => $post_data['txt_input_namabrg'],
                'stokawal' => $post_data['txt_input_stokawal'],
                'stokmin' => $post_data['txt_input_stokmin'],
                'stokmax' => $post_data['txt_input_stokmax'],
                'hpp' => $post_data['txt_input_hpp'],
                'hjual1' => $post_data['txt_input_hjual'],
                'kodekategori' => $post_data['txt_input_kodekategori'],
                'gambar1' => $imagename,
            );
            $save_logs = array(
                'USER_ID' => $this->session->userdata('ID'),
                'USER_NAME' => $this->session->userdata('USER_NAME'),
                'EMP_NAME' => $this->session->userdata('NAMA'),
                'TABLE_NAME' => 'inv.barang',
                'TRANS_ID' =>  $post_data['txt_input_kodebrg'],
                'TRANS_DESC' =>  $post_data['txt_input_namabrg'],
                'CREATE_SYSTEM' =>  date('Y-m-d H:i:s'),
                'ACTIONS' => 'INPUT'
            );

            $this->M_masterbarang->save($save_data);
            $this->M_masterbarang->save_log($save_logs);
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
        //Save Master Barang Logs

        echo json_encode($out);
    }
    public function update_proses()
    {
        $this->load->library('form_validation');
        $out['is_error']       = true;
        $out['error_message']  = "";
        $post_data  = $this->input->post();
        $this->form_validation->set_rules('idupdate', 'Input Kode Barang', 'required');
        $this->form_validation->set_rules('barcodes', 'Input Barcode', 'required');
        $this->form_validation->set_rules('kelompoks', 'Input Kelompok', 'required');
        $this->form_validation->set_rules('satuans', 'Input satuan', 'required');
        $this->form_validation->set_rules('namabarang', 'Input Nama', 'required');
        $this->form_validation->set_rules('stokakhirs', 'Input Stok');
        $this->form_validation->set_rules('stokmins', 'Input Stok', 'required');
        $this->form_validation->set_rules('stokmaxs', 'Input Stok', 'required');
        $this->form_validation->set_rules('hpps', 'Input HPP', 'required');
        $this->form_validation->set_rules('hjuals', 'Input Price', 'required');
        $this->form_validation->set_rules('kodekategoris', 'Input Kategori', 'required');
        $this->form_validation->set_rules('image', 'Input Gambar', 'unrequired');

        if ($this->form_validation->run() == false) {
            $out['is_error']       = true;
            $out['error_message']  = validation_errors();
        } else {
            $image = $_FILES['image']['tmp_name'];
            $kodebrg = $this->input->post('kodebarang');
            $target_file = './assets/barang/';
            $imagePath = $target_file . $kodebrg . ".png";
            $imagename = $kodebrg . ".png";
            move_uploaded_file($image, $imagePath);
            $stokawal = $this->input->post('stokawals');
            $stokakhir = $this->input->post('stokakhirs');
            if (!empty($stokakhir)) {
                $stokbaru = $stokawal + $stokakhir;
            } elseif (empty($stokakhir)) {
                $stokbaru = $stokawal;
            } elseif ($stokakhir == NULL) {
                $stokbaru = '0';
            }
            $stokmax = $this->input->post('stokmaxs');
            $stokmin = $this->input->post('stokmins');
            if ($stokbaru > $stokmax) {
                $stokbaru = $stokawal;
            } elseif ($stokbaru < $stokmin) {
                $stokbaru = $stokawal;
            }
            $save_data = array(
                'gambar1' => $imagename,
                'kodebrg' => $post_data['idupdate'],
                'barcode' => $post_data['barcodes'],
                'kodeklmpk' => $post_data['kelompoks'],
                'kodedept' => '01',
                'kodesat' => $post_data['satuans'],
                'namabrg' => $post_data['namabarang'],
                'stokawal' => $stokbaru,
                'stokmin' => $post_data['stokmins'],
                'stokmax' => $post_data['stokmaxs'],
                'hpp' => $post_data['hpps'],
                'hjual1' => $post_data['hjuals'],
                'kodekategori' => $post_data['kodekategoris'],
                'status' => '1',
            );
            $save_logs = array(
                'USER_ID' => $this->session->userdata('ID'),
                'USER_NAME' => $this->session->userdata('USER_NAME'),
                'EMP_NAME' => $this->session->userdata('NAMA'),
                'TABLE_NAME' => 'inv.barang',
                'TRANS_ID' =>  $post_data['idupdate'],
                'TRANS_DESC' =>  $post_data['namabarang'],
                'CREATE_SYSTEM' =>  date('Y-m-d H:i:s'),
                'ACTIONS' => 'UPDATES'
            );

            $this->M_masterbarang->update(array('kodebrg' => $this->input->post('idupdate')), $save_data);
            $this->M_masterbarang->save_log($save_logs);
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
            $target_file = './assets/barang/' . $item->kodebrg . ".png";
            unlink($target_file);
        }

        $this->M_masterbarang->delete_by_id($kodebrg);
        $this->M_masterbarang->delete_by_id_masterbaranglogs($kodebrg);
        echo json_encode(array("kodebrg" => NULL));
        $SQLmas = $this->db->query("SELECT * from inv.barang");
        if ($SQLmas->num_rows() == '') {
            $this->db->query("ALTER TABLE inv.barang");
            $this->session->redirect('C_masterbarang');
        }
    }
    public function delete_archive($kodebrg)
    {
        $message['is_error']       = true;
        $message['succes_message']  = "";
        if (!empty($kodebrg)) {
            $save_data = array(
                'STATUS' => '2',
            );
            $evdesc = $this->db->query("SELECT a.namabrg FROM inv.barang a where a.kodebrg='" . $kodebrg . "'");
            foreach ($evdesc->result() as $row) {
                $save_logs = array(
                    'USER_ID' => $this->session->userdata('ID'),
                    'USER_NAME' => $this->session->userdata('USER_NAME'),
                    'EMP_NAME' => $this->session->userdata('NAMA'),
                    'TABLE_NAME' => 'inv.barang',
                    'TRANS_ID' =>  $kodebrg,
                    'TRANS_DESC' =>  $row->namabrg,
                    'CREATE_SYSTEM' =>  date('Y-m-d H:i:s'),
                    'ACTIONS' => 'Temp.Del'
                );
            }

            // die(var_dump($post_data['txt_input_kodebrg']));
            $this->M_masterbarang->update(array('kodebrg' => $kodebrg), $save_data);
            $this->M_masterbarang->save_log($save_logs);
            $message['is_error']       = false;
            $message['succes_message']  = "Delete data success";
        } else {
            $message['is_error']       = true;
            $message['error_message']  = "Errr!!!";
        }

        echo json_encode($message);
    }
    public function recovery($kodebrg)
    {
        $message['is_error']       = true;
        $message['succes_message']  = "";
        if (!empty($kodebrg)) {
            $save_data = array(
                'STATUS' => '1',
            );
            $evdesc = $this->db->query("SELECT a.namabrg FROM inv.barang a where a.kodebrg='" . $kodebrg . "'");
            foreach ($evdesc->result() as $row) {
                $save_logs = array(
                    'USER_ID' => $this->session->userdata('ID'),
                    'USER_NAME' => $this->session->userdata('USER_NAME'),
                    'EMP_NAME' => $this->session->userdata('NAMA'),
                    'TABLE_NAME' => 'inv.barang',
                    'TRANS_ID' =>  $kodebrg,
                    'TRANS_DESC' =>  $row->namabrg,
                    'CREATE_SYSTEM' =>  date('Y-m-d H:i:s'),
                    'ACTIONS' => 'Recovery'
                );
            }

            // die(var_dump($post_data['txt_input_kodebrg']));
            $this->M_masterbarang->update(array('kodebrg' => $kodebrg), $save_data);
            $this->M_masterbarang->save_log($save_logs);
            $message['is_error']       = false;
            $message['succes_message']  = "Delete data success";
        } else {
            $message['is_error']       = true;
            $message['error_message']  = "Errr!!!";
        }

        echo json_encode($message);
    }
}
