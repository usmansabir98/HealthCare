<?php 
    include("../includes/config.php");

include("headerSupplierDashboard.php");

$retailerLoggedIn = '';
if(isset($_SESSION['retailerLoggedIn'])) {
    $retailerLoggedIn = $_SESSION['retailerLoggedIn'];
    echo "<script>retailerLoggedIn = '$retailerLoggedIn';</script>";
}
else {
    header("Location: ../register.php");
}

$queryAll = mysqli_query($con, "SELECT orders.orderId, brandname.brandName, manufacturer.manName, dosageform.formName, medicine.pack, user.name, orders.time, orders.quantity, orderstatus.status 
        FROM `orders` 
        INNER JOIN user on orders.userId = user.id
        INNER JOIN orderstatus on orders.status = orderstatus.statusId
        INNER JOIN medicine on orders.medId = medicine.medId
        INNER JOIN brandName on medicine.brandId = brandname.brandId
        INNER JOIN manufacturer on medicine.manId = manufacturer.manId
        INNER JOIN dosageform on medicine.formId = dosageform.formId
        where orders.supplierId = (SELECT id from retailer where emailid='$retailerLoggedIn') 
        and orders.status = 1
        order by orders.time desc LIMIT 3");

$queryPending = mysqli_query($con, "SELECT orderId from orders
    where supplierId = (SELECT id from retailer where emailid='$retailerLoggedIn')
    and status = 1");

$queryExpired = mysqli_query($con, "SELECT orderId from orders
    where supplierId = (SELECT id from retailer where emailid='$retailerLoggedIn')
    and status = 2");

$queryFulfilled = mysqli_query($con, "SELECT orderId from orders
    where supplierId = (SELECT id from retailer where emailid='$retailerLoggedIn')
    and status = 3");

$queryUnfulfilled = mysqli_query($con, "SELECT orderId from orders
    where supplierId = (SELECT id from retailer where emailid='$retailerLoggedIn')
    and status = 4");

$queryTotal = mysqli_query($con, "SELECT orderId from orders
    where supplierId = (SELECT id from retailer where emailid='$retailerLoggedIn')");

$totalCount = mysqli_num_rows($queryTotal);

$pendingCount = floor(mysqli_num_rows($queryPending)/$totalCount*100);
$expiredCount = floor(mysqli_num_rows($queryExpired)/$totalCount*100);
$fulfilledCount = floor(mysqli_num_rows($queryFulfilled)/$totalCount*100);
$unfulfilledCount = floor(mysqli_num_rows($queryUnfulfilled)/$totalCount*100);


?>
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <?php include("startPageContent.php"); ?>

                <div class="row bg-white m-l-0 m-r-0 box-shadow ">

                    <!-- column -->
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-title">
                                <h4>Recent Orders </h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Supplier</th>
                                                <th>Product</th>
                                                <th>Packing</th>
                                                <th>Qty</th>
                                                <th>Date</th>
                                                <th>Status</th>

                                            </tr>

                                            <?php 

                                            $i =1;

                                            while ($row = mysqli_fetch_array($queryAll)) {
                                                # code.
                                                # code.
                                                $name = $row['name'];
                                                $brandName = $row['brandName'];
                                                $manName = $row['manName'];
                                                $dosageForm = $row['formName'];
                                                $pack = $row['pack'];

                                                $product = $brandName.'<br>'.$manName;
                                                $packing = $pack.'<br>'.$dosageForm;


                                                $quantity = $row['quantity'];
                                                $date = date('Y-m-d', $row['time']);
                                                $time = date('h:i:sa', $row['time']);
                                                $status = $row['status'];
                                                $datetime = $date.'<br>'.$time;

                                                if($status == 'Pending'){
                                                    $statusClass = 'badge badge-primary';
                                                }
                                                else if($status == 'Fulfilled'){
                                                    $statusClass = 'badge badge-success';
                                                }
                                                else if($status == 'Unfulfilled'){
                                                    $statusClass = 'badge badge-danger';
                                                }
                                                else{
                                                    $statusClass = 'badge badge-warning';

                                                }


                                                echo "<tr>

                                                    <td>$i</td>
                                                    <td>$name</td>
                                                    <td>$product</td>
                                                    <td>$packing</td>
                                                    <td>$quantity</td>
                                                    <td>$datetime</td>
                                                    <td><span class='$statusClass'>$status</span></td>


                                                </tr>";

                                                $i++;
                                            }

                                             ?>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <!-- column -->

                    <!-- column -->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body browser">
                                <p class="f-w-600">Fulfilled Orders <span class="pull-right"><?php echo $fulfilledCount; ?>%</span></p>
                                <div class="progress ">
                                    <div role="progressbar" style="display: none; width:<?php echo $fulfilledCount; ?>%; height:8px;" class="progress-bar bg-danger wow animated progress-animated"> <span class="sr-only"><?php echo $fulfilledCount; ?>% Complete</span> </div>
                                </div>

                                

                                <p class="m-t-30 f-w-600">Pending Orders<span class="pull-right"><?php echo $pendingCount; ?>%</span></p>
                                <div class="progress">
                                    <div role="progressbar" style="display: none; width: <?php echo $pendingCount; ?>%; height:8px;" class="progress-bar bg-info wow animated progress-animated"> <span class="sr-only"><?php echo $pendingCount; ?>% Complete</span> </div>
                                </div>

                                <p class="m-t-30 f-w-600">Unfulfilled Orders<span class="pull-right"><?php echo $unfulfilledCount; ?>%</span></p>
                                <div class="progress">
                                    <div role="progressbar" style="display: none; width: <?php echo $unfulfilledCount; ?>%; height:8px;" class="progress-bar bg-success wow animated progress-animated"> <span class="sr-only"><?php echo $unfulfilledCount; ?>% Complete</span> </div>
                                </div>

                                <p class="m-t-30 f-w-600">Expired Orders<span class="pull-right"><?php echo $expiredCount; ?>%</span></p>
                                <div class="progress">
                                    <div role="progressbar" style="display: none; width: <?php echo $expiredCount; ?>%; height:8px;" class="progress-bar bg-warning wow animated progress-animated"> <span class="sr-only"><?php echo $expiredCount; ?>% Complete</span> </div>
                                </div>

                                <script type="text/javascript">
                                    var pBars = document.querySelectorAll('.progress-bar');

                                    pBars.forEach(function(pBar){
                                        var target = pBar.style.width;
                                        pBar.style.width = '0%'; 
                                        pBar.style.display = 'block';
                                        var pos = 0;
                                        var id = setInterval(frame, 30);
                                        function frame() {
                                            if (pBar.style.width == target) {
                                                clearInterval(id);
                                            } else {
                                                pos++; 
                                                pBar.style.width = pos + '%'; 
                                            }
                                        }
                                    });
                                    
                                </script>

								
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
        var retailerLoggedIn;
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


    <!-- Amchart -->
     <script src="js/lib/morris-chart/raphael-min.js"></script>
    <script src="js/lib/morris-chart/morris.js"></script>
    <script src="js/lib/morris-chart/dashboard1-init.js"></script>

    <script src="js/scripts.js"></script>
    <!-- scripit init-->

    <script src="js/custom.min.js"></script>

</body>

</html>