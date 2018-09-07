<?php 
    include("../includes/config.php");

include("headerSupplierDashboard.php");
include("../includes/handlers/paginatedSuppliers-handler.php");

if(isset($_SERVER['PHP_SELF'])){
  $thisPage = $_SERVER['PHP_SELF'];
  if(isset($_GET['page'])){
    $thisPage .= '?page=' . $_GET['page'];
  }
  echo "<script>thisPage = '$thisPage';</script>";
  
}

if(isset($_POST['submitPerPage'])){
  $perPage = $_POST['perPage'];
  $_SESSION['perPage'] = $perPage;
}


?>
            <!-- Container fluid  -->
      <div class="container-fluid">
          <!-- Start Page Content -->
          <?php include("startPageContent.php"); ?>

          <div class="row bg-white m-l-0 m-r-0 box-shadow ">

              <!-- column -->
              <div class="col-lg-12">
                  <div class="card">
                      <div class="card-body">
                          <h2>Registered Suppliers/Retailers</h2>
                          <h6>View Authorized Drug Suppliers</h6>

                          
                          <div class="table-responsive m-t-40">
                              <form action="table-suppliers.php" method="POST" class="m-b-20">
                                  <label for="perPage">Results Per Page</label>
                                  <select id="perPage" name="perPage">
                                      <!-- <option>5</option>
                                      <option>10</option>
                                      <option>15</option>
                                      <option>20</option>
                                      <option>25</option> -->
                          <?php  
                            if(isset($_SESSION['perPage'])){
                              $perPage = $_SESSION['perPage'];
                            }
                            else{
                              $perPage = 5;
                            }

                            for($i=5; $i<=25; $i+=5){
                              if($i==$perPage){
                                echo "<option selected>$perPage</option>";
                              }
                              else
                                echo "<option>$i</option>";

                            }

                          ?>

                                  </select>
                                  <input class="button" type="submit" name="submitPerPage" value="Go">
                              </form>
                              <table id="" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                  <thead>
                                      <tr>
                                          <th>#</th>
                                          <th>Name</th>
                                          <th>Email</th>
                                          <th>Phone</th>
                                          <th>Location</th>
                                          <th>License</th>
                                          <th>Timings</th>
                                          <th>Date Joined</th>
                                      </tr>
                                  </thead>
                                  <tfoot>
                                      <tr>
                                          <th>#</th>
                                          <th>Name</th>
                                          <th>Email</th>
                                          <th>Phone</th>
                                          <th>Location</th>
                                          <th>License</th>
                                          <th>Timings</th>
                                          <th>Date Joined</th>

                                      </tr>
                                  </tfoot>
                                  <tbody>
                                      <?php 
                                          $outputPagination = get_products($con);
                                       ?>
                                  </tbody>
                              </table>
                          </div>
                          <?php echo "<div class='text-center pull-right m-t-20 m-r-20'><ul class='pagination'>{$outputPagination}</ul></div>"; ?>
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
        var thisPage;
        console.log(thisPage);
       

    </script>
    <!-- All Jquery -->
    <script src="js/lib/jquery/jquery.min.js"></script>
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