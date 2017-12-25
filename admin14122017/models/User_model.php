<?php

class User_model extends CI_Model {

	function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_user($id)
	{
		$this->db->where('id',$id);	
		$query=$this->db->get('registration');
		return $r=$query->row();
	}

	public function user_pharmacy()
	{
		$query=$this->db->get("user_pharmacy");		
		$result=$query->result();
		//echo json_encode($result);die();
		return $result;
	}

	public function ispharmaciesExisted($zipcode)
    {
    	$query=$this->db->get_where('pharmacy',array('zipcode' =>$zipcode));	
    	$count =$query->num_rows();
    	//echo $count; die();
		if($count>0)
		{
			return false;
		}
		else
		{
			return true;
		}
    }

	public function add_user($data)

	{
		$this->db->insert('registration',$data);
		return $this->db->insert_id();
	}

	public function update_qbId($id,$qb_id)
	{
		$this->db->where('id',$id);
		return $this->db->update('registration',array('qb_id'=>$qb_id));
	}

	public function update_user($data,$id)

	{
		$this->db->where('id',$id);
		$rr=$this->db->update('registration',$data);
		if($rr)
		{
			return true;
		}	
		else
		{
			return false;
		}
	}

	public function check_user($email)
	{
		$query=$this->db->get_where('registration',array('email'=>$email));
		return $query->num_rows();		
	}
	public function update_image($image,$id)
	{
		 $data=array(
		 	"image"=>$image,
		 	"image_type"=>0	
		 	);		
		$this->db->where('id',$id);
		$res=$this->db->update('registration',$data);
		if($res)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function delete_user($id)
	{
		$s=$this->db->delete('registration', array('id' => $id));
		if($s)
		{
			$this->db->delete('prescription', array('user_id' => $id));
			$this->db->delete('prescription_medicine', array('user_id' => $id));
			return true; 
		}
		else
		{
			return false;
		}
	}

	public function userPharmacy($user_id)
	{
		return $this->db->get_where("user_pharmacy",array('user_id'=>$user_id))->row();
	}

	public function addUserPharmacy($data)
	{
		return $this->db->insert('user_pharmacy',$data);
	}

	public function updateUserPharmacy($data,$user_id)
	{
		$this->db->where('user_id',$user_id);
		return $this->db->update('user_pharmacy',$data);
	}
}