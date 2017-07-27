<?php
if(isset($_POST['user_id']))
{
	require_once 'include/Md_Functions.php';
	require_once 'include/config.php';
	$db = new Md_Functions();
	$response = array("success" => 0, "error" => 0, "message"=>'');
	$user_id  = $_POST['user_id'];
	$doseDate = $_POST['doseDate'];
	$result=array();
	$blank='';
	$pres_status=$db->prescription_count($user_id);
	$s="SELECT `prescription_medicine`.*,`prescription_medicine`.`id` AS med_Id, `pharmasist`.`name`,`p1`.id,`p1`.`status`,`time`,`dose_date` FROM `prescription_medicine` LEFT JOIN pharmasist ON prescription_medicine.pharmacist_id = pharmasist.id LEFT JOIN prescription_medicine_time AS p1 ON prescription_medicine.id= p1.medicine_id  WHERE `user_id`='$user_id' && `remain_medicine`!=0 && `p1`.`status`='not' && `dose_date`='$doseDate' order by `time` ASC";
	//echo $s;
	$q=mysql_query($s);
	if(mysql_num_rows($q)>0)
	{
		while($as=mysql_fetch_assoc($q))
		{
			$result['medicine_id'] 			= $as['med_Id'];
			$result['prescription_id']		= $as['prescription_id'];
 			$result['medicine_name']		= $as['medicine_name'];
 			$result['prescription']			= $as['prescription'];
 			$result['dose_days']			= $as['dose_days'];
 			$result['refill_remain'] 		= $as['remain_medicine'].' '.$as['unit'];
 			$result['time_id']			    = $as['id'];
 			$result['time']				    = $as['time'];
 			$result['status']			    = $as['status'];
 			$result['dose_date']			= $as['dose_date'];
 			$result['medicine_image']		= base_url.'medical/tablet_image/'.$as['medicine_image'];
 			$result['last_refil']			= $as['end_date'];
 			$result['pharmacist_name']		= $as['name'];
 			$result['dose_type']			= 0;	
 			$response['Not_Taken'][]		= $result;
		}
	}
	else
	{
		$response['Not_Taken']=[];
	}

	
	$s1="SELECT `prescription_medicine`.*,`prescription_medicine`.`id` AS med_Id, `pharmasist`.`name`,`p1`.id,`p1`.`status`,`time`,`dose_date` FROM `prescription_medicine` LEFT JOIN pharmasist ON prescription_medicine.pharmacist_id = pharmasist.id LEFT JOIN prescription_medicine_time AS p1 ON prescription_medicine.id= p1.medicine_id  WHERE `user_id`='$user_id' && `remain_medicine`!=0 && `p1`.`status`='taken' && `dose_date`='$doseDate' order by `time` ASC";
	//echo $s;die();
	$q1=mysql_query($s1);
	if(mysql_num_rows($q1)>0)
	{
		while($as1=mysql_fetch_assoc($q1))
		{
			$result1['medicine_id']			= $as1['med_Id'];
			$result1['prescription_id']		= $as1['prescription_id'];
 			$result1['medicine_name']		= $as1['medicine_name'];
 			$result1['prescription']		= $as1['prescription'];
 			$result1['dose_days']			= $as1['dose_days'];
 			$result1['refill_remain'] 		= $as1['remain_medicine'].' '.$as1['unit'];
 			$result1['time_id']				= $as1['id'];
 			$result1['time']				= $as1['time'];
 			$result1['status']				= $as1['status'];
 			$result1['dose_date']			= $as1['dose_date'];
 			$result1['medicine_image']		= base_url.'medical/tablet_image/'.$as1['medicine_image'];
 			$result1['last_refil']			= $as1['end_date'];
 			$result1['pharmacist_name']		= $as1['name'];
 			$result1['dose_type']			= 1;
 			$response['taken'][]			= $result1;
		}
	}
	else
	{
		$response['taken']=[];
	}
	$response["success"] = 1;
	$response["message"] = "Success";
	$response["pres_status"] = $pres_status;
	echo json_encode($response);		
}
else
{
	$response["error"]	 = 1;
	$response["message"] = "Access Denied";
	echo json_encode($response);
}
?>