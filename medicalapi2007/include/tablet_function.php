<?php

class tablet_Functions {

    private $db;

    //put your code here
    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $this->db = new DB_Connect();
        $this->db->connect();
    }

    // destructor
    function __destruct() {
        
    }
    public function pharmacy($pharmacy)
    {
        $s="SELECT id FROM pharmasist where name='$pharmacy'";
        $q=mysql_query($s);
        if(mysql_num_rows($q)>0)
        {
        $as=mysql_fetch_assoc($q);
        $id=$as['id'];
        return $id;
        }
        else
        {
            return false;
        }

}
        
    public function tabletDetail($id,$medication)
    {
    $s1="SELECT * from tablet WHERE pharmacist_id='$id' && tablet_name='$medication'";
        $q1=mysql_query($s1);
        if(mysql_num_rows($q1)>0)
        {
            $as1=mysql_fetch_assoc($q1);
            echo json_encode($as1);
        }
        else{
            $response["message"]="This pharmacy does not make that mediciation, Please Enter correct details";
            echo json_encode($response);
        }
    }

    public function check($f_id,$tablet_id)
         {
            $s="SELECT id FROM `family_member` WHERE id='$f_id'";
            $q=mysql_query($s);
            if(mysql_num_rows($q)>0)
                {
                    $p="SELECT id FROM `tablet` WHERE id='$tablet_id'";
                    $q1=mysql_query($p);
                   if(mysql_num_rows($q1)>0){
                       return true;
                       }
                   else{
                         $user["message"]="Medicine not found";
                         echo json_encode($user);
                      }
                }
         else
                 {
                   $user["message"]="Member not found! Please Enter valid Member Id";
                   echo json_encode($user);
                 }
    }
    public function add_prescription($f_id,$tablet_id,$time1,$time2,$time3,$quantity,$prescription,$status)
    {
        $in="INSERT INTO `patatent_tablet_status`(`fmamber_id`, `tablet_id`, `time1`, `time2`, `time3`, `quantity`, `prescription`, `status`, `prescription_stamp`) VALUES ('$f_id','$tablet_id','$time1','$time2','$time3','$quantity','$prescription','$status',NOW())";
        //echo $in;
        $q=mysql_query($in);
        if($q){
            return true;
        }
        else
        {
            return false;
        }
    }
    public function prescription_paperscript($token,$img,$member_id)
    {

        $result = mysql_query("SELECT * from registration WHERE uniq_id = '$token'");
        $count = mysql_num_rows($result);
        if($count>0)
        {
            $in = "INSERT INTO prescription (`member_id`,`prescription_image`) VALUES ('$member_id','$img')";
            $q  = mysql_query($in);
            if($q)
            {
                return true;
                exit;
            }
            else
            {
                return false;
                exit;
            }
        }
        else
        {
            $r["error"]= 1;
            $r["message"]="this token does not valid";
            echo json_encode($r);
            exit;
        }
     }

}
?>