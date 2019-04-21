<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<!-- BASIC TABLE -->

							<div class="card">

<div class="card-header "><b style="font-size:20px;"><center>Result Info</center></b> <br>
<input id="live_search_students_manage_results" style="width:60%;margin-left:20%;margin-right:20%;" class="form-control search-me-please" placeholder="🔎" name="" type="text"><br>
</div>
<div class="card-body card-block panel-body">
<table class="table   table-striped" style="width:100% !important;">
										<thead>
											<tr>
											<th>Result Info</th>
											</tr>
										</thead>
										<tbody id="display_content">

										<?php 
                            foreach ($results as $key => $value) {
                                $base_url = base_url();
                                $id = $value->id;
							  echo  "<tr>
                               <td>{$value->class_name}&nbsp;&nbsp;{$value->session}&nbsp;&nbsp;{$value->calendar_year}
                               <div class='table-data-feature'>
                               <button class='item load_student_result' data-toggle='tooltip'  data-student-id='$value->student_id' data-target='#scrollmodal' data-toggle='tooltip' data-placement='top' title='' data-original-title='view'>
                                  <i class='fa fa-eye' aria-hidden='true'></i>
                               </button>
                               <button class='item' data-toggle='tooltip' data-placement='top' title='' data-original-title='delete'>
                                   <i class='fa fa-trash' aria-hidden='true'></i>
                               </button>
                           </div>
							  <input type='hidden' class='class_name_hidden' value='$value->class_name'/>
							  <input type='hidden' class='session_hidden' value='$value->session'/>
							  <input type='hidden' class='sub_class_name_hidden' value='$value->sub_class_name'/>
							  <input type='hidden' class='calendar_year' value='$value->calendar_year'/>
                               
                              
                               </a> </td>
							  </tr>";
							}
				                  ?>

										</tbody>
									</table>


      </div>
</div>

							
							<!-- END BASIC TABLE -->
						</div>
						 <div class="center-me-btn "><p class="click_link"><?php   echo $links; ?></p></div>

					</div>
				
				</div>
			</div>
			<!-- END MAIN CONTENT -->

            <!-- modal scroll -->
			<div class="modal fade" id="scrollmodal" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="scrollmodalLabel">Scrolling Long Content Modal</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body" id="content_result">
							<p>
								Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo
								risus, porta ac consectetur ac, vestibulum at eros.
								<br> Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum
								faucibus dolor auctor.
								<br> Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et.
								Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.
								<br> Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi
								leo risus, porta ac consectetur ac, vestibulum at eros.
								<br> Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum
								faucibus dolor auctor.
								<br> Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et.
								Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.
								<br> Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi
								leo risus, porta ac consectetur ac, vestibulum at eros.
								<br> Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum
								faucibus dolor auctor.
								<br> Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et.
								Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.
								<br> Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi
								leo risus, porta ac consectetur ac, vestibulum at eros.
								<br> Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum
								faucibus dolor auctor.
								<br> Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et.
								Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.
								<br> Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi
								leo risus, porta ac consectetur ac, vestibulum at eros.
								<br> Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum
								faucibus dolor auctor.
								<br> Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et.
								Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.
								<br> Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi
								leo risus, porta ac consectetur ac, vestibulum at eros.
								<br> Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum
								faucibus dolor auctor.
								<br> Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et.
								Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.
							</p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
							<button type="button" class="btn btn-primary">Confirm</button>
						</div>
					</div>
				</div>
			</div>
			<!-- end modal scroll -->
		</div><br><br>
