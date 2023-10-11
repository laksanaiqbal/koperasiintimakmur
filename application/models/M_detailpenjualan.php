<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_detailpenjualan extends CI_Model
{

    var $table = 'inv.djual';
    var $column_order = array(null, 'a.iddjual', 'a.nojual', 'a.kodebrg', 'a.unit',  'a.disc', 'a.hjual1', 'a.qtyjual', 'a.brutto'); //set column field database for datatable orderable
    var $column_search = array('a.iddjual', 'a.nojual', 'a.kodebrg', 'a.unit',  'a.disc', 'a.hjual1', 'a.qtyjual', 'a.brutto'); //set column field database for datatable searchable 
    var $order = array('a.iddjual' => 'asc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function getdata()
    {
        $query = $this->db->query("SELECT * FROM djual ORDER BY iddjual ASC");
        return $query->result();
    }
    private function _get_datatables_query()
    {
        $month = date('m') - 3;
        $years = date('Y');
        $this->db->select("a.iddjual, a.nojual,b.namabrg,b.kodebrg,b.barcode, b.hbeli1,b.hjual1, a.kodebrg, a.hjual1, a.qtyjual,a.brutto");
        $this->db->from('djual a');
        $this->db->join('barang b', 'a.kodebrg=b.kodebrg');
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
        if (isset($params['txt_transID'])) {
            $this->db->where('a.nojual', $params['txt_transID']);
        }
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function count_filtered($params)
    {
        $this->_get_datatables_query();
        if (isset($params['txt_transID'])) {
            $this->db->where('a.nojual', $params['txt_transID']);
        }

        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all()
    {
        $this->_get_datatables_query();
        if (isset($params['txt_transID'])) {
            $this->db->where('a.nojual', $params['txt_transID']);
        }
        return $this->db->count_all_results();
    }

    public function get_by_id($id)
    {
        $this->db->select("a.iddjual, a.nojual, b.namabrg, b.kodebrg, a.kodebrg,a.unit,a.disc,a.hjual1, a.qtyjual, a.brutto");
        $this->db->from('inv.djual a');
        $this->db->join('barang b', 'a.kodebrg=b.kodebrg');
        $this->db->WHERE('a.nojual', $id);
        $query = $this->db->get();
        return $query->row();
    }
}
