<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pharmacy extends CI_Controller 
{
	function __construct() {
        parent::__construct();
        $this->load->model("user_model");
        $this->load->model("admin_model");
		$this->load->model("pharmasist_model");
		$this->load->model("pharmacy_model");
        $data= new stdClass();
        if($this->session->userdata('email') == '')
        {
           redirect('admin');
        }
	    }
	 public function get_pharmacy()
	 {
		$data=new stdClass();
		$pharmacylist=$this->pharmacy_model->registred_pharmacy();
		if(!empty($pharmacylist))
		{
			$data->pharmacylist=$pharmacylist;
		 	$this->load->view('pharmacylist',$data);
		}
		else
		{
			$data->error=1;
			$data->success=0;
			$data->message="No Pharmacy registred";
			$this->load->view('pharmacylist',$data);
		}
	 }

	 public function add_pharmacy()
	 {
	 	$data= new stdClass();
		if ($this->input->post('submit') && $this->input->post())
		{
			extract($_POST);
			$email=$_POST['email'];
			$pharmacy_name=$_POST['pharmacy_name'];
			$address=$_POST['address'];
			$city=$_POST['city'];
			$zipcode=$_POST['zipcode'];
			$add=$address.' '.$city.' '.$zipcode;
			$add1=$city.''.$zipcode;
			$latlong=$this->latLong($add,$add1);
			$lat=$latlong["latitude"];
        	$long=$latlong["longitude"];
			$db=$this->pharmacy_model->ispharmacyexits($email,$pharmacy_name);
			if($db>0)
			{
				$data->error=1;
				$data->success=0;
				$data->message="This Pharmacy name or Email-id  already registred";
				$this->load->view('add_pharmacy',$data);
			}
			else
			{
				$data=array(
		                	"name"=>$name,
		                	//"father_name"=>$father_name,
		                	"pharmacy_name"=>$pharmacy_name,
		                	"pharmacy_address"=>$address,
		                	"city"=>$city,
		                	"zipcode"=>$zipcode,
		                	"lat"=>$lat,
		                	"long"=>$long,
		                	//"qualification"=>$qualification,
					 		"mobile_no"=>$mobile_no,
					 		"email_id"=>$email,
							);
	    		$res=$this->pharmacy_model->insert_pharmacy($data);	
		    	if($res!=false)
		    	{
		    		$data= new stdClass();
		    		$data->error=0;
					$data->success=1;
					$data->message="Pharmacy has been registered successfully";
					$this->load->view('add_pharmacy',$data);

		    	}
		    	else
		    	{
		    		$data= new stdClass();
		    		$data->error=1;
					$data->success=0;
					$data->message="Error occur! Pharmacy is not registred";
					$this->load->view('add_pharmacy',$data);
		    	}

			}		
	 	}
	 	else
	 	{
	 		$this->load->view('add_pharmacy');
	 	}
	}

	public function latLong($add,$add1)
    {
    	
        $address = urlencode($add);
        //print_r($addres);
        $geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$address.'&sensor=false');
        $output= json_decode($geocode); //Store values in variable
        //print_r($output);
        if($output->status == 'OK')
        { 
    	    $lat = $output->results[0]->geometry->location->lat; //Returns Latitude
            $long = $output->results[0]->geometry->location->lng; // Returns Longitude
            $latlong=array('latitude' =>$lat ,'longitude'=>$long );
            return $latlong;
            exit;
	     }
        else if($output->status=='ZERO_RESULTS')
        {
        	$address = urlencode($add1);
	        $geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$address.'&sensor=false');
	        $output= json_decode($geocode); //Store values in variabl
	        if($output->status == 'OK')
    		{ 
	    	    $lat = $output->results[0]->geometry->location->lat; //Returns Latitude
	            $long = $output->results[0]->geometry->location->lng;
	            $latlong=array('latitude' =>$lat ,'longitude'=>$long );
            	return $latlong;
				exit;
	        }
  		}
  		else
  		{
  			$data=new stdClass();
  			$data['error']=1;
  			$data['message']="Enter corret address";
  			$this->load->view('add_pharmacy',$data);

  		}
    }

	public function pharmacy_update()
	{
		$id=$_GET['id'];
		$data['pharmacy']=$this->pharmacy_model->get_pharmacy($id);
		$this->load->view('pharmacy_update',$data);

	}

	public function update_pharmacy()
	{
		$data= new stdClass();
		if(isset($_POST['submit']))
		{
			extract($_POST);
			$id=$this->input->post('id');
			$db=$this->pharmacy_model->ispharmacyexitsUpdate($email,$pharmacy_name,$id);
			if($db>0)
			{
				$data->error=1;
				$data->success=0;
				$data->message="This Pharmacy name or Email-id  already registred";
				$data->pharmacy=$this->pharmacy_model->get_pharmacy($id);
				$this->load->view('pharmacy_update',$data);
			}
			else
			{
				$address=$_POST['address'];
				$city=$_POST['city'];
				$zipcode =$_POST['zipcode'];
				$add=$address.' '.$city;
				$add1=$city.''.$zipcode;
				$latlong=$this->latLong($add,$add1);
				$lat=$latlong["latitude"];
	        	$long=$latlong["longitude"];
				$data=array(
						"name"=>$name,
	                	//"father_name"=>$father_name,
	                	"pharmacy_name"=>$pharmacy_name,
	                	"pharmacy_address"=>$address,
	                	"city"=>$city,
	                	"zipcode"=>$zipcode,
	                	"lat"=>$lat,
	                	"long"=>$long,
	                	//"qualification"=>$qualification,
				 		"mobile_no"=>$mobile_no,
				 		"email_id"=>$email		
	 					);
		 		$res=$this->pharmacy_model->update_pharmacy($data,$id);
		 		if($res!=false)
				{
		        	$data= new stdClass();
		        	$data->pharmacy=$this->pharmacy_model->get_pharmacy($id);
			        $data->error=0;
					$data->success=1;
					$data->message="Pharmacy Record has been updated successfully";
					$this->load->view('pharmacy_update',$data);
				}
		   		else
				{
	     			$data= new stdClass();
		        	$data->pharmacy=$this->pharmacy_model->get_pharmacy($id);
			        $data->error=1;
					$data->success=0;
					$data->message="Pharmacy Not update";
					$this->load->view('pharmacy_update',$data);
		    	}
			}
		}
		else
		{
			$this->pharmacy_update();
		}	    		 
	}

	public function delete_pharmacy()
	{
		$data=new stdClass();
		$id=$_GET['id'];
	 	$res=$this->pharmacy_model->delete_pharmacy($id);
	 	if($res!=false)
	 	{
	 		$data=new stdClass();
	 		$data->error=0;
	 		$data->sucess=1;
	 		$data->message="Pharmacy has been deleted successfully!";
			$data->pharmacylist=$this->pharmacy_model->registred_pharmacy();
	 		$this->load->view('pharmacylist',$data);
	    }
	    else
	    {
	    	$data->error=1;
	    	$data->sucess=0;
	    	$data->message="Pharmacy not Deleted!";
			$data->pharmacylist=$this->pharmacy_model->registred_pharmacy();
	 		$this->load->view('pharmacylist',$data);
	    }
	}


	public function all_tablets()
	{
		$id=$_GET['id'];
	 	$res=$this->pharmasist_model->all_tablets($id);
	 	$count=$res->num_rows();
	 	if($count>0)
	 	{
	 		$data = new stdClass();
	 		$data->error=0;
	 		$data->tablets=$res->result();
	 		$this->load->view('all_tablets',$data);
		 }
		 else{
		 	$data= new stdClass();
		 	$data->error=1;
		 	$data->message="No Medicin found";
		 	$this->load->view('all_tablets',$data);
		 }
	}
}