<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{
	function __construct() {
        parent::__construct();
        $this->load->library("form_validation");
        $this->load->model("PrescriptionModel");
        $this->load->model("admin_model");
        $this->load->library('session');
  }
	
	public function index()
	{
		$this->load->view('login');
	}

	public function logout()
	{
		$data=new stdClass();
		$this->session->sess_destroy();
		$this->load->view('login');
	}

	
	public function login()
  {  
      $data= new stdClass();
      if ($this->input->post('login') && $this->input->post())
      {
        extract($_POST);       
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
         if ($this->form_validation->run() == FALSE)
          {
            $this->load->view('login');
          }
          else
          {
           $email = $this->input->post('email');
           $password = $this->input->post('password');
           $pasword=md5($password);
           $data=array('email' => $email, 'password' =>$pasword);
           $res=$this->admin_model->login($data);
           if($res!=false)
            {
               if($res->status == 'admin')
               { 
                $newdata = array(
                            'email'  => $res->email,
                            'name'   => $res->name,
                            'status' => $res->status,
                            'id'     => $res->id,
                            'logged_in' => TRUE
                          );
               $this->session->set_userdata($newdata);
               $data['userlist']=$this->admin_model->registred_user();
               $data['pharmalist']=$this->admin_model->registred_pharmasist();   
               $this->load->view('index',$data);
               }
                elseif ($res->status == 'pharmacist') 
                {
                  $newdata1 = array(
                                'email'  => $res->email,
                                'name'   => $res->name,
                                'status' => $res->status,
                                'id'     => $res->id,
                                'logged_in' => TRUE
                              );
                  $this->session->set_userdata($newdata1);
                  $res=$this->PrescriptionModel->prescriptionimage();
                  $data=new stdClass();
                  $data->image=$res;
                  $this->load->view('prescription',$data);
                }
            }
            else
            {
              $data['error']=1;
              $data['success']=0;
              $data['message']="Invalid Email And Password";
              $this->load->view('login',$data);
            }
        }
    }
    else
    { 
      if($this->session->userdata('email') && $this->session->userdata('status')=='admin')
      {
           $data->userlist=$this->admin_model->registred_user();
           $data->pharmalist=$this->admin_model->registred_pharmasist();
           $this->load->view('index',$data);               
      }
      else if($this->session->userdata('email') && $this->session->userdata('status')=='pharmacist')
      {
            $res=$this->PrescriptionModel->prescriptionimage();
            $data=new stdClass();
            $data->image=$res;
            $this->load->view('prescription',$data);
      }
      else
      {
            $this->index();
      }   
    }
  } 	

	public function registred_user()
	{
		$res=$this->admin_model->registred_user();
		if($res!=false)
		{
			$this->load->view('index',$res);
		}
		else
		{
			print_r("No Registred User found");
		}
	}

	public function change_password()
  {
    $data=new stdClass();
    if(isset($_POST['submit']))
    {
      $id=$this->input->post('id');
      $status=$this->input->post('status');
      $old_password=$this->input->post('old_password');
      $opass=md5($old_password);
      $password=$this->input->post('password');
      $confirm_password=$this->input->post('confirm_password');
      $this->form_validation->set_rules('old_password', 'Old password', 'required');
      $this->form_validation->set_rules('password', 'password', 'required');
      $this->form_validation->set_rules('confirm_password','confirm_password','required');
      if ($this->form_validation->run() == FALSE)
        {
          $data->id=$id;
          $data->status=$this->session->userdata('status');
          $this->load->view('change_password',$data);
        }
      else
        {
          if($password !=$confirm_password)
            {
                $data->error=1;
                $data->success=0;
                $data->id=$id;
                $data->status=$this->session->userdata('status');
                $data->message="Confirm password not match";
                $this->load->view('change_password',$data);  
            }
          else
            {
              if($status=='admin')
              {
                $rr=$this->admin_model->checkuser($id,$opass);
                if($rr!=false)
                {
                    $enpass=md5($password);
                    $rr=$this->admin_model->change_password($enpass,$id);    
                    if($rr!=false)
                    {
                        $data->error=0;
                        $data->success=1;
                        $data->id=$id;
                        $data->status=$this->session->userdata('status');
                        $data->message="Password update successfull";
                        $this->load->view('change_password',$data);
                    }
                    else
                    {
                        $data->error=2;
                        $data->success=0;
                        $data->id=$id;
                        $data->status=$this->session->userdata('status');
                        $data->message="Password not update";
                        $this->load->view('change_password',$data);
                    }
                }
                else
                {
                  $data->error=3;
                  $data->success=0;
                  $data->id=$id;
                  $data->status=$this->session->userdata('status');
                  $data->message="Error!Old password not found";
                  $this->load->view('change_password',$data);
                }
            } 
            else
            {
                $rr=$this->admin_model->checkpharmacist($id,$opass);
                if($rr!=false)
                {
                    $enpass=md5($password);
                    $rr=$this->admin_model->change_pharmacist_password($enpass,$id);    
                    if($rr!=false)
                    {
                        $data->error=0;
                        $data->success=1;
                        $data->id=$id;
                        $data->status=$this->session->userdata('status');
                        $data->message="Password update successfull";
                        $this->load->view('change_password',$data);
                    }
                    else
                    {
                        $data->error=2;
                        $data->success=0;
                        $data->id=$id;
                        $data->status=$this->session->userdata('status');
                        $data->message="Password not update";
                        $this->load->view('change_password',$data);
                    }
                }
                else
                {
                  $data->error=3;
                  $data->success=0;
                  $data->id=$id;
                  $data->status=$this->session->userdata('status');
                  $data->message="Error!Old password not found";
                  $this->load->view('change_password',$data);
                }
            } 
        }
      }
    }
    else
    {
            $data=new stdClass();
            $data->id =$this->session->userdata('id');
            $data->status=$this->session->userdata('status');
            $this->load->view('change_password',$data);
    }   
  }
  public function forget_password()
  {
    if($this->input->post('forget'))
    {
      $email=$this->input->post('email');
      $res=$this->admin_model->forget_password($email);
      if($res=='fail')
      {
          $data=new stdClass();
          $data->error=1;
          $data->success=0;
          $data->message="Error!Email not send try again";
          $this->load->view('forget_password',$data);
      }
      else if($res=='success')
      {
          $data=new stdClass();
          $data->error=0;
          $data->success=1;
          $data->message="Please Check your email_id, Confirmation Link send to" .$email;
          $this->load->view('forget_password',$data);
      }
      else
       {
          $data=new stdClass();
          $data->error=1;
          $data->success=0;
          $data->message="Error!This email not found";
          $this->load->view('forget_password',$data);
      }
    }
    else
    {
      $this->load->view('forget_password');  
    }  
  }

  public function recover_password()
  {
      $data=new stdClass();
      $email=$_GET['email'];
      if($this->input->post('change'))
      {
        extract($_POST);
        if($new_password !=$confirm_password)
            {
                $data->error=1;
                $data->success=0;
                $data->email=$email;
                $data->message="Confirm password not match";
                $this->load->view('recover_password',$data);  
            }
          else
            {
                $enpass= md5($new_password);
                $res=$this->admin_model->recover_password($enpass,$email);
                if($res!=false)
                {
                  $data->error=0;
                  $data->success=1;
                  $data->email=$email;
                  $data->message="Password update successfull";
                  $this->load->view('recover_password',$data);
                }
                else
                {
                  $data->error=0;
                  $data->success=1;
                  $data->email=$email;
                  $data->message="Password not update, Please Try again";
                  $this->load->view('recover_password',$data);
                }
            }
      }
      else
      {
        $data->email=$email;
        $this->load->view('recover_password',$data);
      }

  }
}
