<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <script src="../../../plugins/alert/alertify.min.js"></script>
   <link rel="stylesheet" href="../../../plugins/alert/css/alertify.min.css" />
   <link rel="stylesheet" href="../../../plugins/alert/css/themes/default.min.css" />
   <script src="http://localhost/vtuApp/plugins/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>set new pin</title>
<style>
    .loading{
        display:none;
    }
</style>
</head>
<body>

<div id="main" class="">
<div class="login-box d-flex  justify-content-center m-2 mt-3">
   <div class="card card-outline card-primary w-60 mt-5">
      <div class="card-header text-center">
          <span class="h5 text-decoration-none text-success ">Set new pin</span>
      </div>
      <div class="card-body">
         <form action="" id="updatePin">
            <div class="container">
         
               <div class="row">
               <span id="expired" class="text-danger text-center"></span> 
                  <div class="col-sm-12">
                     <label for="farm">New pin:</label><br> 
                      <div class="input-group">
                         <input type="password" class="form-control form-control-sm inp" name="newpin" autofocus >
                      </div>
                      <span id="newPinErr" class="text-danger"></span> 
                  </div>
                  <div class="col-sm-12">
                     <label for="phone">Confirm new pin:</label><br> 
                      <div class="input-group">
                          <input type="password" class="form-control form-control-sm inp" name="confirmPin" autofocus >
                      </div>
                      <span id="confirmPinErr" class="text-danger"></span>
                  </div>
                  <div class="container mt-2">
                    <button type="button" class="btn btn-sm" style="background:#b2b6b9"><i id="showtext">show</i> <span class="fas fa-eye-slash show" id="show"></div></button>
                  </div>
                  
               </div>
               <div class="row justify-content-center mt-2">
                 <div class="col-lg-8">
                    <input type="submit" value="set pin" id="submit" style="width:120px;margin:0 auto"  class="btn btn-primary btn-block btn-flat btn-sm">
                    <button type="button" id="loading" class="form-control btn loading">loading...</button>
                  </div>
              </div>
            </form>
         </div>
      </div>
   </div>
</div>
</div>
<script src="../../../js/custom.js"></script>
<script src="../../../js/showOrHide.js"></script>
<script>
  // user id get from include navbar
   
  const user=new MyApp();
   user.updateForgotPin();
</script>
</body>
</html>