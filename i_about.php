<?php
@include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'i_header.php';?>

<section class="about">

   <div class="row">

      <div class="box">
         <img src="images/about-img-1.png" alt="">
         <h3>why choose us?</h3>
         <p>Grocery Mart presents you the most fresh itms and fully organic vegetables with out any trouble and on time as promises by us.You can shopping from here seamlessly with out much effort.</p>
         
      </div>

      <div class="box">
         <img src="images/about-img-2.png" alt="">
         <h3>what we provide?</h3>
         <p>We provide you the fastest delivery as soon as possible to reach you the grocery items that could remain as it is on lowest delivery charge.</p>
        
      </div>

   </div>

</section>

<section class="reviews">

   <h1 class="title">clients reviews</h1>

   <div class="box-container">
   <?php
      $select_reviews = $conn->prepare("SELECT * FROM `reviews` ORDER BY RAND() LIMIT 6");
      $select_reviews->execute();
      if($select_reviews->rowCount() > 0){
         while($fetch_reviews = $select_reviews->fetch(PDO::FETCH_ASSOC)){
            $rev_id=$fetch_reviews['id'];
            $select_des= $conn->prepare("SELECT `id`,`name`,`image` FROM `users` WHERE id=$rev_id"); 
            $select_des->execute();
            $fetch_des = $select_des->fetch(PDO::FETCH_ASSOC);
   ?>
      <div class="box">
         <img src="uploaded_img/<?=$fetch_des['image']?>" alt="">
         <h3><?=$fetch_des['name']?></h3>
         <p><?= $fetch_reviews['review']?></p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
      </div>
   <?php
      }
   }else{
      echo '<p class="empty">no reviews available now!</p>';
   }
   ?>
   </div>

</section>
<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>