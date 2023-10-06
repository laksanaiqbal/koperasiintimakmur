<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_PO extends CI_Model
{

    var $table = 'dorder';
    var $column_order = array(null, 'a.noorder', 'a.namabrg', 'a.sup', 'a.kodebrg', 'a.qtyorder', 'd.namasup', 'c.namaklmpk', 'b.namasat', 'a.kodeklmpk', 'a.rbeli', 'a.satorder', 'a.status', 'a.gambar'); //set column field database for datatable orderable
    var $column_search = array('a.noorder', 'a.namabrg', 'a.sup', 'a.kodebrg', 'a.qtyorder', 'd.namasup', 'c.namaklmpk', 'b.namasat', 'a.kodeklmpk', 'a.rbeli', 'a.satorder', 'a.status', 'a.gambar'); //set column field database for datatable searchable 
    var $order = array('a.noorder' => 'asc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function getdata()
    {
        $query = $this->db->query("SELECT * FROM dorder ORDER BY namabrg ASC");
        return $query->result();
    }
    private function _get_datatables_query()
    {
        $month = date('m') - 3;
        $years = date('Y');
        $this->db->select("a.noorder, a.kodebrg,a.namabrg,a.sup,c.namaklmpk,d.namasup, a.qtyorder,a.kodeklmpk, a.rbeli ,b.namasat, a.satorder, a.status, a.gambar");
        $this->db->from('dorder a');
        $this->db->join('satuan b', 'a.satorder=b.kodesat');
        $this->db->join('kelompok c', 'a.kodeklmpk=c.kodeklmpk');
        $this->db->join('suplier d', 'a.sup=d.kodesup');
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
            $this->db->where('a.noorder', $params['txt_nmkary']);
        }

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        //    die($query->result());
        return $query->result();
    }
    function count_filtered($params)
    {
        $this->_get_datatables_query();
        $month = date('m');
        $years = date('Y');
        //jika parameter yang di set txt_nmkary 
        if (isset($params['txt_nmkary'])) {
            $this->db->where('a.noorder', $params['txt_nmkary']);
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
            $this->db->where('a.noorder', $params['txt_nmkary']);
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
        $this->db->where('noorder', $id);
        $this->db->delete($this->table);
    }
    public function get_by_id($noorder)
    {
        $this->db->from($this->table);
        $this->db->where('noorder', $noorder);
        $query = $this->db->get();

        return $query->row();
    }
    public function delete_by_id_POlogs($id)
    {
        $this->db->where('TRANS_ID', $id);
        $this->db->delete('db_logs.tb_PO_log');
    }
    public function get_PO($id)
    {
        $PO = $this->db->query("SELECT * FROM inv.dorder WHERE noorder='$id'");
        return $PO->row();
    }
}
