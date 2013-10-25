<?php include('struct/header.html'); ?>
	<div class="demo-headline" id="raysDemoHolder">
        <h1 class="demo-logo">
          <div class="logo"></div>
          Rasp Pie
          <small>Tool for monitoring Raspberry Pi</small>
        </h1>
	</div>
	
	<!-- Login form -->
	<div class="row">
		<div class="offset3 span6 offset3">
			<form class="login-form" method="post" action="home.php">
				<fieldset>
					<div class="control-group">
					  <input type="text" required placeholder="Enter your name" class="login-field">
					  <label for="login-name" class="login-field-icon fui-user"></label>
					</div>

					<div class="control-group">
					  <input type="password" required placeholder="Password" class="login-field">
					  <label for="login-pass" class="login-field-icon fui-lock"></label>
					</div>

					<button type="submit"class="btn btn-primary btn-large btn-block">Login</button>
					
					<a href="#" class="login-link">Lost your password?</a>
				</fieldset>
			</form>
		</div>
		
	</div>


<?php include('struct/footer.html'); ?>