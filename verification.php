<?php
session_start();

@include 'config.php';
if(isset($_POST["verify"])){
    $otp = $_SESSION['otp'];
    $email = $_SESSION['mail'];
    $otp_code = $_POST['otp_code'];
    $insert = $_SESSION['insert'];

    if($otp != $otp_code){
        ?>
       <script>
           alert("Invalid OTP code");
       </script>
       <?php
    }else{
         mysqli_query($conn, $insert);
        ?>
         <script>
             alert("Verfiy account done");
             window.location.replace('login_form.php');
         </script>
         <?php
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login form</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<div class="form-container">

   <form action="" method="post">
      <h3 class="login-now">Verification</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="text" name="otp_code" id="otp" required placeholder="OTP code">
      <input type="submit" name="verify" value="Verify" class="form-btn">
   </form>
</div>
</body>
</html>