<?php
include("connection.php");
if(isset($_SESSION['user_id']))
{

  $user_id=$_SESSION['user_id'];
  $select_pro = "SELECT * FROM `user`
                LEFT JOIN `project` ON `project`.`user_id` = `user`.`user_id`
				WHERE `user`.`user_id` = $user_id";
  $run_sel_pro=mysqli_query($connect,$select_pro);
  $countProj = mysqli_num_rows($run_sel_pro);

  $select_pro .= " LIMIT 5";
  $run_sel_pro=mysqli_query($connect,$select_pro);

  if ($run_sel_pro)
  {
    $fetch_projects = mysqli_fetch_all($run_sel_pro, MYSQLI_ASSOC);
    $fetch = $fetch_projects[0];
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
	<!-- My CSS -->
	 
    <link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/nav.css">

    
    <title>Organizo</title>
    <link rel="icon" type="image/x-icon" href="./img/keklogo.png">
</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bxl-slack'></i>
			<span class="text">Organizo</span>
		</a>
		<ul class="side-menu top">
			<li>
				<a href="userprof.php">
					<i class='bx bxs-user-detail'></i>
					<span class="text">Profile</span>
				</a>
			</li>
			<li>
				<a href="subscription.php">
					<!-- <i class='bx bxs-user-detail'></i> -->
					<!-- <i class="fa-solid fa-crown"></i> -->
					<i class='bx bx-crown'></i>
					<span class="text">Premium plans</span>
				</a>
			</li>
			<li>
				<a href="calendar.php">
				<i class='bx bxs-calendar' ></i>
					<span class="text">Calendar</span>
				</a>
			</li>
			<li>
				<a href="my_tasks.php">
					<i class='bx bxs-contact'></i>
					<span class="text">Personal board</span>
				</a>
			</li>
		

			
			<!-- <li>
				<a href="#">
					<i class='bx bxs-collection'></i>
					<span class="text">General board</span>
				</a>
			</li> -->
			<li>
				<a href="archive_taskss.php">
					<i class='bx bx-archive-in' ></i>
					<span class="text">Archived Tasks</span>

				</a>
			</li>


			<li style="display:flex;    position: relative;">
				<a href="projects.php">
					<i class='bx bxs-add-to-queue'></i>
					<span class="text">My Project<?php if($countProj > 1) echo "s" ?>
					</span>
				</a>

				<a class="" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" style=" width:23%;" <?php if(empty($fetch['project_id'])) echo 'hidden' ?>>
				    <i class='bx bx-chevron-down'></i>
                </a>
              </p>
<div class="collapse" id="collapseExample">
  <div class="card card-body" style="border:none;  width: 93%;
    position: absolute;
    left: 0px;
    top: 105%; background-color:transparent;" >
	<!-- put the loop here  -->
	<ul>
	<?php if(!empty($fetch_projects)){
			foreach ($fetch_projects as $project) {
			    if(empty($project['project_id'])) break; ?>
				<li style="background-color:transparent;">
					<a href="ViewSprints.php?pid=<?php echo $project['project_id']?>" style="color:black;"> <!-- originally: projects.php?projectid -->
						<i class='bx bx-box'></i>
						<span class="text"><?php echo $project['project_name'].'<br>'?></span>
					</a>
				</li>
	<?php }} ?>
        <?php if($countProj > 5) { ?>
        <li style="background-color:transparent;">
            <a href="projects.php?>" style="color:black;"> <!-- originally: projects.php?projectid -->
                <i class='bx bx-box'></i>
                <span class="text">Show All Projects</span>
            </a>
        </li>
        <?php } ?>
	</ul>
  </div>
</div>
				</a>
					<!--  -->
			</li>




	


            <!-- <li>
				<a href="#">
					<i class='bx bxs-message-square-edit'></i>
					<span class="text">Change password</span>
				</a>
			</li> -->



			<!-- <li>
				<a href="#">
					<i class='bx bxs-message-square-edit'></i>								
					<span class="text">Edit Profile</span>
				</a>
			</li> -->





			<!-- <li>
				<a href="#">
					<i class='bx bxs-hide'></i>
					<span class="text">Unhide Tasks</span>
				</a>
			</li> -->


		</ul>
		<ul class="side-menu">
		
			
		</ul>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu' ></i>
			<a href="index.php" class="nav-link">Home</a>


            <a href="#" class="nav-link"></a>
            
            
            <a href="#" class="nav-link"></a>



            <a href="#" class="nav-link"></a>






            <?php
            $currpage = basename($_SERVER['PHP_SELF']);
            $SRCHPages = array('projects.php', 'ViewSprints.php', 'tasks.php', 'archive_taskss.php');
            if(in_array($currpage, $SRCHPages)) { ?>
			<form method="POST">
				<div class="form-input">
					<input type="search" placeholder="Search..." name="text">
					<button type="submit" class="search-btn" name="search"><i class='bx bx-search' ></i></button>
				</div>
			</form>
            <?php } else { ?>
            <form method="POST" style="visibility: hidden">
                <div class="form-input">
                    <input type="search" placeholder="Search..." name="text">
                    <button type="submit" class="search-btn" name="search"><i class='bx bx-search' ></i></button>
                </div>
            </form>
            <?php } ?>


			<input type="checkbox" id="switch-mode" hidden>
			
			<!-- <a href="#" class="notification">
			
			</a> -->
			<a href="userprof.php" class="profile">
			
				<img src="./img/profile/<?php echo $fetch['image'] ?>">
			</a>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
<!-- <part of contant>	 -->

<main>



</main>


	    <!-- bootstrap js link -->
		<script src="js/bootstrap.min.js"></script>

	<script src="./js/script.js"></script>
</body>
</html>