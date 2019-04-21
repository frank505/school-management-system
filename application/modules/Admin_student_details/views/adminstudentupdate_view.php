<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
              <div class="card">

                                    <div class="card-header"><b>Update Student Profile</b></div>
                                    <div class="card-body card-block">
                                    <div class="form-group" style="width:100%;" id="response_area"></div>
                                        <form action="" method="post" class="">
                                        
                                        <?php 
                                        foreach ($student as $key => $values) {
                                            $username = $values->username;
                                            $date_of_birth = $values->date_of_birth;
                                            $graduate = $values->graduate;
                                    
                                        
                                        ?>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                    <input id="username" name="username"  value="<?php echo $username;?>"    placeholder="Students Name" class="form-control" type="text">
                                                </div>
                                            </div>
                                          
                                          <input type="hidden" id="hidden_id" name="" value="<?php echo $this->uri->segment(3);?>">


                                  <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                <select name="" id="classes_area" class="form-control">
                                                <option value="">Select A Class</option>

                                                <?php
                                                foreach ($classes as $key => $value) {
                                                   $class_name = $value->class_name;
                                                   echo "<option value='$class_name'>$class_name</option>";
                                                }
                                                
                                                
                                                ?>
                                                </select>
                                                </div>
                                            </div>
                                
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                    <select name="" id="sub_class_content" class="form-control">
                                                <option value="">Sub Class Name</option>
                                                </select>
                                                </div>
                                            </div>

                       
                            
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                    <select name="" id="graduate" class="form-control">
                                                    <option value="">Graduate</option>
                                                <option value="">No</option>
                                                <option value="">Yes</option>
                                                </select>
                                                </div>
                                            </div>
                                  <?php } //end of the first foreach loop ?>
                    
                                            <div class="form-actions form-group">
                                                <button type="button" id="update_new_student" class="btn btn-primary ">Submit</button>
                                                <button type="button" id="btn-clear-new-student-form" class="btn btn-primary pull-right ">clear</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>


							
						</div>
						

					</div>
				
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>




<div id="myModal" class="modal fade" role="dialog"  aria-hidden="true">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header header-content-modal" style="font-weight:bolder;background-color: #007bff;">
      <center><h5><b class="modal-title" style="color:white;font-size:15px;">ADD A NEW CLASS</b></h5></center>

        <button type="button" class="close" id="close_me" data-dismiss="modal"><i class="fa fa-close" aria-hidden="true"></i></button>
              </div>
      <div class="modal-body">
       <div class="notification">
           <center><b>Generate Password Here</b></center>
       </div>
        <form action="" method="post">
      <div class="form-group">
     <input class="form-control" required="required" name="" id="password_generate" placeholder="enter new class"  type="text">
        <div class="validation" id="validation_password" style="margin-top:15px;"></div>
            </div>
                             

      </form></div>
      <div class="modal-footer">
          <button class="btn  custom_btn btn-primary" id="generate_password" name="send_content" style="font-weight:bolder;color:white;">Generate</button>
          <button class="btn custom_btn btn-primary" id="set_password" name="send_content" style="font-weight:bolder;color:white;">Set Password</button>
        <button type="button" class="btn btn-primary" id="data_close" style="font-weight:bolder;color:white;" data-dismiss="modal">Close</button>
      </div>
      
    </div>

  </div>
</div>














