<?php
/* THIS CLASS WAS WRITTEN BY AKPU FRANKLIN CHIMAOBI*/
/* THIS MODEL HANDLES OPERATIONS ON THE USER TABLE ESPECIALLY FETCHING USER DETAILS.. */

defined('BASEPATH') OR exit('No direct script access allowed');
class User_detail_mdl extends CI_Model
{
 public function __construct()
 {
parent::__construct();
 }
/*
     * THIS RETURNS THE STUDENTS TABLE
     * ==============================================================================
     */

 public function return_student_table()
 {
     $table = "student_details";
     return $table;
 }

 /*
     * THIS RETURNS THE STUDENTS DETAILS
     * ==============================================================================
     */

 public function fetch_student_detail($user_id)
 {
     $table = $this->return_student_table();
     $this->db->where("id",$user_id);
  $query = $this->db->get($table);
  foreach ($query->result() as $key => $value) {
     $data[] = $value;
  }
  return  $data;
 }

/*
     * THIS CHECKS ID FROM TOKEN SENT
     * ==============================================================================
     */

 public function check_id_token($user_id)
 {
  $table = $this->return_student_table();
  $this->db->select("*");
  $this->db->from($table);
  $this->db->where("id", $user_id);
  $total_val = $this->db->count_all_results();
  return $total_val;
 }

 //end of this class

}