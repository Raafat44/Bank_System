<?php
$dsn  = "mysql:host=localhost;dbname=banksystem";
$user = "root";
$pass = "";
try
{
    $con = new PDO($dsn,$user,$pass);
}catch(PDOException $e)
{
    echo "failed"."<br>";
}