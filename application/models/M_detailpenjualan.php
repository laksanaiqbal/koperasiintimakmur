<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_detailpenjualan extends CI_Model
{

    var $table = 'inv.detail_penjualan';
    var $column_order = array(null, 'a.id_detail', 'a.id_jual', 'a.id_barang', 'a.id_servis',  'a.diskon', 'a.hjual', 'a.qty', 'a.total'); //set column field database for datatable orderable
    var $column_search = array('a.id_detail', 'a.id_jual', 'a.id_barang', 'a.id_servis',  'a.diskon', 'a.hjual', 'a.qty', 'a.total'); //set column field database for datatable searchable 
    var $order = array('a.id_jual' => 'asc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function getdata()
    {
        $query = $this->db->query("SELECT * FROM detail_penjualan ORDER BY id_detail ASC");
        return $query->result();
    }
    private function _get_datatables_query()
    {
        $month = date('m') - 3;
        $years = date('Y');
        $this->db->select("a.id_detail, a.id_jual,b.namabrg,b.kodebrg,b.barcode, b.hbeli1,b.hjual1, a.id_barang, a.kode_detail, a.hjual, a.qty,a.total");
        $this->db->from('detail_penjualan a');
        $this->db->join('barang b', 'a.id_barang=b.kodebrg');
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
            $this->db->where('a.id_jual', $params['txt_transID']);
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
            $this->db->where('a.id_jual', $params['txt_transID']);
        }

        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all()
    {
        $this->_get_datatables_query();
        if (isset($params['txt_transID'])) {
            $this->db->where('a.id_jual', $params['txt_transID']);
        }
        return $this->db->count_all_results();
    }

    public function get_by_id($id)
    {
        $this->db->select("a.id_detail, a.id_jual, b.namabrg, b.kodebrg, a.id_barang,a.id_servis,a.diskon,a.hjual, a.qty, a.total");
        $this->db->from('inv.detail_penjualan a');
        $this->db->join('barang b', 'a.id_barang=b.kodebrg');
        $this->db->WHERE('a.id_jual', $id);
        $query = $this->db->get();
        // die(var_dump($query));
        return $query->row();
    }
}
