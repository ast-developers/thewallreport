<?php
/**
 * Flow-Flow
 *
 * Plugin class. This class should ideally be used to work with the
 * public-facing side of the WordPress site.
 *
 * If you're interested in introducing administrative or dashboard
 * functionality, then refer to `FlowFlowAdmin.php`
 *
 * @package   FlowFlow
 * @author    Looks Awesome <email@looks-awesome.com>

 * @link      http://looks-awesome.com
 * @copyright 2014 Looks Awesome
 */
//Used for example moderation
$pageTitle = "A Real-Time Collection of News";
require_once(\App\Config::F_FLOW_FLOW_ROOT.'ff-injector.php');
$flowFlowInjector = new FFInjector();
include(\App\Config::F_ROOT . 'App/Views/Front/header.php');
?>


<table width="100%">
    <tr>
        <td style="width: 300px;vertical-align: top;padding-top: 113px; background: black;">
            <?php
            $stream_id = isset($_REQUEST['stream']) ? $_REQUEST['stream'] : 1;
            $flowFlowInjector->stream($stream_id);
            ?>
        </td>

    </tr>
</table>
<?php
include(\App\Config::F_ROOT . 'App/Views/Front/footer.php');
