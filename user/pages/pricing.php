<?php 
    require_once '../db_connect.php';
    require_once "../classes/actions.php";
  $getPlan =new Actions();

$query ="SELECT 
p.id, p.data_id, p.Amount, p.size, p.Validity,
d.Plan_name,
n.name AS network_name
FROM datapricelist p
INNER JOIN dataplantype d ON d.plan_id = p.plan_id
INNER JOIN networks_list n ON n.networks_id = d.networks_id ORDER BY network_name
";
$priceList = $getPlan->select('RAW_QUERY', $query, '', 'fetchAll');

$getPlan->closeConnection();
?>
<head>
    <title>Pricing</title>
    <style>
        .footernavbar{
            display: none;
        }
     .nofication-read{
        background-color: #f1f4f7;
     }
     .nofication-unread{
       background-color: #98b9b6;
       color: #fff;
     }
    </style>
</head>
<div id="main" class="mt-5">

    <div class="container mt-5" id="container">
    <div class="container my-4">
    <div class="table-responsive mt-3">
  <h4 class="mb-3 text-center">Data plan list</h4>
  <table id="priceTable" class="table table-bordered table-striped align-middle text-center">
    <thead class="table-primary bg-grey">
      <tr>
        <th>#</th>
        <th>Network Name</th>
        <th>Plan Name</th>
        <th>Data ID</th>
        <th>Amount (₦)</th>
        <th>Size</th>
        <th>Validity</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($priceList as $index => $price): ?>
        <tr id="price-row-<?= $price['id'] ?>">
          <td><?= $index + 1 ?></td>
          <td><?= $price['network_name'] ?></td>
          <td><?= $price['Plan_name'] ?></td>
          <td><?= $price['data_id'] ?></td>
          <td><?= $price['Amount'] ?></td>
          <td><?= $price['size'] ?></td>
          <td><?= $price['Validity'] ?></td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>
         
    </div>
    </div>
</div>
<script src="./../js/custom.js"></script>
