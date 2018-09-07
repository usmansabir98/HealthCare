<?php
  include("includes/config.php");
  include("includes/classes/UserAccount.php");
  include("includes/classes/RetailerAccount.php");
   include("includes/classes/Constants.php");

  $Haccount = new UserAccount($con);  
  $Uaccount = new UserAccount($con);

  $Raccount = new RetailerAccount($con);


  include("includes/handlers/register-handler.php");

  include("includes/handlers/login-handler.php");

  function getInputValue($name) {
    if(isset($_POST[$name])) {
      echo $_POST[$name];
    }
  }

  if (isset($_GET['logout'])) {
    session_destroy();
  }
?>


<!DOCTYPE html>
<html lang="en">
  <head>  <title>Register!</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

   <!-- Bootstrap CDN -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  
  <!-- Google Font link -->
  <link href="https://fonts.googleapis.com/css?family=Do+Hyeon" rel="stylesheet">
  
  <!-- Font Awesome CDN -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

    <!-- Google Font link -->
    

    <!-- CSS Style Sheet -->
    <link rel="stylesheet" type="text/css" href="includes/assets/css/style_2.css">
    <title>HealthCare</title>

    <style type="text/css">
      /*Styling the Navbar*/
      body{
        font-size: 20px;
      }

.navbar-default .navbar-nav>li>a {
  color: #E8F5E9;
}


.navbar-default .navbar-brand {
    color: #E8F5E9;
}

.container{
  width: 100%;
  margin-left: 0px;
  margin-right: 0px;
}

a {
    color: #E8F5E9;
    text-decoration: none;
}


/*-----------------------------------------------------------------*/
.nav>li>a:focus, .nav>li>a:hover {
    color: #4DB890;
    text-decoration: none;
    background-color: #E8F5E9;
    transition: all 0.5s ease-out;

}



.fixed-theme .nav>li>a:focus, .fixed-theme .nav>li>a:hover {
  
  color: #4DB890;
    text-decoration: none;
    background-color: #E8F5E9;
    transition: all 0.5s ease-out;
}


.navbar>.container .navbar-brand, .navbar>.container-fluid .navbar-brand {
    margin-left: 30px;
}


.navbar-brand {
    font-size: 30px;
    letter-spacing: 3px;
    margin-left: 30px;
 }

 .navbar-nav>li {
    float: left;
    letter-spacing: 3px;
}

.fixed-theme .navbar-nav>li>a {
    padding-top: 15px;
    padding-bottom: 15px;
  color: #E8F5E9 ;
}

.navbar-container {
    padding: 20px 0 20px 0;
}

.navbar.navbar-fixed-top.fixed-theme {
    background-color: #4DB890;
    border-color: #E8F5E9;
    box-shadow: 0 0 5px rgba(0,0,0,.8);
}

.navbar-brand.fixed-theme {
    font-size: 18px;
  color: #E8F5E9 ;


}

.navbar-container.fixed-theme {
    padding: 0;
  color: #E8F5E9 ;
}

