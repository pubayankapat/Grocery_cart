<?php

@include 'config.php';
session_start();
$dump_id = session_create_id();


?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>index</title>
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>
   <?php include 'i_header.php' ?>
   <div class="home-bg">
      <section class="home">
         <div class="content">
            <h2>Fresh and <span>Organic</span> Products</h2>
            <p>Reach For A Healthier You With Organic Foods.</p>
            <a href="i_about.php" class="btn">about us</a>
         </div>
      </section>
   </div>

   <section class="products">
      <h1 class="title">latest products</h1>
      <div class="box-container">
         <?php
         if (isset($_GET['view_all'])) {
            $select_products = $conn->prepare("SELECT * FROM `products` ORDER BY id DESC");
            $select_products->execute();
         } else {
            $select_products = $conn->prepare("SELECT * FROM `products` ORDER BY RAND() LIMIT 9");
            $select_products->execute();
         }
         if ($select_products->rowCount() > 0) {
            while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
               ?>
               <form action="" class="box" method="POST">
                  <div class="price">
                     Rs<span><?= $fetch_products['price'];?></span>/-
                  </div>
                     <?php
                     if($fetch_products['Status'] !== 0){
                     ?>
                        <div class=""><span><?= $fetch_products['Status'];?></span></div>
                     <?php
                     }else{
                     ?>
                     <h3>Out of stock</h3>
                     <?php
                     }
                     ?>
                  
                  <img src="uploaded_img/<?= $fetch_products['image']; ?>" onerror="this.src='images/gro.png'">
                  <div class="name"><?= $fetch_products['name']; ?></div>
                  <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                  <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>">
                  <input type="hidden" name="p_price" value="<?= $fetch_products['price']; ?>">
                  <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>">
                  <input type="number" min="1" value="1" name="p_qty" class="qty">
                  <button class="btn" onclick="message()">add to cart</button>
                  <script>
                     function message() {
                        alert("please login to continue shopping!");
                     }
                  </script>
               </form>
               <?php
            }
         } else {
            echo '<p class="empty">no products available now!</p>';
         }
         ?>
      </div>
      <form action="" method="get" class="box-container">
         <input type="submit" value="More products" class="option-btn" name="view_all"
            style="box-shadow:0 1.8rem 1.8rem rgba(0,0,0,.5)">
      </form>
   </section>

   <?php include 'footer.php'; ?>
   <script src="js/script.js"></script>
</body>

</html>