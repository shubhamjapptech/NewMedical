<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends CI_Controller
{
  function __construct() 
  {
    parent::__construct();
    $this->load->model("PrescriptionModel");
    $this->load->model("Prescriptioncheck");
    $this->load->model("Admin_model");
    $this->load->model("User_model");

    $this->load->library('session');
  }
  /*public function index()
  {
      $this->load->view('login');
  }*/
  
  public function index()
  {  
    $data= new stdClass();
    if(isset($_POST['login']))
    //if ($this->input->post('login'))
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
      $res=$this->Admin_model->login($data);
      if($res!=false)
      {
        if($res->status == 'admin')
        { 
          $newdata = array(
          'email'  => $res->email,
          'name'   => $res->name,
          'status' => $res->status,
          'id'     => $res->id,
          'img'    => $res->image,
          'logged_in' => TRUE
          );
          $this->session->set_userdata($newdata);
          //$data['userlist']=$this->Admin_model->registred_user();
          //$data['pharmalist']=$this->Admin_model->registred_pharmasist();   
          //$this->load->view('index',$data);
          $data=new stdClass();
          $table_name ='registration';
          $this->Prescriptioncheck->updatecount($table_name); 
          $data->user_pharmacy=$this->User_model->user_pharmacy();
          $data->userlist=$this->Admin_model->registred_user();     
          $this->load->view('userlist',$data);
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
          $id=$this->session->userdata('id');
          $res=$this->PrescriptionModel->prescriptionimage1($id);
          if($res!=false)
          {
            $pres_images=$this->PrescriptionModel->pres_image1($id);
            $data=new stdClass();
            $data->image=$res;
            $data->pres_image=$pres_images;
            $this->load->view('prescription',$data);
          }
          else
          {
            $data=new stdClass();
            $data->error=1;
            $data->message="No prescription request";
            $this->load->view('prescription',$data);
          }
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
        //$data->userlist=$this->Admin_model->registred_user();
        //$data->pharmalist=$this->Admin_model->registred_pharmasist();
        //$this->load->view('dashboard',$data);               
        $table_name ='registration';
        $this->Prescriptioncheck->updatecount($table_name); 
        $data->user_pharmacy = $this->User_model->user_pharmacy();
        $data->userlist =      $this->Admin_model->registred_user();     
        $this->load->view('userlist',$data);
      }
      else if($this->session->userdata('email') && $this->session->userdata('status')=='pharmacist')
      {
        $id=$this->session->userdata('id');
        $res=$this->PrescriptionModel->prescriptionimage1($id);
        $pres_images=$this->PrescriptionModel->pres_image1($id);
        $data=new stdClass();
        $data->image=$res;
        $data->pres_image=$pres_images;
        $this->load->view('prescription',$data);
      }
      else
      {
        $this->load->view('login');
      }   
    }
  }

  public function logout()
  {
      $data=new stdClass();
      $this->session->sess_destroy();
      $this->load->view('login');
  } 

  public function registred_user()
  {
  $res=$this->Admin_model->registred_user();
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
      $this->form_validation->set_rules('old_password', 'old_password', 'required');
      $this->form_validation->set_message('old_password','required','Please enter old password');
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
            $rr=$this->Admin_model->checkuser($id,$opass);
            if($rr!=false)
            {
              $enpass=md5($password);
              $rr=$this->Admin_model->change_password($enpass,$id);    
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
                $data->error=1;
                $data->success=0;
                $data->id=$id;
                $data->status=$this->session->userdata('status');
                $data->message="Password not update";
                $this->load->view('change_password',$data);
              }
            }
            else
            {
              $data->error=1;
              $data->success=0;
              $data->id=$id;
              $data->status=$this->session->userdata('status');
              $data->message="Error!Old password not found";
              $this->load->view('change_password',$data);
            }
          } 
          else
          {
            $rr=$this->Admin_model->checkpharmacist($id,$opass);
            if($rr!=false)
            {
              $enpass=md5($password);
              $rr=$this->Admin_model->change_pharmacist_password($enpass,$id);    
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
                $data->error=1;
                $data->success=0;
                $data->id=$id;
                $data->status=$this->session->userdata('status');
                $data->message="Password not update";
                $this->load->view('change_password',$data);
              }
            }
            else
            {
              $data->error=1;
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
      if($this->session->userdata('email') == '')
      {
        redirect('admin');
      }
      else
      {
        $data=new stdClass();
        $data->id =$this->session->userdata('id');
        $data->status=$this->session->userdata('status');
        $this->load->view('change_password',$data);
      }
    }   
  }
    public function forget_password()
    {
    if($this->input->post('forget'))
    {
    $email=$this->input->post('email');
    $res=$this->Admin_model->forget_password($email);
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
    $data->message="Please Check your email_id, Confirmation Link send to " .$email;
    $this->load->view('forget_password',$data);
    }
    else
    {
    $data=new stdClass();
    $data->error=1;
    $data->success=0;
    $data->message="Error! This email not found";
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
  $res=$this->Admin_model->recover_password($enpass,$email);
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
  public function recover_pharmacist_password()
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
  $res=$this->Admin_model->recover_pharmacist_password($enpass,$email);
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
  public function recover_userpassword()
  {
  $data=new stdClass();
  $email=$_GET['email'];
  if($this->input->post('recover'))
  {
  extract($_POST);
  if($new_password !=$confirm_password)
  {
  $data->error=1;
  $data->success=0;
  $data->email=$email;
  $data->message="Confirm password not match";
  $this->load->view('recover_userpassword',$data);  
  }
  else
  {
  $enpass= md5($new_password);
  $res= $this->Admin_model->userdetail($email);
  $upass= $new_password;  
  $cp =$res->upass;  
  $user_qbid =$res->qb_id;      
  $res=$this->Admin_model->recover_userpassword($enpass,$upass,$email);
  if($res!=false)
  {
  // user stored successfully
  $this->load->view('layout/createSession.php');
  //$session = createSession(1111, 'AOrewZF7Ap5ysa', 'jyhyu-HZbMZ', 'login', 'password');
  $session = createSession(54310, 'j292Dy8Oyszfak9', '8-XPxGMpCZavUTT',$email,$cp);
  $token = $session->token;
  $request = '{"user": {"old_password":"'.$cp.'","password":"'.$upass.'"}}';
  $ch =
  curl_init('http://api.quickblox.com/users/'.$user_qbid.'.json'); 
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  'Content-Type: application/json',
  'QuickBlox-REST-API-Version: 0.1.0',
  'QB-Token:'.$token
  ));
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $resultJSON = curl_exec($ch);
  $pretty = json_encode(json_decode($resultJSON), JSON_PRETTY_PRINT);
  $d=json_decode($pretty);
  // echo json_encode($d);
  $data->error=0;
  $data->success=1;
  $data->email=$email;
  $data->message="Password Reset successfull";
  $this->load->view('recover_userpassword',$data);
  }
  else
  {
  $data->error=0;
  $data->success=1;
  $data->email=$email;
  $data->message="Password not Reset, Please Try again";
  $this->load->view('recover_userpassword',$data);
  }
  }
  }
  else
  {
  $data->email=$email;
  $this->load->view('recover_userpassword',$data);
  }
  }
  public function admin_profile()
  {
  $data=new stdClass();
  $id =$this->session->userdata('id');
  if($this->input->post('submit'))
  {
  extract($_POST);
  $picture=$_POST['admin_img'];
  if(isset($_FILES['image']['name']) && $_FILES['image']['name']!='')
  {
  $s=$_FILES["image"]["tmp_name"];
  $d="image/".$_FILES["image"]["name"];
  $picture=$_FILES["image"]["name"];
  move_uploaded_file($s,$d);
  }
  $data=array(
  "name"=>$name,
  "mobile"=>$mobile,
  "image"=>$picture     
  );
  $response=$this->Admin_model->update_profile($id,$data);
  if($response!=false)
  {
  $data=new stdClass();
  $res= $this->Admin_model->admin_profile($id);
  $data->admin=$res;
  $newdata = array(
  'email'  => $res->email,
  'name'   => $res->name,
  'status' => $res->status,
  'id'     => $res->id,
  'img'    => $res->image,
  'logged_in' => TRUE
  );
  $this->session->set_userdata($newdata);
  $data->success=1;
  $data->message="Profile Update Sucessfull";
  $this->load->view('admin_profile',$data);
  }
  else
  {
  $data=new stdClass();
  $res= $this->Admin_model->admin_profile($id);
  $data->admin=$res;
  $data->error=1;
  $data->message="Profile Not Update";
  $this->load->view('admin_profile',$data);
  }    
  }
  else
  {
  $data=new stdClass();
  $res= $this->Admin_model->admin_profile($id);
  $data->admin=$res;
  $this->load->view('admin_profile',$data);
  }
  }
  public function eventAction()
  {
  if($this->session->userdata('email') == '')
  {
  redirect('admin');
  }
  else
  {
  $this->load->view('eventAction');  
  }
  }
  public function screenSession()
  {
  if($this->session->userdata('email') == '')
  {
  redirect('admin');
  }
  else
  {
  $this->load->view('screenSession');
  }
  }

  public function analytics()
  {
    $this->load->view('dashboard');
  }
}