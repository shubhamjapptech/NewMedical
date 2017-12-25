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
		$notification_id =1;
		$this->Notification_model->updateNotification($notification_id);
	}

	public function cron_check()
	{
		$this->Notification_model->check_cron();
	}

	public function checkNotification()
	{
		$customerToken='80630B54AFD65569452DE75CE6811D97D194ABB2CC8E68523D00D13FF65959CD';
		$message = 'chl gya';
		$this->Notification_model->send($customerToken,$message);
	}

	

}