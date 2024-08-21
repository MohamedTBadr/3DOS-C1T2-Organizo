<?php 
include 'connection.php';

$select_p="SELECT *  FROM `project`";
$run_select_p=mysqli_query($connect,$select_p);
$num_p=mysqli_num_rows($run_select_p);


$select_m="SELECT * FROM `project_member`";
$run_select_m=mysqli_query($connect,$select_m);
$num_m=mysqli_num_rows($run_select_m);

$select_t="SELECT * FROM `task`";
$run_select_t=mysqli_query($connect,$select_t);
$num_t=mysqli_num_rows($run_select_t);




// $member_count_query = "SELECT COUNT(*) as member_count FROM `project_member`";
// $member_result_result = mysqli_query($connect,$member_count_query);
// $member_count = mysqli_fetch_assoc($member_result_result)['member_count'];




// $select_task="SELECT * FROM `task` ";
// $runselect2=mysqli_query($connect, $select_task);
// $task_count=mysqli_num_rows($runselect2);
// // $task_query = "SELECT COUNT(*) as task_count FROM task  ";
// // $task_result = mysqli_query($connect,$task_query);
// // $task_count = mysqli_fetch_assoc($task_result)['task_count'];



// $select_project="SELECT * FROM project ";
// $runselect3=mysqli_query($connect, $select_project);

// $project_query = "SELECT COUNT(*) as project_count FROM project ";
// $project_result = mysqli_query($connect,$project_query);
// $project_count = mysqli_fetch_assoc($project_result)['project_count'];

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- flaticon -->
  <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.5.1/uicons-bold-rounded/css/uicons-bold-rounded.css'>
  <!-- link google fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
  <!-- link fontawsome -->
  <script src="https://kit.fontawesome.com/4f17bdb3b3.js" crossorigin="anonymous"></script>
  <!-- link bootstrab -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css"
    integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- link css -->
  <link rel="stylesheet" href="css/homepage.css">
  <link rel="stylesheet" href="css/swiper-bundle.min.css">
  <!-- link google fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Unna:ital,wght@0,400;0,700;1,400;1,700&display=swap"
    rel="stylesheet">
  <title>Organizo</title>
</head>

