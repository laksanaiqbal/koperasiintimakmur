<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_member_billing extends CI_Model {
 
    var $table = 'hjual';
    var $column_order = array(null,null, 'a.kodecus','b.namacus','TotPembelian','TotBayar','TotHutang'); //set column field database for datatable orderable
    var $column_search = array('a.kodecus','b.namacus'); //set column field database for datatable searchable 
    var $order = array('TotHutang' => 'DESC'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {
        $nik = $this->session->userdata('NIK');
        $thn = date("Y");
        $bln = date("m");
        $this->db->select("a.kodecus,b.namacus,sum(a.piutang)+sum(a.bayar) TotPembelian,sum(a.bayar) TotBayar,sum(a.piutang) TotHutang");
        $this->db->from('hpiutang a');
        $this->db->join('customer b', 'b.kodecus=a.kodecus');
        $this->db->join('hjual c', 'c.nojual=a.nojual');
        $this->db->where('a.kodecus=', $nik);
        $this->db->where('month(a.tanggal)', $bln);
        $this->db->where('year(a.tanggal)', $thn);
        $this->db->group_by('a.kodecus');
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
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        // die(var_dump($query->result()));
        return $query->result();
    }
    function count_filtered($params)
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        // die(var_dump($query->num_rows()));
        return $query->num_rows();
    }
    public function count_all($params)
    {
        // $this->db->from($this->table);
        $this->_get_datatables_query();
        return $this->db->count_all_results();
    }
 
}