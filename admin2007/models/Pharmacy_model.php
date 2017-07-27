<?php
class Pharmacy_model extends CI_Model {
	function __construct() {
        parent::__construct();
        $this->load->database();
    }

	public function registred_pharmacy()
	{
		$this->db->from('pharmacy');
		$this->db->order_by("id", "desc");
		$query = $this->db->get(); 
		return $query->result();
	}
	public function insert_pharmacy($data)
	{
		$c=$this->db->insert('pharmacy',$data);
		if($c)
		{
		return true;
		}
		else
		{
			return false;
		}
	}

	public function ispharmacyexits($email,$pharmacy_name)
	{
		$this->db->from('pharmacy');
		$this->db->where('email_id',$email);
		$this->db->or_where('pharmacy_name',$pharmacy_name);
		$query=$this->db->get();
		return $query->num_rows();
	}
	public function ispharmacyexitsUpdate($email,$pharmacy_name,$id)
	{
		$this->db->from('pharmacy');
		$this->db->where('email_id',$email);
		$this->db->where('id!=',$id);
		$this->db->or_where('pharmacy_name',$pharmacy_name);
		$this->db->where('id!=',$id);
		$query=$this->db->get();
		return $query->num_rows();
		

	}

	public function get_pharmacy($id)
	{
		$this->db->where('id',$id);	
		$query=$this->db->get('pharmacy');
		return $r=$query->row();
	}

	public function update_pharmacy($data,$id)
	{
		$this->db->where('id',$id);
		$rr=$this->db->update('pharmacy',$data);
		if($rr)
		{
			return true;
		}	
		else
		{
			return false;
		}		
	}

	

	public function delete_pharmacy($id)
	{
		$s=$this->db->delete('pharmacy', array('id' => $id));
		if($s)
		{
			return true;  
		}
		else
		{
			return false;
		}
	}


	public function all_tablets($id)
	{
		$query=$this->db->get_where('tablet',array('pharmacist_id'=>$id));
	 	return $query;
	}

}

?>