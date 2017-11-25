<?php namespace flowads\db;

use flow\db\FFDB;
use flow\db\FFDBManager;
use flow\settings\FFSettingsUtils;

if ( ! defined( 'WPINC' ) ) die;

if (!defined('FF_ADS_BIG_INT')) define('FF_ADS_BIG_INT', 9223372036854775807);

/**
 * Flow-Flow-Ads.
 *
 * @package   FlowFlowAds
 * @author    Looks Awesome <email@looks-awesome.com>

 * @link      http://looks-awesome.com
 * @copyright 2014-2016 Looks Awesome
 */
class FFDBAds {
	public static $statuses = array('draft', 'published', 'live', 'pause', 'finished');

	public static function init(){
		global $flow_flow_context;
		/** @var FFDBManager $db */
		$db = $flow_flow_context['db_manager'];
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
			FFDB::conn()->query($sql);
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
			FFDB::conn()->query($sql);
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
			FFDB::conn()->query($sql);
		}
	}

	public static function getAds(){
		$ads = array();
		global $flow_flow_context;
		/** @var FFDBManager $db */
		$db = $flow_flow_context['db_manager'];
		if (false !== ($result = FFDB::conn()->getAll('SELECT ca.`id`, ca.`name`, ca.`status`, ca.`start`, ca.`end`, el2.`views`, el2.`clicks`
			FROM ?n ca LEFT JOIN (SELECT el.campaign, sum(el.views) as views, sum(el.clicks) as clicks FROM ?n el GROUP BY el.campaign) as el2 ON el2.campaign = ca.id ORDER BY ca.`id`',
				$db->table_prefix . 'ads_campaigns', $db->table_prefix . 'ads_elements'))){
			foreach ( $result as $ad ) {
				$curr = new \stdClass();
				$curr->id = $ad['id'];
				$curr->name = $ad['name'];
				$curr->start = $ad['start'];
				$curr->end = $ad['end'];
				$curr->status = $ad['status'];
				$curr->readableStatus = self::getReadableStatus($curr);
				$curr->nextReadableStatus = self::getNextReadableStatus($curr);
				$curr->end = FF_ADS_BIG_INT == $ad['end'] ? '0' : $ad['end'];
				$curr->views = $ad['views'] == null ? 0 : (int)$ad['views'];
				$curr->clicks = $ad['clicks'] == null ? 0 : (int)$ad['clicks'];
				$curr->conversion = ($curr->clicks != 0 && $curr->views != 0)? round(  ($curr->clicks * 100) / $curr->views , 2) : 0;
				$ads[] = $curr;
			}
		}
		return $ads;
	}

    public static function getAd($id){
	    global $flow_flow_context;
	    /** @var FFDBManager $db */
	    $db = $flow_flow_context['db_manager'];
	    $table_name = $db->table_prefix . 'ads_campaigns';
	    if (false !== ($ad = FFDB::conn()->getRow('SELECT `id`, `name`, `status`, `start`, `end`, `adsenseClient`, `firstAdIndex`, `adsDistrubution`, `randomize` FROM ?n WHERE `id` = ?s',
			    $table_name, $id))) {
		    $curr               = new \stdClass();
		    $curr->id           = $ad['id'];
		    $curr->name         = $ad['name'];
		    $curr->status       = $ad['status'];
		    $curr->start        = $ad['start'];
		    $curr->end          = $ad['end'];
		    $curr->readableStatus = self::getReadableStatus($curr);
		    $curr->nextReadableStatus = self::getNextReadableStatus($curr);
		    $curr->end          = FF_ADS_BIG_INT == $ad['end'] ? '0' : $ad['end'];
		    $curr->firstAdIndex = $ad['firstAdIndex'];
		    $curr->adsenseClient = $ad['adsenseClient'];
		    $curr->adsDistrubution = $ad['adsDistrubution'];
		    $curr->randomize = $ad['randomize'];

		    self::setStreams2Model($db, $curr);

		    $curr->elements = array();
		    $table_name = $db->table_prefix . 'ads_elements';
		    if (false != ($elements = FFDB::conn()->getAll('SELECT `id`, `name`, `type`, `views`, `clicks`, `enabled`, `cardBG`, `textCol`, `height`, `label`, `labelTxt`, `labelCol`, `link`, `slot`, `content` FROM ?n WHERE `campaign` = ?s ORDER BY `order`', $table_name, $id))){
			    foreach ( $elements as $element ) {
				    $content = htmlspecialchars_decode($element['content']);

				    $el = new \stdClass();
				    $el->id = $element['id'];
				    $el->type = $element['type'];
				    $el->name = $element['name'];
				    $el->views = $element['views'];//1203;
				    $el->clicks = $element['clicks'];//12;
				    $el->enabled = $element['enabled'];
				    $el->textCol = $element['textCol'];
				    $el->cardBG = $element['cardBG'];
				    $el->height = $element['height'];
				    $el->label = $element['label'];
				    $el->labelTxt = $element['labelTxt'];
				    $el->labelCol = $element['labelCol'];
				    $el->link = $element['link'];
				    $el->slot = $element['slot'];
				    $el->conversion = ( $el->clicks != 0 && $el->views != 0 ) ? round( ( $el->clicks * 100 ) / $el->views, 2 ) : 0;
				    $el->content = $element['type'] != 'html' ? '<div class="campaign-elements__image campaign-elements__dummy"></div>' : $content;
				    $el->code = $content;
				    $curr->elements[] = $el;
			    }
		    }
		    return $curr;
	    }
	    return false;
	}

	public static function deleteAd($id){
		global $flow_flow_context;
		/** @var FFDBManager $db */
		$db = $flow_flow_context['db_manager'];
		try{
			FFDB::beginTransaction();

			$table_name = $db->table_prefix . 'ads_streams';
			FFDB::conn()->query('DELETE FROM ?n WHERE `campaign` = ?s', $table_name, $id);

			$table_name = $db->table_prefix . 'ads_elements';
			FFDB::conn()->query('DELETE FROM ?n WHERE `campaign` = ?s', $table_name, $id);

			$table_name = $db->table_prefix . 'ads_campaigns';
			if (false !== FFDB::conn()->query('DELETE FROM ?n WHERE `id` = ?s', $table_name, $id)){
				echo $id;
			}
			FFDB::commit();
		}catch (Exception $e){
			FFDB::rollbackAndClose();
			error_log('save_stream_settings error:');
			error_log($e->getMessage());
			error_log($e->getTraceAsString());
		}
		FFDB::close();
		die();
	}

	public static function cloneAd($id){
		$campaign = self::getAd($id);
		unset($campaign->id);
		$campaign->name =  $campaign->name . ' clone';
		$campaign->status = 0;
		$campaign->streams = array();
		if (isset($campaign->elements)){
			foreach ( $campaign->elements as $el ) {
				unset($el->id);
				$el->views = 0;
				$el->clicks = 0;
			}
		}
        // cast array
        $campaign = json_decode(json_encode($campaign), true);
		self::saveAd($campaign);
	}

	public static function saveAd($campaign){
		global $flow_flow_context;
		/** @var FFDBManager $db */
		$db = $flow_flow_context['db_manager'];
		$table_name = $db->table_prefix . 'ads_campaigns';
		if (is_array($campaign)) $campaign = (object) $campaign;

		try{
			FFDB::beginTransaction();

			$campaign->end = 0 == $campaign->end ? FF_ADS_BIG_INT : $campaign->end;

			if (isset($_POST['status']) && $_POST['status'] == 'true') {
				$campaign->status = self::getNextStatus($campaign);
			}
			$campaign->readableStatus = self::getReadableStatus($campaign);
			$campaign->nextReadableStatus = self::getNextReadableStatus($campaign);

			$common = array(
				'name' =>  $campaign->name,
				'status' => $campaign->status,
				'start' =>  $campaign->start,
				'end'   =>  $campaign->end,
                'adsenseClient' => $campaign->adsenseClient,
				'firstAdIndex' => $campaign->firstAdIndex
			);
			if (isset($campaign->id)) $common['id'] = $campaign->id;
			if (isset($campaign->adsDistrubution) && $campaign->adsDistrubution > 0) {
				$common['adsDistrubution'] = (int)$campaign->adsDistrubution;
			}
			if (isset($campaign->randomize)) $common['randomize'] = $campaign->randomize;

			$sql = "INSERT INTO ?n SET ?u ON DUPLICATE KEY UPDATE ?u";
			if (false == FFDB::conn()->query($sql, $table_name, $common, $common)){
				throw new \Exception(FFDB::conn()->conn->error);
			}
			if (!isset($campaign->id)){
				$campaign->id = FFDB::conn()->insertId();
			}

			if (!isset($campaign->streams)) $campaign->streams = array();
			self::setStreams($db, $campaign->id, $campaign->streams);
			self::setStreams2Model($db, $campaign);
			if (!isset($campaign->elements)) $campaign->elements = array();
			self::setElements($db, $campaign->id, $campaign->elements);

			$campaign->end = FF_ADS_BIG_INT == $campaign->end ? 0 : $campaign->end;
			echo json_encode($campaign);
			FFDB::commit();

		}catch (Exception $e){
			FFDB::rollbackAndClose();
			error_log('save_stream_settings error:');
			error_log($e->getMessage());
			error_log($e->getTraceAsString());
		}
		FFDB::close();
		die();
	}

	public static function buildPublicResponse($response, $all, $context, $errors, $oldHash, $page, $status, $stream) {
		$streamId = (int) is_object($stream) ? $stream->getId() :  $stream;
		$distrubution = array();
		$countOfPostsOnPage = sizeof( $response['items'] );

		if ($page == 0) {
			/** @var FFDBManager $db */
			$db = $context['db_manager'];
			$prefix = $db->table_prefix;
			global $wpdb;
			$sql = '';
			if (!isset($_GET['preview']) || $_GET['preview'] == false){
				$time_ms = time() * 1000;
				$sql = 'AND ca.status = 1 AND ' . $time_ms . ' BETWEEN ca.start AND ca.end';
			}
			$ads = FFDB::conn()->getAll("SELECT ca.*, el.id, el.type, el.name, el.content, el.link, el.label, el.labelCol, el.height, el.labelTxt, el.textCol, el.cardBG, el.slot
				FROM ?n as st INNER JOIN ?n as ca ON st.campaign = ca.id INNER JOIN ?n as el ON st.campaign = el.campaign
				WHERE st.stream = ?i AND el.enabled = ?s ". $sql ." ORDER BY el.`order`", $prefix . "ads_streams", $prefix . "ads_campaigns", $prefix . "ads_elements", $streamId, 'yep');
			/*$ads = $wpdb->get_results($wpdb->prepare("SELECT ca.*, el.id, el.type, el.name, el.content, el.link, el.label, el.labelCol, el.height, el.labelTxt, el.textCol, el.cardBG, el.slot
				FROM " . $prefix . "ads_streams as st INNER JOIN " . $prefix . "ads_campaigns as ca ON st.campaign = ca.id INNER JOIN " . $prefix . "ads_elements as el ON st.campaign = el.campaign
				WHERE st.stream = %d AND el.enabled = '%s' " . $sql . " ORDER BY el.`order`", $streamId, 'yep'));*/

			if (sizeof($ads) > 0) {
				$firstAdIndex = (int) $ads[0]['firstAdIndex'] - 1;
				if ( FFSettingsUtils::YepNope2ClassicStyle( $ads[0]['randomize'] ) ) {
					$endRange = is_object( $stream ) ? $stream->getCountOfPostsOnPage() : $countOfPostsOnPage;
					$numbers  = range( $firstAdIndex, $endRange - 1 );
					shuffle( $numbers );
					$numbers = array_slice( $numbers, 0, sizeof( $ads ) );
					asort( $numbers );
					$index = 0;
					foreach ( $numbers as $position ) {
						$el                        = $ads[ $index ++ ];
						$distrubution[ $position ] = self::buildElement4Public( $el, $ads[0]->adsenseClient );
					}
				} else {
					$adsDistrubution = (int) $ads[0]['adsDistrubution'];
					for ( $index = 0; sizeof( $ads ) > $index; $index ++ ) {
						$el                        = $ads[ $index ];
						$position                  = $firstAdIndex + $adsDistrubution * $index;
						$distrubution[ $position ] = self::buildElement4Public( $el, $ads[0]['adsenseClient'] );
					}
				}
			}
		}
		else if (isset($_SESSION['ff_ads'][$streamId])) {
			$session = $_SESSION['ff_ads'][$streamId];
			$distrubution = $session['distrubution'];
			$countOfPostsOnPage = (int) $session['page_size'];
		}

		if (!empty($distrubution)){
			$ad_ids = array();
			$count = $page * $countOfPostsOnPage;
			$result = array();
			foreach (  $response['items'] as $item ) {
				if (isset($distrubution[$count])) {
					$ad = $distrubution[$count];
					$ad_ids[] = (int)$ad->id;
					$ad->id = 'ad_el_' . $ad->id;
					$result[] = $ad;
					unset($distrubution[$count]);
				}
				$result[] = $item;
				$count++;
			}
			$response['items'] = $result;
			if (sizeof($ad_ids) > 0) $response['ads'] = $ad_ids;
		}

		if (empty($distrubution))
			unset($_SESSION['ff_ads'][ $streamId ]);
		else
			$_SESSION['ff_ads'][ $streamId ] = array('distrubution' => $distrubution, 'page_size' => $countOfPostsOnPage);

		return $response;
	}

	public static function removeStream($streamId){
		global $flow_flow_context;
		/** @var FFDBManager $db */
		$db = $flow_flow_context['db_manager'];
		$prefix = $db->table_prefix;
		FFDB::conn()->query('DELETE FROM ?n WHERE `stream` = ?s', $prefix . 'ads_streams', $streamId);
	}

	private static function buildElement4Public( $el, $adsenseClient ) {
		if ($el['type ']== 'ad') {
			$format = 'auto';
			$text = '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
						<ins class="adsbygoogle"
     						style="display:block"
     						data-ad-client="' . $adsenseClient . '"
     						data-ad-slot="' . $el['slot ']. '"
     						data-ad-format="' . $format . '"></ins>
						<script>setTimeout(function(){(adsbygoogle = window.adsbygoogle || []).push({})}, 100)</script>';
		}
		else {
			$text = htmlspecialchars_decode($el['content']);
		}

		$ad = new \stdClass();
		$ad->id = $el['id'];
		$ad->type = 'ad';
		$ad->adtype = $el['type'];
		$ad->text = $text;
		$ad->permalink = $el['link'];
		$ad->header = $el['name'];
		$ad->height = $el['height'];
		$ad->label = $el['label'];
		$ad->labelCol = $el['labelCol'];
		$ad->labelTxt = $el['labelTxt'];
		$ad->textCol = $el['textCol'];
		$ad->cardBG = $el['cardBG'];
		return $ad;
	}

	private static function setStreams($db, $campaign, $streams){
		$table_name = $db->table_prefix . 'ads_streams';
		if (false != FFDB::conn()->query('DELETE FROM ?n WHERE `campaign` = ?s', $table_name, $campaign)){
			foreach ( $streams as $stream ) {
				FFDB::conn()->query('INSERT INTO ?n (`campaign`, `stream`) VALUES(?s, ?s)', $table_name, $campaign, $stream);
			}
		}
	}

	private static function setStreams2Model($db, &$model){
		$model->streams = array();
		$model->available_streams = array();
		if (false != ($streams = FFDB::conn()->getAll('SELECT st.id, st.name, ast.stream, ast.campaign FROM ?n st LEFT JOIN ?n ast ON st.id = ast.stream ORDER BY st.id', $db->streams_table_name, $db->table_prefix . 'ads_streams'))){
			foreach ( $streams as $stream ) {
				if ($stream['campaign'] != null && $stream['campaign'] == $model->id){
					$model->streams[] = $stream['id'];
				} else {
                    $model->available_streams[$stream['id']] = $stream['name'] ? $stream['name'] : ('Unnamed#'.$stream['id']);
                }
			}
		}
	}

	private static function setElements($db, $campaign, &$elements){
		$table_name = $db->table_prefix . 'ads_elements';
		$index = 0;
		$ids = array();
		if (!empty($elements)) {
            foreach ( $elements as &$element ) {
                $index++;
                $contentFieldName = $element['type'] == 'html' ? 'content' : 'code';
                $content = stripslashes($element[$contentFieldName]);
                $element[$contentFieldName] = $content;
                $content = htmlspecialchars($content);

                $common = array(
                    'name' =>  $element['name'],
                    'type' =>  $element['type'],
                    'campaign' => $campaign,
                    'views' => $element['views'],
                    'enabled' => $element['enabled'],
                    'height' => $element['height'],
                    'label' => $element['label'],
                    'labelTxt' => $element['labelTxt'],
                    'labelCol' => $element['labelCol'],
                    'cardBG' => $element['cardBG'],
                    'textCol' => $element['textCol'],
                    'link' => $element['link'],
                    'slot' => $element['slot'],
                    'clicks' =>  $element['clicks'],
                    'content'   => $content,
                    'order' => $index
                );
                if (isset($element['id'])){
                    $common['id'] = $element['id'];
                }

                $sql = "INSERT INTO ?n SET ?u ON DUPLICATE KEY UPDATE ?u";
                if (false == FFDB::conn()->query($sql, $table_name, $common, $common)){
                    throw new \Exception(FFDB::conn()->conn->error);
                }
                if (!isset($element['id'])){
                    $element['id'] = FFDB::conn()->insertId();
                }
                $ids[] = $element['id'];
		    }
        }

		$sql = 'DELETE FROM ?n WHERE `campaign` = ?s';
		if (!empty($ids)){
			$sql .= FFDB::conn()->parse(' AND `id` NOT IN (?a)', $ids);
		}
		$sql = FFDB::conn()->parse($sql, $table_name, $campaign);
		FFDB::conn()->query($sql);
	}

	private static function array_to_object($array) {
		foreach($array as $key => $value) {
			if(is_array($value)) {
				$tmp = self::array_to_object($value);
				if (is_array($array)) $array[$key] = $tmp;
				else if (is_object($array)) $array->{$key} = $tmp;
			}
		}
		return (object)$array;
	}

	private static function getReadableStatus($campaign){
		$time = time() * 1000;
		$status = intval($campaign->status);
		if ($status > 0){
			if (( $status == 1) && ($time > $campaign->start) && ($campaign->end > $time))
			{
				return self::$statuses[ $status + 1 ];
			}
			else if ($time > $campaign->end){
				return self::$statuses[ 4 ];
			}
		}
		return self::$statuses[ $status ];
	}

	private static function getNextReadableStatus($campaign){
		if ($campaign->status == 0) return 'publish';
		$campaign = clone $campaign;
		$campaign->status = self::getNextStatus($campaign);
		return self::getReadableStatus($campaign);
	}

	private static function getNextStatus($campaign){
		$status = intval($campaign->status);
		if ($status > 0){
			if ($status == 1){
				return $status + 2;
			}
			else if ($status == 3){
				return $status - 2;
			}
		}
		return $status + 1;
	}
}