<?php
$response = array("success" => 0, "error" => 0);
if(isset($_POST['prescription_id']) && $_POST['prescription_id']!='' && isset($_POST['medicine_id']) && $_POST['medicine_id']!='')
{
	$pres_id =$_POST['prescription_id'];
	$medicine_id = $_POST['medicine_id'];
	require_once 'include/Md_Functions.php';
	$db = new Md_Functions();
	$up="UPDATE prescription_medicine SET pres_status=1, renew_timestamp=NOW() WHERE prescription_id = '$pres_id' AND id='$medicine_id'";
	
	//echo $up;
	$q=mysql_query($up);
	if(mysql_affected_rows()>0)
	{
		$response['success']=1;
		$response['message']="Renew refill request has been sent successfully";
		echo json_encode($response);
	}
	else
	{
		$response['error']=1;
		$response['message']="Error occur! Try again";
		echo json_encode($response);
	}
}
else
{
	$response['error']=1;
	$response['message']="Access Denied!";
	echo json_encode($response);
}
?>