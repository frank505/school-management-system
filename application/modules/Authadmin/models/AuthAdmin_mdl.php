<?php
/* THIS CLASS WAS WRITTEN BY AKPU FRANKLIN CHIMAOBI*/
/* THIS MODEL HANDLES OPERATIONS ON THE ADMIN TABLE THINGS LIKE LOGIN,ADMIN UPDATE PROFILE.. */

defined('BASEPATH') OR exit('No direct script access allowed');
class AuthAdmin_mdl extends CI_Model
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


 
 public function get_user_id_from_username($username) 
 {
     $table = $this->return_admin_table();
    $this->db->select('id');
    $this->db->from($table);
    $this->db->where('email', $username);
    return $this->db->get()->row('id');
    
}

/*
     * CREATE NEW COOKIE OR UPDATE EXISTING COOKIE VALUE
     * ==============================================================================
     */

public function insertCookie($cookie_value,$email)
{
    $table = $this->return_admin_table();
    $data = array(
        'admin_cookie' => $cookie_value,
    );
$this->db->where('email', $email);
$this->db->update($table , $data);

}
/*
     * COMPARES COOKIE TO COOKIE STORED IN THE DATABSE
     * ==============================================================================
     */

public function check_admin_cookie($cookie_value)
{
    $table = $this->return_admin_table();
 $this->db->select("*");
 $this->db->from($table);
 $this->db->where("admin_cookie", $cookie_value);
 $total_val = $this->db->count_all_results();
 return $total_val;
}

/*
     * SELECTS ADMIN DETAILS IF COOKIE IS PRESENT
     * ==============================================================================
     */

public function select_results($cookieData)
{
  $this->db->where("admin_cookie",$cookieData);
  $query = $this->db->get($table);
  foreach ($query->result() as $key => $value) {
     $data[] = $value;
  }
  return  $data;
}


/*
     * CHECK IF HASHED USER EMAIL MATCHES WITH SESSION WHICH IS HASHED EMAIL AND RETURN THE EMAIL VALUE
     * ================================================================================================
     */

public function select_result_session($sessionData)
{
$table = $this->return_admin_table();
$query = $this->db->get($table);
foreach ($query->result() as $row)
{
$user_email = $row->email;
$user_email_hash = md5($user_email);
if($user_email_hash==$sessionData){
   return $user_email;
}else{
    echo "";
}
}
}

/*
     * THIS IS TO ADD A NEW ADMIN
     * ==============================================================================
     */

public function fetch_content_session($email)
{
    $table = $this->return_admin_table();
    $this->db->where("email", $email);
    $query = $this->db->get($table);
  foreach ($query->result() as $key => $value) {
     $data[] = $value;
  }
  return  $data;
}
/*
     * THIS IS TO ADD A NEW ADMIN
     * ==============================================================================
     */
public function add_new_admin($admin_data)
{
    $table = $this->return_admin_table();
    return  $this->db->insert($table,$admin_data);
}


public function update_admin_profile($admin_data,$data)
{
    $table = $this->return_admin_table();
    $this->db->where("email", $admin_data);
    return $this->db->update($table, $data);
}
/*
     * THIS CHECKS TO SEE IF EMAIL EXIST BEFORE ADDING A NEW ADMIN
     * ==============================================================================
     */
 public function check_email($email)
 {
   $table = $this->return_admin_table();
   $this->db->select("*");
     $this->db->from($table);
  $where = "email='$email'";
    $this->db->where($where);
   $total_val = $this->db->count_all_results();
   return $total_val;
 }

 /*
     * THIS LOGS USER INTO TO THE ADMIN SECTION
     * ==============================================================================
     */
 public function login($email,$password)
 {
    $table = $this->return_admin_table();
     $this->db->select("*");
     $this->db->from($table);
  $where = "email='$email'";
    $this->db->where($where);
   $total_val = $this->db->count_all_results();
   if($total_val==0){
       return FALSE;
   }else {
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

 /*
     * THIS IS FOR THE SETTINGS PAGE
     * ==============================================================================
     */

      /*
     * THIS IS TO GET USER DETAILS
     * ==============================================================================
     */
  
     public function get_user_details($id)
     {
        $table = $this->return_admin_table();
         $this->db->where("id", $id);
         $this->db->get($table);
         
     }
 
  
    
//end of this class
}