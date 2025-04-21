<head>
   <title>Edit details</title>
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
                     <form action="" id="editform">
                        <div class="container">
                           <div class="card-head h5 text-decoration-none text-secondary text-center">Edit details</div>
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
                                    <input type="text" class="form-control " name="username" id="username" autofocus>
                                    
                                 </div>
                                 <span id="userError" class="text-danger"></span>
                              </div>
                              <div class="col-sm-6">
                                 <label for="farm">email:</label><br> 
                                 <div class="input-group">
                                    <input type="text" class="form-control " name="email" id="email" autofocus >
                                 
                                 </div>
                                 <span id="emailError" class="text-danger"></span> 
                              </div>
                              <div class="col-sm-6 ">
                                 <label for="phone">Phone:</label><br> 
                                 <div class="input-group">
                                    <input type="number" class="form-control " name="phone" id="phone" autofocus >
                                 </div>
                                 <span id="phoneError" class="text-danger"></span>
                              </div>
                              <div class="col-sm-6">
                              <label for="image">Image:</label><br>
                              <div class="input-group">
                                    <div class="custom-file">
                                    <input type="file" class="custom-file-input form-control " id="imageInput" name="image" autofocus>
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
                              <input type="submit" value="save changes" name="edit"  class="btn btn-block btn-flat mb-2">
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
<script>
      //  Make the custom file input label show the selected file name
      document.getElementById("imageInput").addEventListener("change", function() {
    const fileName = this.files[0].name;
    const label = this.nextElementSibling;
    label.innerHTML = fileName;
  });
//   i get this id from navbar
  const id=<?= $user['user_id'] ?>;
  const user=new MyApp();
  user.getEditUser(id);

</script>
   