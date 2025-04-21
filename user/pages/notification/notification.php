<head>
    <title>Notifications</title>
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
        <!-- <div class="row"> -->
        <span id="loading" class="loading"></span>
        <!-- </div> -->
    </div>
</div>
<script src="./../js/custom.js"></script>
<script>
     // user id get from include navbar
   const id=<?= $userId ?>;
  const user=new MyApp();
   user.notification(id);

</script>