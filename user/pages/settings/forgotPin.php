<head>
  <title>Forgot pin</title>
<style>
    .footernavbar{
        display: none;
    }

</style>
<div id="main" class="box">
    <div class="d-flex justify-content-center m-2 mt-3">
    <div class="card-body mt-5">
         <form action="" id="forgotpin">
            <div class="container">
            <div class="h5 text-decoration-none text-secondary text-center">Forgot pin ?</div>
               <div class="row justify-content-center">
                  <div class="col-sm-6">
                     <label for="farm">Enter your email:</label><br> 
                      <div class="input-group">
                         <input type="text" class="form-control inp" name="email" id="username" autofocus>
                        
                      </div>
                      <span id="emailErr" class="text-danger"></span>
                  </div>  
               </div>
               <div class="row justify-content-center mt-2">
                 <div class="col-lg-8">
                    <input type="submit" value="send" name="edit"  class="btn btn-block btn-flat mb-2">
                    <span id="loading" class="loading"></span>
                  </div>
              </div>
            </form>
         </div>
    </div>
</div>  
<script src="./../js/custom.js"></script>
<script>
  // user id get from include navbar
   const id=<?= $userId ?>;
  const user=new MyApp();
  user.forgotPin(id);
</script>