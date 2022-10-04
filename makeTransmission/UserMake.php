<?php
$pageName = "Make Transmissions";
include("../includes/template/init.php");
include("../includes/template/UserNavbar.php");
if(isset($_SESSION['ID']))
{
    if($_SERVER['REQUEST_METHOD']=="POST" )
    {
        $senderID   = $_POST['senderID'];
        $recieverID = $_POST['recieverID'];
        $amount   = $_POST['amount'];
        if($amount !="" && $amount >0 && $_SESSION['senderBalance']>=$amount)
        {
            $stmnt = $con->prepare(
                'SELECT ID from users
                where ID = ?'
            );
            $stmnt->execute(array($recieverID));        
            $existCheck = $stmnt->rowCount();
    
            if($existCheck > 0)
            {
                $stmnt = $con->prepare(
                'UPDATE users SET Balance = Balance - ?
                WHERE ID = ?'
                );
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
                        'SELECT FullName from users
                        where ID = ?'
                        );
                    $stmnt->execute(array($recieverID));
                    $recieverName = $stmnt->fetch();
                    $stmnt = $con->prepare(
                        'INSERT INTO `recent_transmissions` (`senderID`, `recieverID`,`date`, `amount`,`senderName`,`recieverName`) 
                        VALUES (?,?,now(),?,?,?);'
                        );
                    $stmnt->execute(array($senderID,$recieverID,$amount,$_SESSION['FullName'],$recieverName['FullName']));
                    echo "<div class='alert alert-success text-center' role='alert'>
                            Transmission is Successfully Done!!
                        </div>";
                }        
            }else
            {
                echo 
                '
                <div class="alert alert-warning text-center" role="alert">
                    Please Enter a Valid User ID!!
                </div>
                ';
            }    
        }else
        {
            echo 
            '
            <div class="alert alert-warning text-center" role="alert">
                Please Make Sure you are Entering the right Amount!!
            </div>
            ';
        }
    }
    $stmnt = $con->prepare(
        'SELECT * from users where ID = ?'
    );
    $stmnt->execute(array($_SESSION['ID']));
    $Count = $stmnt->rowCount();
    if($Count>0)
    {
        $user = $stmnt->Fetch();
        $_SESSION['senderBalance'] = $user['Balance'];
    }
    ?>
    <h1>My Information</h1>
    <div class="container">
    <table>
        <tbody class="cusdata">
            <tr>
                <th style="width: 300px;">ID</th>
                <th style="width: 300px;">Name</th>
                <th style="width: 300px;">Email</th>
                <th style="width: 200px;">Balance</th>
            </tr>
            <tr>
                <td style="width: 300px;"><?php echo $user['ID'] ?></td>
                <td style="width: 300px;"><?php echo $user['FullName'] ?></td>
                <td style="width: 300px;"><?php echo $user['Email'] ?></td>
                <td style="width: 200px;"><?php echo $user['Balance'] . "$" ?></td>
            </tr>
        </tbody>
    </table>
    <h1 >Transfer Money</h1>
    </div>
    <table style="margin-bottom: 50px ;">
        <tr>
            <th style="width: 300px;">Sender ID</th>
            <th style="width: 300px;">Reviever ID</th>
            <th style="width: 200px;">Amount</th>
        </tr>     
        <tr>
        <form id="transmissionForm" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
            <td>
                <input type="text" class="sender text-center" value = "<?php echo $_SESSION['ID'] ?>" Disabled >
                <input name="senderID" type="hidden" class="sender text-center" value = "<?php echo $_SESSION['ID'] ?>" >
            </td>
            <td><input name="recieverID" type="text" class="reciever text-center"></td>
            <td><input name="amount" type="number" class="amount text-center"></td>
        </form>
        </tr> 
    </table>
    <div class="container" style="text-align: center;margin-bottom: 60px;">
        <button type="submit" form="transmissionForm" style="width: 300px;" class=" transfer btn btn-success">Transfer</button>
    </div>
<?php
}else
{
    echo
    '
    <div class="alert alert-warning ">
        Sorry You Need to Login First to be able to make Transmisions!!
    </div>
    ';
}
include("../includes/template/footer.php");