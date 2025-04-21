<head>
  <title>change pin</title>
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
                    <form action="" id="changePin">
                        <div class="container">
                          <div class="card-head h5 text-decoration-none text-secondary text-center">Change pin</div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="oldpin">Old Pin:</label><br>
                                    <div class="input-group">
                                        <input type="password" class="form-control inp" name="oldpin" id="oldpin" autofocus>
                                    </div>
                                    <span id="oldPinErr" class="text-danger"></span>
                                </div>
                                <div class="col-sm-12">
                                    <label for="newpin">New Pin:</label><br>
                                    <div class="input-group">
                                        <input type="password" class="form-control inp" name="newpin" id="newpin" autofocus>
                                    </div>
                                    <span id="newPinErr" class="text-danger"></span>
                                </div>
                                <div class="col-sm-12">
                                    <label for="confirmPin">Confirm:</label><br>
                                    <div class="input-group">
                                        <input type="password" class="form-control inp" name="confirmPin" id="confirmPin" autofocus>
                                    </div>
                                    <span id="confirmPinErr" class="text-danger"></span>
                                </div>

                            </div>
                            <div class="row justify-content-center mt-2">
                                 <div class="col-lg-8 text-center">
                                    <span class="border p-1 rounded"><i id="showtext">show</i> <span class="fas fa-eye-slash show" id="show"></span></span>
                                 </div>
                              </div>
                            <div class="row justify-content-center mt-2">
                                <div class="col-lg-8">
                                    <input type="submit" value="Change" name="edit" class="btn btn-block btn-flat mb-2">
                                    <span id="loading" class="loading"></span>
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
<script src="./../js/custom.js"></script>
<script src="./../js/showOrHide.js"></script>
<script>
  // user id get from include navbar
   const id=<?= $userId ?>;
  const user=new MyApp();
   user.changePin(id);
</script>