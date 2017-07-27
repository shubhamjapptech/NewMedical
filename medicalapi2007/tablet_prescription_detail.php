<?php
$response = array("success" =>'0', "error" => 0);
if(isset($_POST['prescription_id']) && ($_POST['medicine_name']))
{
	require_once 'include/tablet_function.php';
	require_once 'include/config.php';
	$db = new tablet_Functions();
	
	$pres_id=$_POST['prescription_id'];
	$md_name=$_POST['medicine_name'];
    // $s="SELECT `p1`.`medicine_name`,`medicine_image`,`p1`.`status`,`prescription` , `remain_medicine`,`unit`,`p1`.`end_date`,`p2`.`name`, `phone`, `p2`.`address`,`lat`,`long` FROM `patatent_tablets` AS p1 JOIN pharmasist AS p2 ON p1.pharmacist_id = p2.id WHERE p1.medicine_name= '$md_name' && p1.prescription_id='$pres_id'";
     $s="SELECT `p1`.*,`p2`.`name`, `phone`, `p2`.`address`,`lat`,`long`,`p3`.status FROM `prescription_medicine` AS p1 JOIN pharmasist AS p2 ON p1.pharmacist_id = p2.id LEFT JOIN prescription_medicine_time AS p3 ON p1.id= p3.medicine_id WHERE p1.medicine_name= '$md_name' && p1.prescription_id='$pres_id'";
	//print_r($s);die;
	$q=mysql_query($s);
	if(mysql_num_rows($q)>0)
	{
		$as=mysql_fetch_assoc($q);	
		//echo json_encode($as);die;
		$ss="SELECT * from user_pharmacy join prescription ON user_pharmacy.id=prescription.pharmacy_id WHERE prescription.id='$pres_id'";
		//print_r($ss);die;

		$qq=mysql_query($ss);
		$ass=mysql_fetch_assoc($qq);
		$user["medicine"]["medicine_id"]	 = $as["id"];
		$user["medicine"]["user_id"]		 = $as["user_id"];
		$user["medicine"]["prescription_id"] = $as["prescription_id"];
		$user["medicine"]["manufacturer"]    = $as["medicine_company"];		 		
		$user["medicine"]["medicine_name"]	 = $as['medicine_name'];
		$user["medicine"]["status"]			 = $as['status'].' taken';
		$user["medicine"]["last_refil"]		 = $as['end_date'];
		$user["medicine"]["refil_remain"]	 = $as['remain_medicine'].' '.$as['unit'];		
		$user["medicine"]["quantity"]	 	 = $as['total_medicine'].' '.$as['unit'];		
		$user["medicine"]["prescription"]	 = $as['prescription'];
		$user["Prescriber"]["name"]			 = $as['name'];
		$user["Prescriber"]["phone"]		 = $as['phone'];
		$user["Prescriber"]["address"]		 = $as['address'];
		$user["Prescriber"]["latitute"]		 = $as['lat'];
		$user["Prescriber"]["longitude"]	 = $as['long'];
		$user["Pharmacy"]["name"]			 = $ass['pharmacy_name'];
		$user["Pharmacy"]["phone"]			 = $ass['contactNo'];
		$user["Pharmacy"]["address"]		 = $ass['city'];		
		$user["Pharmacy"]["cross_street"]	 = $ass['cross_street'];		
		$response['success']	= "1";
		$response['message']	= "success";
		$response['data']		= $user;
		echo json_encode($response);
	}
	else
	{
		$response['error']		= "1";
		$response['message']	= "please enter corret detail";
		echo json_encode($response);
	}
}

else
{
	$response['error']		= "2";
	$response['message']		= "Access Denied";
	echo json_encode($response);
}
?>