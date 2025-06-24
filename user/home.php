<style>
    .referrals{
    background-color:  #7f8d88;
    width: 150px;
   }
</style>
<div class=""><?php include "includes/navbar.php" ?></div>
<div id="main" class="mt-5">
     <div class="balance p-3">
     <div class="container">
          <div class="row p-1 balancefontsize">
              <div class="col-sm-4 eye">
                  <span><i class="" id="balance"></i> Balance</span><br>
                  <span id="nunakudi"></span>
              </div>
              <div class="col-sm-4">
                  <a href="index.php?page=pages/fundWallet/payments">
                  <i class="fa-regular fa-plus font" aria-hidden="true"></i><br>
                  <span>fund wallet</span>
                  </a>
              </div>
              <div class="col-sm-4">
                  <a href="index.php?page=pages/transfer/searchUser">
                  <i class="fa fa-money-bill-transfer font"></i><br>
                  <span>Transfer</span>
                  </a>
              </div>
            </div>
     </div>
      </div>
      <div class="services mt-4 mb-4">
        <div class="container">
          <!-- <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
          <span class="sr-only">Loading...</span> -->
          <h5 class="p-2">Our servicecs</h5>
             <div class="row">
            <div class="col-sm-3">
                <a href="index.php?page=services/data/data">
                <i class="fa-sharp fa-regular fa-signal fonts"></i><br>
                <span>Data</span>
                </a>
            </div>
            <div class="col-sm-3">
               <a href="index.php?page=services/airtime/airtime">
               <i class="fa-regular fa-phone fonts"></i><br>
                <span>Airtime</span>
               </a>
            </div>
            <div class="col-sm-3">
                <a href="index.php?page=services/tv/tv">
                <i class="fa-regular fa-tv fonts" aria-hidden="true"></i><br>
                <span>Tv</span>
                </a>
            </div>
            <div class="col-sm-3">
                <a href="index.php?page=services/electricity/electricity">
                <i class="fa-regular fa-lightbulb fonts"></i><br>
                <span>Electricity</span>
                </a>
            </div>
            <div class="col-sm-3">
             <a href="index.php?page=services/exam/exam">
             <i class="fa-regular fa-graduation-cap fonts"></i><br>
                <span>Exams</span>
             </a>
            </div>

             </div>
        </div>
      </div>
      <div class="data">
         <div class="data-info">
        <div class="container">
          <div class="row p-1 balancefontsize">
          <div class="col-md-4 text-center">
                  <div>Total data bought</div>
                  <div>200GB</div>
              </div>
              <div class="col-md-4 text-center">
                  <div>Data bought today</div>
                  <div>4GB</div>
              </div>
              <div class="col-md-4 text-center">
                  <div>Data bought this week </div>
                  <div>6GB</div>
              </div>
              <div class="col-md-4 text-center">
                  <div>Data bought this month </div>
                  <div>20GB</div>
              </div>
            </div>
        </div>
        </div>
      </div>
   	</div>
    <script>
      function formatNaira(amount) {
        const options = {
            style: 'currency',
            currency: 'NGN',
            minimumFractionDigits: 2
        };
        return amount.toLocaleString('en-NG', options);
        }
        const bal=<?= $user['balance'] ?>;
        const formattedAmount = formatNaira(bal);
        const balance = document.getElementById('balance');
const nunakudi = document.getElementById('nunakudi');
const showBalance = "fa-regular fa-eye font small";
const hideBalance = "fa-regular fa-eye-slash font small";

if (localStorage.getItem('showBalance') === showBalance) {
  balance.className = showBalance;
  nunakudi.textContent = formattedAmount;
} else if (localStorage.getItem('hideBalance') === hideBalance) {
  balance.className = hideBalance;
  nunakudi.textContent = '***';
} else {
  balance.className = showBalance;
}

balance.addEventListener("click", () => {
  if (localStorage.getItem('showBalance') === showBalance) {
    localStorage.removeItem('showBalance');
    localStorage.setItem('hideBalance', hideBalance);
    balance.className = hideBalance;
    nunakudi.textContent = '****';
  } else if (localStorage.getItem('hideBalance') === hideBalance) {
    localStorage.removeItem('hideBalance');
    localStorage.setItem('showBalance', showBalance);
    balance.className = showBalance;
    nunakudi.textContent = formattedAmount;
  } else {
    localStorage.setItem('showBalance', showBalance);
  }
});
       
    </script>