<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Dpembelian extends CI_Model
{

    var $table = 'hbeli';
    var $column_order = array(null, 'a.nobeli', 'a.kodebeli', 'a.idcabang', 'b.namasup', 'a.tanggal', 'a.tanggalreq', 'a.tanggaldel', 'a.disc1', 'a.hutang', 'a.tbrutto', 'a.biaya', 'a.potongan', 'a.post', 'a.kodesup', 'a.ppn', 'a.faktur', 'a.noproses'); //set column field database for datatable orderable
    var $column_search = array('a.nobeli', 'a.kodebeli', 'a.idcabang', 'b.namasup', 'a.tanggal', 'a.tanggalreq', 'a.tanggaldel', 'a.disc1', 'a.hutang', 'a.tbrutto', 'a.biaya', 'a.potongan', 'a.post', 'a.kodesup', 'a.ppn', 'a.faktur', 'a.noproses'); //set column field database for datatable searchable 
    var $order = array('a.post' => 'asc'); // default order  

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function getdata()
    {
        $query = $this->db->query("SELECT * FROM hbeli ORDER BY nobeli ASC");
        return $query->result();
    }
    private function _get_datatables_query()
    {
        $month = date('m') - 3;
        $years = date('Y');
        $this->db->select("a.nobeli,a.tanggalreq,a.tanggaldel,b.namasup,a.kodebeli,a.tanggal,  a.disc1, a.hutang, a.idcabang, a.tbrutto, a.biaya, a.potongan, a.post, a.kodesup, a.ppn, a.faktur, c.namacabang,a.noproses");
        $this->db->from('hbeli a');
        $this->db->join('suplier b', 'a.kodesup=b.kodesup');
        $this->db->join('cabang c', 'a.idcabang=c.idcabang');

        // $this->db->where('year(a.tanggalreq)', $years);
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


        //kodesup 
        if ((!isset($params['kodebeli'])) && (!isset($params['txt_tgl_start'])) &&  (!isset($params['txt_tgl_end'])) &&  (isset($params['kodesup']))) {
            $this->db->where('a.kodesup', $params['kodesup']);
        }
        //kodebeli 
        if ((isset($params['kodebeli'])) && (!isset($params['txt_tgl_start'])) &&  (!isset($params['txt_tgl_end'])) &&  (!isset($params['kodesup']))) {
            $this->db->LIKE('a.kodebeli', $params['kodebeli']);
        }
        //kodesup & kodebeli
        if ((isset($params['kodebeli'])) && (!isset($params['txt_tgl_start'])) &&  (!isset($params['txt_tgl_end'])) &&  (isset($params['kodesup']))) {
            $this->db->LIKE('a.kodebeli', $params['kodebeli']);
            $this->db->where('a.kodesup', $params['kodesup']);
        }
        // tgl start & Tgl End
        if ((!isset($params['kodebeli'])) && (isset($params['txt_tgl_start'])) &&  (isset($params['txt_tgl_end'])) &&  (!isset($params['kodesup']))) {
            $this->db->where('a.tanggal >=', date('d-m-Y', strtotime($params['txt_tgl_start'])));
            $this->db->where('a.tanggal <=', date('d-m-Y', strtotime($params['txt_tgl_end'])));
        }
        // tgl start 
        if ((!isset($params['kodebeli'])) && (isset($params['txt_tgl_start'])) &&  (!isset($params['txt_tgl_end'])) &&  (!isset($params['kodesup']))) {
            $this->db->where('a.tanggal >=', date('d-m-Y', strtotime($params['txt_tgl_start'])));
        }
        //Tgl End
        if ((!isset($params['kodebeli'])) && (!isset($params['txt_tgl_start'])) &&  (isset($params['txt_tgl_end'])) &&  (!isset($params['kodesup']))) {
            $this->db->where('a.tanggal <=', date('d-m-Y', strtotime($params['txt_tgl_end'])));
        }
        //kodebeli & tgl start & tgl end
        if ((isset($params['kodebeli'])) && (isset($params['txt_tgl_start'])) &&  (isset($params['txt_tgl_end'])) &&  (!isset($params['kodesup']))) {
            $this->db->LIKE('a.kodebeli', $params['kodebeli']);
            $this->db->where('a.tanggal >=', date('d-m-Y', strtotime($params['txt_tgl_start'])));
            $this->db->where('a.tanggal <=', date('d-m-Y', strtotime($params['txt_tgl_end'])));
        }
        //tgl start & tgl end & kodesup
        if ((!isset($params['kodebeli'])) && (isset($params['txt_tgl_start'])) &&  (isset($params['txt_tgl_end'])) &&  (isset($params['kodesup']))) {
            $this->db->where('a.kodesup', $params['kodesup']);
            $this->db->where('a.tanggal >=', date('d-m-Y', strtotime($params['txt_tgl_start'])));
            $this->db->where('a.tanggal <=', date('d-m-Y', strtotime($params['txt_tgl_end'])));
        }
        //kodebeli & tgl start & tgl end & kodesup
        if ((isset($params['kodebeli'])) && (isset($params['txt_tgl_start'])) &&  (isset($params['txt_tgl_end'])) &&  (isset($params['kodesup']))) {
            $this->db->like('a.kodebeli', $params['kodebeli']);
            $this->db->where('a.kodesup', $params['kodesup']);
            $this->db->where('a.tanggal >=', date('d-m-Y', strtotime($params['txt_tgl_start'])));
            $this->db->where('a.tanggal <=', date('d-m-Y', strtotime($params['txt_tgl_end'])));
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
        //kodesup 
        if ((!isset($params['kodebeli'])) && (!isset($params['txt_tgl_start'])) &&  (!isset($params['txt_tgl_end'])) &&  (isset($params['kodesup']))) {
            $this->db->where('a.kodesup', $params['kodesup']);
        }
        //kodebeli 
        if ((isset($params['kodebeli'])) && (!isset($params['txt_tgl_start'])) &&  (!isset($params['txt_tgl_end'])) &&  (!isset($params['kodesup']))) {
            $this->db->like('a.kodebeli', $params['kodebeli']);
        }
        //kodesup & kodebeli
        if ((isset($params['kodebeli'])) && (!isset($params['txt_tgl_start'])) &&  (!isset($params['txt_tgl_end'])) &&  (isset($params['kodesup']))) {
            $this->db->like('a.kodebeli', $params['kodebeli']);
            $this->db->where('a.kodesup', $params['kodesup']);
        }
        // tgl start & Tgl End
        if ((!isset($params['kodebeli'])) && (isset($params['txt_tgl_start'])) &&  (isset($params['txt_tgl_end'])) &&  (!isset($params['kodesup']))) {
            $this->db->where('a.tanggal >=', date('d-m-Y', strtotime($params['txt_tgl_start'])));
            $this->db->where('a.tanggal <=', date('d-m-Y', strtotime($params['txt_tgl_end'])));
        }
        // tgl start 
        if ((!isset($params['kodebeli'])) && (isset($params['txt_tgl_start'])) &&  (!isset($params['txt_tgl_end'])) &&  (!isset($params['kodesup']))) {
            $this->db->where('a.tanggal >=', date('d-m-Y', strtotime($params['txt_tgl_start'])));
        }
        //Tgl End
        if ((!isset($params['kodebeli'])) && (!isset($params['txt_tgl_start'])) &&  (isset($params['txt_tgl_end'])) &&  (!isset($params['kodesup']))) {
            $this->db->where('a.tanggal <=', date('d-m-Y', strtotime($params['txt_tgl_end'])));
        }
        //kodebeli & tgl start & tgl end
        if ((isset($params['kodebeli'])) && (isset($params['txt_tgl_start'])) &&  (isset($params['txt_tgl_end'])) &&  (!isset($params['kodesup']))) {
            $this->db->like('a.kodebeli', $params['kodebeli']);
            $this->db->where('a.tanggal >=', date('d-m-Y', strtotime($params['txt_tgl_start'])));
            $this->db->where('a.tanggal <=', date('d-m-Y', strtotime($params['txt_tgl_end'])));
        }
        //tgl start & tgl end & kodesup
        if ((!isset($params['kodebeli'])) && (isset($params['txt_tgl_start'])) &&  (isset($params['txt_tgl_end'])) &&  (isset($params['kodesup']))) {
            $this->db->where('a.kodesup', $params['kodesup']);
            $this->db->where('a.tanggal >=', date('d-m-Y', strtotime($params['txt_tgl_start'])));
            $this->db->where('a.tanggal <=', date('d-m-Y', strtotime($params['txt_tgl_end'])));
        }
        //kodebeli & tgl start & tgl end & kodesup
        if ((isset($params['kodebeli'])) && (isset($params['txt_tgl_start'])) &&  (isset($params['txt_tgl_end'])) &&  (isset($params['kodesup']))) {
            $this->db->like('a.kodebeli', $params['kodebeli']);
            $this->db->where('a.kodesup', $params['kodesup']);
            $this->db->where('a.tanggal >=', date('d-m-Y', strtotime($params['txt_tgl_start'])));
            $this->db->where('a.tanggal <=', date('d-m-Y', strtotime($params['txt_tgl_end'])));
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
        //kodesup 
        if ((!isset($params['kodebeli'])) && (!isset($params['txt_tgl_start'])) &&  (!isset($params['txt_tgl_end'])) &&  (isset($params['kodesup']))) {
            $this->db->where('a.kodesup', $params['kodesup']);
        }
        //kodebeli 
        if ((isset($params['kodebeli'])) && (!isset($params['txt_tgl_start'])) &&  (!isset($params['txt_tgl_end'])) &&  (!isset($params['kodesup']))) {
            $this->db->like('a.kodebeli', $params['kodebeli']);
        }
        //kodesup & kodebeli
        if ((isset($params['kodebeli'])) && (!isset($params['txt_tgl_start'])) &&  (!isset($params['txt_tgl_end'])) &&  (isset($params['kodesup']))) {
            $this->db->like('a.kodebeli', $params['kodebeli']);
            $this->db->where('a.kodesup', $params['kodesup']);
        }
        // tgl start & Tgl End
        if ((!isset($params['kodebeli'])) && (isset($params['txt_tgl_start'])) &&  (isset($params['txt_tgl_end'])) &&  (!isset($params['kodesup']))) {
            // $this->db->where('a.tanggal >=', date('d-m-Y', strtotime($params['txt_tgl_start'])));
            // $this->db->where('a.tanggal <=', date('d-m-Y', strtotime($params['txt_tgl_end'])));

            $this->db->where('a.tanggal BETWEEN "' . date('d-m-Y', strtotime($params['txt_tgl_start'])) . '" and "' . date('d-m-Y', strtotime($params['txt_tgl_end'])) . '"');
        }
        // tgl start 
        if ((!isset($params['kodebeli'])) && (isset($params['txt_tgl_start'])) &&  (!isset($params['txt_tgl_end'])) &&  (!isset($params['kodesup']))) {
            $this->db->where('a.tanggal >=', date('d-m-Y', strtotime($params['txt_tgl_start'])));
        }
        //Tgl End
        if ((!isset($params['kodebeli'])) && (!isset($params['txt_tgl_start'])) &&  (isset($params['txt_tgl_end'])) &&  (!isset($params['kodesup']))) {
            $this->db->where('a.tanggal <=', date('d-m-Y', strtotime($params['txt_tgl_end'])));
        }
        //kodebeli & tgl start & tgl end
        if ((isset($params['kodebeli'])) && (isset($params['txt_tgl_start'])) &&  (isset($params['txt_tgl_end'])) &&  (!isset($params['kodesup']))) {
            $this->db->like('a.kodebeli', $params['kodebeli']);
            $this->db->where('a.tanggal BETWEEN "' . date('d-m-Y', strtotime($params['txt_tgl_start'])) . '" and "' . date('d-m-Y', strtotime($params['txt_tgl_end'])) . '"');
        }
        //tgl start & tgl end & kodesup
        if ((!isset($params['kodebeli'])) && (isset($params['txt_tgl_start'])) &&  (isset($params['txt_tgl_end'])) &&  (isset($params['kodesup']))) {
            $this->db->where('a.kodesup', $params['kodesup']);
            $this->db->where('a.tanggal BETWEEN "' . date('d-m-Y', strtotime($params['txt_tgl_start'])) . '" and "' . date('d-m-Y', strtotime($params['txt_tgl_end'])) . '"');
        }
        //kodebeli & tgl start & tgl end & kodesup
        if ((isset($params['kodebeli'])) && (isset($params['txt_tgl_start'])) &&  (isset($params['txt_tgl_end'])) &&  (isset($params['kodesup']))) {
            $this->db->like('a.kodebeli', $params['kodebeli']);
            $this->db->where('a.kodesup', $params['kodesup']);
            $this->db->where('a.tanggal BETWEEN "' . date('d-m-Y', strtotime($params['txt_tgl_start'])) . '" and "' . date('d-m-Y', strtotime($params['txt_tgl_end'])) . '"');
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
    public function update_tbrutto($where, $save_tbrutto)
    {
        $this->db->update($this->table, $save_tbrutto, $where);
        return $this->db->affected_rows();
    }
    public function delete_by_id($id)
    {
        $this->db->where('nobeli', $id);
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
    public function save_pembelian($data)
    {
        $this->db->insert('inv.hbeli', $data);
    }
    public function get_by_id($nobeli)
    {
        $this->db->select("a.nobeli,a.tanggalreq,a.tanggaldel,b.namasup,a.kodebeli,a.tanggal,  a.disc1, a.hutang, a.idcabang, a.tbrutto, a.biaya, a.potongan, a.post, a.kodesup, a.ppn, a.faktur, a.nilaidisc1, a.nilaippn, a.nilaifak");
        $this->db->from('hbeli a');
        $this->db->join('suplier b', 'a.kodesup=b.kodesup');
        $this->db->where('nobeli', $nobeli);
        $query = $this->db->get();

        return $query->row();
    }
}
