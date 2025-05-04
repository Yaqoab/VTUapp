    <head>
    <title>Transactions history</title>
    <style>
     .transaction-card{
        /* background-color: #f1f4f7; */
        background-color: #f1f4f7;
     }
     .nofication-unread{
       background-color: #98b9b6;
       color: #fff;
     }
     .category-selected{
        background-color: #599ca3;
        color: #fff;
     }
     .category-unselected{
        background-color: #f1f4f7;
     }
     #main{
        margin-bottom: 70px;
     }
    </style>
</head>
<div id="main" class="mt-4">
    <div class="container mt-5 " id="container">
    <div class="row d-flex justify-content-center" id="categories">
        <div class="badge p-2 m-2 category-selected cat" id="all" >All</div>
    </div>
   <div id="transcontainer">
   
   </div>
   <span id="loading" class="loading"></span>
  
     <div id="pagination" class="text-center mt-3"></div>


    </div>
</div>
<script src="./../user/pages/transaction_table/transactionTable.js"></script>
<script>
   const id=<?= $user['user_id'] ?>;

</script> 
