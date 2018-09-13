<?php 
    include("../includes/config.php");

include("headerSupplierDashboard.php");
include("../includes/handlers/paginatedOrders-handler.php");

if(isset($_SERVER['PHP_SELF'])){
  $thisPage = $_SERVER['PHP_SELF'];
  if(isset($_GET['page'])){
    $thisPage .= '?page=' . $_GET['page'];
  }
  echo "<script>thisPage = '$thisPage';</script>";
  
}

if(isset($_POST['submitPerPage'])){
  $perPage = $_POST['perPage'];
  $filterStatus = $_POST['filterStatus'];

  $_SESSION['perPage'] = $perPage;
  $_SESSION['filterStatus'] = $filterStatus;

}

if(isset($_POST['submitChangeQuantity'])){
  $itemId = $_POST['itemId'];
  $quantity = $_POST['quantity'];
  $query = mysqli_query($con, "UPDATE inventory SET quantity='$quantity' WHERE inventory.itemId='$itemId'");

}

if(isset($_POST['submitDelete'])){
  $itemId = $_POST['submitDelete'];
  $query = mysqli_query($con, "DELETE FROM inventory WHERE itemId='$itemId'");
  // echo "Submitted";
  // echo $itemId;
  if($query){
    echo "<div id='myModalSuccess' class='modal success-modal'>

            <div class='modal-content'>
              <div class='modal-header bg-success'>
                <h2>Succesful!</h2>

                <span class='close-modal'>&times;</span>
              </div>
              <div class='modal-body p-t-40 p-b-40'>
                <p style='text-align: center;'>Inventory successfully updated</p>
              
              </div>
            </div>

          </div>";


    echo "<script>
      setTimeout(function(){
        document.getElementById('myModalSuccess').style.display = 'block';
      }, 800);
      setTimeout(function(){
        document.getElementById('myModalSuccess').style.display = 'none';
      }, 2200);
    </script>";
  }
}


$retailerLoggedIn = '';
if(isset($_SESSION['retailerLoggedIn'])) {
    $retailerLoggedIn = $_SESSION['retailerLoggedIn'];
    echo "<script>retailerLoggedIn = '$retailerLoggedIn';</script>";
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
                      <h2>Orders</h2>
                      <h6>View and Update your orders</h6>

                      <!-- <div id="edit-panel">
                        <form class="pull-right">
                          <input type="hidden" name="itemId">
                          <input type="number" name="quantity">
                          <input type="submit" name="submitChangeQuantity">
                        </form>
                      </div> -->

                        <!-- The Modal -->
                      <div id="myModal" class="modal">

                        <div class="modal-content">
                          <div class="modal-header bg-warning">
                            <h2>Are You Sure?</h2>

                            <span class="close-modal">&times;</span>
                          </div>
                          <div class="modal-body">
                            <p style="text-align: center;">Do you want to remove this medicine from your inventory?</p>
                            <div class="p-b-20" style="display: flex; justify-content: center;">
                              <form action="<?php echo $thisPage; ?>" method="POST">
                                <button type="submit" name="submitDelete" class="btn btn-outline btn-rounded btn-danger m-r-10" id="submitDelete">Yes, Delete It!</button>
                              </form>
                              <button class="btn btn-outline btn-rounded btn-dark m-l-10" id="cancel-modal">No, Cancel!</button>
                            </div>
                          </div>
                        </div>

                      </div>

                      
                      <div class="table-responsive m-t-40">
                          <form action="table-orders.php" method="POST" class="m-b-20">
                              <label for="perPage">Results Per Page</label>
                              <select id="perPage" name="perPage">
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

                              <label for="filterStatus">Filter By Status</label>
                              <select id="filterStatus" name="filterStatus">
                                  <?php 

                                  if(isset($_SESSION['filterStatus'])){
                                      $filterStatus = $_SESSION['filterStatus'];
                                    }
                                    else{
                                      $filterStatus = 0;
                                    }

                                    $filterQuery=mysqli_query($con, "SELECT * from orderstatus");

                                    echo "<option value='0'>All</option>";
                                    while($row = mysqli_fetch_array($filterQuery)){
                                        $status = $row['status'];
                                        $val = $row['statusId'];
                                      
                                      if($row['statusId']==$filterStatus){
                                        echo "<option value='$val' selected>$status</option>";
                                      }
                                      else{
                                        echo "<option value='$val'>$status</option>";
                                      }

                                    }

                                   ?>

                              </select>

                              <input class="button" type="submit" name="submitPerPage" value="Apply">
                          </form>
                          <table id="" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                              <thead>
                                  <tr>
                                      <th>#</th>
                                      <th>Name</th>
                                      <th>Product</th>
                                      <th>Packing</th>
                                      <th>Qty</th>
                                      <th>Date</th>
                                      <th>Status</th>
                                  </tr>
                              </thead>
                              <tfoot>
                                  <tr>
                                      <th>#</th>
                                      <th>Name</th>
                                      <th>Product</th>
                                      <th>Packing</th>
                                      <th>Qty</th>
                                      <th>Date</th>
                                      <th>Status</th>

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
        var retailerLoggedIn;
        var myModalSuccess = document.getElementById('myModalSuccess');

        // var previousClicked=null;

        var coll = document.getElementsByClassName("ti-pencil-alt");
        var contents = document.querySelectorAll('.edit-panel');

        for (var i = 0; i < coll.length; i++) {

          coll[i].addEventListener("click", function() {
            this.classList.toggle("active");

            var j = Number(this.previousElementSibling.id);
            

            if(this.classList.contains("active")){
              // not active

              document.querySelectorAll('.edit-container').forEach(function(x){
                x.innerHTML = '';
              });

              document.querySelectorAll('.ti-pencil-alt').forEach((pencil)=>{
                if(pencil!=this){
                  pencil.classList.remove("active");
                }
              });

              const td = document.createElement('td');
              td.className = 'edit-panel';
              td.setAttribute('colspan', '8');
              td.innerHTML = `
                <form class="pull-right" action="${thisPage}" method='POST'">
                  <input type="hidden" name="itemId" value=${this.id}>
                  <label for="quantity">Enter quantity: </label>
                  <input type="number" name="quantity" id="quantity" value=${this.parentElement.parentElement.previousElementSibling.textContent}>
                  <input type="submit" name="submitChangeQuantity" value="update">
                </form>
                              `;
              document.querySelectorAll('.edit-container')[j].appendChild(td);
            }

            else{
              // previousClicked.classList.toggle("active");

              document.querySelectorAll('.edit-container')[j].innerHTML = '';
            }
          });
        }

        var modal = document.getElementById('myModal');

        // Get the button that opens the modal
        var btns = document.querySelectorAll(".ti-cut");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close-modal")[0];



        // When the user clicks on the button, open the modal 
        btns.forEach(function(btn){
          btn.onclick = function(e) {
            modal.style.display = "block";
            document.getElementById('submitDelete').value = Number(e.target.id);
        }
        });

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