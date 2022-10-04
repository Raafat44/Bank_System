<?php
$action = isset($_GET['action'])?$_GET['action']:"Manage";
$pageName = "Edit User";
include("../includes/template/init.php");
include("../includes/template/AdminNavbar.php");

if($action == "Manage")
{
    $stmnt = $con->prepare(
        'SELECT * from users where ID = ?'
    );
    $stmnt->execute(array($_GET['userID']));
    $Count = $stmnt->rowCount();
    if($Count>0)
    {
        $user = $stmnt->Fetch();
    }
?>
<h1 class="text-center">Edit User Information</h1>
<div class="container">
    <form action="?action=Update&userID=<?php echo $_GET['userID']?>" method="POST">
        <div class="mb-3">
            <label class="form-label">User ID</label>
            <input type="text" name="ID" class="form-control" value="<?php echo $user['ID'] ?>" disabled>
        </div>
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="FullName" class="form-control" value="<?php echo $user['FullName'] ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="Username" class="form-control" value="<?php echo $user['Username'] ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="newPassword" class="form-control">
        </div>
        <div class="mb-3">
            <input type="hidden" name="oldPassword" class="form-control" value="<?php echo $user['Pass'] ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="text" name="Email" class="form-control" value="<?php echo $user['Email'] ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Balance</label>
            <input type="number" name="Balance" class="form-control" value="<?php echo $user['Balance'] ?>">
        </div>
        <div class="mb-3">
            <input type="submit" class="btn btn-primary" class="form-control" >
        </div>        
    </form>
</div>

<?php }elseif($action == "Update")
{
    $username = $_POST['Username'];
    $oldPassword =$_POST['oldPassword'];
    $NewPassword =$_POST['newPassword'];
    $email    = $_POST['Email'];
    $fullName = $_POST['FullName'];
    $balance  = $_POST['Balance'];
    if(!empty($NewPassword))
    {
        $password = sha1($NewPassword);
    }else
    {
        $password = $oldPassword;
    }
    try
    {
        $stmnt = $con->prepare(
            'UPDATE `users` SET `Username` = ?, `Pass` = ? , `FullName` = ? , `Email` = ? ,`Balance` = ? 
            WHERE `ID` = ?'
        );
        $stmnt->execute(array($username,$password,$fullName,$email,$balance,$_GET['userID']));
        $Count = $stmnt->rowCount();
        if($Count>0)
        {
            echo "
            <div class='alert alert-success' role='alert'>
                ADD IS DONE SUCCESSFULLY!!
            </div>";
        }else
        {
            echo "
            <div class='alert alert-danger' role='alert'>
                NO Change Happend!!
            </div>";
        }
    }catch(Exception $e)
    {
        echo 
        '
        <div class="alert alert-danger text-center" role="alert">
            Username Already Exist!!
        </div>
        ';
    }
?>

<?php }
include("../includes/template/footer.php");