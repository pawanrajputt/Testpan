<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_model extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }

    function notify_email($task = '' , $param2 = '' , $param3 = '' , $param4 = '' , $param5 = '')
    {
    	$email_sub		=	$this->db->get_where('email_template' , array('task' => $task))->row()->subject;
    	$email_msg		=	$this->db->get_where('email_template' , array('task' => $task))->row()->body;

    	// email notification for rest password
        if ($task == 'password_reset_confirmation')
        {

            $account_type   =   $param2;
            $email          =   $param3;
            $NEW_PASSWORD   =   $param4;
            $NAME           =   $this->db->get_where($account_type , array('email' => $email))->row()->name;
            $SYSTEM_URL     =    base_url();

            $email_msg      =   str_replace('[NAME]' , $NAME , $email_msg);
            $email_msg      =   str_replace('[NEW_PASSWORD]' , $NEW_PASSWORD , $email_msg);
            $email_msg      =   str_replace('[SYSTEM_URL]' , $SYSTEM_URL , $email_msg);

            $email_to       =   $email;
        }


    	$this->do_email($email_msg , $email_sub , $email_to);
    }


	function account_opening_email($account_type = '' , $email = '')
	{
		$system_name	=	$this->db->get_where('settings' , array('type' => 'system_name'))->row()->description;
		
		$email_msg		=	"Welcome to ".$system_name."<br />";
		$email_msg		.=	"Your account type : ".$account_type."<br />";
		$email_msg		.=	"Your login password : ".$this->db->get_where($account_type , array('email' => $email))->row()->password."<br />";
		$email_msg		.=	"Login Here : ".base_url()."<br />";
		
		$email_sub		=	"Account opening email";
		$email_to		=	$email;
		
		$this->do_email($email_msg , $email_sub , $email_to);
	}
	
	function password_reset_email($account_type = '' , $email = '')
	{
		$query			=	$this->db->get_where($account_type , array('email' => $email));
		if($query->num_rows() > 0)
		{
			$password	=	$query->row()->password;
			$email_msg	=	"Your account type is : ".$account_type."<br />";
			$email_msg	.=	"Your password is : ".$password."<br />";
			
			$email_sub	=	"Password reset request";
			$email_to	=	$email;
			$this->do_email($email_msg , $email_sub , $email_to);
			return true;
		}
		else
		{	
			return false;
		}
	}
	
	/***custom email sender****/
	function do_email($msg=NULL, $sub=NULL, $to=NULL, $from=NULL)
	{
		
		$config = array();
        $config['useragent']	= "CodeIgniter";
        $config['mailpath']		= "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
        $config['protocol']		= "smtp";
        $config['smtp_host']	= "localhost";
        $config['smtp_port']	= "25";
        $config['mailtype']		= 'html';
        $config['charset']		= 'utf-8';
        $config['newline']		= "\r\n";
        $config['wordwrap']		= TRUE;

        $this->load->library('email');

        $this->email->initialize($config);

		$system_name	=	$this->db->get_where('settings' , array('type' => 'system_name'))->row()->description;
		if($from == NULL)
			$from		=	$this->db->get_where('settings' , array('type' => 'system_email'))->row()->description;
		
		$this->email->from($from, $system_name);
		$this->email->from($from, $system_name);
		$this->email->to($to);
		$this->email->subject($sub);
		
		$this->email->message($msg);
		
		$this->email->send();
		
		//echo $this->email->print_debugger();
	}
}

