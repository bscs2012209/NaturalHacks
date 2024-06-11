-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql208.infinityfree.com
-- Generation Time: Jun 06, 2024 at 04:46 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_36629316_nh`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(225) DEFAULT NULL,
  `password` varchar(225) DEFAULT NULL,
  `email` varchar(225) DEFAULT NULL,
  `phone` longtext DEFAULT NULL,
  `image` longtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `password`, `email`, `phone`, `image`, `created_at`) VALUES
(2, 'Kashaf', '$2y$10$C6MO9UdkmsPzAgBRoFOgnOnYOd7XJSs3MOvTgsuQ9DN4ZVM4wQ3vS', 'kashafkhalid65@gmail.com', '03202909535', 'C:\\xampp\\htdocs\\FypProject\\BackUp\\logo.jpeg', '2024-03-24 09:25:41'),
(3, 'Shannaya', '$2y$10$JuzRevdon3TTL1u3fs/lBur9kSxOyEwzbEnrCEdBMaBkjR7Zoa0N6', 'shannayafidai@gmail.com', '03452165732', NULL, '2024-01-22 09:37:45');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `remedy_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `discount` int(11) NOT NULL,
  `type` enum('flat','percent','','') NOT NULL,
  `start_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `end_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`id`, `name`, `discount`, `type`, `start_date`, `end_date`) VALUES
