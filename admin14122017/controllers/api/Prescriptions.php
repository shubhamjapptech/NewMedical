<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Prescriptions extends CI_Controller
{
  function __construct() 
  {
    parent::__construct();
    $this->load->model("apiModel/Home_model");
    $this->load->model("apiModel/Testing_model");
    $this->load->model("apiModel/Prescriptions_model");
  }

	public function AddPrescriptionrequest()
  	{
	  	if (isset($_POST['tag']) && $_POST['tag']!='')
		{
			$tag = $_POST['tag'];
			$response = array("tag" => $tag, "success" => 0, "error" => 0);
			if ($tag =='prescription') 
			{			
				if(isset($_POST['user_id']) && $_POST['user_id']!='' && isset($_POST['pharmacy_id']) )
				{
					$token = $_POST['token'];
					$user_id=$_POST['user_id'];
					$pharmacy_id=$_POST['pharmacy_id'];
					$randno =$this->Home_model->radomno();
				    $nn='insurance-card.jpg';
					if(isset($_FILES['insurance_image']) && $_FILES['insurance_image']!='')
					{
		                $insurancename  = $randno.$_FILES['insurance_image']['name'];
						$s  = $_FILES['insurance_image']['tmp_name'];
						$nn = preg_replace('/\s*/m', '',$insurancename);
		                $d  = 'insuranceImage/'.$nn;
		                move_uploaded_file($s,$d);
				    }			    
				    $bcode='';
				    if(isset($_POST['barcode']) && $_POST['barcode']!='')
				    {
				    	$bcode= $_POST['barcode'];	
				    }

					$user = $this->Prescriptions_model->prescription($token,$user_id,$pharmacy_id,$nn,$bcode);

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
			$msg["error"] = 4;
			$msg["message"]="Access Denied";
			echo json_encode($msg);
		}
	}

	public function prescriptionImage()
	{
		$response = array("success" =>0, "error" => 0);
		if(isset($_POST['prescription_id']) && $_POST['prescription_id']!='')
		{			
			$prescription_id=$_POST['prescription_id'];
			if(isset($_FILES['prescription_image']) && $_FILES['prescription_image']!='')
			{
				$randno =$this->Home_model->radomno();
				$imagenames='';
			    $Imagename = $randno.$_FILES['prescription_image']['name'];
			    $s =  $_FILES['prescription_image']['tmp_name'];
			    $imagename = preg_replace('/\s*/m', '',$Imagename);
			    $d = 'precriptionImage/'.$imagename;  
			    move_uploaded_file($s,$d);	 
			    $res= $this->Prescriptions_model->prescriptionimage($prescription_id,$imagename); 
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
				if($this->Prescriptions_model->prescriptionimage($prescription_id,$pres)) 
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
	}

	public function show_all_tablets()
	{
		if(isset($_POST['user_id']) && $_POST['user_id']!='')
		{
			$response = array("success" => 0, "error" => 0, "message"=>'');
			$user_id  = $_POST['user_id'];
			$doseDate = $_POST['doseDate'];
			$result=array();
			$blank='';
			$SoundFlag='';
			$pres_status=$this->Home_model->prescription_count($user_id);
			$notTaken = $this->Prescriptions_model->notTakenMedicine($user_id,$doseDate);
			//echo $s;
			if(!empty($notTaken))
			{
				$SoundFlag=0;
				foreach ($notTaken as $as)
				{
					$result['medicine_id'] 			= $as['med_Id'];
					$result['prescription_id']		= $as['prescription_id'];
		 			$result['medicine_name']		= $as['medicine_name'];
		 			$result['prescription']			= $as['prescription'];
		 			$result['dose_days']			= $as['dose_days'];
		 			$result['refill_remain'] 		= $as['remain_medicine'].' '.$as['unit'];
		 			$result['time_id']			    = $as['id'];
		 			$result['time']				    = $as['time'];
		 			$result['time_type']            = $as['time_type'];
		 			$result['status']			    = $as['status'];
		 			$result['dose_date']			= $as['dose_date'];
		 			$result['medicine_image']		= base_url().'tablet_image/'.$as['medicine_image'];
		 			$result['last_refil']			= $as['end_date'];
		 			$result['pharmacist_name']		= $as['name'];
		 			$result['dose_type']			= 0;	
		 			$response['Not_Taken'][]		= $result;
				}
			}
			else
			{
				$SoundFlag=1;
				$response['Not_Taken']=[];
			}

			$taken = $this->Prescriptions_model->takenMedicine($user_id,$doseDate);
			if(!empty($taken))
			{
				
				foreach ($taken as $as1)
				{
					$result1['medicine_id']			= $as1['med_Id'];
					$result1['prescription_id']		= $as1['prescription_id'];
		 			$result1['medicine_name']		= $as1['medicine_name'];
		 			$result1['prescription']		= $as1['prescription'];
		 			$result1['dose_days']			= $as1['dose_days'];
		 			$result1['refill_remain'] 		= $as1['remain_medicine'].' '.$as1['unit'];
		 			$result1['time_id']				= $as1['id'];
		 			$result1['time']				= $as1['time'];
		 			$result1['time_type']           = $as1['time_type'];
		 			$result1['status']				= $as1['status'];
		 			$result1['dose_date']			= $as1['dose_date'];
		 			$result1['medicine_image']		= base_url().'tablet_image/'.$as1['medicine_image'];
		 			$result1['last_refil']			= $as1['end_date'];
		 			$result1['pharmacist_name']		= $as1['name'];
		 			$result1['dose_type']			= 1;
		 			$response['taken'][]			= $result1;
				}
			}
			else
			{
				
				$response['taken']=[];
			}
			$response["success"] = 1;
			$response["message"] = "Success";
			$response['SoundFlag']=$SoundFlag;
			$response["pres_status"] = $pres_status;
			echo json_encode($response);	
		}
		else
		{
			$response["error"]	 = 1;
			$response["message"] = "Access Denied";
			echo json_encode($response);
		}
	}

	public function tablet_prescription_detail()
	{
		if(isset($_POST['prescription_id']) && ($_POST['medicine_name']))
		{
			$pres_id  = $_POST['prescription_id'];
			$md_name  = $_POST['medicine_name'];
			$tabas = $this->Prescriptions_model->tabletDetail($pres_id,$md_name);
			if(!empty($tabas))
			{
					$user_id = $tabas["user_id"];
					$ass = $this->Home_model->pharmacy_details($user_id);
					//echo json_encode($ass);
					$user["medicine"]["medicine_id"]	 = $tabas["id"];
					$user["medicine"]["user_id"]		 = $tabas["user_id"];
					$user["medicine"]["prescription_id"] = $tabas["prescription_id"];
					$user["medicine"]["manufacturer"]    = $tabas["medicine_company"];		 		
					$user["medicine"]["medicine_name"]	 = $tabas['medicine_name'];
					$user["medicine"]["status"]			 = $tabas['status'].' taken';
					$user["medicine"]["last_refil"]		 = date('d-m-Y', strtotime($tabas['timestamp']));
					$user["medicine"]["refil_remain"]	 = $tabas['refill_remain'];		
					$user["medicine"]["quantity"]	 	 = $tabas['total_medicine'].' '.$tabas['unit'];		
					$user["medicine"]["prescription"]	 = $tabas['prescription'];
					$user["Prescriber"]["name"]			 = $tabas['prescriber_name'];
					$user["Prescriber"]["phone"]		 = $tabas['prescriber_number'];
					$user["Prescriber"]["address"]		 = $tabas['prescriber_address'];
					$user["Prescriber"]["latitute"]		 = $tabas['lat'];
					$user["Prescriber"]["longitude"]	 = $tabas['long'];
					$user["Pharmacy"]["name"]			 = $ass->pharmacy_name;
					$user["Pharmacy"]["phone"]			 = $ass->contactNo;
					$user["Pharmacy"]["address"]		 = $ass->city;		
					$user["Pharmacy"]["cross_street"]	 = $ass->cross_street;		
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
			$response['message']	= "Access Denied";
			echo json_encode($response);
		}
	}

	public function tablet_response()
	{
		if(isset($_POST['time_id']) && $_POST['time_id']!='' && isset($_POST['medicine_id'])&& $_POST['medicine_id']!='')
		{
			$response = array("success" => 0, "error" => 0);
			$time_id			= $_POST['time_id'];
			$medicine_id 		= $_POST['medicine_id'];   //patent tablet id
			$prescription_id	= $_POST['prescription_id'];
			$medicine_name		= $_POST['medicine_name'];
			$check_type         = $_POST['check_type']; //0=uncheck 1=checked
			$med = $this->Prescriptions_model->medicine_detail($medicine_id);
			$total_medicine =  $med['total_medicine'];
			$remain 		=  $med['remain_medicine'];
			$take   		=  $med['dailyDose'];
			if($check_type==1)
			{
				$status =  "taken";	
				$remMed    =  $remain - $take;	
			}
			if($check_type==0)
			{
				$status =  "not";	
			    $remMed    =  $remain + $take;
			}	
			if($total_medicine>=$remMed && $remMed>=0)
			{
				if($this->Prescriptions_model->updateTabResponse($status,$remMed,$time_id,$medicine_id))
				{
					$response["success"] = 1;
					$response["message"] = "success";
					echo json_encode($response);
				}
				else
				{
					$response["error"]   = 1;
					$response["message"] = "Error occur";
					echo json_encode($response);
				}	
			}
			else
			{
				$response["error"]   = 2;
				$response["message"] = "Something wrong";
				echo json_encode($response);
			}
		}
		else
		{
			$response["error"]		= 1;
			$response["success"]	= 0;
			$response["message"]	= "All field are required";
			echo json_encode($response);
		}
	}

	public function refillList_notification()
	{
		$response = array("success" => 0, "error" => 0, "message"=>'');
		if(isset($_POST['user_id']))
		{
			$user_id= $_POST['user_id'];
			$data   = array();
			$refillTab = $this->Prescriptions_model->refillListAtNotificationTab($user_id);
			if(!empty($refillTab))
			{
				foreach ($refillTab as $reTab)
				{
					$result['medicine_id']		= $reTab['id'];
					$result['time_id']			= $reTab['time_id'];
					$result['prescription_id']	= $reTab['prescription_id'];
					$result['manufacturer']		= $reTab['medicine_company'];
		 			$result['medicine_name']	= $reTab['medicine_name'];
		 			$result['prescription']		= $reTab['prescription'];
		 			$result['dose_days']		= $reTab['dose_days'];
		 			// $result['refill_remain'] =$as['remain_medicine'].' '.$as['unit'];
		 			$result['refill_remain'] 	= $reTab['refill_remain'];
		 			$result['medicineRemain'] 	= $reTab['remain_medicine'];
		 			$result['status']			= $reTab['status'];
		 			$result['time']				= $reTab['time'];
		 			$result['pharmacist_name']	= $reTab['name'];
		 			$result['medicine_image']	= base_url().'tablet_image/'.$reTab['medicine_image'];
		 			$result['last_refil']		= $reTab['end_date'];
		 			$result['refillDate']		= $reTab['Date_filled'];
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
			$response["error"]	 = 2;
			$response["message"] = "Access Denied";
			echo json_encode($response);
		}
	}

	public function manuallNotificationSetting()
	{
		if(isset($_POST['medicine_id']) && $_POST['medicine_id']!='' && $_POST['user_id']!='')
		{
			$response = array("success" => 0, "error" => 0, "message"=>'');
			$medicine_id  		  = $_POST['medicine_id'];
			$user_id	 		  = $_POST['user_id'];	
			$prescription_id 	  = $_POST['prescription_id'];
			$notification_type 	  = $_POST['notification_type'];
			$frequency			  = $_POST['frequency'];
			$notificaton_date	  = $_POST['notification_date'];      //23-06-2017
			$notification_time 	  = $_POST['notification_time'];
			$type 				  = $_POST['type'];   //AM OR PM
			$notificaton_status   = $_POST['notificaton_status'];     // 0=manual 1=custom
			$notification_endDate = $_POST['notification_endDate'];  //23-06-2017
			$repeatType 		  = $_POST['repeatType'];            //0=always, 1= TillEndDate
			$notificationSwitch   = $_POST['notificationSwitch'];    //0=on 1=off
			$time  				  = explode(',',$notification_time);
			$types                = explode(',',$type);
			//$notificaton_date     = explode(',',$notificaton_date);
			//print_r($ptime);die();
			$medicineTime = $this->Prescriptions_model->medicineTime($medicine_id);
			$preTime= count($medicineTime);
			$Newtimes = count($time);
			if($notificationSwitch==1)
			{
				if($this->Prescriptions_model->UpdateNotificationSwitch($medicine_id,$notificationSwitch))
				{
					$response["error"]	 = 0;
					$response["success"] = 2;
					$response["message"] = "Notification has been switched off";
					echo json_encode($response);
				}
				else
				{
					$response["error"]	 = 3;
					$response["success"] = 0;
					$response["message"] = "Please try again,Notification does not switche off";
					echo json_encode($response);
				}
			}
			else
			{
				if($preTime==$Newtimes)
				{
					$messagebit=1;
					for($i=0; $i<$Newtimes; $i++)
					{
						if($messagebit<=10)
						{
							$msgbit= $messagebit++;
						}
						else
						{
							$messagebit=1;
							$msgbit= $messagebit;
						}
						//$notification_date = $date->format("d-m-Y");
						$data[] = '('."'".$medicine_id."'".','."'".$user_id."'".','."'".$prescription_id."'".','."'".$notification_type."'".','."'".$frequency."'".','."'".$notificaton_date."'".','."'".$time[$i]."'".','."'".$types[$i]."'".','."'".$notificaton_status."'".','."'".$repeatType."'".','."'".$notification_endDate."'".','."'".$notificationSwitch."'".','."'".$msgbit."'".')';
					}
					$query =implode(',', $data);
					//print_r($query);die();
					if($this->Prescriptions_model->setNotification($query,$medicine_id,$notificaton_status))
					{
						$this->Prescriptions_model->updateMedicineTime($medicine_id,$time,$types);
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
					$response["message"] = "Number of time does not match.";
					echo json_encode($response);
				}
			}
		}
		else
		{
			$response['error']=1;
			$response["success"] = 0;
			$response['message']="Access Denied!";
			echo json_encode($response);
		}
	}

	public function notificationSetting()
	{
		if(isset($_POST['medicine_id']) && $_POST['medicine_id']!='' && $_POST['user_id']!='')
		{
			$response = array("success" => 0, "error" => 0, "message"=>'');
			$medicine_id  			= $_POST['medicine_id'];
			$user_id	 			= $_POST['user_id'];	
			$prescription_id 		= $_POST['prescription_id'];
			$notification_type 		= $_POST['notification_type'];
			$frequency				= $_POST['frequency'];
			$notificaton_date		= $_POST['notification_date'];      //23-06-2017
			$notification_time 		= $_POST['notification_time'];
			$type 					= $_POST['type'];   //AM OR PM
			$notificaton_status 	= $_POST['notificaton_status'];
			$notification_endDate 	= $_POST['notification_endDate'];  //23-06-2017
			$repeatType 		  	= $_POST['repeatType'];            //0=always, 1= TillEndDate  
			$notificationSwitch     = 0;     //0=on 1=off
			$time  = explode(',',$notification_time);
			$types = explode(',',$type);
			$notificaton_date = explode(',',$notificaton_date);
			//print_r($times);die();
			$times = count($time);
			$messagebit=1;
			for($i=0; $i<$times; $i++)
			{
				if($messagebit<=10)
				{
					$msgbit= $messagebit++;
				}
				else
				{
					$messagebit=1;
					$msgbit= $messagebit;
				}
				//$notification_date = $date->format("d-m-Y");
				$data[] = '('."'".$medicine_id."'".','."'".$user_id."'".','."'".$prescription_id."'".','."'".$notification_type."'".','."'".$frequency."'".','."'".$notificaton_date[$i]."'".','."'".$time[$i]."'".','."'".$types[$i]."'".','."'".$notificaton_status."'".','."'".$repeatType."'".','."'".$notification_endDate."'".','."'".$notificationSwitch."'".','."'".$msgbit."'".')';
			}
			//print_r($data);die();
			$query =implode(',', $data);
			if($this->Prescriptions_model->setNotification($query,$medicine_id,$notificaton_status))
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
			$response["message"] = "Access Denied";
			echo json_encode($response);
		}
	}

	public function get_notificationSetting()
	{
		if (isset($_POST['tag']) && $_POST['tag'] != '' && isset($_POST['medicineId']) && $_POST['medicineId'] !='')
		{
			$tag = $_POST['tag'];
			$response = array("tag" => $tag, "success" => 0, "error" => 0);
			if ($tag == 'notificationsetting')
		 	{
		 		$medicine_id = $_POST['medicineId'];
		 		$notificationtimes = $this->Prescriptions_model->getnotificationsetting($medicine_id);
		 		$times = $this->Prescriptions_model->medicineTime($medicine_id);
		 		if(!empty($notificationtimes))
		 		{
		 			$notificationresponse["success"] =1;
					$notificationresponse["error"] = 0;
					$notificationresponse["message"] = "Success";
					$notificationresponse["data"] = $notificationtimes;
					$notificationresponse["timedata"] = $times;					
					echo json_encode($notificationresponse);
		 		}
		 		else
		 		{
		 			$notificationresponse["success"] = 0;
					$notificationresponse["error"] = 1;
					$notificationresponse["message"] = "Notification setting does not found";
					$notificationresponse["data"] = $notificationtimes;
					$notificationresponse["timedata"] = $times;
					echo json_encode($notificationresponse);
		 		}
		 	}
		 	else
			{
				$notificationresponse["success"] = 0;
				$notificationresponse["error"]=2;
				$notificationresponse["message"]="Access Denied";
				echo json_encode($notificationresponse);
			}
		}
		else
		{
			$notificationresponse["success"] = 0;
			$notificationresponse["error"]=3;
			$notificationresponse["message"]="Invalid request";
			echo json_encode($notificationresponse);
		}

	}


	public function renew_refill_request()
	{
		$response = array("success" => 0, "error" => 0);
		if(isset($_POST['prescription_id']) && $_POST['prescription_id']!='' && isset($_POST['medicine_id']) && $_POST['medicine_id']!='')
		{
			$pres_id     = $_POST['prescription_id'];
			$medicine_id = $_POST['medicine_id'];
			$refill_remain = $_POST['refill_remain'];
			$refill_remains  = $refill_remain-1;
			if($this->Prescriptions_model->renew_request($pres_id,$medicine_id,$refill_remains))
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
	}

	public function medicineTime()
	{
		if (isset($_POST['tag']) && $_POST['tag'] != '' && isset($_POST['medicineId']) && $_POST['medicineId'] !='')
		{
			$tag = $_POST['tag'];
			$response = array("tag" => $tag, "success" => 0, "error" => 0);
			if ($tag == 'times')
		 	{
		 		$medicine_id = $_POST['medicineId'];
		 		$times = $this->Prescriptions_model->medicineTime($medicine_id);
		 		if(!empty($times))
		 		{
		 			$timeresponse["success"] =1;
					$timeresponse["error"] = 0;
					$timeresponse["message"] = "Success";
					$timeresponse["data"] = $times;
					echo json_encode($timeresponse);
		 		}
		 		else
		 		{
		 			$timeresponse["success"] = 0;
					$timeresponse["error"] = 1;
					$timeresponse["message"] = "No Time found";
					$timeresponse["data"] = $times;
					echo json_encode($timeresponse);
		 		}
		 	}
		 	else
			{
				$timeresponse["success"] = 0;
				$timeresponse["error"]=2;
				$timeresponse["message"]="Access Denied";
				echo json_encode($timeresponse);
			}
		}
		else
		{
			$timeresponse["success"] = 0;
			$timeresponse["error"]=3;
			$timeresponse["message"]="Invalid request";
			echo json_encode($timeresponse);
		}
	}

	public function phpinformation()
	{
		echo phpinfo();
	}



	
}



