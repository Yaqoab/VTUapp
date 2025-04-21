<?php
  $categories=new Actions;
  
  $catId=$categories->select("categories","*","cat_name='data'");
?>
<head>
    <style>
        .footernavbar{
            display: none;
        }
    .mtn{
      background: url('./../images/mtn.png');
    }
    .airtel{
      background: url('./../images/airtel.png');
    }
    .glo{
      background: url('./../images/glo.png');
    }
    .mobile9{
      background: url('./../images/9mobile.png');
    }
    .net-card{
      background-size: cover;
      position: relative;
      width: 50px;
      height: 50px;
      border: 1px solid #ddd;
      margin: 5px;
      border-radius: 7px;
    }
    .layer{
      background-color: rgba(248, 247, 216, 0.7);
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      pointer-events: none;
     
    }
    .layer:before{
       content:"\2713" ;
       font-size: 25px;
    }
    .phone-con {
    position: relative;
    }

    .favorite {
        position: absolute;
        top: 50px;
        left: 0;
        background-color: rgba(255, 255, 255, 0.7);
        padding: 5px; /* Adjust padding as needed */
    }

    </style>
    <title>Data</title>
</head>
<div id="main" class="mt-5 box">
<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5">
                <div class="card-body">
                     <form action="" id="dataform">
                        <div class="container">     
                          <?php   
                          //  echo $response; 
                            // echo $user['balance'];
                          ?>   
                                            <!-- this DIV id numbers is a network provider -->
                           <div class="row d-flex justify-content-center" name="network">
                              <div class="net-card mtn" id="1">
                                  <div class="">
                                      
                                  </div>
                              </div>
                              <div class="net-card airtel" id="3">
                                  <div class="">
                                     
                                  </div>
                              </div>
                              <div class="net-card glo" id="2">
                                  <div class="">
                                     
                                  </div>
                              </div>
                              <div class="net-card mobile9" id="4">
                                  <div class="">
                                     
                                  </div>
                              </div>
                              
                           </div>
                           <span id="errNetwork" class="text-danger"></span>

                              <div class="form-group mt-2">
                                 <select name="" class="form-control plance" id="plan-type">
                                   <option value="">Select plan type</option>
                                
                                 </select>
                              </div>
                              <span id="errPlan" class="text-danger"></span>

                              <div class="form-group mt-2">
                                 <select name="data-plan" class="form-control plance" id="planlist">
                                   <option value="">Select price list</option>
                                 
                                 </select>
                                 <span id="errPrice" class="text-danger"></span>
                              </div>
                             
                                
                                    <div class="phone-con position-relative">
                                        <div class="input-group w-100 mt-2">
                                            <input type="number" class="form-control" name="phone" id="phone" placeholder="phone number" autofocus>
                                        </div>
                                        <div class="favorite position-absolute top-0 start-0">
                                            <!-- <span>Pin</span> -->
                                        </div>
                                    </div>
                                    <span id="errPhone" class="text-danger"></span>

                                 <div class="input-group w-100 mt-3">
                                    <input type="password" class="form-control " name="pin" id="pin" placeholder="Transaction pin" autofocus>
                                 </div>
                                 <span id="errPin" class="text-danger"></span>

                           <div class="row justify-content-center mt-2">
                           <div class="col-lg-8">
                              <input type="submit" value="buy" name="edit"  class="btn btn-block btn-flat mb-2">
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
<script src="services/js/ourServices.js"></script>
<script>
  const id=<?= $user['user_id'] ?>;
  const catId=<?= $catId['cat_id'] ?>;

  const services=new OurServices();
  services.dataBundle(id,catId);

</script>