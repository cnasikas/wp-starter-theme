<?php

namespace App\Email;

class Email{

    protected static $instance = null;

	private $headers = array();
	private $adminEmail;
	private $fromEmail;
	private $replyEmail;
		
	protected function __construct() {

        $this->adminEmail = '';
        $this->fromEmail = '';
        $this->replyEmail = '';

        $this->headers[] = 'From:  <' . $this->fromEmail . '>';
        $this->headers[] = 'Content-type: text/html';
        $this->headers[] = 'Reply-To: ' .  $this->replyEmail;

    }

    public function init() {
        
    }

    public function send($template, $data){

    	$subject = $data['subject'];
    	$to = $data['send_to'];
		$message = $this->getTemplate($template, $data);
		$mail_code = wp_mail( $to, $subject, $message, $this->headers);

        if($mail_code)
            return true;

		return false;	

    }

    public function getTemplate($template, $data){

    	ob_start(); 
		include(APP_TEMPLATE_PATH . 'email/' . $template);
		$msg = ob_get_contents(); 
		ob_end_clean();
		
		return $msg;

    }

    public function sendAdmin($subject, $message){

    	wp_mail($this->adminEmail, $subject, $message, $this->headers);

    }

    public static function getInstance() {

        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

}

?>