-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2019 at 09:34 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coop`
--

-- --------------------------------------------------------

--
-- Table structure for table `dashboardlogintbl`
--

CREATE TABLE `dashboardlogintbl` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dashboardlogintbl`
--

INSERT INTO `dashboardlogintbl` (`id`, `username`, `password`, `level`, `status`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'active'),
(2, 'chairperson', '21232f297a57a5a743894a0e4a801fc3', 'chairperson', 'chairperson');

-- --------------------------------------------------------

--
-- Table structure for table `loanrequesttbl`
--

CREATE TABLE `loanrequesttbl` (
  `id` int(11) NOT NULL,
  `loanrequestid` varchar(255) NOT NULL,
  `memberid` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `loantype` varchar(255) NOT NULL,
  `totalamount` varchar(300) NOT NULL,
  `datestart` varchar(255) NOT NULL,
  `dateend` varchar(255) NOT NULL,
  `months` varchar(255) NOT NULL,
  `mop` varchar(255) NOT NULL,
  `comakerid` varchar(255) NOT NULL,
  `comakername` varchar(255) NOT NULL,
  `datesubmitted` varchar(255) NOT NULL,
  `paymentstatus` varchar(255) NOT NULL,
  `totalrequeststatus` varchar(255) NOT NULL DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loanrequesttbl`
--

INSERT INTO `loanrequesttbl` (`id`, `loanrequestid`, `memberid`, `name`, `loantype`, `totalamount`, `datestart`, `dateend`, `months`, `mop`, `comakerid`, `comakername`, `datesubmitted`, `paymentstatus`, `totalrequeststatus`) VALUES
(2, '27-03042019', '27-1991-2019', 'Maria C. Bermejo', 'emergency', '5000', '2019-03-31', '31/05/2019', '2', 'Salary Deduction', '28-1991-2019', 'Maricar C. Salazar', '2019-03-04', 'unpaid', 'approved'),
(3, '30-04062019', '30-1991-2019', 'Denis C. Bermejo', 'providential', '20000', '2019-04-30', '30/08/2019', '4', 'Salary Deduction', '29-1991-2019', 'Ma. Teresa C. Cruzada', '2019-04-06', 'unpaid', 'approved'),
(4, '32-04062019', '32-1991-2019', 'Rafael C. Cruzada', 'emergency', '10000', '2019-04-30', '30/07/2019', '3', 'Salary Deduction', '31-1991-2019', 'Lowina C. Fernando', '2019-04-06', 'unpaid', 'approved'),
(5, '31-04062019', '31-1991-2019', 'Lowina C. Fernando', 'business', '65000', '2019-05-30', '30/05/2020', '12', 'Salary Deduction', '30-1991-2019', 'Denis C. Bermejo', '2019-04-06', 'unpaid', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `loantypetbl`
--

CREATE TABLE `loantypetbl` (
  `id` int(11) NOT NULL,
  `loantype` varchar(255) NOT NULL,
  `loanrange1` varchar(255) NOT NULL,
  `loanrange2` varchar(255) NOT NULL,
  `loanrange` varchar(255) NOT NULL,
  `months` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loantypetbl`
--

INSERT INTO `loantypetbl` (`id`, `loantype`, `loanrange1`, `loanrange2`, `loanrange`, `months`) VALUES
(2, 'emergency', '5000', '10000', 'member, employee, member-employee', '3'),
(3, 'business', '60000', '100000', 'member, member-employee', '12'),
(4, 'providential', '10000', '50000', 'member, member-employee', '6'),
(7, 'emergency', '5000', '10000', 'member, employee, member-employee', '3');

-- --------------------------------------------------------

--
-- Table structure for table `memberdetailstbl`
--

CREATE TABLE `memberdetailstbl` (
  `id` int(11) NOT NULL,
  `memberid` varchar(30) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `mname` varchar(255) NOT NULL,
  `bdate` varchar(255) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `address` varchar(300) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobileno` varchar(30) NOT NULL,
  `password` varchar(300) NOT NULL,
  `status` varchar(30) DEFAULT 'inactive',
  `regdate` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `sharecap` varchar(255) NOT NULL,
  `image` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `memberdetailstbl`
--

INSERT INTO `memberdetailstbl` (`id`, `memberid`, `fname`, `lname`, `mname`, `bdate`, `sex`, `address`, `email`, `mobileno`, `password`, `status`, `regdate`, `position`, `sharecap`, `image`) VALUES
(27, '27-1991-2019', 'Maria', 'Bermejo', 'Cruzada', '1999-02-10', 'Female', 'Paco, Manila', 'ma.paulettebermejo@gmail.com', '09279957087', '21232f297a57a5a743894a0e4a801fc3', 'active', '2019-03-04', 'employee', '-', 'img/defaultprofile.png'),
(28, '28-1991-2019', 'Maricar', 'Salazar', 'Ebreo', '1997-10-30', 'Female', 'Cavite Bacoor', 'maricarsalazar.ms@gmail.com', '0987654321', '21232f297a57a5a743894a0e4a801fc3', 'active', '2019-03-04', 'member', '0', 'img/defaultprofile.png'),
(29, '29-1991-2019', 'Ma. Teresa', 'Cruzada', 'Chavez', '1968-11-17', 'Female', 'Paco, Manila', 'cruzadama.teresa@gmail.com', '09279957087', '21232f297a57a5a743894a0e4a801fc3', 'active', '2019-03-26', 'employee-member', '0', 'img/defaultprofile.png'),
(30, '30-1991-2019', 'Denis', 'Bermejo', 'Caseres', '1972-11-25', 'Male', 'Paco, Manila', 'dhenber39@gmail.com', '09973806497', '21232f297a57a5a743894a0e4a801fc3', 'active', '2019-04-06', 'employee-member', '0', 'img/defaultprofile.png'),
(31, '31-1991-2019', 'Lowina', 'Fernando', 'Chavez', '1970-04-17', 'Female', 'Taytay, Rizal', 'lowina123@gmail.com', '09876543211', '21232f297a57a5a743894a0e4a801fc3', 'active', '2019-04-06', 'employee-member', '0', 'img/defaultprofile.png'),
(32, '32-1991-2019', 'Rafael', 'Cruzada', 'Chavez', '1965-04-18', 'Male', 'Pandacan, Manila', 'rafael123@gmail.com', '09876543217', '202cb962ac59075b964b07152d234b70', 'active', '2019-04-06', 'employee', '-', 'img/defaultprofile.png');

-- --------------------------------------------------------

--
-- Table structure for table `memberloandetailstbl`
--

CREATE TABLE `memberloandetailstbl` (
  `id` int(11) NOT NULL,
  `memberid` varchar(255) NOT NULL,
  `balance` varchar(255) NOT NULL,
  `applicationid` varchar(255) NOT NULL,
  `datetoday` varchar(255) NOT NULL,
  `currdeadline` varchar(255) NOT NULL,
  `status` varchar(30) NOT NULL,
  `delinquent` varchar(10) NOT NULL DEFAULT 'no',
  `datepaid` varchar(255) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `memberloandetailstbl`
--

INSERT INTO `memberloandetailstbl` (`id`, `memberid`, `balance`, `applicationid`, `datetoday`, `currdeadline`, `status`, `delinquent`, `datepaid`) VALUES
(16, '27-1991-2019', '5000', '27-03042019', '2019-04-09', '30/04/2019', 'ongoing', 'no', '0'),
(19, '30-1991-2019', '20000', '30-04062019', '2019-04-09', '30/05/2019', 'ongoing', 'no', '0'),
(20, '31-1991-2019', '65000', '31-04062019', '2019-04-07', '29/06/2019', 'ongoing', 'no', '0'),
(21, '32-1991-2019', '10000', '32-04062019', '2019-04-09', '30/05/2019', 'ongoing', 'no', '0');

-- --------------------------------------------------------

--
-- Table structure for table `notiftbl`
--

CREATE TABLE `notiftbl` (
  `id` int(11) NOT NULL,
  `memberfrom` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` varchar(1000) NOT NULL,
  `details` varchar(255) NOT NULL,
  `memberto` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notiftbl`
--

INSERT INTO `notiftbl` (`id`, `memberfrom`, `date`, `title`, `message`, `details`, `memberto`, `status`) VALUES
(9, 'Admin', 'Mar-04-2019 08:06:29 AM', 'Account Activated', 'Your Account Successfully VERIFIED! You can now start your Transactions.', '', '27-1991-2019', 'unread'),
(10, 'Admin', 'Mar-04-2019 08:12:15 AM', 'Account Activated', 'Your Account Successfully VERIFIED! You can now start your Transactions.', '', '28-1991-2019', 'unread'),
(11, '27-1991-2019', 'Mar-04-2019 08:13:44 AM', 'Co-Maker', 'Good Day ! Maricar C. Salazar. Maria C. Bermejo wants you to be  Co-Maker. ', '27-03042019', '28-1991-2019', 'unread'),
(12, '28-1991-2019', 'Mar-04-2019 08:19:12 AM', 'Approved Co-Maker', 'Good Day ! Maria C. Bermejo. Maricar C. Salazar approved your request for Co-Maker. Wait for the approval of the Admin and Chairman for your Request.!', '27-03042019', '27-1991-2019', 'unread'),
(13, 'Admin', 'Mar-04-2019 08:19:22 AM', 'Account Activated', 'Your Account Successfully VERIFIED! You can now start your Transactions.', '', '28-1991-2019', 'unread'),
(14, 'Admin', 'Mar-04-2019 08:20:07 AM', 'Admin Approved', 'Good Day ! Maria C. Bermejo. Your Request Have been approved by the Admin. Wait for the Approval of the Chairman.', '27-03042019', '27-1991-2019', 'unread'),
(15, '27-1991-2019', 'Mar-04-2019 08:20:25 AM', 'Co-Maker', 'Good Day ! .  wants you to be  Co-Maker. ', '27-03042019', '28-1991-2019', 'unread'),
(16, 'Admin', 'Mar-26-2019 04:46:59 AM', 'Account Activated', 'Your Account Successfully VERIFIED! You can now start your Transactions.', '', '29-1991-2019', 'unread'),
(17, 'Admin', 'Apr-06-2019 05:32:15 AM', 'Account Activated', 'Your Account Successfully VERIFIED! You can now start your Transactions.', '', '30-1991-2019', 'unread'),
(18, '30-1991-2019', 'Apr-06-2019 05:34:01 AM', 'Co-Maker', 'Good Day ! Ma. Teresa C. Cruzada. Denis C. Bermejo wants you to be  Co-Maker. ', '30-04062019', '29-1991-2019', 'unread'),
(19, 'Admin', 'Apr-06-2019 05:39:51 AM', 'Account Activated', 'Your Account Successfully VERIFIED! You can now start your Transactions.', '', '31-1991-2019', 'unread'),
(20, 'Admin', 'Apr-06-2019 05:39:54 AM', 'Account Activated', 'Your Account Successfully VERIFIED! You can now start your Transactions.', '', '32-1991-2019', 'unread'),
(21, '32-1991-2019', 'Apr-06-2019 06:42:57 AM', 'Co-Maker', 'Good Day ! Lowina C. Fernando. Rafael C. Cruzada wants you to be  Co-Maker. ', '32-04062019', '31-1991-2019', 'unread'),
(22, '31-1991-2019', 'Apr-06-2019 06:43:42 AM', 'Approved Co-Maker', 'Good Day ! Rafael C. Cruzada. Lowina C. Fernando approved your request for Co-Maker. Wait for the approval of the Admin and Chairman for your Request.!', '32-04062019', '32-1991-2019', 'unread'),
(23, '31-1991-2019', 'Apr-06-2019 06:44:39 AM', 'Co-Maker', 'Good Day ! Denis C. Bermejo. Lowina C. Fernando wants you to be  Co-Maker. ', '31-04062019', '30-1991-2019', 'unread'),
(24, '30-1991-2019', 'Apr-06-2019 06:46:54 AM', 'Approved Co-Maker', 'Good Day ! Lowina C. Fernando. Denis C. Bermejo approved your request for Co-Maker. Wait for the approval of the Admin and Chairman for your Request.!', '31-04062019', '31-1991-2019', 'unread'),
(25, 'Admin', 'Apr-07-2019 04:19:12 PM', 'Admin Approved', 'Good Day ! Lowina C. Fernando. Your Request Have been approved by the Admin. Wait for the Approval of the Chairman.', '31-04062019', '31-1991-2019', 'unread'),
(26, '', 'Apr-07-2019 04:25:48 PM', 'Loan Request Approved', 'Good Day ! . Happy to inform you that your loan request have been approved by the Chairperson. Please avoid delay of payment!', '31-04062019', '31-1991-2019', 'unread'),
(27, 'Admin', 'Apr-09-2019 01:12:20 PM', 'Admin Approved', 'Good Day ! Rafael C. Cruzada. Your Request Have been approved by the Admin. Wait for the Approval of the Chairman.', '32-04062019', '32-1991-2019', 'unread'),
(28, '', 'Apr-09-2019 01:12:41 PM', 'Loan Request Approved', 'Good Day ! . Happy to inform you that your loan request have been approved by the Chairperson. Please avoid delay of payment!', '32-04062019', '32-1991-2019', 'unread'),
(29, '28-1991-2019', 'Apr-09-2019 03:33:40 PM', 'Approved Co-Maker', 'Good Day ! Maria C. Bermejo. Maricar C. Salazar approved your request for Co-Maker. Wait for the approval of the Admin and Chairman for your Request.!', '27-03042019', '27-1991-2019', 'unread'),
(30, 'Admin', 'Apr-09-2019 03:33:52 PM', 'Admin Approved', 'Good Day ! Maria C. Bermejo. Your Request Have been approved by the Admin. Wait for the Approval of the Chairman.', '27-03042019', '27-1991-2019', 'unread'),
(31, '', 'Apr-09-2019 03:34:03 PM', 'Loan Request Approved', 'Good Day ! . Happy to inform you that your loan request have been approved by the Chairperson. Please avoid delay of payment!', '27-03042019', '27-1991-2019', 'unread'),
(32, '29-1991-2019', 'Apr-09-2019 03:35:11 PM', 'Approved Co-Maker', 'Good Day ! Denis C. Bermejo. Ma. Teresa C. Cruzada approved your request for Co-Maker. Wait for the approval of the Admin and Chairman for your Request.!', '30-04062019', '30-1991-2019', 'unread'),
(33, 'Admin', 'Apr-09-2019 03:35:23 PM', 'Admin Approved', 'Good Day ! Denis C. Bermejo. Your Request Have been approved by the Admin. Wait for the Approval of the Chairman.', '30-04062019', '30-1991-2019', 'unread'),
(34, '', 'Apr-09-2019 03:35:34 PM', 'Loan Request Approved', 'Good Day ! . Happy to inform you that your loan request have been approved by the Chairperson. Please avoid delay of payment!', '30-04062019', '30-1991-2019', 'unread');

-- --------------------------------------------------------

--
-- Table structure for table `viewloantbl`
--

CREATE TABLE `viewloantbl` (
  `id` int(25) NOT NULL,
  `memberid` varchar(255) NOT NULL,
  `loanrequestid` varchar(255) NOT NULL,
  `appmonth` varchar(255) NOT NULL,
  `duedate` varchar(255) NOT NULL,
  `amortization` varchar(255) NOT NULL,
  `principal` varchar(255) NOT NULL,
  `interest` varchar(255) NOT NULL,
  `balance` varchar(255) NOT NULL,
  `paymentstatus` varchar(255) NOT NULL DEFAULT 'unpaid'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `viewloantbl`
--

INSERT INTO `viewloantbl` (`id`, `memberid`, `loanrequestid`, `appmonth`, `duedate`, `amortization`, `principal`, `interest`, `balance`, `paymentstatus`) VALUES
(4, '27-1991-2019', '27-03042019', 'April', '30/04/2019', '2600', '2500', '100', '5000', 'unpaid'),
(5, '27-1991-2019', '27-03042019', 'May', '30/05/2019', '2550', '2500', '50', '2500', 'unpaid'),
(6, '30-1991-2019', '30-04062019', 'May', '30/05/2019', '5400', '5000', '400', '20000', 'unpaid'),
(7, '30-1991-2019', '30-04062019', 'June', '29/06/2019', '5300', '5000', '300', '15000', 'unpaid'),
(8, '30-1991-2019', '30-04062019', 'July', '29/07/2019', '5200', '5000', '200', '10000', 'unpaid'),
(9, '30-1991-2019', '30-04062019', 'August', '28/08/2019', '5100', '5000', '100', '5000', 'unpaid'),
(10, '32-1991-2019', '32-04062019', 'May', '30/05/2019', '3533.33', '3333.33', '200', '10000', 'unpaid'),
(11, '32-1991-2019', '32-04062019', 'June', '29/06/2019', '3466.66', '3333.33', '133.33', '6666.67', 'unpaid'),
(12, '32-1991-2019', '32-04062019', 'July', '29/07/2019', '3400', '3333.33', '66.67', '3333.34', 'unpaid'),
(13, '31-1991-2019', '31-04062019', 'June', '29/06/2019', '6716.67', '5416.67', '1300', '65000', 'unpaid'),
(14, '31-1991-2019', '31-04062019', 'July', '29/07/2019', '6608.34', '5416.67', '1191.67', '59583.33', 'unpaid'),
(15, '31-1991-2019', '31-04062019', 'August', '28/08/2019', '6500', '5416.67', '1083.33', '54166.66', 'unpaid'),
(16, '31-1991-2019', '31-04062019', 'September', '27/09/2019', '6391.67', '5416.67', '975', '48749.99', 'unpaid'),
(17, '31-1991-2019', '31-04062019', 'October', '27/10/2019', '6283.34', '5416.67', '866.67', '43333.32', 'unpaid'),
(18, '31-1991-2019', '31-04062019', 'November', '26/11/2019', '6175', '5416.67', '758.33', '37916.65', 'unpaid'),
(19, '31-1991-2019', '31-04062019', 'December', '26/12/2019', '6066.67', '5416.67', '650', '32499.98', 'unpaid'),
(20, '31-1991-2019', '31-04062019', 'January', '25/01/2020', '5958.34', '5416.67', '541.67', '27083.31', 'unpaid'),
(21, '31-1991-2019', '31-04062019', 'February', '24/02/2020', '5850', '5416.67', '433.33', '21666.64', 'unpaid'),
(22, '31-1991-2019', '31-04062019', 'March', '25/03/2020', '5741.67', '5416.67', '325', '16249.97', 'unpaid'),
(23, '31-1991-2019', '31-04062019', 'April', '24/04/2020', '5633.34', '5416.67', '216.67', '10833.3', 'unpaid'),
(24, '31-1991-2019', '31-04062019', 'May', '24/05/2020', '5525', '5416.67', '108.33', '5416.63', 'unpaid');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dashboardlogintbl`
--
ALTER TABLE `dashboardlogintbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loanrequesttbl`
--
ALTER TABLE `loanrequesttbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loantypetbl`
--
ALTER TABLE `loantypetbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `memberdetailstbl`
--
ALTER TABLE `memberdetailstbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `memberloandetailstbl`
--
ALTER TABLE `memberloandetailstbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notiftbl`
--
ALTER TABLE `notiftbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `viewloantbl`
--
ALTER TABLE `viewloantbl`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dashboardlogintbl`
--
ALTER TABLE `dashboardlogintbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `loanrequesttbl`
--
ALTER TABLE `loanrequesttbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `loantypetbl`
--
ALTER TABLE `loantypetbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `memberdetailstbl`
--
ALTER TABLE `memberdetailstbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `memberloandetailstbl`
--
ALTER TABLE `memberloandetailstbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `notiftbl`
--
ALTER TABLE `notiftbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `viewloantbl`
--
ALTER TABLE `viewloantbl`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
