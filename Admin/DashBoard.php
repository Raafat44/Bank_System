<?php
$action = isset($_GET['action'])?$_GET['action']:"Manage";
$pageName = $action=="Add"?"Add New User":"DashBoard";
include("../includes/template/init.php");
include("../includes/template/AdminNavbar.php");
if($action == "Manage")
{
    $stmnt = $con->prepare(
        'SELECT * from users order by ID  asc'
    );
    $stmnt->execute();
    $Count = $stmnt->rowCount();
    $users = $stmnt->FetchAll();
?>
<div class="container">
    <input type="text" class="form-control search" style="width:20%;margin-top:30px" placeholder="Search By ID or Name" value="">
    <table>
        <thead>
            <th style="width: 200px;">ID</th>
            <th style="width: 300px;">Name</th>
            <th style="width: 300px;">Email</th>
            <th style="width: 200px;">Status</th>
            <th style="width: 200px;">Balance</th>
            <th style="width: 200px;">SignUp Date</th>
            <th style="width: 200px;">Controls</th>
        </thead>
        <tbody>
            <?php
            foreach($users as $user)
            {
            ?>   
                <tr data-id="<?php echo $user['ID'] ?>" data-name="<?php echo strtolower($user['FullName']) ?>">
                    <td><?php echo $user['ID'] ?></td>
                    <td><?php echo $user['FullName'] ?></td>
                    <td><?php echo $user['Email'] ?></td>                
                    <td><?php echo $user['Status']==0?'User':'Admin' ?></td>                
                    <td><?php echo $user['Balance']."$" ?></td>   
                    <td><?php echo $user['Date'] ?></td>   
                    <td>
                        <a href="../editProfile/editUser.php?userID=<?php echo $user['ID'] ?>" class="btn btn-success">Edit</a>
                        <a class="btn btn-danger" onclick = "request('','Delete','GET',<?php echo $user['ID']  ?>)">Delete</a>
                    </td>      
                </tr>
            <?php
            }
            ?>  
        <tbody>
    </table>
    <a href="?action=Add" class="btn btn-primary">Add New User</a>
</div>
<div class="col-md-4 stat text-center m-auto">
    <h3>Total Users</h3>
    <span><?php echo $Count ?></span>
</div>
<?php }elseif($action == "Add")
{
?>
<form class="login" action="?action=Insert" method="POST">
    <h4 class="text-center">Add New User</h4>
    <input class="form-control" type="text" name="user" placeholder="Username" required />
    <input class="form-control" type="password" name="pass" placeholder="Password" required/>
    <input class="form-control" type="email" name="email" placeholder="Email" required/>
    <input class="form-control" type="text" name="fullname" placeholder="FullName" required/>
    <input class="form-control" type="number" name="Balance" placeholder="Balance" required/>
    <select class="form-select" name="status">
        <option value="0">User</option>
        <option value="1">Admin</option>
    </select>
    <br>
    <input class="btn btn-primary" type="submit" value="Submit">
</form>
<?php }elseif($action == "Insert")
{
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        $username = $_POST['user'];
        $password =sha1($_POST['pass']);
        $email    = $_POST['email'];
        $fullName = $_POST['fullname'];
        $balance  = $_POST['Balance'];
        $status  = $_POST['status'];
        try
        {
            $stmnt = $con->prepare(
            'INSERT INTO `users` ( `Username`, `Pass`, `Email`, `FullName`, `Balance`,`Status`,`Date`) 
                VALUES (?,?,?,?,?,?,now())
            ');
            $stmnt->execute(array(
                $username,$password,$email,$fullName,$balance,$status
            ));
            $Count = $stmnt->rowCount();
            if($Count>0)
            {
                echo "
                <div class='alert alert-success' role='alert'>
                    ADDITION IS DONE SUCCESSFULLY!!
                </div>";
            }
        }catch(Exception $e) {
            echo "
                <div class='alert alert-danger' role='alert'>
                    SORRY THIS USER NAME IS ALREADY USED PLEASE TRY ANOTHER ONE!!
                </div>";
        }
    }
}elseif($action == "Delete")
{
    $stmnt = $con->prepare(
        'DELETE from users where ID = ?
        ');
    $stmnt->execute(array(
        $_GET['ID']
    ));
}
include("../includes/template/footer.php");