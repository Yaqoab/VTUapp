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
    <title>Electricity</title>
</head>
<div id="main" class="mt-5 box">
<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5">
                <div class="card-body">
                     <form action="" id="electricity">
                        <div class="container">     
                         
                           <div class="form-group mt-2">
                                 <select name="cableName" class="form-control plance" id="discoNames">
                                   <option value="">Select Disco name</option>
                                   <option class="tv-card" value="18">Ikeja Electric</option>
                                   <option class="tv-card" value="19">Ibadan Electric</option>
                                   <option class="tv-card" value="20">Eko Electric</option>
                                   <option class="tv-card" value="21">Kaduna Electric</option>
                                   <option class="tv-card" value="22">Kano Electric</option>
                                 </select>
                                 <span id="errName" class="text-danger"></span>
                              </div>
                           
                              <div class="icu-con position-relative">
                                        <div class="input-group w-100 mt-2">
                                            <input type="number" class="form-control" name="meter" id="meter-number" placeholder="meter number" autofocus>
                                        </div>
                                        <div class="favorite position-absolute top-0 start-0">
                                        </div>
                                   </div>
                                   <span id="errMeter" class="text-danger"></span>
                                   
                                   <div class="form-group mt-2">
                                 <select name="meterType" class="form-control plance" id="meterType">
                                   <option value="">Meter type</option>
                                   <option class="tv-card" value="prepaid">Prepaid</option>
                                   <option class="tv-card" value="postpaid">PostPaid</option>
                                 </select>
                                 <span id="errType" class="text-danger"></span>
                              </div>
                              
                              <div class="amount-con position-relative">
                                        <div class="input-group w-100 mt-3">
                                            <input type="number" class="form-control" name="amount" id="amount"  placeholder="amount" autofocus >
                                        </div>
                                    </div>
                                    <span id="errAmount" class="text-danger"></span>

                                    <div class="amount-con position-relative">
                                        <div class="input-group w-100 mt-3">
                                            <input type="number" class="form-control" name="phone" id="phone"  placeholder="customer phone optional" autofocus >
                                        </div>
                                    </div>
                                    <span id="errPhone" class="text-danger"></span>

                                    <div class="input-group w-100 mt-3">
                                    <input type="number" class="form-control " name="pin" id="pin" placeholder="Transaction pin" autofocus>
                                 </div>
                                 <span id="errPin" class="text-danger"></span>

                           <div class="row justify-content-center mt-2">
                           <div class="col-lg-8">
                              <input type="submit" value="Pay" name="edit"  class="btn btn-block btn-flat mb-2">
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
  const services=new OurServices();
        services.electricity(id);



</script>