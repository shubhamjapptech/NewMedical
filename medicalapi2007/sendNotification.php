<?php

require_once 'include/notification.php';
require_once 'include/config.php';

//echo file_get_contents('https://github.com/duccio/ApnsPHP/issues/24');
$db = new notification_Functions();


$message ="It's med time! Come on in!";
$device_token  = 'caa3f139c856613c6f0055e42130377359239a86e342c7725c7bb10ddfc89747';
//print_r($message);
$db->sendIosNotification($device_token,$message);




/*$r= "SELECT * FROM notification";
$q= mysql_query($r);
while ($result = mysql_fetch_assoc($q))
{
	$user_id = $result['user_id'];
	$medicine_id = $result['medicine_id'];
	$today   = date('d-m-Y H:i');
	//print_r($today);
	$notificationDate =$result['notification_date'].' '.$result['time'];
	if($notificationDate == $today)
	{
		$details = "SELECT * FROM registration LEFT JOIN `prescription_medicine` on prescription_medicine.user_id=registration.id where registration.id='$user_id' and prescription_medicine.id='$medicine_id'";
		//echo $details;
		$qq = mysql_query($details);
		$de = mysql_fetch_assoc($qq);
		$device_token  = $de['device_token'];
		$medicine_name = $de['medicine_name'];
		$message ="It's ".$meidince_name."med time! Come on in!";
		$db->sendIosNotification($device_token,$message);
	}	
}*/


?>