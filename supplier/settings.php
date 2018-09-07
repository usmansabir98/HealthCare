<?php 
    include("../includes/config.php");

include("headerSupplierDashboard.php");



$retailerLoggedIn = '';
if(isset($_SESSION['retailerLoggedIn'])) {
    $retailerLoggedIn = $_SESSION['retailerLoggedIn'];
    echo "<script>retailerLoggedIn = '$retailerLoggedIn';</script>";
}

include("../includes/handlers/settings-handler.php");


$query = mysqli_query($con, "SELECT * FROM retailer WHERE emailid='$retailerLoggedIn'");
    $data = mysqli_fetch_array($query);


?>
            <!-- Container fluid  -->
            <div class="container-fluid">

                <div class="row bg-white m-l-0 m-r-0 box-shadow ">

                    <!-- column -->

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h1 class="card-title">Personal Information</h1>
                                
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6>Email:</h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p><?php echo lcfirst($data['emailid']) ?></p>
                                    </div>
                                    <div class="col-sm-1 ti-pencil-alt zoom" id="emailEdit"></div>

                                </div>
                                <div class="edit-container"></div>
                                <hr>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6>Password:</h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p>**************</p>
                                    </div>
                                    <div class="col-sm-1 ti-pencil-alt zoom" id="passwordEdit"></div>

                                </div>
                                <div class="edit-container"></div>
                                <hr>
                               
                            </div>
                        </div>
                    </div>
                    <!-- column -->

                    
                </div>


                <!-- End PAge Content -->
            </div>
            <!-- End Container fluid  -->
            <!-- footer -->
            <footer class="footer"> © 2018 All rights reserved. Template designed by <a href="#">MUY</a></footer>
            <!-- End footer -->
        </div>
        <!-- End Page wrapper  -->
    </div>
    <!-- End Wrapper -->

    <script type="text/javascript">
        
        document.getElementById('emailEdit').addEventListener("click", function(){
            this.classList.toggle("active");

            if(this.classList.contains("active")){

              document.querySelectorAll('.edit-container').forEach(function(x){
                x.innerHTML = '';
              });

              document.querySelectorAll('.ti-pencil-alt').forEach((pencil)=>{
                if(pencil!=this){
                  pencil.classList.remove("active");
                }
              });

                var email = this.previousElementSibling.firstElementChild.textContent;
            const span = document.createElement('span');
              span.className = 'edit-panel col-sm-12';
              span.innerHTML = `
                <form class="pull-right" action="settings.php" method='POST'>
                  <label for="email">Enter Email: </label>
                  <input type="email" name="email" id="email" value="${email}">
                  <input type="submit" class="btn btn-outline btn-rounded btn-success" name="submitChangeEmail" value="update">
                </form>
                              `;
              document.querySelectorAll('.edit-container')[0].appendChild(span);
            }

            else{
              document.querySelectorAll('.edit-container')[0].innerHTML = '';
            }

            

        });



        document.getElementById('passwordEdit').addEventListener("click", function(){
            this.classList.toggle("active");

            if(this.classList.contains("active")){

              document.querySelectorAll('.edit-container').forEach(function(x){
                x.innerHTML = '';
              });

              document.querySelectorAll('.ti-pencil-alt').forEach((pencil)=>{
                if(pencil!=this){
                  pencil.classList.remove("active");
                }
              });

            const span = document.createElement('span');
              span.className = 'edit-panel col-sm-12';
              span.innerHTML = `
                <form class="pull-right" action="settings.php" method='POST'>
                  <label for="oldpw">Old Password: </label>
                  <input type="password" name="oldpw" id="oldpw">

                  <label for="newpw">New Password: </label>
                  <input type="password" name="newpw" id="newpw">

                  <label for="newpw2">Confirm Password: </label>
                  <input type="password" name="newpw2" id="newpw2">

                  <input type="submit" class="btn btn-outline btn-rounded btn-success" name="submitChangePassword" value="update">
                </form>
                              `;
              document.querySelectorAll('.edit-container')[1].appendChild(span);
            }

            else{
              document.querySelectorAll('.edit-container')[1].innerHTML = '';
            }

        });


    </script>


    <!-- All Jquery -->
    <script src="js/lib/jquery/jquery.min.js"></script>
    <!-- Popper Js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>

    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>

</body>

</html>