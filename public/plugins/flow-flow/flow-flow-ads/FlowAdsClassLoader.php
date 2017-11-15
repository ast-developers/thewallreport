<?php if ( ! defined( 'WPINC' ) ) die;
/**
 * FlowFlowAds.
 *
 * @package   FlowFlowAds
 * @author    Looks Awesome <email@looks-awesome.com>
 *
 * @link      http://looks-awesome.com
 * @copyright 2014-2016 Looks Awesome
 */

class FlowAdsClassLoader {
	private $root;

	public function __construct($root) {
		$this->root = $root;
	}

	public function loadClass($className) {

        if (0 === strpos($className, 'flowads\\')){
			$path = $this->root . 'includes';
			$cls = str_replace('flowads', $path, $className);
			$path = str_replace('\\', DIRECTORY_SEPARATOR, $cls) . '.php';
			/** @noinspection PhpIncludeInspection */
			require_once($path);
		}
	}
} 