<?php 

# database connection file
include 'connection.php';

  if (isset($_SESSION['user_id'])) {

  	include 'app/helpers/user.php';
  	include 'app/helpers/chat.php';
  	include 'app/helpers/opened.php';
  	include 'app/helpers/timeAgo.php';

  	if (!isset($_GET['user'])) {
  		header("Location: home.php");
  		exit;
  	}

  	# Getting User data data
  	$chatWith = getUser($_GET['user'], $connect);

  	if (empty($chatWith)) {
  		header("Location: home.php");
  		exit;
  	}

  	$chats = getChats($_SESSION['user_id'], $chatWith['user_id'], $connect);

  	opened($chatWith['user_id'], $connect, $chats);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Chat App</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
	<link rel="stylesheet" 
	      href="./css/chat.css">
	<link rel="icon" href="img/keklogo.png">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</head>
<body class="d-flex
             justify-content-center
             align-items-center
             vh-100">
    <div class="w-400 shadow p-4 rounded " id="bigdiv">
    	<a href="home.php"
    	   class="fs-4 link-dark">&#8592;</a>

    	   <div class="d-flex align-items-center" id="frstdiv">
    	   	  <img src="./img/profile/<?=$chatWith['image']?>"
    	   	       class="w-15 rounded-circle">

               <h3 class="display-4 fs-sm m-2">
               	  <?=$chatWith['first_name']?> <br>
               	  <div class="d-flex
               	              align-items-center"
               	        title="online">
               	    <?php
                        if (last_seen($chatWith['last_seen']) == "Active") {
               	    ?>
               	        <div class="online"></div>
               	        <small class="d-block p-1">Online</small>
               	  	<?php }else{ ?>
               	         <small class="d-block p-1">
               	         	Last seen:
               	         	<?=last_seen($chatWith['last_seen'])?>
               	         </small>
               	  	<?php } ?>
               	  </div>
               </h3>
    	   </div>

    	   <div class="shadow p-4 rounded
    	               d-flex flex-column
    	               mt-2 chat-box"
    	        id="chatBox">
    	        <?php 
                     if (!empty($chats)) {
                     foreach($chats as $chat){
                     	if($chat['from_user'] == $_SESSION['user_id'])
                     	{ ?>
						<?php if(!empty($chat['file'])){?>
						<div style="display: flex; justify-content: end;">
							<p class="rtext align-self-end border rounded p-2 mb-1">
								<?=$chat['message']?> 
								<a href="./img/chat file/<?= htmlspecialchars($chat['file']) ?>" target="_blank"><?= htmlspecialchars($chat['file']) ?></a>
								<small class="d-block">
									<?=$chat['created_at']?>
								</small>
								<div class="dropdown">
									<ul>
										<li><a class="dropdown-item edit-message" data-id="<?=$chat['chat_id']?>" href="javascript:void()">Edit</a></li>
										<li><a class="dropdown-item delete-message" data-id="<?=$chat['chat_id']?>" href="javascript:void()">Delete</a></li>
									</ul>
								</div>
							</p>
						</div>
						<?php }else{?>
							<div style="display: flex; justify-content: end;">
							<p class="rtext align-self-end border rounded p-2 mb-1">
								<?=$chat['message']?> 
								<small class="d-block">
									<?=$chat['created_at']?>
								</small>
								<div class="dropdown">
									<ul>
										<li><a class="dropdown-item edit-message" data-id="<?=$chat['chat_id']?>" href="javascript:void()">Edit</a></li>
										<li><a class="dropdown-item delete-message" data-id="<?=$chat['chat_id']?>" href="javascript:void()">Delete</a></li>
									</ul>
								</div>
							</p>
						</div>
						<?php } ?>
                    <?php }else{ ?>
					<p class="ltext border 
					         rounded p-2 mb-1">
					    <?=$chat['message']?> 
					    <small class="d-block">
					    	<?=$chat['created_at']?>
					    </small>
					</p>
                    <?php } 
                     }	
    	        }else{ ?>
               <div class="alert alert-info 
    				            text-center">
				   <i class="fa fa-comments d-block fs-big"></i>
	               No messages yet, Start the conversation
			   </div>
    	   	<?php } ?>
    	   </div>
    	   <!-- <div class="input-group mb-3"> -->
			<form class="input-group mb-3" id="chatForm" enctype="multipart/form-data">
    	   	   <textarea style="border: 1px solid white;" cols="3"
    	   	             id="message"
    	   	             class="form-control" placeholder="Write your message.."></textarea>
						 <input type="file" id="file" name="file" for="icon" class="file">
						 <label for="file">
				<div style="background-color: white;height: 100%;">
					<span>
						<svg style="width: 70%;
						height: 75%;
						margin: 16%;"
						xml:space="preserve"
						viewBox="0 0 184.69 184.69"
						xmlns:xlink="http://www.w3.org/1999/xlink"
						xmlns="http://www.w3.org/2000/svg"
						id="Capa_1"
						version="1.1"
						width="60px"
						height="60px">
						<g>
							<g>
							<g>
								<path
								d="M149.968,50.186c-8.017-14.308-23.796-22.515-40.717-19.813
									C102.609,16.43,88.713,7.576,73.087,7.576c-22.117,0-40.112,17.994-40.112,40.115c0,0.913,0.036,1.854,0.118,2.834
									C14.004,54.875,0,72.11,0,91.959c0,23.456,19.082,42.535,42.538,42.535h33.623v-7.025H42.538
									c-19.583,0-35.509-15.929-35.509-35.509c0-17.526,13.084-32.621,30.442-35.105c0.931-0.132,1.768-0.633,2.326-1.392
									c0.555-0.755,0.795-1.704,0.644-2.63c-0.297-1.904-0.447-3.582-0.447-5.139c0-18.249,14.852-33.094,33.094-33.094
									c13.703,0,25.789,8.26,30.803,21.04c0.63,1.621,2.351,2.534,4.058,2.14c15.425-3.568,29.919,3.883,36.604,17.168
									c0.508,1.027,1.503,1.736,2.641,1.897c17.368,2.473,30.481,17.569,30.481,35.112c0,19.58-15.937,35.509-35.52,35.509H97.391
									v7.025h44.761c23.459,0,42.538-19.079,42.538-42.535C184.69,71.545,169.884,53.901,149.968,50.186z"
								style="fill:black;"
								></path>
							</g>
							<g>
								<path
								d="M108.586,90.201c1.406-1.403,1.406-3.672,0-5.075L88.541,65.078
									c-0.701-0.698-1.614-1.045-2.534-1.045l-0.064,0.011c-0.018,0-0.036-0.011-0.054-0.011c-0.931,0-1.85,0.361-2.534,1.045
									L63.31,85.127c-1.403,1.403-1.403,3.672,0,5.075c1.403,1.406,3.672,1.406,5.075,0L82.296,76.29v97.227
									c0,1.99,1.603,3.597,3.593,3.597c1.979,0,3.59-1.607,3.59-3.597V76.165l14.033,14.036
									C104.91,91.608,107.183,91.608,108.586,90.201z"
								style="fill:black;">
								</path>
							</g>
							</g>
						</g></svg>
						</span>
					</div>
					<!-- <i class="fa-solid fa-paperclip" id="icon"></i> -->
				</label>
    	        <button class="btn btn-primary"
    	   	           id="sendBtn">
    	   	   	  <i class="fa fa-paper-plane"></i>
    	   	    </button>
				

			</form>
    	   <!-- </div> -->

    </div>
 

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
	var scrollDown = function(){
        let chatBox = document.getElementById('chatBox');
        chatBox.scrollTop = chatBox.scrollHeight;
	}

	scrollDown();

	$(document).ready(function(){
      
		$("#sendBtn").on('click', function() {
			var message = $("#message").val();
			var fileInput = document.getElementById('file');
			var file = fileInput.files[0]; 

			var formData = new FormData();
			formData.append('message', message);
			formData.append('to_user', <?=$chatWith['user_id']?>);
			if (file) {
				formData.append('file', file);
			}

			$.ajax({
				url: 'app/ajax/insert.php',
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false, 
				success: function(data, status) {
					if (status === 'success') {
						$("#message").val("");
						$("#file").val("");
						$("#chatBox").append(data);
						scrollDown();
						location.reload();
					} else {
						alert("Message could not be sent.");
					}
				}
			});
		});


      /** 
      auto update last seen 
      for logged in user
      **/
      let lastSeenUpdate = function(){
      	$.get("app/ajax/update_last_seen.php");
      }
      lastSeenUpdate();
      /** 
      auto update last seen 
      every 10 sec
      **/
      setInterval(lastSeenUpdate, 10000);



      // auto refresh / reload
      let fechData = function(){
      	$.post("app/ajax/getMessage.php", 
      		   {
      		   	id_2: <?=$chatWith['user_id']?>
      		   },
      		   function(data, status){
                  $("#chatBox").append(data);
                  if (data != "") scrollDown();
      		    });
      }

      fechData();
      /** 
      auto update last seen 
      every 0.5 sec
      **/
      setInterval(fechData, 500);

	      // Edit message
			$(document).on('click', '.edit-message', function(e) {
			e.preventDefault();
			var messageId = $(this).data('id');
			var messageText = $(this).closest('.rtext').find('small').text();

			// Prompt for new message
			var newMessage = prompt("Edit your message:", messageText);
			if (newMessage != null && newMessage.trim() != "") {
				$.post("app/ajax/editMessage.php", {
					chat_id: messageId, 
					new_message: newMessage
				}, function(data, status) {
					if (data === 'success') {
						alert('Could not update the message.');
					} else {
                    	location.reload();
                	}
				});
			}
		});

	  // Handle message deletion
	  $(document).on('click', '.delete-message', function(e) {
        e.preventDefault();

        var chatId = $(this).data('id');

        // Confirm deletion
        if (confirm('Are you sure you want to delete this message?')) {
            $.post("app/ajax/deleteMessage.php", {
                chat_id: chatId
            }, function(response) {
                if (response === 'success') {
                    // Remove the message element from the DOM
                    location.reload();
                } else {
                    alert("Error: Unable to delete message.");
                }
            });
        }
    });
    
    });
</script>
 </body>
 </html>
<?php
  }else{
  	header("location:index.php");
   	exit;
  }
 ?>
