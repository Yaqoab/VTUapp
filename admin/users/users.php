<head>
    <style>
    
    </style>
    <title>Users</title>
</head>
<body>
<div id="main" class="mt-5">

    
    <div class="container my-4">
  <h4 class="mb-3 text-center">Users table</h4>
  <div class="table-responsive">
    <table id="usersTable" class="table table-bordered table-striped align-middle text-center">
      <thead class="table-dark">
        <tr>
            <th>#</th>
          <th>User Name</th>
          <th>email</th>
          <th>Phone</th>
          <th>balance</th>
          <th>Image</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="userstable">
          
      </tbody>
    </table>

  </div>
</div>

 <!-- edit Modal -->
 <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form id="editUserForm">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">Adjust User Balance</h5>
                </div>
                <div class="modal-body">
                <!-- Hidden User ID -->
                <input type="hidden" id="user_id" name="id">

                <!-- Current balance (optional) -->
                <div class="form-group">
                    <label>Current Balance</label>
                    <input type="text" id="current_balance" class="form-control" readonly>
                </div>

                <!-- Amount to add or subtract -->
                <div class="form-group">
                    <label>Amount to Add/Subtract</label>
                    <input type="number" id="adjust_balance" name="adjust_balance" class="form-control">
                </div>
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Update Balance</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
                </div>
            </div>
            </form>
        </div>





</div>

<!-- Only two scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

<script src="./adminjs.js"></script>
<script>
    const users=new Admin();
  users.users();
  

    </script>