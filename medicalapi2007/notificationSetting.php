<?php
if(isset($_POST['medicine_id']) && $_POST['medicine_id']!='' && $_POST['user_id']!='')
{
	require_once 'include/notification.php';
	require_once 'include/config.php';
	$db = new notification_Functions();
	$response = array("success" => 0, "error" => 0, "message"=>'');
	$medicine_id  		= $_POST['medicine_id'];
	$user_id	 		= $_POST['user_id'];	
	$prescription_id 	= $_POST['prescription_id'];
	$notification_type 	= $_POST['notification_type'];
	$frequency			= $_POST['frequency'];
	$notificaton_date	= $_POST['notification_date'];      //23-06-2017
	$notification_time 	= $_POST['notification_time'];
	$type 				= $_POST['type'];   //AM OR PM
	$notificaton_status = $_POST['notificaton_status'];  //0=manual,1=custome
	$notification_endDate = $_POST['notification_endDate'];  //23-06-2017
	$repeatType 		  = $_POST['repeatType'];            //0=always, 1= TillEndDate 

	$time  = explode(',',$notification_time);
	$types = explode(',',$type);
	$notificaton_date = explode(',',$notificaton_date);
	//print_r($times);die();
	$times = count($time);
	for($i=0; $i<$times; $i++)
	{
		//$notification_date = $date->format("d-m-Y");
		$data[] = '('."'".$medicine_id."'".','."'".$user_id."'".','."'".$prescription_id."'".','."'".$notification_type."'".','."'".$frequency."'".','."'".$notificaton_date[$i]."'".','."'".$time[$i]."'".','."'".$types[$i]."'".','."'".$notificaton_status."'".','."'".$repeatType."'".','."'".$notification_endDate."'".')';
	}
	$query =implode(',', $data);
	
	//$query = '('."'".$medicine_id."'".','."'".$user_id."'".','."'".$prescription_id."'".','."'".$notification_type."'".','."'".$frequency."'".','."'".$notificaton_date."'".','."'".$notification_time."'".','."'".$type."'".','."'".$notificaton_status."'".')';
	//print_r($query);die();

	if($db->setNotification($query,$medicine_id))
	{
		$response["error"]	 = 0;
		$response["success"] = 1;
		$response["message"] = "Notification setting has been saved Successfully";
		echo json_encode($response);
	}
	else
	{
		$response["error"]	 = 1;
		$response["success"] = 0;
		$response["message"] = "Not Success";
		echo json_encode($response);
	}
}

else
{
	$response["error"]	 = 2;
	$response["success"] = 0;
	$response["message"] = "Access Denied";
	echo json_encode($response);
}

	/*$dd = date('d-m-Y');
	//echo $dd;
	//Date between two dates
	$begin = new DateTime($dd);
	//$end = new DateTime('2017-05-22');
	$end = new DateTime($endDate);
	//echo $begin;
    if($notification_type==0)
    {    	
    	$daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
    }
    elseif($notification_type==1)
    {    	
    	$daterange = new DatePeriod($begin, new DateInterval('P7D'), $end);
    }
    elseif($notification_type==2)
    {    	
    	$daterange = new DatePeriod($begin, new DateInterval('P14D'), $end);
    }
    elseif($notification_type==3)
    {    	
    	$daterange = new DatePeriod($begin, new DateInterval('P30D'), $end);
    }
    else
    {
    	$daterange = new DatePeriod($begin, new DateInterval('P365D'), $end);
    }
    //Date between two dates
    foreach($daterange as $date)
	{
		$notification_date = $date->format("d-m-Y");
		$data[] = '('."'".$medicine_id."'".','."'".$user_id."'".','."'".$prescription_id."'".','."'".$notification_type."'".','."'".$notification_date."'".','."'".$notification_time."'".')';
	}
	$data[]= '('."'".$medicine_id."'".','."'".$user_id."'".','."'".$prescription_id."'".','."'".$notification_type."'".','."'".$endDate."'".','."'".$notification_time."'".')';
	$query =implode(',', $data);
	//print_r($query);die();
	if($db->setNotification($query,$medicine_id))
	{
		$response["error"]	 = 0;
		$response["success"] = 1;
		$response["message"] = "Notification setting has been saved Successfully";
		echo json_encode($response);
	}
	else
	{
		$response["error"]	 = 1;
		$response["success"] = 0;
		$response["message"] = "Not Success";
		echo json_encode($response);
	}
}
else
{
	$response["error"]	 = 2;
	$response["success"] = 0;
	$response["message"] = "Access Denied";
	echo json_encode($response);
}
*/