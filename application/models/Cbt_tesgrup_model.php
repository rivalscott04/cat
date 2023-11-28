<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* CATEDU
* Achmad Lutfi
* achmdlutfi@gmail.com
* CATEDU@sasambo.com
*/
class Cbt_tesgrup_model extends CI_Model{
	public $table = 'cbt_tesgrup';
	
	function __construct(){
        parent::__construct();
    }
	
    function save($data){
        $this->db->insert($this->table, $data);
    }
    
    function delete($kolom, $isi){
        $this->db->where($kolom, $isi)
                 ->delete($this->table);
    }
    
    function update($kolom, $isi, $data){
        $this->db->where($kolom, $isi)
                 ->update($this->table, $data);
    }
    
    function count_by_kolom($kolom, $isi){
        $this->db->select('COUNT(*) AS hasil')
                 ->where($kolom, $isi)
                 ->from($this->table);
        return $this->db->get();
    }

    function count_by_tes_and_group($tes, $group){
        $this->db->select('COUNT(*) AS hasil')
                 ->where('(tstgrp_tes_id="'.$tes.'" AND tstgrp_grup_id="'.$group.'" )')
                 ->from($this->table);
        return $this->db->get();
    }
	
	function get_by_kolom($kolom, $isi){
        $this->db->where($kolom, $isi)
                 ->from($this->table);
        return $this->db->get();
    }
	
	function get_by_tes_id($tes_id){
        $this->db->where('tstgrp_tes_id', $tes_id)
				 ->join('cbt_user_grup', 'cbt_tesgrup.tstgrp_grup_id = cbt_user_grup.grup_id')
                 ->from($this->table);
        return $this->db->get();
    }
	
	function get_by_kolom_limit($kolom, $isi, $limit){
        $this->db->where($kolom, $isi)
                 ->from($this->table)
				 ->limit($limit);
        return $this->db->get();
    }

    function get_by_tanggal($tglawal, $tglakhir){
        $this->db->where('(DATE(tes_begin_time)>="'.$tglawal.'" AND DATE(tes_begin_time)<="'.$tglakhir.'")')
                 ->join('cbt_tes', 'cbt_tesgrup.tstgrp_tes_id = cbt_tes.tes_id')
                 ->order_by('tes_begin_time ASC, tes_nama ASC')
                 ->from($this->table);
        return $this->db->get();
    }
	
	function get_by_tanggal_and_grup($tglawal, $tglakhir, $grup_id){
        $this->db->where('(DATE(tes_begin_time)>="'.$tglawal.'" AND DATE(tes_begin_time)<="'.$tglakhir.'" AND tstgrp_grup_id="'.$grup_id.'")')
                 ->join('cbt_tes', 'cbt_tesgrup.tstgrp_tes_id = cbt_tes.tes_id')
                 ->order_by('tes_begin_time ASC, tes_nama ASC')
                 ->from($this->table);
        return $this->db->get();
    }
	
	function get_datatable($start, $rows, $grup_id){
		$now = date('Y-m-d H:i:s');
		$this->db->where('(tstgrp_grup_id="'.$grup_id.'" AND tes_begin_time<="'.$now.'" AND tes_end_time>="'.$now.'")')
                 ->from($this->table)
                 ->join('cbt_tes', 'cbt_tesgrup.tstgrp_tes_id = cbt_tes.tes_id')
                 ->order_by('tes_begin_time ASC, tes_nama ASC')
                 ->limit($rows, $start);
        return $this->db->get();
	}
    
    function get_datatable_count($grup_id){
		$now = date('Y-m-d H:i:s');
		$this->db->select('COUNT(*) AS hasil')
                 ->where('(tstgrp_grup_id="'.$grup_id.'" AND tes_begin_time<="'.$now.'" AND tes_end_time>="'.$now.'")')
                 ->join('cbt_tes', 'cbt_tesgrup.tstgrp_tes_id = cbt_tes.tes_id')
                 ->from($this->table);
        return $this->db->get();
	}
}