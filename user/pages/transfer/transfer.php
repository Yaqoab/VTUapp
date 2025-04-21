<head>
    <title>transfer</title>
    <style>
         .footernavbar{
        display: none;
       }
    .parentinput{
    position: relative;
    display: inline-block
    }
    #remark{
        padding-right: 30px;
    }
    .parentinput> .limit{
        position: absolute;
        background-color:gray;
        color: #fff;
        border-radius: 5px;
        padding: 2px;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
    }
    
    </style>
</head>
<div id="main" class="box">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5">
                <div class="card-body">
                        <div class="container">
                          <div class="row justify-content-center text-center text-success">
                                <div class="col-md-12">
                                   <img src="" id="image" class="rounded-circle img-profile border" alt="user">
                                </div>
                                <div class="col-md-12">
                                    <i id="name"></i>
                                    <p id="phone"></p>
                                </div>
                          </div>
                        </div>
                       <form action="" id="transfer">
                            <div class="form-group">
                                <label for="amount" class="text-secondary">Amount</label>
                                <input type="number" class="form-control form-control-sm" name="amount" id="input"  autofocus >
                                <span id="amountErr" class="text-danger"></span>
                            </div>
                            <div class="form-group">
                                <label for="remark" class="text-secondary">Remark</label>
                                <div class="parentinput d-flex">
                                    <input type="text" class="form-control form-control-sm" name="remark" id="remark" maxlength="50" autofocus>
                                    <div class="limit f-right" id="limit"><span id="countDown">50</span></div>
                                </div>
                                <span id="remarkErr" class="text-danger"></span>
                            </div>

                            <div class="form-group">
                                <label for="pin" class="text-secondary">pin</label>
                                <input type="number" class="form-control form-control-sm" name="pin" id="input"  autofocus >
                                <span id="pinErr" class="text-danger"></span>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="confirm" style="width:120px;margin:0 auto"  class="btn btn-primary btn-block btn-flat btn-sm mb-2">
                                <span id="loading" class="loading"></span>
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
     const id=<?= $user['user_id'] ?>;
    const user=new MyApp();
    user.transfer(id)
</script>