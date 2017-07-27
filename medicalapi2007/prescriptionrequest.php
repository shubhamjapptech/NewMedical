<?php
if (isset($_POST['tag']) && $_POST['tag']!='')
	{
		$tag = $_POST['tag'];
		require_once 'include/Md_Functions.php';
		$db = new Md_Functions();
		$response = array("tag" => $tag, "success" => 0, "error" => 0);
		if ($tag =='prescription') 
		{			
			if(isset($_POST['user_id']) && $_POST['user_id']!='' && isset($_POST['pharmacy_id']) && $_POST['pharmacy_id']!='')
			{
				$token = $_POST['token'];
				$user_id=$_POST['user_id'];
				$pharmacy_id=$_POST['pharmacy_id'];
				$randno =$db->radomno();
			    $nn='insurance-card.jpg';
				if(isset($_FILES['insurance_image']) && $_FILES['insurance_image']!='')
				{
	                $insurancename  = $randno.$_FILES['insurance_image']['name'];
					$s  = $_FILES['insurance_image']['tmp_name'];
					$nn = preg_replace('/\s*/m', '',$insurancename);
	                $d  = '../medical/insuranceImage/'.$nn;
	                move_uploaded_file($s,$d);
			    }			    
			    $bcode='';
			    if(isset($_POST['barcode']) && $_POST['barcode']!='')
			    {
			    	$bcode= $_POST['barcode'];	
			    }

				$user = $db->prescription($token,$user_id,$pharmacy_id,$nn,$bcode);

				if ($user) 
				{
					$prescription_id=$user;					
					$res["success"] = 1;
					$res["Error"] = 0;
					$res["prescription_id"]=$prescription_id;
					$res["Message"] ="Your prescription successfully submited";
					echo json_encode($res);
					exit();
				} 

				else
				{
					$res["success"] = 0;
					$res["Error"] = 1;
					$res["Message"] ="Try again! Your prescription not submited";
					echo json_encode($res);
					exit();

				 }
			}
			else
			{
				$res["success"] = 0;
				$res["Error"] = 1;
				$res["Message"] ="Medicine_id and pharmacy_id must to fill";
				echo json_encode($res);
				exit();
			}
		}
	
	}
	else
	{
		$msg="Access Denied";
		echo json_encode($msg);
	}
?>