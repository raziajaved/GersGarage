<?php
$page = "signUp.php";
session_start();
error_reporting(0);
include('include/config.php');
$error = Null;
$msg = Null;

if(isset($_GET['s']))
{
	 
	$fn= mysqli_real_escape_string($con,$_POST['fname']);
	$ln= mysqli_real_escape_string($con,$_POST['lname']);
	$email= mysqli_real_escape_string($con,$_POST['email']);
	$password= mysqli_real_escape_string($con,$_POST['password']);
	$mob= mysqli_real_escape_string($con,$_POST['mobile']);
	$add= mysqli_real_escape_string($con,$_POST['address']);
	
	

	$sql="INSERT INTO  user(fname,lname,password, email ,mobile,address) VALUES('$fn','$ln','$password','$email','$mob','$add')";

	if($con->query($sql) === TRUE)
	{
	
		echo "<script type=\"text/javascript\">".
        		"alert('You have successfully registered with Ger\'s Garage!');".
                "window.location.href='login.php';".
        	"</script>";
	}
	else 
	{
	
		echo "<script type=\"text/javascript\">".
        		"alert('Something went wrong. Please try again!');".
        	"</script>"; 
	}

}
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
                    <h2 class="section-title wow fadeInDown" style="border:0px">Sign Up</h2>
                </div>
                <div class="row">
				  <div class="col-sm-4 col-md-4"></div>
                    <div class="col-sm-4 col-md-4">
                        <div class="contact-form">

                            <form action="signUp.php?s" id="form1" style="text-align:center" name="register" method="post">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="fname" name="fname" maxlength="20" placeholder="Your First Name" required>
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control" id="fname" maxlength="30" name="lname" placeholder="Your Last Name" required>
                                </div>
                                
                                <div class="form-group">
                                    <input type="email" class="form-control" id="email" maxlength="60" name="email" placeholder="Your Email" required>
                                </div>
                                
                                <div class="form-group">
                                    <input type="password" class="form-control" id="password" maxlength="16" name="password" placeholder="Your Password" required>
                                </div>
                                
                                <div class="form-group">
                                    <input type="text" class="form-control" id="mobile" maxlength="10" name="mobile" placeholder="Your Mobile Number" required>
                                </div>
                                
                                <div class="form-group">
                                    <input type="text" class="form-control" id="address" maxlength="100" name="address" placeholder="Your Address" required>
                                </div>
                                
                                <div>
                                    <button class="btn btn-primary" name="register" type="submit">Sign Up</button>
                                </div>
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