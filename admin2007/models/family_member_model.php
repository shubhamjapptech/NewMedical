<?php
class Family_member_model extends CI_Model {
	function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function family_members($id)
	{
		$query=$this->db->get_where('family_member',array('user_id'=>$id));
	 	return $query;
	}
	
	public function add($data)
	{
		$res=$this->db->insert('family_member',$data);
		if($res)
		{
			return true;
		}
		else
		{
			return false;
		}

	}

	public function delete_member($id)
	{
		$s=$this->db->delete('family_member', array('id'=>$id));
		if($s)
		{
			return true;  
		}
		else
		{
			return false;
		}
	}

	public function family_member_detail($id)
	{
		$query=$this->db->get_where('family_member',array('id'=>$id));
	 	return $query;
	}

	public function update_member($data,$id)
	{
		$this->db->where('id',$id);
		$update=$this->db->update('family_member',$data);
		if($update)
		{
			return true;
		}
		else
		{
			return false;
		}

	}
}
