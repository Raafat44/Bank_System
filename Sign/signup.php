<?php
$pageName = "SignUp";
include("../includes/template/init.php");
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $username = $_POST['username'];
    $password = sha1($_POST['password']);
    $email    = $_POST['email'];
    $fullname = $_POST['fullname'];    
    $_SESSION['FullName'] = $fullname;
    $_SESSION['Status']   = 0;
    try
    {
        $stmnt = $con->prepare(
            'INSERT into users (`Username`, `Pass`, `Email`, `FullName`,`Date`)
            values (?,?,?,?,now())
            '
        );
        $stmnt->execute(array($username,$password,$email,$fullname ));
        $count = $stmnt->rowCount();
        if($count>0)
        {
            $stmnt = $con->prepare(
                "SELECT ID from users 
                where Username = ? and Pass = ?"
            );
            $stmnt->execute(array($username,$password));
            $return = $stmnt->fetch();
            $_SESSION['ID'] = $return['ID'];
            header("Location: ../Home/index.php");
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

}
?>
<form class="login" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" >
    <h4 class="text-center">SignUp</h4>
    <input class="form-control" type="text" name="username" placeholder="Username" required/>
    <input class="form-control" type="password" name="password" placeholder="Password" required/>
    <input class="form-control" type="email" name="email" placeholder="Email" required/>
    <input class="form-control" type="FullName" name="fullname" placeholder="FullName" required/>
    <input class="btn btn-primary" type="submit" value="SignUp">
</form>

<?php
include("../includes/template/footer.php");