<?php
/* THIS CLASS WAS WRITTEN BY AKPU FRANKLIN CHIMAOBI*/
/* THIS MODEL HANDLES OPERATIONS ON THE USER TABLE THINGS LIKE LOGIN,ADMIN UPDATE PROFILE.. */

defined('BASEPATH') OR exit('No direct script access allowed');
class Login_register_mdl extends CI_Model
{
 public function __construct()
 {
parent::__construct();
 }
/*
     * THIS RETURNS THE ADMIN TABLE
     * ==============================================================================
     */

 public function return_student_table()
 {
     $table = "student_details";
     return $table;
 }


  /*
     * THIS LOGS USER INTO TO THE ADMIN SECTION
     * ==============================================================================
     */
    public function login($id,$password)
    {
       $table = $this->return_student_table();
        $this->db->select("*");
        $this->db->from($table);
     $where = "id='$id'";
       $this->db->where($where);
      $total_val = $this->db->count_all_results();
      if($total_val==0){
          return FALSE;
      }else {
          $this->db->where("id",$id);
       $query = $this->db->get($table);
       foreach ($query->result() as $row)
       {
           $password_hash = $row->password;
               if(!(password_verify($password, $password_hash))){
                   return FALSE;
               }else{
                   return TRUE;
            }
       }
      }
   }


   public function check_id_token($user_id)
   {
    $table = $this->return_student_table();
    $this->db->select("*");
    $this->db->from($table);
    $this->db->where("id", $user_id);
    $total_val = $this->db->count_all_results();
    return $total_val;
   }


   public function create_new_password($mapped_data,$id)
   {
       $table = $this->return_student_table();
       $this->db->where('id', $id);
   return $this->db->update($table , $mapped_data);
   }

   //end of this class

}