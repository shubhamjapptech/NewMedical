<?php

class notification_Functions 
{

    private $db;
    //put your code here
    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $this->db = new DB_Connect();
        $this->db->connect();
    }

    // destructor
    function __destruct()
    {
        
    }

    public function setNotification($query,$medicine_id)
    {
        $set = "INSERT INTO `notification`(`medicine_id`, `user_id`, `prescription_id`, `notification_type`, `frequency`, `notification_date`, `time`, `time_type`, `notification_status`,`repeatType`,`notification_endDate`) VALUES $query";
        //print_r($set);
        $q = mysql_query($set);
        if($q)
        {
            $u = "UPDATE `prescription_medicine` SET `notification_status`=1 where id='$medicine_id'";
            mysql_query($u);
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function notification_setting($prescription_id,$refill_name,$notification_intervel,$notification_setting)
    {
        $q ="UPDATE `patatent_tablets` SET `notification_intervel`='$notification_intervel', `notification_setting`='$notification_setting' WHERE `prescription_id`='$prescription_id' AND `medicine_name`='$refill_name'";
        //echo $q;
        $up=mysql_query($q);
        if($up)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function sendIosNotification($customerToken,$message)
    {
        $deviceToken = $customerToken;//'0329955742ccbfdb084327f535d3102939eff60b83d90d12b307ed12ed6a0740';
        $ctx = stream_context_create();
        //stream_context_set_option($ctx, 'ssl', 'local_cert','cert/syploDevAPNsCertificates.pem');
        stream_context_set_option($ctx, 'ssl', 'local_cert','APNsDevCertificates.pem');
        stream_context_set_option($ctx, 'ssl', 'passphrase', '123');
        $fp = stream_socket_client(
                'ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
        if (!$fp)
        {
            exit("Failed to connect: $err $errstr" . PHP_EOL);
        }
        else
        {
            $body['aps'] = array(
            'alert' => array(
                'title' => 'Banner',
                'body' => 'Banner',
            ),
            'sound' => 'default'
            );
            $payload = json_encode($body);
            $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
            // Send it to the server
            $result = fwrite($fp, $msg, strlen($msg));

            // Close the connection to the server
            fclose($fp);  
            echo json_encode($result);    
        }
    }        
}

?>