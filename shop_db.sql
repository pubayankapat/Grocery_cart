-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2023 at 09:10 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `charge` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` varchar(50) NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(21, 34, 'Pubayan Kapat', '9330154300', 'pubayankapat@gmail.com', 'cash on delivery', 'flat no. 23,Shyampur,Howrah,West bengal,India,711314', ', Chicken ( 3 )', 660, '13-May-2023', 'completed'),
(27, 34, 'Pubayan Kapat', '9330154300', 'pubayankapat@gmail.com', 'cash on delivery', 'flat no. 23,Shyampur,Howrah,West bengal,India,711314', ', Red chilli ( 1 )', 10, '13-May-2023', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(20) NOT NULL,
  `details` varchar(500) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `charge` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `details`, `price`, `image`, `charge`) VALUES
(1, 'Chana Dal', 'spice', 'Tata Sampann Chana Dal:500gms', 75, 'chanadal.jpg', 40),
(2, 'Moong Dal', 'spice', 'Tata Sampann Moong Dal:500gms', 90, 'moongdal.jpg', 20),
(3, 'Tur Dal', 'spice', 'Tata Sampann Tur Dal:500gms', 110, 'turdal.jpg', 20),
(5, 'Soyabean', 'spice', 'Nutrela Soya Chunks:200gms', 60, 'soyabean.jpg', 20),
(6, 'Masoor', 'spice', 'Satyam Masoor:500gms', 70, 'masoor.jpg', 20),
(7, 'Poha', 'spice', 'Tata Sampann Poha:500gms', 60, 'poha.jpg', 20),
(8, 'Sugar', 'spice', '24 Mantra Organic Sugar:1kg', 60, 'sugar.jpg', 20),
(24, 'chicken leg pieces', 'meat', 'leg pieces: 4 Pcs', 120, 'chicken leg pieces.png', 30),
(25, 'Green grapes', 'fruits', 'Green grapes: 500gm', 50, 'green grapes.png', 20),
(26, 'Semon fish', 'fish', 'Semon fish: 1Kg', 125, 'semon fish.png', 30),
(27, 'Capsicum', 'vegitables', 'Capsicum: 500gm\r\n', 70, 'capsicum.png', 20),
(28, 'Apple', 'fruits', 'Apple: 1Kg', 80, 'apple.png', 20),
(29, 'Chicken', 'meat', 'Chicken: 1Pc', 220, 'chicken.png', 30),
(30, 'Banana', 'fruits', 'Banana:6Pc', 60, 'banana.png', 10),
(31, 'Tomato', 'vegitables', 'Tomato:1Kg', 40, 'tomato.png', 20),
(32, 'Orange', 'fruits', 'Orange:1Kg', 60, 'orange.png', 20),
(33, 'Lichi', 'fruits', 'Lichi:1Kg', 100, 'lichi.png', 20),
(34, 'Carrot', 'vegitables', 'Carrot:1Kg', 30, 'carrot.png', 20),
(35, 'Cauliflower', 'vegitables', 'Cauliflower:1kg', 40, 'cauliflower.png', 10),
(36, 'Cabbage', 'vegitables', 'Cabbage:1Kg', 30, 'cabbage.png', 10),
(37, 'Blue grapes', 'fruits', 'Blue grapes:1Kg', 120, 'blue grapes.png', 20),
(38, 'Broccoli', 'vegitables', 'Broccoli:1Kg', 80, 'broccoli.png', 20),
(39, 'Watermelon', 'fruits', 'Watermelon:1Kg', 30, 'watermelon.png', 20),
(41, 'Red chilli', 'vegitables', 'Red chilli:100gm', 10, 'red papper.png', 10),
(42, 'Oily Fishes', 'fish', 'Oily Fishes:1kg', 170, 'oily fishes.png', 30),
(43, 'Strawberry', 'fruits', 'strawberry:1 pack(500gm)', 250, 'strawberry.png', 40),
(45, 'Mutton ', 'meat', 'Mutton: 1Kg', 800, 'pngegg.png', 60);

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `r_id` int(100) NOT NULL,
  `p_id` int(100) NOT NULL,
  `u_id` int(100) NOT NULL,
  `review` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_reviews`
--

INSERT INTO `product_reviews` (`r_id`, `p_id`, `u_id`, `review`) VALUES
(1, 1, 34, 'good'),
(2, 2, 34, 'Not bad.'),
(3, 1, 37, 'very good'),
(4, 25, 34, 'Nice.worth buying.'),
(6, 8, 34, 'Good.'),
(7, 34, 34, 'healthy'),
(8, 33, 34, 'sweet'),
(9, 44, 34, 'Fresh mutton'),
(10, 29, 34, 'Awsome!');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(100) NOT NULL,
  `review` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `review`) VALUES
(34, 'Nice place for shopping.'),
(37, 'Awsome!'),
(44, 'its a very nice place for purchase grocery.'),
(45, 'Wow!!!!!!');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user',
  `image` varchar(100) NOT NULL,
  `ph_no` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`, `image`, `ph_no`) VALUES
(34, 'Pubayan Kapat', 'pubayankapat@gmail.com', '2c7ba2d58c0bfbe71f46035e02df5dd4', 'user', 'pic-5.png', '9330154300'),
(36, 'Pubayan Kapat', 'kapatpubayan@gmail.com', '2c7ba2d58c0bfbe71f46035e02df5dd4', 'admin', 'pic-3.png', '9875619185'),
(37, 'Monisha Das', 'dasm@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'user', 'pic-4.png', '1234567890'),
(39, 'Monisha Das', 'mdas@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'admin', 'pic-2.png', '1234567890'),
(44, 'Koushik Dey', 'kdey@gmail.com', '7d0c6e0fb19135fadcdc5bd5b54ff21d', 'user', 'kdey.jpg', '9734851234'),
(45, 'Sharmistha Mondal', 'sm@gmail.com', 'ed79acb0cd3d7f8320c53c7798335ef0', 'user', 'pic-6.png', '9087654321');

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE `user_address` (
  `uid` int(100) NOT NULL,
  `ft_no` varchar(10) NOT NULL,
  `street` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `pin` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_address`
--

INSERT INTO `user_address` (`uid`, `ft_no`, `street`, `city`, `state`, `country`, `pin`) VALUES
(34, '23', 'Shyampur', 'Howrah', 'West bengal', 'India', '711314');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `charge` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`r_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_address`
--
ALTER TABLE `user_address`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `r_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
