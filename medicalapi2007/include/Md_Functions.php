<?php

class Md_Functions {

    private $db;

    //put your code here
    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        require_once 'config.php';
        // connecting to database
        $this->db = new DB_Connect();
        $this->db->connect();
    }

    // destructor
    function __destruct() {
        
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
        $length=12;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $uuid = '';
        for ($i = 0; $i < $length; $i++)
        {
            $uuid .= $characters[rand(0, $charactersLength - 1)];
        }

		$in ="INSERT INTO registration (`uniq_id`,`device_token`,`fb_id`,`user_type`,`first_name`, `last_name`,`phone`, `email`, `password`,`upass`,`qbpass`,`image`,`image_type`) VALUES('$uuid','$devicetoken','$fb_id','$user_type','$fname','$lname','$mobile','$email', '$enpass','$password','$password','$ss','$image_type')";
        $result=mysql_query($in);
        
        if ($result)
        {
            $insertedId=mysql_insert_id();
            $result = mysql_query("SELECT * FROM registration WHERE id = \"$insertedId\"");
            return mysql_fetch_array($result);
        }
        else
        {
            return false;
        } 
    }

    public function StoreUserPharmacy($userid,$pharmacy_name,$city,$cross_street,$contactNo)
    {
        $pharmacy_detail='';
        $query ="INSERT INTO user_pharmacy(`user_id`, `pharmacy_name`, `city`, `cross_street`,`contactNo`) VALUES ('$userid','$pharmacy_name','$city','$cross_street','$contactNo')";
        // print_r($query);
        $q = mysql_query($query);
        if($q)
        {
            $result = mysql_query("SELECT * FROM user_pharmacy WHERE user_id = \"$userid\"");
            $response=mysql_fetch_assoc($result);
            return $response;
        }
        else
        {
            return $pharmacy_detail;
        }
    }

    public function userDetails($userid)
    {        
        $result  = mysql_query("SELECT * FROM registration WHERE id = \"$userid\"");
        $details = mysql_fetch_assoc($result);
        return $details;
    }

    public function pharmacy_detail($userid)
    {        
        $result = mysql_query("SELECT * FROM user_pharmacy WHERE user_id = \"$userid\"");
        $response=mysql_fetch_assoc($result);
        return $response;
    }


    public function admin_data()
    {
        $s=mysql_query("SELECT * FROM admin WHERE id=1");
        return mysql_fetch_assoc($s);
    }

    public function update_qbId($userid,$qb_id)
    {
        $up =mysql_query("UPDATE `registration` SET `qb_id`=$qb_id WHERE `id`='".$userid."'");
    }

    public function checkuser($token,$enpass)
    {
       $result = mysql_query("SELECT * from registration WHERE uniq_id = '$token' && password='$enpass'");
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            // user existed 
            return true;
        } else {
            // user not existed
            return false;
        }
    }

    public function prescription_count($user_id)
    {
        $id=$user_id;
        $pres_count =mysql_num_rows(mysql_query("SELECT * FROM prescription_medicine WHERE user_id =\"$id\""));
        return $pres_count;
    }

    public function change_password($token,$new_p,$qbpass)
    {
        $up="UPDATE registration SET `password`='$new_p', `upass`='$qbpass', `qbpass`='$qbpass',`updateAt`=NOW() WHERE uniq_id='$token'";
        //print_r($up);
        $q=mysql_query($up);
        if($q)
        {

            $result = mysql_query("SELECT * FROM registration WHERE uniq_id = \"$token\"");
            return mysql_fetch_assoc($result);
        }
        else
        {
            return false;
        }
    }

    public function updatetoken($devicetoken,$email)
    {
        //print_r($devicetoken);die();
        $qq =  mysql_query("UPDATE `registration` SET `device_token`='$devicetoken' where `email`='$email'");
    }

    public function updatetokenViaFb($devicetoken,$fb_id)
    {
        mysql_query("UPDATE `registration` SET `devicetoken`='$devicetoken' where `fb_id`='$fb_id'");
    }
    

    public function ispharmaciesExisted($zipcode)
    {
        $result = mysql_query("SELECT * from `pharmacy` WHERE zipcode = '$zipcode'");
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0)
        {
            return false;
        } 
        else
        {
            return true;
        }
    }


    public function isUserExisted($email) {
        $result = mysql_query("SELECT email from registration WHERE email = '$email'");
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            // user existed 
            return true;
        } else {
            // user not existed
            return false;
        }
    }

    /**
     * Get user by email and password
     */
    public function getUserByEmailAndPassword($email, $password) {        
        $result = mysql_query("SELECT * FROM registration WHERE email = '$email' AND password='$password'") or die(mysql_error());
        // check for result 
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
          $result = mysql_fetch_array($result);
           return $result;
            }
        else {
            // user not found
            return false;
        }
    }

    public function pharmacy_details($userid)
    {
        $result = mysql_query("SELECT * FROM user_pharmacy WHERE user_id = \"$userid\"");
        $pha=mysql_fetch_assoc($result);
        //print_r($pha);
        return $pha;
    }

    /*public function loginViaFb($fb_id,$email,$user_type,$devicetoken)
    {
        $result = mysql_query("SELECT * FROM registration WHERE fb_id = '$fb_id'") or die(mysql_error());
        $userExist = mysql_num_rows($result);
        //print_r($userExist);die();
        if ($userExist > 0)
        {
            $result = mysql_fetch_array($result);
            return $result;
        }
        else
        {
            $length=12;
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $uuid = '';
            for ($i = 0; $i < $length; $i++)
            {
                $uuid .= $characters[rand(0, $charactersLength - 1)];
            }
            $in ="INSERT INTO registration (`uniq_id`,`device_token`,`fb_id`,`user_type`,`email`) VALUES('$uuid','$devicetoken','$fb_id','$user_type','$email')";
            $result=mysql_query($in);
            if ($result)
            {
                $insertedId=mysql_insert_id();
                $result = mysql_query("SELECT * FROM registration WHERE id = \"$insertedId\"");
                return mysql_fetch_array($result);
            } 
            else 
            {
                return false;
            } 
        }
    }*/

    public function loginViaFb($fb_id,$email,$user_type,$devicetoken)
    {
        $result = mysql_query("SELECT * FROM registration WHERE fb_id = '$fb_id'") or die(mysql_error());
        $userExist = mysql_num_rows($result);
        //print_r($userExist);die();
        if ($userExist > 0)
        {
            $result = mysql_fetch_array($result);
            return $result;
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

    public function prescription($token,$user_id,$pharmacy_id,$nn,$bcode)
    {
        $in = "INSERT INTO  prescription (user_id, pharmacy_id, insurance_image, prescription_scan) VALUES ('$user_id','$pharmacy_id','$nn','$bcode')";
        $q  = mysql_query($in);
        if($q)
        {
            $insertedId=mysql_insert_id();
            return $insertedId;
            exit;

        }
        else
        {
            return false;
            exit;
        }
    }
        

    public function prescriptionimage($id,$key)
    {
        $in="INSERT into `prescription_images` (`prescription_id`, `image`) VALUES ('$id','$key')";
        $q= mysql_query($in);
        if($q)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function forgetpassword($email)
     {
        //echo $email;
        $check=mysql_query("select * from registration where email='".$email."' ") or die(mysql_error());
        $count=mysql_num_rows($check);
        if($count>0)
        {
             $to=$email;
             $subject='Forget password';
             $message='Hello '.$name.",\n";
             $message.='We have received a request to reset password. If you did not request,just ignore this email.Otherwise,You can reset your password using this link:'."\n";
             $message.="http://app.repillrx.com/NewMedical/medical/index.php/admin/recover_userpassword?email=$to"; 
             $headers='From:app.repillrx.com';
             $m=mail($to,$subject,$message,$headers);
                  if($m)
                  {
                    return true;
                  }
                else
                 {
                    return false;   
                  }
                }
                else{
                    $row['error']=1;
                    $row['success']=0;
                    $row['message']="This email Id not found! Please enter correct email id";
                    echo json_encode($row);
                    exit;
            }
        }
            
        public function recovery($email,$n)
        {
            $q=mysql_query("SELECT * FROM registration WHERE email='".$email."'") or die(mysql_error());
            $count=mysql_num_rows($q);
            if($count>0)
            {
            $npass=md5($n);
            $in="UPDATE registration SET `password`='$npass' where email='".$email."'";
            $in1=mysql_query($in);
                if($in1)
                 {
                    return true;
                    
                }
                    else
                    {
                    return false;
                     }
                    }
                else{
                    $p["msg"]="Email id not found";
                    echo json_encode($p);
                }
            }
        }
    ?>
