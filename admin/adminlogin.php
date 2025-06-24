<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> 
     <!-- alert -->
    <script src="../plugins/alert/alertify.min.js"></script>
    <link rel="stylesheet" href="../plugins/alert/css/alertify.min.css" />
    <title>Document</title>
    <style>
          <style>
      body{
          width:calc(100%);
          height:calc(100%);
      }
      #logo-img{
          width:15em;
          height:15em;
          object-fit:scale-down;
          object-position:center center;
      }
      #system_name{
        color:#fff;
        text-shadow: 3px 3px 3px #000;
      }
      /* .login-box{
        width: 50%;
      } */
  </style>
    </style>
</head>
<body>
<div class="login-box d-flex align-items-center justify-content-center vh-100">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <span  class="h2" style="color:#0e615a;">Admin login</span>
      <?php //$pwHash=password_hash("asdf123@", PASSWORD_DEFAULT); ?>
    </div>
    <div class="card-body">
      <form id="adminLogin" action="">
       <label for="email">Email:</label><br>  
      <div class="input-group mb-3">
          <input type="email" class="form-control" id="email" name="email" autofocus placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <label for="password">Password</label><br>  
        <div class="input-group mb-3">
          <input type="password" class="form-control" id="password" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <!-- <span class="text-danger"><?php   ?> </span> -->
        <div class="row align-item-end">
          <div class="col-8">
          </div>
          <!-- /.col -->
          <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6">
          <button type="submit" class="btn btn-block btn-flat text-white" style="background:#0e615a;" name="submit">login</button>
          <button type="button" id="loading" class="form-control btn loading">loading...</button>
          <span id="logError" class="text-danger"></span>
        </div>
          </div>
        </div>

          <!-- /.col -->
        </div>
      </form>   
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<script src="adminjs.js"></script>
<script>
    // const admin=new Admin();
  admin.login();
  // const sendRequest = async (method, endPoint, data = null) => {
  //   const defaultHeaders = {
  //     "Accept": "application/json",
  //     "Content-Type": "application/json",
  //   };
  
  //   try {
  //     const options = {
  //       method: method.toUpperCase(),
  //       headers: defaultHeaders,
  //     };
  
  //     if (method.toLowerCase() === "post" && data) {
  //       options.body = data instanceof FormData ? data : JSON.stringify(data);
  
  //       if (data instanceof FormData) {
  //         delete options.headers["Content-Type"]; // Let the browser set it
  //       }
  //     }
  
  //     const response = await fetch(endPoint, options);
  
  //     if (!response.ok) {
  //       throw new Error(`Error occurred: ${response.statusText}`);
  //     }
  
  //     return await response.json();
  //   } catch (error) {
  //     return Promise.reject({ error: error.message });
  //   }
  // };
  
  //   function login(){
  //     const logError=document.getElementById('logError');
  //       const form=document.getElementById('adminLogin');
  //       const load=document.getElementById('loading');
  //       load.style.display="none";

  //       form.addEventListener('submit',async(event)=>{
  //          event.preventDefault();
  //          load.style.display="block"
  //          const formData = new FormData(form);
            
  //           try {
  //             const res = await sendRequest("POST",`./processlogin.php`,formData);
  //             load.style.display="none"
  //             console.log(res);
  //             if (res.status === "success") {
  //               alertify.success(res.message);
  //               setTimeout(()=>{
  //                 window.location.href = "/index.php"; 
  //               }, 2000)
  //             }else{
  //               logError.textContent=res.message;
  //             }
  //           } catch (error) {
  //             console.error("login error:", error);
  //           }
          

  //       });
  //   }
  //   login()
</script>
</body>
</html>