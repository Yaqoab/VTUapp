<?php
require_once '../db_connect.php';
require_once '../classes/actions.php';
$getTrans = new Actions();

$query = "SELECT dt_id AS id, 'data' AS category, cat_id, user_id, date, amount, status, reference, NULL AS transaction_type
FROM data_history

UNION ALL

SELECT t_id AS id, 'tv_Cable' AS category, cat_id, user_id, date, amount, status, reference, NULL AS transaction_type
FROM tvcable_history

UNION ALL

SELECT air_id AS id, 'airtime' AS category, cat_id, user_id, date, amount, status, reference, NULL AS transaction_type
FROM airtime_history

UNION ALL 

SELECT e_id AS id, 'electricity' AS category, cat_id, user_id, date, amount, status, reference, NULL AS transaction_type
FROM electric_history

UNION ALL 

SELECT transfer_id AS id, 'transfer' AS category, cat_id, sender_id AS user_id, date, amount, status, reference, 'Sent' AS transaction_type
FROM transfer

UNION ALL 

SELECT transfer_id AS id, 'transfer' AS category, cat_id, receiver_id AS user_id, date, amount, status, reference, 'Received' AS transaction_type
FROM transfer

UNION ALL 

SELECT dep_id AS id, 'deposit' AS category, cat_id, user_id, date, amount, status, reference, NULL AS transaction_type
FROM deposit_history

ORDER BY date DESC";

$getAll = $getTrans->select('RAW_QUERY', $query, '', 'fetchAll');

$getTrans->closeConnection();
?>
<head>
    <style>
    
    </style>
    <title>transaction</title>
</head>
<body>
<div id="main" class="mt-5">
    <div class="container mt-3">
    <div class="table-responsive mt-3">
  <h4 class="mb-3 text-center">Transactions</h4>

  <table id="transaction" class="table table-bordered table-striped align-middle text-center">
    <thead class="table-primary bg-grey">
      <tr>
        <th>#</th>
        <th>Reference</th>
        <th>Category</th>
        <th>amount</th>
        <th>status</th>
        <th>Details</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($getAll as $index => $trans): ?>
        <tr id="price-row-<?= $trans['id'] ?>">
          <td><?= $index + 1 ?></td>
          <td><?= $trans['reference'] ?></td>
          <td><?= $trans['category'] ?></td>
          <td><?= $trans['amount'] ?></td>
          <td><?= $trans['status'] ?></td>
          <td><a href="index.php?page=transactions/viewDetails&catname=<?= $trans['category'] ?>&uId=<?= $trans['user_id'] ?>&ref=<?= $trans['reference'] ?>" class="card-link bt-1">view details</a></td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>

    </div>
</div>
<!-- Only two scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

<script>
    $('#transaction').DataTable({
            pageLength: 10,     
            lengthChange: false, 
            ordering: true,     
            searching: true 
          });
</script>