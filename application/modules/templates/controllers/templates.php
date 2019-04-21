<?php
/* THIS CLASS WAS WRITTEN BY AKPU FRANKLIN CHIMAOBI*/
defined('BASEPATH') OR exit('No direct script access allowed');
class templates extends MX_Controller
{
    public $cookie_name  = "__schAdmin";

    public function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
      
    }



     /**
     * frontend handles the rendering of view for the user end.
     *
     * @param array $data
     * @return void
     */
    public function frontend(array $data)
    {
        $this->load->view('frontend', $data);
    }

    /**
     * backend method handles the rendering of the dashboard view for administrator
     *
     * @param array $data
     * @return void
     */
    public function backend(array $data)
    {
        $this->load->view('backend', $data);
    }

    /**
     * middleend handles rendering of view such as login and register view
     *
     * @param array $data
     * @return void
     */
    public function middleend(array $data)
    {
        $this->load->view('middleend', $data);
    }


   
public function clear_session_cookies()
{
    $cookie_value = "";
    session_destroy();
    $this->destroyCookie($cookie_value);
    redirect(base_url()."administrator/login");
}

public function destroyCookie($cookie_value)
  {
   $cookie= array(
       'name'   => $this->cookie_name,
       'value'  => $cookie_value,
        'expire' => '-86500',
        'path'   => '/',
           );
   $this->input->set_cookie($cookie);
    }

  //end of this class
  }
