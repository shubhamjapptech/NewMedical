<?php
$response = array("success" => 0, "error" => 0, "message"=>'');
if(isset($_POST['user_id']))
{
	require_once 'include/Md_Functions.php';
	require_once 'include/config.php';
	$db = new Md_Functions();	
	$user_id=$_POST['user_id'];
	$data=array();

	$s="SELECT `prescription_medicine`.*, `p1`.id As time_id,`p1`.`status`,`time`,`dose_date`, `pharmasist`.`name` FROM `prescription_medicine`LEFT JOIN prescription_medicine_time AS p1 ON prescription_medicine.id= p1.medicine_id LEFT JOIN pharmasist ON prescription_medicine.pharmacist_id = pharmasist.id WHERE `prescription_medicine`.`user_id`='$user_id' && `remain_medicine`!=0 group by `prescription_medicine`.`id`";
	//echo $s;
	$q=mysql_query($s);
	if(mysql_num_rows($q)>0)
	{
		while($as=mysql_fetch_assoc($q))
		{
			$result['medicine_id']=$as['id'];
			$result['time_id']	= $as['time_id'];
			$result['prescription_id']=$as['prescription_id'];
			$result['manufacturer']	= $as['medicine_company'];
 			$result['medicine_name']=$as['medicine_name'];
 			$result['prescription']=$as['prescription'];
 			$result['dose_days']=$as['dose_days'];
 			// $result['refill_remain'] =$as['remain_medicine'].' '.$as['unit'];
 			$result['refill_remain'] =$as['remain_medicine'];
 			$result['status']=$as['status'];
 			$result['time']=$as['time'];
 			$result['pharmacist_name']		= $as['name'];
 			$result['medicine_image']=base_url.'medical/tablet_image/'.$as['medicine_image'];
 			$result['last_refil']=$as['end_date'];
 			$data[]=$result;
		}
			$response["success"]	 = 1;
			$response["message"]     = "Success";
			$response["data"]		 = $data;	
			echo json_encode($response);
	}
	else
	{
		$response["error"]		 = 1;
		$response["message"]     = "No refill";
		$response["data"]		 = $data;	
		echo json_encode($response);
	}
}
else
{
	$response["error"]	 = 1;
	$response["message"] = "Access Denied";
	echo json_encode($response);
}