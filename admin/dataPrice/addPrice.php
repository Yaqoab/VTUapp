<?php 
    require_once '../db_connect.php';
    require_once "../classes/actions.php";
  $getPlan =new Actions();
  
  $getPlan->join('networks_list n','INNER JOIN', 'n.networks_id = d.networks_id');
  $planType = $getPlan->select('dataplantype d','d.*, n.name AS networks','','fetchAll');

 
  $getPlan->join('dataplantype d', 'INNER JOIN', 'd.plan_id = p.plan_id');
$getPlan->join('networks_list n', 'INNER JOIN', 'n.networks_id = d.networks_id');

$priceList = $getPlan->select(
  'datapricelist p',
  'p.id,p.data_id, p.Amount, p.size, p.Validity, d.Plan_name, n.name AS network_name',
  '',
  'fetchAll'
);
$getPlan->closeConnection();
?>
<head>
    <style>
    
    </style>
    <title>Users</title>
</head>
<div id="main" class="mt-5">


<div class="table-responsive mt-3">
<h4 class="mb-3 text-center">Data plan list</h4>
<button type="button" class="btn btn-primary mb-3" onclick="admin.openPlanModal()">
    + Add Plan Type
  </button>
            <table class="table table-bordered table-striped align-middle text-center">
            <thead class="table-primary bg-grey">
                <tr>
                <th>#</th>
                <th>Networks name</th>
                <th>Plan name</th>
                <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($planType as $index => $plan): ?>
                <tr id="plan-row-<?= $plan['plan_id'] ?>">
                <td><?= $index + 1 ?></td>
                <td><?= $plan['networks'] ?></td>
                <td><?= $plan['Plan_name'] ?></td>
                <td>
                    <button class="btn btn-danger btn-sm deletePlan-btn" data-id="<?= $plan['plan_id'] ?>">
                    Delete
                    </button>
                </td>
                </tr>
                <?php endforeach ?>
            </tbody>
            </table>
        </div>

       <!-- Plan Type Modal -->
       <div class="modal fade" id="planModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form id="planForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Plan Type</h5>
        </div>
        <div class="modal-body">
          <!-- Network -->
          <div class="form-group mb-2">
            <label for="network">plan name</label>
            <select name="network" id="plntype" class="form-control" required>
              <option value="">Select Network</option>
              <option value="1">MTN</option>
              <option value="3">Airtel</option>
              <option value="2">Glo</option>
              <option value="4">9mobile</option>
              
            </select>
          </div>

          <!-- Plan Name -->
          <div class="form-group mb-2">
            <label for="plan_name">Plan Name</label>
            <input type="text" id="plan_name" name="plan_name" class="form-control" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save Plan</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>
                       <!-- ---------- price list table---------- -->
 <hr>
 <div class="table-responsive mt-3">
  <h4 class="mb-3 text-center">Data plan list</h4>
  <button type="button" class="btn btn-primary mb-3" onclick="admin.openPriceModal()">+ Add Price</button>

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
        <th>Actions</th>
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
          
          <td>
            <div class="dropdown">
              <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
                Actions
              </button>
              <div class="dropdown-menu">
                <button class="dropdown-item text-primary"
                        onclick='admin.openPriceModal(<?= htmlspecialchars(json_encode($price), ENT_QUOTES, "UTF-8") ?>)'>
                  Edit
                </button>
                <button class="dropdown-item text-danger deleteprice-btn" price-id="<?= $price['id'] ?>">
                  Delete
                </button>
              </div>
            </div>
          </td>

        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>
<!-- form priceModal  -->
<div class="modal fade" id="priceModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form id="priceForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add / Edit Data Price</h5>
        </div>
        <div class="modal-body">
          <input type="hidden" id="id" name="id">

          <div class="form-group mb-2">
            <label for="plan_id">Plan</label>
            <select name="plan_id" id="plan_id" class="form-control" required>
              <option value="">Select Plan</option>
              <?php foreach ($planType as $plan): ?>
                <option value="<?= $plan['plan_id'] ?>"><?= $plan['Plan_name'] ?> (<?= $plan['networks'] ?>)</option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group mb-2">
            <label for="data_id">Data_id</label>
            <input type="text" id="data_id" name="data_id" class="form-control" required>
          </div>

          <div class="form-group mb-2">
            <label for="Amount">Amount (₦)</label>
            <input type="number" id="Amount" name="Amount" class="form-control" required>
          </div>

          <div class="form-group mb-2">
            <label for="size">Size (e.g., 1GB)</label>
            <input type="text" id="size" name="size" class="form-control" required>
          </div>

          <div class="form-group mb-2">
            <label for="Validity">Validity (e.g., 30 days)</label>
            <input type="text" id="Validity" name="Validity" class="form-control" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>


</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="./adminjs.js"></script>
<script>
   const addPrice = new Admin();
   addPrice.addPriceData();

 
    </script>