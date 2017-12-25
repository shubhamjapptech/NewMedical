<?php

class Pharmasist_model extends CI_Model {

	function __construct() {

        parent::__construct();

        $this->load->database();

    }



	public function registred_pharmasist()

	{
        $this->db->order_by("id","DESC");
		
		$query=$this->db->get('pharmasist');

		return $count=$query->result();

	}



	public function insert_pharmasist($data)

	{

		$c=$this->db->insert('pharmasist',$data);

		if($c)

		{

		return true;

		}

		else

		{

			return false;

		}

	}

	public function ispharmacistexits($email)
	{
		$query=$this->db->get_where('pharmasist',array('email'=>$email));
		return $query->num_rows();
	}



	public function get_pharmasist($id)

	{

		$this->db->where('id',$id);	

		$query=$this->db->get('pharmasist');

		return $r=$query->row();

	}



	public function update_pharmasist($data,$id)

	{

		$this->db->where('id',$id);

		$rr=$this->db->update('pharmasist',$data);

		if($rr)

		{

			return true;

		}	

		else

		{

			return false;

		}		

	}



	public function delete_pharmasist($id)

	{

		$s=$this->db->delete('pharmasist', array('id' => $id));

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