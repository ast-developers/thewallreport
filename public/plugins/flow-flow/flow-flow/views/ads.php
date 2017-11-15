<?php if ( ! defined( 'WPINC' ) )  die;
/**
 * FlowFlowAds.
 *
 * @package   FlowFlowAds
 * @author    Looks Awesome <email@looks-awesome.com>
 *
 * @link      http://looks-awesome.com
 * @copyright 2014-2016 Looks Awesome
 */

$ads = $context['ads'];
?>
<script>
    var ads = JSON.parse('<?php echo json_encode($ads) ?>');
</script>
<div class="section-content" id="campaigns-cont" data-tab="ads-tab">
	<!-- tab content -->
    <div class="section-campaign section-stream" id="campaigns-list" data-view-mode="streams-list">

        <div class="section">
            <h1 class="desc-following"><span>Ad/Branding Campaigns</span> <span class="admin-button green-button button-add">Add campaign</span></h1>
            <p class="desc">Manage here your Campaigns to add advertising and branding/personalization to your streams.</p>
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>Campaign</th>
                        <th>Starts</th>
                        <th>Ends</th>
                        <th>Views</th>
                        <th>Clicks *</th>
                        <th>Conversion *</th>
                      </tr>
                </thead>
                <tbody>
                <?php
                    $index = 0;
                    foreach ( $ads as $ad ) {
	                    $name = empty($ad->name) ? 'Unnamed' : $ad->name;
                        $start = (int)$ad->start != 0 ? date("m/d/y",(int)$ad->start / 1000) : "-";
                        $end = (int)$ad->end != 0 ? date("m/d/y", (int)$ad->end / 1000) : "-";
	                    echo
		                    "<tr data-campaign-id='{$ad->id}' data-status='{$ad->status}' data-row-index='{$index}'>
								<td class='controls'><div class='loader-wrapper'><div class='throbber-loader'></div></div><i class='flaticon-pen'></i> <i class='flaticon-copy'></i> <i class='flaticon-trash'></i></td>
								<td class='td-status'><span class='status-light-{$ad->status}'></span></td>
		                    	<td class='td-name'>{$name}</td>
							    <td class='td-start'>{$start}</td>
							    <td class='td-end'>{$end}</td>
							    <td class='td-views'>{$ad->views}</td>
							    <td class='td-clicks'>{$ad->clicks}</td>
							    <td class='td-conversion'>{$ad->conversion}%</td>
		                    </tr>";
                        $index++;
                    }
                    if (empty($ads)){
                        echo '<tr class="empty-row"><td class="empty-cell" colspan="8">Please create at least one campaign</td></tr>';
                    }
                ?>
                </tbody>
            </table>
            <div class="desc">* Actions on third-party iframe ads (like AdSense) cannot be tracked and you need to check their performance in their respective admins</div>
        </div>
    </div>
</div>