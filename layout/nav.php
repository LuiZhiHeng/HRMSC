<?php
function get_navbar($logged_user, $logged_user_type, $logged_user_id){
?>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark d-print-none">
            <a class="navbar-brand ps-3" href="index.php">HRMS Church</a>
            <button class="btn btn-link btn-sm mx-auto order-1 order-lg-0 me-3 me-lg-4" id="sidebarToggle" href=""><i class="fas fa-bars"></i></button>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav" class="d-print-none">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                        
                        <?php if($logged_user_type == 1 || $logged_user_type == 2){ ?>
                            <div class="sb-sidenav-footer text-light">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-user"></i>
                                    <span class="small">&nbsp;&nbsp;Logged as: </span>
                                    <?= $logged_user ?>
                                </div>
                            </div>

                            <!-- Home -->
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-home"></i>
                                </div>
                                <span class="text-uppercase">Home</span>
                            </a>
                        <?php } else { ?>

                            <a class="sb-sidenav-footer nav-link text-light" href="login.php">
                                <div class="sb-nav-link-icon text-light">
                                    <i class="fas fa-sign-in-alt"></i>
                                </div>
                                Log In
                            </a>
                        <?php } ?>

                        <!-- User Info -->
                        <?php if($logged_user_type == 1 || $logged_user_type == 2){ ?>
                            <a class="nav-link" href="employee.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-list-alt"></i></div>
                                <?php if($logged_user_type == 1){ ?>
                                    Employee List
                                <?php } elseif($logged_user_type == 2){ ?>
                                    Profile
                                <?php } ?>
                            </a>
                        <?php } ?>

                        <!-- Leave -->
                        <?php if($logged_user_type == 1 || $logged_user_type == 2){ ?>
                            <a class="nav-link" href="leave.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-business-time"></i></div>
                                Leave
                            </a>
                        <?php } ?>

                        <!-- Attendance -->
                        <?php if($logged_user_type == 1){ ?>
                            <a class="nav-link" href="attendance.php">
                            <div class="sb-nav-link-icon"><i class="far fa-calendar-alt"></i></div>
                                Attendance
                            </a>
                        <?php } elseif($logged_user_type == 2){ ?>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#attendance" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="far fa-calendar-alt"></i></div>
                                Attendance
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="attendance" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="attendance.php">Record</a>
                                    <a class="nav-link" href="attendance.php?punch=">Punch-In/Out</a>
                                </nav>
                            </div>
                        <?php } ?>

                        <!-- Recruitment -->
                        <?php if($logged_user_type == 1){ ?>
                            <a class="nav-link" href="recruitment.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-toolbox"></i></div>
                                Recruitment
                            </a>
                        <?php } elseif($logged_user_type != 1 && $logged_user_type != 2){ ?>
                            
                            <a class="nav-link" href="recruitment.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-toolbox"></i></div>
                                <span> Job Vacancy</span>
                            </a>
                        <?php } ?>

                        <!-- Financial -->
                        <?php if($logged_user_type == 1 || $logged_user_type == 2){ ?>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#financial" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-coins"></i></div>
                                Financial
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="financial" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="payroll.php">Payroll</a>
                                    <a class="nav-link" href="claim.php">Claim</a>
                                </nav>
                            </div>
                        <?php } ?>

                        <!-- Setting -->
                        <?php if($logged_user_type == 1 || $logged_user_type == 2){ ?>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#setting" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-tools"></i></div>
                                Setting
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="setting" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="setting.php?changePass=">Change Password</a>
                        <?php } 
                        
                            if($logged_user_type == 1) {
                                if($logged_user_id == 1) echo '<a class="nav-link" href="setting.php?permission=">Permission</a>';
                                checkPermission($logged_user_id);
                            }
                            
                            if($logged_user_type == 1 || $logged_user_type == 2){ ?>
                                </nav>
                            </div>
                        </div>
                        <?php } ?>
                    </div>

                    <?php if($logged_user_type == 1 || $logged_user_type == 2){ ?>
                    <a class="nav-link sb-sidenav-footer text-light" href="Javascript:logout()">
                        <div class="sb-nav-link-icon">
                            <i class="fas fa-sign-out-alt"></i>
                            Log Out
                        </div>
                    </a>
                    <?php } ?>
                </nav>
            </div>
            <script>
                function logout(){
                    swal({
                        title: "Log Out?",
                        text: "Are you sure want to log out?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                        })
                        .then((logout) => {
                            if (logout) {
                                window.location = "function/logout.php";
                            }
                        }
                    );
                }
            </script>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
<?php
}

function checkPermission($logged_user_id){
    global $conn;
    $rsPermission = $conn->query("SELECT * FROM permission");
    if($rsPermission->num_rows >= 0){
        for ($i=0; $i < $rsPermission->num_rows; $i++){ 
            $dataPermission = $rsPermission->fetch_assoc();
            $page = $dataPermission['name'];
            $lvl = $dataPermission['permissionLevel'];

            if($logged_user_id <= $lvl){
                $arrPage = explode("_", $page);
                $pageText = "";
                for ($j=0; $j < count($arrPage); $j++) { 
                    $pageText .= ucfirst($arrPage[$j]) . " ";
                }
                echo '<a class="nav-link" href="setting.php?' . $page . '=">' . $pageText . '</a>';
            }
        }
        
    } else echo'<script>console.log("Fail to get setting nav");</script>';
}

get_navbar(get_logged_user_shortname(), get_logged_user_type(), get_logged_user_id());
?>