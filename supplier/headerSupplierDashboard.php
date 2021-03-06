<?php 

$retailerLoggedIn = '';
if(isset($_SESSION['retailerLoggedIn'])) {
    $retailerLoggedIn = $_SESSION['retailerLoggedIn'];
}
else {
    header("Location: ../register.php");
}

$inventoryNotification = mysqli_query($con, "SELECT quantity from inventory WHERE supplierId=(SELECT id FROM retailer WHERE emailid = '$retailerLoggedIn') AND quantity<20;");

$inventorySizeQuery = mysqli_query($con, "SELECT quantity from inventory WHERE supplierId=(SELECT id FROM retailer WHERE emailid = '$retailerLoggedIn');");

$inventorySize = mysqli_num_rows($inventorySizeQuery);

$ordersQuery = mysqli_query($con, "SELECT orderId from orders WHERE supplierId=(SELECT id FROM retailer WHERE emailid = '$retailerLoggedIn');");

$ordersTotal = mysqli_num_rows($ordersQuery);

$customersQuery = mysqli_query($con, "SELECT distinct userId from orders WHERE supplierId=(SELECT id FROM retailer WHERE emailid = '$retailerLoggedIn');");

$customersTotal = mysqli_num_rows($customersQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>Supplier Dashboard</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->

    <!-- <link href="css/lib/calendar2/semantic.ui.min.css" rel="stylesheet"> -->
    <!-- <link href="css/lib/calendar2/pignose.calendar.min.css" rel="stylesheet"> -->
    <!-- <link href="css/lib/owl.carousel.min.css" rel="stylesheet" /> -->
    <!-- <link href="css/lib/owl.theme.default.min.css" rel="stylesheet" /> -->
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="../includes/assets/css/style.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:** -->
    <!--[if lt IE 9]>
    <script src="https:**oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https:**oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header fix-sidebar">
    <!-- Preloader - style you can find in spinners.css -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- Main wrapper  -->
    <div id="main-wrapper">
        <!-- header header  -->
        <div class="header">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- Logo -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="supplierDashboard.php">
                        <!-- Logo icon -->
                        <b><img src="../includes/assets/images/logo-dashboard.jpg" alt="homepage" class="dark-logo" style="width: 32px;" /></b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span style="letter-spacing: 2.5px; color: #4db890; font-weight: bold;">MediQuick</span>
                    </a>
                </div>
                <!-- End Logo -->
                <div class="navbar-collapse">
                    <!-- toggle and nav items -->
                    <div class="mr-auto"></div>
                    <!-- User profile and search -->
                    <ul class="navbar-nav my-lg-0">

                        <!-- Comment -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-bell"></i>
                                <!-- <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div> -->
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox animated zoomIn">
                                <ul>
                                    <li>
                                        <div class="drop-title">Notifications</div>
                                    </li>
                                    <li>
                                        <div class="message-center">

                                        <?php 

                                        while($row=mysqli_fetch_array($inventoryNotification)){
                                            if($row['quantity']!=0){
                                                echo "<a href='table-datatable.php'>
                                                    <div class='btn btn-warning btn-circle m-r-10''><i class='fa fa-link'></i></div>
                                                    <div class='mail-contnet'>
                                                        <h5>Warning! Low Inventory</h5> <span class='mail-desc'>A medicine is low in quantity. Click to review details</span> 
                                                    </div>
                                                </a>";
                                            }
                                            else{
                                                echo "<a href='table-datatable.php'>
                                                    <div class='btn btn-danger btn-circle m-r-10''><i class='fa fa-link'></i></div>
                                                    <div class='mail-contnet'>
                                                        <h5>Altert! Medicine Out of Stock</h5> <span class='mail-desc'>A medicine is out of stock. Click to review details</span> 
                                                    </div>
                                                </a>";
                                            }
                                        }

                                         ?>
                                            <!-- Message -->
                                            <!-- <a href="#">
                                                <div class="btn btn-danger btn-circle m-r-10"><i class="fa fa-link"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>This is title</h5> <span class="mail-desc">Just see the my new admin!</span> <span class="time">9:30 AM</span>
                                                </div>
                                            </a> -->
                                            <!-- Message -->
                                            <!-- <a href="#">
                                                <div class="btn btn-success btn-circle m-r-10"><i class="ti-calendar"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>This is another title</h5> <span class="mail-desc">Just a reminder that you have event</span> <span class="time">9:10 AM</span>
                                                </div>
                                            </a> -->
                                            <!-- Message -->
                                            <!-- <a href="#">
                                                <div class="btn btn-info btn-circle m-r-10"><i class="ti-settings"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>This is title</h5> <span class="mail-desc">You can customize this template as you want</span> <span class="time">9:08 AM</span>
                                                </div>
                                            </a> -->
                                            <!-- Message -->
                                            <!-- <a href="#">
                                                <div class="btn btn-primary btn-circle m-r-10"><i class="ti-user"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>This is another title</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span>
                                                </div>
                                            </a> -->
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="javascript:void(0);"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- End Comment -->
                        
                        <!-- Profile -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/users/5.jpg" alt="user" class="profile-pic" /></a>
                            <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                                <ul class="dropdown-user">
                                    <li><a href="profile.php"><i class="ti-user"></i> Profile</a></li>
                                    <!-- <li><a href="#"><i class="ti-wallet"></i> Balance</a></li>
                                    <li><a href="#"><i class="ti-email"></i> Inbox</a></li> -->
                                    <li><a href="settings.php"><i class="ti-settings"></i> Setting</a></li>
                                    <li><a href="../register.php?logout=true"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- End header header -->
        <!-- Left Sidebar  -->
        <div class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-devider"></li>
                        <li class="nav-label">Home</li>
                        <li> <a class="has-arrow  " href="supplierDashboard.php" aria-expanded="false"><i class="fa fa-tachometer"></i><span class="hide-menu">Dashboard</span></a>
                            <!-- <ul aria-expanded="false" class="collapse">
                                <li><a href="index.html">Ecommerce </a></li>
                                <li><a href="index1.html">Analytics </a></li>
                            </ul> -->
                        </li>
                        <li class="nav-label">Apps</li>
                        <!-- <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-envelope"></i><span class="hide-menu">Email</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="email-compose.html">Compose</a></li>
                                <li><a href="email-read.html">Read</a></li>
                                <li><a href="email-inbox.html">Inbox</a></li>
                            </ul>
                        </li> -->
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-bar-chart"></i><span class="hide-menu">Analysis</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="chart-morris.php">Order History</a></li>
                            </ul>
                        </li>
                        <li class="nav-label">Features</li>
                        
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-table"></i><span class="hide-menu">Tables</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="table-orders.php">Orders</a></li>
                                <li><a href="table-datatable.php">Inventory</a></li>
                            </ul>
                        </li>

                        <li class="nav-label">Forms</li>
                        
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-table"></i><span class="hide-menu">Inventory</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="addInventory.php">Add Items</a></li>
                            </ul>
                        </li>
                        
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </div>
        <!-- End Left Sidebar  -->
        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Dashboard</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->