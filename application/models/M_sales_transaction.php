<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_sales_transaction extends CI_Model {
 
    var $table = 'hjual';
    var $column_order = array(null,null, 'a.nojual','a.tanggal','a.jam','a.tgltempo','a.kodecus','e.namacus','b.kodebrg','c.namabrg','b.qtyjual','d.namasat','b.hjual1','HPP','TotalHPP','TotPembelian','ProfitRP','ProfitPersen','STATUS'); //set column field database for datatable orderable
    var $column_search = array('a.nojual','a.tanggal','a.jam','a.tgltempo','a.kodecus','e.namacus','b.kodebrg','c.namabrg','b.qtyjual','d.namasat','b.hjual1'); //set column field database for datatable searchable 
    var $order = array('a.nojual,a.tanggal' => 'asc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {
        // $month = date('m')-3;
        // $years = date('Y');
        $this->db->select("a.nojual AS IDTrans,a.tanggal AS TglTrans,a.jam AS JamTrans,a.tgltempo AS JthTempo,a.kodecus AS KDCust,e.namacus AS NamaCust,b.kodebrg AS KDBrg,c.namabrg AS NMBrg,b.qtyjual AS QTY,d.namasat AS Unit,b.hjual1 AS HRG_Jual,(b.hpp/b.qtyjual) AS HPP,(b.hpp/b.qtyjual)*b.qtyjual AS TotalHPP,b.brutto AS TotPembelian,(b.hjual1-(b.hpp/b.qtyjual))*b.qtyjual AS ProfitRP,ROUND(((b.brutto-((b.hpp/b.qtyjual)*qtyjual))/((b.hpp/b.qtyjual)*qtyjual))*100,2) AS ProfitPersen, case when b.deleted=2 then 'Cancel' when b.deleted=1 then 'Input' when b.deleted=0 then 'Oke' end as STATUS");
        $this->db->from('hjual a');
        $this->db->join('djual b', 'a.nojual=b.nojual');
        $this->db->join('barang c', 'b.kodebrg=c.kodebrg');
        $this->db->join('satuan d', 'b.kodesat=d.kodesat');
        $this->db->join('customer e', 'e.kodecus=b.kodecus', 'left');
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
        //jika semua parameter tidak di set
        if (!isset($params['txt_tgl_start']) && !isset($params['txt_tgl_end']) && !isset($params['txt_nmkary']) && !isset($params['txt_status']) ) {
             $this->db->where('month(a.tanggal)', $month);
             $this->db->where('year(a.tanggal)', $years);
            // die($params['txt_status']);
        }
       
        //jika parameter yang di set txt_nmkary
        if (!isset($params['txt_tgl_start']) && !isset($params['txt_tgl_end']) && isset($params['txt_nmkary']) && isset($params['txt_status']) ) {
             $this->db->where('month(a.tanggal)', $month);
             $this->db->where('year(a.tanggal)', $years);
             $this->db->where('a.kodecus', $params['txt_nmkary']);
            //  die($params['txt_status']);
        }

        //jika parameter yang di set txt_status
        if (!isset($params['txt_tgl_start']) && !isset($params['txt_tgl_end']) && !isset($params['txt_nmkary']) && isset($params['txt_status']) ) {
             $this->db->where('month(a.tanggal)', $month);
             $this->db->where('year(a.tanggal)', $years);
             $this->db->where('b.deleted', $params['txt_status']);
            //  die($params['txt_status']);
        }
        

        //jika parameter yang di set txt_tgl_end,txt_nmkary dan txt_status
        if (!isset($params['txt_tgl_start']) && isset($params['txt_tgl_end']) && isset($params['txt_nmkary']) && isset($params['txt_status'])) {
           $this->db->where('a.tanggal BETWEEN "'.'0000-00-00'. '" and "'.date('Y-m-d',strtotime($params['txt_tgl_end'])).'"');
           $this->db->where('a.kodecus', $params['txt_nmkary']);
           $this->db->where('b.deleted', $params['txt_status']);
        }
        //jika parameter yang di set txt_tgl_start,txt_nmkary dan txt_status
        if (isset($params['txt_tgl_start']) && !isset($params['txt_tgl_end']) && isset($params['txt_nmkary']) && isset($params['txt_status'])) {
           $this->db->where('a.tanggal',date('Y-m-d',strtotime($params['txt_tgl_start'])));
           $this->db->where('a.kodecus', $params['txt_nmkary']);
           $this->db->where('b.deleted', $params['txt_status']);
        }

         //jika parameter yang di set txt_tgl_start,txt_tgl_end dan txt_status
        if (isset($params['txt_tgl_start']) && isset($params['txt_tgl_end']) && !isset($params['txt_nmkary']) && isset($params['txt_status'])) {
           $this->db->where('a.tanggal>=',date('Y-m-d',strtotime($params['txt_tgl_start'])));
           $this->db->where('a.tanggal<=',date('Y-m-d',strtotime($params['txt_tgl_end'])));
           $this->db->where('b.deleted', $params['txt_status']);
        }
        
        //jika parameter yang di set txt_tgl_start
        if (isset($params['txt_tgl_start']) && !isset($params['txt_tgl_end']) && !isset($params['txt_nmkary']) && empty($params['txt_status'])) {
           $this->db->where('a.tanggal',date('Y-m-d',strtotime($params['txt_tgl_start'])));
        }
        //jika parameter yang di set txt_tgl_start dan txt_status
        if (isset($params['txt_tgl_start']) && !isset($params['txt_tgl_end']) && !isset($params['txt_nmkary']) && isset($params['txt_status'])) {
           $this->db->where('a.tanggal',date('Y-m-d',strtotime($params['txt_tgl_start'])));
           $this->db->where('b.deleted', $params['txt_status']);
        }
        //jika semua parameter di set
        if (isset($params['txt_tgl_start']) && isset($params['txt_tgl_end']) && isset($params['txt_nmkary']) && isset($params['txt_status'])) {
            $this->db->where('a.tanggal BETWEEN "'.date('Y-m-d',strtotime($params['txt_tgl_start'])). '" and "'.date('Y-m-d',strtotime($params['txt_tgl_end'])).'"');
            $this->db->where('a.kodecus', $params['txt_nmkary']);
            $this->db->where('b.deleted', $params['txt_status']);
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
        //jika semua parameter tidak di set
        if (!isset($params['txt_tgl_start']) && !isset($params['txt_tgl_end']) && !isset($params['txt_nmkary']) && !isset($params['txt_status']) ) {
             $this->db->where('month(a.tanggal)', $month);
             $this->db->where('year(a.tanggal)', $years);
            // die($params['txt_status']);
        }
       
        //jika parameter yang di set txt_nmkary
        if (!isset($params['txt_tgl_start']) && !isset($params['txt_tgl_end']) && isset($params['txt_nmkary']) && isset($params['txt_status']) ) {
             $this->db->where('month(a.tanggal)', $month);
             $this->db->where('year(a.tanggal)', $years);
             $this->db->where('a.kodecus', $params['txt_nmkary']);
            //  die($params['txt_status']);
        }

        //jika parameter yang di set txt_status
        if (!isset($params['txt_tgl_start']) && !isset($params['txt_tgl_end']) && !isset($params['txt_nmkary']) && isset($params['txt_status']) ) {
             $this->db->where('month(a.tanggal)', $month);
             $this->db->where('year(a.tanggal)', $years);
             $this->db->where('b.deleted', $params['txt_status']);
            //  die($params['txt_status']);
        }
        

        //jika parameter yang di set txt_tgl_end,txt_nmkary dan txt_status
        if (!isset($params['txt_tgl_start']) && isset($params['txt_tgl_end']) && isset($params['txt_nmkary']) && isset($params['txt_status'])) {
           $this->db->where('a.tanggal BETWEEN "'.'0000-00-00'. '" and "'.date('Y-m-d',strtotime($params['txt_tgl_end'])).'"');
           $this->db->where('a.kodecus', $params['txt_nmkary']);
           $this->db->where('b.deleted', $params['txt_status']);
        }
        //jika parameter yang di set txt_tgl_start,txt_nmkary dan txt_status
        if (isset($params['txt_tgl_start']) && !isset($params['txt_tgl_end']) && isset($params['txt_nmkary']) && isset($params['txt_status'])) {
           $this->db->where('a.tanggal',date('Y-m-d',strtotime($params['txt_tgl_start'])));
           $this->db->where('a.kodecus', $params['txt_nmkary']);
           $this->db->where('b.deleted', $params['txt_status']);
        }

         //jika parameter yang di set txt_tgl_start,txt_tgl_end dan txt_status
        if (isset($params['txt_tgl_start']) && isset($params['txt_tgl_end']) && !isset($params['txt_nmkary']) && isset($params['txt_status'])) {
           $this->db->where('a.tanggal>=',date('Y-m-d',strtotime($params['txt_tgl_start'])));
           $this->db->where('a.tanggal<=',date('Y-m-d',strtotime($params['txt_tgl_end'])));
           $this->db->where('b.deleted', $params['txt_status']);
        }
        
        //jika parameter yang di set txt_tgl_start
        if (isset($params['txt_tgl_start']) && !isset($params['txt_tgl_end']) && !isset($params['txt_nmkary']) && empty($params['txt_status'])) {
           $this->db->where('a.tanggal',date('Y-m-d',strtotime($params['txt_tgl_start'])));
        }
        //jika parameter yang di set txt_tgl_start dan txt_status
        if (isset($params['txt_tgl_start']) && !isset($params['txt_tgl_end']) && !isset($params['txt_nmkary']) && isset($params['txt_status'])) {
           $this->db->where('a.tanggal',date('Y-m-d',strtotime($params['txt_tgl_start'])));
           $this->db->where('b.deleted', $params['txt_status']);
        }
        //jika semua parameter di set
        if (isset($params['txt_tgl_start']) && isset($params['txt_tgl_end']) && isset($params['txt_nmkary']) && isset($params['txt_status'])) {
            $this->db->where('a.tanggal BETWEEN "'.date('Y-m-d',strtotime($params['txt_tgl_start'])). '" and "'.date('Y-m-d',strtotime($params['txt_tgl_end'])).'"');
            $this->db->where('a.kodecus', $params['txt_nmkary']);
            $this->db->where('b.deleted', $params['txt_status']);
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
        //jika semua parameter tidak di set
        if (!isset($params['txt_tgl_start']) && !isset($params['txt_tgl_end']) && !isset($params['txt_nmkary']) && !isset($params['txt_status']) ) {
             $this->db->where('month(a.tanggal)', $month);
             $this->db->where('year(a.tanggal)', $years);
            // die($params['txt_status']);
        }
       
        //jika parameter yang di set txt_nmkary
        if (!isset($params['txt_tgl_start']) && !isset($params['txt_tgl_end']) && isset($params['txt_nmkary']) && isset($params['txt_status']) ) {
             $this->db->where('month(a.tanggal)', $month);
             $this->db->where('year(a.tanggal)', $years);
             $this->db->where('a.kodecus', $params['txt_nmkary']);
            //  die($params['txt_status']);
        }

        //jika parameter yang di set txt_status
        if (!isset($params['txt_tgl_start']) && !isset($params['txt_tgl_end']) && !isset($params['txt_nmkary']) && isset($params['txt_status']) ) {
             $this->db->where('month(a.tanggal)', $month);
             $this->db->where('year(a.tanggal)', $years);
             $this->db->where('b.deleted', $params['txt_status']);
            //  die($params['txt_status']);
        }
        

        //jika parameter yang di set txt_tgl_end,txt_nmkary dan txt_status
        if (!isset($params['txt_tgl_start']) && isset($params['txt_tgl_end']) && isset($params['txt_nmkary']) && isset($params['txt_status'])) {
           $this->db->where('a.tanggal BETWEEN "'.'0000-00-00'. '" and "'.date('Y-m-d',strtotime($params['txt_tgl_end'])).'"');
           $this->db->where('a.kodecus', $params['txt_nmkary']);
           $this->db->where('b.deleted', $params['txt_status']);
        }
        //jika parameter yang di set txt_tgl_start,txt_nmkary dan txt_status
        if (isset($params['txt_tgl_start']) && !isset($params['txt_tgl_end']) && isset($params['txt_nmkary']) && isset($params['txt_status'])) {
           $this->db->where('a.tanggal',date('Y-m-d',strtotime($params['txt_tgl_start'])));
           $this->db->where('a.kodecus', $params['txt_nmkary']);
           $this->db->where('b.deleted', $params['txt_status']);
        }

         //jika parameter yang di set txt_tgl_start,txt_tgl_end dan txt_status
        if (isset($params['txt_tgl_start']) && isset($params['txt_tgl_end']) && !isset($params['txt_nmkary']) && isset($params['txt_status'])) {
           $this->db->where('a.tanggal>=',date('Y-m-d',strtotime($params['txt_tgl_start'])));
           $this->db->where('a.tanggal<=',date('Y-m-d',strtotime($params['txt_tgl_end'])));
           $this->db->where('b.deleted', $params['txt_status']);
        }
        
        //jika parameter yang di set txt_tgl_start
        if (isset($params['txt_tgl_start']) && !isset($params['txt_tgl_end']) && !isset($params['txt_nmkary']) && empty($params['txt_status'])) {
           $this->db->where('a.tanggal',date('Y-m-d',strtotime($params['txt_tgl_start'])));
        }
        //jika parameter yang di set txt_tgl_start dan txt_status
        if (isset($params['txt_tgl_start']) && !isset($params['txt_tgl_end']) && !isset($params['txt_nmkary']) && isset($params['txt_status'])) {
           $this->db->where('a.tanggal',date('Y-m-d',strtotime($params['txt_tgl_start'])));
           $this->db->where('b.deleted', $params['txt_status']);
        }
        //jika semua parameter di set
        if (isset($params['txt_tgl_start']) && isset($params['txt_tgl_end']) && isset($params['txt_nmkary']) && isset($params['txt_status'])) {
            $this->db->where('a.tanggal BETWEEN "'.date('Y-m-d',strtotime($params['txt_tgl_start'])). '" and "'.date('Y-m-d',strtotime($params['txt_tgl_end'])).'"');
            $this->db->where('a.kodecus', $params['txt_nmkary']);
            $this->db->where('b.deleted', $params['txt_status']);
        }
        return $this->db->count_all_results();
    }
 
}