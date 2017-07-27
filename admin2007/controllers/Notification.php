<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Notification extends CI_Controller {
	function __construct() 
	{
        parent::__construct();
        $this->load->model("Notification_model");
	}

	/**  Cron job to send notification of medicine**/
	public function index()
	{
		$this->Notification_model->sendNotification();
	}	

	public function update_notification()
	{
		
	}

	public function check_notification()
	{
		$this->Notification_model->check_cron();
	}
}