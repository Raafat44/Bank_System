<?php
$pageName = "Home";
include("../includes/template/init.php");
include("../includes/template/UserNavbar.php");
?>
<section class="firstSec " >
    <div class="container">
    <div class="row ">
        <div  class="col-md-6" style="text-align: center; margin-top:100px ;color: white;">
            <h4>Welcome to</h4>
            <h1>BANKY.eg Bank</h1>
        </div>
        <div  class="col-md-6 spacingOne">
            <img style="text-align: center; " class="img-fluid" src="../layout/images/bankimage.png" alt="">
        </div>
    </div>
    </div>          
</section>
<section>
<div class="container">
    <div style="display: flex; flex-wrap: wrap; justify-content: center;">
        <div class="col-sm-6" style="margin-top: 50px; margin-bottom: 50px;" ><img src="../layout/images/user.jpg"  alt=""><a class="btn btn-primary" style=" margin-left:50px ; width:150px ; display: block;text-align: center;" href="../makeTransmission/UserMake.php">Make Transmissions</a></div>
        <div class="col-sm-6" style="margin-top: 50px; margin-bottom: 50px;" ><img src="../layout/images/history.jpg" alt=""><a class="btn btn-primary" style="margin-left:40px ;width:200px ; display: block;text-align: center;" href="../recentTransmission/UserRecent.php">View Recent Transmissions</a></div>
    </div>
</div>
</section>

<?php
include("../includes/template/footer.php");