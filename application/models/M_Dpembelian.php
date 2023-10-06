<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Dpembelian extends CI_Model
{

    var $table = 'pembelian';
    var $column_order = array(null, 'a.id_pembelian', 'b.namasup', 'a.id_user', 'a.kode_beli', 'a.tgl_faktur', 'a.faktur_beli', 'a.diskon', 'a.metode', 'a.g_total', 'a.bayar', 'a.kembalian', 'a.tgl', 'a.status'); //set column field database for datatable orderable
    var $column_search = array('a.id_pembelian', 'b.namasup', 'a.id_user', 'a.kode_beli', 'a.tgl_faktur', 'a.faktur_beli', 'a.diskon', 'a.metode', 'a.g_total', 'a.bayar', 'a.kembalian', 'a.tgl', 'a.status'); //set column field database for datatable searchable 
    var $order = array('a.id_pembelian' => 'asc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function getdata()
    {
        $query = $this->db->query("SELECT * FROM pembelian ORDER BY id_pembelian ASC");
        return $query->result();
    }
    private function _get_datatables_query()
    {
        $month = date('m') - 3;
        $years = date('Y');
        $this->db->select("a.id_pembelian, a.id_user, a.kode_beli, STR_TO_DATE(a.tgl_faktur, '%Y-%m-%d') tgl_faktur, a.faktur_beli, a.diskon, a.metode, a.g_total, a.bayar, a.kembalian, a.tgl, a.status");
        $this->db->from('pembelian a');

        // $this->db->where('year(a.tanggal)', $years);
        $i = 0;

        foreach ($this->column_search as $item) // loop column 
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($params)
    {

        $this->_get_datatables_query();
        $month = date('m');
        $years = date('Y');


        //kode_beli 
        if ((isset($params['kode_beli'])) && (!isset($params['txt_tgl_start'])) &&  (!isset($params['txt_tgl_end']))) {
            $this->db->where('a.id_pembelian', $params['kode_beli']);
        }
        // tgl start & Tgl End
        if ((!isset($params['kode_beli'])) && (isset($params['txt_tgl_start'])) &&  (isset($params['txt_tgl_end']))) {
            $this->db->where('STR_TO_DATE(a.tgl_faktur, "%Y-%m-%d") >=', date('Y-m-d', strtotime($params['txt_tgl_start'])));
            $this->db->where('STR_TO_DATE(a.tgl_faktur, "%Y-%m-%d") <=', date('Y-m-d', strtotime($params['txt_tgl_end'])));
        }
        // tgl start 
        if ((!isset($params['kode_beli'])) && (isset($params['txt_tgl_start'])) &&  (!isset($params['txt_tgl_end']))) {
            $this->db->where('STR_TO_DATE(a.tgl_faktur, "%Y-%m-%d") >=', date('Y-m-d', strtotime($params['txt_tgl_start'])));
        }
        //Tgl End
        if ((!isset($params['kode_beli'])) && (!isset($params['txt_tgl_start'])) &&  (isset($params['txt_tgl_end']))) {
            $this->db->where('STR_TO_DATE(a.tgl_faktur, "%Y-%m-%d") <=', date('Y-m-d', strtotime($params['txt_tgl_end'])));
        }
        // kode_beli & tgl start & tgl end
        if ((isset($params['kode_beli'])) && (isset($params['txt_tgl_start'])) &&  (isset($params['txt_tgl_end']))) {
            $this->db->where('a.id_pembelian', $params['kode_beli']);
            $this->db->where('STR_TO_DATE(a.tgl_faktur, "%Y-%m-%d") >=', date('Y-m-d', strtotime($params['txt_tgl_start'])));
            $this->db->where('STR_TO_DATE(a.tgl_faktur, "%Y-%m-%d") <=', date('Y-m-d', strtotime($params['txt_tgl_end'])));
        }


        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function count_filtered($params)
    {
        $this->_get_datatables_query();
        $month = date('m');
        $years = date('Y');
        //all not sett
        if ((!isset($params['kode_beli'])) && (!isset($params['txt_tgl_start'])) &&  (!isset($params['txt_tgl_end']))) {
            $this->db->where('year(STR_TO_DATE(a.tgl_faktur, "%Y-%m-%d")) =', date("Y"));
            $this->db->where('month(STR_TO_DATE(a.tgl_faktur, "%Y-%m-%d")) =', date("m"));
        }
        //kode_beli 
        if ((isset($params['kode_beli'])) && (!isset($params['txt_tgl_start'])) &&  (!isset($params['txt_tgl_end']))) {
            $this->db->where('a.id_pembelian', $params['kode_beli']);
        }
        // tgl start & Tgl End
        if ((!isset($params['kode_beli'])) && (isset($params['txt_tgl_start'])) &&  (isset($params['txt_tgl_end']))) {
            $this->db->where('STR_TO_DATE(a.tgl_faktur, "%Y-%m-%d") >=', date('Y-m-d', strtotime($params['txt_tgl_start'])));
            $this->db->where('STR_TO_DATE(a.tgl_faktur, "%Y-%m-%d") <=', date('Y-m-d', strtotime($params['txt_tgl_end'])));
        }
        // // tgl start 
        // if ((!isset($params['kode_beli'])) && (isset($params['txt_tgl_start'])) &&  (!isset($params['txt_tgl_end']))) {
        //     $this->db->where('STR_TO_DATE(a.tgl_faktur, "%Y-%m-%d") >=', date('Y-m-d', strtotime($params['txt_tgl_start'])));
        // }
        // //Tgl End
        // if ((!isset($params['kode_beli'])) && (!isset($params['txt_tgl_start'])) &&  (isset($params['txt_tgl_end']))) {
        //     $this->db->where('STR_TO_DATE(a.tgl_faktur, "%Y-%m-%d") <=', date('Y-m-d', strtotime($params['txt_tgl_end'])));
        // }
        // // kode_beli & tgl start & tgl end
        // if ((isset($params['kode_beli'])) && (isset($params['txt_tgl_start'])) &&  (isset($params['txt_tgl_end']))) {
        //     $this->db->where('a.id_pembelian', $params['kode_beli']);
        //     $this->db->where('STR_TO_DATE(a.tgl_faktur, "%Y-%m-%d") >=', date('Y-m-d', strtotime($params['txt_tgl_start'])));
        //     $this->db->where('STR_TO_DATE(a.tgl_faktur, "%Y-%m-%d") <=', date('Y-m-d', strtotime($params['txt_tgl_end'])));
        // }


        $query = $this->db->get();
        // die(var_dump($query->num_rows())); 
        return $query->num_rows();
    }
    public function count_all($params)
    {
        // $this->db->from($this->table);
        $this->_get_datatables_query();
        $month = date('m');
        $years = date('Y');
        //all not sett
        if ((!isset($params['kode_beli'])) && (!isset($params['txt_tgl_start'])) &&  (!isset($params['txt_tgl_end']))) {
            $this->db->where('year(STR_TO_DATE(a.tgl_faktur, "%Y-%m-%d")) =', date("Y"));
            $this->db->where('month(STR_TO_DATE(a.tgl_faktur, "%Y-%m-%d")) =', date("m"));
        }
        //kode_beli 
        if ((isset($params['kode_beli'])) && (!isset($params['txt_tgl_start'])) &&  (!isset($params['txt_tgl_end']))) {
            $this->db->where('a.id_pembelian', $params['kode_beli']);
        }
        // tgl start & Tgl End
        if ((!isset($params['kode_beli'])) && (isset($params['txt_tgl_start'])) &&  (isset($params['txt_tgl_end']))) {
            $this->db->where('STR_TO_DATE(a.tgl_faktur, "%Y-%m-%d") >=', date('Y-m-d', strtotime($params['txt_tgl_start'])));
            $this->db->where('STR_TO_DATE(a.tgl_faktur, "%Y-%m-%d") <=', date('Y-m-d', strtotime($params['txt_tgl_end'])));
        }
        // // tgl start 
        // if ((!isset($params['kode_beli'])) && (isset($params['txt_tgl_start'])) &&  (!isset($params['txt_tgl_end']))) {
        //     $this->db->where('STR_TO_DATE(a.tgl_faktur, "%Y-%m-%d") >=', date('Y-m-d', strtotime($params['txt_tgl_start'])));
        // }
        // //Tgl End
        // if ((!isset($params['kode_beli'])) && (!isset($params['txt_tgl_start'])) &&  (isset($params['txt_tgl_end']))) {
        //     $this->db->where('STR_TO_DATE(a.tgl_faktur, "%Y-%m-%d") <=', date('Y-m-d', strtotime($params['txt_tgl_end'])));
        // }
        // // kode_beli & tgl start & tgl end
        // if ((isset($params['kode_beli'])) && (isset($params['txt_tgl_start'])) &&  (isset($params['txt_tgl_end']))) {
        //     $this->db->where('a.id_pembelian', $params['kode_beli']);
        //     $this->db->where('STR_TO_DATE(a.tgl_faktur, "%Y-%m-%d") >=', date('Y-m-d', strtotime($params['txt_tgl_start'])));
        //     $this->db->where('STR_TO_DATE(a.tgl_faktur, "%Y-%m-%d") <=', date('Y-m-d', strtotime($params['txt_tgl_end'])));
        // }

        return $this->db->count_all_results();
    }
    public function save($data)
    {
        $this->db->insert($this->table, $data);
    }
    public function save_log($data)
    {
        $this->db->insert('db_logs.tb_PO_log', $data);
        return $this->db->insert_id();
    }
    public function update($where, $save_data)
    {
        $this->db->update($this->table, $save_data, $where);
        return $this->db->affected_rows();
    }
    public function delete_by_id($id)
    {
        $this->db->where('id_pembelian', $id);
        $this->db->delete($this->table);
    }

    public function delete_by_id_POlogs($id)
    {
        $this->db->where('TRANS_ID', $id);
        $this->db->delete('db_logs.tb_PO_log');
    }
    public function General($sql)
    {
        return $this->db->query($sql);
    }
}
