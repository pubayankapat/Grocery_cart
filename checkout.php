<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['order'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = 'flat no. '. $_POST['flat'] .','. $_POST['street'] .','. $_POST['city'] .','. $_POST['state'] .','. $_POST['country'] .','. $_POST['pin_code'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $f_no = $_POST['flat'];
   $f_no = filter_var($f_no, FILTER_SANITIZE_STRING);
   $street = $_POST['street'];
   $street = filter_var($street, FILTER_SANITIZE_STRING);
   $city = $_POST['city'];
   $city = filter_var($city, FILTER_SANITIZE_STRING);
   $state = $_POST['state'];
   $state = filter_var($state, FILTER_SANITIZE_STRING);
   $country = $_POST['country'];
   $country = filter_var($country, FILTER_SANITIZE_STRING);
   $pin = $_POST['pin_code'];
   $pin = filter_var($pin, FILTER_SANITIZE_STRING);
   $placed_on = date('d-M-Y');

   $cart_total = 0;
   $cart_products[] = '';
   
   $select_add = $conn->prepare("SELECT * FROM `user_address` WHERE uid = ?");
   $select_add->execute([$user_id]);
   if($select_add->rowCount() == 0){
      $insert_add = $conn->prepare("INSERT INTO `user_address`(uid, ft_no, street, city, state, country, pin) VALUES(?,?,?,?,?,?,?)");
      $insert_add->execute([$user_id, $f_no, $street, $city, $state, $country, $pin]);
   }else{
      $update_add = $conn->prepare("UPDATE `user_address` SET ft_no=?, street=?, city=?, state=?, country=?, pin=? WHERE uid=?");
      $update_add->execute([$f_no, $street, $city, $state, $country, $pin,$user_id]);
   }

   $cart_query = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $cart_query->execute([$user_id]);
   if($cart_query->rowCount() > 0){
      while($cart_item = $cart_query->fetch(PDO::FETCH_ASSOC)){
         $cart_products[] = $cart_item['name'].' ( '.$cart_item['quantity'].' )';
         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $cart_total += $sub_total;
      };
   };

   $total_products = implode(', ', $cart_products);

   $order_query = $conn->prepare("SELECT * FROM `orders` WHERE name = ? AND number = ? AND email = ? AND method = ? AND address = ? AND total_products = ? AND total_price = ?");
   $order_query->execute([$name, $number, $email, $method, $address, $total_products, $cart_total]);

   if($cart_total == 0){
      $message[] = 'your cart is empty';
   }elseif($order_query->rowCount() > 0){
      $message[] = 'order placed already!';
   }else{
      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES(?,?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $cart_total, $placed_on]);
      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);
      if($method !== "cash on delivery"){
         header('location: pay.php');
      }else{
      $message[] = 'order placed successfully!';
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
   <title>checkout</title>


   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">


   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="display-orders">

   <?php
      $cart_grand_total = 0;
      $select_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
      $select_cart_items->execute([$user_id]);
      if($select_cart_items->rowCount() > 0){
         while($fetch_cart_items = $select_cart_items->fetch(PDO::FETCH_ASSOC)){
            $cart_total_price = (($fetch_cart_items['price'] * $fetch_cart_items['quantity'])+$fetch_cart_items['charge']);
            $cart_grand_total += $cart_total_price;
   ?>
   <p> <?= $fetch_cart_items['name']; ?> <span><?= '(Rs'.$fetch_cart_items['price'].'/- x '. $fetch_cart_items['quantity'].')+'.$fetch_cart_items['charge'].'/-'; ?></span> </p>
   <?php
    }
   }else{
      echo '<p class="empty">your cart is empty!</p>';
   }
   ?>
   <div class="grand-total">grand total : <span>Rs<?= $cart_grand_total; ?>/-</span></div>
</section>

<section class="checkout-orders">
   <?php
    $select_add = $conn->prepare("SELECT * FROM `user_address` WHERE uid = ?");
    $select_add->execute([$user_id]);
    $fetch_add = $select_add->fetch(PDO::FETCH_ASSOC);
    error_reporting(E_ERROR | E_PARSE);
   ?>

   <form action="" method="POST">
      <h3>place your order</h3>
      <div class="flex">
         <div class="inputBox">
            <span>your name :</span>
            <input type="text" name="name" value="<?= $fetch_profile['name']; ?>" placeholder="enter your name" class="box" required>
         </div>
         <div class="inputBox">
            <span>your number :</span>
            <input type="number" name="number" value="<?= $fetch_profile['ph_no']; ?>" placeholder="enter your number" class="box" required>
         </div>
         <div class="inputBox">
            <span>your email :</span>
            <input type="email" name="email" value="<?= $fetch_profile['email']; ?>" placeholder="enter your email" class="box" required>
         </div>
         <div class="inputBox">
            <span>payment method :</span>
            <select name="method" class="box" required>
               <option value="cash on delivery">Cash on delivery</option>
               <option value="Online payment">Pay Online</option>
                
            </select>
         </div>
         <div class="inputBox">
            <span>Flat or house No:</span>
            <input type="text" name="flat" placeholder="e.g. flat number" value="<?= $fetch_add['ft_no'];?>"  class="box" required>
         </div>
         <div class="inputBox">
            <span>Street:</span>
            <input type="text" name="street" value="<?= $fetch_add['street']; ?>" placeholder="e.g. street name" class="box" required>
         </div>
         <div class="inputBox">
            <span>city :</span>
            <input type="text" name="city" value="<?= $fetch_add['city']; ?>" placeholder="e.g. mumbai" class="box" required>
         </div>
         <div class="inputBox">
            <span>state :</span>
            <input type="text" name="state" value="<?= $fetch_add['state']; ?>" placeholder="e.g. maharashtra" class="box" required>
         </div>
         <div class="inputBox">
            <span>country :</span>
            <input type="text" name="country" value="<?= $fetch_add['country']; ?>" placeholder="e.g. India" class="box" required>
         </div>
         <div class="inputBox">
            <span>pin code :</span>
            <input type="number" min="0" name="pin_code" value="<?= $fetch_add['pin']; ?>" placeholder="e.g. 123456" class="box" required>
         </div>
         <input type="submit" name="order" class="btn <?= ($cart_grand_total > 1)?'':'disabled'; ?>" value="place order">
      </div>  
   </form>
</section>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>