<header id="header">
        <nav id="main-nav" class="navbar navbar-default navbar-fixed-top" role="banner">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php"><img src="images/logo.png" alt="logo"></a>
                </div>
				
                <div class="collapse navbar-collapse navbar-right">
                    <ul class="nav navbar-nav">
                        <li class="scroll <?php echo ($page == "index.php" ? "active" : "")?>"><a href="index.php">Home</a></li>  
                        <li class="scroll"><a href="index.php#services">Services</a></li>
                        <?php
                            if(strlen(isset($_SESSION['authtoken'])))
                            {
                                echo '<li class="scroll '.($page == "booking.php" ? "active" : "").'"><a href="booking.php">Booking</a></li>';
                                echo '<li class="scroll '.($page == "past-bookings.php" ? "active" : "").'"><a href="past-bookings.php">Past Bookings</a></li>';
                            }
                        ?>
                        <li class="scroll"><a href="index.php#about">About</a></li> 
                        <li class="scroll"><a href="index.php#contact-us">Contact</a></li>         
                        
                        <?php
                            
                            if(strlen(isset($_SESSION['authtoken'])))
                            {
                                echo '<li class="scroll"><a href="logout.php">Logout</a></li>';

                            }else{
                                echo '<li class="scroll '.($page == "login.php" ? "active" : "").'"><a href="login.php">Login</a></li>';
                                echo '<li class="scroll '.($page == "signUP.php" ? "active" : "").'"><a href="signUp.php">SignUp</a></li>';
                            }
                        ?>
                    </ul>
                </div>
            </div><!--/.container-->
        </nav><!--/nav-->
    </header><!--/header-->