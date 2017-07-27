<?php
class Admin_Functions {
    private $db;
    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $this->db = new DB_Connect();
        $this->db->connect();
        }
    function checkuser($token)
    {
    $result = mysql_query("SELECT * from registration WHERE uniq_id = '$token'");
     $no_of_rows = mysql_num_rows($result);
     if ($no_of_rows > 0) {
        return true;}
        else{
            return false;
        }
    }
    public function updatename($token,$first_name)
    {
       $check=$this->checkuser($token);     
       if($check!=false)
       {
       $update="UPDATE registration SET first_name='$first_name', updateAt=NOW() WHERE uniq_id = '$token'";
       $q=mysql_query($update);
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
      else{
        $r["error"]= 1;
        $r["message"]="Invalid token";
        echo json_encode($r);
        exit;
      }
    }

    public function updatelastname($token,$last_name)
    {
        $check=$this->checkuser($token);     
       if($check!=false)
       {
       $update="UPDATE registration SET last_name='$last_name', updateAt=NOW() WHERE uniq_id = '$token'";
       $q=mysql_query($update);
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
      else{
        $r["error"]= 1;
        $r["message"]="Invalid token";
        echo json_encode($r);
        exit;
      }
    }

    public function updatemobileNo($token,$mobile_no)
    {
        $check=$this->checkuser($token);     
       if($check!=false)
       {
       $update="UPDATE registration SET phone='$mobile_no', updateAt=NOW() WHERE uniq_id = '$token'";
       $q=mysql_query($update);
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
      else{
        $r["error"]= 1;
        $r["message"]="Invalid token";
        echo json_encode($r);
        exit;
      }
    }

    public function updateImage($token,$image)
    {
    $result = mysql_query("SELECT * from registration WHERE uniq_id = '$token'");
    $no = mysql_num_rows($result);     
       if($no>0)
       {
        $as=mysql_fetch_assoc($result);
        $img=$as['image'];
        if($image!='')
            {unlink($img);}
        $s  = $_FILES['image']['tmp_name'];
        $d  = "image/".$_FILES['image']['name'];
        $n  = "C:/xampp/htdocs/shubham/medical/image/".$_FILES['image']['name'];
        move_uploaded_file($s,$d);
        $update="UPDATE registration SET image='$n', updateAt=NOW()  WHERE uniq_id = '$token'";
        $q=mysql_query($update);
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
      else{
        $r["error"]= 1;
        $r["message"]="Invalid token";
        echo json_encode($r);
        exit;
      }
    }

    public function deleteUser($token)
    {
        $c=$this->checkuser($token);
        if($c!=false)
        {
            $d="DELETE FROM `registration` WHERE uniq_id = '$token'";
            //print_r($d);
            $q=mysql_query($d);
            if($q)
            {
                return true;
            }
            else{
                return false;
            }
        }
        else{
        $r["error"]= 1;
        $r["message"]="Invalid token";
        echo json_encode($r);
        exit;
      }
    }

    public function updateGender($token,$gender)
    {
       $check=$this->checkuser($token);     
       if($check!=false)
       {
       $update="UPDATE registration SET gender='$gender', updateAt=NOW() WHERE uniq_id = '$token'";
       $q=mysql_query($update);
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
      else{
        $r["error"]= 1;
        $r["message"]="Invalid token";
        echo json_encode($r);
        exit;
      }
    }
    public function updateAddress($token,$address)
    {
       $check=$this->checkuser($token);     
       if($check!=false)
       {
       $update="UPDATE registration SET address='$address', updateAt=NOW() WHERE uniq_id = '$token'";
       $q=mysql_query($update);
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
      else{
        $r["error"]= 1;
        $r["message"]="Invalid token";
        echo json_encode($r);
        exit;
      }
    }
}
?>
