<div class="main" style="min-height: 582px;" >
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<!-- OVERVIEW -->
					<div class="panel panel-headline" style="background:white;">


<div class="content-section-all" style="margin-bottom:40px !important;background:white;">


<div class="card">
									<div class="card-header">
										<h4>Edit Your Details</h4>
									</div>
									<div class="card-body">

                                    
										<ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-bottom:10px;">
											<li class="nav-item">
												<a class="nav-link active show" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="false"><b>New admin</b></a>
											</li>
											<li class="nav-item">
												<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><b>Update profile</b></a>
											</li>
										</ul>
										<div class="tab-content pl-3 p-1" id="myTabContent">
                                        
											<div class="tab-pane fade  active show" id="home" role="tabpanel" aria-labelledby="home-tab">
                                            <form action="" method="post" role="form" class="contactForm">

<div class="notification-registration" id="sent_indicator_additional">  </div>          
               
<div class="form-group">
<input id="add_username" placeholder="enter your username" class="form-control" type="text">
</div>

<div class="form-group">
<input id="add_email" placeholder="enter your email" class="form-control" type="email">
</div>

<div class="form-group">
<input id="add_password" placeholder="enter your password" class="form-control" type="password">
</div>


<div class="form-group">
<input id="add_confirm" class="form-control" placeholder="confirm password here" type="password">
</div>
                                                            

                         <button type="button" id="btn-add-admin" class="btn btn-primary ">Submit</button>
                         <button type="button" id="btn-clear-admin" class="btn btn-primary pull-right ">clear</button>
                     </form>
											</div>
											<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                            <form action="" method="post" role="form" class="contactForm">
             <div class="notification-registration" id="sent_indicator_update">  </div>     

             <div class="notification-registration" id="add-indicator">  </div>          
                            
             <?php    
                 foreach ($details as $key => $value) {
                  
                ?>            
             <div class="form-group">
<input id="update_username" placeholder="enter your username" class="form-control" value="<?php echo $value->username; } ?>" type="text">
   </div>
   
   <div class="form-group">

   <input id="update_password" placeholder="enter your password" class="form-control" type="password">
   </div>


   <div class="form-group">
   <input id="update_confirm" class="form-control" placeholder="confirm password here" type="password">
   </div>

                                                                         
          
                                      <button type="button" id="update-admin" class="btn btn-primary ">Submit</button>
                                      <button type="button" id="clear-update" class="btn btn-primary pull-right ">clear</button>
                                  </form>				
											</div>
											
										</div>


									</div>
								</div>




</div>

<br><br>



</div>


</div>


</div>


</div>