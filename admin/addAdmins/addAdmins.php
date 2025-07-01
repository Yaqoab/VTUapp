<?php
require_once '../db_connect.php';
require_once '../classes/actions.php';

$actions = new Actions();
$adminList = $actions->select('admin', 'id, username, email, role', '', 'fetchAll');
?>

<head>
    <style>
    
    </style>
    <title>Add admins</title>
</head>
<body>
<div id="main" class="mt-5">
    <div class="container mt-3">
    <h4 class="mb-3 text-center">Admin List</h4>
    <?php if ($_SESSION['vtu_role'] === 'super_admin'): ?>
      <button class="btn btn-success mb-3" onclick="admin.openAdminModal()">+ Add Admin</button>
      <?php endif ?>
<div class="table-responsive">
  <table class="table table-bordered table-striped text-center">
    <thead class="table-dark">
      <tr>
        <th>#</th>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
        <?php foreach ($adminList as $index => $admin): ?>
      <tr>
        <td><?= $index + 1 ?></td>
        <td><?= htmlspecialchars($admin['username']) ?></td>
        <td><?= htmlspecialchars($admin['email']) ?></td>
        <td><?= htmlspecialchars($admin['role']) ?></td>
        <td>
          <?php if ($_SESSION['vtu_role'] === 'super_admin'): ?>
            <?php if ($_SESSION['vtu_admin_id'] != $admin['id']): ?>
              <!-- Only super_admin can edit/delete other admins -->
              <div class="dropdown">
                <button class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">Actions</button>
                <div class="dropdown-menu">
                <?php $adminJson = htmlspecialchars(json_encode($admin), ENT_QUOTES, 'UTF-8'); ?>
                <button class="dropdown-item text-info" onclick='admin.openEditRoleModal(<?= $adminJson ?>)'>
                  Edit
                </button>
                    <button class="dropdown-item text-danger delete-btn" data-id="<?= $admin['id'] ?>">Delete </button>
              </div>
              </div>
            <?php else: ?>
              <!-- Current super_admin viewing self -->
              <em class="text-muted">You</em>
            <?php endif; ?>
          <?php else: ?>
            <!-- Regular admin cannot manage other admins -->
            <em class="text-muted">Restricted</em>
          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>

    </tbody>
  </table>
</div>

<div class="modal fade" id="adminModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="adminForm">
      <div class="modal-content">
        <div class="modal-header"><h5 class="modal-title">Add / Edit Admin</h5></div>
        <div class="modal-body">
          <input type="hidden" id="admin_id" name="id">

          <div class="form-group mb-2">
            <label>Username</label>
            <input type="text" id="username" name="username" class="form-control" required>
          </div>

          <div class="form-group mb-2">
            <label>Email</label>
            <input type="email" id="email" name="email" class="form-control" required>
          </div>

          <div class="form-group mb-2">
            <label>Password</label>
            <input type="password" id="password" name="password" class="form-control">
          </div>

          <div class="form-group mb-2">
            <label>Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" class="form-control">
          </div>

          <div class="form-group mb-2">
            <label>Role</label>
            <select id="role" name="role" class="form-control" required>
              <option value="admin">Admin</option>
              <option value="super_admin">Super Admin</option>
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Role Edit Modal -->
<div class="modal fade" id="editRoleModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form id="editRoleForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Admin Role</h5>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="editRoleId">
          
          <div class="form-group mb-2">
            <label for="editRole">Select Role</label>
            <select name="role" id="editRole" class="form-control" required>
              <option value="admin">Admin</option>
              <option value="super_admin">Super Admin</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Update Role</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>


    </div>
</div>
<!-- Only two scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

<script src="./adminjs.js"></script>
<script>
    const add=new Admin();
  add.addAdmin();
  

    </script>