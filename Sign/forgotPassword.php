<?php
$pageName = "Login";
include("../includes/template/init.php");
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $username = $_POST['Username'];
    $email = $_POST['Email'];
    $pass = sha1($_POST['Password']);
    $stmnt = $con->prepare(
        'SELECT * from users 
        where Username = ? and Email = ?'
    );
    $stmnt->execute(array($username,$email));
    $user = $stmnt->Fetch();
    $count = $stmnt->rowCount();
    if($count >0)
    {
        $stmnt = $con->prepare(
            'UPDATE `users` SET `Pass` = ?
            WHERE Username = ? and Email =?
        ');
        $stmnt->execute(array($pass,$username,$email));
        header("Location: Login.php");
    }else
    {
        echo '
        <div class="alert alert-danger" role="alert">
            Sorry We Couldn\'t Identify You with Entered Information
        </div>
        ';
    }
}
?>
<form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
    <h4 class="text-center">Reset Password</h4>
    <input class="form-control" type="text" name="Username" placeholder="Username" required />
    <input class="form-control" type="email" name="Email" placeholder="Email" required/>
    <input class="form-control" type="password" name="Password" placeholder="New Password" required/>
    <input class="btn btn-primary"type="submit" value="Reset">
</form>
