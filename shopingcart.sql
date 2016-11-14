--
-- Table structure for table `bookgeneral`
--

CREATE TABLE IF NOT EXISTS `bookgeneral` (
  `isbn` varchar(30) NOT NULL,
  `title` varchar(30) NOT NULL,
  `description` varchar(200) NOT NULL,
  `category` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Inserting data for table `bookgeneral`
--

INSERT INTO `bookgeneral` (`isbn`, `title`, `description`, `category`) VALUES
('14355', 'Linux for beginners', 'Linux for beginners because its so hard it needs a book.', 'Business');

--
-- Table structure for table `bookspecific`
--

CREATE TABLE IF NOT EXISTS `bookspecific` (
  `id` int(11) NOT NULL,
  `isbn` varchar(30) NOT NULL,
  `price` double NOT NULL,
  `bookCondition` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL,
  `ownerUsername` varchar(30) NOT NULL,
  `imageName` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Inserting data for table `bookspecific`
--

INSERT INTO `bookspecific` (`id`, `isbn`, `price`, `bookCondition`, `status`, `ownerUsername`, `imageName`) VALUES
(1, '14355', 200, 'quite old', 'availible', 'lonwabo', 'image1.png'),
(2, '14355', 400, 'almost new', 'availible', 'lonwabo', 'linux.png');

--
-- Table structure for table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Insertng data for table `client`
--

INSERT INTO `client` (`username`, `password`, `name`, `lastName`, `email`, `phone`, `address`) VALUES
('lonwabo', 'lodz', 'lonwabo', 'tsipa', 'email@email.email', '017453728262', 'Southwood');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `clientUsername` varchar(30) NOT NULL,
  `bookid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookgeneral`
--
ALTER TABLE `bookgeneral`
  ADD PRIMARY KEY (`isbn`);

--
-- Indexes for table `bookspecific`
--
ALTER TABLE `bookspecific`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`clientUsername`,`bookid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookspecific`
--
ALTER TABLE `bookspecific`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
