<?php
/* THIS CLASS WAS WRITTEN BY AKPU FRANKLIN CHIMAOBI*/
defined('BASEPATH') OR exit('No direct script access allowed');

class admin_classes_mdl extends CI_Model
{
 
    public function __construct()
    {
        parent::__construct();
    }

    /*
     * THIS RETURNS THE TABLE TO BE USED WHICH IS THE Classes TABLE
     * ==============================================================================
     */
      public function return_table()
      {
        $table = "classes";
        return $table;
      } 

   /*
     * THIS ADDS A CLASS TO THE TABLE
     * ==============================================================================
     */
    public function add_classes($classes)
    {
        $table = $this->return_table();
      $this->db->insert($table,$classes);
    }

/*
     * CHECKS IF CLASS ALREADY EXISTS IN THE TABLE
     * ==============================================================================
     */
     public function check_classes($classes)
     {
       $table = $this->return_table();
        $this->db->select("*");
        $this->db->from($table);
        $this->db->where("class_name", $classes);
        $total_val = $this->db->count_all_results();
        return $total_val;
     }

     /*
     * THIS COUNTS THE TOTAL NUMBER OF CLASSES AVAILABLE
     * ==============================================================================
     */
     public function count_classes()
     {
       $table = $this->return_table();
      return $this->db->count_all($table);
     }
  
     /*
     * THIS FETCHES CLASSES IN A PAGINATED FORM
     * ==============================================================================
     */

     public function fetch_classes($limit,$start)
     {
       $table = $this->return_table();
       $this->db->order_by("id", "DESC");
      $this->db->limit($limit, $start);
      $query = $this->db->get($table);

      if ($query->num_rows() > 0) {
          foreach ($query->result() as $row) {
              $data[] = $row;
          }
          return $data;
      }
      return false;
     }

     public function fetch_classes_for_sub_classes()
     {
      $table = $this->return_table();
      $this->db->order_by("id", "DESC");
      $query = $this->db->get($table);

      if ($query->num_rows() > 0) {
          foreach ($query->result() as $row) {
              $data[] = $row;
          }
          return $data;
      }
      return false;
     }
     /*
     * THIS GETS THE CLASS FROM ID
     * ==============================================================================
     */

   public function class_from_id($id)
   {
       $table = $this->return_table();
       $this->db->where("id",$id);
     $query = $this->db->get($table);
     foreach ($query->result() as $key => $value) {
         $class = $value->class_name;
         return $class;
     }
     
   }


     /*
     * THIS DELETES CLASSES USING THIER ID
     * ==============================================================================
     */
     public function delete_classes($id)
     {
       $table = $this->return_table();
       $this->db->where('id', $id);
       return $this->db->delete($table);
     }
  /*
     * THIS SEARCHES FOR A CLASS
     * ==============================================================================
     */     
     public function search_class($search_term)
     {
             $table = $this->return_table();
             $this->db->like('class_name',$search_term);      
             $this->db->order_by("id","DESC");
             $query = $this->db->get($table);
             return $query->result_array();
      }   
    
    




/**
 * this class ends here
 */
}