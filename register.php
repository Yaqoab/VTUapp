<?php 
    //   require_once './db_connect.php';
    //   require_once "./classes/actions.php";

	//   $addData=new Actions();
    //   if (isset($_GET['referral'])) {
	// 	$date=date('Y-m-d');
	// 	$time=date('h:i:sa');
	// 	$date_time=$date.' / '.$time;

	// 	$code=$_GET['referral'];
	// 	$getReferralUser=$addData->select("users","*","phone ='$code'");
	// 	$ref=[
	// 	  'referrer_id'=>$getReferralUser['user_id'],
	// 	  'referee_id'=>'invited id',
	// 	  'deposited'=>0,
	// 	  'referral_date'=>$date_time
	// 	];
	// 	$addData->addDataToDatabase("referrals",$ref);
	//   }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">   
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
.spinner {
  border: 16px solid #f3f3f3;
  border-top: 16px solid #3498db;
  border-radius: 50%;
  width: 50px;
  height: 50px;
  animation: spin 2s linear infinite;
  margin: 0 auto;
  display: none; /* Initially hidden */
  }

  @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
  }
  .loading{
    display: none;
  }
   </style>
</head>
<body>
	<? include "./includes/navbar.php" ?>
<div id="particles-js" class="main-form-box">
  <div class="md-form">
   <div class="container mt-3 mb-3">
     <div class="row">
     	<div class="col-md-6 offset-md-3">
     	  <div class="panel panel-login">
     	  	<div class="logo-top">
			<!--  <a href="#"><img src="images/logo.png" alt="" /></a> -->
			<span>logo</span>
		  </div>
		  <div class="panel-heading">
		  	<span>Register</span>
		 </div>
		 <div class="panel-body">
		  <div class="row">
		  	<div class="col-lg-12">
		  		<form id="form" >
		  	   
										<div class="form-group">
											<label class="icon-lp"><i class="fa fa-user"></i></label>
											<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="<?php echo isset($user) ? $user:''?>" >
											<span class="text-danger"><?php //echo $err['username']; ?></span>
                       <span id="usernameErr" class="text-danger"></span>
										</div>
										<div class="form-group">
											<label class="icon-lp"><i class="fa fa-envelope"></i></label>
											<input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="<?php echo isset($email) ? $email:''?>">
											<span id="emailErr" class="text-danger"></span>
										</div>
										<div class="form-group">
											<label class="icon-lp"><i class="fa fa-phone"></i></label>
											<input type="phone" name="phone" id="phone" tabindex="1" class="form-control" placeholder="Phone Number" value="<?php echo isset($phone) ? $phone:''?>">
											<span id="phoneErr" class="text-danger"></span>
										</div>
										<div class="form-group">
											<label class="icon-lp"><i class="fa fa-key"></i></label>
											<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
											<span id="passwordErr" class="text-danger"></span>
										</div>
										<div class="form-group">
											<label class="icon-lp"><i class="fa fa-key"></i></label>
											<input type="password" name="confirm" id="confirm" tabindex="2" class="form-control" placeholder=" confirm Password">
											<span id="confirmErr" class="text-danger"></span>
										</div>
										<div class="che-box">
											<label class="checkbox-in">
												<input name="checkbox" type="checkbox" tabindex="3" id="remember"> <span></span>I agree to the <a href="#"> Terms and Conditions </a> and <a href="#">Privacy Policy </a>
											</label>
										</div>
										
										<?php if (!empty($success)) {?>
										 <div class="alert alert-success text-center mb-2 mt-2"><strong><?php echo $success;?></strong></div>
										<?php } ?>
										<div class="form-group">
											<div class="row">
												<div class="col-sm-6 offset-sm-3">
													<input type="submit" id="submitButton" tabindex="4" class="form-control btn btn-login" value="Register">
                          <!-- <input type="submit" id="loading" tabindex="4" class="form-control btn btn-login" value="loading..."> -->
                          <button type="button" id="loading" class="form-control btn loading">loading...</button>
                          <div id="response"></div>
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
 <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>

  <!-- bootstrap js -->
   <script type="text/javascript" src="js/bootstrap.js"></script>
  <script>
	const app=new LoginAndRegister();
    app.register();
  </script>
  <!-- <script src="js/userJS/main.js"></script> -->

  
</body>
</html>