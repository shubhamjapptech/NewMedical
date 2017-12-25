<?php

class Prescriptions_model extends CI_Model {
	function __construct() 
	{
        parent::__construct();
        $this->load->database();
    }

    public function prescription($token,$user_id,$pharmacy_id,$nn,$bcode)
    {
    	$prData = array(
    		"user_id"=>$user_id,
    		"pharmacy_id"=>$pharmacy_id,
    		"insurance_image"=>$nn,
    		"prescription_scan"=>$bcode
    		);

    	if($this->db->insert('prescription',$prData))
    	{
    		return  $this->db->insert_id();
    	}
    	else
        {
            return false;
            exit;
        }       
    }

    public function prescriptionimage($id,$image)
    {
        if($this->db->insert('prescription_images',array('prescription_id'=>$id,'image'=>$image)))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function notTakenMedicine($user_id,$doseDate)
    {
        $query = $this->db->query("SELECT `prescription_medicine`.*,`prescription_medicine`.`id` AS med_Id, `pharmasist`.`name`,`p1`.id,`p1`.`status`,`time`,`time_type`,`dose_date` FROM `prescription_medicine` LEFT JOIN pharmasist ON prescription_medicine.pharmacist_id = pharmasist.id LEFT JOIN prescription_medicine_time AS p1 ON prescription_medicine.id= p1.medicine_id  WHERE `user_id`='$user_id' && `remain_medicine`!=0 && `p1`.`status`='not' && `dose_date`='$doseDate' order by `time` ASC");
        if($query->num_rows()>0)
        {   
            //echo json_encode($query->result_array()); die();
            return $query->result_array(); 
        }
        else
        {
           return false;
        }
    }

    /*--------------------------------------Tablet for home page Start------------------------------*/    
    public function takenMedicine($user_id,$doseDate)
    {
        $query1 = $this->db->query("SELECT `prescription_medicine`.*,`prescription_medicine`.`id` AS med_Id, `pharmasist`.`name`,`p1`.id,`p1`.`status`,`time`,`time_type`,`dose_date` FROM `prescription_medicine` LEFT JOIN pharmasist ON prescription_medicine.pharmacist_id = pharmasist.id LEFT JOIN prescription_medicine_time AS p1 ON prescription_medicine.id= p1.medicine_id  WHERE `user_id`='$user_id' && `remain_medicine`!=0 && `p1`.`status`='taken' && `dose_date`='$doseDate' order by `time` ASC");
        if($query1->num_rows()>0)
        {   
            //echo json_encode($query->result_array()); die();
            return $query1->result_array(); 
        }
        else
        {
            //echo json_encode($query1->result_array());die();
            return false;
        }
    }
    /*--------------------------------------Tablet for home page End------------------------------*/

    /*--------------------------------------Tablet Details Start ---------------------------------*/
    public function tabletDetail($pres_id,$md_name)
    {
        $tabletquery1 = $this->db->query("SELECT `p1`.*,`p2`.`name`, `phone`, `p2`.`address`,`lat`,`long`,`p3`.status FROM `prescription_medicine` AS p1 JOIN pharmasist AS p2 ON p1.pharmacist_id = p2.id LEFT JOIN prescription_medicine_time AS p3 ON p1.id= p3.medicine_id WHERE p1.medicine_name= '$md_name' && p1.prescription_id='$pres_id'");
        if($tabletquery1->num_rows()>0)
        { 
            //print_r($this->db->last_query());die();
            //echo json_encode($tabletquery1->row_array());die();
            return $tabletquery1->row_array(); 
        } 
        else
        {
            return false;
        } 
    }

    /*--------------------------------------Tablet Details End ---------------------------------*/

    public function medicine_detail($medicine_id)
    {
        return $this->db->get_where('prescription_medicine',array('id'=>$medicine_id))->row_array();
    }

    public function updateTabResponse($status,$remMed,$time_id,$medicine_id)
    {
       if($this->db->update('prescription_medicine_time', array('status'=>$status), array('id' => $time_id)))
       {
            $this->db->update('prescription_medicine', array('remain_medicine'=>$remMed), array('id' => $medicine_id));
            return true;
       }
       else
       {
            return false;
       }
    }

    /*--------------------------------------Tablet Response End ---------------------------------*/
    public function refillListAtNotificationTab($user_id)
    {
        $refillTab = $this->db->query("SELECT `prescription_medicine`.*, `p1`.id As time_id,`p1`.`status`,`time`,`dose_date`, `pharmasist`.`name` FROM `prescription_medicine`LEFT JOIN prescription_medicine_time AS p1 ON prescription_medicine.id= p1.medicine_id LEFT JOIN pharmasist ON prescription_medicine.pharmacist_id = pharmasist.id WHERE `prescription_medicine`.`user_id`='$user_id' && `remain_medicine`!=0 group by `prescription_medicine`.`id`");
        //print_r($this->db->last_query());
        if($refillTab->num_rows()>0)
        { 
            return $refillTab->result_array(); 
        } 
        else
        {
            return false;
        } 
    }
    /*--------------------------------------Tablet NotificationTab End ---------------------------------*/
    /*public function setNotification($query,$medicine_id)
    {
        $set = $this->db->query("INSERT INTO `notification` (`medicine_id`, `user_id`, `prescription_id`, `notification_type`, `frequency`, `notification_date`, `time`, `time_type`, `notification_status`,`repeatType`,`notification_endDate`) VALUES $query");
        if($set)
        {
            $this->db->update('prescription_medicine', array('notification_status'=>1), array('id' => $medicine_id));
            return true;
        }
        else
        {
            return false;
        }
    }*/

    public function UpdateNotificationSwitch($medicine_id,$notificationSwitch)
    {
        $this->db->where(array('medicine_id'=>$medicine_id,'notification_status'=>0));
        return $this->db->update('notification',array('notification_switch'=>1));
    }


    public function setNotification($query,$medicine_id,$notificaton_status)
    {
        $check = $this->db->get_where('notification',array('medicine_id'=>$medicine_id,'notification_status'=>$notificaton_status));
        if($check->num_rows()>0)           //if notification setting exist,Delete then update
        {
            if($this->db->delete('notification',array('medicine_id'=>$medicine_id,'notification_status'=>$notificaton_status)))
            {
                return $this->db->query("INSERT INTO `notification` (`medicine_id`, `user_id`, `prescription_id`, `notification_type`, `frequency`, `notification_date`, `time`, `time_type`, `notification_status`,`repeatType`,`notification_endDate`,`notification_switch`,`messageType`) VALUES $query");
            }
            else
            {
                $response["error"]   = 4;
                $response["success"] = 0;
                $response["message"] = "Opps! Something went wrong. Please try again";
                echo json_encode($response);
            }
        }
        else
        {
            $set = $this->db->query("INSERT INTO `notification` (`medicine_id`, `user_id`, `prescription_id`, `notification_type`, `frequency`, `notification_date`, `time`, `time_type`, `notification_status`,`repeatType`,`notification_endDate`,`notification_switch`,`messageType`) VALUES $query");
            if($set)
            {
                $this->db->update('prescription_medicine', array('notification_status'=>1), array('id' => $medicine_id));
                return true;
            }
            else
            {
                return false;
            }
        }   
    }

    public function updateMedicineTime($medicine_id,$time,$type)
    {
        $pdetail = $this->medicineTime($medicine_id);
        $medtimes = count($pdetail);
        for($i=0; $i<$medtimes; $i++)
        {
            $ptime = $pdetail[$i]['time'];
            $ptype = $pdetail[$i]['time_type'];

            $this->db->where(array('medicine_id'=>$medicine_id,'time'=>$ptime,'time_type'=>$ptype));
            $r= $this->db->update('prescription_medicine_time',array('time'=>$time[$i],'time_type'=>$type[$i]));
    
        }
    }

    /*---------------------------Tablet NotificationSetting End --------------------*/

    public function renew_request($pres_id,$medicine_id,$refill_remains)
    {
        $reup=$this->db->query("UPDATE prescription_medicine SET pres_status=1,refill_remain='$refill_remains', renew_timestamp=NOW() WHERE prescription_id = '$pres_id' AND id='$medicine_id'");   
        if($this->db->affected_rows()>0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /*------------------------------renew_request End ----------------------------------------*/

    public function medicineTime($medicine_id)
    {
        $this->db->group_by('time');
        $this->db->group_by('time_type');
        $timedata = $this->db->get_where('prescription_medicine_time',array('medicine_id'=>$medicine_id))->result_array();
        if(!empty($timedata))
        {
            foreach($timedata as $tdata => $v)
            {
                $x = count($timedata[$tdata]);
                $timedata[$tdata]['Timestring'] =strtotime($v['time'].' '.$v['time_type']);
                $Timestring[$tdata]=strtotime($v['time'].' '.$v['time_type']);
                //echo strtotime($v->time.' '.$v->time_type);
            } 
            array_multisort($Timestring, SORT_ASC, $timedata);    
        }        
        return $timedata;
    }

    public function getnotificationsetting($medicine_id)
    {
        $data = $this->db->get_where('notification',array('medicine_id'=>$medicine_id))->result_array();
        if(!empty($data))
        {
            foreach($data as $d => $dv)
            {
                $x = count($data[$d]);
                $data[$d]['Timestring'] =strtotime($dv['time'].' '.$dv['time_type']);
                $Timestring[$d]=strtotime($dv['time'].' '.$dv['time_type']);
                //echo strtotime($v->time.' '.$v->time_type);
            } 
            array_multisort($Timestring, SORT_ASC, $data);    
        }
        return $data;exit;
    }


}

?>