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
session_start();

require_once('flow-flow/ff-injector.php');
$injector = new FFInjector();
?>

<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html lang="en-US"><!--<![endif]-->
<head><?php echo $injector->head(true); ?>
</head>
<body>

<table width="100%">
	<tr>
		<td style="width: 300px;vertical-align: top;padding-top: 113px; background: black;">
			<?php
				$stream_id = isset($_REQUEST['stream']) ? $_REQUEST['stream'] : 1;
				$injector->stream($stream_id);
			?>
		</td>
<!--		<td style="vertical-align: top;">-->
<!--			--><?php //$injector->stream(7); ?>
<!--		</td>-->
	</tr>
</table>


</body>
</html>