(1, 'Testing 123', 500, 'flat', '2024-05-23 19:00:00', '2024-05-15 19:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `diseases`
--

CREATE TABLE `diseases` (
  `id` int(11) NOT NULL,
  `name` varchar(225) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `diseases`
--

INSERT INTO `diseases` (`id`, `name`, `description`, `image`, `created_at`) VALUES
(3, 'Hair Fall', '<p>kkkkkkkkkkkkk</p>', 'https://naturalhacks.is-great.net/assets/uploaded_images/diseases/1705858239_Hair-Fall.jpg', '2024-01-21 17:30:39'),
(4, 'Skin Glow', '<p>Skin gets dull due to lack of brightness in complexion and is caused by accumulation of dead cells, stress or dehydration. To gain the brightness and the glow back skin glow remedies are used.</p>', 'https://naturalhacks.is-great.net/assets/uploaded_images/diseases/1705858319_Skin-Glow.jpg', '2024-01-22 08:48:11'),
(5, 'Dandruff', '<p>KKKKKKKKKKKKKKKKKKKKKKKKKKK</p>', 'https://naturalhacks.is-great.net/assets/uploaded_images/diseases/1705858351_Dandruff.jpg', '2024-01-21 17:32:31'),
(6, 'Joint Pain', '<p>JJJJJJJJJJJJJJJJ</p>', 'https://naturalhacks.is-great.net/assets/uploaded_images/diseases/1705858370_Joint-Pain.jpg', '2024-01-21 17:32:50'),
(7, 'Headache', '<p>jk,kkkk</p>', 'https://naturalhacks.is-great.net/assets/uploaded_images/diseases/1705858459_Headache.avif', '2024-01-21 17:34:19'),
(8, 'Teeth Whitening ', '<p>KKKKKKKKKKKKKKKK</p>', 'https://naturalhacks.is-great.net/assets/uploaded_images/diseases/1705858544_Teeth-Whitening.webp', '2024-01-21 17:35:44'),
(9, 'Cholesterol', '<p>Cholesterol a type of fat in human bodies essential for building cells and hormones. Too much of it may be unhealthy. It is often caused by consuming diets having high fats.</p>', 'https://naturalhacks.is-great.net/assets/uploaded_images/diseases/1705858681_Cholesterol.jpeg', '2024-01-22 09:35:22'),
(10, 'Skin Allergy', '<p>KKKK</p>', 'https://naturalhacks.is-great.net/assets/uploaded_images/diseases/1705858797_Allergy.jpg', '2024-01-21 17:39:57'),
(11, 'Digestive Issue', '<p>kkkk</p>', 'https://naturalhacks.is-great.net/assets/uploaded_images/diseases/1705858830_Digestive-Issue.webp', '2024-01-21 17:40:30'),
(12, 'Diabetes', '<p>qqqqqqqqqqqqqqq</p>', 'https://naturalhacks.is-great.net/assets/uploaded_images/diseases/1705858866_Diabetes.jpg', '2024-01-21 17:41:06'),
(13, 'Blood Pressure', '<p>1111111111</p>', 'https://naturalhacks.is-great.net/assets/uploaded_images/diseases/1705858902_Blood-Pressure.webp', '2024-01-21 17:41:42'),
(14, 'Acne', '<p>A skin condition which involves clogged pores, occurs due to excess oil production, inflammation and bacteria. It happens mostly due to hormonal changes in the body.</p>', 'https://naturalhacks.is-great.net/assets/uploaded_images/diseases/1705858927_Acne.jpg', '2024-01-21 18:19:55'),
(16, 'Dark Circle', '<p>aaaaaaaaaa</p>', 'https://naturalhacks.is-great.net/assets/uploaded_images/diseases/1705858986_Dark-Circles.jpg', '2024-01-21 17:43:06'),
(17, 'Weight Loss', '<p>kkkkkkkkkkkk</p>', 'https://naturalhacks.is-great.net/assets/uploaded_images/diseases/1705859006_Weightloss.cms', '2024-01-21 17:43:26'),
(18, 'Weight Gain', '<p>1111111111111111</p>', 'https://naturalhacks.is-great.net/assets/uploaded_images/diseases/1705859036_Weight-Gain.jpeg', '2024-01-21 17:43:56'),
(19, 'Cough', '<p>aaaaaaaaaaaaaaaaaa</p>', 'https://naturalhacks.is-great.net/assets/uploaded_images/diseases/1705859213_cough.jpg', '2024-01-21 17:46:53'),
(20, 'Kidney Pain', '<p>aaaaaaaaaaaa</p>', 'https://naturalhacks.is-great.net/assets/uploaded_images/diseases/1705859292_Kidney-Pain.webp', '2024-01-21 17:48:12'),
(21, 'Skin Tan', '<p>lklkll</p>', 'https://naturalhacks.is-great.net/assets/uploaded_images/diseases/1705907173_Skin-Tan.jpg', '2024-01-22 07:06:13');

-- --------------------------------------------------------

--
-- Table structure for table `experts`
--

CREATE TABLE `experts` (
  `id` int(11) NOT NULL,
  `name` varchar(225) DEFAULT NULL,
  `password` varchar(225) DEFAULT NULL,
  `email` varchar(225) DEFAULT NULL,
  `admin_approved` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `experts`
--

INSERT INTO `experts` (`id`, `name`, `password`, `email`, `admin_approved`, `created_at`) VALUES
(1, 'Dummy', '$2y$10$OR9wlQeldxqC9nFLsd7yMe1cx2QTQCoRYfFRMxTuVdNe3WlP8HnKK', 'expert@gmail.com', 1, '2024-03-24 09:03:06');

-- --------------------------------------------------------

--
-- Table structure for table `forget_passwords`
--

CREATE TABLE `forget_passwords` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `otp` varchar(6) NOT NULL,
  `expired` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forget_passwords`
--

INSERT INTO `forget_passwords` (`id`, `user_id`, `token`, `otp`, `expired`, `created_at`) VALUES
(1, 7, 'a15fbcb4d20c23133b0d8017ab3cc345', '746076', 0, '2024-06-06 20:49:28'),
(2, 7, 'a0e567c30212b8a610571a1fe8974718', '147455', 1, '2024-06-06 21:03:18');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `created_at`, `status`) VALUES
(1, 7, '0.00', '2024-03-24 00:47:44', 'processing'),
(2, 7, '0.00', '2024-03-24 02:24:22', 'shipped'),
(3, 7, '0.00', '2024-03-24 02:45:48', 'pending'),
(4, 7, '0.00', '2024-03-24 02:45:49', 'pending'),
(5, 7, '0.00', '2024-03-24 02:45:49', 'pending'),
(6, 7, '-600.00', '2024-03-24 13:23:22', 'pending'),
(7, 7, '0.00', '2024-03-24 13:23:23', 'pending'),
(8, 7, '0.00', '2024-03-24 13:23:23', 'pending'),
(9, 7, '0.00', '2024-03-26 01:12:02', 'pending'),
(10, 7, '0.00', '2024-03-26 01:12:02', 'pending'),
(11, 7, '0.00', '2024-03-26 01:12:03', 'pending'),
(12, 7, '0.00', '2024-03-26 01:12:04', 'pending'),
(13, 7, '2040950.00', '2024-05-04 02:37:57', 'pending'),
(14, 9, '197920.00', '2024-05-07 11:16:43', 'pending'),
(15, 9, '670.00', '2024-05-07 11:19:03', 'pending'),
(16, 9, '2680.00', '2024-05-07 11:19:55', 'pending'),
(17, 9, '6030.00', '2024-05-07 11:22:15', 'pending'),
(18, 9, '2680.00', '2024-05-07 11:25:20', 'pending'),
(19, 9, '2680.00', '2024-05-07 11:47:35', 'pending'),
(20, 9, '670.00', '2024-05-07 11:47:54', 'pending'),
(21, 9, '670.00', '2024-05-07 11:54:19', 'pending'),
(22, 9, '2680.00', '2024-05-07 11:57:02', 'pending'),
(23, 9, '1120.00', '2024-05-07 12:43:18', 'pending'),
(24, 9, '6600.00', '2024-05-07 12:51:54', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `remedy_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `remedy_id`, `quantity`, `price`) VALUES
(1, 1, 19, 1, '0.00'),
(2, 2, 20, 1, '0.00'),
(3, 6, 20, 0, '-600.00'),
(4, 9, 19, 2, '0.00'),
(5, 13, 20, 56, '33600.00'),
(6, 13, 27, 43, '3800.00'),
(7, 13, 19, 9, '-450.00'),
(8, 14, 19, 23, '8550.00'),
(9, 14, 20, 1, '600.00'),
(10, 14, 23, 1, '670.00'),
(11, 15, 23, 1, '670.00'),
(12, 16, 23, 2, '1340.00'),
(13, 17, 23, 3, '2010.00'),
(14, 18, 23, 2, '1340.00'),
(15, 19, 23, 2, '1340.00'),
(16, 20, 23, 1, '670.00'),
(17, 21, 23, 1, '670.00'),
(18, 22, 23, 2, '1340.00'),
(19, 23, 23, 1, '670.00'),
(20, 23, 19, 1, '450.00'),
(21, 24, 19, 2, '900.00'),
(22, 24, 21, 2, '2400.00');

-- --------------------------------------------------------

--
-- Table structure for table `remedies`
--

CREATE TABLE `remedies` (
  `id` int(11) NOT NULL,
  `name` varchar(225) DEFAULT NULL,
  `images` longtext DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `introduction` longtext DEFAULT NULL,
  `advantages` longtext DEFAULT NULL,
  `dis_advantages` longtext DEFAULT NULL,
  `ingredients` varchar(225) DEFAULT NULL,
  `how_to_make` varchar(255) NOT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `shelflife` tinyint(1) NOT NULL DEFAULT 0,
  `rating` decimal(10,2) NOT NULL DEFAULT 0.00,
  `expert_approval` enum('waiting','approved','declined','') NOT NULL DEFAULT 'waiting',
  `disease_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `remedies`
--

INSERT INTO `remedies` (`id`, `name`, `images`, `price`, `introduction`, `advantages`, `dis_advantages`, `ingredients`, `how_to_make`, `featured`, `shelflife`, `rating`, `expert_approval`, `disease_id`, `created_at`) VALUES
(7, 'Black Seeds', '[\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705751177_kalonji.jpg\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705751177_kalonji1.webp\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705751177_kalonji2.webp\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705751177_kalonji3.jpg\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705751177_kalonji4.jpg\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705751177_kalonji5.jpg\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705751177_kalonji6.webp\"]', '400.00', '<p>Also known as black seeds have been used in tradition remedies for various purpose due to their medicinal properties and potential health benefits.</p>', '<ol><li>Used to aid respiratory conditions like asthma and bronchitis</li><li>Helps with digestion and other issues which include bloating and gas</li><li>Kalonji oil due to its anti-inflammatory properties and antimicrobial properties is applied to skin conditions such as eczema.</li><li>Kalonji oil is also believed to treat hair conditions like dandruff and promote hair growth</li><li>Kalonji seeds are also used as a part of weight loss remedies.</li></ol>', '<ol><li>Consumption of excessive kalonji seeds or oil may have adverse effects such as allergic reactions or upset stomach.</li><li>Kalonji may react with certain medications.</li><li>Recommended to avoid in case of pregnancy&nbsp;</li><li>Quality and purity are essential else may have health risks.</li></ol>', '', '', 1, 0, '0.00', 'approved', 0, '2024-03-24 10:30:23'),
(8, 'Turmeric', '[\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705752608_T1.jpg\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705752608_T2.jpg\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705752608_T3.jpg\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705752608_T4.jpg\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705752608_T5.jpg\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705752608_T6.avif\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705752608_T7.avif\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705752608_Turmeric.jpg\"]', '300.00', '<p>Turmeric has been used in traditional medicine for its various medicinal properties.</p>', '<ol><li>Turmeric is a powerful antioxidant, helping to protect cells from oxidative stress and damage caused by free radicals.</li><li>Turmeric has been used as a natural pain reliever and may be effective in alleviating pain.</li><li>Turmeric may promote better digestion by increasing bile production.</li><li>Turmeric may help improve heart health.</li><li>Turmeric is used in skincare products and remedies to address various skin conditions.</li><li>Turmeric can be used topically on wounds and cuts to aid in the healing process and prevent infection.</li></ol>', '<ol><li>Can have mild blood-thinning effects, which may be problematic for individuals</li><li>Turmeric may trigger gallbladder contractions, which could be problematic for individuals.</li><li>Turmeric, may interact with certain medications, including those for diabetes.</li><li>Turmeric, because of its oxalate content, may contribute to the formation of kidney stones in susceptible individuals.</li><li>Turmeric supplements may increase stomach acid production.</li><li>Topical applications of turmeric can sometimes cause skin irritation or allergic reactions.</li></ol>', '', '', 1, 0, '0.00', 'approved', 0, '2024-03-24 10:30:23'),
(10, 'Ajwain', '[\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705753645_A.avif\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705753645_A1.jpg\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705753645_A2.png\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705753645_A3.webp\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705753645_A4.webp\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705753645_A5.jpeg\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705753645_A6.webp\"]', '320.00', '<p>Mostly known for its potential health benefits has been used in traditional remedies. It possesses various medicinal properties.</p>', '<ol><li>Widely used for alleviation of digestive issues and aids with indigestion and bloating.</li><li>Also used to ease menstrual cramps and discomfort</li><li>Ajwain has the potential to boost metabolism which is why it is also used in weight loss remedies.</li><li>Ajwain has anti-inflammatory effects also aiding ear and tooth aches.</li><li>Helps improve cholesterol levels.</li></ol>', '<ol><li>Excessive consumption may lead to adverse health effects.</li><li>High doses of ajwain may prove as a risk for pregnant women.</li><li>Individuals may be allergic to ajwain seeds and are advised to avoid using such remedies involving ajwain.</li><li>May react with certain medications professional advice is suggested.</li></ol>', '', '', 1, 0, '0.00', 'approved', 0, '2024-03-24 10:30:23'),
(11, 'Salajeet', '[\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705754868_S.avif\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705754868_S1.webp\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705754868_S2.webp\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705754868_S3.webp\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705754868_S4.webp\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705754868_S5.jpg\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705754868_S6.jpg\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705754868_S7.webp\"]', '520.00', '<p>Salajeet often considered as a natural medicine has a wide history of significant place in ayurveda. &nbsp;It has been popularly used in traditional medicines due to its numerous health benefits.</p>', '<ol><li>Salajeet is rich in various minerals including calcium and iron and fulvic acid. It enhances mineral absorption in body promoting overall health.</li><li>Also known for its antioxidant properties Salajeet helps fight oxidative stress and reduce cellular damage.</li><li>In many traditional remedies salajeet has been used to enhance energy level and increase stamina.</li><li>Salajeet has been associated with anti-aging benefits which promotes skin health due to its richness in minerals.</li></ol>', '<ol><li>The scientific research and evidence is very limited for salajeet for its use in herbal remedies.</li><li>High quality salajeet is pretty expensive and may be a limiting factor for individuals.</li><li>In a few cases individuals may experience side effects from its usage. Professional consultation is suggested.</li></ol>', '', '', 1, 0, '0.00', 'approved', 0, '2024-03-24 10:30:23'),
(12, 'Khus Root', '[\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705755536_K.jpg\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705755536_K1.jpg\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705755536_K2.png\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705755536_K3.jpg\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705755536_K4.jpg\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705755536_K5.webp\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705755536_K6.jpg\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705755536_K7.webp\"]', '600.00', '<p>Khus roots are prized for their aromatic and therapeutic properties. It has been widely used in traditional medicines.</p>', '<ol><li>Known for its cooling properties, it is widely used in home remedies to soothe body in summer months.</li><li>Khus roots contains compounds with anti-inflammatory properties which prove to be useful in naturally healing inflammation or skin injuries.</li><li>The oil extracted by khus roots is used in aromatherapy promoting relaxation and stress reduction.</li><li>Can also be of help in skin care remedies often used in pastes or baths to aid with skin conditions like acne.</li><li>Pastes of khus roots can also be applied to scalp because of their cooling and nourishing effects.</li></ol>', '<ol><li>Some individuals may face allergic reactions as they may be allergic to sensitive to khus roots. Patch test is advised.</li><li>The quality of oils derived from khus roots can vary.</li><li>Khus roots inspite of its health benefits can not be used as a substitute for medical treatment.</li></ol>', '', '', 1, 0, '0.00', 'approved', 0, '2024-03-24 10:30:23'),
(13, 'Singhara', '[\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705856148_W.jpg\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705856148_W1.jpg\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705856148_W2.webp\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705856148_W3.webp\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705856148_W4.jpg\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705856148_W5.jpg\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705856148_W6.jpg\",\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705856148_W7.webp\"]', '400.00', '<p>Singhara a nutrient rich ingredient recognized for its potential in natural remedies. Previously recognized in traditional medicines due to its wide range of benefits.</p>', '<ol><li>A good source of essential nutrients including vitamins and minerals. Helps maintain overall health.</li><li>Singhara possesses of anti-inflammatory properties that aids with conditions of inflammation.</li><li>Dietary fiber in Singhara contributes to the digestive health which promotes regular bowel movements.</li><li>Since Singhara is high in fiber and low in calories it proves to be advantageous for individuals seeking to manage their weight.</li></ol>', '<ol><li>Singhara has high oxalate content due to which consumption in large amounts may contribute to form kidney stones.</li><li>Singhara has a very short shell life due to which its improper storage may lead to deterioration.</li><li>Few individuals may be allergic to singhara. Reactions may result in swelling or difficulty in breathing. Professional consultation is advised.</li></ol>', '', '', 1, 0, '0.00', 'approved', 0, '2024-03-24 10:30:23'),
(14, 'Activated Charcoal Face Pack', '[\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705860755_Acne1.jpg\"]', '1000.00', '', '<ol><li>Charcoal is an effective anti-acne remedy which has detoxifying properties which really purifies the blood.</li><li>&nbsp;It has incredible exfoliating properties clears the clog pores and deeply cleanses the skin.</li><li>&nbsp;It makes the appearance of dark spots less visible.</li><li>Aloe vera gel has astringent properties that pulls dirt and excess oil out of skin, which helps preventing breakout it contains anti-bacterial quality which helps control and reduce the production of bacteria which cause acne.</li><li>&nbsp;Aloe vera gel is also used to moisturize your skin so it will really nourish your skin.</li><li>Tea tree oil is a wonderful skin treatment option especially for oily and acne prone skin.</li><li>Tea tree oil is a popular choice for treating acne because of its anti-inflammatory and antimicrobial properties it instantly calms redness swelling and inflammation.</li></ol>', '', '<ol><li>1tsp activated charcoal powder</li><li>1tsp aloe vera gel</li><li>1 drop tea tree oil</li></ol>', '<ol><li>In a small bowl, combine all the ingredients and mix them together before applying them on the skin.&nbsp;</li><li>Massage this charcoal pack on the face in a clock wise directions. Have circular motion for one minute then let the pack dry for 10<', 0, 0, '0.00', 'approved', 14, '2024-03-24 10:30:23'),
(15, 'Orange Peel Face Pack', '[\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705861411_Acne3.jpg\"]', '400.00', '', '<ol><li>Orange peel powder is high in vitamin C which helps in the formation of collagen and elastin in all skin types especially in oily skin because orange peel has anti-bacterial qualities they fight because acne causing germs which would result in clear skin.</li><li>Rosewater as antiseptic and antimicrobial properties which helps to reduce symptoms of acne breakout.&nbsp;</li><li>Rose water helps gently cleanse the skin without harming it, removes oil and dirt from your skin by unclogging your pores.</li></ol>', '', '<ol><li>1 tsp orange peel powder&nbsp;</li><li>2 tsp rose water</li></ol>', '<ol><li>Add both these ingredients and make a fine paste.</li><li>Apply this paste all over your face and neck.</li><li>Let it dry for 15 to 20 minutes and the wash it out with warm water.</li><li>Tap dry your face later.</li><li>Orange peel powder can be', 0, 0, '0.00', 'approved', 14, '2024-03-24 10:30:23'),
(16, 'Rice Flour Face Pack', '[\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705861593_Acne2.jpg\"]', '300.00', '', '<ol><li>Rice Flour is an excellent ingredient to get rid of acne and pigmentation spots.&nbsp;</li><li>It has skin brightening and de-tanning properties. Can help to reveal your inner skin glow, its an excellent source of vitamin B which helps in the production of new cells and makes your skin look young and fresh.</li><li>Lemon juice – is loaded with citric acid that directly targets the acne prone areas and dries out the excessive oil.</li><li>Its antiseptic properties kill bacteria that causes acne.</li><li>It is loaded with vitamin C and lightens the acne marks slowly slowly.</li><li>Raw Honey helps to balance the bacterias on the skin making it an excellent acne treatment.</li><li>Honey also improves the healing of the skin cell and it is also a great moisturizer which can keep your skin soft throughout the day.</li></ol>', '', '<ol><li>2 tsp rice flour</li><li>1 tsp lemon juice&nbsp;</li><li>1 tsp honey</li></ol>', '<ol><li>In a small bowl mix all these three ingredients and form a paste.</li><li>Now apply an even layer, on your face and neck.</li><li>Apply paste in a circular motion and let it dry for 10-15 minutes.</li><li>Gently wash your face with water and dry y', 0, 0, '0.00', 'approved', 14, '2024-03-24 10:30:23'),
(17, 'Tea Tree Ice Cubes', '[\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705861804_Acne5.webp\"]', '1000.00', '', '<ol><li>Tea tree oil helps prevents bacteria from sinking in the skin.</li><li>Aloe vera gel aids with inflammation on the skin and also moisturizes the skin giving a calming effect.</li><li>Tea Tree oil gives out a drying effect which helps reducing excess oil.<br>&nbsp;</li></ol>', '', '<ol><li>3 tbsp aloe vera gel</li><li>½ cup water</li><li>8-10 drops tea tree oil</li></ol>', '<ol><li>Mix all the ingredients in a bowl and mix well.&nbsp;</li><li>Pour the mixture into an ice tray and let it freeze.&nbsp;</li><li>Once done take an ice cube and rub it over the problem area. It works overnight.</li></ol>', 0, 0, '0.00', 'approved', 14, '2024-03-24 10:30:23'),
(18, 'Honey and Cinnamon Mask', '[\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705861979_acne6.jpg\"]', '590.00', '', '<ol><li>Honey comprises of antibacterial properties which help prevent acne.</li><li>Cinnamon helps reduce inflammation and redness on skin.</li><li>Cinnamon also provides gentle exfoliation to the skin helping in removal of dead skin.</li><li>Honey is also a natural moisturizer which provides hydration without clogging the pores.</li></ol>', '', '<ol><li>2 tbsp Honey&nbsp;</li><li>1tsp Cinnamon&nbsp;</li></ol>', '<ol><li>In a bowl add honey and cinnamon powder.&nbsp;</li><li>Mix it well until you get even consistency.&nbsp;</li><li>Make sure your face is clean of any kind of dirt or makeup.&nbsp;</li><li>Apply the mixture evenly in circular motion.&nbsp;</li><li>L', 0, 0, '0.00', 'approved', 14, '2024-03-24 10:30:23'),
(19, 'Turmeric Mask', '[\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705913756_SkinGlow1.jpeg\"]', '450.00', '', '<ol><li>Turmeric helps keep skin free from infections.</li><li>Gram flour has exceptional exfoliating properties which prevents dirt from settling in skin.</li><li>Gram flour helps absorb excess oil proving it to be beneficial for oily skin.</li><li>Rose water hydrates and refreshers the skin without making it oily.</li><li>Also helps balance skin’s PH</li></ol>', '', '<ol><li>½ tbsp turmeric powder</li><li>½ tbsp gram flour (baisan)</li><li>1 tbsp rose water</li></ol>', '<ol><li>Mix turmeric powder and gram flour in a bowl.</li><li>&nbsp;Add rose water to make a thick paste.&nbsp;</li><li>Apply evenly on your face.&nbsp;</li><li>Let it sit for 20 minutes then rinse with warm water.</li></ol>', 0, 0, '4.00', 'approved', 4, '2024-05-04 04:43:34'),
(20, 'Sandalwood and Rice Flour Mask', '[\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705913993_SkinGlow2.jpg\"]', '600.00', '', '<ol><li>Rice flour helps in gentle exfoliation which promotes the removal of dead skin cells.</li><li>Sandalwood powder due to its anti-inflammatory properties helps soothe irritated skin.</li><li>Combination of both powder contributes to a brighter complexion over time.</li></ol>', '', '<ol><li>½ tbsp sandalwood powder</li><li>1 tbsp rice flour</li><li>Rose water</li><li>1 tsp Honey (optional)</li></ol>', '<ol><li>Add rice flour and sandalwood powder in a bowl.</li><li>Then slowly add rose water while mixing until you achieve a paste like smooth consistency.</li><li>You can add a teaspoon of honey for moisture.</li><li>Make sure your skin is clean from any ', 0, 0, '0.00', 'approved', 4, '2024-03-24 10:30:23'),
(21, 'Glow Serum for Dry Skin', '[\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705914277_SkinGlow3.webp\"]', '1200.00', '', '<ol><li>Rose hip oil helps improve skin tone and reduces pigmentation.</li><li>It also helps repair and protect the skin from damage.</li><li>Aloe vera gel also has skin brightening properties.</li><li>It moisturizes the skin and fights acne.</li><li>Rose water deeply hydrates the skin resulting in smooth and soft skin.</li></ol>', '', '<ol><li>1 tsp Rosehip oil</li><li>1 tbsp aloe vera gel</li><li>¼ cup rose water</li></ol>', '<ol><li>Put rosehip oil and aloe vera gel and mix until you get a thick consistency.</li><li>Add rose water and mix well.</li><li>Pour the solution in a dropper bottle and the serum is ready to use.</li><li>Apply after you cleanse your face.</li><li>Use a', 0, 0, '0.00', 'approved', 4, '2024-03-24 10:30:23'),
(22, 'Glow Mist', '[\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705914409_SkinGlow4.jpeg\"]', '900.00', '', '<ol><li>Both aloe vera and rose water hydrate the skin so this mist can provide</li><li>A quick and refreshing burst of hydration to the skin</li><li>Lavender is widely known for its calming properties.</li><li>It gives aromatherapy benefits.</li><li>Rose water helps protect the skin from damage contributing to a healthier and youthful complexion</li></ol>', '', '<ol><li>1-2 tbsp aloe vera gel</li><li>½ cup rose water</li><li>1-2 drops lavender oil</li></ol>', '<ol><li>In a clean bowl add aloe vera gel and rose water together.</li><li>Then add drops of lavender oil to the mixture.</li><li>Mix until you get a water like consistency.</li><li>Transfer the solution to a spray bottle and the mist is ready to use.</li', 0, 0, '0.00', 'approved', 4, '2024-03-24 09:43:45'),
(23, 'Kulthi Drink', '[\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705915064_Cholesterol1.jpg\"]', '670.00', '', '<ol><li>Kulthi dal is said to be abundant in calcium and iron.</li><li>Also provides 1/4th of human’s total protein requirement per day.</li></ol>', '', '<ol><li>Cooked kulthi dal 2 cups</li><li>1 spoon lemon juice</li><li>2 tsp garlic paste</li><li>1 chopped tomato</li><li>2 tsp pepper and cummin seeds paste</li><li>1 tsp mustard seeds</li><li>5ml cooking oil</li><li>Salt to ', '<ol><li>Clean, wash and soak kulthi dal for 4 hours.</li><li>Then steam it and let it cool down.</li><li>After it is cooled down remove the excess water.</li><li>Heat 1 tsp oil in a pan followed by adding mustard seeds and curry leaves allowing it to spla', 0, 0, '0.00', 'approved', 9, '2024-03-24 10:29:23'),
(24, 'Bay Leaves Drink', '[\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705915449_Cholesterol2.jpeg\"]', '320.00', '', '<ol><li>Bay leaves prove to be a good source of vitamin A, C and B6.&nbsp;</li><li>Bay leaves aid digestive system.</li><li>Also helps lower and manage cholesterol levels.</li><li>Vitamin C in lemon helps lower and regulate blood cholesterol levels.</li></ol>', '', '<ol><li>10 bay leaves (tez patta)</li><li>300ml hot water</li><li>150 ml warm water</li><li>Half lemon</li><li>½ tsp honey (optional)</li></ol>', '<ol><li>Cut the bay leaves in small pieces and dip it in hot water.</li><li>Cover and let sit for 10 minutes.&nbsp;</li><li>After 10 minutes, place a towel in a pot, place the glass of the bay leaves and water on it.</li><li>Cover it with a lid, pour boil', 0, 0, '0.00', 'approved', 9, '2024-03-24 10:30:23'),
(25, 'Cholesterol Drink', '[\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705915789_Cholesterol3.jpeg\"]', '520.00', '', '<ol><li>Garlic has cholesterol lowering properties and contributes in reducing the oxidative stress and cholesterol levels in the body.</li><li>Ginger, lemon and apple cider vinegar are proved to be rich in antioxidants which support healthy heart.</li><li>This drink indirectly supports weight management.</li><li>Vitamin C in lemon juice helps boost immune system</li><li>Apple cider vinegar aids in better digestion.&nbsp;</li></ol>', '', '<ol><li>1-2 cloves garlic</li><li>1 tsp ginger</li><li>1tbsp lemon juice</li><li>1-2 tbsp apple cider vinegar&nbsp;</li><li>1 tsp honey</li></ol>', '<ol><li>First of all you need to crush or mince the garlic and keep it aside.</li><li>Then grate the ginger.&nbsp;</li><li>In a glass mix well all the ingredients’ garlic, ginger, lemon juice, apple cider vinegar and honey.</li><li>Making sure all the ing', 0, 0, '0.00', 'approved', 9, '2024-03-24 10:30:23'),
(26, 'Oatmeal and blueberry breakfast bowl', '[\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1705916055_Cholestero4.jpeg\"]', '800.00', '', '<ol><li>Oats are proved to be a rich source of soluble fiber which aids lowering LDL cholesterol levels.</li><li>Almonds may also have a positive impact on cholesterol levels as it is rich in fats and fiber.</li><li>Cinnamon is known to add a flavor without any need of excessive sugar and is believed to have cholesterol lowering properties.</li><li>Fatty acid in flax seeds supports healthy heart and helps lower cholesterol.</li><li>Greek yogurt provides protein making the diet a complete balanced diet.</li></ol>', '', '<ol><li>½ cup rolled oats</li><li>½ cup fresh blueberries</li><li>1 tbsp almonds</li><li>1 tbsp ground flaxseeds</li><li>½ tsp cinnamon</li><li>½ cup low fat Greek yogurt</li></ol>', '<ol><li>Firstly cook the rolled oats according to the instructions given on the package you can either use water or low-fat milk for cooking.</li><li>In a bowl, add those cooked oats followed by blueberries, chopped almonds, cinnamon and ground flaxseeds.', 0, 0, '0.00', 'approved', 9, '2024-03-24 10:30:23'),
(27, 'lemon', '[\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1711272939_screencapture-localhost-phpmyadmin-index-php-2024-01-22-14_38_14.png\"]', '100.00', '', '<p>asdasd</p>', '', '<p>wawdasd</p>', '<p>asdasdasd</p>', 0, 0, '4.00', 'approved', 3, '2024-05-04 05:06:26'),
(28, 'Shannaya', '[\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1711434898_screencapture-localhost-FypProject-expert-remedies-remedy-edit-php-2024-03-24-22_26_57.png\"]', '2000.00', '', '<p>kkkkuiu</p>', '', '<p>lkkkkk</p>', '<p>kkkk</p>', 0, 0, '11.00', 'declined', 4, '2024-05-04 04:40:11'),
(29, 'lemon', '[\"https://naturalhacks.is-great.net/assets/uploaded_images/remedies/1714803850_statechart.PNG\"]', '200.00', '', '<p>Testing</p>', '', '<p>Testing</p>', '<p>Testing</p>', 0, 1, '0.00', 'approved', 9, '2024-05-04 06:24:50');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `remedy_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `remedy_id`, `description`, `rating`, `created_at`) VALUES
(1, 7, 23, 'Testing', 3, '2024-05-04 04:29:17'),
(2, 7, 19, 'iuyi', 4, '2024-05-04 04:43:34'),
(3, 7, 27, 'Testing', 4, '2024-05-04 05:06:26');

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` int(11) NOT NULL,
  `name` varchar(225) DEFAULT NULL,
  `address` varchar(225) DEFAULT NULL,
  `latitude` decimal(9,6) DEFAULT NULL,
  `longitude` decimal(9,6) DEFAULT NULL,
  `commission_rate` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `name`, `address`, `latitude`, `longitude`, `commission_rate`, `created_at`) VALUES
(1, 'Saeed Ghani', 'G 3, Block 9 Clifton, Karachi, Karachi City, Sindh 75600', '24.878200', '67.064070', '2.00', '2024-04-20 05:37:37'),
(3, 'adas', 'asd', '123.000000', '123.000000', '5.00', '2024-05-07 23:24:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(225) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `email` varchar(225) DEFAULT NULL,
  `phone` longtext DEFAULT NULL,
  `password` varchar(225) DEFAULT NULL,
  `address` varchar(225) DEFAULT NULL,
  `admin_approved` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `image`, `email`, `phone`, `password`, `address`, `admin_approved`, `created_at`) VALUES
(7, 'Kashaf', '', 'kashafkhalid65@gmail.com', '03202909535', '$2y$10$Gvvhy3VmrWliI2giVdPP0unfKihTfX2vINIvo0qvU/bkZP6JD11V6', NULL, 1, '2024-06-06 21:03:18'),
(9, 'Muhammad Burhan Arshad', NULL, 'burhantheschoolboy@gmail.com', '03437649017', '$2y$10$C6MO9UdkmsPzAgBRoFOgnOnYOd7XJSs3MOvTgsuQ9DN4ZVM4wQ3vS', NULL, 1, '2024-05-04 16:11:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `remedy_id` (`remedy_id`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `diseases`
--
ALTER TABLE `diseases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `experts`
--
ALTER TABLE `experts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forget_passwords`
--
ALTER TABLE `forget_passwords`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `remedy_id` (`remedy_id`);

--
-- Indexes for table `remedies`
--
ALTER TABLE `remedies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `disease_id` (`disease_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `remedy_id` (`remedy_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `diseases`
--
ALTER TABLE `diseases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `experts`
--
ALTER TABLE `experts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `forget_passwords`
--
ALTER TABLE `forget_passwords`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `remedies`
--
ALTER TABLE `remedies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`remedy_id`) REFERENCES `remedies` (`id`);

--
-- Constraints for table `forget_passwords`
--
ALTER TABLE `forget_passwords`
  ADD CONSTRAINT `forget_passwords_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`remedy_id`) REFERENCES `remedies` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`remedy_id`) REFERENCES `remedies` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
