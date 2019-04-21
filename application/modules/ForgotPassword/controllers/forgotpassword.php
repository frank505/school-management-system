<?php
/* THIS CLASS WAS WRITTEN BY AKPU FRANKLIN CHIMAOBI*/
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH ."libraries/Page_Settings.php";
use PHPMailer\PHPMailer\PHPMailer;
require_once APPPATH ."libraries/vendor/autoload.php";

class forgotpassword extends MX_controller
{

 

public function __construct()
{
    parent::__construct();
    $this->load->module(["ForgotPassword","AuthAdmin", "templates"]);
    $this->load->helper(["url","cookie","security"]);  
    $this->load->library('session');
    $this->load->model("AuthAdmin/AuthAdmin_mdl");
    $this->load->model("ForgotPassword_mdl");
    $this->mail = new PHPMailer(true);
}
/*
     * THIS IS THE FORGOT PASSWORD VIEW
     * ==============================================================================
     */

public function index()
{
    $data_send = Page_settings::set_page('forgotpassword_view', NULL, '', 'Login Here', 'ForgotPassword');
    $this->form_validation->set_rules('email', 'email', 'required|valid_email');
    if($this->form_validation->run()==FALSE){
        $this->templates->middleend($data_send);            
    }else{
      $username = $this->input->post("email");
    if($this->AuthAdmin_mdl->check_email($username)==0){
      echo "<script>alert('this user email doesnt exist')</script>";
    }else{
        $this->send_email($username);
        echo "<script>alert('an email notification has been sent to you to reset your password')</script>";
          $this->templates->middleend($data_send);
    }
    
}
}

  
/*
     * THIS RETURNS THE TEMPOARY PASSWORD VIEW
     * ==============================================================================
     */

public function tm_password_view()
{

    $data_send = Page_settings::set_page('tmpassword_view', NULL, '', 'Reset Here', 'ForgotPassword');
    $this->form_validation->set_rules('password', 'password', 'required|trim|min_length[6]');
     if($this->form_validation->run()==FALSE){
        $this->templates->middleend($data_send);            
    }else{
        $password = $this->input->post("password");
        $log_with_tmpassword = $this->ForgotPassword_mdl->check_tm_password($password);
        if($log_with_tmpassword==FALSE){
            $this->templates->middleend($data_send);      
            echo"<script>alert('tempoary password entered is incorrect please enter correct tempoary password')</script>";
        }else{
            $new_tmp_pass = "tmp".md5(time())."me";
            $new_tmp_pass = trim($new_tmp_pass);
          $email = $this->ForgotPassword_mdl->return_email($password); 
         $hashed_username = md5($email);
        $session_credentials = $this->authadmin->setSession($hashed_username);
        $this->session->set_userdata($session_credentials);
        $tm_password_array = $this->mapped_tm_password_array($new_tmp_pass);  
        $this->ForgotPassword_mdl->update_tm_password($email, $tm_password_array); 
        redirect(base_url()."Home");
        }  
    }     
  }


/*
     * GET THE USER TEMPOARY PASSWORD FROM USER EMAIL ENTERED
     * ==============================================================================
     */

   public function tm_password($email)
   {
   $tm_passsword = $this->ForgotPassword_mdl->get_tm_password_from_email($email);
   return $tm_passsword;
   }

/*
     * SEND EMAIL TO ADMIN TO RESET HIS PASSWORD
     * ==============================================================================
     */

public function send_email($username)
{   
    $return_tm_password = $this->tm_password($username); // this first function returns tempoary password from email
    $this->mail->isSMTP();                            // Set mailer to use SMTP
    $this->mail->Host = 'smtp.gmail.com';             // Specify main and backup SMTP servers
    $this->mail->SMTPAuth = true;                     // Enable SMTP authentication
    $this->mail->Username = 'akpufranklin333@gmail.com';          // SMTP username
    $this->mail->Password = 'akpufranklin202'; // SMTP password
    $this->mail->SMTPSecure = 'tls';                  // Enable TLS encryption, `ssl` also accepted
    $this->mail->Port = 587;                          // TCP port to connect to
    $this->mail->addAddress($username);   // Add a recipient
    $this->mail->isHTML(true);  // Set email format to HTML
    $this->mail->setFrom('techmiz@techmiz.com', 'Tech House');
    $this->mail->SMTPDebug  = 0; 
    $bodyContent = "you asked if you wanted to reset your password if  you were not the one then
    ignore this message else here is your tempoary passsword $return_tm_password  to login with.  &nbsp; 
    use this link to login and then change your password once logged in &nbsp;<a href='".base_url()."administrator/reset-password'>here</a>
    please note that this is only a tempoary password and once you log out it can no more be used to log 
    you in again so please klindly change your email once your logged in </b>"; 
    $this->mail->Subject = 'From School Portal Reset Password';
    $this->mail->Body    = $bodyContent;
    
    if(!$this->mail->send()) {
        echo '<script>alert("there seems to be an error please check your internet connection")</script>';
    } else {
        echo '<script>alert("message was sent successfully")</script>';
    }

}
/*
     * MAPPING TO UPDATE TEMPOARY PASSWORD
     * ==============================================================================
     */

public function mapped_tm_password_array($tm_password)
{
  $data = array(
    "tm_password"=> $tm_password,
  );
  return $data;
}


//end of this class
}