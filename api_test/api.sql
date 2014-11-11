# MySQL-Front Dump 2.1
#
# Host: localhost   Database: api
#--------------------------------------------------------
# Server version 3.23.52-nt


#
# Table structure for table 'payment'
#

CREATE TABLE `payment` (
  `PaymentID` int(11) NOT NULL auto_increment,
  `PaymentResult` varchar(16) default NULL,
  `PaymentApCode` varchar(16) default NULL,
  `PaymentAmt` varchar(16) default NULL,
  `PaymentMethod` char(2) default NULL,
  `PaymentDate` timestamp(14) NOT NULL,
  `PaymentInvoice` varchar(16) default NULL,
  `PaymentStatus` char(2) default NULL,
  PRIMARY KEY  (`PaymentID`),
  UNIQUE KEY `PaymentID` (`PaymentID`),
  KEY `PaymentID_2` (`PaymentID`)
) TYPE=MyISAM;

