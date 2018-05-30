<?php
// header for admin page
function printHead($page, $name) {?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <link rel="icon" href="/resource/images/logoUM.png">
        <title>Halaman admin EVAN</title>
        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons"
              type="text/css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css"/>
        <link rel="stylesheet" href="/resource/stylesheet/vendor/material-dashboard.css?v=2.0.0">
        <link rel="stylesheet" href="/resource/stylesheet/vendor/material-dashboard-demo.css">
    </head>
    <body class="">
    <div class="wrapper">
    <div class="sidebar" data-color="purple" data-background-color="white" data-image="../assets/img/sidebar-1.jpg">
        <div class="logo">
            <a href="http://evan.um.ac.id" class="simple-text logo-normal">
                Evan UM
            </a>
        </div>
        <div class="sidebar-wrapper">
            <ul class="nav">
                <li class="nav-item <?php if($page == 'assessment')echo'active'?>">
                    <a class="nav-link" href="/admin/assessment.php">
                        <i class="material-icons">content_paste</i>
                        <p>Hasil Penilaian</p>
                    </a>
                </li>
                <li class="nav-item <?php if($page == 'institute')echo'active'?>">
                    <a class="nav-link" href="/admin/institute.php">
                        <i class="material-icons">person</i>
                        <p>Lembaga</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="main-panel">
    <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top">
        <div class="container-fluid">
            <div class="navbar-wrapper">
                <a class="navbar-brand" href="#"><?php echo $name?></a>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
                    aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                <span class="sr-only">Toggle navigation</span>
                <span class="navbar-toggler-icon icon-bar"></span>
                <span class="navbar-toggler-icon icon-bar"></span>
                <span class="navbar-toggler-icon icon-bar"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navigation">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">person</i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="/login.php?logout">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<?php }
// footer for admin page
function printFoot() { ?>
    </div>
    </div>
    <script src="/resource/js/vendor/jquery.min.js"></script>
    <script src="/resource/js/vendor/popper.min.js"></script>
    <script src="/resource/js/vendor/bootstrap-material-design.min.js"></script>
    <script src="/resource/js/vendor/bootstrap-notify.js"></script>
    </body>
    </html>
<?php } ?>