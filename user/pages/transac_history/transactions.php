<head>
<title>transfer receipt</title>
<style>
  .footernavbar{
            display: none;
        }
   
 #main {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh; 
} 

</style>
</head>
<div id="main" class="mt-4 " >
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <!-- <div class="card-header bg-primary text-white">
                    Receipt
                </div> -->
                <div class="card-body text-muted">
                <span id="loading" class="loading"></span>
                    <!-- <div class="w-100 position-relative">
                        <span class="h4 card-title" id="transfertitle">loading...</span>
                        <span class="card-text position-absolute" style="right:0" id="amount">loading...</span>
                    </div>
                    <hr>
                    <h5 class="card-title">Transaction Details</h5>
                    <p class="card-text"><strong>Status:</strong> <span id="status">loading...</span></p>
                    <p class="card-text"><strong>Sender:</strong> <span id="sender">loading...</span></p>
                    <p class="card-text"><strong>Reciever:</strong> <span id="receiver">loading...</span></p>
                    <p class="card-text"><strong>Sender account:</strong> <span id="senderacc">loading...</span></p>
                    <p class="card-text"><strong>Reciever account:</strong> <span id="receiveracc">loading...</span></p>
                    <p class="card-text"><strong>Remark:</strong> <span id="remark">loading...</span></p>
                    <p class="card-text"><strong>Date:</strong> <span id="date">loading...</span></p> -->
                <!-- </div>
                <div class="card-footer text-muted">
                    Thank you for using our service!
                </div> -->
            </div>
        </div>
    </div>
</div>
</div>
<script src="./../user/pages/transac_history/display_transaction.js"></script>
<script>
    const id=<?= $user['user_id'] ?>;
    // const user=new MyApp();
    // user.transferReciept(id)
</script>