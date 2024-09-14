<?php
// include("connection.php");
include("nav.php");
$error="";

if(!isset($_SESSION['user_id']))
    header("Location: index.php");

if(isset($_GET['plan']))
    $new_planid=$_GET['plan'];

if(isset($_POST['pay'])){
    // $card_number = $_POST['card_number'];
    // if (strlen($card_number) != 16)
    //     $error = "Invalid Card Number";
    // else if (empty($_POST['C-HOLDER']))
    //     $error = "Cardholder can't be left empty";
    // else if (empty($_POST['MM']) || $_POST['MM'] > 12 || $_POST['MM'] < 1)
    //     $error = "You must select a valid month";
    // else if (empty($_POST['YY']) || $_POST['YY'] > 2035 || $_POST['YY'] < 2024)
    //     $error = "You must select a valid year";
    // else if (empty($_POST['cvv']) || strlen($_POST['cvv']) < 3 || strlen($_POST['cvv']) > 3)
    //     $error = "Insert a valid CVV";
    // else
    // {
        $user_id = $_SESSION['user_id'];
        $edit = " UPDATE `user`
            SET `plan_id` = '$new_planid'
            WHERE `user_id` = '$user_id' ";
        $run_edit = mysqli_query($connect, $edit);
        $update = " UPDATE `user`
                JOIN `role` ON `user`.`role_id` = `role`.`role_id`
                SET `user`.`role_id` = 1
                WHERE `user`.`user_id` = '$user_id'";
        $run_update = mysqli_query($connect, $update);
        $start = date('Y-m-d');
        $end = date('Y-m-d', strtotime('+1 month'));
        $insert = "INSERT INTO `subscription` VALUES ('$new_planid', '$user_id', 'active', '$start', '$end')";
        $run_insert = mysqli_query($connect, $insert);
        header("Location:subscription.php");
    // }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- css file link  -->
    <link rel="stylesheet" href="css/payment.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <script src="js/payment.js"></script>   

    <style>
      .warning
      {
          display: none; color: red;
          position: static;
          width: 65%;
          margin: -13% auto -1%;
          font-size: 1vw;
      }
      .warning.visible {display: block}
      #s-btn {margin-top: 20px}

      .error {
          font-size: 15px;
          margin: 2px;
          text-align: center;
          color: red;
          width: 100%;
      }

    </style>
</head>

<body>
<!-- start of visa card -->
    <div class="container">
        <div class="card-container">
           <div class="pic">
            <div class="front">
                <div class="image">
                    <img src="img/chip-card2 (1).png" alt="">
                    <img src="img/visa.png" alt="">
                </div>
                <div class="card-number-box" name="card_number"><?php echo isset($_POST['card_number']) ? $_POST['card_number'] : '################'?></div>
                <div class="flexbox">
                    <div class="box">
                        <span>Card Holder</span>
                        <div class="card-holder-name"><?php echo isset($_POST['C-HOLDER']) ? $_POST['C-HOLDER'] : 'Full Name'?></div>
                    </div>

                    <div class="box">
                        <span>expires</span>
                        <div class="expiration">
                            <span class="exp-month"><?php echo isset($_POST['MM']) ? $_POST['MM'] : 'mm'?></span>
                            <span class="exp-year"><?php echo isset($_POST['YY']) ? $_POST['YY'] : 'yy'?></span>
                        </div>
                    </div>
                </div>
            </div>
           </div>

           <div class="back">
                <div class="stripe"></div>
                <div class="box">
                    <span>cvv</span>
                    <div class="cvv-box"><?php echo isset($_POST['cvv']) ? $_POST['cvv'] : ''?></div>
                    <img src="image/visa.png" alt="">
                </div>
            </div>
        </div>

<!-- <end part of visa card> -->
        
 <!-- start work space of inputs -->

        <form method="POST" onsubmit="return validateForm()">
            <div class="inputBox">
                <?php if(isset($error)) echo "<p style='color: red'>$error</p>" ?>
                <span class="span">card number</span>
                <input type="number" maxlength="16" name="card_number" id="card-number-input" class="card-number-input" oninput="validateNum()" value="<?php echo isset($_POST['card_number']) ? $_POST['card_number'] : '';?>">
                <span name="numError" id="numError" class="error" style="display:none;"></span>
            </div>
            <div class="inputBox">
                <span class="span">card holder</span>
                <input type="text" class="card-holder-input" name="C-HOLDER" id="card-holder-input" oninput="validateName()" value="<?php echo isset($_POST['C-HOLDER']) ? $_POST['C-HOLDER'] : ''; ?>">
                <span name="nameError" id="nameError" class="error" style="display:none;"></span>
            </div>
            <div class="flexbox">
                <div class="inputBox">
                    <span class="span">expiration mm</span>
                    <select name="MM" id="month-input" oninput="validateMonth()" class="month-input" required>
                        <option value="month" id="MONTH">Month</option>
                        <?php
                        for ($i = 1; $i <= 12; $i++)
                        {
                            $selected = (isset($_POST['MM']) && $_POST['MM'] == $i) ? 'selected' : '';
                            if ($i < 10)
                                echo "<option value='$i' $selected>0$i</option>";
                            else
                                echo "<option value='$i' $selected>$i</option>";
                        }
                        ?>
                    </select>
                    <span name="monthError" id="monthError" class="error" style="display:none;"></span>
                </div>
                <div class="inputBox">
                    <span class="span">expiration yy</span>
                    <select name="YY" id="year-input" oninput="validateYear()" class="year-input" required>
                        <option value="year" id="YEAR">Year</option>
                        <?php
                        for ($i = 2024; $i <= 2035; $i++)
                        {
                            $selected = (isset($_POST['YY']) && $_POST['YY'] == $i) ? 'selected' : '';
                            echo "<option value='$i' $selected>$i</option>";
                        }
                        ?>
                    </select>
                    <span name="yearError" id="yearError" class="error" style="display:none;"></span>
                </div>
                <div class="inputBox">
                    <span>cvv</span>
                    <input type="text" maxlength="3" class="cvv-input" name="cvv" id="cvv-input" oninput="validateCvv()" value="<?php echo isset($_POST['cvv']) ? $_POST['cvv'] : ''; ?>">
                    <span name="cvvError" id="cvvError" class="error" style="display:none;"></span>
                </div>
                </div>
                <div class="btns">
                    <div class="buttons">
                      <button class="cssbuttons-io-button addto" type="submit" name="pay">
                        <a href="#">Pay</a>
                        <div class="icon">
                          <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"
                              fill="currentColor"></path>
                          </svg>
                        </div>
                      </button>
                    </div>
                  </div>
    </form>

</div> 
<!-- end work space of input -->

<script>
// Card Number Display and Validation
document.getElementById('card-number-input').oninput = () => {
    document.querySelector('.card-number-box').innerText = document.getElementById('card-number-input').value;
    validateNum();
};

// Card Holder Name Display and Validation
document.getElementById('card-holder-input').oninput = () => {
    document.querySelector('.card-holder-name').innerText = document.getElementById('card-holder-input').value;
    validateName();
};

// Expiration Month Display and Validation
document.getElementById('month-input').oninput = () => {
    document.querySelector('.exp-month').innerText = document.getElementById('month-input').value;
    validateMonth();
};

// Expiration Year Display and Validation
document.getElementById('year-input').oninput = () => {
    document.querySelector('.exp-year').innerText = document.getElementById('year-input').value;
    validateYear();
};

// CVV Display and Validation
document.getElementById('cvv-input').oninput = () => {
    document.querySelector('.cvv-box').innerText = document.getElementById('cvv-input').value;
    validateCvv();
};

// Rotate card on CVV focus
document.getElementById('cvv-input').onmouseenter = () => {
    document.querySelector('.front').style.transform = 'perspective(1000px) rotateY(-180deg)';
    document.querySelector('.back').style.transform = 'perspective(1000px) rotateY(0deg)';
};

// Rotate card back on CVV blur
document.getElementById('cvv-input').onmouseleave = () => {
    document.querySelector('.front').style.transform = 'perspective(1000px) rotateY(0deg)';
    document.querySelector('.back').style.transform = 'perspective(1000px) rotateY(180deg)';
};

// Prevent form submission if validation fails
document.querySelector('form').onsubmit = function (e) {
    if (!validateForm()) {
        e.preventDefault();
    }
};
</script>
</body>
</html>