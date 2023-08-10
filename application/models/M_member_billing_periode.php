<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class M_member_billing_periode extends CI_Model {
 
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
        // $thn = date("Y");
        // $bln = date("m");
        $this->db->select("a.kodecus,b.namacus,sum(a.piutang)+sum(a.bayar) TotPembelian,sum(a.bayar) TotBayar,sum(a.piutang) TotHutang");
        $this->db->from('hpiutang a');
        $this->db->join('customer b', 'b.kodecus=a.kodecus');
        $this->db->join('hjual c', 'c.nojual=a.nojual');
        $this->db->where('a.kodecus=', $nik);
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
        $month = date('m');
        $years = date('Y');
        //jika semua parameter di set
        if (isset($params['txt_cari_bln']) && isset($params['txt_cari_thn'])) {
            $this->db->where('month(a.tanggal)', $params['txt_cari_bln']);
            $this->db->where('year(a.tanggal)', $params['txt_cari_thn']);
          }
         //jika parameter txt_cari_bln
        if (isset($params['txt_cari_bln']) && !isset($params['txt_cari_thn'])) {
           $this->db->where('month(a.tanggal)', $params['txt_cari_bln']);
           $this->db->where('year(a.tanggal)', $years);
          }
        //jika parameter txt_cari_thn yang diset 
        if (!isset($params['txt_cari_bln']) && isset($params['txt_cari_thn'])) {
            $this->db->where('year(a.tanggal)', $params['txt_cari_thn']);
          }          
        //jika Semua Parameter Tidak di sett
        if (!isset($params['txt_cari_bln']) && !isset($params['txt_cari_thn'])) {
             $this->db->where('month(a.tanggal)', $month);
             $this->db->where('year(a.tanggal)', $years);
            //  die(var_dump('Kuya'));
        }        
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        // die(var_dump($query->result()));
        return $query->result();
    }
    function count_filtered($params)
    {
        $this->_get_datatables_query();
        $month = date('m');
        $years = date('Y');
        //jika semua parameter di set
        if (isset($params['txt_cari_bln']) && isset($params['txt_cari_thn'])) {
            $this->db->where('month(a.tanggal)', $params['txt_cari_bln']);
            $this->db->where('year(a.tanggal)', $params['txt_cari_thn']);
          }
         //jika parameter txt_cari_bln
        if (isset($params['txt_cari_bln']) && !isset($params['txt_cari_thn'])) {
           $this->db->where('month(a.tanggal)', $params['txt_cari_bln']);
           $this->db->where('year(a.tanggal)', $years);
          }
        //jika parameter txt_cari_thn yang diset 
        if (!isset($params['txt_cari_bln']) && isset($params['txt_cari_thn'])) {
            $this->db->where('year(a.tanggal)', $params['txt_cari_thn']);
          }
          
        //jika Semua Parameter Tidak di sett
        if (!isset($params['txt_cari_bln']) && !isset($params['txt_cari_thn'])) {
             $this->db->where('month(a.tanggal)', $month);
             $this->db->where('year(a.tanggal)', $years);
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
        //jika semua parameter di set
        if (isset($params['txt_cari_bln']) && isset($params['txt_cari_thn'])) {
            $this->db->where('month(a.tanggal)', $params['txt_cari_bln']);
            $this->db->where('year(a.tanggal)', $params['txt_cari_thn']);
          }
         //jika parameter txt_cari_bln
        if (isset($params['txt_cari_bln']) && !isset($params['txt_cari_thn'])) {
           $this->db->where('month(a.tanggal)', $params['txt_cari_bln']);
           $this->db->where('year(a.tanggal)', $years);
          }
        //jika parameter txt_cari_thn yang diset 
        if (!isset($params['txt_cari_bln']) && isset($params['txt_cari_thn'])) {
            $this->db->where('year(a.tanggal)', $params['txt_cari_thn']);
          }
          
        //jika Semua Parameter Tidak di sett
        if (!isset($params['txt_cari_bln']) && !isset($params['txt_cari_thn'])) {
             $this->db->where('month(a.tanggal)', $month);
             $this->db->where('year(a.tanggal)', $years);
        }
        return $this->db->count_all_results();
    }
    public function get_detail_kodecus($id)
    {
        
        $this->db->select("a.nojual AS IDTrans,a.tanggal AS TglTrans,a.jam AS JamTrans,a.tgltempo AS JthTempo,a.kodecus AS KDCust,e.namacus AS NamaCust,b.kodebrg AS KDBrg,c.namabrg AS NMBrg,b.qtyjual AS QTY,d.namasat AS Unit,b.hjual1 AS HRG_Jual,(b.hpp/b.qtyjual) AS HPP,(b.hpp/b.qtyjual)*b.qtyjual AS TotalHPP,b.brutto AS TotPembelian,(b.hjual1-(b.hpp/b.qtyjual))*b.qtyjual AS ProfitRP,ROUND(((b.brutto-((b.hpp/b.qtyjual)*qtyjual))/((b.hpp/b.qtyjual)*qtyjual))*100,2) AS ProfitPersen, case when b.deleted=2 then 'Cancel' when b.deleted=1 then 'Input' when b.deleted=0 then 'Oke' end as STATUS");
        $this->db->from('hjual a');
        $this->db->join('djual b', 'a.nojual=b.nojual');
        $this->db->join('barang c', 'b.kodebrg=c.kodebrg');
        $this->db->join('satuan d', 'b.kodesat=d.kodesat');
        $this->db->join('customer e', 'e.kodecus=b.kodecus', 'left');
        $this->db->where('a.kodecus', $id);
        $query = $this->db->get();
        return $query->row();
    }
    private function _get_datatables_query_detail()
    {
        $niks = $this->session->userdata('NIK');
        $this->db->select("a.nojual AS IDTrans,a.tanggal AS TglTrans,a.jam AS JamTrans,a.tgltempo AS JthTempo,a.kodecus AS KDCust,e.namacus AS NamaCust,b.kodebrg AS KDBrg,c.namabrg AS NMBrg,b.qtyjual AS QTY,d.namasat AS Unit,b.hjual1 AS HRG_Jual,(b.hpp/b.qtyjual) AS HPP,(b.hpp/b.qtyjual)*b.qtyjual AS TotalHPP,b.brutto AS TotPembelian,(b.hjual1-(b.hpp/b.qtyjual))*b.qtyjual AS ProfitRP,ROUND(((b.brutto-((b.hpp/b.qtyjual)*qtyjual))/((b.hpp/b.qtyjual)*qtyjual))*100,2) AS ProfitPersen, case when b.deleted=2 then 'Cancel' when b.deleted=1 then 'Input' when b.deleted=0 then 'Oke' end as STATUS");
        $this->db->from('hjual a');
        $this->db->join('djual b', 'a.nojual=b.nojual');
        $this->db->join('barang c', 'b.kodebrg=c.kodebrg');
        $this->db->join('satuan d', 'b.kodesat=d.kodesat');
        $this->db->join('customer e', 'e.kodecus=b.kodecus', 'left');
        $this->db->where('a.post', '1');
        $this->db->where('a.kodecus=', $niks);
        $this->db->order_by('a.tanggal','ASC');
        $i = 0;
    }

    function get_datatables_detail($params)
    {
        $this->_get_datatables_query_detail();
        $months = date('m');
        $yearss = date('Y');
        //jika semua parameter di set
        if (isset($params['bulan_temp']) && isset($params['txt_year_periode'])) {
            $this->db->where('month(a.tanggal)', $params['bulan_temp']);
            $this->db->where('year(a.tanggal)', $params['txt_year_periode']);
          }
         //jika parameter txt_cari_bln
        if (isset($params['bulan_temp']) && !isset($params['txt_year_periode'])) {
           $this->db->where('month(a.tanggal)', $params['bulan_temp']);
           $this->db->where('year(a.tanggal)', $yearss);
          }
        //jika parameter txt_cari_thn yang diset 
        if (!isset($params['bulan_temp']) && isset($params['txt_year_periode'])) {
            $this->db->where('year(a.tanggal)', $params['txt_year_periode']);
          }          
        //jika Semua Parameter Tidak di sett
        if (!isset($params['bulan_temp']) && !isset($params['txt_year_periode'])) {
             $this->db->where('month(a.tanggal)', $months);
             $this->db->where('year(a.tanggal)', $yearss);
            //  die(var_dump('Kuya'));
        }   
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function count_filtered_detail($params)
    {
        $this->_get_datatables_query_detail();
        $months = date('m');
        $yearss = date('Y');
        //jika semua parameter di set
        if (isset($params['bulan_temp']) && isset($params['txt_year_periode'])) {
            $this->db->where('month(a.tanggal)', $params['bulan_temp']);
            $this->db->where('year(a.tanggal)', $params['txt_year_periode']);
          }
         //jika parameter txt_cari_bln
        if (isset($params['bulan_temp']) && !isset($params['txt_year_periode'])) {
           $this->db->where('month(a.tanggal)', $params['bulan_temp']);
           $this->db->where('year(a.tanggal)', $yearss);
          }
        //jika parameter txt_cari_thn yang diset 
        if (!isset($params['bulan_temp']) && isset($params['txt_year_periode'])) {
            $this->db->where('year(a.tanggal)', $params['txt_year_periode']);
          }          
        //jika Semua Parameter Tidak di sett
        if (!isset($params['bulan_temp']) && !isset($params['txt_year_periode'])) {
             $this->db->where('month(a.tanggal)', $months);
             $this->db->where('year(a.tanggal)', $yearss);
            //  die(var_dump('Kuya'));
        }   
        $query = $this->db->get();
        // die(var_dump($query->num_rows()));
        return $query->num_rows();
    }
    public function count_all_detail($params)
    {
        // $this->db->from($this->table);
        $this->_get_datatables_query_detail();
        $months = date('m');
        $yearss = date('Y');
        //jika semua parameter di set
        if (isset($params['bulan_temp']) && isset($params['txt_year_periode'])) {
            $this->db->where('month(a.tanggal)', $params['bulan_temp']);
            $this->db->where('year(a.tanggal)', $params['txt_year_periode']);
          }
         //jika parameter txt_cari_bln
        if (isset($params['bulan_temp']) && !isset($params['txt_year_periode'])) {
           $this->db->where('month(a.tanggal)', $params['bulan_temp']);
           $this->db->where('year(a.tanggal)', $yearss);
          }
        //jika parameter txt_cari_thn yang diset 
        if (!isset($params['bulan_temp']) && isset($params['txt_year_periode'])) {
            $this->db->where('year(a.tanggal)', $params['txt_year_periode']);
          }          
        //jika Semua Parameter Tidak di sett
        if (!isset($params['bulan_temp']) && !isset($params['txt_year_periode'])) {
             $this->db->where('month(a.tanggal)', $months);
             $this->db->where('year(a.tanggal)', $yearss);
            //  die(var_dump('Kuya'));
        }   
        return $this->db->count_all_results();
    }
}