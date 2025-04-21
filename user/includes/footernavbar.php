<style>

</style>
<div class="row text-center footerbar pt-1">
    <div class="col-sm-3">
        <a href="index.php">
        <i class="fa fa-house-user fonts"></i><br>
        <span>Home</span>
        </a>
    </div>
    <div class="col-sm-3">
        <a href="index.php?page=pages/transaction_table/transaction_table">
        <i class="fa fa-history fonts"></i><br>
        <span>Transactions</span>
        </a>
    </div>
    <div class="col-sm-3">
    <a href="index.php?page=pages/refferal/refferal">
        <i class="fa fa-external-link"></i><br>
        <span>Refferal</span>
        </a>
    </div>
    <div class="col-sm-3">
        <a href="index.php?page=more">
        <i class="fa-solid fa-ellipsis "></i><br>
        <span>more</span>
        </a>
    </div>
</div>
<script>
    const menu=document.querySelectorAll('.footerbar div a');
    const path = window.location.href;
    menu.forEach(anchor => {
        if (anchor.href === path) {
            anchor.parentElement.classList.add('activefooter');
      }
    });
    
    // set navbar header
    const title=document.getElementById('title');
    const back=document.getElementById('back')
    const getTitle = document.title;
    title.textContent=getTitle;
    
    back.addEventListener('click',function(){
        window.history.back()
    })
</script>