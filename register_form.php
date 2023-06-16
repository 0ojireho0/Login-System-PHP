<?php
session_start();
@include 'config.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);


   $_SESSION['name'] = $name;




   $select = " SELECT * FROM user_form WHERE email = '$email' && password = '$pass' ";
   $result = mysqli_query($conn, $select);




   if(mysqli_num_rows($result) > 0){

      $row = mysqli_fetch_array($result);
      $error[] = 'user already exist!';

   }else{

      if($pass != $cpass){
         $error[] = 'password not matched!';
      }elseif(strlen($_POST['password'])<6){
         $error[] = 'password must be 6 characters or more';
      }elseif(strlen($_POST['password'])>16){
         $error[] = 'password must be 15 characters or less';
      }else{
            $insert = "INSERT INTO user_form(name, email, password) VALUES('$name','$email','$pass')";
            $_SESSION['insert'] =$insert;
            $otp = rand(100000,999999);
            $_SESSION['otp'] = $otp;
            $_SESSION['mail'] = $email;
            require "Mail/phpmailer/PHPMailerAutoload.php";
            $mail = new PHPMailer;
    
            $mail->isSMTP();
            $mail->Host='smtp.gmail.com';
            $mail->Port=587;
            $mail->SMTPAuth=true;
            $mail->SMTPSecure='tls';
    
            $mail->Username='jeremiahquintano18@gmail.com';
            $mail->Password='nocfzwbvsppizhig';
    
            $mail->setFrom('jeremiahquintano18@gmail.com', 'Jeremiah Quintano');
            $mail->addAddress($_POST["email"]);

            $mail->isHTML(true);
            $mail->Subject="Your verify code";
            $mail->Body="<h3>Your verify OTP code is $otp <br></h3>
            <br><br>
            <p>By</p>
            <b>Jeremiah M. Quintano</b>";


            if($mail -> send()){
               ?>
                  <script>
                    alert("<?php echo "OTP sent to " . $email ?>");
                     window.location.replace('verification.php');
                     
                  </script>
               <?php
            }else{
               ?>
                  <script>
                     alert("<?php echo "Invalid Email "?>");
                  </script>
               <?php
            }

         
      }
   }
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register form</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
<div class="form-container">

   <form action="" method="post">
      <h3 class="login-now">register now</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="text" name="name" class="input-field" required placeholder="Name">
      <input type="email" name="email" class="input-field" required placeholder="Email">
      <input type="password" name="password" class="input-field" required placeholder="Password">
      <input type="password" name="cpassword" class="input-field" required placeholder="confirm your password">
      <input type="submit" name="submit" value="register now" class="form-btn">
      <p>already have an account? <a href="login_form.php">login now</a></p>
   </form>
</div>

</body>
</html>