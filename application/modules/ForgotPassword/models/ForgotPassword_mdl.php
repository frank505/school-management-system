<?php
/* THIS CLASS WAS WRITTEN BY AKPU FRANKLIN CHIMAOBI*/
/* THIS MODEL HANDLES OPERATIONS ON THE ADMIN TABLE THINGS LIKE LOGIN,ADMIN UPDATE PROFILE.. */

defined('BASEPATH') OR exit('No direct script access allowed');
class ForgotPassword_mdl extends CI_Model
{
  

 public function __construct()
 {
parent::__construct();
 }
/*
     * THIS RETURNS THE ADMIN TABLE
     * ==============================================================================
     */

 public function return_admin_table()
 {
     $table = "admin";
     return $table;
 }
/*
     * GET THE TEMPOARY PASSWORD FROM THE USER EMAIL
     * ==============================================================================
     */

 public function get_tm_password_from_email($email)
 {
     $table = $this->return_admin_table();
   $this->db->where("email",$email);
  $query = $this->db->get($table);
  foreach ($query->result() as $key => $value) {
     $tm_password =  $value->tm_password;
  }
  return  $tm_password;
 }

 /*
     * CHECK USER TEMPOARY PASSWORD
     * ==============================================================================
     */

 public function check_tm_password($password)
 {
    $table = $this->return_admin_table();
    $this->db->select("*");
      $this->db->from($table);
   $where = "tm_password='$password'";
     $this->db->where($where);
    $total_val = $this->db->count_all_results();
    if($total_val==0){
        return FALSE;
    }else{
        return TRUE;
    }
 }

 /*
     * RETURN USER EMAIL FROM THE TEMPOARY PASSWORD
     * ==============================================================================
     */

 public function return_email($password)
 {
    $table = $this->return_admin_table();
   $this->db->where("tm_password",$password);
  $query = $this->db->get($table);
  foreach ($query->result() as $key => $value) {
     $email =  $value->email;
  }
  return  $email;   
 }


 /*
     * CHANGE TEMPOARY PASSWORD ONCE NEW PASSWORD IS CREATED
     * ==============================================================================
     */

 public function update_tm_password($email , $new_tm_password)
 {
    $table = $this->return_admin_table();
    $this->db->where("email", $email);
    return $this->db->update($table, $new_tm_password);
 }

//end of this classs
}