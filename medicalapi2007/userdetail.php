<?php
if (isset($_POST['user_id']) && $_POST['user_id'] != '')
{ 
	$user_id = $_POST['user_id'];
	require_once 'include/Md_Functions.php';
	require_once 'include/config.php';

	$db = new Md_Functions();
	$response = array("success" => 0, "error" => 0);	
	$user = $db->userDetails($user_id);
	if(!empty($user))
	{
	    $admin=$db->admin_data();
	    $pres_status=$db->prescription_count($user_id);
	    $pharmacy_detail= $db->pharmacy_detail($user_id);
	    if(empty($pharmacy_detail))
	    {
	    	$pharmacy_detail='';
	    }
		$response["success"] = 1;
		$response["token"] = $user["uniq_id"];
		$response["devicetoken"]=$user["device_token"];
		$response["admin_image"]=base_url.'/medical/image/'.$admin['image'];
		$response["user1"]["pres_status"] = $pres_status;
		$response["user1"]["user_id"] = $user["id"];
		// $response["user1"]["user_qbid"]=$qb_id;
		$response["user1"]["user_password"] =$user["upass"];
		$response["user1"]["First_name"] = $user["first_name"];
		$response["user1"]["last_name"] = $user["last_name"];
		$response["user1"]["mobileNo"] = $user["phone"];
		if($user['image_type']==0)
		{
			$image = base_url.'/medical/image/'.$user["image"];
		}	
		else
		{
			$image = $user["image"];
		}
		$response["user1"]["image"] = $image;
		$response["user1"]["image_type"] = $user['image_type'];
		$response["user1"]["email"] = $user["email"];
		$response["user1"]["gender"] = $user["gender"];
		$response["user1"]["address"] = $user["address"];
		$response["user1"]["created_at"] = $user["timestamp"];
		$response["user1"]["pharmacy_detail"] =$pharmacy_detail;
		$response["QbDetail"]["admin_id"]="22363083";
		$response["QbDetail"]["password"]=$user["password"];
		echo json_encode($response);
	}
	else
	{
		$response["error"]=1;
		$response["msg"]="User is not found";
		echo json_encode($response);
	}
} 
else
{
	$response["error"]=3;
	$response["msg"]="Accss Denied";
	echo json_encode($response);
}
?>
