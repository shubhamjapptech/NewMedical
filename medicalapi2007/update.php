<?php
if (isset($_POST['tag']) && $_POST['tag'] !='') 
{
	$tag = $_POST['tag'];
	require_once 'include/admin.php';
	require_once 'include/Md_Functions.php';
	require_once 'include/config.php';
	$db = new Admin_Functions();
	$md = new Md_Functions();
	$respons = array("tag" => $tag, "success" => 0, "error" => 0);
	if ($tag == 'update') 
	{
		$token = $_POST['token'];
		$image="";
		$check=$db->checkuser($token);

		if($check!=false)
		{
			//echo $check;
			$s="SELECT * FROM registration WHERE uniq_id='$token'";
			//print_r($s);
			$q           = mysql_query($s);
			$as          = mysql_fetch_assoc($q);
			$first_name  = $as["first_name"];
			$last_name   = $as["last_name"];
			$mobile 	 = $as["phone"];
			$gender      = $as["gender"];
			$address	 = $as["address"];	
		 // $zipcode     = $as["zipcode"];
			$image		 = $as["image"];
			$image_type  = $as["image_type"];
			if(isset($_FILES["img"]["name"]) && $_FILES["img"]["name"]!='')
			{
				// $imge="app.repillrx.com/app.repillrx.com/NewMedical/medical/image/".$as['image'];
				unlink("../medical/image/".$as['image']);
				$uuid=$md->radomno();	
				$s=$_FILES["img"]["tmp_name"];
	            //$ss=$fname.$_FILES["img"]["name"];
	            $ss=$uuid.$_FILES['img']['name'];
	            $image = preg_replace('/\s*/m', '',$ss);
	            $d="../medical/image/".$image;
	            move_uploaded_file($s,$d);
	        }
            extract($_POST);
			$up="UPDATE registration SET first_name='$first_name', last_name='$last_name', phone='$mobile', gender='$gender',address='$address',image='$image',image_type='$image_type',updateAt=NOW() WHERE uniq_id = '$token'";
			//echo $up;
			$q=mysql_query($up);
			if($q)
			{
				$s="SELECT * FROM registration WHERE uniq_id='$token'";
				$q=mysql_query($s);
				if($q)
				{
					/*if($md->ispharmaciesExisted($zipcode))
					{
						$respons['error']=1;
						$respons['error_msg']="Sorry! Repill does not have any pharmacist in your area";
					}*/
					$admin      = $md->admin_data();
					$as         = mysql_fetch_assoc($q);
				    $pres_status= $md->prescription_count($user_id);
				    $pharmacy_detail = $md->pharmacy_detail($user_id);
				    if(empty($pharmacy_detail))
				    {
				    	$pharmacy_detail='';
				    }
					$respons['success']				= 1;
					$respons['message']         	= "Update Sucess";
					$respons["token"]          	    = $as["uniq_id"];
					$respons["devicetoken"]         = $as["device_token"];
					$respons["admin_image"]         = base_url.'/medical/image/'.$admin['image'];
					$respons["user"]["pres_status"] = $pres_status;
					$respons["user"]["user_id"] 	= $as["id"];
					$respons["user"]["user_qbid"]	= $as["qb_id"];
					$respons['user']['first_name']	= $as['first_name'];
					$respons['user']['last_name']	= $as['last_name'];
					$respons['user']['mobileNo']		= $as['phone'];
					$respons['user']['email']		= $as['email'];
					if($as['image_type']==0)
					{
						$image=base_url."medical/image/".$as['image'];
					}	
					else
					{
						$image = $as["image"];
					}						
					$respons['user']['image']		 = $image;
					$respons['user']['image_type']	 = $as['image_type'];
					$respons['user']['gender']		 = $as['gender'];
					$respons['user']['address']		 = $as['address'];
					$respons["user"]["pharmacy_detail"] =$pharmacy_detail;
					$respons["QbDetail"]["admin_id"] = "22363083";
					$respons["QbDetail"]["password"] = $as["password"];
					// $respons['user']['zipcode']=$as['zipcode'];
					echo json_encode($respons);
				}
			}
			else
			{
				$respons['error']=2;
				$respons['message']="Not update! Some error occur";
				echo json_encode($respons);
			}
		}
		else
		{
			$respons['error']=3;
			$respons['message']="You are not login or Your token is expire";
			echo json_encode($respons);
		}
	}
	else
	{
		$respons['error']=4;
		$respons['message']="Access Denied";
		echo json_encode($respons);
	}
	
}

else
{
	$respons['error']=4;
	$respons['message']="Access Denied";
	echo json_encode($respons);
}
?>