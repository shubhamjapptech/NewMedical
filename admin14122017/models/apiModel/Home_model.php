<?php

class Home_model extends CI_Model {
	function __construct() 
	{
        parent::__construct();
        $this->load->database();
    }

    public function loginViaFb($fb_id,$email,$user_type,$devicetoken)
    {
    	$resfb = $this->db->get_where('registration',array('fb_id'=>$fb_id))->row();
    	if(!empty($resfb))
    	{
    		return $resfb;
    	}
    	else
    	{
    		$respons["success"]=0;
            $respons["error"] = 1;
            $respons["error_msg"] = "User does not exist";
            echo json_encode($respons);
            exit();
    	}        
    }

    public function updatetokenViaFb($devicetoken,$fb_id)
    {
    	$this->db->where(array('fb_id'=>$fb_id));
    	$this->db->update('registration',array('device_token'=>$devicetoken));
        //mysql_query("UPDATE `registration` SET `devicetoken`='$devicetoken' where `fb_id`='$fb_id'");
    }

    public function updatetoken($devicetoken,$email)
    {
    	$this->db->where(array('email'=>$email));
    	$this->db->update('registration',array('device_token'=>$devicetoken));
    }

    public function getUserByEmailAndPassword($email, $password) 
    {        
    	$getData = $this->db->get_where('registration',array('email'=>$email,'password'=>$password))->row();
    	if(!empty($getData))
    	{
    		return $getData;
    	}
    	else
    	{
    		return false;
    	}
    }

    public function admin_data()
    {
    	return $this->db->get_where('admin',array('id'=>1))->row();
    }

    public function prescription_count($user_id)
    {
        return $this->db->get_where('prescription_medicine',array('user_id'=>$user_id))->num_rows();
    }

    public function pharmacy_details($userid)
    {
    	return $this->db->get_where('user_pharmacy',array('user_id'=>$userid))->row();
    }

    /*------------------Login Functionality End-------------------------------------*/

    public function isUserExisted($email) 
    {
        $existUser = $this->db->get_where('registration',array('email'=>$email))->num_rows();
        if ($existUser > 0) // user existed 
        {            
            return true;
        } 
        else
        {
            return false;       // user not existed
        }
    }

    public function radomno()
    {
        $length=12;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $uuid = '';
        for ($i = 0; $i < $length; $i++)
        {
            $uuid .= $characters[rand(0, $charactersLength - 1)];
        }
        return $uuid;
   }

   public function storeUser($devicetoken,$fb_id,$user_type,$fname,$lname,$mobile,$email,$password,$enpass,$ss,$image_type) 
    {
        $uuid =$this->radomno();
        $data = array(
          "uniq_id"=>$uuid,
          "device_token"=>$devicetoken,
          "fb_id"=>$fb_id,
          "user_type"=>$user_type,
          "first_name"=>$fname,
          "last_name"=>$lname,
          "phone"=>$mobile,
          "email"=>$email,
          "password"=>$enpass,
          "upass"=>$password,
          "qbpass"=>$password,
          "image"=>$ss,
          "image_type"=>$image_type,
          );
        if($this->db->insert('registration',$data))
        {
           $insertedId = $this->db->insert_id();
           $user_data  = $this->user_record($insertedId);
           return $user_data;
        }    
        else
        {
            return false;
        }
    }

    public function user_record($user_id)
    {
       return $this->db->get_where('registration',array('id'=>$user_id))->row();
    }

    public function user_details($user_id)
    {
       return $this->db->get_where('registration',array('id'=>$user_id))->row_array();
    }

    public function StoreUserPharmacy($userid,$pharmacy_name,$city,$cross_street,$contactNo)
    {
        $pharmacyData = array(
                    "user_id"=>$userid,
                    "pharmacy_name"=>$pharmacy_name,
                    "city"=>$city,
                    "cross_street"=>$cross_street,
                    "contactNo"=>$contactNo,
                    );

        if($this->db->insert('user_pharmacy',$pharmacyData))
        {
            $pharmacy='';
            $pharmacyId = $this->db->insert_id();
            if($pharmacy = $this->db->get_where('user_pharmacy',array('id'=>$pharmacyId))->row())
            {
                return $pharmacy;
            }
            else
            {
                return $pharmacy;
            }
        }    
        else
        {
            return false;
        }
    }

    public function update_qbId($userid,$qb_id)
    {
        $this->db->where(array('id'=>$userid));
        $this->db->update('registration',array('qb_id'=>$qb_id));
    }

    /*--------------------------Singup end -------------------------------*/

    public function checkuser($token)
    {
        $existUser = $this->db->get_where('registration',array('uniq_id'=>$token))->num_rows();
        if ($existUser > 0) {
            // user existed 
            return true;
        } else {
            // user not existed
            return false;
        }
    } 

    public function userData($token)  //For update Profile
    {
       return $this->db->get_where('registration',array('uniq_id'=>$token))->row();
    }

    public function updateUser($token,$Updatedata)
    {
        $this->db->where('uniq_id',$token);
        if($this->db->update('registration',$Updatedata))
        {
            return $this->userData($token);
        }
        else
        {
            return false;
        }

    }

    public function pharmacy_list()
    {
        return $this->db->get_where('pharmacy')->result();
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
            $this->email->subject('Forget password');
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

  






          











    


}
