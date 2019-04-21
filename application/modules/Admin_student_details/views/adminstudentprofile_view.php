

                    <div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<div class="row">


<div class="col-md-12">
  
                        <div class="card card-user">
                        <?php   
    foreach ($results as $key => $value) {
        $file_name = $value->file_name;
        $username = $value->username;
        $class_name = $value->class_name;
        $sub_class_name = $value->sub_class_name;
        $date_of_birth = $value->date_of_birth;
        $time_added = $value->time_added;   
        $sex = $value->sex;
        $graduated = $value->graduate;
        // $year_joined = strtotime($time_added);
        $year_joined = date('d/m/Y', $time_added);
   ?>                 
                   <div class="student-image" style="background-image:url(<?php echo base_url();?>assets/images_admin/profile-bg.png);">
                   
                    <img  class="img-circle"src="<?php echo base_url();?>assets/student_image/<?php echo $file_name;?>" alt="" srcset="">
                     <p class="name-style" style="color:white;font-weight:bolder;font-size:25px;"><b><?php echo $username; ?></b></p>
                   
                   </div> 

                   <div class="profile-stat">
										<div class=" row">
											<div class="col-md-6 stat-item">
												Class: <span><?php echo $class_name;?></span>
											</div>
											<div class="col-md-6 stat-item">
												Sub Class: <span><?php echo $sub_class_name;?></span>
											</div>
											<div class="col-md-6 stat-item">
												Sex: <span><?php echo $sex;?></span>
											</div>
                                            <div class="col-md-6 stat-item">
												Date Of Birth: <span><?php  echo $date_of_birth;?></span>
											</div>
                                            <div class="col-md-6 stat-item">
												Date Of Student Registration: <span><?php  echo $year_joined;?></span>
											</div>
                                            <div class="col-md-6 stat-item">
											Graduated: <span><?php  echo $graduated;?></span>
											</div>
										</div>
									</div>                     
                                    <?php } //end of foreach loop?> 
                        </div>
                    </div>




                    </div>
                    </div>
                    </div>
                    </div>