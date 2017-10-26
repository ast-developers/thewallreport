<?php namespace flow\tabs;
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

class FFStreamsTab implements LATab{
	public function __construct() {
	}

	public function id() {
		return 'streams-tab';
	}

	public function flaticon() {
		return 'flaticon-ctrl-left';
	}

	public function title() {
		return 'Streams';
	}

	public function includeOnce( $context ) {
		$arr = $context['streams'];

		$export = array();
		foreach ($arr as $stream) {

			$item = array();

			foreach ($stream as $key => $value) {
                if ($key !== 'value') {
					if ($key === 'error') {
						$item['error'] = true;
					} else {
						if ($key === 'css') {
							$value = str_replace('"', "'", $value);
						}
						$item[$key] = $value;
					}
				}
			}

			$export[] = $item;
		}
//		debug
//		$export[0]['css'] = '';
//		$export[0]['heading'] = '';
		?>
		<script>
//			var str = '<?php //echo json_encode($export, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>//';
			/*str = str.replace(/\n/g, "\\\\n").replace(/\r/g, "\\\\r").replace(/\t/g, "\\\\t").replace(/\\\'/g, "'")
			var streams = JSON.parse(str, function(name, value) {
				//if (name === 'css') debugger
				return value
			});
			*/
			var streams = <?php echo json_encode($export, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
		</script>
		<div class="section-content" id="streams-cont" data-tab="streams-tab">
			<div class="popup">
				<div class="section">
					<i class="popupclose flaticon-close-4"></i>
					<div class="networks-choice add-feed-step">
						<h1>Create feed to use in your streams.</h1>
						<p class="desc">Choose source and then set up what content you want to load from it.</p>
						<ul class="networks-list">
							<li class="network-twitter"
								data-network="twitter"
								data-network-name="Twitter">
								<i class="flaticon-twitter"></i>
							</li>
							<li class="network-facebook"
								data-network="facebook"
								data-network-name="Facebook">
								<i class="flaticon-facebook"></i>
							</li>
							<li class="network-instagram"
								data-network="instagram"
								data-network-name="Instagram">
								<i class="flaticon-instagram"></i>
							</li>
							<li class="network-youtube"
								data-network="youtube"
								data-network-name="YouTube">
								<i class="flaticon-youtube"></i>
							</li>
							<li class="network-pinterest"
								data-network="pinterest"
								data-network-name="Pinterest">
								<i class="flaticon-pinterest"></i>
							</li>
							<li class="network-linkedin"
								data-network="linkedin"
								data-network-name="LinkedIn">
								<i class="flaticon-linkedin"></i>
							</li>

							<li class="network-flickr"
								data-network="flickr"
								data-network-name="Flickr">
								<i class="flaticon-flickr"></i>
							</li>
							<li class="network-tumblr"
								data-network="tumblr"
								data-network-name="Tumblr"
								style="margin-right:0">
								<i class="flaticon-tumblr"></i>
							</li>
							<br>

							<li class="network-google"
								data-network="google"
								data-network-name="Google +">
								<i class="flaticon-google"></i>
							</li>
							<li class="network-vimeo"
								data-network="vimeo"
								data-network-name="Vimeo">
								<i class="flaticon-vimeo"></i>
							</li>
							<li class="network-wordpress"
								data-network="wordpress"
								data-network-name="WordPress">
								<i class="flaticon-wordpress"></i>
							</li>
							<li class="network-foursquare"
								data-network="foursquare"
								data-network-name="Foursquare">
								<i class="flaticon-foursquare"></i>
							</li>
							<li class="network-soundcloud"
								data-network="soundcloud"
								data-network-name="SoundCloud">
								<i class="flaticon-soundcloud"></i>
							</li>
							<li class="network-dribbble"
								data-network="dribbble"
								data-network-name="Dribbble">
								<i class="flaticon-dribbble"></i>
							</li>
							<li class="network-rss"
								data-network="rss"
								data-network-name="RSS"
								style="margin-right:0">
								<i class="flaticon-rss"></i>
							</li>
						</ul>
					</div>
					<div class="networks-content  add-feed-step">
						<div id="feed-views"></div>
						<div id="filter-views"></div>
						<p class="feed-popup-controls add">
										<span id="feed-sbmt-1"
											  class="admin-button green-button submit-button">Add feed</span><span
								class="space"></span><span class="admin-button grey-button button-go-back">Back to first step</span>
						</p>
						<p class="feed-popup-controls edit">
										<span id="feed-sbmt-2"
											  class="admin-button green-button submit-button">Save changes</span>
						</p>
						<p class="feed-popup-controls enable">
										<span id="feed-sbmt-3"
											  class="admin-button blue-button submit-button">Save & Enable</span>
						</p>
					</div>
				</div>
			</div>
			<div class="section-stream" id="streams-list" data-view-mode="streams-list">
				<div class="section" id="streams-list-section">
					<h1 class="desc-following"><span>List of your streams</span> <span class="admin-button green-button button-add">create stream</span></h1>
					<p class="desc">Here is a list of your streams. Edit them to change styling or to add/remove social feeds. Status means all connected feeds are loaded or not.</p>
					<table>
						<thead>
						<tr>
							<th></th>
							<th>Stream</th>
							<th>Layout</th>
							<th>Feeds</th>
							<?php
							if (FF_USE_WP) echo '<th>Status</th><th>Shortcode</th>';
							else echo '<th>ID</th><th>Status</th>';
							?>
						</tr>
						</thead>
						<tbody>
						<?php

						foreach ($arr as $stream) {
							if (!isset($stream['id'])) continue;
							$id = $stream['id'];

							$status = $stream['status'] == 1 ? 'ok' : 'error';
							$additionalInfo = FF_USE_WP ?
								'<td><span class="cache-status-'. $status .'"></span></td><td><span class="shortcode">[ff id="' . $id . '"]</span><span class="shortcode-copy">Copy</span></td>' :
								'<td>' . $id . '</td><td><span class="cache-status-'. $status .'"></span></td>';

							if (isset($_REQUEST['debug']) && isset($stream['error'])) {
								$additionalInfo .= $stream['error'];
							}
							$info = '';
							if (isset($stream['feeds']) && !empty($stream['feeds'])) {
								$feeds = $stream['feeds'];
								if (is_array($feeds) || is_object($feeds)){
									foreach ( $feeds as $feed ) {
										$info = $info . '<i class="flaticon-' . $feed['type'] . '"></i>';
									}
								}
							}


							echo
								'<tr data-stream-id="' . $id . '">
							      <td class="controls"><div class="loader-wrapper"><div class="throbber-loader"></div></div><i class="flaticon-pen"></i> <i class="flaticon-copy"></i> <i class="flaticon-trash"></i></td>
							      <td class="td-name">' . (!empty($stream['name']) ? stripslashes($stream['name']) : 'Unnamed') . '</td>
							      <td class="td-type">' . (isset($stream['layout']) ? '<span class="highlight">' . $stream['layout'] . '</span>': '-') . '</td>
							      <td class="td-feed">' . (empty($info) ? '-' : $info) . '</td>'
								. $additionalInfo .
								'</tr>';
						}

						if (empty($arr)) {
							echo '<tr class="empty-row"><td class="empty-cell" colspan="6">Please add at least one stream</td></tr>';
						}

						?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<?php
	}
} 