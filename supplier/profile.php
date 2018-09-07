<?php 
    include("../includes/config.php");

include("headerSupplierDashboard.php");



$retailerLoggedIn = '';
if(isset($_SESSION['retailerLoggedIn'])) {
    $retailerLoggedIn = $_SESSION['retailerLoggedIn'];
    echo "<script>retailerLoggedIn = '$retailerLoggedIn';</script>";
}

include("../includes/handlers/profile-handler.php");


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
                                        <h6>Name:</h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p><?php echo $data['name'] ?></p>
                                    </div>
                                    <div class="col-sm-1 ti-pencil-alt zoom" id="nameEdit"></div>

                                </div>
                                <div class="row">
                                    <div class="col-sm-12 edit-container"></div>
                                </div>

                                <hr>
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
                                        <h6>Phone:</h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p><?php echo $data['phone'] ?></p>
                                    </div>
                                    <div class="col-sm-1 ti-pencil-alt zoom" id="phoneEdit"></div>

                                </div>
                                <div class="edit-container"></div>

                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6>Location:</h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p><?php echo $data['location'] ?></p>
                                        <p style="display: none;" id="lat"><?php echo $data['latitude'] ?></p>
                                        <p style="display: none;" id="lng"><?php echo $data['longitude'] ?></p>

                                    </div>
                                    <div class="col-sm-1 ti-pencil-alt zoom" id="locationEdit"></div>

                                </div>
                                <div id="myModal" class="modal">

                                    <div class="modal-content">
                                      <div class="modal-header bg-warning">
                                        <h2>Update Your Location</h2>

                                        <span class="close-modal">&times;</span>
                                      </div>
                                      <div class="modal-body">
                                        <form action="profile.php" method="POST">
                                          
                                          <div class="p-t-20" style="display: flex; justify-content: center;">
                                            <input type="text" name="location" id="location" class="m-r-10" style="width: 70%">
                                            <input type="text" name="latRetailer" id="latRetailer" style="display: none;">
                                            <input type="text" name="lngRetailer" id="lngRetailer" style="display: none;">
                                            <div id="setLocation" class="m-l-10 btn btn-outline btn-rounded btn-info">Set Location</div>
                                          
                                          </div>

                                          <div id="map" style="height: 250px; width: 80%; margin: 20px auto;"></div>
                                          
                                          <div class="p-b-20" style="display: flex; justify-content: center;">
                                            <input type="submit" name="submitChangeLocation" class="btn btn-rounded btn-success btn-outline" style="padding: 0 auto;" value="Update Location">
                                            <div class="btn btn-outline btn-rounded btn-dark m-l-10" id="cancel-modal">Cancel</div>
                                          </div>
                                        </form>
                                      </div>
                                    </div>

                                  </div>
                                <div class="edit-container"></div>
                                
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6>Licence:</h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p><?php echo $data['license'] ?></p>
                                    </div>
                                    <div class="col-sm-1 ti-pencil-alt zoom" id="licenseEdit"></div>

                                </div>
                                <div class="edit-container"></div>

                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6>Date Joined:</h6>
                                    </div>
                                    <div class="col-sm-6">
                                        <p><?php echo $data['date'] ?></p>
                                    </div>


                                </div>
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
      
        document.getElementById('nameEdit').addEventListener("click", function(){
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

                var name =this.previousElementSibling.firstElementChild.textContent;
                const span = document.createElement('span');
              span.className = 'edit-panel col-sm-12';
              span.innerHTML = `
                <form class="pull-right" action="profile.php" method='POST'>
                  <label for="name">Enter Name: </label>
                  <input type="text" name="name" id="name" value="${name}">
                  <input type="submit" class="btn btn-outline btn-rounded btn-success" name="submitChangeName" value="update">
                </form>
                              `;
              document.querySelectorAll('.edit-container')[0].appendChild(span);

              console.log("if-1");
            }

            else{
              document.querySelectorAll('.edit-container')[0].innerHTML = '';
              console.log("else");

            }

        });
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
                <form class="pull-right" action="profile.php" method='POST'>
                  <label for="email">Enter Email: </label>
                  <input type="email" name="email" id="email" value="${email}">
                  <input type="submit" class="btn btn-outline btn-rounded btn-success" name="submitChangeEmail" value="update">
                </form>
                              `;
              document.querySelectorAll('.edit-container')[1].appendChild(span);
            }

            else{
            
              document.querySelectorAll('.edit-container')[1].innerHTML = '';
            }

        });
        document.getElementById('phoneEdit').addEventListener("click", function(){

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
                <form class="pull-right" action="profile.php" method='POST'>
                  <label for="phone">Enter Phone: </label>
                  <input type="text" name="phone" id="phone" value="${this.previousElementSibling.firstElementChild.textContent}">
                  <input type="submit" class="btn btn-outline btn-rounded btn-success" name="submitChangePhone" value="update">
                </form>
                              `;
              document.querySelectorAll('.edit-container')[2].appendChild(span);
            }

            else{
              document.querySelectorAll('.edit-container')[2].innerHTML = '';
            }

        });
        document.getElementById('locationEdit').addEventListener("click", function(){

          var modal = document.getElementById('myModal');

          // Get the button that opens the modal
          var btn = document.getElementById("locationEdit");

          // Get the <span> element that closes the modal
          var span = document.getElementsByClassName("close-modal")[0];

          // When the user clicks on the button, open the modal 
          btn.onclick = function() {
              modal.style.display = "block";
          }

          // When the user clicks on <span> (x), close the modal
          span.onclick = function() {
              modal.style.display = "none";
          }

          document.getElementById('cancel-modal').onclick = function() {
              modal.style.display = "none";
          }

          // When the user clicks anywhere outside of the modal, close it
          window.onclick = function(event) {
              if (event.target == modal) {
                  modal.style.display = "none";
              }
          }

            
        });
        document.getElementById('licenseEdit').addEventListener("click", function(){

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
                <form class="pull-right" action="profile.php" method='POST'>
                  <label for="license">Enter License: </label>
                  <input type="text" name="license" id="license" value="${this.previousElementSibling.firstElementChild.textContent}">
                  <input type="submit" class="btn btn-outline btn-rounded btn-success" name="submitChangeLicense" value="update">
                </form>
                              `;
              document.querySelectorAll('.edit-container')[4].appendChild(span);
            }

            else{
              document.querySelectorAll('.edit-container')[4].innerHTML = '';
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

    <script type="text/javascript" src="app.js"></script>

    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-0ff6dw9PJbMb-28OlWi5Oz9igGeATcM&libraries=places&callback=activatePlacesSearch"></script>

</body>

</html>