<?php
/* THIS CLASS WAS WRITTEN BY AKPU FRANKLIN CHIMAOBI*/
defined('BASEPATH') OR exit('No direct script access allowed');

class admin_sub_classes_mdl extends CI_Model
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
        $table = "sub_classes";
        return $table;
      } 


   public function add_sub_class($data)
   {
    $table = $this->return_table();
    return  $this->db->insert($table,$data);
   }

public function check_same_class_and_sub($class,$sub_class)
{
       $table = $this->return_table();
        $this->db->select("*");
        $this->db->from($table);
        $this->db->where("class_name", $class);
        $this->db->where("sub_class_name", $sub_class);
        $total_val = $this->db->count_all_results();
        return $total_val;
}


     /*
     * THIS FETCHES CLASSES AND SUBCLASSES IN A PAGINATED FORM
     * ==============================================================================
     */

    public function fetch_sub_classes($limit,$start)
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
     /*
     * THIS COUNTS THE TOTAL NUMBER OF SUB CLASSES  AVAILABLE
     * ==============================================================================
     */
    public function count_sub_classes()
    {
      $table = $this->return_table();
     return $this->db->count_all($table);
    }
 
  /*
     * THIS DELETES SUB CLASSES USING THIER ID
     * ==============================================================================
     */
    public function delete_sub_classes($id)
    {
      $table = $this->return_table();
      $this->db->where('id', $id);
      return $this->db->delete($table);
    }


/*
     * THIS SEARCHES FOR A SUB CLASS
     * ==============================================================================
     */     

  public function search_sub_class($search_term)
  {
    $table = $this->return_table();
    $filter = $this->input->post('class_name');
    if($filter == 'class_name')
    {
        $this->db->like('class_name',$search_term);
    }
     else if($filter == 'sub_class_name')
    {
        $this->db->like('sub_class_name',$search_term);
    }
     else
    {
    
        $this->db->like('class_name',$search_term);
        $this->db->or_like('sub_class_name',$search_term);
        }
        $this->db->order_by("id","DESC");
        $query = $this->db->get($table);
        return $query->result_array();
  }

 /*
     * THIS FUNCTION HELPS DELETE SUB CLASS CONTENT WITH CLASS THAT DOESNT EXIST IMIDIATELY
     * THE CLASS ITSELF IS DELETED
     * =====================================================================================
     */     

  public function delete_deleted_class($class_from_id)
  {
    $table = $this->return_table();
    $this->db->where("class_name",$class_from_id);
    $this->db->delete($table);
  }

  /*
     * THIS FETCHES SUB CLASSES FOR THE AJAX REQUEST SENT ON THE ADMIN_STUDENT_DETAIL CONTROLLER 
     * =========================================================================================
     */

public function fetch_sub_class_json($class)
{
    $table =  $this->return_table();
    $this->db->where("class_name", $class);
    $query = $this->db->get($table);

    if ($query->num_rows() > 0) {
        foreach ($query->result() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    return false;
}

//end of this class
    }