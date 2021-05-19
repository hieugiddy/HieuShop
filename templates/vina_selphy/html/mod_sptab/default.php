<?php 
/*---------------------------------------------------------------
# SP Tab - Next generation tab module for joomla
# ---------------------------------------------------------------
# Author - JoomShaper http://www.joomshaper.com
# Copyright (C) 2010 - 2014 JoomShaper.com. All Rights Reserved.
# license - GNU/GPL V2 or later
# Websites: http://www.joomshaper.com
-----------------------------------------------------------------*/
// no direct access
defined('_JEXEC') or die('Restricted access'); ?>

<div class="sptab <?php echo $color ?>" id="sptab<?php echo $uniqid ?>">
<?php foreach ($list as $key => $item) : ?>
	<div style="display:none">
		<div class="tab-padding">
			<!--<h2 style="display:none" class="title"><span id="<?php echo (preg_replace('/\s+/', '_',strtolower($item['title']))); ?>" class="sptab-title<?php echo ($item['sfx']) ? ' sptab_sfx' . $item['sfx'] : ''; ?>"><?php echo $item['title']; ?></span></h2>-->
			<h2 style="display:none" class="title"><span id="<?php echo (preg_replace(array('/\s+/','/[^A-Za-z0-9\-]/'), array('_',''),strtolower($item['title']))); ?>" class="sptab-title<?php echo ($key + 1) ?><?php echo ($item['sfx']) ? ' sptab_sfx' . $item['sfx'] : ''; ?>"><?php echo str_replace( array('[',']'), array('<em style="display: none;">','</em>'), $item['title'] ); ?></span></h2>
			<?php echo $item['content']; ?>
			<div style="clear:both"></div>
		</div>
	</div>
<?php endforeach; ?>
</div>

<script type="text/javascript">
	jQuery(function($) {
		$('#sptab<?php echo $uniqid ?>').sptab({
			animation : <?php echo "'" . $animation . "'" ?>,
			btnPos: <?php echo "'" . $btnPos . "'" ?>,
			activator: <?php echo "'" . $activator . "'" ?>,
			transition: <?php echo "'" . $transition . "'" ?>,
			duration: <?php echo $fxspeed ?>
		});
	});
</script>