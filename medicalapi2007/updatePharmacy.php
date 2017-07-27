<?php
if(isset($_POST['user_id']) && $_POST['user_id']!='')
{
	require_once 'include/admin.php';
	require_once 'include/Md_Functions.php';
	require_once 'include/config.php';
	$db = new Admin_Functions();
	$md = new Md_Functions();
	$response = array("success" => 0, "error" => 0);
	$user_id       = $_POST['user_id'];
	$pharmacy_name = $_POST['pharmacy_name'];
	$city 		   = $_POST['city'];
	$cross_street  = $_POST['cross_street'];
	$contactNo	   = $_POST['contactNo']; 	
	//print_r($_POST);die();
	$s="SELECT * FROM user_pharmacy WHERE user_id='$user_id'";
	//print_r($s);
	$q           = mysql_query($s);
	$exist 		 = mysql_num_rows($q);
	if($exist>0)
	{
		$update_at  = date('Y-m-d H:i:s');
		// $as          = mysql_fetch_assoc($q);
		$up = "UPDATE `user_pharmacy` SET `pharmacy_name`='$pharmacy_name',`city`='$city',`cross_street`='$cross_street',`contactNo`='$contactNo',`update_at`='$update_at' WHERE `user_id`='$user_id'";
		//echo $up;
		$upq = mysql_query($up);
		if($upq)
		{
			$result   = mysql_query("SELECT * FROM user_pharmacy WHERE user_id = \"$user_id\"");
        	$pharmacy_detail = mysql_fetch_assoc($result);	
        	$response['success']=2;
			$response['message']="Success";	
        	$response["user"]["pharmacy_detail"] =$pharmacy_detail;
        	// header('Content-Type: application/json');
        	echo json_encode($response);
    	}
    	else
    	{
    		$response['error']=2;
			$response['message']="error occur";	
        	$response["user"]["pharmacy_detail"] ='';
        	echo json_encode($response);
    	}
	}
	else
	{
		$query ="INSERT INTO user_pharmacy(`user_id`, `pharmacy_name`, `city`, `cross_street`,`contactNo`) VALUES ('$user_id','$pharmacy_name','$city','$cross_street','$contactNo')";
		$q = mysql_query($query);
		if($q)
		{
			$result   = mysql_query("SELECT * FROM user_pharmacy WHERE user_id = \"$user_id\"");
        	$pharmacy_detail = mysql_fetch_assoc($result);	
        	$response['success']=2;
			$response['message']="Success";	
        	$response["user"]["pharmacy_detail"] =$pharmacy_detail;
        	echo json_encode($response);
        }
        else
    	{
    		$response['error']=2;
			$response['message']="error occur";	
        	$response["user"]["pharmacy_detail"] ='';
        	echo json_encode($response);
    	}
	}
}
else
{
	$response['error']=3;
	$response['message']="Access Denied";
	echo json_encode($response);
}
?>