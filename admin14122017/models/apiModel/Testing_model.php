<?php

class Testing_model extends CI_Model {
	function __construct() 
	{
        parent::__construct();
        $this->load->database();
    }

    public function medicineTime($medicine_id)
    {
        $this->db->group_by('time');
        return $this->db->get_where('prescription_medicine_time',array('medicine_id'=>$medicine_id))->result();
    }

    public function getnotificationsetting($medicine_id)
    {
        return $this->db->get_where('notification',array('medicine_id'=>$medicine_id))->result();
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

    public function refillListAtNotificationTab($user_id)
    {
        $refillTab = $this->db->query("SELECT `prescription_medicine`.*, `p1`.id As time_id,`p1`.`status`,`time`,`dose_date`, `pharmasist`.`name` FROM `prescription_medicine`LEFT JOIN prescription_medicine_time AS p1 ON prescription_medicine.id= p1.medicine_id LEFT JOIN pharmasist ON prescription_medicine.pharmacist_id = pharmasist.id WHERE `prescription_medicine`.`user_id`='$user_id' && `remain_medicine`!=0 group by `prescription_medicine`.`id`");
        if($refillTab->num_rows()>0)
        { 
            return $refillTab->result_array(); 
        } 
        else
        {
            return false;
        } 
    }
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
                return $this->db->query("INSERT INTO `notification` (`medicine_id`, `user_id`, `prescription_id`, `notification_type`, `frequency`, `notification_date`, `time`, `time_type`, `notification_status`,`repeatType`,`notification_endDate`,`notification_switch`) VALUES $query");
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
            $set = $this->db->query("INSERT INTO `notification` (`medicine_id`, `user_id`, `prescription_id`, `notification_type`, `frequency`, `notification_date`, `time`, `time_type`, `notification_status`,`repeatType`,`notification_endDate`,`notification_switch`) VALUES $query");
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


    /*public function setNotification($query,$medicine_id)
    {
        $set = $this->db->query("INSERT INTO `notification` (`medicine_id`, `user_id`, `prescription_id`, `notification_type`, `frequency`, `notification_date`, `time`, `time_type`, `notification_status`,`repeatType`,`notification_endDate`,`notification_switch`) VALUES $query");
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

    public function updateUserPharmacy($user_id,$data)
    {
        $this->db->where('user_id',$user_id);
        if($this->db->update('user_pharmacy',$data))
        {
            return $this->db->get_where('user_pharmacy',array('user_id'=>$user_id))->row();
        }
        else
        {
            return false;
        }
    }

    public function mailconfig()
    {
        $config = array();
        $config['useragent']           = "CodeIgniter";
        $config['mailpath']            = "/usr/sbin/sendmail"; // or "/usr/sbin/sendmail 25"
        $config['protocol']            = "sendmail";
        $config['smtp_host']           = "localhost";
        $config['smtp_port']           = "25";
        $config['mailtype']            = 'mail';
        $config['charset']             = 'utf-8';
        $config['newline']             = "\r\n";
        $config['wordwrap']            = TRUE;
        return $config;
    }


    public function forget_password($email)
    {
        $check=$this->db->get_where('registration',array('email'=>$email));
        $count=$check->num_rows();      
        if($count>0)
        {
            $result = $check->row();
            $name   = $result->first_name.' '.$result->last_name;
            $to     = $email;;
            $mailcon = $this->mailconfig();
            $this->load->library('email');
            $this->email->initialize($mailcon);
            $message = 'Hello '.$name.",\n";
            $message .='We have received a request to reset password. If you did not request,just ignore this email.Otherwise,You can reset your password using this link:'."\n";
            $message .="http://54.149.226.127/medical/index.php/admin/recover_userpassword?email=$to";

            $this->email->from('info@repillrx.com', 'Repillrx');
            $this->email->to($to);
            $this->email->subject('forget password');
            $this->email->message($message);
            if($this->email->send())
            {
                //echo 'send';die();
                return true;
            } 
            else
            {
                //echo 'not send';die();
                return false;  
            }
        }
        else
        {
            $response['error']=1;
            $response['success']=0;
            $response['message']="This email Id is not found! Please enter correct email id";
            echo json_encode($response);
            exit;
        }
    }

    public function checkuserPassword($token,$enpass)
    {
        $exuser=$this->db->query("SELECT * from registration WHERE uniq_id = '$token' && password='$enpass'");   
        if($exuser->num_rows()>0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function change_password($token,$new_p,$qbpass)
    {
        $up=$this->db->query("UPDATE registration SET `password`='$new_p', `upass`='$qbpass', `qbpass`='$qbpass',`updateAt`=NOW() WHERE uniq_id='$token'");
        if($up)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function notification_setting($prescription_id,$refill_name,$notification_intervel,$notification_setting)
    {
     /*   $q =$this->db->query("UPDATE `patatent_tablets` SET `notification_intervel`='$notification_intervel', `notification_setting`='$notification_setting' WHERE `prescription_id`='$prescription_id' AND `medicine_name`='$refill_name'");
        //echo $q;
        if($q)
        {
            return true;
        }
        else
        {
            return false;
        }*/
    }

    

}

?>