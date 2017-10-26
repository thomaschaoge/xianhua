/*
SQLyog 企业版 - MySQL GUI v7.14 
MySQL - 5.0.51b-community-nt-log : Database - lamp18_shop
*********************************************************************
*/


DROP TABLE IF EXISTS `detail`;

CREATE TABLE `detail` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `orderid` int(11) unsigned default NULL,
  `goodsid` int(11) unsigned default NULL,
  `name` varchar(32) default NULL,
  `price` double(6,2) default NULL,
  `num` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `detail` */

/*Table structure for table `goods` */

DROP TABLE IF EXISTS `goods`;

CREATE TABLE `goods` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `typeid` int(11) unsigned default NULL,
  `goods` varchar(32) default NULL,
  `company` varchar(50) default NULL,
  `descr` text,
  `price` double(6,2) default NULL,
  `picname` varchar(255) default NULL,
  `state` tinyint(1) default '1',
  `store` int(11) unsigned default '0',
  `num` int(11) unsigned default '0',
  `clicknum` int(11) unsigned default '0',
  `addtime` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `typeid` (`typeid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `goods` */

/*Table structure for table `orders` */

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `uid` int(11) unsigned default NULL,
  `linkman` varchar(32) default NULL,
  `address` varchar(255) default NULL,
  `code` char(6) default NULL,
  `phone` varchar(16) default NULL,
  `addtime` int(11) unsigned default NULL,
  `total` double(8,2) default NULL,
  `status` tinyint(4) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `orders` */

/*Table structure for table `type` */

DROP TABLE IF EXISTS `type`;

CREATE TABLE `type` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(32) default NULL,
  `pid` int(11) unsigned default '0',
  `path` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `type` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `username` varchar(32) NOT NULL,
  `name` varchar(16) default NULL,
  `pass` char(32) NOT NULL,
  `sex` tinyint(1) default NULL,
  `address` varchar(255) default NULL,
  `code` char(6) default NULL,
  `phone` varchar(16) default NULL,
  `email` varchar(50) NOT NULL,
  `state` tinyint(1) default '1',
  `addtime` int(11) unsigned default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`name`,`pass`,`sex`,`address`,`code`,`phone`,`email`,`state`,`addtime`) values (1,'admin','管理员','21232f297a57a5a743894a0e4a801fc3',1,'wu','100086','12345678901','admin@126.com',0,1234567809);

