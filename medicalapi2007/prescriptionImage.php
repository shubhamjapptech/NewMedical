<?php 
$response = array("success" =>0, "error" => 0);
if(isset($_POST['prescription_id']) && $_POST['prescription_id']!='')
{
	require_once 'include/Md_Functions.php';
	$prescription_id=$_POST['prescription_id'];
	$db = new Md_Functions();	
	if(isset($_FILES['prescription_image']) && $_FILES['prescription_image']!='')
	{
		$randno =$db->radomno();
		$imagenames='';
	    $Imagename = $randno.$_FILES['prescription_image']['name'];
	    $s =  $_FILES['prescription_image']['tmp_name'];
	    $imagename = preg_replace('/\s*/m', '',$Imagename);
	    $d = '../medical/precriptionImage/'.$imagename;  
	    move_uploaded_file($s,$d);	 
	    $res= $db->prescriptionimage($prescription_id,$imagename); 
	    if($res)
	    {
	    	$response["success"] = 1;
			$response["error"] = 0;
			$response["prescription_id"]=$prescription_id;
			$response["Message"] ="Your prescription has been submited successfull";
			echo json_encode($response); 
	    }
	    else
	    {
			$response["error"] = 1;
			$response["prescription_id"]=$prescription_id;
			$response["Message"] ="Error! Prescription image not submited";
			echo json_encode($response); 
	    }	
	         
	}
	else
	{
		$pres='prescription.jpg';
		if($db->prescriptionimage($prescription_id,$pres))
		{
			$response["success"] = 1;
			$response["prescription_id"]=$prescription_id;
			$response["Message"] ="Your prescription has been submited successfull";
			echo json_encode($response);
		}
		else
		{
			$response["error"] = 1;
			$response["prescription_id"]=$prescription_id;
			$response["Message"] ="Error! Prescription image not submited";
			echo json_encode($response); 
		}
	}
}
else
{
	$response["error"] = 2;
	$response["Message"] ="Access Denied";
	echo json_encode($response); 
}

?>