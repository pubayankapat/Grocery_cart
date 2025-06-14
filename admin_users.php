<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:adminlogin.php');
};

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $select_img= $conn->prepare("SELECT `image` FROM `users` WHERE id = ?");
   $select_img->execute([$delete_id]);
   $fetch_img = $select_img->fetch(PDO::FETCH_ASSOC);
   $image=$fetch_img['image'];
   unlink('uploaded_img/'.$image);
   $delete_users = $conn->prepare("DELETE FROM `users` WHERE id = ?");
   $delete_users->execute([$delete_id]);
   $delete_review= $conn->prepare("DELETE FROM `reviews` WHERE id = ?");
   $delete_review->execute([$delete_id]);
   $delete_prod_review= $conn->prepare("DELETE FROM `product_reviews` WHERE u_id = ?");
   $delete_prod_review->execute([$delete_id]);
   header('location:admin_users.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>users</title>

   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">


   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="user-accounts">

   <h1 class="title">accounts</h1>
   <section class="box-container">
   <div>
         <a href="adminregistration.php" class="option-btn">Add new admin</a>
   </div>
</section>
   <div class="box-container">
      <?php
         $select_users = $conn->prepare("SELECT * FROM `users`");
         $select_users->execute();
         while($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)){
      ?>
      <div class="box" style="<?php if($fetch_users['id'] == $admin_id){ echo 'display:none'; }; ?>">
         <img src="uploaded_img/<?= $fetch_users['image']; ?>" onerror="this.src='images/Make Your Day.jpeg'">
         <p> user id:<span><?= $fetch_users['id']; ?></span></p>
         <p> username:<span><?= $fetch_users['name']; ?></span></p>
         <p> email:<span><?= $fetch_users['email']; ?></span></p>
         <p> user type:<span style=" color:<?php if($fetch_users['user_type'] == 'admin'){ echo 'orange'; }; ?>"><?= $fetch_users['user_type']; ?></span></p>
         <a href="admin_users.php?delete=<?= $fetch_users['id']; ?>" onclick="return confirm('delete this user?');" class="delete-btn">delete</a>
      </div>
      <?php 
      } 
      ?>
      
   </div>

</section>













<script src="js/script.js"></script>

</body>
</html>