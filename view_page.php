<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
}
;
if (isset($_POST['submit'])) {
   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $rev = $_POST['preview'];
   $rev = filter_var($rev, FILTER_SANITIZE_STRING);
   $select = $conn->prepare("SELECT * FROM `product_reviews` where p_id=? AND u_id=?");
   $select->execute([$pid, $user_id]);
   if ($select->rowCount() > 0) {
      $update_review = $conn->prepare("UPDATE `product_reviews` set review= ? WHERE p_id= ? AND u_id=?");
      $update_review->execute([$rev, $pid, $user_id]);
      $message[] = "Feedback submitted successfully!";
   } else {
      $add_review = $conn->prepare("INSERT INTO `product_reviews`(p_id,u_id,review) VALUES(?,?,?)");
      $add_review->execute([$pid, $user_id, $rev]);
      $message[] = "Feedback submitted successfully!";
   }
}

if (isset($_POST['add_to_wishlist'])) {

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $p_name = $_POST['p_name'];
   $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
   $p_price = $_POST['p_price'];
   $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
   $p_image = $_POST['p_image'];
   $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);
   $charge = $_POST['charge'];
   $charge = filter_var($charge, FILTER_SANITIZE_STRING);
   $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
   $check_wishlist_numbers->execute([$p_name, $user_id]);

   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if ($check_wishlist_numbers->rowCount() > 0) {
      $message[] = 'already in your wishlist!';
   } elseif ($check_cart_numbers->rowCount() > 0) {
      $message[] = 'already in your cart!';
   } else {
      $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image,charge) VALUES(?,?,?,?,?,?)");
      $insert_wishlist->execute([$user_id, $pid, $p_name, $p_price, $p_image, $charge]);
      $message[] = 'added to wishlist!';
   }

}

if (isset($_POST['add_to_cart'])) {

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $p_name = $_POST['p_name'];
   $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
   $p_price = $_POST['p_price'];
   $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
   $p_image = $_POST['p_image'];
   $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);
   $p_qty = $_POST['p_qty'];
   $p_qty = filter_var($p_qty, FILTER_SANITIZE_STRING);
   $charge = $_POST['charge'];
   $charge = filter_var($charge, FILTER_SANITIZE_STRING);
   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if ($check_cart_numbers->rowCount() > 0) {
      $message[] = 'already in your cart!';
   } else {

      $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
      $check_wishlist_numbers->execute([$p_name, $user_id]);

      if ($check_wishlist_numbers->rowCount() > 0) {
         $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
         $delete_wishlist->execute([$p_name, $user_id]);

      }
      $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image,charge) VALUES(?,?,?,?,?,?,?)");
      $insert_cart->execute([$user_id, $pid, $p_name, $p_price, $p_qty, $p_image, $charge]);
      $message[] = 'added to cart!';

   }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>quick view</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>
   <?php

   if (isset($message)) {
      if (is_array($message) || is_object($message)) {
         foreach ($message as $message) {
            echo '
         <div class="message">
            <span>' . $message . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
         }
      }
   }
   ?>

   <?php include 'header.php'; ?>

   <section class="quick-view">

      <h1 class="title">view product</h1>

      <?php
      $pid = $_GET['pid'];
      $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
      $select_products->execute([$pid]);
      if ($select_products->rowCount() > 0) {
         while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <form action="" method="POST">
               <div class="flex">
                  <div class="inputBox">
                     <div class="price">Rs<span><?= $fetch_products['price']; ?></span>/-</div>
                     <?php
                     if ($fetch_products['Status'] !== 0) {
                        ?>
                        <div class="">
                           <h2>Available <?= $fetch_products['Status']; ?></h2>
                        </div>
                        <?php
                     } else {
                        ?>
                        <h2>Out of stock</h2>
                        <?php
                     }
                     ?>
                     <img src="uploaded_img/<?= $fetch_products['image']; ?>" onerror="this.src='images/gro.png'">
                     <div class="name"><?= $fetch_products['name']; ?></div>
                     <div class="details"><?= $fetch_products['details']; ?></div>
                     <div class="charge">Delivery charge:<?= $fetch_products['charge']; ?>/-</div>
                     <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                     <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>">
                     <input type="hidden" name="p_price" value="<?= $fetch_products['price']; ?>">
                     <input type="hidden" name="charge" value="<?= $fetch_products['charge']; ?>">
                     <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>">
                     <input type="number" min="1" value="1" name="p_qty" class="qty">
                     <input type="submit" value="add to wishlist" class="option-btn" name="add_to_wishlist">
                     <input type="submit" value="add to cart" class="btn" name="add_to_cart">
                  </div>
                  <div class="inputBox">
                     <h1 class="title">Product Reviews</h1>
                     <?php
         }
         $select_review = $conn->prepare("SELECT * FROM `product_reviews` WHERE p_id= ?");
         $select_review->execute([$pid]);
         if ($select_review->rowCount() > 0) {
            while ($fetch_review = $select_review->fetch(PDO::FETCH_ASSOC)) {
               $uid = $fetch_review['u_id'];
               $select_name = $conn->prepare("SELECT `name` FROM `users` WHERE id= ?");
               $select_name->execute([$uid]);
               $fetch_name = $select_name->fetch(PDO::FETCH_ASSOC);
               ?>
                        <div class="qty">
                           <div class="name"><?= $fetch_name['name'] ?></div>
                           <div class="details"><?= $fetch_review['review'] ?></div>
                        </div>
                        <?php
            }
         } else {
            echo '<p class="qty">No reviews yet!</p>';
         }
         ?>
                  <div class="empty">
                     <form action="" method="post">
                        <!-- <h1 class="title">Product review</h1> -->
                        <input type="hidden" name="pid" value="<?= $pid ?>">
                        <textarea name="preview" required placeholder="Give your review." cols="30" rows="5"
                           class="qty"></textarea>
                        <input type="submit" value="Submit" name="submit" class="btn">
                     </form>
                  </div>
               </div>
            </div>

         </form>
      </section>

      <?php
      } else {
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>

   <?php include 'footer.php'; ?>

   <script src="js/script.js"></script>

</body>

</html>