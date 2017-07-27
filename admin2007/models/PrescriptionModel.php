<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class PrescriptionModel extends CI_Model {
	function __construct() {
        parent::__construct();
        $this->load->database();
    }

	public function prescriptionimage()
	{
		
		$this->db->select('prescription.pharmacist_id,prescription.user_id,prescription.id,prescription.insurance_image,prescription_scan,prescription.time_stamp,registration.first_name,last_name,email,user_pharmacy.pharmacy_name');
		$this->db->from('prescription');
		$this->db->join('registration', 'prescription.user_id = registration.id');
		$this->db->join('user_pharmacy','prescription.pharmacy_id = user_pharmacy.id');
		$this->db->order_by('prescription.id','desc');
		$que1 = $this->db->get()->result();
		// print_r($que1);die();
		if(!empty($que1))
		{
			return $que1;
		}
		else
		{
			return false;
		}	
	}

	public function pres_image()
	{
		$this->db->select('*');
		$this->db->from('prescription_images');
		$this->db->order_by('prescription_id','desc');
		return $this->db->get()->result();

	}



	public function prescriptionimage1($id)
	{				
		$this->db->select('prescription.pharmacist_id,prescription.user_id,prescription.id,prescription.insurance_image,prescription_scan,prescription.time_stamp,registration.first_name,last_name,email,user_pharmacy.pharmacy_name');
		$this->db->from('prescription');
		$this->db->join('registration', 'prescription.user_id = registration.id');
		$this->db->join('user_pharmacy','prescription.pharmacy_id = user_pharmacy.id');
		$this->db->where('prescription.pharmacist_id='.$id);
		$this->db->order_by('prescription.id','desc');
		$que1 = $this->db->get()->result();
		$new=array_merge($que1);
		//print_r($new);die();
		//if($new!='')
		if(!empty($que1))
		{
			return $que1;
		}
		else
		{
			return false;
		}
	}

	// -------------------------------------------------------------------------------------------------------------
	
	public function pres_image1($id)
	{
		//print_r($id);die();
		$this->db->select('*');
		$this->db->from('prescription_images');
		$this->db->order_by('prescription_id','desc');
		$this->db->where('pharmacist_id='.$id);
		return $this->db->get()->result();
	}
// -------------------------------------------------------------------------------------------------------------
	public function pharmasistname()
	{
		$this->db->select('id,name');
		$this->db->order_by("id","DESC");
		$this->db->from('pharmasist');		
		return $this->db->get()->result();
	}	

	// -------------------------------------------------------------------------------------------------------------

	

	public function renew_prescription()
	{
		$this->db->order_by('renew_timestamp');		
		$this->db->group_by('medicine_name');
		$this->db->select('prescription_medicine.*,user_pharmacy.pharmacy_name,prescription.pharmacy_id');
		$this->db->from('prescription_medicine');
		$this->db->join('prescription','prescription.id=prescription_medicine.prescription_id');
		$this->db->join('user_pharmacy','prescription.pharmacy_id = user_pharmacy.id');
		$this->db->where('prescription_medicine.pres_status',1);
		$query = $this->db->get();
		if($query->num_rows()>0)
		{
			return $query;
		}
		else
		{
			return false;
		}
	}


	// -------------------------------------------------------------------------------------------------------------

	public function renew_prescription1($id)
	{
		$this->db->order_by('renew_timestamp');		
		$this->db->group_by('medicine_name');
		$query=$this->db->get_where('prescription_medicine',array('pres_status'=>'1','pharmacist_id'=>$id));
		if($query->num_rows()>0)
		{
			return $query;
		}
		else
		{
			return false;
		}
	}

// -------------------------------------------------------------------------------------------------------------

	/*public function usercount()
	{
		$q=$this->db->get_where("registration",array('seen_status'=>0));
		print_r($q->num_rows());			
	}

	public function prescriptioncount()
	{
		$q=$this->db->get_where("prescription",array('seen_status'=>0));
		return $q->num_rows();			
	}

	public function updatecount($tablename)
	{
		$this->db->update($tablename,array('seen_status'=>2));
	}*/

	public function add_prescription($data)
	{
		//$result=$this->db->insert_batch('prescription_medicine', $data); 
		$result=$this->db->insert('prescription_medicine', $data); 
		if($result)
		{
			$medicine_id = $this->db->insert_id();
			return $medicine_id;
		}
		else
		{
			return false;
		}

	}

	public function add_time($medicine_id,$prescription_id,$time,$endDate)
    {
        $data = array();
        //Date between two dates
        $begin_date = date('d-m-Y'); 
        $begin      = new DateTime($begin_date);
        $end        = new DateTime($endDate);
        $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
        foreach($daterange as $dosedate)
        {
            $dose_date=$dosedate->format("d-m-Y");
            foreach($time as $times)
            {
                $data[] = array(
                "medicine_id"       => $medicine_id,
                "prescription_id"   => $prescription_id,
                "time"              => $times,
                "dose_date"         => $dose_date
                 );
            }
        }
        if(!empty($data))
       	{
       		$this->db->insert_batch('prescription_medicine_time', $data); 
   		}
    }

    public function add_renewtime($medicine_id,$prescription_id,$time,$begin_date,$endDate)
    {
        $data = array();
        //Date between two dates
        $begin      = new DateTime($begin_date);
        $end        = new DateTime($endDate);
        $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
        foreach($daterange as $dosedate)
        {
            $dose_date=$dosedate->format("d-m-Y");
            foreach($time as $times)
            {
                $data[] = array(
                "medicine_id"       => $medicine_id,
                "prescription_id"   => $prescription_id,
                "time"              => $times,
                "dose_date"         => $dose_date
                 );
            }
        }
        if(!empty($data))
       	{
       		$this->db->insert_batch('prescription_medicine_time', $data); 
   		}
    }

	
// -------------------------------------------------------------------------------------------------------------

    public function update_time($timedata,$pres_id,$med_id)
	{
		//print_r(count($timedata['time']));die();
		//When prescription days decrease
		if($timedata['newdays']<$timedata['olddays'])
		{
			$begin      = new DateTime($timedata['previousEndDate']);
	        $end        = new DateTime($timedata['endDate']);
	        $daterange  = new DatePeriod($end, new DateInterval('P1D'), $begin);
	        foreach($daterange as $dosedate)
	        {
	            $dose_date=$dosedate->format("d-m-Y");
	            $timecount = count($timedata['time']);
	            for($t=0; $t<$timecount; $t++)
	            {
	                 $this->db->where(array('dose_date' =>$dose_date,'medicine_id'=>$med_id,'prescription_id'=>$pres_id));
	                 $this->db->delete('prescription_medicine_time');
	            } 
	        }
	    }

	    //When prescription days increase

		if($timedata['newdays']>$timedata['olddays'])
		{
			//echo "New Add";
	        $begin      = new DateTime($timedata['previousEndDate']);
	        $end        = new DateTime($timedata['endDate']);
	        $daterange  = new DatePeriod($begin, new DateInterval('P1D'), $end);
	        foreach($daterange as $dosedate)
	        {
	            $dose_date=$dosedate->format("d-m-Y");
	            $timecount = count($timedata['time']);
	            for($t=0; $t<$timecount; $t++)
	            {
	            	$data[] = array(
	                "medicine_id"       => $med_id,
	                "prescription_id"   => $pres_id,
	                "time"              => $timedata['time'][$t],
	                "dose_date"         => $dose_date,
	                "status"			=>'not'
	                 );
	            } 
	        }
         	//echo "<pre>";
            //print_r($data);die();
	        if(!empty($data))
	       	{
	       		if($this->db->insert_batch('prescription_medicine_time', $data))
	       		{
	       			$this->db->where(array('medicine_id'=>$med_id,'prescription_id'=>$pres_id));
					$times= $this->db->get_where('prescription_medicine_time')->result();
					$NoTimes = count($times);
					$t=0;
					foreach ($times as $t1)
					{
						$timecount = count($timedata['time']);
						$timec =$timecount-1;
						$data1[] = array(
			                "id"    => $t1->id,
			                "time" 	=> $timedata['time'][$t],
			                );
			            if($timec==$t)
			            {$t=0;}
			            else
			            {$t++;}
					}
					//echo "<pre>";
					//print_r($data1);
					$this->db->update_batch('prescription_medicine_time', $data1, 'id');
	       		} 	
	   		}
		}

		 //When prescription days same
		
		if($timedata['olddays']==$timedata['newdays'])
		{	
			//echo "Same days";
			$this->db->where(array('medicine_id'=>$med_id,'prescription_id'=>$pres_id));
			$times= $this->db->get_where('prescription_medicine_time')->result();
			$NoTimes = count($times);
			$begin_date = date('d-m-Y'); 
	        $begin      = new DateTime($timedata['startDate']);
	        $end        = new DateTime($timedata['endDate']);
	        $daterange  = new DatePeriod($begin, new DateInterval('P1D'), $end);
	        foreach($daterange as $dosedate)
	        {
	        	$dose_date=$dosedate->format("d-m-Y");
				foreach ($timedata['time'] as $t) 
				{
					$datat[]= array(
						"time"=>$t,
						"dose_date"=> $dose_date
					);
				}
			}
			foreach ($times as $t)
			{
				$dd[]=array(
					'id'=>$t->id,
					);
			}

			for($i=0; $i<$NoTimes; $i++)
			{
				$this->db->set('time',$datat[$i]['time']);
				$this->db->where('id',$dd[$i]['id']);
				$this->db->update('prescription_medicine_time');	
			}
		}
	}

	public function update_presctiption($data,$timedata,$pres_id,$med_id)
	{
		$this->db->where('id',$med_id);		
		$re=$this->db->update('prescription_medicine',$data);
		if($re)
		{
			$this->update_time($timedata,$pres_id,$med_id);
			return true;
		}
		else
		{
			return false;
		}

	}

	public function Add_renew_presctiption($data,$pres_id,$med_id)
	{
		$this->db->where('id',$med_id);		
		$re=$this->db->update('prescription_medicine',$data);
		if($re)
		{
			return true;
		}
		else
		{
			return false;
		}

	}

	public function delete_prescription($med_id)
	{
	  $d= $this->db->delete('prescription_medicine',array('id'=>$med_id));
	  if($d)
	  {
	  	$this->db->delete('prescription_medicine_time',array('medicine_id'=>$med_id));
	  	return true;
	  }
	  else
	  {
	  	return false;
	  }
	}


	public function prescription_list($p_id)
	{
		//$this->db->group_by('medicine_name');
		$query=$this->db->get_where('prescription_medicine',array('prescription_id'=>$p_id));
		if($query->num_rows()>0)
		{
			return $query;
		}
		else
		{
			return false;
		}
	}

	public function prescription_record($medicine_id,$pres_id)
	{
		//$this->db->group_by('medicine_name');
		$query=$this->db->get_where('prescription_medicine',array('prescription_id'=>$pres_id,'id'=>$medicine_id));
		return $query->row();
	}
	public function prescription_time($medicine_id,$pres_id)
	{
		$this->db->select('id,time,dose_date');
		$this->db->from('prescription_medicine_time');
		$this->db->where('prescription_id',$pres_id);
		$this->db->group_by('time');
		$time=$this->db->where('medicine_id',$medicine_id)->get();
		//$time=$this->db->where('medicine_name',$med_name)->get();
		return $time->result();
	}
	
	public function medicine($p_id)
	{
		$this->db->order_by("tablet_name", "asc");
		$rr=$this->db->get_where('tablet',array('pharmacist_id'=>$p_id));
		$count=$rr->num_rows();
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
		$this->db->from('prescription_medicine');
		$res=$this->db->get();
		return $res->result(); 
	}


    public function assigned($ph_id,$pres_id)
    {
    	$this->db->where('id',$pres_id);
		$rr=$this->db->update('prescription',array('pharmacist_id'=>$ph_id));
		if($rr)
		{
			$this->db->where('prescription_id',$pres_id);
			$rr=$this->db->update('prescription_images',array('pharmacist_id'=>$ph_id));
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
		$query=$this->db->get_where('prescription_medicine',array('pharmacist_id'=>$p_id));
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