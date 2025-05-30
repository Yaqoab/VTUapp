<?php
    require_once "./../classes/actions.php";
    require_once './../db_connect.php';

    $referralURL = "http";
    // Check if the request is using HTTPS
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $currentURL .= "s";
    }
    // referral link the i get user from navbar page
    $referralURL .= "://$_SERVER[HTTP_HOST]/vtuApp/register.php?referral=$user[referral_code]";

    $get_referrals=new Actions;

    $ref_count=$get_referrals->count("referrals","*", "referrer_id ='$userId'");

        // Get total commission
    $referrals = $get_referrals->select("referrals", "*", "referrer_id = '$userId'", "fetchAll");
    $total_commission = 0;
    foreach ($referrals as $ref) {
        $total_commission += $ref['commission'] ?? 0;
    }
   
    $get_referrals->join('users u','INNER JOIN','u.user_id = r.referee_id ');
    $referrals_list = $get_referrals->select('referrals r','r.*, u.username, u.phone',"r.referrer_id= '$userId'","fetchAll");
   

?>
<head>
    <style>
        .more .column div{
      border: none;
    }
   /* .refferal{
      display: grid;
      grid-template-columns:1fr 1fr 1fr;
      gap: 10px;
   }
   .refferal> .ref{
    border: 1px solid #ccc;
    border-radius: 20px;
    padding: 5px;
   } */
   .referrals{
    background-color:  #7f8d88;
    width: 150px;
   }
   .link{
    background-color: #e3ebf3;
    padding: 5px;
   }




   #referral-link-div {
            background-color: #f4f4f4;
            padding: 20px;
            border-radius: 5px;
        }

        #referral-link {
            font-size: 18px;
            font-weight: bold;
        }
        .share-icons > a{
           margin: 10px;
        }
        .image-icons{
          width: 50px;
          height: 50px;
        }
    </style>
    <title>Refferal</title>
</head>
<div id="main" class="mt-5">

    <div class="container">
    
        <div class="text-center" id="referral-link-div">
            <h4>Referral Link</h4>
            <p>Copy this link and reffer it to your friends and family you will get 2% bonus on deposit</p>
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="referral-link" value="<?= $referralURL ?>" readonly>
                <div class="input-group-append">
                    <button class="btn btn-primary" id="copy-button">
                        <i class="fas fa-copy"></i> Copy
                    </button>
                </div>
            </div>
               <h5 class="mt-5">Or direct to social media</h5>
            <div class="share-icons">
            <a  href="https://www.facebook.com/sharer.php?u=<?= $referralURL ?>" target="_blank">
                <img  src="./../images/facebook.jpg" class="rounded-circle image-icons" alt="Facebook Share">
            </a>
            <a href="whatsapp://send?text=<?= $referralURL ?>" target="_blank">
                <img src="./../images/whatsapp.png" class="rounded-circle image-icons" alt="WhatsApp Share">
            </a>
            <a href="https://twitter.com/intent/tweet?url=<?= $referralURL ?>&code=youruniquecode&text=Check out this referral link:" target="_blank">
                <img  src="./../images/x.twitter.png" class="rounded-circle image-icons" alt="Twitter Share">
            </a>
        </div>

        <div class="referrals-info p-3">
        <div class="container">
          <div class="row p-1 balancefontsize">
              <div class="col-sm-4">
                  <span> Total Referrals <span class="rounded-circle bg-white"><?= $ref_count ?></span></span>
              </div>
              <div class="col-sm-4">
                  <span>Total commission <span class="rounded-circle bg-white"><?= $total_commission ?></span></span>
              </div>
            </div>
        </div>
        </div>
        </div>
    </div>
    
    <div class="container my-4">
  <h4 class="mb-3 text-center">My Referrals list</h4>
  <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle text-center">
      <thead class="table-dark">
        <tr>
            <th>#</th>
          <th>Referee Name</th>
          <th>Phone</th>
          <th>Commission</th>
          <th>Referred On</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($referrals_list as $index => $ref): ?>
          <tr>
            <td><?= $index + 1 ?></td>
            <td><?= $ref['username'] ?></td>
            <td><?= htmlspecialchars($ref['phone']) ?></td>
            <td>₦<?= number_format($ref['commission'], 2) ?></td>
            <td><?= date('M d, Y', strtotime($ref['referral_date'])) ?></td>
          </tr>
        <?php endforeach ; ?>
      </tbody>
    </table>
  </div>
</div>


</div>
<script>
        // Function to copy the referral link to the clipboard
        function copyToClipboard() {
            const referralLink = document.getElementById('referral-link');
            referralLink.select();
            document.execCommand('copy');
        }

        // Add click event listener to the copy button
        const copyButton = document.getElementById('copy-button');
        copyButton.addEventListener('click', copyToClipboard);
    </script>