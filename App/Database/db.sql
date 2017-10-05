/* 11 Sept 2017 */
DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `status` ENUM('0','1') NOT NULL DEFAULT '0',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

insert  into `roles`(`id`,`name`,`status`,`created_at`,`updated_at`) values (1,'Admin','1','2017-09-11 15:26:14','2017-09-11 15:26:14'),(2,'Editors','1','2017-09-11 15:26:14','2017-09-11 15:26:14');

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `first_name` VARCHAR(255) DEFAULT NULL,
  `last_name` VARCHAR(255) DEFAULT NULL,
  `nick_name` VARCHAR(255) DEFAULT NULL,
  `role_id` INT(11) UNSIGNED NOT NULL,
  `avatar_image_id` INT(11) UNSIGNED DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

insert  into `users`(`id`,`username`,`password`,`email`,`first_name`,`last_name`,`nick_name`,`role_id`,`avatar_image_id`,`created_at`,`updated_at`) values (1,'thewall','e10adc3949ba59abbe56e057f20f883e','admin@thewall.com','admin',NULL,NULL,1,NULL,'2017-09-11 15:42:14','2017-09-11 16:05:20');

/* 13 Sept 2017 */

DROP TABLE IF EXISTS `password_reminders`;

CREATE TABLE `password_reminders` (
  `email` varchar(255) CHARACTER SET latin1 NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* 14 Sept 2017 */

ALTER TABLE `users` ADD `profile_image` VARCHAR(255) NULL DEFAULT NULL AFTER `role_id`;

/* 20 Sept 2017 */

CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `status` enum('pending','draft') NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_by` int(11) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

CREATE TABLE `post_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `post_category_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `post_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `post_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  KEY `tag_id` (`tag_id`),
  CONSTRAINT `post_tag_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `post_tag_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* 21 Sep 2017 */

CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `status` enum('pending','draft') NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_by` int(11) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `pages_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* 22 Sep 2017  */

CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` enum('1','2','3') NOT NULL,
  `link` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `menu` ADD COLUMN `status` ENUM('active','inactive') DEFAULT 'active' NOT NULL AFTER `sort_order`;
ALTER TABLE `menu` ADD `new_tab` ENUM('0','1') NOT NULL DEFAULT '0' AFTER `status`;

/* 25 Sept 2017 */

ALTER TABLE `pages` CHANGE `status` `status` ENUM('pending','draft','publish') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE `pages` ADD `featured_image` VARCHAR(255) NULL AFTER `slug`, ADD `views` INT(11) NOT NULL DEFAULT '0' AFTER `featured_image`;
ALTER TABLE `pages` ADD `published_at` DATETIME NULL AFTER `updated_at`;

ALTER TABLE `posts` CHANGE `status` `status` ENUM('pending','draft','publish') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE `posts` ADD `featured_image` VARCHAR(255) NULL AFTER `slug`, ADD `views` INT(11) NOT NULL DEFAULT '0' AFTER `featured_image`;
ALTER TABLE `posts` ADD `published_at` DATETIME NULL AFTER `updated_at`;

/*
* 3 Oct 2017
* Add featured and is_active flags for the feed posts in flow flow
*/
ALTER TABLE `ff_posts` ADD `featured` BOOLEAN NULL DEFAULT 0 AFTER `post_additional`, ADD `is_active` BOOLEAN NULL DEFAULT 1 AFTER `featured`;

/*
* 4 Oct 2017
* Roles and Permission
 */
DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `section` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varbinary(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `permissions` */

insert  into `permissions`(`id`,`section`,`name`,`value`) values (1,'user','Add User','add_user'),(2,'user','Edit User','edit_user'),(3,'user','Delete User','delete_user'),(4,'user','List User','list_user'),(5,'post','Add Post','add_post'),(6,'post','Edit Post','edit_post'),(7,'post','Delete Post','delete_post'),(8,'post','List Post','list_post'),(9,'post_category','Add Category','add_category'),(10,'post_category','Edit Category','edit_category'),(11,'post_category','Delete Category','delete_category'),(12,'post_category','List Category','list_category'),(13,'page','Add Page','add_page'),(14,'page','Edit Page','edit_page'),(15,'page','Delete Page','delete_page'),(16,'page','List Page','list_page'),(17,'menu','Add Menu','add_menu'),(18,'menu','Edit Menu','edit_menu'),(19,'menu','Delete Menu','delete_menu'),(20,'menu','List Menu','list_menu'),(21,'flow_flow','Manage Flow Flow Plugin','manage_flow_flow');

/*Table structure for table `role_permission` */

DROP TABLE IF EXISTS `role_permission`;

CREATE TABLE `role_permission` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(11) unsigned NOT NULL,
  `permission_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  KEY `permission_id` (`permission_id`),
  CONSTRAINT `role_permission_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_permission_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `role_permission` */

insert  into `role_permission`(`id`,`role_id`,`permission_id`) values (1,1,1),(2,1,2),(3,1,3),(4,1,4),(5,1,5),(6,1,6),(7,1,7),(8,1,8),(9,1,9),(10,1,10),(12,1,11),(13,1,12),(14,1,13),(15,1,14),(16,1,15),(17,1,16),(18,1,17),(19,1,18),(20,1,19),(21,1,20),(22,1,21),(23,2,5),(24,2,6),(26,2,8),(27,2,13),(28,2,14),(30,2,16);

/* 4 Oct 2017
Add Advertisement table
*/

CREATE TABLE `advertise` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` enum('banner','adsense') NOT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `adsense_code` text,
  `status` enum('active','inactive') NOT NULL,
  `position` enum('left','right','center') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8