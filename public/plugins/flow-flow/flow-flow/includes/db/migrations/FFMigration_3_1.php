<?php namespace flow\db\migrations;
use flow\db\FFDB;
use flow\db\FFDBMigration;

if ( ! defined( 'WPINC' ) ) die;
/**
 * FlowFlow.
 *
 * @package   FlowFlow
 * @author    Looks Awesome <email@looks-awesome.com>
 *
 * @link      http://looks-awesome.com
 * @copyright 2014-2016 Looks Awesome
 */
class FFMigration_3_1 implements FFDBMigration {

	public function version() {
		return '3.1';
	}

	public function execute($conn, $manager) {

		/** @var FFDBManager $db */
		$db = $manager;
		$table_name = $db->table_prefix . 'ads_campaigns';
		if (!FFDB::existTable($table_name)){
			$charset = FFDB::charset();
			if ( !empty( $charset ) ) {
				$charset = " CHARACTER SET {$charset}";
			}

			$sql = "
			CREATE TABLE `" . $table_name . "`
			(
				`id` INT NOT NULL AUTO_INCREMENT,
				`name` VARCHAR(250),
				`adsenseClient` VARCHAR(100),
				`status` INT NOT NULL,
				`start` BIGINT NOT NULL,
				`end` BIGINT NOT NULL,
				`firstAdIndex` INT default 1,
				`adsDistrubution` INT default 1,
				`randomize` VARCHAR(5) default 'nope',
				PRIMARY KEY (`id`)
			){$charset}";
			$conn->query($sql);
		}

		$table_name = $db->table_prefix . 'ads_streams';
		if (!FFDB::existTable($table_name)){
			$charset = FFDB::charset();
			if ( !empty( $charset ) ) {
				$charset = " CHARACTER SET {$charset}";
			}

			$sql = "
			CREATE TABLE `" . $table_name . "`
			(
				`id` INT NOT NULL AUTO_INCREMENT,
				`campaign` INT NOT NULL,
				`stream` INT NOT NULL,
				PRIMARY KEY (`id`)
			){$charset}";
			$conn->query($sql);
		}

		$table_name = $db->table_prefix . 'ads_elements';
		if (!FFDB::existTable($table_name)){
			$charset = FFDB::charset();
			if ( !empty( $charset ) ) {
				$charset = " CHARACTER SET {$charset}";
			}

			$sql = "
			CREATE TABLE `" . $table_name . "`
			(
				`id` INT NOT NULL AUTO_INCREMENT,
				`campaign` INT NOT NULL,
				`enabled` VARCHAR(10),
                `name` VARCHAR(250),
                `type` VARCHAR(50),
                `label` VARCHAR(50),
                `labelTxt` VARCHAR(250),
                `labelCol` VARCHAR(50),
                `height` INT NOT NULL DEFAULT 200,
                `textCol` VARCHAR(50),
                `cardBG` VARCHAR(50),
                `link` VARCHAR(250),
                `slot` VARCHAR(20),
                `views` INT NOT NULL DEFAULT 0,
                `clicks` INT NOT NULL DEFAULT 0,
                `content` BLOB NULL,
                `order` INT NOT NULL DEFAULT 0,
				PRIMARY KEY (`id`)
			){$charset}";
			$conn->query($sql);
		}

	}
}