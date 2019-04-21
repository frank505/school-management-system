<?php
/* THIS CLASS WAS WRITTEN BY AKPU FRANKLIN CHIMAOBI*/
defined('BASEPATH') OR exit('No direct script access allowed');


require_once APPPATH ."libraries/Rest_Controller.php";

class LoginAndRegister extends MX_Controller
{


public function __construct()
{
    parent::__construct();
    $this->load->module('home');
    $this->load->model("StudentRest/Login_register_mdl");
    $this->load->helper(["url","cookie","security"]);  
}

public function index()
{
    echo "access denied 502 error";
}


/**
 * this function logs the student into his account using two crucial details:
 * @password:student password
 * @key:student id
 * finally a token is created once a students login successfully
 */
public function StudentLogin()
{
    Rest_Controller::set_allowed_headers();
    $data = json_decode(file_get_contents("php://input"));
    $student_pass =  $data->password;
    $student_key = $data->key;
   // $student_key = $student_key;
    $val = $this->Login_register_mdl->login($student_key, $student_pass);
    if($val==FALSE){
        $message = "invalid user unique id or password entered";
        $response = array("msg"=>$message);
        print json_encode($response);    
    }else{
        $jwt_token = Rest_Controller::create_token($student_key);
        $jwt_token = array("token"=>$jwt_token);
        print json_encode($jwt_token);
    }

   
}

public function test()
{
    Rest_Controller::set_allowed_headers();
    $array = array("hello"=>"hello","fat"=>"godwin and her friend");
    //very important sample for you
  //  print $this->output->set_content_type('application/json')->set_output(json_encode($array));
    
}


/**
 * this function changes the user password using the token sent
 */

public function ChangePassword()
{
    Rest_Controller::set_allowed_headers();
    $data = json_decode(file_get_contents("php://input"));
    $new_pass = $data->new_pass;
    $confirm_pass = $data->confirm_pass;
    $segment = $this->uri->segment(4);
   if($segment==""){
    $msg = array("msg"=>"error");
    print json_encode($msg);
   }else{
    $decode_token =  Rest_Controller::decode_token($segment);
     $user_id = $decode_token["aud"];
    $token_exp = $decode_token["exp"];
    $current_time= time();
    if($current_time >= $token_exp){
        $msg = array("msg"=>"new password couldnt be set there seems to be a problem please logout and login again");
        print json_encode($msg);
    }else{
        $val = $this->Login_register_mdl->check_id_token($user_id);
        if($val==0){
            $msg = array("msg"=>"new password couldnt be set there seems to be a problem please logout and login again");
        print json_encode($msg);
        }else{
          if($new_pass!==$confirm_pass){
            $msg = array("msg"=>"new password and confirm password dont match");
            print json_encode($msg);
          }else{
            $mapped_password = $this->mapped_reset_password($new_pass);
              $set_password = $this->Login_register_mdl->create_new_password($mapped_password, $user_id);
               $msg= array("done"=>"password succesfully updated");
               print json_encode($msg);
          }
        }
    }
   }
}

/**
 * this function as the name goes hashes the password
 */
public function hash_password($password)
{
  return password_hash($password,PASSWORD_DEFAULT);
}


public function mapped_reset_password($new_pass)
{
    $hash_pass = $this->hash_password($new_pass); 
    $data = array(
        "password"=>$hash_pass,
    );
    return $data;
}

public function VerifyToken()
{
    Rest_Controller::set_allowed_headers();
    $data = $this->input->get("token");
    $decode_token =  Rest_Controller::decode_token($data);
    $user_id = $decode_token["aud"];
    $token_exp = $decode_token["exp"];
    $token_issuer = $decode_token["iss"];
    $current_time= time();
        $val = $this->Login_register_mdl->check_id_token($user_id);
        if($token_issuer!=Rest_Controller::ISSUER_URL){
            $msg = array("msg"=>"error");
            print json_encode($msg);
        }
        else if($current_time >= $token_exp){
            $msg = array("msg"=>"error");
            print json_encode($msg);
        }
        else if($val==0){
            $msg = array("msg"=>"error");
            print json_encode($msg);
        }
        else{
            $jwt_token = Rest_Controller::create_token($user_id);
            $jwt_token = array("token"=>$jwt_token);
            print json_encode($jwt_token);
        }
    }
    


//end of this class
}