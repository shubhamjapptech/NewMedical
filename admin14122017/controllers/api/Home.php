<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller
{
  function __construct() 
  {
    parent::__construct();
    $this->load->model("apiModel/Home_model");
  }

  public function index()
  {
    if (isset($_POST['tag']) && $_POST['tag'] != '' && isset($_POST['user_type']) && $_POST['user_type']!='')
    {
      $tag = $_POST['tag'];
      $respons = array("tag" => $tag, "success" => 0, "error" => 0);
      if ($tag == 'login')
      {
        $user_type    = $_POST['user_type'];
        $fb_id        = $_POST['fb_id'];
        $devicetoken  = $_POST['devicetoken'];
        $email        = $_POST['email'];
        $password     = $_POST['password'];
        $pasword      = md5($password);
        if($user_type==1)
        {
          $user = $this->Home_model->loginViaFb($fb_id,$email,$user_type,$devicetoken);
          $this->Home_model->updatetokenViaFb($devicetoken,$fb_id);   
        }

        else
        {     
          $this->Home_model->updatetoken($devicetoken,$email);    //Update device Token;
          $user = $this->Home_model->getUserByEmailAndPassword($email, $pasword); 
        }
        //print_r($user);die();
        if ($user != false)
        {
          //echo json_encode($user);die();
          /********************************** Qb Login Start *********************************/
          DEFINE('APPLICATION_ID', 60993);
          DEFINE('AUTH_KEY', "zrUP8-PrfrCfNT9");
          DEFINE('AUTH_SECRET', "V2sbb4W6-RXtzKt");  
          // User credentials
          // DEFINE('USER_LOGIN', "shubhamj");
          // DEFINE('USER_PASSWORD',"9889520019");
          DEFINE('USER_LOGIN', "repillrx@gmail.com");
          DEFINE('USER_PASSWORD',"12345678");   
          // Quickblox endpoints
          DEFINE('QB_API_ENDPOINT', "https://api.quickblox.com");
          DEFINE('QB_PATH_SESSION', "session.json");
          // Generate signature
          $nonce = rand();
          $timestamp = time(); // time() method must return current timestamp in UTC but seems like hi is return timestamp in current time zone
          $signature_string = "application_id=".APPLICATION_ID."&auth_key=".AUTH_KEY."&nonce=".$nonce."&timestamp=".$timestamp."&user[login]=".USER_LOGIN."&user[password]=".USER_PASSWORD;
          $signature = hash_hmac('sha1', $signature_string , AUTH_SECRET);
          $post_body = http_build_query(array(
          'application_id' => APPLICATION_ID,
          'auth_key' => AUTH_KEY,
          'timestamp' => $timestamp,
          'nonce' => $nonce,
          'signature' => $signature,
          'user[login]' => USER_LOGIN,
          'user[password]' => USER_PASSWORD
          ));
          $curl = curl_init();
          curl_setopt($curl, CURLOPT_URL, QB_API_ENDPOINT . '/' . QB_PATH_SESSION); // Full path is - https://api.quickblox.com/session.json
          curl_setopt($curl, CURLOPT_POST, true); // Use POST
          curl_setopt($curl, CURLOPT_POSTFIELDS, $post_body); // Setup post body
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Receive server response
          // Execute request and read response
          //********** Handel for SSL ceritifacte error *******//
          curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
          //********** Handel for SSL ceritifacte error End *******//
          $response = curl_exec($curl);
          $qb="";
          // Check errors
          if ($response)
          {
            $qb=json_decode($response);
          }
          else
          {
            $error = curl_error($curl). '(' .curl_errno($curl). ')';
            $qb= json_decode($error);
          //echo $error . "\n";
          }
          // Close connection
          curl_close($curl);
          /********************************** Qb Login End ***********************************/
          $admin=$this->Home_model->admin_data();
          //echo json_encode($admin);die();
          $id =$user->id;
          $pres_status=$this->Home_model->prescription_count($id);
          $pharmacy_detail = $this->Home_model->pharmacy_details($id);
          if($pharmacy_detail=='')
          {
            $pharmacy_detail = '';
          }
          $respons["success"] = 1;
          $respons["token"] = $user->uniq_id;
          $respons["admin_image"]= base_url().'image/'.$admin->image;
          $respons["admin_name"] = $admin->name;
          $respons["user"]["token"] = $user->uniq_id;
          $respons["user"]["devucetoken"] = $user->device_token;
          $respons["user"]["fb_id"] = $user->fb_id;
          $respons["user"]["user_type"] = $user->user_type; 
          $respons["user"]["pres_status"] = $pres_status;   
          $respons["user"]["user_id"] = $user->id;
          $respons["user"]["user_qbid"]=$user->qb_id;
          $respons["user"]["user_password"]=$user->upass; 
          $respons["user"]["first_name"] = $user->first_name;
          $respons["user"]["last_name"] = $user->last_name;
          $respons["user"]["mobile"] = $user->phone;    
          $respons["user"]["email"]=$user->email;
          if($user->image_type==0)
          {
          $image = base_url().'/image/'.$user->image;
          } 
          else
          {
          $image = $user->image;
          }
          // $image=base_url.'medical/image/'.$user["image"];
          $respons["user"]["image"]      = $image;
          $respons["user"]["image_type"] = $user->image_type;
          $respons["user"]["gender"]     = $user->gender;
          // $respons["user"]["zipcode"]=$user["zipcode"];
          $respons["user"]["created_at"] = $user->timestamp;
          $respons["user"]["pharmacy_detail"] =$pharmacy_detail;
          $respons["QbDetail"]["password"]=$user->password;
          $respons["QbDetail"]["admin_user"]=$qb;
          //$response["user"]["updated_at"] = $user["update_at"];
          echo json_encode($respons);
        } 
        else
        {
          $respons["error"] = 2;
          $respons["error_msg"] = "Incorrect email or password!";
          echo json_encode($respons);
        }
      } 
      else 
      {
        $respons["error"] = 4;
        $respons["error_msg"] = "Access denied";
        echo json_encode($respons);
      }
    } 
    else 
    {
      $respons["error"] = 3;
      $respons["error_msg"] = "Access denied";
      echo json_encode($respons);
    }
  }

  public function createSession()
  {
    $USER_LOGIN     = "repillrx";
    $USER_PASSWORD  = "Icenut77!";
    $this->load->view('layout/createSession.php');
    //$session = createSession(1111, 'AOrewZF7Ap5ysa', 'jyhyu-HZbMZ', 'login', 'password');
    $session = createSession(60993, 'zrUP8-PrfrCfNT9', 'V2sbb4W6-RXtzKt',$USER_LOGIN,$USER_PASSWORD);
    $QbSessiontoken = $session->token;
    //print_r($token);die();
    return $QbSessiontoken;
  }

  public function signup()
  {
    if (isset($_POST['tag']) && $_POST['tag'] != '')
    {
      $tag = $_POST['tag'];
      $response = array("tag" => $tag, "success" => 0, "error" => 0);
      if ($tag == 'signup')
      {
        $devicetoken = $_POST['devicetoken'];
        $fb_id     = $_POST['fb_id']; 
        $user_type   = $_POST['user_type']; //0=normal, 1=fbLogin
        $fname     = $_POST['first_name'];
        $lname     = $_POST['last_name'];
        // $zipcode  = $_POST["zipcode"];     
        $mobile    = $_POST['mobile_no'];
        $email     = $_POST['email'];
        $password    = $_POST['password'];
        $cpassword   = $_POST['confirm_password'];
        $fb_image    = $_POST['fb_image'];
        $image_type  = $_POST['image_type'];    //0=simple, 1= fb;
        $pharmacy_name =''; $city=''; $cross_street='';
        if(isset($_POST['pharmacy_name']) && $_POST['pharmacy_name']!='')
        {
          $pharmacy_name = $_POST['pharmacy_name'];
          $city        = $_POST['city'];
          $cross_street  = $_POST['cross_street'];
          $contactNo     = $_POST['contactNo'];
        }
        $plength=strlen($password);
        if($plength<8)
        {
          $response["error"]=3;
          $response["error_msg"]="Password length must be greater then 7";
          echo json_encode($response);
        }
        else
        {
          if($password==$cpassword)
          {
            $enpass=md5($password);
            if($this->Home_model->isUserExisted($email))
            {
            $response["error"] = 2;
            $response["error_msg"] = "User already existed";
            echo json_encode($response);
            } 
            else 
            {
              /*if($db->ispharmaciesExisted($zipcode))
              {
              $response['error']=3;
              $response['error_msg']="Sorry! Repill does not have any pharmacist in your area";
              }*/
              $ss='default1.jpg';
              $uuid =$this->Home_model->radomno();
              if(isset($_FILES["img"])!='')
              {
                $s=$_FILES["img"]["tmp_name"];
                //$ss=$fname.$_FILES["img"]["name"];
                $image=$uuid.$_FILES['img']['name'];
                $ss = preg_replace('/\s*/m', '',$image);
                $d='image/'.$ss;
                move_uploaded_file($s,$d);
              }
              if($fb_image!='' && $image_type==1)
              {
                $ss = $fb_image;
              }

              // $userDetails = $db->storeUser($devicetoken,$fname,$lname,$zipcode,$mobile,$email,$password,$enpass,$ss);
              $userDetails = $this->Home_model->storeUser($devicetoken,$fb_id,$user_type,$fname,$lname,$mobile,$email,$password,$enpass,$ss,$image_type);
              if ($userDetails)
              {
                $userid=$userDetails->id;
                $pharmacy_detail='';
                if($pharmacy_name!=''&& $city!='')
                {
                  $pharmacy_detail=$this->Home_model->StoreUserPharmacy($userid,$pharmacy_name,$city,$cross_street,$contactNo);
                }
                // user stored successfully
                /*******QB User Register*******/
                $quickbox_api_url = "https://api.quickblox.com";
                $Sessiontoken = $this->createSession();
                //print_r($token);
                $post_body = http_build_query(array(
                'user[login]' => $email,
                'user[password]' => $password,
                'user[email]' => $email,
                'user[external_user_id]' => "",
                'user[facebook_id]' => '',
                'user[twitter_id]' => '',
                'user[full_name]' => $fname.' '.$lname,
                'user[phone]' => $mobile
                ));
                $url = $quickbox_api_url . "/users.json";
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url); // Full path is - https://api.quickblox.com/session.json
                curl_setopt($curl, CURLOPT_POST, true); // Use POST
                curl_setopt($curl, CURLOPT_POSTFIELDS, $post_body); // Setup post body
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('QB-Token: ' . $Sessiontoken));
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                // Execute request and read response
                $qbresponse = curl_exec($curl);
                curl_close($curl);
                $qbresponse = json_decode($qbresponse, TRUE);
                //print_r($qbresponse);
                $quickblock_id = $qbresponse['user']['id'];   
                //$userid=$userDetails["id"];
                $this->Home_model->update_qbId($userid,$quickblock_id);                     
                //echo $pretty;
                /*******QB User Register*******/
                $pres_status=$this->Home_model->prescription_count($userid);
                $admin=$this->Home_model->admin_data();
                $response["success"] = 1;
                $response["token"] = $userDetails->uniq_id;
                $response["devicetoken"]=$userDetails->device_token;
                $response["admin_image"]=base_url().'image/'.$admin->image;
                $response["admin_name"] =$admin->name;
                $response["user1"]["pres_status"] = $pres_status;
                $respons["user"]["fb_id"] = $userDetails->fb_id;
                $respons["user"]["user_type"] = $userDetails->user_type;
                $response["user1"]["user_id"] = $userDetails->id;
                $response["user1"]["user_qbid"]=$quickblock_id;
                $response["user1"]["user_password"] =$userDetails->upass;
                $response["user1"]["First_name"] = $userDetails->first_name;
                $response["user1"]["last_name"] = $userDetails->last_name;
                $response["user1"]["mobileNo"] = $userDetails->phone;
                // $response["user1"]["zipcode"] = $userDetails["zipcode"];
                if($userDetails->image_type==0)
                {
                $image = base_url().'image/'.$userDetails->image;
                } 
                else
                {
                $image = $userDetails->image;
                }
                $response["user1"]["image"] = $image;
                $response["user1"]["image_type"] = $userDetails->image_type;
                $response["user1"]["email"] = $userDetails->email;
                $response["user1"]["created_at"] = $userDetails->timestamp;
                $response["user1"]["pharmacy_detail"] =$pharmacy_detail;
                // $response["QbDetail"]["admin_id"]="22363083";
                $response["QbDetail"]["admin_id"]  = "32625198";
                $response["QbDetail"]["password"]  =$userDetails->password;
                $response["QbDetail"]["admin_user"]=$qbresponse;
                echo json_encode($response);
              } 
              else 
              {
                $response["error"] = 1;
                $response["error_msg"] = "Not Registred! Some Error Occured";
                echo json_encode($response);
              }
            }
          }
          else
          {
            $msg["error"]=1;
            $msg["msg"]="Password does not match";
            echo json_encode($msg);
          } 
        }
      } 
      else
      {
        $msg["error"]=2;
        $msg["msg"]="Access Denied";
        echo json_encode($msg);
      }
    } 
    else
    {
      $msg["error"]=3;
      $msg["msg"]="Access Denied";
      echo json_encode($msg);
    }
  }


  public function update()
  {
    if (isset($_POST['tag']) && $_POST['tag'] !='') 
    {
      $tag = $_POST['tag'];
      $respons = array("tag" => $tag, "success" => 0, "error" => 0);
      if ($tag == 'update') 
      {
        $token = $_POST['token'];
        $image="";
        $check=$this->Home_model->checkuser($token);
        if($check!=false)
        {
          $as = $this->Home_model->userData($token);
          $first_name  = $as->first_name;
          $last_name   = $as->last_name;
          $mobile      = $as->phone;
          $gender      = $as->gender;
          $address     = $as->address;  
         // $zipcode     = $as["zipcode"];
          $image       = $as->image;
          $image_type  = $as->image_type;
          extract($_POST);
          if(isset($_FILES["img"]["name"]) && $_FILES["img"]["name"]!='')
          {
            // $imge="app.repillrx.com/app.repillrx.com/NewMedical/medical/image/".$as['image'];
            if($image!='default1.jpg'){unlink("image/".$image);}
            $uuid=$this->Home_model->radomno(); 
            $s=$_FILES["img"]["tmp_name"];
            //$ss=$fname.$_FILES["img"]["name"];
            $ss=$uuid.$_FILES['img']['name'];
            $image = preg_replace('/\s*/m', '',$ss);
            $d="image/".$image;
            move_uploaded_file($s,$d);
          }          
          $updateAt = date('Y-m-d H:i:s');
          $Updatedata = array(
            "first_name"  =>$first_name,
            "last_name"   =>$last_name,
            "phone"       =>$mobile,
            "gender"      =>$gender,
            "image"       =>$image,
            "image_type"  =>$image_type,
            "address"     =>$address,
            "updateAt"    =>$updateAt
            );
          //print_r($Updatedata);die();
          $userDetails = $this->Home_model->updateUser($token,$Updatedata);

          if(!empty($userDetails))
          {
              $admin      = $this->Home_model->admin_data();
              //$as         = mysql_fetch_assoc($q);
              $user_id    = $userDetails->id;
              $pres_status= $this->Home_model->prescription_count($user_id);
              $pharmacy_detail = $this->Home_model->pharmacy_details($user_id);
              if(empty($pharmacy_detail))
              {
                $pharmacy_detail='';
              }
              $respons['success']             = 1;
              $respons['message']             = "Update Sucess";
              $respons["token"]               = $userDetails->uniq_id;
              $respons["devicetoken"]         = $userDetails->device_token;
              $respons["admin_image"]         = base_url().'image/'.$admin->image;
              $respons["user"]["pres_status"] = $pres_status;
              $respons["user"]["user_id"]     = $userDetails->id;
              $respons["user"]["user_qbid"]   = $userDetails->qb_id;
              $respons['user']['first_name']  = $userDetails->first_name;
              $respons['user']['last_name']   = $userDetails->last_name;
              $respons['user']['mobileNo']    = $userDetails->phone;
              $respons['user']['email']       = $userDetails->email;
              if($userDetails->image_type==0)
              {
                $image=base_url()."image/".$userDetails->image;
              } 
              else
              {
                $image = $userDetails->image;
              }           
              $respons['user']['image']       = $image;
              $respons['user']['image_type']  = $userDetails->image_type;
              $respons['user']['gender']      = $userDetails->gender;
              $respons['user']['address']     = $userDetails->address;
              $respons["user"]["pharmacy_detail"] =$pharmacy_detail;
              $respons["QbDetail"]["admin_id"] = "32625198";
              $respons["QbDetail"]["password"] = $userDetails->password;
              // $respons['user']['zipcode']=$as['zipcode'];
              echo json_encode($respons);
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
        $respons['error']=3;
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
  }

  public function pharmacy_list()
  {
    if(isset($_POST['zipcode']))
    {
      $response = array("success" => 0, "error" => 0);
      $pharmacy = $this->Home_model->pharmacy_list();
      if(!empty($pharmacy))
      {
        $response["success"]=1;
        $response["message"]="success";
        $response["data"]=$pharmacy;
        echo json_encode($response);
      }
      else
      {
        $response["error"]=1;
        $response["message"]="No pharmacy available";
        $response["data"]=[];
        echo json_encode($response);
      }
    }
    else
    {
      $response["error"]=2;
      $response["message"]="Access Denied";
      echo json_encode($response);
    }
  }

  public function updatePharmacy()
  {
    if(isset($_POST['user_id']) && $_POST['user_id']!='')
    {
      $response = array("success" => 0, "error" => 0);
      $user_id       = $_POST['user_id'];
      $pharmacy_name = $_POST['pharmacy_name'];
      $city          = $_POST['city'];
      $cross_street  = $_POST['cross_street'];
      $contactNo     = $_POST['contactNo']; 
      $pharmacy      = $this->Home_model->pharmacy_details($user_id);
      if(!empty($pharmacy))
      {
        $update_at  = date('Y-m-d H:i:s');
        $pData = array(
          'pharmacy_name'=>$pharmacy_name,
          'city'=>$city,
          'cross_street'=>$cross_street,
          'update_at'=>$update_at,
          'contactNo'=>$contactNo
          );
        if($pharmacy_detail= $this->Home_model->updateUserPharmacy($user_id,$pData))
        {
          $response['success']=2;
          $response['message']="Success"; 
              $response["user"]["pharmacy_detail"] =$pharmacy_detail;
              echo json_encode($response);
        }
        else
        {
          $response['error']=2;
          $response['message']="error occur"; 
              $response["user"]["pharmacy_detail"] ='';
              echo json_encode($response);
        }
      }

      else
      {
        if($this->Home_model->StoreUserPharmacy($user_id,$pharmacy_name,$city,$cross_street,$contactNo))
        {
          $pharmacy_detail     = $this->Home_model->pharmacy_details($user_id);
          $response['success']=2;
          $response['message']="Success"; 
          $response["user"]["pharmacy_detail"] =$pharmacy_detail;
          echo json_encode($response);
        }
        else
        {
          $response['error']=2;
          $response['message']="error occur"; 
          $response["user"]["pharmacy_detail"] ='';
          echo json_encode($response);
        }
      }
    }
    else
    {
      $response['error']=3;
      $response['message']="Access Denied";
      echo json_encode($response);
    }

  }
  public function userDetail()
  {
    $response = array("success" => 0, "error" => 0);
    if (isset($_POST['user_id']) && $_POST['user_id'] != '')
    { 
      $user_id = $_POST['user_id'];
      $user = $this->Home_model->user_details($user_id);
      if(!empty($user))
      {
        $admin= $this->Home_model->admin_data();
          $pres_status=$this->Home_model->prescription_count($user_id);
          $pharmacy_detail= $this->Home_model->pharmacy_details($user_id);
          if(empty($pharmacy_detail))
          {
            $pharmacy_detail='';
          }
          $response["success"]  = 1;
        $response["token"]    = $user["uniq_id"];
        $response["devicetoken"]=$user["device_token"];
        $response["admin_image"]=base_url().'image/'.$admin->image;
        $response["user1"]["pres_status"] = $pres_status;
        $response["user1"]["user_id"] = $user["id"];
        // $response["user1"]["user_qbid"]=$qb_id;
        $response["user1"]["user_password"] =$user["upass"];
        $response["user1"]["First_name"] = $user["first_name"].' '.$user["last_name"];
        $response["user1"]["last_name"] = $user["last_name"];
        $response["user1"]["mobileNo"] = $user["phone"];
        if($user['image_type']==0)
        {
          $image = base_url().'image/'.$user["image"];
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
        $response["QbDetail"]["admin_id"]="32625198";
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
      $response['error']=3;
      $response['message']="Access Denied";
      echo json_encode($response);
    } 
  }

  public function forget_password()
  {
    if (isset($_POST['tag']) && $_POST['tag'] != '') 
    {
      $tag = $_POST['tag'];
      $response = array("tag" => $tag, "success" => 0, "error" => 0);
      if ($tag == 'forget' && isset($_POST['email'])!='')
      {
        $email=$_POST['email'];
        $confirm=$this->Home_model->forget_password($email);
        if($confirm!=FALSE)
        {
          $response['message']="Email send to your id";
          $response['Email ']= $email;
          echo json_encode($response);
          exit;
        }
        else
        {
          $response['error'] =1;
          $response['message']="Error occur during mail";
          echo json_encode($response);
          exit;
        }
      }
      else
      {
        $response['error']   = 2;
        $response["message"] = "!please enter email id";
        echo json_encode($r);
      }
    }
    else
    {
      $response['error']=3;
      $response['message']="Access Denied";
      echo json_encode($response);
    }
  }

  public function change_password()
  {
    if (isset($_POST['tag']) && $_POST['tag'] != '') 
    {
      $tag = $_POST['tag'];      
      $response = array("tag" => $tag, "success" => 0, "error" => 0);
      if ($tag == 'change_password')
      {
        $usertoken  = $_POST['token'];
        $cp     = $_POST['current_password'];
        $new_p    = $_POST['new_password'];
        $qbpass   = $_POST['new_password'];
        $cpassword  = $_POST['confirm_password'];
        $email    = $_POST['email'];
        $user_qbid  = $_POST['user_qbid'];
        $enpass   = md5($cp);
        if($this->Home_model->checkuserPassword($usertoken,$enpass))
        {
          if($new_p==$cpassword)
          {
            $new_p=md5($new_p);     
            $user = $this->Home_model->change_password($usertoken,$new_p,$qbpass);
            if($user)
            {
              /*-------------------Change in Qb account-------------------------------*/
               $this->load->view('layout/createSession.php');
                  //$session = createSession(1111, 'AOrewZF7Ap5ysa', 'jyhyu-HZbMZ', 'login', 'password');
                 //$session = createSession(54310, 'j292Dy8Oyszfak9', '8-XPxGMpCZavUTT',$email,$cp);
                 $session = createSession(60993, 'zrUP8-PrfrCfNT9', 'V2sbb4W6-RXtzKt',$email,$cp);
                 $token = $session->token;
                  //print_r($token);*/
                 $request = '{"user": {"old_password":"'.$cp.'","password":"'.$qbpass.'"}}';
              $ch =
              curl_init('https://api.quickblox.com/users/'.$user_qbid.'.json'); 
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
              /*-------------------Change in Qb account end-------------------------*/
              $response["success"] = 1;
              $response["Message"] = "Password Change success";
              $response["token"]   = $usertoken ;
              $response["UpdateAt"]= '';
              $response["qbdetails"]=$d;
              echo json_encode($response);
            }
            else 
            {
              $response["success"] = 0;
              $response["error"] = 1;
              $response["error_msg"] = "Password not change! Some Error Occured";
              echo json_encode($response);
            }
          }
          else
          {
            $response["error"]=1;
            $response["message"] ="New password and Confirm password must be same";
            echo json_encode($response);
          }
        }
        else
        {

          $response["error"]=1;
          $response["msg"]="This Password or token not found! Please Enter correct Details";
          echo json_encode($response);
        }
      }
      else
      {
        $response["error"]=1;
        $response["msg"]="Access Denied";
        echo json_encode($msg);
      }
    }
  }

  public function AdminData()
  {
    if (isset($_REQUEST['tag']) && $_REQUEST['tag']=='admin') 
    {
      
      $response = array("success" => 0, "error" => 0);
      $admin=$this->Home_model->admin_data();
      $response["success"]=1;
      $response["message"]="success";
      $response['data']=$admin;
      echo json_encode($response);
    }
    else
    {
      $response["error"]=1;
      $response["message"]="Access Denied";
      $response['data']='';
      echo json_encode($response);
    }
  }



  
  
   





}