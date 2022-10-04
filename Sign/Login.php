<?php
$pageName = "Login";
include("../includes/template/init.php");
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $username = $_POST['Username'];
    $pass = sha1($_POST['Password']);
    $stmnt = $con->prepare(
        'SELECT * from users 
        where Username = ? and Pass = ?'
    );
    $stmnt->execute(array($username,$pass));
    $user = $stmnt->Fetch();
    $count = $stmnt->rowCount();
    if($count >0)
    {
        $_SESSION['FullName'] = $user['FullName'];
        $_SESSION['Status']   = $user['Status'];
        $_SESSION['ID']       = $user['ID'];
        if($user['Status'] == 0)
        {
            header("Location: ../Home/index.php");
        }else
        {
            header("Location: ../Admin/DashBoard.php");
        }
    }else
    {
        echo '
        <div class="alert alert-danger" role="alert">
            Wrong User Name or Password!!
        </div>
        ';
    }
}
?>
    <form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
    <h4 class="text-center">Login</h4>
    <input class="form-control" type="text" name="Username" placeholder="Username" required />
    <input class="form-control" type="password" name="Password" placeholder="Password" required/>
    <input class="btn btn-primary"type="submit" value="login"><br>
    <a href="signup.php" style="text-decoration:none;">Don't have an account? </a><br>
    <a href="forgotPassword.php" style="text-decoration:none;">Forgot your password?</a>
</form>
<?php
include("../includes/template/footer.php");