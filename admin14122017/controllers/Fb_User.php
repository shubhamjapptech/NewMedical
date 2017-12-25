<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Fb_User extends CI_Controller
{
    function __construct() {
		parent::__construct();
		// Load user model		
		$this->load->library('session');
		$this->load->model('user');
		$this->load->model("PrescriptionModel");
        $this->load->model("admin_model");
    }
    
    public function index(){
		// Include the facebook api php libraries
		include_once APPPATH."libraries/facebook-api-php-codexworld/facebook.php";	
		// Facebook API Configuration
		$appId = '248122518964382';
		$appSecret = '783ce2dd9844971cfe675ba7c451fde9';
		$redirectUrl = site_url() . '/Fb_User/';
		$fbPermissions = 'email';
		//Call Facebook API
		$facebook = new Facebook(array(
		  'appId'  => $appId,
		  'secret' => $appSecret	
		));
		$fbuser = $facebook->getUser();
        if ($fbuser) {
			$userProfile = $facebook->api('/me?fields=id,first_name,last_name,email,gender,locale,picture');
            // Preparing data for database insertion
			$userData['oauth_provider'] = 'facebook';
			$userData['oauth_uid'] = $userProfile['id'];
            $userData['first_name'] = $userProfile['first_name'];
            $userData['last_name'] = $userProfile['last_name'];
            $userData['email'] = $userProfile['email'];
			$userData['gender'] = $userProfile['gender'];
			$userData['locale'] = $userProfile['locale'];
            $userData['profile_url'] = 'https://www.facebook.com/'.$userProfile['id'];
            $userData['picture_url'] = $userProfile['picture']['data']['url'];
			// Insert or update user data
            $userID = $this->user->checkUser($userData);
            if(!empty($userID)){
				$newdata['userData'] = $userData;
				$newdata['email']  = $userData['email'];
				$newdata['name']   = $userData['first_name'];
				$newdata['status'] = $userData['locale'];
				$newdata['id']     = $userData['oauth_uid'];
				$newdata['img']    = $userData['profile_url'];
				$newdata['logged_in'] =TRUE;
               $this->session->set_userdata($newdata);
               $data['userlist']=$this->admin_model->registred_user();
               $data['pharmalist']=$this->admin_model->registred_pharmasist();
               $this->load->view('index',$data); 
                //$this->session->set_userdata('userData',$userData);
            } else {
               $data['userData'] = array();
            }
        } else {
			$fbuser = '';
            $data['authUrl'] = $facebook->getLoginUrl(array('redirect_uri'=>$redirectUrl,'scope'=>$fbPermissions));
        }
		$this->load->view('fblogin',$data);
    }
	
	public function logout() {
		$this->session->unset_userdata('userData');
        $this->session->sess_destroy();
		$this->load->view('login');
    }
}
