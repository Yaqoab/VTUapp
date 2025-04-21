<head>
<style>
    .more .column div{
      border: none;
    }
 
.container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      column-gap: 10px;
      align-items: center;
    }
    .user-card{
      display: grid;
      grid-template-columns:50px 100px;
      margin: 5px;
      margin-bottom: 10px;
      position: relative;
      text-decoration: none; 
      color: #000;
      border-radius: 5px;
      padding: 5px;
      background-color: #eeee;
      align-items: center;
    }
    .delete{
      position: absolute;
      padding: 0;
      border-top-right-radius: 5px;
      right: 0;
      top: 0;
    }
  </style>

<title>Beneficiaries</title>
</head>
<div id="main" class="mt-5">
 
  <div class="login-box d-flex  justify-content-center m-2">
    <div class="card card-outline card-primary w-60 mt-2">
       <div class="card-header text-center">
          <span class="h5 text-decoration-none text-secondary ">Benefitiaries</span>
       </div>
       <div class="card-body">
            <div class="p-3 " id="beneficiaries" style="height:100vh"> 
            <span id="loading" class="loading"></span>
            </div>
            
        </div>
    </div>
  </div>
</div> 
<script src="./../js/custom.js"></script>
<script>
    const id=<?= $user['user_id'] ?>;
    const user=new MyApp();
    user.benefitiaries(id)

   
</script>
<!-- </html> -->