<?php include('struct/header.html'); ?>
<div class="headline">
    <h1>
        <div class="logo"></div>
        Rasp Pie
        <small>Tool for monitoring Raspberry Pi</small>
    </h1>
</div>
<div class="row">
    <div class="col-md-6 col-md-offset-3">	
        <form class="login-form" method="post" action="home.php">
            <div class="form-group">
                <input type="text" id="login-name" placeholder="Enter your name" value="" class="form-control login-field">
                <label for="login-name" class="login-field-icon fui-user"></label>
            </div>

            <div class="form-group">
                <input type="password" id="login-pass" placeholder="Password" value="" class="form-control login-field">
                <label for="login-pass" class="login-field-icon fui-lock"></label>
            </div>

            <button type="submit"class="btn btn-primary btn-lg btn-block">Login</button>

            <a href="#" class="login-link">Lost your password?</a>
        </form>
    </div>
</div>



<?php include('struct/footer.html'); ?>