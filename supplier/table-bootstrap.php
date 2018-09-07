<?php 
    include("../includes/config.php");

include("headerSupplierDashboard.php");

$retailerLoggedIn = '';
if(isset($_SESSION['retailerLoggedIn'])) {
    $retailerLoggedIn = $_SESSION['retailerLoggedIn'];
    echo "<script>retailerLoggedIn = '$retailerLoggedIn';</script>";
}


$queryAll = mysqli_query($con, "SELECT orders.orderId, brandname.brandName, manufacturer.manName, dosageform.formName, medicine.pack, user.name, orders.time, orders.quantity, orderstatus.status 
        FROM `orders` 
        INNER JOIN user on orders.userId = user.id
        INNER JOIN orderstatus on orders.status = orderstatus.statusId
        INNER JOIN medicine on orders.medId = medicine.medId
        INNER JOIN brandName on medicine.brandId = brandname.brandId
        INNER JOIN manufacturer on medicine.manId = manufacturer.manId
        INNER JOIN dosageform on medicine.formId = dosageform.formId
        where orders.supplierId = (SELECT id from retailer where emailid='$retailerLoggedIn');
        ");

?>
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                
                <?php include("startPageContent.php"); ?>
                    
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-title">
                                <h4>Orders</h4>

                            </div>
                            <div class="card-body">
                                <div class="scroll-div table-responsive">
                    
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
                                <!-- <div class="table-responsive">
                                    <table class="table table-hover ">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>Kolor Tea Shirt For Man</td>
                                                <td><span class="badge badge-primary">Sale</span></td>
                                                <td>January 22</td>
                                                <td class="color-primary">$21.56</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td>Kolor Tea Shirt For Women</td>
                                                <td><span class="badge badge-success">Tax</span></td>
                                                <td>January 30</td>
                                                <td class="color-success">$55.32</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">3</th>
                                                <td>Blue Backpack For Baby</td>
                                                <td><span class="badge badge-danger">Extended</span></td>
                                                <td>January 25</td>
                                                <td class="color-danger">$14.85</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div> -->
                            </div>
                        </div>
                        <!-- /# card -->
                    </div>
                    <!-- /# column -->
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
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>


    <script src="js/lib/datatables/datatables.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script src="js/lib/datatables/datatables-init.js"></script>

</body>

</html>