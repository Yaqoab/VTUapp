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
    <!-- <div class="col-md-6 mx-auto mb-2 p-0 ">     
        <a href="#" class="card-link bt-1">
            <div class="card transaction-card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <span class="h5 card-title">Airtime</span><br>
                        <i class="card-text">14th, November, 2024</i>
                    </div>
                    <div class="text-right">
                        <span class="badge text-white" style="background:#85e589">success</span><br>
                        <span class="fw-bold">5000</span>
                    </div>
                </div>
            </div>
        </a>
   </div> -->
     <!-- jQuery -->
     <div id="pagination" class="text-center mt-3"></div>


    </div>
</div>
<script src="./../user/pages/transaction_table/transactionTable.js"></script>
<script>
   const id=<?= $user['user_id'] ?>;

//    const data = [];
// for (let i = 1; i <= 100; i++) {
//   data.push(`Item ${i}`);
// }

// $('#pagination-container').pagination({
//   dataSource: data,
//   pageSize: 10,
//   showPrevious: true,
//   showNext: true,
//   callback: function(data, pagination) {
//     let html = '<ul>';
//     $.each(data, function(index, item) {
//       html += `<li>${item}</li>`;
//     });
//     html += '</ul>';
//     $('#data-container').html(html);
//   }
// });

</script> 
