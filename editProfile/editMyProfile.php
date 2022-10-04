<?php
$pageName = "Edit MY Profile";
include("../includes/template/init.php");
$action = isset($_GET['action'])?$_GET['action']:"Manage";
$status = $_SESSION['Status']==0?"User":"Admin";
if($status == "Admin")
{
    include("../includes/template/AdminNavbar.php");
}else
{
    include("../includes/template/UserNavbar.php");
}
if($action == "Manage")
{
    $stmnt = $con->prepare(
        'SELECT * from users where ID = ?'
    );
    $stmnt->execute(array($_SESSION['ID']));
    $Count = $stmnt->rowCount();
    if($Count>0)
    {
        $user = $stmnt->Fetch();
    }
?>
<h1 class="text-center">Edit MY Profile</h1>
<div class="container">
    <form action="?action=Update" method="POST">
        <div class="mb-3">
            <label class="form-label">Full name</label>
            <input type="text" name="Fullname" value = "<?php echo $user['FullName'] ?>" class="form-control" >
        </div>
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="Username" value = "<?php echo $user['Username'] ?>" class="form-control" >
        </div>        
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="hidden" name="oldPassword" value="<?php echo $user['Pass'] ?>">
            <input type="password" name="newPassword" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="Email" value = "<?php echo $user['Email'] ?>" class="form-control"  >
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
    $fullName = $_POST['Fullname'];
    if(!empty($NewPassword))
    {
        $password = sha1($NewPassword);
    }else
    {
        $password = $oldPassword;
    }
    $stmnt = $con->prepare(
        'UPDATE `users` SET `Username` = ?, `Pass` = ? , `FullName` = ? , `Email` = ? 
        WHERE `ID` = ?'
    );
    $stmnt->execute(array($username,$password,$fullName,$email,$_SESSION['ID']));
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
}
include("../includes/template/footer.php");