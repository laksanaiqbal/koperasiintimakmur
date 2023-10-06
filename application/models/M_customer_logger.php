<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_customer_logger extends CI_Model
{
    var $table = 'db_logs.tb_customer_log';
    var $column_order = array(null, 'a.ACTIONS', 'a.USER_NAME', 'a.EMP_NAME', 'a.CREATE_DB', 'a.CREATE_SYSTEM'); //set column field database for datatable orderable
    var $column_search = array('a.ACTIONS', 'a.USER_NAME', 'a.EMP_NAME', 'a.CREATE_DB', 'a.CREATE_SYSTEM'); //set column field database for datatable searchable 
    var $order = array('a.CREATE_DB,a.ACTIONS' => 'desc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        $this->db->select("*");
        $this->db->from('db_logs.tb_customer_log a');
        $this->db->where('TABLE_NAME', 'inv.customer');
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
            $this->db->where('a.TRANS_ID', $params['txt_transID']);
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
            $this->db->where('a.TRANS_ID', $params['txt_transID']);
        }

        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all()
    {
        $this->_get_datatables_query();
        if (isset($params['txt_transID'])) {
            $this->db->where('a.TRANS_ID', $params['txt_transID']);
        }
        return $this->db->count_all_results();
    }
    public function get_by_id($id)
    {
        // $this->db->from('db_.tb_5r_log');
        $this->db->from($this->table);
        $this->db->where('TRANS_ID', $id);
        $this->db->where('TABLE_NAME', 'inv.customer');
        $query = $this->db->get();
        return $query->row();
    }
}
