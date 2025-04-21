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
<div id="particles-js" class="main-form-box">
  <div class="md-form">
   <div class="container mt-4 mb-3">
     <div class="row">
     	<div class="col-md-6 offset-md-3">
     	  <div class="panel panel-login">
     	          <!-- dfghjkl;' -->
                 <div class="card-body">
         <form action="" id="editform">
            <div class="container">
            <div class="row justify-content-center">
    <div class="col-md-4">
      <div class="text-center">
        <img src="<?php
                  //  we get this user variable navbar file
                     if(!empty($user['image'])){
                      echo "./../uploads/" . $user['image'];
                    } else {
                      echo "./../uploads/defaultpro.png";
                    }
                  ?>"  class="rounded-circle img-profile border" alt="Profile Image">
       
      </div>
    </div>
  </div>
               <div class="row">
                  <div class="col-sm-6">
                     <label for="farm">Username:</label><br> 
                      <div class="input-group">
                         <input type="text" class="form-control form-control-sm" name="username" id="username" autofocus>
                        
                      </div>
                      <span id="userError" class="text-danger"></span>
                  </div>
                  <div class="col-sm-6">
                     <label for="farm">email:</label><br> 
                      <div class="input-group">
                         <input type="text" class="form-control form-control-sm" name="email" id="email" autofocus >
                       
                      </div>
                      <span id="emailError" class="text-danger"></span> 
                  </div>
                  <div class="col-sm-6 ">
                     <label for="phone">Phone:</label><br> 
                      <div class="input-group">
                          <input type="number" class="form-control form-control-sm" name="phone" id="phone" autofocus >
                      </div>
                      <span id="phoneError" class="text-danger"></span>
                  </div>
                  <div class="col-sm-6">
                    <label for="image">Image:</label><br>
                    <div class="input-group">
                        <div class="custom-file">
                        <input type="file" class="custom-file-input form-control form-control-sm" id="imageInput" name="image" autofocus>
                        <label class="custom-file-label" for="imageInput">Choose image</label>
                        </div>
                        <div class="input-group-append">
                        <span class="input-group-text">
                            
                        </span>
                        </div>
                    </div>

                    <span id="imageError" class="text-danger"></span>
                  </div>
                  
               </div>
               <div class="row justify-content-center mt-2">
                 <div class="col-lg-8">
                    <input type="submit" value="save changes" name="edit" style="width:120px;margin:0 auto"  class="btn btn-primary btn-block btn-flat btn-sm mb-2">
                    <span id="loading" class="loading"></span>
                  </div>
              </div>
            </form>
         </div>
                <!-- fghjkl;' -->
           </div>
        </div>
      </div>
    </div> 	
  </div>
 </div>
</div>