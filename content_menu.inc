<?php

//$pages = Array(
//	'name' => "Custom Theme",
//	'type' => "status",
//	'page' => "config.php");
//
?>

<li><a href="<?php echo preg_replace('/.*\/plugins\/(.*)/', 'plugin.php?plugin=$1&page=config.php', dirname(__FILE__)); ?>">Custom Theme</a></li>