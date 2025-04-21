<head>
  <title>change password</title>
<style>
    .footernavbar{
        display: none;
    }
 
</style>
<div id="main" class="box">
  <div class="container mt-5">
     <div class="row justify-content-center">
         <div class="col-md-6">
             <div class="card mt-5">
                 <div class="card-body">
                      <form action="" id="password">
                         <div class="container">
                            <div class="card-head h5 text-decoration-none text-secondary text-center">Change pin</div>
                           <div class="row">
                              <div class="col-sm-12">
                                 <label for="farm">old password:</label><br> 
                                 <div class="input-group">
                                    <input type="password" class="form-control inp" name="old" id="username" autofocus>
                                    
                                 </div>
                                 <span id="old" class="text-danger"></span>
                              </div>
                              <div class="col-sm-12">
                                 <label for="farm">new password:</label><br> 
                                 <div class="input-group">
                                    <input type="password" class="form-control inp" name="new" autofocus >
                                 
                                 </div>
                                 <span id="new" class="text-danger"></span> 
                              </div>
                              <div class="col-sm-12">
                                 <label for="phone">confirm:</label><br> 
                                 <div class="input-group">
                                    <input type="password" class="form-control inp" name="confirm" autofocus >
                                 </div>
                                 <span id="confirm" class="text-danger"></span>
                              </div>

                           </div>
                             
                              <div class="row justify-content-center mt-2">
                                 <div class="col-lg-8 text-center">
                                    <span class="border p-1 rounded"><i id="showtext">show</i> <span class="fas fa-eye-slash show" id="show"></span></span>
                                 </div>
                              </div>

                           <div class="row justify-content-center mt-2">
                           <div class="col-lg-8">
                              <input type="submit" value="change" name="edit"  class="btn btn-block btn-flat mb-2">
                              <span id="loading" class="loading"></span>
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
  user.changePass(id);
</script>
   