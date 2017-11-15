<?php if ( ! defined( 'WPINC' ) ) die;
/**
 * @package   Flow_Flow_Ads
 * @author    Looks Awesome <hello@looks-awesome.com>

 * @link      http://looks-awesome.com
 * @copyright 2014-2016 Looks Awesome
 *
 * @wordpress-plugin
 * Plugin Name:       Flow-Flow: Branding & Advertisement
 * Plugin URI:        flow.looks-awesome.com
 * Description:       Extension for Flow-Flow Social Stream
 * Version:           1.3
 * Author:            Looks Awesome
 * Author URI:        looks-awesome.com
 * Text Domain:       flow-flow-ads
 * Domain Path:       /languages
 */

if (!class_exists('FlowAdsClassLoader')){
    require_once( realpath(dirname(__FILE__)) . '/' . 'FlowAdsClassLoader.php' );
	spl_autoload_register(array(new FlowAdsClassLoader(realpath(dirname(__FILE__)) . '/' ), 'loadClass'));

}

if (!defined('FF_ADS_VERSION')) define('FF_ADS_VERSION', '1.2.1');

add_action('init', function(){
	if( !session_id() ) session_start();
});

add_action('ff_addon_loaded', function(){
	add_filter('ff_plugin_dependencies', function($dependencies){
		$dependencies[] = 'ads';
		return $dependencies;
	});

	if (defined('DOING_AJAX') && DOING_AJAX) {

		// ajax endpoints
		add_action( 'wp_ajax_flow_flow_save_campaign',  function(){
			flowads\db\FFDBAds::saveAd($campaign = $_POST['campaign']);
		} );

		add_action( 'wp_ajax_flow_flow_get_campaign',  function(){
			$ad = flowads\db\FFDBAds::getAd($id = $_GET['id']);
			echo json_encode( $ad );
			die();
		} );

		add_action( 'wp_ajax_flow_flow_delete_campaign',  function(){
			flowads\db\FFDBAds::deleteAd($id = $_POST['id']);
		} );

		add_action( 'wp_ajax_flow_flow_clone_campaign',  function(){
			flowads\db\FFDBAds::cloneAd($id = $_POST['id']);
		} );

		add_action( 'wp_ajax_flow_flow_show_preview',  function(){
			echo flow\FlowFlow::get_instance()->renderShortCode(array('id' => $_GET['stream-id'], 'preview' => true));
			die();
		} );

		function ff_ad_action(){
			if (isset($_REQUEST['id'])){

				$context = ff_get_context();
				/** @var \flow\db\FFDBManager $db */
				$db = $context['db_manager'];
				$prefix = $db->table_prefix;
				if ($_REQUEST['status'] && $_REQUEST['status'] == 'view') {
					flow\db\FFDB::conn()->query('UPDATE ?n SET views = views + 1 WHERE id IN (?a)', $prefix . 'ads_elements', $_REQUEST['id']);
				}
				else {
					$id = substr($_REQUEST['id'], 6);
					flow\db\FFDB::conn()->query('UPDATE ?n SET `clicks` = `clicks` + 1 WHERE `id` = ?i', $prefix . 'ads_elements', $id);
				}
			}
            echo json_encode('action tracking attempted');
			die();
		}
		add_action( 'wp_ajax_flow_flow_ad_action', 'ff_ad_action');
		add_action( 'wp_ajax_nopriv_flow_flow_ad_action', 'ff_ad_action');

		add_filter('ff_build_public_response', array('flowads\\db\\FFDBAds', 'buildPublicResponse'), 100, 8);

		add_action('ff_after_delete_stream', array('flowads\\db\\FFDBAds', 'removeStream'), 100);
	}
	else {
		flowads\db\FFDBAds::init();

		if (is_admin()){
			add_action('ff_enqueue_admin_resources_only_at_plugin_page', function(){
				$path = plugins_url() . '/flow-flow-ads/';
				wp_enqueue_style(  'flow-flow-ads-admin-styles', $path . 'css/ff_ads_admin.css', array(), FF_ADS_VERSION );
				wp_enqueue_script( 'flow-flow-builder-script', $path . 'js/ff_admin_editor.js', array(), FF_ADS_VERSION );
				wp_enqueue_script( 'flow-flow-ads-admin-script', $path . 'js/ff_ads_admin.js', array( 'jquery' ), FF_ADS_VERSION );
				wp_enqueue_media();
			});

			add_filter('ff_change_context', function($context){
				array_splice( $context['tabs'], 2, 0, array(new flowads\tabs\FFAdsTab()) );
				$context['ads_root'] = realpath(dirname(__FILE__)) . '/' ;
				$context['ads'] = flowads\db\FFDBAds::getAds();
				return $context;
			});
		}
		else {
			add_action('ff_add_view_action', function($stream){
				echo "if (FlowFlowOpts.dependencies['ads'] && response['ads']){
	                var deferred = jQuery.post(opts.ajaxurl, {
		                'action'  : 'flow_flow_ad_action',
		                'status'  : 'view',
			            'id' : response['ads']
	                });
	                $.when( deferred ).always(function(data) {});
                }";
			}, '', 1);
		}
	}
});