<?php
$pageName = "Make Transmissions";
include("../includes/template/init.php");
include("../includes/template/AdminNavbar.php");
if($_SERVER['REQUEST_METHOD']=="POST")
{
    $senderSplit   = explode('|', $_POST['senderID']);   
    $recieverSplit = explode('|', $_POST['recieverID']);  

    $senderID   = $senderSplit[0] ;
    $senderName = $senderSplit[1];

    $recieverID   = $recieverSplit[0];
    $recieverName = $recieverSplit[1];
    $amount        = $_POST['amount'];    

    $stmnt = $con->prepare(
        'SELECT Balance from users
        where ID = ?'
    );
    $stmnt->execute(array($senderID));
    $senderBalance = $stmnt->Fetch(); 

    if($senderID != $recieverID && $amount >0 && $senderBalance['Balance'] >= $amount)
    {
        $stmnt = $con->prepare(
            'UPDATE users SET Balance = Balance - ?
            WHERE ID = ?');
            $stmnt->execute(array($amount,$senderID));
            $stmnt = $con->prepare(
            'UPDATE users SET Balance = Balance + ?
            WHERE ID = ?'
            );
        $stmnt->execute(array($amount,$recieverID)); 
        $count = $stmnt->rowCount();
        if($count >0)
        {
            $stmnt = $con->prepare(
                'INSERT INTO `recent_transmissions` (`senderID`, `recieverID`,`date`, `amount`,`senderName`,`recieverName`) 
                VALUES (?,?,now(),?,?,?);'
                );
            $stmnt->execute(array($senderID,$recieverID,$amount,$senderName,$recieverName));
            echo "<div class='alert alert-success text-center' role='alert'>
                    Transmission is Successfully Done!!
                </div>";
        }       
    }else
    {
        echo 
        '
        <div class="alert alert-danger text-center" role="alert">
            TRANSACTION FAILED !!
        </div>
        ';
    }
}
$stmnt = $con->prepare(
    'SELECT * from users'
);
$stmnt->execute();
$Count = $stmnt->rowCount();
if($Count>0)
{
    $users = $stmnt->FetchAll();
}

?>
<div class="container">
    <h1 >Transfer Money</h1>
</div>
<table style="margin-bottom: 50px ;">
    <tr>
        <th style="width: 300px;">Sender</th>
        <th style="width: 300px;">Reviever</th>
        <th style="width: 200px;">Amount</th>
    </tr>     
    <form id="transmissionForm" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
        <tr>
            <td>
                <select class="form-select" name="senderID" style="width:80%;margin:15px auto;">
                    <option value=""></option>
                    <?php
                        foreach($users as $user)
                        {
                    ?>
                        <option value="<?php echo $user["ID"]."|".$user['FullName'] ?>"> <?php echo  $user["ID"] ." - " .$user['FullName'] . " - " . $user['Balance'] . "$" ?> </option>
                    <?php 
                        } 
                    ?>
                </select>
            </td>
            <td>
                <select class="form-select" name="recieverID" style="width:80%;margin:15px auto;" >
                    <option value=""></option>
                    <?php
                        foreach($users as $user)
                        {
                    ?>
                        <option value="<?php echo $user["ID"]."|".$user['FullName']  ?>"> <?php echo  $user["ID"] ." - " .$user['FullName'] . " - " . $user['Balance'] . "$"   ?> </option>
                    <?php 
                        } 
                    ?>
                </select>
            </td>    
            <td>
                <input name="amount" type="number" class="amount text-center form-control" style="width:80%;margin:15px auto;">
            </td>
        </tr> 
    </form>
</table>
<div class="container" style="text-align: center;margin-bottom: 200px;">
    <button form="transmissionForm" style="width: 300px;" class=" transfer btn btn-success">Transfer</button>
</div>


<?php
include("../includes/template/footer.php");