<?php 
include("connection.php");

if(isset($_SESSION['admin_id']))
{
    $admin_id=$_SESSION['admin_id'];
}else
    header("location: login_admin.php");

    if(isset($_SESSION['isSuper']))
    {
        $isSuper=$_SESSION['isSuper'];
        $isSuper=1;
    }else
        header("location: login_admin.php");

$select="SELECT * FROM `admin`";
$run_select=mysqli_query($connect,$select);

if(isset($_GET['delete'])){
    $admin_id=$_GET['admin_id'];

    $delete="DELETE FROM `admin` WHERE `admin`.`admin_id`=$admin_id";
    if($run_delete=mysqli_query($connect,$delete)){
        echo "Admin has been removed.";
        header("location:display_admins.php");
        exit();
    }else{
        echo "Error: ".mysqli_error($connect);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Admins</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
    integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
       <!-- fontaswomn link -->
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- bootstrab link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="/logo.png" rel="icon">
    <link rel="stylesheet" href="css/displayadmins.css" />
    <link href="./img/logo.png" rel="icon">
</head>
<style>
        /* Popup styling */
        .popup {
            display: none; /* Hide popups by default */
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background: white;
            border: 1px solid #ccc;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            z-index: 1000;
            transform: translate(-50%,-50%);
            text-align: center;
            border-radius: 7px;
             color:#58151c;
        }
        .popup.show {
            display: block; /* Show popup when class 'show' is added */
        }
        .overlay {
            display: none; /* Hide overlay by default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }
        .overlay.show {
            display: block; /* Show overlay when class 'show' is added */
        }
        .lol{
    color:#58151c;

}

    </style>
<body>
    <table id="example" class="table table-striped" style="width:90%; margin:auto;">
        <thead>
            <tr>
                <th>Admin Name</th>
                <th>Admin Email</th>
                <th>Remove Admin</th>
            </tr>
        </thead>
        <?php if($isSuper == 1){ ?>
            <?php foreach($run_select as $data){ ?>
        <tbody>
            <tr>
            <td><?php echo htmlspecialchars($data['name']) ?></td>
            <td><?php echo htmlspecialchars($data['email']) ?></td>
            <td>
                <?php if(($isSuper == 1) AND $data ['isSuper']!=1 ){ ?>
                    <button type="button" class="btn btn-outline-danger" onclick="openPopup(<?php echo $data['admin_id']; ?>)">
                    <i class="fa-solid fa-trash"></i> 
                </button>
                <form method="GET" id="deleteForm-<?php echo $data['admin_id']; ?>" style="display:none;">
                    <input type="hidden" name="delete" value="<?php echo $data['admin_id']; ?>">
                    <input type="hidden" name="admin_id" value="<?php echo $data['admin_id']; ?>">

                </form>
                <div class="popup alert alert-danger"  id="popup-<?php echo $data['admin_id']; ?>">
                    <h2><i class="fa-solid fa-triangle-exclamation"></i> Are you sure you want to delete this admin?</h2>
                    <button type="button" class="lol btn btn-outline-dark" onclick="confirmDelete(<?php echo $data['admin_id']; ?>)">Yes</button>
                    <button type="button" class="lol btn btn-outline-dark" onclick="closePopup()">No</button>
                </div>
                <div class="overlay" id="overlay-<?php echo $data['admin_id']; ?>"></div>
            </td>
            </tr>
            <?php } } ?>
        <?php } ?>
        </tbody>
    </table>
    <div class="btns">
<!-- <button class="logbtn" id="lgbtn">logout</button> -->

    <a href="add_admin.php">
            <button type="button" class="btn btn-danger" id="addbtn">Add Admin</button>
        </a>
        </div>
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    let deleteAdminId;

    function openPopup(adminId) {
        deleteAdminId = adminId;
        document.getElementById('popup-' + adminId).classList.add('show');
        document.getElementById('overlay-' + adminId).classList.add('show');
    }

    function closePopup() {
        if (deleteAdminId) {
            document.getElementById('popup-' + deleteAdminId).classList.remove('show');
            document.getElementById('overlay-' + deleteAdminId).classList.remove('show');
        }
    }

    function confirmDelete() {
        if (deleteAdminId) {
            document.getElementById('deleteForm-' + deleteAdminId).submit();
        }
    }
</script>

</body>
</html>