<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pharmacist extends CI_Controller 
{
	function __construct() {
        parent::__construct();
        $this->load->model("user_model");
        $this->load->model("admin_model");
		$this->load->model("pharmasist_model");
        if($this->session->userdata('email') == '')
        {
           redirect('admin');
        }
	    }

	 public function index()
	 {
	 	$this->load->view('add_prescription');
	 }

	 public function get_pharmacist()
	 {
		$data=new stdClass();
		$data->pharmalist=$this->pharmasist_model->registred_pharmasist();
	 	$this->load->view('pharmasistlist',$data);
	 }

	 public function add_pharmacist()
	 {
	 	$data= new stdClass();
		if ($this->input->post('submit') && $this->input->post()) 
		{
			extract($_POST);
			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('licenseNumber','License Number','required');
			$this->form_validation->set_rules('phone', 'Phone number', 'required');
			$this->form_validation->set_rules('address','Address','required');	
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('add_pharmasist');
			}
			else
			{
				$email=$_POST['email'];
				$add=$_POST['address'];
				$db=$this->pharmasist_model->ispharmacistexits($email);
				if($db>0)
				{
					$data->error=1;
					$data->success=0;
					$data->message="This email-id  already registred";
					$this->load->view('add_pharmasist',$data);
				}
				else
				{
					//$latlong=$this->latLong($add);
					/*if($latlong["latitude"]=='')
					{
						$data=new stdClass();
			  			$data->error=1;
			  			$data->message="Check your address in google map and fill correct address";
			  			$this->load->view('add_pharmasist',$data);
					}
					else
					{*/
						//$lat=$latlong["latitude"];
	        			//$long=$latlong["longitude"];
	        			$lat='';
	        			$long='';
						$password=$_POST['password'];
						$enpass=md5($password);
						$data=array(
				                	"name"		=>$name,
				                	"licenseNumber" =>$licenseNumber,
							 		"phone"		=>$phone,
							 		"address"	=>$address,
							 		"lat"		=>$lat,
		                			"long"		=>$long,
							 		"email"		=>$email,
							 		"password"	=>$enpass	
									);
			    		$res=$this->pharmasist_model->insert_pharmasist($data);	
				    	if($res!=false)
				    	{
				    		$data= new stdClass();
				    		$data->error=0;
							$data->success=1;
							$data->message="Pharmacist has been added successfully";
							$this->load->view('add_pharmasist',$data);

				    	}
				    	else
				    	{
				    		$data= new stdClass();
				    		$data->error=1;
							$data->success=0;
							$data->message="Error occur!Pharmacist Not added";
							$this->load->view('add_pharmasist',$data);
				    	}	
					/*}*/
				}		
			}
		}
	 	else
	 	{
	 		$this->load->view('add_pharmasist');
	 	}
	}

	public function latLong($add)
    {    	
        $address = urlencode($add);
        //print_r($addres);
        $geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$address.'&sensor=false');
        $output= json_decode($geocode); //Store values in variable
        //print_r($output->results);die;
        if(!empty($output->results))
        { 
    	    $lat = $output->results[0]->geometry->location->lat; //Returns Latitude
            $long = $output->results[0]->geometry->location->lng; // Returns Longitude
            $latlong=array('latitude' =>$lat ,'longitude'=>$long );
            return $latlong;
            exit;
	    }
    	else
  		{
  			$data=new stdClass();
  			$data->error=1;
  			$data->message="Check your address in google map and fill correct address";
  			$this->load->view('add_pharmasist',$data);  			
  		}
    }

	public function update_pharmacist()
	{
		if(isset($_POST['submit']))
		{
			extract($_POST);
			$id=$this->input->post('id');
			$add=$_POST['address'];
			$email=$_POST['email'];
			$db=$this->pharmasist_model->ispharmacistexits($email);
			if($db>1)
			{
				$data=new stdClass();
				$data->error=1;
				$data->success=0;
				$data['pharma']=$this->pharmasist_model->get_pharmasist($id);
				$data->message="This email-id  already registred";
				$this->load->view('pharmasist_update',$data);
			}
			else
			{
				$latlong=$this->latLong($add);
				if($latlong["latitude"]=='')
				{
					$data=new stdClass();
		  			$data->error=1;
		  			$data->pharma=$this->pharmasist_model->get_pharmasist($id);
		  			$data->message="Address not found! Check your address in google map and fill correct address";
		  			$this->load->view('pharmasist_update',$data);
				}
				else
				{
					$lat=$latlong["latitude"];
		        	$long=$latlong["longitude"];
					$data=array(
								"name"		=>$name,
								"licenseNumber" =>$licenseNumber,
								"phone"		=>$phone,
								"address"	=>$address,
								"lat"		=>$lat,
			                	"long"		=>$long	 		
			 					);
				 	$res=$this->pharmasist_model->update_pharmasist($data,$id);
				 	if($res!=false)
			        {
			        	$data= new stdClass();
			        	$data->pharma=$this->pharmasist_model->get_pharmasist($id);
				        $data->error=0;
						$data->success=1;
						$data->message="Pharmacist has been updated successfully";
						$this->load->view('pharmasist_update',$data);
		        	}
			     	else
		     		{
		     			$data= new stdClass();
			        	$data->pharma=$this->pharmasist_model->get_pharmasist($id);
				        $data->error=1;
						$data->success=0;
						$data->message="Error occur! Pharmasist Not updated";
						$this->load->view('pharmasist_update',$data);
		    		}
				}	
			}
		}
		else
		{
			$id=$_GET['id'];
			$data['pharma']=$this->pharmasist_model->get_pharmasist($id);
			$this->load->view('pharmasist_update',$data);
		}	    		 
	}
	
	public function delete_pharmacist()
	{
		$data=new stdClass();
		$id=$_GET['id'];
	 	$res=$this->pharmasist_model->delete_pharmasist($id);
	 	if($res!=false)
	 	{
	 		$data->error=0;
	 		$data->success=1;
	 		$data->message="Pharmacist has been deleted successfully";
	 		$data->pharmalist=$this->pharmasist_model->registred_pharmasist();
	 		$this->load->view('pharmasistlist',$data);
	    }

	    else
	    {
	    	$data->error=1;
	    	$data->success=0;
	    	$data->message="Some error occur! Pharmacist is not deleted";
	    	$data->pharmalist=$this->pharmasist_model->registred_pharmasist();
	 		$this->load->view('pharmasistlist',$data);
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