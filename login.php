<!DOCTYPE html>
<html>
<head>
	<title>login</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">   
  <?php include "./includes/navbar.php" ?>
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	 <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
  <!-- Fontawesome CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> 
  <link href="css/style.css" rel="stylesheet" />
   <link href="css/responsive.css" rel="stylesheet" />
     <!-- alert -->
  <script src="./plugins/alert/alertify.min.js"></script>
   <link rel="stylesheet" href="./plugins/alert/css/alertify.min.css" />
   <link rel="stylesheet" href="./plugins/alert/css/themes/default.min.css" />
   <style type="text/css">
   	 .main-form-box{
  background: url(./images/bg_login.jpg) no-repeat center;
  background-size: cover;
  height: 100%;
  overflow: visible;
  position: relative;
  background-position: center;
  background-size: cover;
  display: table;
  position: relative;
  width: 100%;
}
   </style>
</head>
<body>

<div id="particles-js" class="main-form-box">
  <div class="md-form">
   <div class="container mt-4 mb-3">
     <div class="row">
     	<div class="col-md-6 offset-md-3">
     	  <div class="panel panel-login">
     	  	<div class="logo-top">
			<!--  <a href="#"><img src="images/logo.png" alt="" /></a> -->
			<span>logo</span>
		  </div>
		  <div class="panel-heading">
		  	<span>Login</span>
		 </div>
		 <div class="panel-body">
		  <div class="row">
		  	<div class="col-lg-12">
		  		<form id="loginForm" role="form" style="display: block;">
										<div class="form-group">
											<label class="icon-lp"><i class="fa fa-envelope"></i></label>
											<input type="text" name="email" id="username" tabindex="1" class="form-control" placeholder="email adress" value="" >
										</div>
										<div class="form-group">
											<label class="icon-lp"><i class="fa fa-key"></i></label>
											<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password" >
										</div>
										<div class="che-box">
											<label class="checkbox-in">
												<input name="checkbox" type="checkbox" tabindex="3" id="remember"> <span></span>
												Remember Me
											</label>
										</div>
                                        <span id="logError" class="text-danger"></span>
										<div class="form-group">
											<div class="row">
												<div class="col-sm-6 offset-sm-3">
													<input type="submit"
												name="submitBtnLogin" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In">
												<button type="button" id="loading" class="form-control btn loading">loading...</button>
											</div>
											</div>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-lg-12">					
													<div class="text-center">
														<a href="#" tabindex="5" class="forgot-password">Forgot Password?</a>
													</div>
												</div>
											</div>
										</div>
									</form>
		  	</div>
		  </div>
		 </div>
        </div>
      </div>
    </div> 	
  </div>
 </div>
</div>
<?php include "./includes/footer.php" ?>

<script src="js/particles.min.js"></script>
<script src="js/particles.js"></script>

 <!-- jQery -->
  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>

  <!-- bootstrap js -->
  <script type="text/javascript" src="js/bootstrap.js"></script>
 
  <!-- Google Map -->
<!--   <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap">
  </script> -->
  <!-- End Google Map -->
  <script>
    const app=new LoginAndRegister();
    app.login();
  </script>
</body>
</html>