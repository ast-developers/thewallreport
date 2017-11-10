<?php namespace flow\tabs;
if ( ! defined( 'WPINC' ) ) die;

//use la\core\tabs\LATab;

/**
 * FlowFlowAds.
 *
 * @package   FlowFlowAds
 * @author    Looks Awesome <email@looks-awesome.com>
 *
 * @link      http://looks-awesome.com
 * @copyright 2014-2016 Looks Awesome
 */
class FFAdsTab implements LATab {
	public function __construct() {
	}

	public function id() {
		return 'ads-tab';
	}

	public function flaticon() {
		return 'flaticon-data';
	}

	public function title() {
		return 'Campaigns';
	}

	public function includeOnce( $context ) {
		include_once($context['root']  . 'views/ads.php');
	}
}