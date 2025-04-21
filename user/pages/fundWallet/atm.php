<?php 


?>
<head>
    <style>
         .footernavbar{
        display: none;
       }
   </style>
   <title>Pay with ATM</title>
</head>
<div id="main" class="box">
    <?php 
        
       

    ?>
    <div class="d-flex justify-content-center m-2 mt-3">
        <div class="card-body mt-5">
            <form action="" id="forgotpin">
                <div class="container">
                <div class="h5 text-decoration-none text-secondary text-center">Pay with Atm</div>
                <div class="row justify-content-center">
                    <div class="col-sm-6">
                        <label for="farm">Enter Amount:</label><br> 
                        <div class="input-group">
                            <input type="number" class="form-control inp" name="amount" id="inputamt" autofocus>
                            
                        </div>
                        <div class="text-secondary mt-2">
                            <span>amount to pay + charge</span><br>
                            <span id="amount">Amount: ₦0.00</span> + 50<br>
                            <span id="total">Total: ₦0.00</span>
                        </div>
                        <span id="err" class="text-danger"></span>
                    </div>  
                </div>
                <div class="row justify-content-center mt-2">
                    <div class="col-lg-8">
                        <input type="button" value="pay with ATM"  onclick="payWithMonnify()"  class="btn btn-block btn-flat mb-2">
                        <span id="loading" class="loading"></span>
                    </div>
                </div>
                </form>
            </div>
     </div>
</div>
<script type="text/javascript" src="https://sdk.monnify.com/plugin/monnify.js"></script>
    <script>
 const inputAmount = document.getElementById('inputamt');
const amount = document.getElementById('amount');
const total = document.getElementById('total');
const err = document.getElementById('err');
const userEmail = '<?= $user['email'] ?>';
const userName = '<?= $user['username'] ?>';
let totalAmt = 0; 
console.log(userName);

inputAmount.addEventListener('input', () => {
    const inputValue = inputAmount.value.trim();
    if (inputValue !== "") {
        const numericVal = parseFloat(inputValue);
        amount.textContent = "Amount: " + formatAmount(numericVal);
        total.textContent ="Total: " + formatAmount(numericVal + 50);
        totalAmt = numericVal + 50;
        console.log(totalAmt);
    } else {
        amount.textContent = "Amount: ₦0.00";
        total.textContent = "Toatal: ₦0.00";
        totalAmt = 0; // Set totalAmt to 0 if input is empty
    }
});

function formatAmount(value) {
    return `₦${value.toFixed(2)}`;
}
// 
const api = "<?= $monnify_details['api']?>";
const contract_code = "<?= $monnify_details['contractCode']?>";


function payWithMonnify() {
    if (totalAmt > 0) {
        MonnifySDK.initialize({
            amount: totalAmt,
            currency: "NGN",
            reference: new String((new Date()).getTime()),
            customerFullName: userName,
            customerEmail: userEmail,
            apiKey: api,
            contractCode: contract_code,
            paymentDescription: "Lahray World",

            paymentMethods: [
                "CARD",
            ],
            onLoadStart: () => {
                console.log("loading has started");
            },
            onLoadComplete: () => {
                console.log("SDK is UP");
            },
            onComplete: function (response) {
                // Implement what happens when the transaction is completed.
                console.log(response);
            },
            onClose: function (data) {
                // Implement what should happen when the modal is closed here
                console.log(data);
            }
        });
    } else {
        err.textContent = "please enter amount"
    }
}





       
        </script>