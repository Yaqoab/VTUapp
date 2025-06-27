<?php
require_once '../db_connect.php';
require_once '../classes/actions.php';
$getTv = new Actions();

$tvPrice = $getTv->select('cable_plan_list','*','','fetchAll');
$getTv->closeConnection();
?>
<head>
    <style>
    
    </style>
    <title>Add tv cables</title>
</head>
<body>
<div id="main" class="mt-5">
<div class="container my-4">
  <h4 class="mb-3 text-center">TV cable list</h4>
  <div class="table-responsive">
    <table id="tv" class="table table-bordered table-striped align-middle text-center">
      <thead class="table-dark">
        <tr>
          <th>Cable name</th>
          <th>Cable plan ID</th>
        </tr>
      </thead>
      <tbody id="TvCables">
         <tr>
           <th>GOTV</th>
           <th>1</th>
         </tr>
         <tr>
           <th>DSTV</th>
           <th>2</th>
         </tr>
         <tr>
           <th>STARTINE</th>
           <th>3</th>
         </tr>
      </tbody>
    </table>
  </div>

  <h4 class="mb-3 text-center">Cable Plan List</h4>
<div class="table-responsive">
  <button class="btn btn-primary mb-3" onclick="admin.openCableModal()">Add Cable Plan</button>

  <table id="tv" class="table table-bordered table-striped align-middle text-center">
    <thead class="table-dark">
      <tr>
        <th>#</th>
        <th>Cable Plan Name</th>
        <th>Amount</th>
        <th>Cable ID</th>
        <th>Cable Plan ID</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody id="TvCables">
      <?php foreach ($tvPrice as $index => $tv): ?>
        <tr id="cable-row-<?= $tv['id'] ?>">
          <td><?= $index + 1 ?></td>
          <td><?= $tv['planName'] ?></td>
          <td><?= '₦'.$tv['amount'] ?></td>
          <td><?= $tv['cableID'] ?></td>
          <td><?= $tv['cablePlanID'] ?></td>

          <td>
            <div class="dropdown">
              <button class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">
                Actions
              </button>
              <div class="dropdown-menu">
                <button class="dropdown-item text-info"
                  onclick='admin.openCableModal(<?= json_encode($tv) ?>)'>
                  Edit
                </button>
                <button class="dropdown-item text-danger delete-btn"
                  data-id="<?= $tv['id'] ?>">
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

<!-- Cable Modal -->
<div class="modal fade" id="cableModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form id="cableForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add / Edit Cable Plan</h5>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="cable_id">

          <div class="form-group mb-2">
            <label for="planName">Plan Name</label>
            <input type="text" class="form-control" id="planName" name="planName" required>
          </div>
          <div class="form-group mb-2">
            <label for="amount">Amount</label>
            <input type="amount" class="form-control" id="amount" name="amount" required>
          </div>

          <div class="form-group mb-2">
            <label for="cableID">Cable ID</label>
            <input type="text" class="form-control" id="cableID" name="cableID" required>
          </div>

          <div class="form-group mb-2">
            <label for="cablePlanID">Cable Plan ID</label>
            <input type="text" class="form-control" id="cablePlanID" name="cablePlanID" required>
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

<!-- Only two scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

<script src="./adminjs.js"></script>
<script>
    const tv=new Admin();
  tv.tvCables();
  

    </script>