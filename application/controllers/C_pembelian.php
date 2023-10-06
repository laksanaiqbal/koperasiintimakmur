<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class C_pembelian extends CI_Controller
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
        $this->load->model('M_pembelian');
        $this->load->model('M_Dpembelian');
        $this->load->model('M_detailpembelian');
        $this->load->model('M_satuan');
        $this->load->model('M_suplier');
        $this->load->model('M_masterbarang');
        $this->load->model('M_kelompokbarang');
    }
    public function index()
    {
        $data = array(
            'title_form' => 'Purchase List',
            'url_back'   => site_url('C_pembelian')
        );
        $data['datasat'] = $this->M_satuan->getdata();
        $data['databarang'] = $this->M_masterbarang->getdata();
        $data['datasup'] = $this->M_suplier->getdata();
        $data['datapembelian'] = $this->M_Dpembelian->getdata();
        $data['datakelompok'] = $this->M_kelompokbarang->getdata();
        $data['Epembelian'] = $this->M_pembelian->getdata();
        $data['sum'] = $this->M_pembelian->get_sum();

        $this->load->view('template/header');
        $this->load->view('purchase/index', $data);
        $this->load->view('template/footer');
    }

    public function ajax_list_showbarang()
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
        $list = $this->M_masterbarang->get_datatabless($params);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $listdata) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $listdata->kodebrg;
            $row[] = $listdata->barcode;
            $row[] = $listdata->namabrg;
            $row[] = $listdata->hpp;
            $row[] = $listdata->hjual1;
            $row[] = '<a href="javascript:void(0)" class="btn btn-primary btn-xs" data-bs-dismiss="modal" title="Pilih Data" onclick="pilihbarang(' . "'" . $listdata->kodebrg . "'" . ')"><i class="fa fa-check-square-o"></i> Select</a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_masterbarang->count_all(),
            "recordsFiltered" => $this->M_masterbarang->count_filtered($params),
            "data" => $data,
        );
        echo json_encode($output);
    }


    public function ajax_list_sup()
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
        $list = $this->M_suplier->get_datatables($params);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $listdata) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $listdata->kodesup;
            $row[] = $listdata->namasup;
            $row[] = $listdata->telepon;
            $row[] = $listdata->Bank;
            $row[] = $listdata->ACBank;
            $row[] = $listdata->alamat;
            $row[] = '<a href="javascript:void(0)" class="btn btn-primary btn-xs" data-bs-dismiss="modal" title="Pilih Data" onclick="pilihsup(' . "'" . $listdata->kodesup . "'" . ')"><i class="fa fa-check-square-o"></i> Select</a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_suplier->count_all(),
            "recordsFiltered" => $this->M_suplier->count_filtered($params),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function ajax_list_Epembelian()
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

        $list = $this->M_pembelian->get_datatables($params);
        // $kuya=$this->input->post('txt_status');
        // die(var_dump($list));
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $listdata) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $listdata->id_detail . '<p> 
            <a class="btn btn-pill btn-outline-primary btn-air-primary btn-xs" href="javascript:void(0)" title="Edit data" onclick="edit_data(' . "'" . $listdata->id_detail . "'" . ')"><i class="fa fa-edit"></i> </a>
            <a class="btn btn-pill btn-outline-danger btn-air-danger btn-xs"  href="javascript:void(0)" title="Delete Permanen" onclick="delete_data(' . "'" . $listdata->id_detail . "'" . ')"><i class="fa fa-trash-o"></i> </a>';
            $row[] = $listdata->namasup;
            $row[] = $listdata->namabrg;
            $row[] = $listdata->kode_detail;
            $row[] = $listdata->harga_beli;
            $row[] = $listdata->harga_jual;
            $row[] = $listdata->qty;
            $row[] = $listdata->total;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_pembelian->count_all($params),
            "recordsFiltered" => $this->M_pembelian->count_filtered($params),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function input_proses()
    {
        $post_data  = $this->input->post();
        $this->form_validation->set_rules('kodebrg', 'Input id');
        $this->form_validation->set_rules('namabrg', 'Input barang', 'required');
        $this->form_validation->set_rules('kodedetail', 'Input KodeDetail');
        $this->form_validation->set_rules('hbeli', 'Input hargabeli', 'required');
        $this->form_validation->set_rules('hjual', 'Input hargajual', 'required');
        $this->form_validation->set_rules('qty', 'Input qty', 'required');
        $this->form_validation->set_rules('total', 'Input total');
        $this->form_validation->set_rules('kodesup', 'Input Kodesup', 'required');

        if ($this->form_validation->run() == false) {
            $out['is_error']       = true;
            $out['error_message']  = validation_errors();
        } else {
            $kodebrg = $this->input->post('kodebrg');
            $qty = $this->input->post('qty');
            $hbeli = $this->input->post('hbeli');
            $total = $qty * $hbeli;
            $microtime = substr((string)microtime(), 1, 8);
            $date = trim($microtime, ".");
            $save_data = array(
                'id_barang' => $post_data['kodebrg'],
                'kode_detail' => 'DB' . $date,
                'harga_beli' => $post_data['hbeli'],
                'harga_jual' => $post_data['hjual'],
                'qty' => $post_data['qty'],
                'id_sup' => $post_data['kodesup'],
                'total' => $total,
            );

            $this->M_pembelian->save($save_data);

            //masih bingung
            $hjual = $this->input->post('hjual');
            $hbeli = $this->input->post('hbeli');
            $save_harga = array(
                'hpp' => $post_data['hbeli'],
                'hjual1' => $post_data['hjual']
            );
            $this->M_masterbarang->update_harga(array('kodebrg' => $this->input->post('kodebrg')), $save_harga);

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
        echo json_encode($out);
    }
    public function update_proses()
    {
        $post_data  = $this->input->post();
        $this->form_validation->set_rules('kodebrg', 'Input id');
        $this->form_validation->set_rules('namabrg', 'Input barang');
        $this->form_validation->set_rules('kodedetail', 'Input KodeDetail');
        $this->form_validation->set_rules('hbeli', 'Input hargabeli');
        $this->form_validation->set_rules('hjual', 'Input hargajual');
        $this->form_validation->set_rules('jumlah', 'Input jumlah', 'required');
        $this->form_validation->set_rules('total', 'Input total');
        $this->form_validation->set_rules('id_detail', 'Input ID', 'required');

        if ($this->form_validation->run() == false) {
            $out['is_error']       = true;
            $out['error_message']  = validation_errors();
        } else {
            $qty = $this->input->post('jumlah');
            $hbeli = $this->input->post('hargabeli');
            $total = $qty * $hbeli;
            $save_data = array(
                'total' => $total,
                'qty' => $post_data['jumlah'],
                'id_detail' => $post_data['id_detail'],
            );

            //Save Pegawai
            $this->M_pembelian->update(array('id_detail' => $this->input->post('id_detail')), $save_data);
            // $this->M_pembelian->save_log($save_logs);

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
        echo json_encode($out);
    }
    public function ajax_edit($id_detail)
    {
        $data = $this->M_pembelian->get_by_id($id_detail);
        echo json_encode($data);
    }

    public function ajax_show($kodebrg)
    {
        $data = $this->M_masterbarang->get_by_id($kodebrg);
        echo json_encode($data);
    }
    public function ajax_show_sup($kodesup)
    {
        $data = $this->M_suplier->get_by_id($kodesup);
        echo json_encode($data);
    }
    public function simpan_pembelian()
    {
        $post_data  = $this->input->post();
        $this->form_validation->set_rules('tanggal', 'Input tanggal', 'required');
        $this->form_validation->set_rules('faktur', 'Input Faktur', 'required');
        $this->form_validation->set_rules('diskon', 'Input Diskon');
        $this->form_validation->set_rules('total', 'Input total', 'required');
        $this->form_validation->set_rules('metode', 'Input metode', 'required');
        $this->form_validation->set_rules('bayar', 'Input Bayar', 'required');
        $this->form_validation->set_rules('kembalian', 'Input kembalian');


        if ($this->form_validation->run() == false) {
            $out['is_error']       = true;
            $out['error_message']  = validation_errors();
        } else {
            $total = $this->input->post('total');
            $bayar = $this->input->post('bayar');
            $kembalian = $bayar - $total;
            $microtime = substr((string)microtime(), 1, 8);
            $date = trim($microtime, ".");
            $save_data = array(
                'tgl_faktur' => $post_data['tanggal'],
                'kode_beli' => "PB-" . $date,
                'faktur_beli' => $post_data['faktur'],
                'id_user' => $this->session->userdata('ID'),
                'diskon' => $post_data['diskon'],
                'g_total' => $post_data['total'],
                'metode' => $post_data['metode'],
                'bayar' => $post_data['bayar'],
                'kembalian' => $kembalian,
                'tgl' => date('Y-m-d H:i:s'),
            );
            $this->M_pembelian->save_pembelian($save_data);

            $idbeli = "select max(id_pembelian) as id_pembelian from pembelian";
            $id = implode($this->db->query($idbeli)->row_array());
            $sql = "update detail_pembelian set id_beli = '$id' where id_beli='0'";
            $this->db->query($sql);
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

        echo json_encode($out);
    }
    public function delete_permanen($id_detail)
    {
        $this->M_pembelian->delete_by_id($id_detail);
        echo json_encode(array("id_detail" => NULL));
        $SQLmas = $this->db->query("SELECT * from inv.detail_pembelian");
        if ($SQLmas->num_rows() == '') {
            $this->db->query("ALTER TABLE inv.detail_pembelian");
            $this->session->redirect('C_pembelian');
        }
    }
    public function status($id_detail)
    {
        $message['is_error']       = true;
        $message['succes_message']  = "";
        if (!empty($id_detail)) {
            $save_data = array(
                'status' => '2',
            );
            // die(var_dump($post_data['txt_input_kodebrg']));
            $this->M_detailpembelian->update(array('id_detail' => $id_detail), $save_data);
            $message['is_error']       = false;
            $message['succes_message']  = "Change data success";
        } else {
            $message['is_error']       = true;
            $message['error_message']  = "Errr!!!";
        }

        echo json_encode($message);
    }
    //Pembelian
    public function ajax_list_pembelian()
    {
        $start  = $_REQUEST['start']; //tambahan limit
        $length = $_REQUEST['length'];
        $params = array();

        if ($this->input->post('kode_beli')) {
            $params['kode_beli'] = $this->input->post('kode_beli');
        }
        if ($this->input->post('txt_tgl_start')) {
            $params['txt_tgl_start'] = $this->input->post('txt_tgl_start');
        }
        if ($this->input->post('txt_tgl_end')) {
            $params['txt_tgl_end'] = $this->input->post('txt_tgl_end');
        }
        if ($length != -1) {
            $params['limit'] = $length; //tambahan limit
            $params['start'] = $start;
        }
        $list = $this->M_Dpembelian->get_datatables($params);
        $data = array();
        foreach ($list as $listdata) {
            $row = array();
            $row[] = $listdata->kode_beli;
            $row[] = $listdata->faktur_beli;
            $row[] = $listdata->tgl_faktur;
            $row[] = $listdata->diskon;
            $row[] = $listdata->g_total;
            $row[] = $listdata->metode;
            $row[] = '<a class="btn btn-pill btn-outline-warning btn-air-warning btn-xs" href="javascript:void(0)" title="Detail"  onclick="detail(' . "'" . $listdata->id_pembelian . "'" . ')"><i class="fa fa-toggle-down"></i> </a>';
            $data[] = $row;
        }
        $output = array(
            "start" => $start,
            "limit" => $length,
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_Dpembelian->count_all($params),
            "recordsFiltered" => $this->M_Dpembelian->count_filtered($params),
            "data" => $data,
        );
        // die(var_dump($output));
        echo json_encode($output);
    }

    //detail pembelian
    public function ajax_list_detail()
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
        $list = $this->M_detailpembelian->get_datatables($params);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $listdata) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $listdata->kode_detail;
            $row[] = $listdata->namabrg;
            $row[] = $listdata->qty;
            $row[] = $listdata->namasat;
            $row[] = $listdata->total;
            if ($listdata->status == 2) {
                $row[] = '<span style="color:white" class="badge bg-success"></i>Proses</span>';
            } else {
                $row[] = '<span style="color:white" class="badge bg-danger"></i>Belum Proses</span>';
            }
            $row[] = '<a class="btn btn-pill btn-outline-info btn-air-warning btn-xs" href="javascript:void(0)" title="Change Status" onclick="status(' . "'" . $listdata->id_detail . "'" . ')"><i class="fa fa-send"></i></a>';

            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_detailpembelian->count_all(),
            "recordsFiltered" => $this->M_detailpembelian->count_filtered($params),
            "data" => $data,
        );
        echo json_encode($output);
        // exit;
    }
    public function ajax_detail($id_pembelian)
    {
        $data = $this->M_detailpembelian->get_by_id($id_pembelian);
        echo json_encode($data);
    }
}
