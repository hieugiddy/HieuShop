<?php
/*
# ------------------------------------------------------------------------
# Vina CSS3 Image Gallery for Joomla 3
# ------------------------------------------------------------------------
# Copyright(C) 2014 www.VinaGecko.com. All Rights Reserved.
# @license http://www.gnu.org/licenseses/gpl-3.0.html GNU/GPL
# Author: VinaGecko.com
# Websites: http://vinagecko.com
# Forum:    http://vinagecko.com/forum/
# ------------------------------------------------------------------------
*/
// no direct access
defined('_JEXEC') or die('Restricted access');
$doc = JFactory::getDocument();
$doc->addScript('modules/'.$module->module.'/assets/js/freewall.js', 'text/javascript');
$doc->addScript('modules/'.$module->module.'/assets/js/jquery.photobox.js', 'text/javascript');
$doc->addStyleSheet('modules/'.$module->module.'/assets/styles/photobox.css');
$doc->addStyleSheet('modules/'.$module->module.'/assets/styles/photobox.ie.css');
$doc->addStyleSheet('modules/'.$module->module.'/assets/styles/style.css');
$timthumb = JURI::base() . 'modules/'.$module->module.'/libs/timthumb.php?a=c&amp;q=99&amp;z=0';
?>

<style type="text/css" scoped>
#vina-css3-image-gallery-wrapper<?php echo $module->id; ?> {
	max-width: <?php echo $moduleWidth; ?>;
	max-height: <?php echo $moduleHeight; ?>;
	overflow: <?php echo $overflow; ?>;
	padding: <?php echo $modulePadding; ?>;
	margin: <?php echo $moduleMargin; ?>;
	<?php echo ($isBgColor) ? "background-color: {$bgColor};" : '';?>
	<?php echo ($bgImage != '') ? "background: url({$bgImage}) top center repeat;" : ''; ?>
}
#vina-css3-image-gallery-wrapper<?php echo $module->id; ?> .item {
	width: <?php echo $itemMaxWidth; ?>px;
}
#vina-css3-image-gallery-wrapper<?php echo $module->id; ?> .item h3 {
	color: <?php echo $itemLinkColor; ?>;
}
<?php if($textBlock): ?>
#vina-css3-image-gallery-wrapper<?php echo $module->id; ?> .item .image-block:before {
	<?php echo ($isItemBgColor) ? "border-bottom: 12px solid {$itemBgColor};" : ''; ?>
}
<?php endif; ?>
#vina-css3-image-gallery-wrapper<?php echo $module->id; ?> .item .text-block {
	<?php echo ($isItemBgColor) ? "background-color: {$itemBgColor};" : ''; ?>
	color: <?php echo $itemTextColor; ?>;
	padding: <?php echo $itemPadding; ?>;
}
</style>

<!-- HTML Block -->
<div id="vina-css3-image-gallery-wrapper<?php echo $module->id; ?>" class="vina-css3-image-gallery-wrapper">
	<?php
	for($i = 0; $i < $pageNumber; $i++) : 
		$min = $imageInPage * $i;
		$max = $imageInPage * ($i + 1);
	?>
	<div id="vina-css3-image-gallery<?php echo $module->id; ?>-<?php echo $i; ?>" class="vina-css3-image-gallery page-<?php echo $i; ?>">
		<?php require JModuleHelper::getLayoutPath($module->module, "default_items"); ?>		
	</div>
	<?php endfor; ?>
	
	<!-- Pagination Block -->
	<?php if($pageNumber > 1) : ?>
	<div class="vina-pagination">
		<ul>
		<?php for($i = 0; $i < $pageNumber; $i++) : ?>
			<li class="page-<?php echo $i; ?>">
				<a class="<?php echo $i ? '' : 'activated'; ?>" href="javascript: void(0);"><span><?php echo $i; ?></span></a>
			</li>
		<?php endfor; ?>
		</ul>
	</div>
	<?php endif; ?>
</div>

<!-- Javascript Block -->
<script type="text/javascript">
jQuery(document).ready(function ($) {
	<?php for($i = 0; $i < $pageNumber; $i++) : ?>
	var wall<?php echo $i; ?> = new freewall("#vina-css3-image-gallery<?php echo $module->id; ?>-<?php echo $i; ?>");
	wall<?php echo $i; ?>.reset({
		selector	: '.brick',
		draggable	: <?php echo $draggable ? 'true' : 'false'; ?>,
		animate		: <?php echo $animate ? 'true' : 'false'; ?>,
		cache		: <?php echo $moduleCache ? 'true' : 'false'; ?>,
		cellW		: function(width) {
			var cellWidth = width / <?php echo $maxItemRow; ?>;
			cellWidth = (cellWidth < <?php echo $itemMinWidth; ?>) ? <?php echo $itemMinWidth; ?> : cellWidth;
			return cellWidth - <?php echo $gutterX + $gutterY; ?>;
		},
		cellH		: 'auto',
		delay		: <?php echo $delay; ?>,
		fixSize		: <?php echo $fixSize; ?>,
		gutterX		: <?php echo $gutterX; ?>,
		gutterY		: <?php echo $gutterY; ?>,
		rightToLeft	: <?php echo ($rightToLeft) ? 'true' : 'false'; ?>,
		bottomToTop	: <?php echo ($bottomToTop) ? 'true' : 'false'; ?>,
		onResize	: function() {
			wall<?php echo $i; ?>.fitWidth();
		}
	});
	
	wall<?php echo $i; ?>.fitWidth();
	
	$(window).load(function(){
		wall<?php echo $i; ?>.fitWidth();
	});
	<?php endfor; ?>
	
	$('#vina-css3-image-gallery-wrapper<?php echo $module->id; ?>').find(".vina-pagination a").click(function() {
		var active = $(this).parent().attr('class');
		var wall   = 'wall' + active.replace('page-', '');
		
		$('#vina-css3-image-gallery-wrapper<?php echo $module->id; ?> .vina-css3-image-gallery').hide();
		$('#vina-css3-image-gallery-wrapper<?php echo $module->id; ?> .' + active).show();
		
		<?php for($i = 0; $i < $pageNumber; $i++) : ?>
		wall<?php echo $i; ?>.fitWidth();
		<?php endfor; ?>
		
		$(this).parent().parent().find('a').removeClass('activated');
		$(this).addClass('activated');
	});
});

jQuery(document).ready(function($) {
	$('#vina-css3-image-gallery-wrapper<?php echo $module->id; ?>').photobox('a.vina-gallery', {
		single        : <?php echo $single ? 'true' : 'false'; ?>,
		loop          : <?php echo $loop ? 'true' : 'false'; ?>,
		thumbs        : <?php echo $thumbs ? 'true' : 'false'; ?>,
		title         : <?php echo $title ? 'true' : 'false'; ?>,
		autoplay      : <?php echo $autoplay ? 'true' : 'false'; ?>,
		time          : <?php echo $time; ?>,
		history       : <?php echo $history ? 'true' : 'false'; ?>,
		zoomable      : <?php echo $zoomable ? 'true' : 'false'; ?>,
		wheelNextPrev : <?php echo $wNextPrev ? 'true' : 'false'; ?>,
	});
});
</script>