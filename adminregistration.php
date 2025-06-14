<?php

include 'config.php';

if(isset($_POST['submit'])){
   $type=$_POST['type'];
   $type = filter_var($type, FILTER_SANITIZE_STRING);
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $ph = $_POST['ph'];
   $ph = filter_var($ph, FILTER_SANITIZE_STRING);
   $pass = md5($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select->execute([$email]);

   if($select->rowCount() > 0){
      $message[] = 'admin email already exist!';
   }else{
      $insert = $conn->prepare("INSERT INTO `users`(name, email, password,user_type, image,ph_no) VALUES(?,?,?,?,?,?)");
      $insert->execute([$name, $email, $pass,$type, $image,$ph]);

      if($insert){
         if($image_size > 2000000){
            $message[] = 'image size is too large!';
         }else{
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'registered successfully!';
            header('location:admin_users.php');
         }
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/components.css">

</head>
<body style="background-image:linear-gradient(to bottom right,orange,white);">

<?php

if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}

?>
   
<section class="form-container">

   <form action="" enctype="multipart/form-data" method="POST">
      <h3>Add new admin</h3>
      <input type="hidden" name="type" value="admin">
      <input type="text" name="name" class="box" placeholder="enter your name" required>
      <input type="email" name="email" class="box" placeholder="enter your email" required>
      <input type="number" name="ph" class="box" placeholder="enter your phone No" required>
      <input type="hidden" name="pass" class="box" value="admin">
      <input type="file" name="image" class="box" required accept="image/jpg, image/jpeg, image/png">
      <input type="text" class="box" value="Password : admin" readonly>
      <input type="submit" value="Add now" class="btn" name="submit">
   </form>

</section>


</body>
</html>