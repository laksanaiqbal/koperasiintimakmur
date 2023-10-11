<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_pembelian extends CI_Model
{

    var $table = 'inv.dbeli';
    var $column_order = array(null, 'a.iddbeli', 'a.nobeli', 'a.kodebrg', 'a.hpp', 'a.hjual1', 'a.qtybeli', 'a.brutto', 'a.kodesup', 'a.post'); //set column field database for datatable orderable
    var $column_search = array('a.iddbeli', 'a.nobeli', 'a.kodebrg', 'a.hpp', 'a.hjual1', 'a.qtybeli', 'a.brutto', 'a.kodesup', 'a.post'); //set column field database for datatable searchable 
    var $order = array('a.nobeli' => 'desc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function getdata()
    {
        $query = $this->db->query("SELECT * FROM dbeli ORDER BY nobeli ASC");
        return $query->result();
    }
    private function _get_datatables_query()
    {
        $month = date('m') - 3;
        $years = date('Y');
        $this->db->select("a.iddbeli,b.barcode, a.nobeli,b.namabrg,b.kodebrg, a.kodebrg, a.hpp, a.hjual1, a.qtybeli ,a.brutto, a.kodesup");
        $this->db->from('dbeli a');
        $this->db->where("a.nobeli='0'");
        $this->db->join('barang b', 'a.kodebrg=b.kodebrg');
        // $this->db->join('suplier c', 'a.id_sup=c.kodesup');
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

        //jika parameter yang di set txt_nmkary 
        if (isset($params['txt_nmkary'])) {
            $this->db->where('a.nobeli', $params['txt_nmkary']);
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
            $this->db->where('a.nobeli', $params['txt_nmkary']);
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
            $this->db->where('a.nobeli', $params['txt_nmkary']);
        }
        return $this->db->count_all_results();
    }
    public function get_by_id($iddbeli)
    {
        $this->db->select("a.nobeli,b.kodebrg,b.namabrg, b.kodesat, a.iddbeli,  a.kodebrg, a.hpp, a.hjual1, a.qtybeli, a.brutto, a.kodesup");
        $this->db->from('inv.dbeli a');
        $this->db->join('inv.barang b', 'a.kodebrg=b.kodebrg');
        $this->db->where('iddbeli', $iddbeli);
        $query = $this->db->get();

        return $query->row();
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
        $this->db->where('iddbeli', $id);
        $this->db->delete($this->table);
    }

    public function delete_by_id_POlogs($id)
    {
        $this->db->where('TRANS_ID', $id);
        $this->db->delete('db_logs.tb_PO_log');
    }
    public function get_PO($id)
    {
        $PO = $this->db->query("SELECT * FROM inv.dbeli WHERE nobeli='$id'");
        return $PO->row();
    }
    public function get_sum()
    {
        $PO = "SELECT sum(brutto) as brutto FROM inv.dbeli WHERE nobeli='0'";
        $result = $this->db->query($PO);
        return $result->row()->brutto;
    }
}
