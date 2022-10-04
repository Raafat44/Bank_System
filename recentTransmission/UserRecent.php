<?php
$pageName = "Recent Transmissions";
include("../includes/template/init.php");
include("../includes/template/UserNavbar.php");
if(isset($_SESSION['ID']))
{
    $stmnt = $con->prepare(
        'SELECT * from recent_transmissions
        where senderID = ? or recieverID =?'
    );
    $stmnt->execute(array($_SESSION['ID'] ,$_SESSION['ID'] ));
    $Count = $stmnt->rowCount();
    $recents = $stmnt->FetchAll();
    ?>
    <div class="container">
        <input type="text" class="form-control search" style="width:20%;margin-top:30px" placeholder="Search By Transmission ID" value="">
        <table class="transTable">
            <thead>
                <tr>
                    <th style="width: 200px;">Transmission ID</th>
                    <th style="width: 300px;">Sender Name</th>
                    <th style="width: 300px;">Reciever Name</th>
                    <th style="width: 200px;">Date</th>
                    <th style="width: 200px;">Amount</th>
                </tr>
            </thead>
            <?php
                foreach($recents as $recent)
                {
            ?>   
            <tr data-id="<?php echo $recent['ID'] ?>">
                <td><?php echo $recent['ID'] ?></td>
                <td><?php echo $recent['senderID']." - ".$recent['senderName'] ?></td>
                <td><?php echo $recent['recieverID']." - ".$recent['recieverName'] ?></td>
                <td><?php echo $recent['date'] ?></td>
                <td><?php echo $recent['amount']."$" ?></td>        
            </tr> 
            <?php
                }
            ?>            
        </table>
    </div>
<?php
}else
{
    echo
    '
    <div class="alert alert-warning ">
        Sorry You Need to Login First to view your Recent Transmisions!!
    </div>
    ';
}
include("../includes/template/footer.php");