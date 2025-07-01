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
    <title>Update profile</title>
</head>
<body>
<div id="main" class="mt-5">
    <div class="container mt-3">
           <h2 class="text-center">update profile</h2>
            <form id="adminUpdateForm">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" value="<?= $admin['username'] ?>" class="form-control" required>
        </div>

        <div class="form-group">
            <label>email</label>
            <input type="text" name="email" value="<?= $admin['email'] ?>" class="form-control" required>
        </div>

        <div class="form-group">
            <label>New Password</label>
            <input type="password" name="new_password" class="form-control">
        </div>

        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        </form>

    </div>
</div>
<!-- Only two scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

<script src="./adminjs.js"></script>
<script>
    const profile=new Admin();
  profile.updteProfile();
  

    </script>