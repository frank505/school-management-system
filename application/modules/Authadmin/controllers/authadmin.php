<?php
/* THIS CLASS WAS WRITTEN BY AKPU FRANKLIN CHIMAOBI*/
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH ."libraries/Page_Settings.php";

class authadmin extends MX_controller
{

  public $cookie_key = "dre45354e";
  public $cookie_name  = "__schAdmin";
  public $tm_password_key = "csdr32";
 
 
public function __construct()
{
    parent::__construct();
    $this->load->module(["Home","AuthAdmin", "templates"]);
    $this->load->helper(["url","cookie","security"]);  
    $this->load->library('session');
    
}


/*
     * THIS LOADS THE ADMIN LOGIN VIEW
     * ========================================================================
     */

public function index()
{
    $data_send = Page_settings::set_page('login_view', NULL, '', 'Login Here', 'AuthAdmin');
    $this->load->model("AuthAdmin_mdl");
    $this->form_validation->set_rules('email', 'email', 'required|valid_email');
    $this->form_validation->set_rules('password', 'password', 'required|trim|min_length[6]');
    if($this->form_validation->run()==FALSE){
        $this->templates->middleend($data_send);            
    }else{
      $username = $this->input->post("email");
      $password = $this->input->post("password");
     $val =  $this->AuthAdmin_mdl->login($username,$password);
     if($val==FALSE){
    echo "<script>alert('incorrect email or password entered')</script>";
    $this->templates->middleend($data_send);            
     }
     else if($val==NULL){
        $this->templates->middleend($data_send);            
     echo "<script>alert('incorrect username or email entered')</script>";
     }else{
       $hashed_username = md5($username);
  $session_credentials = $this->setSession($hashed_username);
$this->session->set_userdata($session_credentials);
       $check = $this->input->post("check_me");
       if($check == TRUE){
        $cookie_key = $this->cookie_key;
        $cookie_value = md5($username)."".$cookie_key.""; 
        $this->AuthAdmin_mdl->insertCookie($cookie_value,$username);   
       $this->setCookie($cookie_value);  
       redirect(base_url()."Home");
       } else{
        redirect(base_url()."Home");
       }    
          }

    }
}


    /*
     * ADMIN TABLES ARE MAPPED TO CONTENTS AS CONTENT WILL BE ADDED
     * ==============================================================================
     */
  
    public function admin_add_array($username,$email,$password,$confirm)
{
  $cookie_key = $this->cookie_key;
  $admin_cookie = md5($email)."".$cookie_key;
  $tm_password = md5($username)."".$this->tm_password_key;
  $password = $this->hash_password($password);
  $confirm = $this->hash_password($confirm);
$data = array(
'username' => $username,
'email' => $email,
'password' => $password,
"confirm"=>$confirm,
"tm_password"=>$tm_password,
"admin_cookie" => $admin_cookie,
);
return $data;
}

public function admin_update_array($username,$password,$confirm)
{
  $password = $this->hash_password($password);
  $confirm = $this->hash_password($confirm);
  $data = array(
    "username"=> $username,
    "password"=> $password,
    "confirm"=>$confirm
  );
  return $data;
}

    public function setCookie($cookie_value)
    {
     $cookie= array(
         'name'   => $this->cookie_name,
         'value'  => $cookie_value,
          'expire' => '86500',
          'path'   => '/',
             );
     $this->input->set_cookie($cookie);
      }
  
       /*
       * THIS FUNCTION IS TO SET THE SESSION VARIABLES
       * ==============================================================================
       */
     public function setSession($email)
     {
     return  $session_data = array(
        'email'     => $email,
        'logged_in' => TRUE
  );     
     }
     /*
       * STRING SANITIZER
       * ==============================================================================
       */
     public function sanitize_string($input)
   {
    return filter_var($input, FILTER_SANITIZE_STRING);
   }
   /*
       * EMAIL VALIDATION
       * ==============================================================================
       */
  public function validate_email($email)
  {
  return filter_var($email, FILTER_VALIDATE_EMAIL);
  }
  /*
       * PASSWORD HASHING
       * ==============================================================================
       */
  public function hash_password($password)
  {
    return password_hash($password,PASSWORD_DEFAULT);
  }
  
  
  /*
     * THIS FUNCTIONS CHECKS FOR COOKIE OR SESSION
     * ==============================================================================
     */
  public function CheckSessionOrCookie()
  {
       $this->load->model("AuthAdmin/AuthAdmin_mdl");
   @$logged_in = $_SESSION["logged_in"];
    @$email  = $_SESSION["email"];
        if(isset($email) && isset($logged_in) ){
         if($logged_in==TRUE){
         return TRUE; 
         }else{
          return FALSE;       
         }  
        }else{
          $cookieData = get_cookie($cookie_name);
           if($cookieData==""){
             return FALSE;
           }else{
            $total = $this->AuthAdmin_mdl->check_admin_cookie($cookieData);
            if($total==0){
              return FALSE;
            }else{
              $data = $this->AuthAdmin_mdl->select_results($cookieData);
              foreach ($data as $key => $value) {
                $user_email = $value->email;
              } 
              $hashed_username = md5($user_email);
              $session_credentials = $this->setSession($hashed_username);
              $this->session->set_userdata($session_credentials);
              return TRUE;
            }
           }
          
        }
  }



  

  



}




  