<body>
  <!-- beg of navbar -->
  <nav class="navbar navbar-expand-lg  sticky-top bg-body-tertiary">
    <div class="container-fluid ">
      <a class="navbar-brand text-warning" href="index.php">Organizo</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class=" " id="navbarNav">
        <ul class="navbar-nav">
          <!-- <li class="nav-item">
            <a class="nav-link active text-warning" aria-current="page" href="index.php">Home</a>
          </li> -->
          <!-- <li class="nav-item">
            <a class="nav-link text-warning" href="">Pricing</a>
          </li> -->
          <?php if(!isset($_SESSION['user_id'])){ ?>
          <li class="nav-item">
            <a class="nav-link text-warning" href="login.php">Signup</a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link text-warning" href="login.php">Login</a>
          </li>  -->
          <?php  } else{  ?>

          <li class="nav-item">
            <a class="nav-link text-warning" href="userprof.php">My profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-warning" href="projects.php">Projects</a>
          </li>
          <li class="my_tasks.php">
            <a class="nav-link text-warning" href="my_tasks.php">My Tasks</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-warning" href="subscription.php">Premium Plans</a>
          </li>
          <?php } ?>
          
        </ul>
      </div>
    </div>
  </nav>
  <!-- end of navbar -->

  <!-- hero content -->
  <div class="wave-header">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#0a7273" fill-opacity="1" d="M0,128L60,149.3C120,171,240,213,360,192C480,171,600,85,720,58.7C840,32,960,64,1080,90.7C1200,117,1320,139,1380,149.3L1440,160L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path></svg>
    <section class="hero-section overflow-hidden position-relative z-0 mb-4 mb-lg-0" id="home">
      <div class="hero-background">
        <div class="container">
          <div class="row gy-4 gy-md-8 pt-9 pt-lg-0">
            <div class="text-center text-lg-start">
              <h1 class="herohead1 text-center" aria-label="Hi! I'm a developer">  Organizo  &nbsp;<span class="typewriter"></span></h1>
              <p class=" heroparagraph text-center">
                <strong>Get everyone working in a single platform</strong><br>
                designed to manage any type of work.
              </p>
              <div class="d-flex justify-content-center  "><a class="btn gets btn-lg lh-xl mb-4 mb-md-5 mb-lg-7"
                  href="login.php">Get Started</a></div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- end of hero content -->

  <!-- beg of countup list -->
  <div class="contanier1">
    <section class="  container border-bottom mb-8 mb-lg-10">
      <div class="row pb-6 pb-lg-8 g-3 g-lg-8 px-3">
        <div class="col-12 col-md-4">
          <h2 class=" count  fw-bold lh-sm mb-2 text-center" data-target="<?php echo $num_p?>"><?php echo $num_p?></h2>
          <h6 class=" listnum fs-8  lh-lg mb-0 opacity-70 text-center" > Projects</h6>
        </div> <br>
        <div class="col-12 col-md-4">
          <h2 class=" count2 fw-bold lh-sm mb-2 text-center" data-target="<?php echo $num_m?>"><</h2>
          <h6 class=" listnum opacity-70 fs-8  lh-lg mb-0 text-center">Members </h6>
        </div>
        <br>
        <div class="col-12 col-md-4">
          <h2 class=" count3  fw-bold lh-sm mb-2 text-center"data-target="<?php echo $num_t ?>" ><?php echo $num_t ?></h2>
          <h6 class=" listnum opacity-70 fs-8  lh-lg mb-0 text-center">Tasks </h6>
        </div>
      </div>
    </section>
  </div>
  <!-- end of countup list -->

  <!-- beg of 1st features -->
  <section class=" sec1 hiddensec  container mb-8 mb-lg-13" id="about">
    <div class="row align-items-center">
      <div class="col-12 col-lg-6 col-xl-7"><img class="img-fluid" src="img/Team.webp" alt="" /></div>
      <div class="col-12 col-lg-6 col-xl-5">
        <div class="row justify-content-center justify-content-lg-start">
          <div class="col-sm-10 col-md-8 col-lg-12">
            <h2 class="fs-4 fs-lg-3 fw-bold mb-2 text-lg-start">Collaborate with team members.</h2>
            <p class="fs-8 mb-4 mb-lg-5 lh-lg  text-lg-start fw-normal">We share common trends and strategies
              for improving your rental income</p>
          </div>
          <div class="col-sm-10 col-md-8 col-lg-12">
            <div class="mb-x1 mb-lg-3">
              <h5 class="fs-8 fw-bold lh-lg mb-1">Project Based Groups </h5>
              <p class="mb-0  lh-xl">You can use this module to monitor ongoing projects seamlessly.</p>
            </div>
            <div>
              <h5 class="fs-8 fw-bold lh-lg mb-1"> Unlimited Projects </h5>
              <p class="lh-xl mb-0">Conduct unlimited Project with us for better business operations.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end of 1st features -->

  <!-- beg of 2nd features -->
  <div class="container2">
    <section class=" container hiddensec mb-8 mb-lg-13">
      <div class="row align-items-center">
        <div class="col-12 col-lg-6 col-xl-5 order-lg-1"><img class=" imgfeat2 img-fluid widthimg"
            src="img/Screenshot 2024-08-04 031813.png" alt="" /></div>
        <div class="col-12 col-lg-6 col-xl-7">
          <div class="row justify-content-center justify-content-lg-start">
            <div class="col-sm-10 col-md-8 col-lg-11">
              <h2 class="fs-4 fs-lg-3 fw-bold mb-2 text-center text-lg-start"> Organize remote team fast & easily.</h2>
              <p class="fs-8 mb-4 mb-lg-5 lh-lg text-center text-lg-start fw-normal">Organizing and managing your remote
                teams has never been this easy!</p>
            </div>
            <div class="col-sm-10 col-md-8 col-lg-12">
              <div class="mb-x1 mb-lg-3">
                <h5 class="fs-8 fw-bold lh-lg mb-1">Create Unlimited Teams </h5>
                <p class="b-0 lh-xl">Create unlimited teams and boost productivity with efficient collaboration.</p>
              </div>
              <div>
                <h5 class="fs-8 fw-bold lh-lg mb-1"> Hasslefree Connect with Everyone</h5>
                <p class="lh-xl mb-0">With unique and simple UIs, keep yourself connected across all the teams.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- end of 2nd features -->

  <!-- how does it work -->
  <section class="container hiddensec mb-8 mb-lg-11">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-7">
        <h3 class="fs-1 fs-lg-3 fw-bold text-center mb-2 mb-lg-x1"> How does <span class="text-nowrap">it work?</span>
        </h3>
        <p class="fs-5 mb-7 mb-lg-8 text-center lh-lg">You can use this as it is or tweak it as you seem necessary. you
          seem necessary.</p>
      </div>
      <div class="col-12">
        <div class="row g-sm-2 g-lg-3 align-items-center timeline">
          <div class="col-12 col-lg-4 d-flex flex-row flex-lg-column justify-content-center gap-2 gap-sm-x1 gap-md-4 gap-lg-0  align-items-center">
            <div class="timeline-step-1 w-25 w-lg-100 mb-4 mb-lg-5 mb-xl-6   ">
              <div class="timeline-item d-flex justify-content-center  ">
                <div class="timeline-icon bg-primary rounded-circle d-flex justify-content-center align-items-center">
                  <span class="fs-3 fs-lg-5 fs-xl-4 text-white"> 1</span>
                </div>
              </div>
            </div>
            <div class="py-1 py-lg-0 px-lg-5 w-75 w-sm-50 w-lg-100 timeline-content">
              <h6 class="fs-3 fw-bold text-lg-center lh-lg mb-2 text-nowrap">Sign up in Organizo</h6>
              <p class="text-lg-center lh-xl mb-0">Sign up with a single click.</p>
            </div>
          </div>
          <div class="col-12 col-lg-4 d-flex flex-row flex-lg-column justify-content-center gap-2 gap-sm-x1 gap-md-4 gap-lg-0  align-items-center">
            <div class="timeline-step-2 w-25 w-lg-100 mb-4 mb-lg-5 mb-xl-6">
              <div class="timeline-item d-flex justify-content-center">
                <div class="timeline-icon bg-success rounded-circle d-flex justify-content-center align-items-center">
                  <span class="fs-3 fs-lg-5 fs-xl-4 text-white"> 2</span>
                </div>
              </div>
            </div>
            <div class="py-1 py-lg-0 px-lg-5 w-75 w-sm-50 w-lg-100 timeline-content">
              <h6 class="fs-3 fw-bold text-lg-center text-nowrap ">Add Team Members</h6>
              <p class="text-lg-center lh-xl mb-0">Adding team <span class="text-nowrap"> members to your projects.
                </span></p>
            </div>
          </div>
          <div class="col-12 col-lg-4 d-flex flex-row flex-lg-column justify-content-center gap-2 gap-sm-x1 gap-md-4 gap-lg-0  align-items-center">
            <div class="timeline-step-3 position-relative z-1 overflow-hidden w-25 w-lg-100 mb-4 mb-lg-5 mb-xl-6">
              <div class="timeline-item d-flex justify-content-center">
                <div class="timeline-icon bg-info rounded-circle d-flex justify-content-center align-items-center"><span
                    class="fs-3 fs-lg-5 fs-xl-4 text-white"> 3</span></div>
              </div>
            </div>
            <div class="py-1 py-lg-0 px-lg-5 w-75 w-sm-50 w-lg-100 timeline-content">
              <h6 class="fs-3 fw-bold text-lg-center lh-lg mb-2">Start Rolling</h6>
              <p class="text-lg-center lh-xl mb-0">Operating your <span class="text-nowrap"> business in a simpler
                  way!</span></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- END OF HOW IT WORK -->

  <!-- BEG OF WHY  -->
  </section>
  <section class="experience hiddensec position-relative overflow-hidden" id="service">
    <div class="container container3">
      <div class="row justify-content-center">
        <div class="col-12">
          <div class="position-relative z-1 text-center mb-8 mb-lg-9 video-player-paused"
            data-video-player-container="data-video-player-container">
            <div class="overlay  rounded-4 bg-1100 object-cover" data-overlay="data-overlay"> <img
                class="pause-icon w-100 h-100 " src="img/Screenshot 2024-08-04 060742.png" alt="" /> </div>
          </div>
        </div>
        <div class="col-md-8 col-lg-7">
          <h2 class="fs-3 fs-lg-3 fw-bold text-center text-white mb-5 mb-lg-9 lh-sm">We made Organizo to solve your
            problems.</h2>
        </div>
        <div class="col-12">
          <div class="row gy-4 g-md-3 pb-8 pb-lg-11 px-1">
            <div class="col-12 col-md-6 col-lg-4 d-flex align-items-start gap-2"><img  class="imgwhy" src="img/plan-list-svgrepo-com.svg"/>
              <div>
                <h5 class="fs-8 text-white lh-lg fw-bold">Unlimited Projects</h5>
                <p class="text-white text-opacity-50 lh-xl mb-0">Manage multiple projects at once and for seamless
                  business operation.</p>
              </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 d-flex align-items-start gap-2"><img class="imgwhy"  src="img/team-work-svgrepo-com.svg" alt="" />
              <div>
                <h5 class="fs-8 text-white lh-lg fw-bold">Team Management</h5>
                <p class="text-white text-opacity-50 lh-xl mb-0">Manage your cross-functional teams better than ever
                  with our easily manageable app.</p>
              </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 d-flex align-items-start gap-2"><img class="imgwhy" src="img/share-svgrepo-com (1).svg" alt="" />
              <div>
                <h5 class="fs-8 text-white lh-lg fw-bold">File Sharing</h5>
                <p class="text-white text-opacity-50 lh-xl mb-0">Easily share files where necessary and keep them safe
                  with enhanced security and protection.</p>
              </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 d-flex align-items-start gap-2"><img class="imgwhy" src="img/chart-column-grow-svgrepo-com.svg"
                alt="" />
              <div>
                <h5 class="fs-8 text-white lh-lg fw-bold">Increase Profit</h5>
                <p class="text-white text-opacity-50 lh-xl mb-0">increase your profit of your projects and your company</p>
              </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 d-flex align-items-start gap-2"><img class="imgwhy" src="img/calendar-svgrepo-com (1).svg"
                alt="" />
              <div>
                <h5 class="fs-8 text-white lh-lg fw-bold">Time Tracking</h5>
                <p class="text-white text-opacity-50 lh-xl mb-0">Track time to ensure meeting all the deadlines and
                  never lag behind managing multiple projects.</p>
              </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 d-flex align-items-start gap-2"><img class="imgwhy" src="img/payment-request-api-svgrepo-com.svg"
                alt="" />
              <div>
                <h5 class="fs-8 text-white lh-lg fw-bold">Payment System</h5>
                <p class="text-white text-opacity-50 lh-xl mb-0">With its easy payment system create invoices and get
                  paid all at the same place.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="position-absolute top-0 start-0 end-0">
      <div class="bg-white py-3 py-md-9 py-xl-10"> </div><img class="wave" src="img/Wave_2.svg" alt="" />
    </div>
  </section>
  <!-- end of why -->


  <!-- beg of feedback -->
  <!-- <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="sectioncarosel">
      <div class="carousel-item active">
        <div class="card shadow-sm rounded-3">
          <div class="card-body">
            <p class="card-text">"Some quick example text to build on the card title and make up the
              bulk of
              the card's content."</p>
            <div class="d-flex align-items-center pt-2">
              <img src="https://codingyaar.com/wp-content/uploads/square-headshot-1.png"
                alt="bootstrap testimonial carousel slider 2">
              <div>
                <h5 class="card-title fw-bold">Jane Doe</h5>
                <span class="text-secondary">CEO, Example Company</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
      <div class="sectioncarosel">
      <div class="carousel-item">
        <div class="card shadow-sm rounded-3">
          <div class="card-body">
            <p class="card-text">"Some quick example text to build on the card title and make up the
              bulk of
              the card's content."</p>
            <div class="d-flex align-items-center pt-2">
              <img src="https://codingyaar.com/wp-content/uploads/square-headshot-1.png"
                alt="bootstrap testimonial carousel slider 2">
              <div>
                <h5 class="card-title fw-bold">Jane Doe</h5>
                <span class="text-secondary">CEO, Example Company</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
      <div class="sectioncarosel">
      <div class="carousel-item">
        <div class="card shadow-sm rounded-3">
          <div class="card-body">
            <p class="card-text">"Some quick example text to build on the card title and make up the
              bulk of
              the card's content."</p>
            <div class="d-flex align-items-center pt-2">
              <img src="https://codingyaar.com/wp-content/uploads/square-headshot-1.png"
                alt="bootstrap testimonial carousel slider 2">
              <div>
                <h5 class="card-title fw-bold">Jane Doe</h5>
                <span class="text-secondary">CEO, Example Company</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  end of feedback
    -->

  <!-- beg of questions -->
  <section class="bg-1100">
    <div class="container">
      <div class="row py-8 py-md-10 py-lg-11">
        <div class="col-lg-6">
          <div class="row justify-content-center justify-content-lg-start">
            <div class=" wehere col-md-8 col-lg-12 col-xl-11">
              <h2 class="text-white fs-3 fs-lg-3 lh-sm mb-2  text-lg-start fw-bold">We are always here </h2>
              <p
                class="fs-8 text-white text-opacity-65 mb-4 mb-md-6 mb-lg-7 lh-lg mb-6 mb-lg-7  text-lg-start">
                We share common trends and strategies for creating </p>
            </div>
            <div class="col-lg-10">
              <div class="d-flex gap-2 gap-lg-x1 mb-4 mb-lg-5">
                <div>
                  <div
                    class="check-icon bg-success mb-1 rounded-circle d-flex align-items-center justify-content-center">
                    <span class="uil uil-check text-white"></span>
                  </div>
                </div>
                
                <div>
                  <h5 class="fs-4 fw-bold lh-lg mb-1  text-white">Noise Free website</h5>
                  <p class="lh-xl text-white text-opacity-70 mb-0">We ensure noise-free website to focus </p>
                </div>
              </div>
              <div class="d-flex gap-2 gap-lg-x1 mb-4 mb-lg-5">
                <div>
                  <div
                    class="check-icon bg-success mb-1 rounded-circle d-flex align-items-center justify-content-center">
                    <span class="uil uil-check text-white"></span>
                  </div>
                </div>
                <div>
                  <h5 class="fs-4 fw-bold lh-lg mb-1  text-white">24/7 Hour Support</h5>
                  <p class="lh-xl text-white text-opacity-70 mb-0">Get support from our efficient customer support team,
                    24/7, all year round.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="accordion mt-lg-4 ps-3 pe-x1 " id="accordion">
            <div class="accordion-item">
              <h2 class="accordion-header" id="heading1"><button class="accordion-button fs-4 lh-lg fw-bold pt-x1 pb-2"
                  type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expand="true"
                  aria-controls="collapse1" data-accordion-button="data-accordion-button">How do i create a new project?</button></h2>
              <div class="accordion-collapse collapse show" id="collapse1" data-bs-parent="#accordion">
                <div class="accordion-body lh-xl pt-0 pb-x1">Click the "Create Project"button, give it a name,and add your team members</div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="heading2"><button
                  class="accordion-button fs-4 lh-lg fw-bold pt-x1 pb-2 collapsed" type="button"
                  data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expand="false" aria-controls="collapse2"
                  data-accordion-button="data-accordion-button">How can i assign tasks to team members?</button></h2>
              <div class="accordion-collapse collapse" id="collapse2" data-bs-parent="#accordion">
                <div class="accordion-body lh-xl pt-0 pb-x1">Create a task , select the "Add member"option and choose the person responsible
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="heading3"><button
                  class="accordion-button fs-4 lh-lg fw-bold pt-x1 pb-2 collapsed" type="button"
                  data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expand="false" aria-controls="collapse3"
                  data-accordion-button="data-accordion-button">How do i track progress and see whats been completed?</button></h2>
              <div class="accordion-collapse collapse" id="collapse3" data-bs-parent="#accordion">
                <div class="accordion-body lh-xl pt-0 pb-x1">in the project page show the progress of each task , with completed tasks marked as finished</div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="heading4"><button
                  class="accordion-button fs-4 lh-lg fw-bold pt-x1 pb-2 collapsed" type="button"
                  data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expand="false" aria-controls="collapse4"
                  data-accordion-button="data-accordion-button">Can i communicate with my team withinthe project ?</button></h2>
              <div class="accordion-collapse collapse" id="collapse4" data-bs-parent="#accordion">
                <div class="accordion-body lh-xl pt-0 pb-x1">yes, you can leave comments on tasks </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="heading5"><button
                  class="accordion-button fs-4 lh-lg fw-bold pt-x1 pb-2 collapsed" type="button"
                  data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expand="false" aria-controls="collapse5"
                  data-accordion-button="data-accordion-button">How can I get your support?</button></h2>
              <div class="accordion-collapse collapse" id="collapse5" data-bs-parent="#accordion">
                <div class="accordion-body lh-xl pt-0 pb-x1">To reach our support team, simply send an email to
                  organizohelp@gmail.com Our team will promptly address your inquiry and provide assistance as needed.
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>








  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js"
    integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="js/countup.js"></script>
  <!-- <script src="js/swiper.js"></script> -->
  <script src="js/scoller.js"></script>
  
</body>

</html>