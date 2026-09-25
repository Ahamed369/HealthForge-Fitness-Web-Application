-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2026 at 08:02 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `healthforge`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int(11) NOT NULL,
  `question` varchar(500) NOT NULL,
  `answer` text NOT NULL,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `sort_order`) VALUES
(1, 'What payment methods do you accept?', 'We accept all major credit/debit cards, bank transfers, and cash on delivery within Sri Lanka.', 1),
(2, 'How long does delivery take?', 'Standard delivery takes 3–5 business days. Express delivery (1–2 days) is available for Colombo and Western Province.', 2),
(3, 'Can I return a product?', 'Yes, we offer a 14-day return policy for unused products in original packaging. Contact us to initiate a return.', 3),
(4, 'Are your supplements authentic?', 'All our supplements are sourced directly from certified distributors and are third-party tested for quality and authenticity.', 4),
(5, 'Do you offer bulk or wholesale pricing?', 'Yes! Contact us via the form above or WhatsApp for bulk order pricing and corporate packages.', 5);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Processing',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_number`, `total_amount`, `status`, `created_at`) VALUES
(1, 2, 'HF20260611105211128', 11450.00, 'Processing', '2026-06-11 08:52:11');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 2, 1, 11450.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(100) NOT NULL,
  `rating` decimal(2,1) DEFAULT 0.0,
  `reviews` int(11) DEFAULT 0,
  `description` text DEFAULT NULL,
  `features` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `category`, `rating`, `reviews`, `description`, `features`, `image`) VALUES
(1, 'Premium Whey Protein Powder', 18000.00, 'supplements', 4.8, 124, 'High-quality whey protein isolate with 25g protein per serving. Available in chocolate, vanilla, and strawberry flavors.', '[\"25g Protein\", \"Low Carb\", \"Fast Absorption\", \"Third-Party Tested\"]', 'images/Whey_protein.jpg'),
(2, 'Omega-3 Fish Oil Capsules', 11450.00, 'supplement', 4.6, 89, 'Pure omega-3 fish oil capsules supporting heart health and brain function. 1000mg per capsule.', '[\"1000mg EPA/DHA\", \"Heart Health\", \"Brain Support\", \"Molecularly Distilled\"]', 'images/Omega.jpg'),
(3, 'Pre-Workout Energy Booster', 7500.00, 'supplement', 4.7, 156, 'Clean energy pre-workout formula with natural caffeine, beta-alanine, and citrulline for enhanced performance.', '[\"Natural Caffeine\", \"No Crash\", \"Enhanced Focus\", \"30 Servings\"]', 'images/Energy.jpg'),
(4, 'Multivitamin for Active Adults', 2700.00, 'supplement', 4.5, 203, 'Complete multivitamin specifically formulated for active individuals with enhanced B-vitamins and antioxidants.', '[\"25+ Vitamins & Minerals\", \"Energy Support\", \"Immune Boost\", \"60 Tablets\"]', 'images/Multivitamin.jpg'),
(5, 'Adjustable Dumbbell Set', 27000.00, 'equipment', 4.9, 78, 'Space-saving adjustable dumbbells with quick-change weight system. Each dumbbell adjusts from 5-50 lbs.', '[\"5-50 lbs Range\", \"Quick Adjust\", \"Space Saving\", \"Durable Steel\"]', 'images/dumbbell.jpg'),
(6, 'Power Tower Pull-Up Station', 3900.00, 'equipment', 4.4, 45, 'Multi-functional power tower for pull-ups, dips, push-ups, and knee raises. Heavy-duty steel construction.', '[\"4-in-1 Design\", \"400 lbs Capacity\", \"Padded Grips\", \"Easy Assembly\"]', 'images/Pull_up.jpg'),
(7, 'Folding Treadmill', 18000.00, 'equipment', 4.3, 67, 'Compact folding treadmill with 12 preset programs, heart rate monitoring, and quiet motor operation.', '[\"12 Programs\", \"Foldable Design\", \"Heart Rate Monitor\", \"Silent Motor\"]', 'images/treadmill.jpg'),
(8, 'Olympic Barbell with Plates', 5100.00, 'equipment', 4.8, 34, 'Professional Olympic barbell set including 45lb barbell and 255lbs of rubber-coated weight plates.', '[\"Olympic Standard\", \"Rubber Coated\", \"300lbs Total\", \"Chrome Barbell\"]', 'images/barbell.jpg'),
(9, 'Yoga Mat with Alignment Lines', 1500.00, 'wellness', 4.6, 189, 'Premium non-slip yoga mat with alignment guides. 6mm thick for extra cushioning and joint protection.', '[\"6mm Thick\", \"Non-Slip Surface\", \"Alignment Lines\", \"Eco-Friendly Material\"]', 'images/yoga_mat.jpg'),
(10, 'Foam Roller for Muscle Recovery', 1200.00, 'wellness', 4.7, 142, 'High-density foam roller perfect for myofascial release and post-workout recovery. 13\" x 6\" size.', '[\"High Density Foam\", \"13 inch Length\", \"Muscle Recovery\", \"Travel Friendly\"]', 'images/foam_roller.jpg'),
(11, 'Vitamin Tablets', 1500.00, 'supplements', 5.0, 245, 'The best Vitamins you Can get now in Sri Lanka', NULL, 'images/vitamin.jfif');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Admin', 'admin@healthforge.com', '$2y$10$/bBYv1N11NZMhre9mNCuo.KDuqjV2zM0qNKvVnxaLZ.F5.fRJ8IpK', 'admin', '2026-06-11 08:33:20');
--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_product` (`user_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_number` (`order_number`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
