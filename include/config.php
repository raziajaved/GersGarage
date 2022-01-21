<?php 

try
{
    $con = mysqli_connect('localhost','root','','gersgarage');
}
catch (Exception $e)
{
    exit("Error: " . $e->getMessage());
}
?>