<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
              <div class="card">

                                    <div class="card-header"><b>Upgrade Student Classes</b></div>
                                    <div class="card-body card-block">
                                    <div class="form-group" style="width:100%;" id="response_area">
                                    <b class="show_errors"><?php echo validation_errors(); ?></b>
                                </div>
                                    <?php echo form_open(base_url()."Home/Class-Upgrade"); ?><br><br>
                                  <div class="form-group" style="text-align:center;">
                                                <div class="input-group ">
                                                <select name="select_class" id="classes_area" class="form-control">
                                                <option value="">Search For Students By Class</option>

                                                <?php
                                                foreach ($classes as $key => $value) {
                                                   $class_name = $value->class_name;
                                                   echo "<option value='$class_name'>$class_name</option>";
                                                }
                                                ?>
                                                </select>
                                                 &nbsp;&nbsp;&nbsp;
                                                <button type="submit" class="btn btn-primary"><i class="zmdi zmdi-search"></i>
                                            </button>&nbsp;&nbsp;&nbsp;
                                              <input type="text" name="" title="search by name or sex" placeholder="🔎 search for student by student name" id="student_search_upgrade_class" class="form-control search_single_user_to_update">&nbsp;&nbsp;
                                         <select name="" id="classes_area" class="form-control  select_class_to_update">
                                                <option value="">Upgrade Students Class</option>

                                                <?php
                                                foreach ($classes as $key => $value) {
                                                   $class_name = $value->class_name;
                                                   echo "<option value='$class_name'>$class_name</option>";
                                                }
                                                ?>
                                                </select> &nbsp;&nbsp;&nbsp;


                                            &nbsp;&nbsp;<button type="button"class="btn btn-primary check_all_students_searched" title="check all students searched" ><i class="fa fa-check-square"></i></button>
                                            &nbsp;&nbsp;<button  type="button" class="btn btn-primary update_checked_students" title="update students searched to new classes"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                                </div>
                                            </div>

                                            
                                
                                        </form>
                                    </div>



                 <div class="panel-body table-responsive">
									<table class="table">
                                    <thead>
											<tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Class</th>
                                                <th>Sub Class</th>
                                                 <th>image</th>
                                                 <th>Check Student</th>
                                                 
											</tr>
										</thead>
										<tbody id="display_content">

                            <?php 
                            foreach ($results as $key => $value) {
                                $file_name = $value->file_name;
                                $base_url = base_url();
                                $id = $value->id;
							  echo  "<tr>
                               <td>$value->id</td> 
                               <td>$value->username</td>
                               <td>$value->class_name</td>
                               <td>$value->sub_class_name</td>
                               <td><img src='{$base_url}assets/student_image/$file_name' style='width:40px;height:40px;' ></td>
                               <td><input type='checkbox' name='' class='check-me' id='$id'></td>
							  </tr>";
							}
				                  ?>
   
										</tbody>
									</table>
								</div>





                                    
                                </div>
                                <div class="center-me-btn "><p class="click_link">
                                    <?php echo $links; ?>
                                    </p></div>

							
						</div>
						

					</div>
				
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>
