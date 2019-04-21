<?php
/* THIS CLASS WAS WRITTEN BY AKPU FRANKLIN CHIMAOBI*/
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH ."libraries/Rest_Controller.php";

class UserDetails extends MX_Controller
{

public function __construct()
{
    parent::__construct();
    $this->load->module('home');
    $this->load->model("StudentRest/User_detail_mdl");
    
}

public function index()
{
    echo "error url seems to be invalid";
}

public function StudentDetails()
{

    Rest_Controller::set_allowed_headers();
    $data = $this->input->get("token");
    $decode_token =  Rest_Controller::decode_token($data);
    $user_id = $decode_token["aud"];
    $token_exp = $decode_token["exp"];
    $current_time= time();
    $val =  $this->User_detail_mdl->check_id_token($user_id);
    if($current_time >= $token_exp){
        $msg = array("token_expired"=>"token has expired");
        print json_encode($msg);
    }
   else if($val==0){
    $message = "Invalid User Credentails";
    $response = array("msg"=>$message);
    print json_encode($response);    
   }else{
   $data =  $this->User_detail_mdl->fetch_student_detail($user_id);
   $jwt_token = Rest_Controller::create_token($user_id);
    $array_data = array("token"=>$jwt_token,"data"=>$data);
      print json_encode($array_data);
   }
}






}