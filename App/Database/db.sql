/* 11 Sept 2017 */
DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

insert  into `roles`(`id`,`name`,`status`,`created_at`,`updated_at`) values (1,'Admin','1','2017-09-11 15:26:14','2017-09-11 15:26:14'),(2,'Editors','1','2017-09-11 15:26:14','2017-09-11 15:26:14');

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `nick_name` varchar(255) DEFAULT NULL,
  `role_id` int(11) unsigned NOT NULL,
  `avatar_image_id` int(11) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

insert  into `users`(`id`,`username`,`password`,`email`,`first_name`,`last_name`,`nick_name`,`role_id`,`avatar_image_id`,`created_at`,`updated_at`) values (1,'thewall','e10adc3949ba59abbe56e057f20f883e','admin@thewall.com','admin',NULL,NULL,1,NULL,'2017-09-11 15:42:14','2017-09-11 16:05:20');