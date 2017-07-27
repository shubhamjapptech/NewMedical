 <?php

if (isset($_POST['tag']) && $_POST['tag'] != '')
{
	$tag = $_POST['tag'];
	require_once 'include/notification.php';
	require_once 'include/config.php';
	$db = new notification_Functions();
	$response = array("tag" => $tag, "success" => 0, "error" => 0);
	if ($tag == 'notification_update')
	{
		$prescription_id=$_POST['prescription_id'];
		$refill_name=$_POST['refill_name'];
		$notification_intervel=$_POST['notification_intervel'];
		$notification_setting= $_POST['setting']; // 0=On, 1=Off

		$user = $db->notification_setting($prescription_id,$refill_name,$notification_intervel,$notification_setting);
		if($user)
		{
			$response["success"] = 1;
			$response["message"] = "success";
			echo json_encode($response);
		}
		else
		{
			$response["error"] = 1;
			$response["message"] = "Error occur! Try again";
			echo json_encode($response);
		}
	}
	else
	{
		$response["error"] = 2;
		$response["message"] = "Enter corret tag name";
		echo json_encode($response);
	}
}
else
{
	$response["error"] = 3;
	$response["message"] = "Access Denied";
	echo json_encode($response);
}		