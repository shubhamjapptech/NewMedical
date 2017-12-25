<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Prescriptioncheck extends CI_Model {
	function __construct() {
        parent::__construct();
        $this->load->database();
    }

	public function prescriptioncount()
	{
		$q=$this->db->query("SELECT * FROM prescription WHERE `seen_status`=0 OR `seen_status`=1");
		$count= $q->num_rows();			
		return $count;
	}

	public function checkpopup()
	{
		$q=$this->db->get_where("prescription",array('seen_status'=>0))->num_rows();		
		if($q!=0)
		{
			$this->db->select('registration.first_name,last_name,email,prescription.id,user_id');
			$this->db->from('prescription');
			$this->db->join('registration', 'prescription.user_id = registration.id');
			$this->db->where('prescription.seen_status=0');
			$result= $this->db->get()->result();
			return $result;
		}
	}


	public function removepopup($tablename)
	{
		$this->db->where('seen_status',0);
		$this->db->update($tablename,array('seen_status'=>1));
	}

	public function updatecount($tablename)
	{
		//echo $tablename;
		$q=$this->db->query("UPDATE $tablename SET `seen_status`=2 WHERE `seen_status`=0 OR `seen_status`=1");
		//$this->db->where('seen_status',0 OR 'seen_status',1);
		//$this->db->update($tablename,array('seen_status'=>2));
	}

	public function usercount()
	{
		$q=$this->db->query("SELECT * FROM registration WHERE `seen_status`=0 OR `seen_status`=1");
		$count= $q->num_rows();			
		return $count;			
	}
}
?>