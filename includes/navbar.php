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

                            if(isset($_SESSION['userLoggedIn'])){
                                echo "<li><a href='orders.php?logout=true'>View Orders</a></li>";

                                echo "<li><a href='register.php?logout=true'>Log Out</a></li>";

                            } 
                            else{
                               echo "<li><a href='register.php'>Log In</a></li>";
                            }
                        ?>


                        <!-- Profile and noti -->


                    </ul>


                </div><!-- /.nav-collapse -->
            </div><!-- /.container -->
        </nav><!-- /.navbar -->