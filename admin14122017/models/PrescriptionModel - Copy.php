<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class PrescriptionModel extends CI_Model {
	function __construct() {
        parent::__construct();
        $this->load->database();
    }

	public function prescriptionimage()
	{
		$this->db->select('prescription.pharmacist_id,prescription.user_id,prescription.id,prescription.prescription_image,prescription.insurance_image,prescription_scan,prescription.time_stamp,family_member.first_name,last_name,prescription.member_id,prescription.status,pharmacy.pharmacy_name');
		$this->db->from('prescription');
		$this->db->join('family_member', 'prescription.member_id = family_member.id');
		$this->db->join('pharmacy','prescription.pharmacy_id = pharmacy.id');
		$this->db->where('prescription.status="member"');
		$que = $this->db->get()->result();				

		$this->db->select('prescription.pharmacist_id,prescription.user_id,prescription.id,prescription.prescription_image,prescription.insurance_image,prescription_scan,prescription.time_stamp,registration.first_name,last_name,prescription.member_id,prescription.status,pharmacy.pharmacy_name');
		$this->db->from('prescription');
		$this->db->join('registration', 'prescription.user_id = registration.id');
		$this->db->join('pharmacy','prescription.pharmacy_id = pharmacy.id');
		$this->db->where('prescription.status="user"');
		$que1 = $this->db->get()->result();
		$new=array_merge($que,$que1);
		print_r($new); die();
		foreach ($new as $key)
		{
    		$sort[] = $key['time_stamp'];
		}
			$newarray[]=array_multisort($sort, SORT_DESC, $new);
			
	}

	public function prescriptionimage1($id)
	{
		$this->db->select('prescription.pharmacist_id,prescription.user_id,prescription.id,prescription.prescription_image,prescription.insurance_image,prescription_scan,prescription.time_stamp,family_member.first_name,last_name,prescription.member_id,prescription.status,pharmacy.pharmacy_name');
		$this->db->from('prescription');
		$this->db->join('family_member', 'prescription.member_id = family_member.id');
		$this->db->join('pharmacy','prescription.pharmacy_id = pharmacy.id');
		$this->db->where('prescription.status="member"');
		$this->db->where('prescription.pharmacist_id='.$id);
		$que = $this->db->get()->result();				

		$this->db->select('prescription.pharmacist_id,prescription.user_id,prescription.id,prescription.prescription_image,prescription.insurance_image,prescription_scan,prescription.time_stamp,registration.first_name,last_name,prescription.member_id,prescription.status,pharmacy.pharmacy_name');
		$this->db->from('prescription');
		$this->db->join('registration', 'prescription.user_id = registration.id');
		$this->db->join('pharmacy','prescription.pharmacy_id = pharmacy.id');
		$this->db->where('prescription.status="user"');
		$this->db->where('prescription.pharmacist_id='.$id);
		$que1 = $this->db->get()->result();
		$new=array_merge($que,$que1);
		if($new!='')
		{
		return $new;
		}
		else
		{
			return false;
		}
	}
	

	public function pharmasistname()
	{
		$this->db->select('id,name');
		$this->db->from('pharmasist');		
		return $this->db->get()->result();
	}	


	public function add_prescription($data)
	{
		$result=$this->db->insert_batch('patatent_tablets', $data); 
		if($result)
		{
			return true;
		}
		else
		{
			return false;
		}

	}

	public function update_presctiption($time)
	{		
		$re=$this->db->update_batch('patatent_tablets',$time,'id');
		if($re)
		{
			return true;
		}
		else
		{
			return false;
		}

	}

	public function delete_prescription($pres_id,$med_name)
	{
	  $d= $this->db->delete('patatent_tablets',array('prescription_id'=>$pres_id,'medicine_name'=>$med_name));
	  if($d)
	  {
	  	return true;
	  }
	  else
	  {
	  	return false;
	  }
	}

	public function prescription_list($p_id)
	{
		$this->db->group_by('medicine_name');
		$query=$this->db->get_where('patatent_tablets',array('prescription_id'=>$p_id));
		if($query->num_rows()>0)
		{
			return $query;
		}
		else
		{
			return false;
		}
	}

	public function prescription_record($u_id,$pres_id,$med_name)
	{
		$this->db->group_by('medicine_name');
		$query=$this->db->get_where('patatent_tablets',array('prescription_id'=>$pres_id,'user_id'=>$u_id,'medicine_name'=>$med_name));
		return $query->row();
	}
	public function prescription_time($u_id,$pres_id,$med_name)
	{
		$this->db->select('time,id');
		$this->db->from('patatent_tablets');
		$this->db->where('prescription_id',$pres_id);
		$this->db->where('user_id',$u_id);
		$time=$this->db->where('medicine_name',$med_name)->get();
		return $time->result();
	}
	
	public function medicine($p_id)
	{
		$this->db->select('medicine_name');		
		$this->db->order_by("medicine_name", "asc");
		$rr=$this->db->from('patatent_tablets')->get();
		$count=$rr->num_rows();
		//echo $count;die();
		if($count>0)
		{
			$result=$rr->result();
			return $result;
	    }
	    else
	    {
	    	return false;
	    }
	}

	public function search_company($name)
	{
		$this->db->like('name',$name,'both');
		$this->db->order_by('name');
		$res=$this->db->get('pharmasist');
		return $res->result(); 
	}
        
    public function search_medicine($name)
	{
		$this->db->like('medicine_name',$name,'both');
		$this->db->group_by('medicine_name');
		$this->db->from('patatent_tablets');
		$res=$this->db->get();
		return $res->result(); 
	}
    public function assigned($ph_id,$pres_id)
    {
    	$this->db->where('id',$pres_id);
		$rr=$this->db->update('prescription',array('pharmacist_id'=>$ph_id));
		if($rr)
		{
			return true;
		}	
		else
		{
			return false;
		}		
    
    }
    public function assignedpharmacist($ph_id)
    {
    	$a=$this->db->get_where('pharmasist',array('id'=>$ph_id));
    	return $a->row();
    }

    public function allprescription($p_id)
	{
		$this->db->group_by('medicine_name');
		$query=$this->db->get_where('patatent_tablets',array('pharmacist_id'=>$p_id));
		if($query->num_rows()>0)
		{
			return $query;
		}
		else
		{
			return false;
		}
	}

}
?>