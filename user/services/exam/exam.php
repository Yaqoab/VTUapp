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
    <title>Exams result pin</title>
</head>
<div id="main" class="mt-5 box">
<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5">
                <div class="card-body">
                     <form action="" id="exam">
                        <div class="container">     
                         
                           <div class="form-group mt-2">
                                 <select name="exam" class="form-control plance" id="examname">
                                   <option value="">Select exam</option>
                                   <option class="exam-card" value="WAEC" data-price="2000">WAEC</option>
                                   <option class="exam-card" value="NECO" data-price="1000">NECO</option>
                                   <option class="exam-card" value="NABTEB" data-price="800">NABTEB</option>
                                 </select>
                                 <span id="errExam" class="text-danger"></span>
                              </div>
                           
                              <div class="exam-con position-relative">
                                        <div class="input-group w-100 mt-2">
                                            <input type="number" class="form-control" name="quantity" id="quantity" value="1" placeholder="quantity" autofocus>
                                        </div>
                                        <div class="favorite position-absolute top-0 start-0">
                                        </div>
                                   </div>
                                   <span id="errquantity" class="text-danger"></span>
                                   
                              <div class="amount-con position-relative">
                                        <div class="input-group w-100 mt-3">
                                            <input type="text" class="form-control" name="amount" id="amount" value="0"  placeholder="amount" autofocus >
                                        </div>
                                    </div>
                                    <span id="errAmount" class="text-danger"></span>

                                    <div class="input-group w-100 mt-3">
                                    <input type="password" class="form-control " name="pin" id="pin" placeholder="Transaction pin" autofocus>
                                 </div>
                                 <span id="errPin" class="text-danger"></span>

                           <div class="row justify-content-center mt-2">
                           <div class="col-lg-8">
                              <input type="submit" value="Buy pin" name="edit"  class="btn btn-block btn-flat mb-2">
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
        services.exams(id);



</script>