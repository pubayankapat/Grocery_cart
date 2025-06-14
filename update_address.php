<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['order'])){

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
   
   $select_add = $conn->prepare("SELECT * FROM `user_address` WHERE uid = ?");
   $select_add->execute([$user_id]);
   if($select_add->rowCount() == 0){
      $insert_add = $conn->prepare("INSERT INTO `user_address`(uid, ft_no, street, city, state, country, pin) VALUES(?,?,?,?,?,?,?)");
      $insert_add->execute([$user_id, $f_no, $street, $city, $state, $country, $pin]);
   }else{
      $update_add = $conn->prepare("UPDATE `user_address` SET ft_no=?, street=?, city=?, state=?, country=?, pin=? WHERE uid=?");
      $update_add->execute([$f_no, $street, $city, $state, $country, $pin,$user_id]);
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
<section class="checkout-orders">
    <?php
    $select_add = $conn->prepare("SELECT * FROM `user_address` WHERE uid = ?");
    $select_add->execute([$user_id]);
    $fetch_add = $select_add->fetch(PDO::FETCH_ASSOC);
    error_reporting(E_ERROR | E_PARSE);
   ?>
   <form action="" method="POST">
   <h3>Update your address</h3>
        <div class="flex">
         <div class="inputBox">
            <span>Flat or house No:</span>
            <input type="text" name="flat" placeholder="e.g. flat number" value="<?= $fetch_add['ft_no'];?>"  class="box" required>
         </div>
         <div class="inputBox">
            <span>Street:</span>
            <input type="text" name="street" value="<?= $fetch_add['street']; ?>" placeholder="e.g. street name" class="box" required>
         </div>
         <div class="inputBox">
            <span>City :</span>
            <input type="text" name="city" value="<?= $fetch_add['city']; ?>" placeholder="e.g. mumbai" class="box" required>
         </div>
         <div class="inputBox">
            <span>State :</span>
            <input type="text" name="state" value="<?= $fetch_add['state']; ?>" placeholder="e.g. maharashtra" class="box" required>
         </div>
         <div class="inputBox">
            <span>Country :</span>
            <input type="text" name="country" value="<?= $fetch_add['country']; ?>" placeholder="e.g. India" class="box" required>
         </div>
         <div class="inputBox">
            <span>Pin code :</span>
            <input type="number" min="0" name="pin_code" value="<?= $fetch_add['pin']; ?>" placeholder="e.g. 123456" class="box" required>
         </div>
         <input type="submit" name="order" class="btn" value="Update">
        </div>    
   </form>
</section>

<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>