<?php
if(isset($_POST['time_id']) && $_POST['time_id']!='' && isset($_POST['medicine_id'])&& $_POST['medicine_id']!='')
{
	require_once 'include/Md_Functions.php';
	$db = new Md_Functions();
	$response = array("success" => 0, "error" => 0);
	$time_id			= $_POST['time_id'];
	$medicine_id 		= $_POST['medicine_id'];   //patent tablet id
	$prescription_id	= $_POST['prescription_id'];
	$medicine_name		= $_POST['medicine_name'];
	$check_type         = $_POST['check_type']; //0=uncheck 1=checked
	// $s="SELECT * FROM prescription_medicine where `prescription_id`='$prescription_id' && `medicine_name`='$medicine_name'";
	$s = "SELECT * FROM prescription_medicine where `id`='$medicine_id'";	
	$q = mysql_query($s);
	$as= mysql_fetch_assoc($q);

	$ss = "SELECT * FROM prescription_medicine_time where `id`='$time_id'";	
	$qq = mysql_query($ss);
	$ass= mysql_fetch_assoc($qq);

	$total_medicine = $as['total_medicine'];
	$remain =  $as['remain_medicine'];
	$take   =  $as['dailyDose'];
	if($check_type==1)
	{
		$status =  "taken";	
		$rem    =  $remain - $take;	
	}
	if($check_type==0)
	{
		$status =  "not";	
	    $rem    =  $remain + $take;
	}	
	if($total_medicine>=$rem && $rem>=0)
	{
		$up  =	"UPDATE prescription_medicine_time SET status='$status' WHERE `id`='$time_id'";
		//print_r($up);
		$up1  = "UPDATE prescription_medicine SET remain_medicine='$rem' WHERE `id`='$medicine_id'";
		// $up2 = "UPDATE prescription_medicine SET remain_medicine='$rem' WHERE `prescription_id`='$prescription_id' && `medicine_name`='$medicine_name'";
		$q  = mysql_query($up);
		$q1 = mysql_query($up1);
		if($q && $q1)
		{
			$response["success"] = 1;
			$response["error"]   = 0;
			$response["message"] = "success";
			echo json_encode($response);
		}
		else
		{
			$response["success"] = 0;
			$response["error"]   = 1;
			$response["message"] = "Error occur";
			echo json_encode($response);
		}
	}
	else
	{
		$response["success"] = 0;
		$response["error"]   = 2;
		$response["message"] = "Something wrong";
		echo json_encode($response);
	}
	
}
else
{
	$response["error"]		= 1;
	$response["success"]	= 0;
	$response["message"]	= "All field are required";
	echo json_encode($response);
}

?>