.navbar-brand.fixed-theme,
.navbar-container.fixed-theme,
.navbar.navbar-fixed-top.fixed-theme,
.navbar-brand,
.navbar-container{
    transition: 0.8s;
    -webkit-transition:  0.8s;
}
/*----------------------------------------------------------------------*/
          </style>
    
  </head>
  <body>
    

    <nav id="header" class="navbar navbar-fixed-top">
            <div id="header-container" class="container navbar-container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a id="brand" class="navbar-brand" href="#">Health-Care</a>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="index.php">Home</a></li>
                        <li><a href="search.php">Search</a></li>
                        <li><a href="#">About</a></li>
                        <?php 

                            // if(isset($_SESSION['userLoggedIn'])){
                            //     echo "<li><a href='register.php?logout=true'>Log Out</a></li>";

                            // } 
                            // else{
                            //    echo "<li><a href='register.php'>Log In</a></li>";
                            // }
                        ?>
                    </ul>
                </div><!-- /.nav-collapse -->
            </div><!-- /.container -->
        </nav><!-- /.navbar -->


    <div id="myModal" class="modal">

      <div class="modal-content">
        <div class="modal-header bg-warning">
          <h2>Set Your Location</h2>

          <span class="close-modal m-t-10">&times;</span>
        </div>
        <div class="modal-body">
          <div id="map" style="height: 250px; width: 80%; margin: 20px auto;"></div>
          <div style="display: flex; justify-content: center" class="p-b-20">
            <div class="btn btn-outline btn-rounded btn-dark" style="width: 80%; margin-bottom: 20px;" id="cancel-modal">Confirm</div>
          </div>
          
        </div>
      </div>

    </div>

    <!-- Container for the left side of the image -->
    <!-- It contains the image -->
    <div id="login-page-image">
      <img src="includes/assets/images/logo3.jpg" width="100%" height="100%">
    </div>


    <!-- Container for the right side of the image -->
    <div id="login-page-details">

      <h3>Register Yourself for a Better Experience!</h3>
      <div class="tab">
        <button class="tablinks" onclick="openCity(event, 'Hospital')" id="defaultOpen">Hospital</button>
        <button class="tablinks" onclick="openCity(event, 'User')">User</button>
        <button class="tablinks" onclick="openCity(event, 'Retailer')">Retailer</button>
        <button class="tablinks" onclick="openCity(event, 'Login')">Login</button>

      </div>

      <div id="Hospital" class="tabcontent">
          
          <form autocomplete="off" id='hospital' action="register.php" method="POST">
            <fieldset>
              <legend>Signup For Hospital</legend>

              <label for="hname" value="<?php getInputValue('hname') ?>">Name</label>  
            <input type = "text" id = "hname" name="hname" placeholder="Enter your name" required autofocus /><br>
            
            <label for="hphone" value="<?php getInputValue('hphone') ?>">Telephone</label>
            <input pattern="([0-9]{1}(-[0-9]{3})(-[0-9]{3})(-[0-9]{4}))" name="hphone"  placeholder="Pattern: 1-234-567-8910" id="hphone" type="text" title="11 digit phone number" required ><br>
            <p><?php echo $Haccount->getError(Constants::$emailNotUnique); ?>
            <label for="hemail" value="<?php getInputValue('hemail') ?>">Email Address</label>
            <input type="email" placeholder="foo@this.com, bar@that.com" id="hemail" name="hemail"  required/></p><br>
            
           

            <label for="searchHospital" >Address/Location</label>
            <input type="text" name="haddress" id="searchHospital"  required>
            <div class="btn btn-danger" id="submitHospital">Set Location</div>

            <input type="hidden" name="hlat" id="latHospital">
            <input type="hidden" name="hlng" id="lngHospital">
             <br>

            <label for="hlicense" value="<?php getInputValue('hlicense') ?>">License No.</label>  
            <input type = "text" id = "hlicense" name="hlicense" pattern="([0-9]{1}(-[0-9]{3})(-[0-9]{3}))" placeholder="Pattern: 1-234-567" required />
              <br>  
            
            <p> <label for="hpw"  >Password</label>
              <?php echo $Haccount->getError(Constants::$passwordsDoNoMatch); ?>
        <?php echo $Haccount->getError(Constants::$passwordNotAlphanumeric); ?>
        <?php echo $Haccount->getError(Constants::$passwordCharacters); ?>
            
           
            <input type="password" name="hpw" id="hpw" placeholder="********(5-20 numbers or letters)" title="Numbers and alphabets Only(5-10 range)" required>
            </p>
              <br>

            <label for="hpw2">Confirm Password</label>
            <input type="password" name="hpw2" id="hpw2"  placeholder="********(5-20 numbers or letters)" title="Numbers and alphabets Only(5-10 range)" required>
              <br>
              
            <input type="submit" name="hospitalRegisterButton" value="submit">
            </fieldset>
          </form>


        
      </div>

      <div id="User" class="tabcontent">
        <form autocomplete="on" id='userform' method="POST" action="register.php">
            <fieldset>
              <legend>Signup As a User</legend>
              <label for="uname" value="<?php getInputValue('uname') ?>">Name</label>  
            <input type = "text" id = "uname" name="uname" placeholder="Enter your name" required autofocus /><br>
            
            <label for="uphone" value="<?php getInputValue('uphone') ?>">Telephone</label>
            <input pattern="([0-9]{1}(-[0-9]{3})(-[0-9]{3})(-[0-9]{4}))" name="uphone"  placeholder="Pattern: 1-234-567-8910" id="uphone" type="text" title="11 digit phone number" required ><br>

            <p><?php echo $Uaccount->getError(Constants::$emailNotUnique); ?>
            <label for="uemail" value="<?php getInputValue('uemail') ?>">Email Address</label>
            <input type="email" placeholder="foo@this.com, bar@that.com" id="uemail" name="uemail"  required/></p><br>

            <label for="uaddress">Location</label>
            <input type="text" name="uaddress" id="searchUser">
            <div class="btn btn-danger" id="submitUser">Set Location</div>
            <br>

            <input type="hidden" name="ulat" id="latUser">
            <input type="hidden" name="ulng" id="lngUser">
            <br>
            
            <p> <label for="upw"  >Password</label>
              <?php echo $Uaccount->getError(Constants::$passwordsDoNoMatch); ?>
              <?php echo $Uaccount->getError(Constants::$passwordNotAlphanumeric); ?>
              <?php echo $Uaccount->getError(Constants::$passwordCharacters); ?>
            
            <input type="password" name="upw" id="upw" placeholder="********(5-20 numbers or letters)" title="Numbers and alphabets Only(5-10 range)" required>
            </p>
              <br>


            
            <label for="upw2">Confirm Password</label>
            <input type="password" name="upw2" id="upw2"  placeholder="********(5-20 numbers or letters)" title="Numbers and alphabets Only(5-10 range)" required>
              <br>
            
            <input type="submit" name="UserRegisterButton" value="submit">
            </fieldset>
          </form> 
      </div>

      <div id="Retailer" class="tabcontent">
        <form autocomplete="on" id='retailerform' action="register.php" method="POST">
            <fieldset>
              <legend>Signup As a Retailer</legend>

              <label for="name" value="<?php getInputValue('name') ?>">Name</label>  
            <input name="name" type = "text" id = "name" placeholder="Enter your name" required autofocus /><br>
      
            <label for="phone" value="<?php getInputValue('phone') ?>">Telephone</label>
            <input pattern="([0-9]{1}(-[0-9]{3})(-[0-9]{3})(-[0-9]{4}))" placeholder="Pattern: 1-234-567-8910" id="phone" name="phone" type="text" title="11 digit phone number" required ><br>
            <p> <?php echo $Raccount->getError(Constants::$emailNotUnique); ?>
            <label for="email" value="<?php getInputValue('email') ?>">Email Address</label>
            <input type="email" placeholder="foo@this.com" id="email" name="email" required/></p><br>
      
            <!-- <label for="address">Address/Location</label>
            <input type="text" name="address" id="address" placeholder="Enter your location" required>
            <br> -->

            <label for="searchRetailer" value="<?php getInputValue('address') ?>">Location</label>
            <input type="text"  name="address" id="searchRetailer">
            <div class="btn btn-danger" id="submitRetailer">Set Location</div>
             <br>

             <input type="hidden" name="lat" id="latRetailer">
            <input type="hidden" name="lng" id="lngRetailer">
             <br>
        
            <label for="license" value="<?php getInputValue('license') ?>">License No.</label>  
            <input type = "text" id = "license" name="license" pattern="([0-9]{1}(-[0-9]{3})(-[0-9]{3}))" placeholder="Pattern: 1-234-567" required/>
            <br>
         
        
             <p> <label for="pw"  >Password</label>
              <?php echo $Raccount->getError(Constants::$passwordsDoNoMatch); ?>
              <?php echo $Raccount->getError(Constants::$passwordNotAlphanumeric); ?>
              <?php echo $Raccount->getError(Constants::$passwordCharacters); ?>
            
            <input type="password" name="pw" id="pw" placeholder="********(5-20 numbers or letters)" title="Numbers and alphabets Only(5-10 range)" required>
            </p>
            <br>
            
            <label for="pw2">Confirm Password</label>
            <input type="password" name="pw2" id="pw2"  placeholder="********(5-20 numbers or letters)" title="Numbers and alphabets Only(5-10 range)" required>
            <br>

            <label for="openTime" value="<?php getInputValue('openingTime') ?>">Opening Time</label>
            <input type="text" name="openingTime" id="openTime" pattern="([0-1]{1}[0-9]{1}|20|21|22|23):[0-5]{1}[0-9]{1}" placeholder="12:00" title="Use 24 hours format" required>
            <br>
         
            <label for="closeTime" value="<?php getInputValue('closingTime') ?>">Closing Time</label>
            <input type="text" name="closingTime" id="closeTime" pattern="([0-1]{1}[0-9]{1}|20|21|22|23):[0-5]{1}[0-9]{1}" placeholder="12:00" title="Use 24 hours format" required>
            <br>
            
            <input type="submit" value="submit" name="RetailerRegisterButton">
            </fieldset>
          </form>
      </div>

      <div id="Login" class="tabcontent">
        <form autocomplete="on" id='loginform' action="register.php" method="POST">
    <fieldset>
    <legend>Login</legend>
          
      <p>
              <?php
                if($Uaccount->isErrorPresent(Constants::$loginFailed) && $Uaccount->isErrorPresent(Constants::$loginFailed)){  
                    echo (Constants::$loginFailed);
                }    
              ?>
              <label for="loginEmail" value="<?php getInputValue('loginEmail') ?>">Email</label>
              <input id="loginEmail" name="loginEmail" type="text" placeholder="e.g. bartSimpson@gmail.com" required>
            </p>
            <p>
              <label for="loginPassword">Password</label>
              <input id="loginPassword" name="loginPassword" type="password" placeholder="Your password" required>
            </p>

            <input type="submit" name="loginButton" value="Log In">
          </fieldset>
        </form>
      </div>

    </div>

    <script>
      function openCity(evt, cityName) {
          var i, tabcontent, tablinks;
          tabcontent = document.getElementsByClassName("tabcontent");
          for (i = 0; i < tabcontent.length; i++) {
              tabcontent[i].style.display = "none";
          }
          tablinks = document.getElementsByClassName("tablinks");
          for (i = 0; i < tablinks.length; i++) {
              tablinks[i].className = tablinks[i].className.replace(" active", "");
          }
          document.getElementById(cityName).style.display = "block";
          evt.currentTarget.className += " active";
      }

      // Get the element with id="defaultOpen" and click on it
      document.getElementById("defaultOpen").click();
    </script>
  

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script type="text/javascript" src="app.js"></script>

    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-0ff6dw9PJbMb-28OlWi5Oz9igGeATcM&libraries=places&callback=activatePlacesSearch"></script>

  <script type="text/javascript" src="includes/assets/js/search_script.js"></script>

  </body>
</html>