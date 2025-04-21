<head>
   <title>search user</title>
   <style>
    .footernavbar{
        display: none;
    }
   
    /* Custom Card Link Styling */
.card-link {
  text-decoration: none;
  color: #333;
  display: grid;
  grid-template-columns: 50px 200px;
  align-items: center;
  column-gap: 20px;
}

.user-card {
      display: grid;
      grid-template-columns: 50px 3fr;
      column-gap: 20px;
      align-items: center;
      text-decoration: none; 
      color: #000;
      border: 1px solid #ddd;
      border-radius: 5px;
      padding: 5px;
      background-color: #f8f8f8;
    }

    .user-card img {
      max-width: 100%;
      height: 50px;
      border-radius: 50%;
    }
  
</style>
</head>
<div id="main" class="box">
  <div class="container mt-2">
     <div class="row justify-content-center">
         <div class="col-md-6">
             <div class="card mt-5">
                 <div class="card-body">
                    <form action="" id="transfer">
                          <div class="h5 text-decoration-none text-secondary text-center">Search user</div>
                          <div class="form-group">
                              <label for="search" class="text-secondary">phone number</label>
                              <input type="number" class="form-control form-control-sm" name="num" id="input"  autofocus >
                          </div>
                     </form>
                      <div id="result">
                      
                        
                      </div>
                      <span id="loading" class="loading"></span>
                      </div>
                </div>
             </div>
         </div>
    </div>
</div>
<script src="./../js/custom.js"></script>
<script>
    const id=<?= $user['user_id'] ?>;
    const user=new MyApp();
    user.searchUser(id)
</script>