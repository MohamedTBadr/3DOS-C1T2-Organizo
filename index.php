<?php 
include("connection.php");

$select_p="SELECT *  FROM `project`";
$run_select_p=mysqli_query($connect,$select_p);
$num_p=mysqli_num_rows($run_select_p);


$select_m="SELECT * FROM `project_member`";
$run_select_m=mysqli_query($connect,$select_m);
$num_m=mysqli_num_rows($run_select_m);

$select_t="SELECT * FROM `task`";
$run_select_t=mysqli_query($connect,$select_t);
$num_t=mysqli_num_rows($run_select_t);

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    
    // Query to get subscription details for the user
    $select = "SELECT * FROM `subscription` WHERE `user_id` = '$user_id'";
    $run_select = mysqli_query($connect, $select);
  
    // Check if the query returned a result
    if (mysqli_num_rows($run_select) > 0) {
        $fetch = mysqli_fetch_assoc($run_select);
        $status = $fetch['status'];
        $end = $fetch['end_date']; // End date of the subscription
        $current_date = date("Y-m-d");
  
        // Check if the subscription is active and past the end date
        if ($status == 'active' && $current_date > $end) {
          // Update the subscription status to 'not active'
          $update_status = "UPDATE `subscription` SET `status` = 'not active' WHERE `user_id` = '$user_id'";
          $run_update = mysqli_query($connect, $update_status);
  
        }
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>organizo</title>
    <link rel="icon" type="image/x-icon" href="./img/keklogo.png">



    <!--  -->
    
    <!--  -->
  <!-- fontawesome link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <!--  -->

    <!-- Favicon -->
    <link rel="icon" href="img/card-favorite.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.0/css/boxicons.min.css" integrity="sha512-pVCM5+SN2+qwj36KonHToF2p1oIvoU3bsqxphdOIWMYmgr4ZqD3t5DjKvvetKhXGc/ZG5REYTT6ltKfExEei/Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- CSS FILES -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&display=swap"
        rel="stylesheet">

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/bootstrap-icons.css" rel="stylesheet">

    <link href="css/organiso.css" rel="stylesheet">


</head>

<body>

    <main>

        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="./index.php">
                    <i class='bx bxl-slack navbar-brand-image img-fluid'></i>
                    <!-- <img src="img/abstract-envelope.png" class="navbar-brand-image img-fluid" alt="organizo"> -->
			        <!-- <i class='bx bxl-slack'></i> -->

                    <span class="navbar-brand-text">
                        organizo
                        <!-- <small></small> -->
                    </span>
                </a>
                <?php if(!isset($_SESSION['user_id'])){ ?>
                <div class="d-lg-none ms-auto me-3">
                    <a class="btn custom-btn custom-border-btn" data-bs-toggle="offcanvas" href="./login.php?LC=1"
                        role="button" aria-controls="offcanvasExample">Login <a href="login.php?LC=1">Login</a></a>
                </div>
                <?php } ?>
                <?php if(isset($_SESSION['user_id'])) {?>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <?php } ?>

            <?php if(isset($_SESSION['user_id'])){ ?>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-lg-auto">
                        <li class="nav-item">
                            <a class="nav-link " href="./index.php">Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="./userprof.php">Profile</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="./projects.php">projects</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="./subscription.php">subscribe</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarLightDropdownMenuLink" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">Pages</a>

                            <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
                                <li><a class="dropdown-item" href="./my_tasks.php">My Tasks</a></li>
                                <li><a class="dropdown-item" href="./calendar.php">Calendar</a></li>
                                <li><a class="dropdown-item" href="./archive_taskss.php">Archive</a></li>
                            </ul>
                        </li>
                    </ul>
            <?php }else{ ?>
                    <div class="d-none d-lg-block ms-lg-3">
                        <a class="btn custom-btn custom-border-btn" role="button"
                            aria-controls="offcanvasExample" href="./login.php">Login</a>
                    </div>
                </div>
            <?php } ?>
            </div>
        </nav>




        <section class="hero-section d-flex justify-content-center align-items-center" id="section_1">

            <div class="section-overlay"></div>

            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#6db1a6" fill-opacity="1"
                    d="M0,224L34.3,192C68.6,160,137,96,206,90.7C274.3,85,343,139,411,144C480,149,549,107,617,122.7C685.7,139,754,213,823,240C891.4,267,960,245,1029,224C1097.1,203,1166,181,1234,160C1302.9,139,1371,117,1406,106.7L1440,96L1440,0L1405.7,0C1371.4,0,1303,0,1234,0C1165.7,0,1097,0,1029,0C960,0,891,0,823,0C754.3,0,686,0,617,0C548.6,0,480,0,411,0C342.9,0,274,0,206,0C137.1,0,69,0,34,0L0,0Z">
                </path>
            </svg>

            <div class="container">
                <div class="row">

                    <div class="col-lg-6  col-12 mb-5 mb-lg-0">
                        <h2 class="text-white">Welcome </h2>

                        <h1 class="cd-headline rotate-1 text-white mb-4 pb-2">
                            <span>Organizo is</span>
                            <span class="cd-words-wrapper">
                                <b class="is-visible">Modern</b>
                                <b>Creative</b>
                                <b>Lifestyle</b>
                            </span>
                        </h1>
                        <?php if(!isset($_SESSION['user_id'])){ ?>
                        <div class="custom-btn-group">
                            <a href="./login.php" class="btn custom-btn smoothscroll me-3">START</a>
                            <a href="./login.php" class="link smoothscroll">Become a member</a>
                        </div>
                        <?php }else{ ?>
                        <div class="custom-btn-group">
                            <a href="./projects.php" class="btn custom-btn smoothscroll me-3">START</a>
                            <!-- <a href="./userprof.php" class="link smoothscroll">Become a member</a> -->
                        </div>
                        <?php } ?>
                    </div>

                    <!-- <div class="col-lg-6 col-12">
                        <div class="ratio ratio-16x9">
                            <iframe width="560" height="315" src="https://www.youtube.com/embed/MGNgbNGOzh8"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>
                        </div>
                    </div> -->

                </div>
            </div>

            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#ffffff" fill-opacity="1"
                    d="M0,224L34.3,192C68.6,160,137,96,206,90.7C274.3,85,343,139,411,144C480,149,549,107,617,122.7C685.7,139,754,213,823,240C891.4,267,960,245,1029,224C1097.1,203,1166,181,1234,160C1302.9,139,1371,117,1406,106.7L1440,96L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z">
                </path>
            </svg>
        </section>

        <!-- beg of 1st features -->
        <section class=" sec1 hiddensec mt-5  container mb-8 mb-lg-13" id="about">
            <div class="row align-items-center">
                <div class="col-12 col-lg-6 col-xl-7"><img class="img-fluid" src="img/Team.webp" alt="" /></div>
                <div class="col-12 col-lg-6 col-xl-5">
                    <div class="row justify-content-center justify-content-lg-start">
                        <div class="col-sm-10 col-md-8 col-lg-12">
                            <h2 class="fs-4 fs-lg-3 fw-bold mb-2 text-lg-start">Collaborate with team members.</h2>
                            <p class="fs-8 mb-4 mb-lg-5 lh-lg  text-lg-start fw-normal">We share common trends and
                                strategies
                                for improving your rental income</p>
                        </div>
                        <div class="col-sm-10 col-md-8 col-lg-12">
                            <div class="mb-x1 mb-lg-3">
                                <h5 class="fs-8 fw-bold lh-lg mb-1">Project Based Groups </h5>
                                <p class="mb-0  lh-xl">You can use this module to monitor ongoing projects seamlessly.
                                </p>
                            </div>
                            <div>
                                <h5 class="fs-8 fw-bold lh-lg mb-1"> Unlimited Projects </h5>
                                <p class="lh-xl mb-0">Conduct unlimited Project with us for better business operations.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end of 1st features -->
        <section class="bg-color">
            <svg viewBox="0 0 1265 144" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <path fill="rgba(255, 255, 255, 1)" d="M 0 40 C 164 40 164 20 328 20 L 328 20 L 328 0 L 0 0 Z"
                    stroke-width="0"></path>
                <path fill="rgba(255, 255, 255, 1)" d="M 327 20 C 445.5 20 445.5 89 564 89 L 564 89 L 564 0 L 327 0 Z"
                    stroke-width="0"></path>
                <path fill="rgba(255, 255, 255, 1)" d="M 563 89 C 724.5 89 724.5 48 886 48 L 886 48 L 886 0 L 563 0 Z"
                    stroke-width="0"></path>
                <path fill="rgba(255, 255, 255, 1)"
                    d="M 885 48 C 1006.5 48 1006.5 67 1128 67 L 1128 67 L 1128 0 L 885 0 Z" stroke-width="0"></path>
                <path fill="rgba(255, 255, 255, 1)" d="M 1127 67 C 1196 67 1196 0 1265 0 L 1265 0 L 1265 0 L 1127 0 Z"
                    stroke-width="0"></path>
            </svg>


            <!-- beg of 2nd features -->
            <div class="container2">
                <section class=" container hiddensec mb-8 mb-lg-13">
                    <div class="row align-items-center">

                        <div class="col-12 col-lg-6 col-xl-5 order-lg-1 ">
                            <img class=" imgfeat2 img-fluid widthimg ms-auto" src="img/Screenshot 2024-08-04 031813.png"
                                alt="" />
                        </div>

                        <div class="col-12 col-lg-6 col-xl-7 ">
                            <div class="row justify-content-center justify-content-lg-start ">
                                <div class="col-sm-10 col-md-8 col-lg-11">
                                    <h2 class="fs-4 fs-lg-3 fw-bold mb-2 text-center text-white  text-lg-start"> Organize remote
                                        team fast & easily.</h2>
                                    <p class="fs-8 mb-4 mb-lg-5 lh-lg text-center text-white  text-lg-start fw-normal">Organizing
                                        and managing your remote
                                        teams has never been this easy!</p>
                                </div>
                                <div class="col-sm-10 col-md-8 col-lg-12">
                                    <div class="mb-x1 mb-lg-3">
                                        <h5 class="fs-8 fw-bold text-white lh-lg mb-1">Create Unlimited Teams </h5>
                                        <p class="b-0 lh-xl text-white">Create unlimited teams and boost productivity with
                                            efficient collaboration.</p>
                                    </div>
                                    <div>
                                        <h5 class="fs-8 fw-bold lh-lg mb-1 text-white"> Hasslefree Connect with Everyone</h5>
                                        <p class="lh-xl mb-0 text-white">With unique and simple UIs, keep yourself connected across
                                            all the teams.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <!-- end of 2nd features -->



        </section>

        <svg viewBox="0 0 1265 144" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <path fill="#6db1a6" d="M 0 40 C 164 40 164 20 328 20 L 328 20 L 328 0 L 0 0 Z" stroke-width="0"></path>
            <path fill="#6db1a6" d="M 327 20 C 445.5 20 445.5 89 564 89 L 564 89 L 564 0 L 327 0 Z" stroke-width="0">
            </path>
            <path fill="#6db1a6" d="M 563 89 C 724.5 89 724.5 48 886 48 L 886 48 L 886 0 L 563 0 Z" stroke-width="0">
            </path>
            <path fill="#6db1a6" d="M 885 48 C 1006.5 48 1006.5 67 1128 67 L 1128 67 L 1128 0 L 885 0 Z"
                stroke-width="0"></path>
            <path fill="#6db1a6" d="M 1127 67 C 1196 67 1196 0 1265 0 L 1265 0 L 1265 0 L 1127 0 Z" stroke-width="0">
            </path>
        </svg>




        <!-- how does it work -->
        <section class="container hiddensec  ">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-7">
                    <h3 class="fs-1 fs-lg-3 fw-bold text-center mb-2 mb-lg-x1"> How does <span class="text-nowrap">it
                            work?</span>
                    </h3>
                    <p class="fs-5 mb-7 mb-lg-8 text-center lh-lg">You can use this as it is or tweak it as you seem
                        necessary. you
                        seem necessary.</p>
                </div>
                <div class="col-12">
                    <div class="row g-sm-2 g-lg-3 align-items-center timeline">
                        <div
                            class="col-12 col-lg-4 d-flex flex-row flex-lg-column justify-content-center gap-2 gap-sm-x1 gap-md-4 gap-lg-0  align-items-center">
                            <div class="timeline-step-1 w-25 w-lg-100 mb-4 mb-lg-5 mb-xl-6   ">
                                <div class="timeline-item d-flex justify-content-center  ">
                                    <div style="width: 50%; border-radius: 50%;"
                                        class="timeline-icon bg-primary rounded-circle d-flex justify-content-center align-items-center">
                                        <span class="fs-3 fs-lg-5 fs-xl-4 text-white"> 1</span>
                                    </div>
                                </div>
                            </div>
                            <div class="py-1 py-lg-0 px-lg-5 w-75 w-sm-50 w-lg-100 timeline-content">
                                <h6 class="fs-3 fw-bold text-lg-center lh-lg mb-2 text-nowrap">Sign up in Organizo</h6>
                                <p class="text-lg-center lh-xl mb-0">Sign up with a single click.</p>
                            </div>
                        </div>
                        <div
                            class="col-12 col-lg-4 d-flex flex-row flex-lg-column justify-content-center gap-2 gap-sm-x1 gap-md-4 gap-lg-0  align-items-center">
                            <div class="timeline-step-2 w-25 w-lg-100 mb-4 mb-lg-5 mb-xl-6">
                                <div class="timeline-item d-flex justify-content-center">
                                    <div style="width: 50%; border-radius: 50%;"
                                        class="timeline-icon bg-success rounded-circle d-flex justify-content-center align-items-center">
                                        <span class="fs-3 fs-lg-5 fs-xl-4 text-white"> 2</span>
                                    </div>
                                </div>
                            </div>
                            <div class="py-1 py-lg-0 px-lg-5 w-75 w-sm-50 w-lg-100 timeline-content">
                                <h6 class="fs-3 fw-bold text-lg-center text-nowrap ">Add Team Members</h6>
                                <p class="text-lg-center lh-xl mb-0">Adding team <span class="text-nowrap"> members to
                                        your projects.
                                    </span></p>
                            </div>
                        </div>
                        <div
                            class="col-12 col-lg-4 d-flex flex-row flex-lg-column justify-content-center gap-2 gap-sm-x1 gap-md-4 gap-lg-0  align-items-center">
                            <div
                                class="timeline-step-3 position-relative z-1 overflow-hidden w-25 w-lg-100 mb-4 mb-lg-5 mb-xl-6">
                                <div class="timeline-item d-flex justify-content-center">
                                    <div 
                                    style="width: 50%; border-radius: 50%;"
                                        class="timeline-icon bg-color rounded-circle d-flex justify-content-center align-items-center">
                                        <span class="fs-3 fs-lg-5 fs-xl-4 text-white"> 3</span></div>
                                </div>
                            </div>
                            <div class="py-1 py-lg-0 px-lg-5 w-75 w-sm-50 w-lg-100 timeline-content">
                                <h6 class="fs-3 fw-bold text-lg-center lh-lg mb-2">Start Rolling</h6>
                                <p class="text-lg-center lh-xl mb-0">Operating your <span class="text-nowrap"> business
                                        in a simpler
                                        way!</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- END OF HOW IT WORK -->


        <!-- BEG OF WHY  -->

        <section class="experience hiddensec position-relative overflow-hidden bg-color" id="service">
            <svg viewBox="0 0 1265 144" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <path fill="rgba(255, 255, 255, 1)" d="M 0 40 C 164 40 164 20 328 20 L 328 20 L 328 0 L 0 0 Z"
                    stroke-width="0"></path>
                <path fill="rgba(255, 255, 255, 1)" d="M 327 20 C 445.5 20 445.5 89 564 89 L 564 89 L 564 0 L 327 0 Z"
                    stroke-width="0"></path>
                <path fill="rgba(255, 255, 255, 1)" d="M 563 89 C 724.5 89 724.5 48 886 48 L 886 48 L 886 0 L 563 0 Z"
                    stroke-width="0"></path>
                <path fill="rgba(255, 255, 255, 1)"
                    d="M 885 48 C 1006.5 48 1006.5 67 1128 67 L 1128 67 L 1128 0 L 885 0 Z" stroke-width="0"></path>
                <path fill="rgba(255, 255, 255, 1)" d="M 1127 67 C 1196 67 1196 0 1265 0 L 1265 0 L 1265 0 L 1127 0 Z"
                    stroke-width="0"></path>
            </svg>
            <div class="container container3">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="position-relative z-1 text-center mb-8 mb-lg-9 video-player-paused"
                            data-video-player-container="data-video-player-container">
                            <div class="overlay  rounded-4 bg-1100 object-cover" data-overlay="data-overlay"> <img
                                    class="pause-icon w-100 h-100 " src="img/Screenshot 2024-08-04 060742.png" alt="" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-7 mt-5">
                        <h2 class="fs-3 fs-lg-3 fw-bold text-center text-white mb-5 mb-lg-9 lh-sm">We made Organizo to
                            solve your
                            problems.</h2>
                    </div>
                    <div class="col-12">
                        <div class="row gy-4 g-md-3 pb-8 pb-lg-11 px-1">
                            <div class="col-12 col-md-6 col-lg-4 d-flex align-items-start gap-2">
                                <!-- <img class="imgwhy"
                                    src="img/plan-list-svgrepo-com.svg"> -->
                                <div>
                                    <h5 class="fs-8 text-white lh-lg fw-bold">Unlimited Projects</h5>
                                    <p class="text-white text-opacity-50 lh-xl mb-0">Manage multiple projects at once
                                        and for seamless
                                        business operation.</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 d-flex align-items-start gap-2">
                                <!-- <img class="imgwhy"
                                    src="img/team-work-svgrepo-com.svg" alt="" > -->
                                <div>
                                    <h5 class="fs-8 text-white lh-lg fw-bold">Team Management</h5>
                                    <p class="text-white text-opacity-50 lh-xl mb-0">Manage your cross-functional teams
                                        better than ever
                                        with our easily manageable app.</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 d-flex align-items-start gap-2">
                                <!-- <img class="imgwhy"
                                    src="img/share-svgrepo-com (1).svg" alt=""> -->
                                <div>
                                    <h5 class="fs-8 text-white lh-lg fw-bold">File Sharing</h5>
                                    <p class="text-white text-opacity-50 lh-xl mb-0">Easily share files where necessary
                                        and keep them safe
                                        with enhanced security and protection.</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 d-flex align-items-start gap-2">
                                <!-- <img class="imgwhy"
                                    src="img/chart-column-grow-svgrepo-com.svg" alt="" > -->
                                <div>
                                    <h5 class="fs-8 text-white lh-lg fw-bold">Increase Profit</h5>
                                    <p class="text-white text-opacity-50 lh-xl mb-0">increase your profit of your
                                        projects and your company</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 d-flex align-items-start gap-2">
                                <!-- <img class="imgwhy"
                                    src="img/calendar-svgrepo-com (1).svg" alt="" > -->
                                <div>
                                    <h5 class="fs-8 text-white lh-lg fw-bold">Time Tracking</h5>
                                    <p class="text-white text-opacity-50 lh-xl mb-0">Track time to ensure meeting all
                                        the deadlines and
                                        never lag behind managing multiple projects.</p>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 d-flex align-items-start gap-2">
                                <!-- <img class="imgwhy"
                                    src="img/payment-request-api-svgrepo-com.svg" alt="" > -->
                                <div>
                                    <h5 class="fs-8 text-white lh-lg fw-bold">Payment System</h5>
                                    <p class="text-white text-opacity-50 lh-xl mb-0">With its easy payment system create
                                        invoices and get
                                        paid all at the same place.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="position-absolute top-0 start-0 end-0">
                <div class="bg-white  py-md-9 py-xl-10"> </div><img class="wave" src="img/Wave_2.svg" alt="" />
            </div>
        </section>
        <!-- end of why -->



        <section class="section">




                    <!-- Start Fun-facts -->
                    <div id="fun-facts" class="fun-facts section overlay bg-color ">
                        <svg viewBox="0 0 1265 144" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <path fill="rgba(255, 255, 255, 1)" d="M 0 40 C 164 40 164 20 328 20 L 328 20 L 328 0 L 0 0 Z"
                                stroke-width="0"></path>
                            <path fill="rgba(255, 255, 255, 1)" d="M 327 20 C 445.5 20 445.5 89 564 89 L 564 89 L 564 0 L 327 0 Z"
                                stroke-width="0"></path>
                            <path fill="rgba(255, 255, 255, 1)" d="M 563 89 C 724.5 89 724.5 48 886 48 L 886 48 L 886 0 L 563 0 Z"
                                stroke-width="0"></path>
                            <path fill="rgba(255, 255, 255, 1)"
                                d="M 885 48 C 1006.5 48 1006.5 67 1128 67 L 1128 67 L 1128 0 L 885 0 Z" stroke-width="0"></path>
                            <path fill="rgba(255, 255, 255, 1)" d="M 1127 67 C 1196 67 1196 0 1265 0 L 1265 0 L 1265 0 L 1127 0 Z"
                                stroke-width="0"></path>
                        </svg>


                        <div class="container">
                            <div class="row">
                                <div class="col-lg-4 col-md-6 col-12 ">

                                    <!-- Start Single Fun -->
                                    <div class="single-fun">
                                        <div class="content">
                                         <i class="fa fa-solid fa-heart"></i>
                                            <span class="counter"><?php echo $num_p?></span>
                                            <p>projects</p>
                                        </div>
                                    </div>
                                    <!-- End Single Fun -->

                                </div>

                                <div class="col-lg-4 col-md-6 col-12">
                                    <!-- Start Single Fun -->
                                    <div class="single-fun">
                                        <div class="content">
                                        <i class="fa fa-solid fa-heart"></i>

                                            <span class="counter"><?php echo $num_m?></span>
                                            <p>members</p>
                                        </div>
                                    </div>
                                    <!-- End Single Fun -->
                                </div>
                                <div class="col-lg-4 col-md-6 col-12">
                                    <!-- Start Single Fun -->
                                    <div class="single-fun">
                                        <div class="content">
                                            <i class="fa fa-solid fa-heart"></i>
                                        

                                            <span class="counter"><?php echo $num_t ?></span>
                                            <p>tasks</p>
                                        </div>
                                    </div>
                                    <!-- End Single Fun -->
                                </div>
                            </div>
                        </div>
                    </div>


                    
                    <!--/ End Fun-facts -->

            <svg viewBox="0 0 1265 144" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <path fill="#6db1a6" d="M 0 40 C 164 40 164 20 328 20 L 328 20 L 328 0 L 0 0 Z"
                    stroke-width="0"></path>
                <path fill="#6db1a6" d="M 327 20 C 445.5 20 445.5 89 564 89 L 564 89 L 564 0 L 327 0 Z"
                    stroke-width="0"></path>
                <path fill="#6db1a6" d="M 563 89 C 724.5 89 724.5 48 886 48 L 886 48 L 886 0 L 563 0 Z"
                    stroke-width="0"></path>
                <path fill="#6db1a6"
                    d="M 885 48 C 1006.5 48 1006.5 67 1128 67 L 1128 67 L 1128 0 L 885 0 Z" stroke-width="0"></path>
                <path fill="#6db1a6" d="M 1127 67 C 1196 67 1196 0 1265 0 L 1265 0 L 1265 0 L 1127 0 Z"
                    stroke-width="0"></path>
            </svg>
        </section>





        <div>


            <!-- beg of questions -->
            <section class="">
                <div class="container">
                    <div class="row py-8 py-md-10 py-lg-11">
                        <div class="col-lg-6">
                            <div class="row justify-content-center justify-content-lg-start">
                                <div class="where col-md-8 col-lg-12 col-xl-11">
                                    <h2 class="color fs-3 fs-lg-3 lh-sm mb-2  text-lg-start fw-bold">We are always here
                                    </h2>
                                    <p
                                        class="fs-8 color text-opacity-65 mb-4 mb-md-6 mb-lg-7 lh-lg mb-6 mb-lg-7  text-lg-start">
                                        We share common trends and strategies for creating </p>
                                </div>
                                <div class="col-lg-10">
                                    <div class="d-flex gap-2 gap-lg-x1 mb-4 mb-lg-5">
                                        <div>
                                            <div
                                                class="check-icon bg-success mb-1 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="uil uil-check color"></span>
                                            </div>
                                        </div>

                                        <div>
                                            <h5 class="fs-4 fw-bold lh-lg mb-1">Noise Free website</h5>
                                            <p class="lh-xl color text-opacity-70 mb-0">We ensure noise-free website to
                                                focus </p>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 gap-lg-x1 mb-4 mb-lg-5">
                                        <div>
                                            <div
                                                class="check-icon bg-success mb-1 rounded-circle d-flex align-items-center justify-content-center">
                                                <span class="uil uil-check color"></span>
                                            </div>
                                        </div>
                                        <div>
                                            <h5 class="fs-4 fw-bold lh-lg mb-1  color">24/7 Hour Support</h5>
                                            <p class="lh-xl  text-opacity-70 mb-0">Get support from our efficient
                                                customer support team,
                                                24/7, all year round.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="col-lg-6">
                            <div class="accordion mt-lg-4 ps-3 pe-x1 " id="accordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading1"><button
                                            class="accordion-button fs-4 lh-lg fw-bold pt-x1 pb-2" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expand="true"
                                            aria-controls="collapse1" data-accordion-button="data-accordion-button">How
                                            do i create a new project?</button></h2>
                                    <div class="accordion-collapse collapse show" id="collapse1"
                                        data-bs-parent="#accordion">
                                        <div class="accordion-body lh-xl pt-0 pb-x1">Click the "Create Project" button,
                                            give it a name, and add your team members</div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading2"><button
                                            class="accordion-button fs-4 lh-lg fw-bold pt-x1 pb-2 collapsed"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapse2"
                                            aria-expand="false" aria-controls="collapse2"
                                            data-accordion-button="data-accordion-button">How can i assign tasks to team
                                            members?</button></h2>
                                    <div class="accordion-collapse collapse" id="collapse2" data-bs-parent="#accordion">
                                        <div class="accordion-body lh-xl pt-0 pb-x1">Create a task , select the "Add
                                            member" option and choose the person responsible
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading3"><button
                                            class="accordion-button fs-4 lh-lg fw-bold pt-x1 pb-2 collapsed"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapse3"
                                            aria-expand="false" aria-controls="collapse3"
                                            data-accordion-button="data-accordion-button">How do i track progress and
                                            see whats been completed?</button></h2>
                                    <div class="accordion-collapse collapse" id="collapse3" data-bs-parent="#accordion">
                                        <div class="accordion-body lh-xl pt-0 pb-x1">in the project page show the
                                            progress of each task , with completed tasks marked as finished</div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading4"><button
                                            class="accordion-button fs-4 lh-lg fw-bold pt-x1 pb-2 collapsed"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapse4"
                                            aria-expand="false" aria-controls="collapse4"
                                            data-accordion-button="data-accordion-button">Can i communicate with my team
                                            within the project ?</button></h2>
                                    <div class="accordion-collapse collapse" id="collapse4" data-bs-parent="#accordion">
                                        <div class="accordion-body lh-xl pt-0 pb-x1">yes, you can leave comments on
                                            tasks </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading5"><button
                                            class="accordion-button fs-4 lh-lg fw-bold pt-x1 pb-2 collapsed"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#collapse5"
                                            aria-expand="false" aria-controls="collapse5"
                                            data-accordion-button="data-accordion-button">How can I get  to your
                                            support?</button></h2>
                                    <div class="accordion-collapse collapse" id="collapse5" data-bs-parent="#accordion">
                                        <div class="accordion-body lh-xl pt-0 pb-x1">To reach our support team, simply
                                            send an email to
                                            organizohelp@gmail.com Our team will promptly address your inquiry and
                                            provide assistance as needed.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>



    </main>

    <footer class="site-footer">



        
  <!-- Site footer -->
  <div class="main-footer">
    <footer class="site-footer">
      <div class="container">
        <div class="row">
          <div class="col-sm-12 col-md-6">
            <h6>About</h6>
            <p class="text-justify"> Planner websites are online tools designed to help individuals and organizations
              manage their schedules, tasks, and projects. They often offer features like calender integration, task
              lists, reminders, goal tracking, and collaborative functions </p>
            </p>
          </div>

          <div class="col-xs-6 col-md-3">
            <h6>Categories</h6>
            <ul class="footer-links">
              <li><a href="./index.php">Home</a></li>
              <li><a href="./subscription.php">pricing</a></li>
              <li><a href="./my_tasks.php">Personal board</a></li>
              <li><a href="./tasks.php">General board</a></li>
              <li><a href="./userprof.php">User Profile</a></li>
              <li><a href="./projects.php">Projects</a></li>
            </ul>
          </div>

          <div class="col-xs-6 col-md-3">
            <h6>Quick Links</h6>
            <ul class="footer-links">
              <li><a href="http://scanfcode.com/about/">About Us</a></li>
              <li><a href="http://scanfcode.com/contact/">Contact Us</a></li>
              <li><a href="http://scanfcode.com/contribute-at-scanfcode/">Contribute</a></li>
              <li><a href="http://scanfcode.com/privacy-policy/">Privacy Policy</a></li>
              <li><a href="http://scanfcode.com/sitemap/">Sitemap</a></li>
            </ul>
          </div>
        </div>
        <hr>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-sm-6 col-xs-12">
            <p class="copyright-text">Copyright &copy; 2024 All Rights Reserved by
              <a href="./index.php">organizo</a>.
            </p>
          </div>

          <div class="col-md-4 col-sm-6 col-xs-12">
            <ul class="social-icons">
              <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
              <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
              <li><a class="dribbble" href="#"><i class="fa fa-dribbble"></i></a></li>
              <li><a class="linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </footer>



    <!-- Get Pro Button -->
    <ul class="pro-features">
        <?php if(isset($_SESSION['user_id'])) {?>
        <a class="get-pro" href="./subscription.php">GET PRO</a>
        <?php } else { ?>
        <a class="get-pro" href="./login.php">GET PRO</a>
        <?php } ?>
        <li class="big-title">Bronze</li>
        <li class="big-title">Silver</li>
        <li class="title">Gold</li>
        <li style="list-style: none;">Alot of options to make yourr life easer ,  what are you wating for subscribe now</li>
        <!-- <li>lllllllllll</li>
        <li>llllllllllll</li>
        <li>lallalalla</li>
        <li>lallalala</li> -->
        <div class="button">
            <a href="" class="btn">Subscribe now</a>
            <!-- <a href="" class="btn">Buy Pro Version</a> -->
        </div>
    </ul>




    <!-- JAVASCRIPT FILES -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <!-- <script src="js/click-scroll.js"></script> -->
    <script src="js/animated-headline.js"></script>
    <script src="js/modernizr.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/main.js"></script>

    <!-- new  -->

    <!-- jquery Migrate JS -->
    <script src="js/jquery-migrate-3.0.0.js"></script>

    <!-- Slicknav JS -->
    <script src="js/slicknav.min.js"></script>

    <!-- Owl Carousel JS -->
    <script src="js/owl-carousel.js"></script>

    <!-- counterup JS -->
    <script src="js/jquery.counterup.min.js"></script>

    <!-- Counter Up CDN JS -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>


</body>

</html>