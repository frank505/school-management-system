<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
			<span class="login100-form-title p-b-26">
						Login 
					</span>
		<b class="show_errors"><?php echo validation_errors(); ?></b>	
 							<?php echo form_open(base_url()."administrator/login"); ?><br><br>
					
					<div class="wrap-input100 validate-input" data-validate = "Valid email is: a@b.c">
						<input class="input100" type="text" name="email">
						<span class="focus-input100" data-placeholder="Email"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input100" name="password" type="password" name="pass">
						<span class="focus-input100" data-placeholder="Password"></span>
					</div>
					 <label for="check_me">remember me</label>&nbsp;
                         <input type="checkbox" id="check_me" name="check_me" id="">
					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button name="submit_btn" class="login100-form-btn">
								SUBMIT
							</button>
						</div>
					</div>


						<a class="txt2" href="<?php echo base_url()?>administrator/forgot-password">
					  forgot password		
					</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	


	<div id="dropDownSelect1"></div>

<script>
/*
     * JAVASCRIPT  CUSTOM STYLE OUR ERROR MESSAGES
     * ========================================================================
     */
var show_errors = document.querySelector(".show_errors");
if(show_errors.innerHTML==""){
  show_errors.classList.remove("alert");
  show_errors.classList.remove("alert-danger");
}else{
 var p_tags	= show_errors.querySelectorAll("p");
  for (let index = 0; index < p_tags.length; index++) {
	  let element = p_tags[index];
	  element.classList.add("alert","alert-danger");
  }
}
</script>