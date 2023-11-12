<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_detailpembelian extends CI_Model
{

    var $table = 'inv.dbeli';
    var $column_order = array(null, 'a.iddbeli', 'a.nobeli', 'a.kodebrg', 'a.hpp', 'a.hjual1', 'a.qtybeli', 'a.brutto', 'a.status', 'a.post'); //set column field database for datatable orderable
    var $column_search = array('a.iddbeli', 'a.nobeli', 'a.kodebrg', 'a.hpp', 'a.hjual1', 'a.qtybeli', 'a.brutto', 'a.status', 'a.post'); //set column field database for datatable searchable 
    var $order = array('a.nobeli' => 'desc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function update($where, $save_edit_dbeli)
    {
        $this->db->update($this->table, $save_edit_dbeli, $where);
        return $this->db->affected_rows();
    }

    public function save($data)
    {
        $this->db->insert($this->table, $data);
    }
    private function _get_datatables_query()
    {
        $this->db->select("b.kodebrg,b.namabrg,a.satbeli, b.kodesat,c.namasat, a.iddbeli, a.nobeli, a.kodebrg, a.hpp, a.hjual1, a.qtybeli, a.brutto, a.status, a.post, a.note");
        $this->db->from('inv.dbeli a');
        $this->db->join('inv.barang b', 'a.kodebrg=b.kodebrg');
        $this->db->join('inv.satuan c', 'b.kodesat=c.kodesat');
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
        if (isset($params['dbeli'])) {
            $this->db->where('a.nobeli', $params['dbeli']);
        }
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function count_filtered($params)
    {
        $this->_get_datatables_query();
        if (isset($params['dbeli'])) {
            $this->db->where('a.nobeli', $params['dbeli']);
        }

        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all()
    {
        $this->_get_datatables_query();
        if (isset($params['dbeli'])) {
            $this->db->where('a.nobeli', $params['dbeli']);
        }
        return $this->db->count_all_results();
    }
    public function get_by_id($id)
    {
        $this->db->select("a.nobeli,b.kodebrg,b.namabrg, b.kodesat,c.namasat, a.iddbeli,  a.kodebrg, a.hpp, a.hjual1, a.qtybeli, a.brutto,a.note");
        $this->db->from('inv.dbeli a');
        $this->db->join('inv.barang b', 'a.kodebrg=b.kodebrg');
        $this->db->join('inv.satuan c', 'b.kodesat=c.kodesat');
        $this->db->WHERE('a.iddbeli', $id);
        $query = $this->db->get();
        return $query->row();
    }
    public function delete_by_id($id)
    {
        $this->db->where('iddbeli', $id);
        $this->db->delete($this->table);
    }
}
