<head>
  <title>Set new pin</title>
<style>
    .footernavbar{
        display: none;
    }
    
</style>
</head>
<div id="main" class="box">
  <div class="container mt-3">
     <div class="row justify-content-center">
         <div class="col-md-6">
             <div class="card mt-5">
                 <div class="card-body">
                     <form action="" id="newpin">
                        <div class="container">
                        <div class="card-head h5 text-decoration-none text-secondary text-center">New pin</div>
                           <div class="row">
                              
                              <div class="col-sm-12">
                                 <label for="farm">New pin:</label><br> 
                                 <div class="input-group">
                                    <input type="password" class="form-control inp" name="pin" autofocus >
                                 </div>
                                 <span id="pinErr" class="text-danger"></span> 
                              </div>
                              <div class="col-sm-12">
                                 <label for="phone">Confirm new pin:</label><br> 
                                 <div class="input-group">
                                    <input type="password" class="form-control inp" name="confirm" autofocus >
                                 </div>
                                 <span id="confirmErr" class="text-danger"></span>
                              </div>
                              <div class="col-sm-12">
                                 <label for="farm">Password:</label><br> 
                                 <div class="input-group">
                                    <input type="password" class="form-control inp" name="password" autofocus>
                                 </div>
                                 <span id="passwordErr" class="text-danger"></span>
                              </div>
                              <!-- <div class="container mt-2">
                              <button type="button" class="btn btn-sm" style="background:#b2b6b9"><i id="showtext">show</i> <span class="fas fa-eye-slash show" id="show"></div></button>
                              </div> -->
                              
                           </div>
                           <div class="row justify-content-center mt-2">
                                 <div class="col-lg-8 text-center">
                                    <span class="border p-1 rounded"><i id="showtext">show</i> <span class="fas fa-eye-slash show" id="show"></span></span>
                                 </div>
                              </div>
                           <div class="row justify-content-center mt-3">
                           <div class="col-lg-8">
                              <input type="submit" value="set pin" name="edit" style="width:120px;margin:0 auto"  class="btn btn-primary btn-block btn-flat">
                              <button type="button" id="loading" class="form-control btn loading">loading...</button>
                              </div>
                        </div>
                        </form>
                  </div>
                </div>
             </div>
         </div>
    </div>
</div>
<script src="./../js/custom.js"></script>
<script src="./../js/showOrHide.js"></script>
<script>
  // user id get from include navbar
   const id=<?= $userId ?>;
  const user=new MyApp();
   user.newPin(id);
</script>