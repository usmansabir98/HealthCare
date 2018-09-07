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
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Product</th>
                                                <th>quantity</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <td>
                                                    <div class="round-img">
                                                        <a href=""><img src="images/avatar/4.jpg" alt=""></a>
                                                    </div>
                                                </td>
                                                <td>Muneeb</td>
                                                <td><span>Panadol</span></td>
                                                <td><span>2 packs</span></td>
                                                <td><span class="badge badge-success">Done</span></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="round-img">
                                                        <a href=""><img src="images/avatar/2.jpg" alt=""></a>
                                                    </div>
                                                </td>
                                                <td>Usman</td>
                                                <td><span>Monekast</span></td>
                                                <td><span>1 pack</span></td>
                                                <td><span class="badge badge-success">Done</span></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="round-img">
                                                        <a href=""><img src="images/avatar/3.jpg" alt=""></a>
                                                    </div>
                                                </td>
                                                <td>Yusra</td>
                                                <td><span>Buscopan</span></td>
                                                <td><span>4 packs</span></td>
                                                <td><span class="badge badge-warning">Pending</span></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="round-img">
                                                        <a href=""><img src="images/avatar/4.jpg" alt=""></a>
                                                    </div>
                                                </td>
                                                <td>Ahmed</td>
                                                <td><span>Buscocin</span></td>
                                                <td><span>2 packs</span></td>
                                                <td><span class="badge badge-success">Done</span></td>
                                            </tr>
                                        </tbody>
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
                                <p class="f-w-600">Fulfilled Orders <span class="pull-right">85%</span></p>
                                <div class="progress ">
                                    <div role="progressbar" style="display: none; width:85%; height:8px;" class="progress-bar bg-danger wow animated progress-animated"> <span class="sr-only">60% Complete</span> </div>
                                </div>

                                

                                <p class="m-t-30 f-w-600">Pending Orders<span class="pull-right">90%</span></p>
                                <div class="progress">
                                    <div role="progressbar" style="display: none; width: 90%; height:8px;" class="progress-bar bg-info wow animated progress-animated"> <span class="sr-only">60% Complete</span> </div>
                                </div>

                                <p class="m-t-30 f-w-600">Unfulfilled Orders<span class="pull-right">65%</span></p>
                                <div class="progress">
                                    <div role="progressbar" style="display: none; width: 65%; height:8px;" class="progress-bar bg-success wow animated progress-animated"> <span class="sr-only">60% Complete</span> </div>
                                </div>

                                <p class="m-t-30 f-w-600">Expired Orders<span class="pull-right">65%</span></p>
                                <div class="progress">
                                    <div role="progressbar" style="display: none; width: 65%; height:8px;" class="progress-bar bg-warning wow animated progress-animated"> <span class="sr-only">60% Complete</span> </div>
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