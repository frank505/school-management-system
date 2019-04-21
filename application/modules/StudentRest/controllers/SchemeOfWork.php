<?php
/* THIS CLASS WAS WRITTEN BY AKPU FRANKLIN CHIMAOBI*/
defined('BASEPATH') OR exit('No direct script access allowed');


require_once APPPATH ."libraries/Rest_Controller.php";

class SchemeOfWork extends MX_Controller
{


public function __construct()
{
    parent::__construct();
    $this->load->module('home');
    $this->load->model("StudentRest/scheme_of_work_mdl");
    $this->load->model("StudentRest/Login_register_mdl");
    $this->load->helper(["url","cookie","security"]);  
}

public function index()
{
    echo "access denied 401 error";
}

public function getClassesName()
{
    Rest_Controller::set_allowed_headers();
    $token = $this->security->xss_clean(htmlspecialchars($this->input->get("token")));
    if($this->validate_each_request($token)==FALSE){
        $msg = array("msg"=>"there seems to be an error somewhere please refresh your browser");
        print json_encode($msg);
    } else{
          $class_names = $this->scheme_of_work_mdl->getClassesName();
          $array_content = array("classes"=>$class_names);
          print json_encode($array_content);
        }
}



 public function getCourseName()
 {
    Rest_Controller::set_allowed_headers();
    $token = $this->security->xss_clean(htmlspecialchars($this->input->get("token")));
  $class_name = $data = $this->security->xss_clean(htmlspecialchars($this->input->get("class_name")));
  if($this->validate_each_request($token)==FALSE){
    $msg = array("msg"=>"there seems to be an error somewhere please refresh your browser");
            print json_encode($msg);
  }else if($class_name==""){
        $msg = array("msg"=>"there seenme to be  an error somewhere please refresh your browser");
        print json_encode($msg);
  }  else{
   $get_courses = $this->scheme_of_work_mdl->getCourseName($class_name);
   $array_content = array("courses"=>$get_courses);
   print json_encode($array_content);
  }

  }

  public function getSessionsAvailable()
  {
  Rest_Controller::set_allowed_headers();
  $token = $this->security->xss_clean(htmlspecialchars($this->input->get("token")));
  $class_name = $data = $this->security->xss_clean(htmlspecialchars($this->input->get("class_name")));
  $course_name = $data = $this->security->xss_clean(htmlspecialchars($this->input->get("course_name")));
  if($this->validate_each_request($token)==FALSE){
    $msg = array("msg"=>"there seems to be an error somewhere please refresh your browser");
            print json_encode($msg);
  }
  else if($class_name=="" || $course_name==""){
      $msg = array("msg"=>"refresh your browser again some parameters to send the http request are missing");
  }else{
      $get_sessions = $this->scheme_of_work_mdl->getSessionsAvailable($class_name, $course_name);
      $array_content = array("sessions"=>$get_sessions);
   print json_encode($array_content);
  }
  }

  public function getCourseTopics()
  {
    Rest_Controller::set_allowed_headers();
    $token = $this->security->xss_clean(htmlspecialchars($this->input->get("token")));
    $class_name = $data = $this->security->xss_clean(htmlspecialchars($this->input->get("class_name")));
    $course_name = $data = $this->security->xss_clean(htmlspecialchars($this->input->get("course_name")));
    $session_name = $data = $this->security->xss_clean(htmlspecialchars($this->input->get("session")));
    if($this->validate_each_request($token)==FALSE){
        $msg = array("msg"=>"there seems to be an error somewhere please refresh your browser");
                print json_encode($msg);
      }
    else if($class_name=="" || $course_name==""  || $session_name==""){
        $msg = array("msg"=>"refresh your browser again some parameters to send the http request are missing");
    }else{
        $get_topics = $this->scheme_of_work_mdl->getTopicsForThisCoursePerSemester($class_name, $course_name, $session_name);
        $array_content = array("topics"=>$get_topics);
     print json_encode($array_content);
    } 
  }

 public function validate_each_request($data)
 {
    $decode_token =  Rest_Controller::decode_token($data);
    $user_id = $decode_token["aud"];
    $token_exp = $decode_token["exp"];
    $token_issuer = $decode_token["iss"];
    $current_time= time();
        $val = $this->Login_register_mdl->check_id_token($user_id);
        if($token_issuer!=Rest_Controller::ISSUER_URL){
            return FALSE;
        }
        // else if($current_time >= $token_exp){
        //    return FALSE;
        // }
        else if($val==0){
            $msg = array("msg"=>"error");
           return FALSE;
        }else{
            return TRUE;
        }
 }



}