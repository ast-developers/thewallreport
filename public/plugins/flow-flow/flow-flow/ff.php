<?php
/**
 * Flow-Flow
 *
 * Plugin class. This class should ideally be used to work with the
 * public-facing side of the site.
 *
 * If you're interested in introducing administrative or dashboard
 * functionality, then refer to `FlowFlowAdmin.php`
 *
 * @package   FlowFlow
 * @author    Looks Awesome <email@looks-awesome.com>

 * @link      http://looks-awesome.com
 * @copyright 2015 Looks Awesome
 */
session_start();

require_once( dirname($_SERVER["SCRIPT_FILENAME"]) . '/LAClassLoader.php' );
LAClassLoader::get(dirname($_SERVER["SCRIPT_FILENAME"]) . '/')->register(true);

if (isset($_REQUEST['action'])){
	$context = ff_get_context();
	/** @var \flow\db\FFDBManager $db */
	$db = $context['db_manager'];

	$ff = flow\FlowFlow::get_instance($context);

	switch ($_REQUEST['action']) {
		case 'fetch_posts':
			$ff->processAjaxRequest();
			break;
		case 'load_cache':
			$ff->processAjaxRequestBackground();
			break;
		case 'refresh_cache':
			if (false !== ($time = $db->getOption('bg_task_time'))){
				if (time() > $time + 60){
					$ff->refreshCache();
					$time = time();
					$db->setOption('bg_task_time', $time);
					echo 'new cache time: ' . $time;
				}
			} else  $db->setOption('bg_task_time', time());
			break;
		case 'flow_flow_save_stream_settings':
			$db->save_stream_settings();
			break;
		case 'flow_flow_get_stream_settings':
			$db->get_stream_settings();
			break;
		case 'flow_flow_save_sources_settings':
			$db->save_sources_settings();
			break;
		case 'flow_flow_ff_save_settings':
			$db->ff_save_settings_fn();
			break;
		case 'flow_flow_create_stream':
			$db->create_stream();
			break;
		case 'flow_flow_clone_stream':
			$db->clone_stream();
			break;
		case 'flow_flow_delete_stream':
			$db->delete_stream();
			break;
		case 'moderation_apply_action':
			$ff->moderation_apply();
			break;
		case 'flow_flow_social_auth':
			$db->social_auth();
			break;
        case 'featured_post_apply_action':
            $db->updatePostFeaturedFlag();
            break;
        case 'post_display_action':
            $db->updatePostActiveFlag();
            break;
		case 'flow_flow_save_campaign':
			\flow\db\FFDBAds::saveAd($campaign = $_POST['campaign']);
			break;
		case 'flow_flow_get_campaign':
			$ad = \flow\db\FFDBAds::getAd($id = $_GET['id']);
			echo json_encode( $ad );
			die();
			break;
		case 'flow_flow_delete_campaign':
			\flow\db\FFDBAds::deleteAd($id = $_POST['id']);
			break;
		case 'flow_flow_clone_campaign':
			\flow\db\FFDBAds::cloneAd($id = $_POST['id']);
			break;
		case 'flow_flow_show_preview':
			echo flow\FlowFlow::get_instance()->renderShortCode(array('id' => $_GET['stream-id'], 'preview' => true));
			die();
			break;
        case 'flow_flow_ad_action':
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
            break;
		default:
			if (strpos($_REQUEST['action'], "backup") !== false) {
				define('FF_SNAPSHOTS_TABLE_NAME', DB_TABLE_PREFIX . 'ff_snapshots');
				$snapshotManager = new flow\settings\FFSnapshotManager($context);
				$snapshotManager->processAjaxRequest();
			}
			break;
	}
}
die;