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
        $this->load->model('M_daftardepartemen');
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
        $data['datacabang'] = $this->M_daftardepartemen->getdata();


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

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $listdata) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $listdata->iddbeli . '<p> 
            <a class="btn btn-pill btn-outline-primary btn-air-primary btn-xs" href="javascript:void(0)" title="Edit data" onclick="edit_data(' . "'" . $listdata->iddbeli . "'" . ')"><i class="fa fa-edit"></i> </a>
            <a class="btn btn-pill btn-outline-danger btn-air-danger btn-xs"  href="javascript:void(0)" title="Delete Permanen" onclick="delete_data(' . "'" . $listdata->iddbeli . "'" . ')"><i class="fa fa-trash-o"></i> </a>';
            $row[] = $listdata->namabrg;
            $row[] = $listdata->hpp;
            $row[] = $listdata->hjual1;
            $row[] = $listdata->qtybeli;
            $row[] = $listdata->brutto;
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

    public function input_baru()
    {
        $post_data  = $this->input->post();
        $this->form_validation->set_rules('kodebrg', 'Input id');
        $this->form_validation->set_rules('namabrg', 'Input barang', 'required');
        $this->form_validation->set_rules('hbeli', 'Input hargabeli', 'required');
        $this->form_validation->set_rules('hjual', 'Input hargajual', 'required');
        $this->form_validation->set_rules('qty', 'Input qty', 'required');
        $this->form_validation->set_rules('total', 'Input total');

        if ($this->form_validation->run() == false) {
            $out['is_error']       = true;
            $out['error_message']  = validation_errors();
        } else {
            $qty = $this->input->post('qty');
            $hbeli = $this->input->post('hbeli');
            $total = $qty * $hbeli;
            $nobeli = $this->db->query("SELECT MAX(nobeli) as nobeli FROM inv.hbeli");
            foreach ($nobeli->result() as $row) {
                $nobelis = $row->nobeli;
                $microtime = substr((string)microtime(), 1, 8);
                $date = trim($microtime, ".");
                $save_data = array(
                    'kodebrg' => $post_data['kodebrg'],
                    'hpp' => $post_data['hbeli'],
                    'hjual1' => $post_data['hjual'],
                    'qtybeli' => $post_data['qty'],
                    'brutto' => $total,
                    'tanggal' => date('Y-m-d'),
                    'nobeli' => $nobelis,
                );
                $this->M_pembelian->save($save_data);
            }


            $tbrutto = $this->db->query("SELECT a.tbrutto,a.nobeli, b.nobeli FROM inv.hbeli a JOIN inv.dbeli b ON a.nobeli=b.nobeli where a.nobeli='" . $nobelis . "'");
            foreach ($tbrutto->result() as $row) {
                $brutto = $row->tbrutto;
                $tbruttobaru = $brutto + $total;
                $save_tbrutto = array(
                    'tbrutto' => $tbruttobaru,
                );
                $this->M_Dpembelian->update(array('nobeli' => $row->nobeli), $save_tbrutto);
            }

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
    public function input_proses()
    {
        $post_data  = $this->input->post();
        $this->form_validation->set_rules('nobeli', 'Input nobeli', 'required');
        $this->form_validation->set_rules('kodebrg', 'Input id');
        $this->form_validation->set_rules('namabrg', 'Input barang', 'required');
        $this->form_validation->set_rules('hbeli', 'Input hargabeli', 'required');
        $this->form_validation->set_rules('hjual', 'Input hargajual', 'required');
        $this->form_validation->set_rules('qty', 'Input qty', 'required');
        $this->form_validation->set_rules('total', 'Input total');

        if ($this->form_validation->run() == false) {
            $out['is_error']       = true;
            $out['error_message']  = validation_errors();
        } else {
            $nobeli = $this->input->post('nobeli');
            $qty = $this->input->post('qty');
            $hbeli = $this->input->post('hbeli');
            $total = $qty * $hbeli;
            $microtime = substr((string)microtime(), 1, 8);
            $date = trim($microtime, ".");
            $save_data = array(
                'kodebrg' => $post_data['kodebrg'],
                'hpp' => $post_data['hbeli'],
                'hjual1' => $post_data['hjual'],
                'qtybeli' => $post_data['qty'],
                'brutto' => $total,
                'tanggal' => date('Y-m-d'),
                'nobeli' => $post_data['nobeli'],
            );
            $this->M_pembelian->save($save_data);

            $tbrutto = $this->db->query("SELECT a.tbrutto,a.nobeli, b.nobeli FROM inv.hbeli a JOIN inv.dbeli b ON a.nobeli=b.nobeli where a.nobeli='" . $nobeli . "'");
            foreach ($tbrutto->result() as $row) {
                $brutto = $row->tbrutto;
                $tbruttobaru = $brutto + $total;
                $save_tbrutto = array(
                    'tbrutto' => $tbruttobaru,
                );
                $this->M_Dpembelian->update(array('nobeli' => $this->input->post('nobeli')), $save_tbrutto);
            }

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
        $this->form_validation->set_rules('hbeli', 'Input hargabeli');
        $this->form_validation->set_rules('hjual', 'Input hargajual');
        $this->form_validation->set_rules('jumlah', 'Input jumlah', 'required');
        $this->form_validation->set_rules('total', 'Input total');
        $this->form_validation->set_rules('id_detail', 'Input ID', 'required');
        $this->form_validation->set_rules('nobeli', 'Input ID', 'required');

        if ($this->form_validation->run() == false) {
            $out['is_error']       = true;
            $out['error_message']  = validation_errors();
        } else {
            $qty = $this->input->post('jumlah');
            $hbeli = $this->input->post('hargabeli');
            $total = $qty * $hbeli;
            $save_data = array(
                'brutto' => $total,
                'qtybeli' => $post_data['jumlah'],
                'iddbeli' => $post_data['id_detail'],
                'nobeli' => $post_data['nobeli'],
            );
            $nobeli = $this->input->post('nobeli');
            $bruttos = $this->input->post('brutto');
            $tbrutto = $this->db->query("SELECT a.tbrutto,a.nobeli, b.nobeli FROM inv.hbeli a JOIN inv.dbeli b ON a.nobeli=b.nobeli where a.nobeli='" . $nobeli . "'");
            foreach ($tbrutto->result() as $row) {
                $brutto = $row->tbrutto;
                $tbruttolama = $brutto - $bruttos;
                $tbruttobaru = $tbruttolama + $total;
                $save_tbrutto = array(
                    'tbrutto' => $tbruttobaru,
                );
                $this->M_Dpembelian->update(array('nobeli' => $this->input->post('nobeli')), $save_tbrutto);
            }
            //Save Pegawai
            $this->M_pembelian->update(array('iddbeli' => $this->input->post('id_detail')), $save_data);

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
    public function ajax_edit($iddbeli)
    {
        $data = $this->M_pembelian->get_by_id($iddbeli);
        echo json_encode($data);
    }
    public function ajax_confirm($iddbeli)
    {
        $data = $this->M_pembelian->get_by_id($iddbeli);
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
        $this->form_validation->set_rules('diskon', 'Input Diskon');
        $this->form_validation->set_rules('total', 'Input total', 'required');
        $this->form_validation->set_rules('metode', 'Input metode', 'required');
        $this->form_validation->set_rules('bayar', 'Input Bayar', 'required');
        $this->form_validation->set_rules('kembalian', 'Input kembalian');
        $this->form_validation->set_rules('kodesup', 'Input Kodesup');



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
                'tanggal' => $post_data['tanggal'],
                // 'id_user' => $this->session->userdata('ID'),
                'disc1' => $post_data['diskon'],
                'tbrutto' => $post_data['total'],
                'hutang' => $post_data['metode'],
                'biaya' => $post_data['bayar'],
                'potongan' => $kembalian,
                'kodesup' => $post_data['kodesuplier'],
                'idcabang' => $post_data['cabangs'],
                'hutang' => $post_data['payments'],
            );
            $this->M_pembelian->save_pembelian($save_data);

            $idbeli = "select max(nobeli) as nobeli from hbeli";
            $id = implode($this->db->query($idbeli)->row_array());
            $sql = "update dbeli set nobeli = '$id' where nobeli='0'";
            $this->db->query($sql);

            $idsup = "select max(kodesup) as kodesup from hbeli";
            $ids = implode($this->db->query($idsup)->row_array());
            $sqls = "update dbeli set kodesup = '$ids' where kodesup='0'";
            $this->db->query($sqls);

            $idcabang = "select max(idcabang) as idcabang from hbeli";
            $idss = implode($this->db->query($idcabang)->row_array());
            $sqlss = "update dbeli set idcabang = '$idss' where idcabang='0'";
            $this->db->query($sqlss);
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
    public function delete_permanen($iddbeli)
    {
        $this->M_pembelian->delete_by_id($iddbeli);
        echo json_encode(array("iddbeli" => NULL));
        $SQLmas = $this->db->query("SELECT * from inv.dbeli");
        if ($SQLmas->num_rows() == '') {
            $this->db->query("ALTER TABLE inv.dbeli");
            $this->session->redirect('C_pembelian');
        }
    }
    public function status($iddbeli)
    {
        $message['is_error']       = true;
        $message['succes_message']  = "";
        if (!empty($iddbeli)) {
            $save_data = array(
                'post' => '1',
            );
            $this->M_detailpembelian->update(array('iddbeli' => $iddbeli), $save_data);
            $stok = $this->db->query("SELECT a.qtybeli,a.kodebrg, b.kodebrg, b.stokawal FROM inv.dbeli a JOIN inv.barang b ON a.kodebrg=b.kodebrg where a.iddbeli='" . $iddbeli . "'");
            foreach ($stok->result() as $row) {
                $stokawal = $row->stokawal;
                $qty = $row->qtybeli;
                $stokbaru = $stokawal + $qty;
                $save_harga = array(
                    'stokawal' => $stokbaru,
                );
                $this->M_masterbarang->update_harga(array('kodebrg' => $row->kodebrg), $save_harga);
            }
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

        if ($this->input->post('nobeli')) {
            $params['nobeli'] = $this->input->post('nobeli');
        }
        if ($this->input->post('kodesup')) {
            $params['kodesup'] = $this->input->post('kodesup');
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
        $no = $_POST['start'];
        foreach ($list as $listdata) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $listdata->idcabang;
            $row[] = $listdata->nobeli;
            $row[] = $listdata->tanggalreq;
            $row[] = $listdata->namasup;
            $row[] = $listdata->hutang;
            $row[] = $listdata->tbrutto;
            $row[] = '<a class="btn btn-pill btn-outline-primary btn-air-primary btn-xs" href="javascript:void(0)" title="Edit data" onclick="edit_data_pembelian(' . "'" . $listdata->nobeli . "'" . ')"><i class="fa fa-edit"></i> </a>';
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
            $row[] = $listdata->namabrg;
            $row[] = $listdata->qtybeli;
            $row[] = $listdata->namasat;
            $row[] = $listdata->brutto;
            // if ($listdata->post == 1) {
            //     $row[] = '<span style="color:white" class="badge bg-success"></i>Proses</span>';
            // } else {
            //     $row[] = '<a class="btn btn-pill btn-air-warning btn-xs" href="javascript:void(0)" title="Change Status" onclick="status(' . "'" . $listdata->iddbeli . "'" . ')"><span style="color:white" class="badge bg-danger"></i>Belum Proses</span></a>';
            // }
            $row[] = '<a class="btn btn-pill btn-outline-primary btn-air-primary btn-xs" href="javascript:void(0)" title="Edit data" onclick="edit_data(' . "'" . $listdata->iddbeli . "'" . ')"><i class="fa fa-edit"></i> </a>';
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
    public function ajax_detail($nobeli)
    {
        $data = $this->M_detailpembelian->get_by_id($nobeli);
        echo json_encode($data);
    }

    //alur baru
    public function save_header()
    {
        $post_data  = $this->input->post();
        $this->form_validation->set_rules('cabang', 'Input cabang', 'required');
        $this->form_validation->set_rules('payment', 'Input metode', 'required');
        $this->form_validation->set_rules('kodesup', 'Input Kodesup', 'required');
        $this->form_validation->set_rules('tanggalreq', 'Input tanggalreq');
        $this->form_validation->set_rules('tanggaldel', 'Input tanggaldel');
        $this->form_validation->set_rules('ppn', 'Input ppn');
        $this->form_validation->set_rules('faktur', 'Input faktur');
        $this->form_validation->set_rules('diskon', 'Input diskon');

        if ($this->form_validation->run() == false) {
            $out['is_error']       = true;
            $out['error_message']  = validation_errors();
        } else {
            $save_data = array(
                'idcabang' => $post_data['cabang'],
                'hutang' => $post_data['payment'],
                'kodesup' => $post_data['kodesup'],
                'tanggalreq' => $post_data['tanggalreq'],
                'tanggaldel' => $post_data['tanggaldel'],
                'ppn' => $post_data['ppn'],
                'faktur' => $post_data['faktur'],
                'disc1' => $post_data['diskon'],
            );
            $this->M_Dpembelian->save($save_data);

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
    public function ajax_edit_pembelian($nobeli)
    {
        $data = $this->M_Dpembelian->get_by_id($nobeli);
        echo json_encode($data);
    }
    public function edit_header()
    {
        $post_data  = $this->input->post();
        $this->form_validation->set_rules('cabangs', 'Input cabang', 'required');
        $this->form_validation->set_rules('payments', 'Input metode', 'required');
        $this->form_validation->set_rules('kodesups', 'Input Kodesup', 'required');
        $this->form_validation->set_rules('tanggalreqs', 'Input tanggalreq');
        $this->form_validation->set_rules('tanggaldels', 'Input tanggaldel');
        $this->form_validation->set_rules('ppns', 'Input ppn');
        $this->form_validation->set_rules('fakturs', 'Input faktur');
        $this->form_validation->set_rules('diskons', 'Input diskon');
        $this->form_validation->set_rules('nobelis', 'Input nobeli', 'required');

        if ($this->form_validation->run() == false) {
            $out['is_error']       = true;
            $out['error_message']  = validation_errors();
        } else {
            $save_data = array(
                'idcabang' => $post_data['cabangs'],
                'hutang' => $post_data['payments'],
                'kodesup' => $post_data['kodesups'],
                'tanggalreq' => $post_data['tanggalreqs'],
                'tanggaldel' => $post_data['tanggaldels'],
                'ppn' => $post_data['ppns'],
                'faktur' => $post_data['fakturs'],
                'disc1' => $post_data['diskons'],
                'nobeli' => $post_data['nobelis'],
            );
            $this->M_Dpembelian->update(array('nobeli' => $this->input->post('nobelis')), $save_data);

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
}
