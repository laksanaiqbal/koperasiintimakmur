<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Dpenjualan extends CI_Model
{

    var $table = 'inv.hjual';
    var $column_order = array(null, 'a.nojual', 'a.kodecus', 'a.idcabang', 'a.tanggal', 'a.jam',  'a.jenis', 'a.bayar', 'a.sisabayar', 'a.subtotal', 'a.ppn', 'a.post', 'a.discFak'); //set column field database for datatable orderable
    var $column_search = array('a.nojual', 'a.kodecus', 'a.idcabang', 'a.tanggal', 'a.jam',  'a.jenis', 'a.bayar', 'a.sisabayar', 'a.subtotal', 'a.ppn', 'a.post', 'a.discFak'); //set column field database for datatable searchable 
    var $order = array('a.nojual' => 'desc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function getdata()
    {
        $query = $this->db->query("SELECT * FROM hjual ORDER BY nojual ASC");
        return $query->result();
    }
    private function _get_datatables_query()
    {
        $month = date('m') - 3;
        $years = date('Y');
        $this->db->select("a.nojual,a.idcabang, a.kodecus, c.kodecus,c.namacus, a.jenis, a.bayar, a.sisabayar, a.subtotal, a.ppn, a.tanggal,a.jam, a.post, a.discFak");
        $this->db->from('hjual a');
        $this->db->join('customer c', 'a.kodecus=c.kodecus');


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

        //kodecus 
        if ((!isset($params['nojual'])) && (!isset($params['txt_tgl_start'])) &&  (!isset($params['txt_tgl_end'])) &&  (isset($params['kodecus']))) {
            $this->db->where('a.kodecus', $params['kodecus']);
        }
        //nojual 
        if ((isset($params['nojual'])) && (!isset($params['txt_tgl_start'])) &&  (!isset($params['txt_tgl_end'])) &&  (!isset($params['kodecus']))) {
            $this->db->where('a.nojual', $params['nojual']);
        }
        //kodecus & nojual
        if ((isset($params['nojual'])) && (!isset($params['txt_tgl_start'])) &&  (!isset($params['txt_tgl_end'])) &&  (isset($params['kodecus']))) {
            $this->db->where('a.nojual', $params['nojual']);
            $this->db->where('a.kodecus', $params['kodecus']);
        }
        // tgl start & Tgl End
        if ((!isset($params['nojual'])) && (isset($params['txt_tgl_start'])) &&  (isset($params['txt_tgl_end'])) &&  (!isset($params['kodecus']))) {
            $this->db->where('STR_TO_DATE(a.tanggal, "%Y-%m-%d") >=', date('Y-m-d', strtotime($params['txt_tgl_start'])));
            $this->db->where('STR_TO_DATE(a.tanggal, "%Y-%m-%d") <=', date('Y-m-d', strtotime($params['txt_tgl_end'])));
        }
        // tgl start 
        if ((!isset($params['nojual'])) && (isset($params['txt_tgl_start'])) &&  (!isset($params['txt_tgl_end'])) &&  (!isset($params['kodecus']))) {
            $this->db->where('STR_TO_DATE(a.tanggal, "%Y-%m-%d") >=', date('Y-m-d', strtotime($params['txt_tgl_start'])));
        }
        //Tgl End
        if ((!isset($params['nojual'])) && (!isset($params['txt_tgl_start'])) &&  (isset($params['txt_tgl_end'])) &&  (!isset($params['kodecus']))) {
            $this->db->where('STR_TO_DATE(a.tanggal, "%Y-%m-%d") <=', date('Y-m-d', strtotime($params['txt_tgl_end'])));
        }
        //nojual & tgl start & tgl end
        if ((isset($params['nojual'])) && (isset($params['txt_tgl_start'])) &&  (isset($params['txt_tgl_end'])) &&  (!isset($params['kodecus']))) {
            $this->db->where('a.nojual', $params['nojual']);
            $this->db->where('STR_TO_DATE(a.tanggal, "%Y-%m-%d") >=', date('Y-m-d', strtotime($params['txt_tgl_start'])));
            $this->db->where('STR_TO_DATE(a.tanggal, "%Y-%m-%d") <=', date('Y-m-d', strtotime($params['txt_tgl_end'])));
        }
        //tgl start & tgl end & kodecus
        if ((!isset($params['nojual'])) && (isset($params['txt_tgl_start'])) &&  (isset($params['txt_tgl_end'])) &&  (isset($params['kodecus']))) {
            $this->db->where('a.kodecus', $params['kodecus']);
            $this->db->where('STR_TO_DATE(a.tanggal, "%Y-%m-%d") >=', date('Y-m-d', strtotime($params['txt_tgl_start'])));
            $this->db->where('STR_TO_DATE(a.tanggal, "%Y-%m-%d") <=', date('Y-m-d', strtotime($params['txt_tgl_end'])));
        }
        //nojual & tgl start & tgl end & kodecus
        if ((isset($params['nojual'])) && (isset($params['txt_tgl_start'])) &&  (isset($params['txt_tgl_end'])) &&  (isset($params['kodecus']))) {
            $this->db->where('a.nojual', $params['nojual']);
            $this->db->where('a.kodecus', $params['kodecus']);
            $this->db->where('STR_TO_DATE(a.tanggal, "%Y-%m-%d") >=', date('Y-m-d', strtotime($params['txt_tgl_start'])));
            $this->db->where('STR_TO_DATE(a.tanggal, "%Y-%m-%d") <=', date('Y-m-d', strtotime($params['txt_tgl_end'])));
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
        //jika parameter yang di set txt_nmkary 
        if (isset($params['txt_nmkary'])) {
            $this->db->where('a.nojual', $params['txt_nmkary']);
        }

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
        //jika parameter yang di set txt_nmkary 
        if (isset($params['txt_nmkary'])) {
            $this->db->where('a.nojual', $params['txt_nmkary']);
        }
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
        $this->db->where('nojual', $id);
        $this->db->delete($this->table);
    }
    public function get_detail($nojual)
    {
        $this->db->select("a.nojual, a.jenis, a.bayar, a.sisabayar, a.subtotal, a.ppn, a.tanggal,a.jam, a.post");
        $this->db->from('hjual a');
        $this->db->join('djual b', 'a.nojual=b.nojual');
        $this->db->join('barang c', 'b.kodebrg=c.kodebrg');
        $this->db->where('a.nojual=b.nojual', $nojual);
        $query = $this->db->get();
        return $query->row();
    }
    public function get_by_id($nojual)
    {
        $this->db->from($this->table);
        $this->db->where('nojual', $nojual);
        $query = $this->db->get();

        return $query->row();
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
    public function get_sum()
    {
        $PO = "SELECT sum(total) as total FROM inv.detail_pembelian WHERE id_pembelian='0'";
        $result = $this->db->query($PO);
        return $result->row()->total;
    }
}
