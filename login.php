<?php
$page = "login.php";
session_start();
error_reporting(0);
include('include/config.php');

if (isset($_POST['login'])) {
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        // username and password sent from form 
        error_reporting(E_ERROR | E_PARSE);
        $myusername = mysqli_real_escape_string($con,$_POST['email']);
        $mypassword = mysqli_real_escape_string($con,$_POST['password']); 
        
        $sql = 'SELECT * FROM user WHERE email = "'.$myusername.'"'.' and Password = "'.$mypassword.'"';

        $result = $con->query($sql);
        $row = $result->fetch_assoc();

        $_SESSION['ID'] = $row["UID"];
        $_SESSION['name'] = $row["fname"].' '.$row['lname'];
        $_SESSION['email'] = $row["email"];
        $_SESSION['phone'] = $row["mobile"];

        if ($result->num_rows > 0) {
        echo '<h1><\h1>';

        $_SESSION['authtoken']=$_POST['email'];
        //$_SESSION['authtoken']='naa';
        header("location: index.php");
        } else {
            echo "<script type=\"text/javascript\">".
                "alert('Invalid Username or Password!');".
                "</script>";
        }

    }
}

if(strlen($_SESSION['authtoken'])!=0)
	{
		
header('location:index.php');

}else{
?>

<!DOCTYPE html>
<html lang="en">
    <head>
  	    <?php include('head.php');?>
    </head>
<body>

    <?php include('header.php');?>
  
    <section id="contact" style="min-height:550px">
        
        <div class="container">
            <div class="container contact-info">
                <div class="section-header" style="text-align:center;margin-bottom:0px">
                    <h2 class="section-title wow fadeInDown" style="border:0px">Login</h2>
                </div>
                <div class="row">
				  <div class="col-sm-4 col-md-4"></div>
                    <div class="col-sm-4 col-md-4">
                        <div class="contact-form">
                            
                            <form action="" method="post" style="text-align:center">
                                <input class="form-control" id="email" name="email" placeholder="Your Email*" type="email" required="required">
                                <br>
                                <input class="form-control" id="password" name="password" placeholder="Password*" type="password" required="required">
                                <br>
                                <button name="login" type="submit" class="btn btn-primary">Login</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>   
   </section><!--/#bottom-->

    <?php include('footer.php');?> 	
</body>
</html>
<?php } ?>