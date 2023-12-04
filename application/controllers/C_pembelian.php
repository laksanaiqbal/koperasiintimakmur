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
            'title_form' => '<i class="fa fa-arrow-circle-right"></i> Purchase List',
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
            $row[] = 'Rp.' .  number_format($listdata->hpp, 0, '', '.');
            $row[] = 'Rp.' .  number_format($listdata->hjual1, 0, '', '.');
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
        if ($this->input->post('dbeli')) {
            $params['dbeli'] = $this->input->post('dbeli');
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
            $row[] = 'Rp.' .  number_format($listdata->brutto, 0, '', '.');
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->M_detailpembelian->count_all(),
            "recordsFiltered" => $this->M_detailpembelian->count_filtered($params),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function input_baru()
    {
        $post_data  = $this->input->post();
        $this->form_validation->set_rules('kodebrg', 'Input id');
        $this->form_validation->set_rules('nobeli', 'Input Nobeli', 'required');
        $this->form_validation->set_rules('namabrg', 'Input barang', 'required');
        $this->form_validation->set_rules('hbeli', 'Input hargabeli', 'required');
        $this->form_validation->set_rules('hjual', 'Input hargajual', 'required');
        $this->form_validation->set_rules('qty', 'Input qty', 'required');
        $this->form_validation->set_rules('note', 'Input note', 'required');
        $this->form_validation->set_rules('total', 'Input total');

        if ($this->form_validation->run() == false) {
            $out['is_error']       = true;
            $out['error_message']  = validation_errors();
        } else {
            $qty = $this->input->post('qty');
            $hbeli = $this->input->post('hbeli');
            $total = $qty * $hbeli;
            $nobeli = $this->input->post('nobeli');
            $microtime = substr((string)microtime(), 1, 8);
            // $date = trim($microtime, ".");
            $save_data = array(
                'kodebrg' => $post_data['kodebrg'],
                'nobeli' => $post_data['nobeli'],
                'hpp' => $post_data['hbeli'],
                'hjual1' => $post_data['hjual'],
                'qtybeli' => $post_data['qty'],
                'note' => $post_data['note'],
                'brutto' => $total,
                'tanggal' => date('Y-m-d'),
            );
            $this->M_detailpembelian->save($save_data);

            $tbrutto = $this->db->query("SELECT a.tbrutto,a.nobeli, b.nobeli FROM inv.hbeli a JOIN inv.dbeli b ON a.nobeli=b.nobeli where a.nobeli='" . $nobeli . "'");
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
        $this->form_validation->set_rules('nobelis', 'Input nobeli', 'required');
        $this->form_validation->set_rules('kodebrg', 'Input id');
        $this->form_validation->set_rules('namabrg', 'Input barang', 'required');
        $this->form_validation->set_rules('hbeli', 'Input hargabeli', 'required');
        $this->form_validation->set_rules('hjual', 'Input hargajual', 'required');
        $this->form_validation->set_rules('qty', 'Input qty', 'required');
        $this->form_validation->set_rules('note', 'Input note', 'required');
        $this->form_validation->set_rules('total', 'Input total');

        if ($this->form_validation->run() == false) {
            $out['is_error']       = true;
            $out['error_message']  = validation_errors();
        } else {
            $nobeli = $this->input->post('nobelis');
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
                'note' => $post_data['note'],
                'brutto' => $total,
                'tanggal' => date('Y-m-d'),
                'nobeli' => $post_data['nobelis'],
            );
            $this->M_pembelian->save($save_data);

            $tbrutto = $this->db->query("SELECT a.tbrutto,a.nobeli, b.nobeli FROM inv.hbeli a JOIN inv.dbeli b ON a.nobeli=b.nobeli where a.nobeli='" . $nobeli . "'");
            foreach ($tbrutto->result() as $row) {
                $brutto = $row->tbrutto;
                $tbruttobaru = $brutto + $total;
                $save_tbrutto = array(
                    'tbrutto' => $tbruttobaru,
                );
                $this->M_Dpembelian->update(array('nobeli' => $this->input->post('nobelis')), $save_tbrutto);
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
    public function update_dbeli()
    {
        $post_data  = $this->input->post();
        $this->form_validation->set_rules('kodebrg', 'Input id');
        $this->form_validation->set_rules('namabrg', 'Input barang');
        $this->form_validation->set_rules('hargabeli', 'Input hargabeli');
        $this->form_validation->set_rules('hargajual', 'Input hargajual');
        $this->form_validation->set_rules('jumlah', 'Input jumlah', 'required');
        $this->form_validation->set_rules('bruttobaru', 'Input total');
        $this->form_validation->set_rules('brutto', 'Input total');
        $this->form_validation->set_rules('iddbeli', 'Input ID', 'required');
        $this->form_validation->set_rules('nobeli', 'Input Nobeli', 'required');
        $this->form_validation->set_rules('catatan', 'Input catatan', 'required');


        if ($this->form_validation->run() == false) {
            $out['is_error']       = true;
            $out['error_message']  = validation_errors();
        } else {
            //update dbeli
            $save_edit_dbeli = array(
                'iddbeli' => $post_data['iddbeli'],
                'brutto' => $post_data['bruttobaru'],
                'qtybeli' => $post_data['jumlah'],
                'hjual1' => $post_data['hargajual'],
                'hpp' => $post_data['hargabeli'],
                'note' => $post_data['catatan'],
            );
            $this->M_detailpembelian->update(array('iddbeli' => $this->input->post('iddbeli')), $save_edit_dbeli);

            //update masterbarang
            $save_harga_barang = array(
                'hpp' => $post_data['hargabeli'],
                'hjual1' => $post_data['hargajual']
            );
            $this->M_masterbarang->update_harga(array('kodebrg' => $this->input->post('kodebrg')), $save_harga_barang);

            //update total brutto
            $nobeli = $this->input->post('nobeli');
            $brutto = $this->input->post('brutto');
            $bruttobaru = $this->input->post('bruttobaru');
            $tbrutto = $this->db->query("SELECT a.tbrutto,a.nobeli, b.nobeli FROM inv.hbeli a JOIN inv.dbeli b ON a.nobeli=b.nobeli where a.nobeli='" . $nobeli . "'");
            foreach ($tbrutto->result() as $row) {
                $tbrutto = $row->tbrutto;
                $tbruttobaru = $tbrutto - $brutto;
                $tbruttojadi = $tbruttobaru + $bruttobaru;
                $save_tbrutto = array(
                    'tbrutto' => $tbruttojadi,
                );
                $this->M_Dpembelian->update_tbrutto(array('nobeli' => $this->input->post('nobeli')), $save_tbrutto);
            }



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

    public function edit_detail_beli($iddbeli)
    {
        $data = $this->M_detailpembelian->get_by_id($iddbeli);
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

    public function delete_permanen($iddbeli)
    {
        $tbrutto = $this->db->query("SELECT a.tbrutto,b.brutto, a.nobeli, b.nobeli,b.iddbeli FROM inv.hbeli a JOIN inv.dbeli b ON a.nobeli=b.nobeli where b.iddbeli='" . $iddbeli . "'");
        foreach ($tbrutto->result() as $row) {
            $nobeli = $row->nobeli;
            $brutto = $row->brutto;
            $tbrutto = $row->tbrutto;
            $tbruttobaru = $tbrutto - $brutto;
            $save_tbrutto = array(
                'tbrutto' => $tbruttobaru,
            );
            $this->M_Dpembelian->update_tbrutto(array('nobeli' => $nobeli), $save_tbrutto);
        }
        $this->M_detailpembelian->delete_by_id($iddbeli);
        echo json_encode(array("iddbeli" => NULL));
        $SQLmas = $this->db->query("SELECT * from inv.dbeli");
        if ($SQLmas->num_rows() == '') {
            $this->db->query("ALTER TABLE inv.dbeli");
            $this->session->redirect('C_pembelian');
        }
    }

    public function ajax_list_pembelian()
    {
        $start  = $_REQUEST['start']; //tambahan limit
        $length = $_REQUEST['length'];
        $params = array();

        if ($this->input->post('kodebeli')) {
            $params['kodebeli'] = $this->input->post('kodebeli');
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
            $row[] = $listdata->kodebeli;
            $row[] = $listdata->namacabang;
            $row[] = $listdata->tanggal;
            $row[] = $listdata->namasup;
            $row[] = 'Rp.' .  number_format($listdata->tbrutto, 0, '', '.');
            if ($listdata->post == 1) {
                $row[] = '<span style="color:white" class="badge bg-danger">Canceled</span><h5 style="text-align: center;"><a class="btn btn-pill btn-outline-success btn-air-success btn-xs" href="javascript:void(0)" title="Recovery Data" onclick="recycle(' . "'" . $listdata->nobeli . "'" . ')"><i class="fa fa-recycle"></i></a></h5>';
            } elseif ($listdata->post == 0) {
                $row[] = '<a class="btn btn-pill btn-outline-primary btn-air-primary btn-xs" href="javascript:void(0)" data-bs-target="#staticBackdrop" title="Edit data" onclick="edit_data_pembelian(' . "'" . $listdata->nobeli . "'" . ')"><i class="fa fa-edit"></i> </a>
                <a class="btn btn-pill btn-outline-danger btn-air-warning btn-xs" href="javascript:void(0)" title="cancel" onclick="cancel(' . "'" . $listdata->nobeli . "'" . ')"><i class="fa fa-xing"></i> </a><p>
                <a class="btn btn-pill btn-outline-warning btn-air-warning btn-xs" href="javascript:void(0)" data-bs-target="#staticBackdrop" title="Proses" onclick="proses(' . "'" . $listdata->nobeli . "'" . ')"><i class="fa fa-file-text-o"></i> </a>
                <a class="btn btn-pill btn-outline-info btn-air-info btn-xs" href="javascript:void(0)"  title="print" onclick="print_pembelian(' . "'" . $listdata->nobeli . "'" . ')"><i class="fa fa-print"></i></a>';
            } elseif ($listdata->post == 2) {
                $row[] = '<a class="btn btn-pill btn-outline-info btn-air-info btn-xs" href="javascript:void(0)" title="print" onclick="print_pembelian(' . "'" . $listdata->nobeli . "'" . ')"><i class="fa fa-print"></i></a>';
            } elseif ($listdata->post == 3) {
                $row[] = '<span style="color:white" class="badge bg-success">Finish</span>';
            }
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
    public function cancel($nobeli)
    {
        $message['is_error']       = true;
        $message['succes_message']  = "";
        if (!empty($nobeli)) {
            $save_data = array(
                'post' => '1',
            );
            $this->M_Dpembelian->update(array('nobeli' => $nobeli), $save_data);
            $message['is_error']       = false;
            $message['succes_message']  = "Change data success";
        } else {
            $message['is_error']       = true;
            $message['error_message']  = "Errr!!!";
        }

        echo json_encode($message);
    }
    public function recycle($nobeli)
    {
        $message['is_error']       = true;
        $message['succes_message']  = "";
        if (!empty($nobeli)) {
            $save_data = array(
                'post' => '0',
            );
            $this->M_Dpembelian->update(array('nobeli' => $nobeli), $save_data);
            $message['is_error']       = false;
            $message['succes_message']  = "Change data success";
        } else {
            $message['is_error']       = true;
            $message['error_message']  = "Errr!!!";
        }

        echo json_encode($message);
    }

    public function proses()
    {
        $post_data  = $this->input->post();
        $this->form_validation->set_rules('idtemp4', 'Input nobeli', 'required');

        if ($this->form_validation->run() == false) {
            $out['is_error']       = true;
            $out['error_message']  = validation_errors();
        } else {
            $nobeli = $this->input->post('idtemp4');
            $save_data = array(
                'post' => '3',
            );
            $this->M_Dpembelian->update(array('nobeli' => $nobeli), $save_data);

            $save_status = array(
                'status' => '1',
            );
            $this->M_pembelian->update_status(array('nobeli' => $nobeli), $save_status);

            // $tbrutto = $this->db->query("SELECT b.status FROM inv.hbeli a JOIN inv.dbeli b ON a.nobeli=b.nobeli where b.nobeli='" . $nobeli . "'");
            // foreach ($tbrutto->result() as $row) {
            //     $nobelis = $row->nobeli;
            //     $save_status = array(
            //         'status' => '1',
            //     );
            //     $this->M_pembelian->update_status(array('nobeli' => $nobelis), $save_status);
            // }

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
    public function good($iddbeli)
    {
        $message['is_error']       = true;
        $message['succes_message']  = "";
        if (!empty($iddbeli)) {
            $save_edit_dbeli = array(
                'status' => '1',
            );
            $this->M_detailpembelian->update(array('iddbeli' => $iddbeli), $save_edit_dbeli);
            $tbrutto = $this->db->query("SELECT a.kodebrg, b.kodebrg, a.stokawal, b.qtybeli FROM inv.barang a JOIN inv.dbeli b ON a.kodebrg=b.kodebrg where b.iddbeli='" . $iddbeli . "'");
            foreach ($tbrutto->result() as $row) {
                $kodebrg = $row->kodebrg;
                $stokawal = $row->stokawal;
                $qtybeli = $row->qtybeli;
                $stokbaru = $stokawal + $qtybeli;
                $save_stok = array(
                    'stokawal' => $stokbaru,
                );
                $this->M_masterbarang->update_stok(array('kodebrg' => $kodebrg), $save_stok);
            }
            $message['is_error']       = false;
            $message['succes_message']  = "Change data success";
        } else {
            $message['is_error']       = true;
            $message['error_message']  = "Errr!!!";
        }

        echo json_encode($message);
    }

    public function ajax_list_edit()
    {
        $start  = $_REQUEST['start']; //tambahan limit
        $length = $_REQUEST['length'];
        $params = array();
        if ($this->input->post('dbeli')) {
            $params['dbeli'] = $this->input->post('dbeli');
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
            if ($listdata->status == 0) {
                $row[] = $listdata->namabrg . '<P><a class="btn btn-pill btn-outline-primary btn-air-primary btn-xs" href="javascript:void(0)" data-bs-target="#staticBackdrop" title="Edit data" onclick="edit_detail_beli(' . "'" . $listdata->iddbeli . "'" . ')"><i class="fa fa-edit"></i> </a>
            <a class="btn btn-pill btn-outline-danger btn-air-danger btn-xs" href="javascript:void(0)" title="Delete data" onclick="delete_data(' . "'" . $listdata->iddbeli . "'" . ')"><i class="fa fa-trash-o"></i> </a>';
            } elseif ($listdata->status == 1) {
                $row[] = $listdata->namabrg . '<P><span style="color:white" class="badge bg-success">Received</span>';
            }
            $row[] = $listdata->qtybeli;
            $row[] = $listdata->namasat;
            // $row[] = 'Rp.' .  number_format($listdata->brutto, 0, '', '.');
            $row[] = $listdata->note;
            $row[] = $listdata->brutto;
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
    public function ajax_list_proses()
    {
        $start  = $_REQUEST['start']; //tambahan limit
        $length = $_REQUEST['length'];
        $params = array();
        if ($this->input->post('dbeli')) {
            $params['dbeli'] = $this->input->post('dbeli');
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
            if ($listdata->status == 0) {
                $row[] = $listdata->namabrg;
            } elseif ($listdata->status == 1) {
                $row[] = $listdata->namabrg . '<P><span style="color:white" class="badge bg-success">Received</span>';
            }
            $row[] = $listdata->qtybeli;
            $row[] = $listdata->namasat;
            // $row[] = 'Rp.' .  number_format($listdata->brutto, 0, '', '.');
            $row[] = $listdata->note;
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
    public function ajax_list_input()
    {
        $start  = $_REQUEST['start']; //tambahan limit
        $length = $_REQUEST['length'];
        $params = array();
        if ($this->input->post('dbeli')) {
            $params['dbeli'] = $this->input->post('dbeli');
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
            $row[] = 'Rp.' .  number_format($listdata->brutto, 0, '', '.');
            $row[] = $listdata->note;
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
    public function ajax_list_cetak()
    {
        $start  = $_REQUEST['start']; //tambahan limit
        $length = $_REQUEST['length'];
        $params = array();
        if ($this->input->post('dbeli')) {
            $params['dbeli'] = $this->input->post('dbeli');
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
            $row[] = $listdata->note;
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

    public function save_header()
    {
        $post_data  = $this->input->post();
        $this->form_validation->set_rules('cabang', 'Input cabang', 'required');
        $this->form_validation->set_rules('PO', 'Input PO', 'required');
        $this->form_validation->set_rules('payment', 'Input metode', 'required');
        $this->form_validation->set_rules('kodesups', 'Input Kodesups', 'required');
        $this->form_validation->set_rules('tanggalreq', 'Input tanggalreq');
        $this->form_validation->set_rules('tanggaldel', 'Input tanggaldel');
        $this->form_validation->set_rules('ppn', 'Input ppn');
        $this->form_validation->set_rules('faktur', 'Input faktur');
        $this->form_validation->set_rules('diskon', 'Input diskon');

        if ($this->form_validation->run() == false) {
            $out['is_error']       = true;
            $out['error_message']  = validation_errors();
        } else {
            $PO = $this->input->post('PO');
            $kodebeli = 'PO-' . $PO;
            $save_data = array(
                'nobeli' => $post_data['PO'],
                'kodebeli' => $kodebeli,
                'idcabang' => $post_data['cabang'],
                'hutang' => $post_data['payment'],
                'kodesup' => $post_data['kodesups'],
                'tanggalreq' => $post_data['tanggalreq'],
                'tanggaldel' => $post_data['tanggaldel'],
                'tanggal' => date('d-m-Y'),
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
    public function ajax_proses($nobeli)
    {
        $data = $this->M_Dpembelian->get_by_id($nobeli);
        echo json_encode($data);
    }
    public function ajax_process($nobeli)
    {
        $data = $this->M_Dpembelian->get_by_id($nobeli);
        echo json_encode($data);
    }
    public function edit_header()
    {
        $post_data  = $this->input->post();
        $this->form_validation->set_rules('cabangs', 'Input cabang', 'required');
        $this->form_validation->set_rules('payments', 'Input metode', 'required');
        $this->form_validation->set_rules('kodesupss', 'Input Kodesup', 'required');
        $this->form_validation->set_rules('tanggalreqs', 'Input tanggalreq');
        $this->form_validation->set_rules('tanggaldels', 'Input tanggaldel');
        $this->form_validation->set_rules('ppns', 'Input ppn');
        $this->form_validation->set_rules('fakturs', 'Input faktur');
        $this->form_validation->set_rules('diskons', 'Input diskon');
        $this->form_validation->set_rules('id_pembelian', 'Input nobeli');

        if ($this->form_validation->run() == false) {
            $out['is_error']       = true;
            $out['error_message']  = validation_errors();
        } else {
            $save_data = array(
                'idcabang' => $post_data['cabangs'],
                'hutang' => $post_data['payments'],
                'tanggalreq' => $post_data['tanggalreqs'],
                'tanggaldel' => $post_data['tanggaldels'],
                'ppn' => $post_data['ppns'],
                'faktur' => $post_data['fakturss'],
                'disc1' => $post_data['diskons'],
                'nobeli' => $post_data['id_pembelian'],
                'kodesup' => $post_data['kodesupss'],
            );
            $this->M_Dpembelian->update(array('nobeli' => $this->input->post('id_pembelian')), $save_data);

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
    public function process()
    {
        $post_data  = $this->input->post();
        $this->form_validation->set_rules('Disc', 'Input disc', 'required');
        $this->form_validation->set_rules('PPN', 'Input PPN', 'required');
        $this->form_validation->set_rules('tbaru', 'Input Tbaru', 'required');
        $this->form_validation->set_rules('bayar', 'Input bayar', 'required');
        $this->form_validation->set_rules('kembalian', 'Input kembalian', 'required');
        $this->form_validation->set_rules('idtemps', 'Input nobeli', 'required');

        if ($this->form_validation->run() == false) {
            $out['is_error']       = true;
            $out['error_message']  = validation_errors();
        } else {
            $faktur = $this->input->post('faktur');
            $fakturs = "PB-" . $faktur;
            $save_data = array(
                'nilaippn' => $post_data['PPN'],
                'nilaifaktur' => $post_data['tbaru'],
                'nilaidisc1' => $post_data['Disc'],
                'biaya' => $post_data['bayar'],
                'kembalian' => $post_data['kembalian'],
                'nobeli' => $post_data['idtemps'],
                'post' => '2',
                'nilaifaktur' => $fakturs,
                'nilaidisc1' => $post_data['Disc'],
                'nilaippn' => $post_data['PPN'],

            );
            $this->M_Dpembelian->update(array('nobeli' => $this->input->post('idtemps')), $save_data);

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
