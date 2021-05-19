<?php
/*
# ------------------------------------------------------------------------
# Vina Articles Carousel for Joomla 3
# ------------------------------------------------------------------------
# Copyright(C) 2014 www.VinaGecko.com. All Rights Reserved.
# @license http://www.gnu.org/licenseses/gpl-3.0.html GNU/GPL
# Author: VinaGecko.com
# Websites: http://vinagecko.com
# Forum: http://vinagecko.com/forum/
# ------------------------------------------------------------------------
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.modal');

/*$doc = JFactory::getDocument();
$doc->addScript('modules/mod_vina_carousel_content/assets/js/owl.carousel.js', 'text/javascript');
$doc->addStyleSheet('modules/mod_vina_carousel_content/assets/css/owl.carousel.css');
$doc->addStyleSheet('modules/mod_vina_carousel_content/assets/css/owl.theme.css');*/
//Include Helix3 plugin
$helix3_path = JPATH_PLUGINS.'/system/helix3/core/helix3.php';

if (file_exists($helix3_path)) {
    require_once($helix3_path);
    $helix3 = helix3::getInstance();
} else {
    die('Please install and activate helix plugin');
}
$blog_quickview 	=  $helix3->getParam('blog_quickview', 1);
?>
<style type="text/css" scoped>
#vina-carousel-content<?php echo $module->id; ?> {
	width: <?php echo $moduleWidth; ?>;
	height: <?php echo $moduleHeight; ?>;
	margin: <?php echo $moduleMargin; ?>;
	padding: <?php echo $modulePadding; ?>;
	<?php echo ($bgImage != '') ? "background: url({$bgImage}) repeat scroll 0 0;" : ''; ?>
	<?php echo ($isBgColor) ? "background-color: {$bgColor};" : '';?>
}
#vina-carousel-content<?php echo $module->id; ?> .item {
	<?php echo ($isItemBgColor) ? "background-color: {$itemBgColor};" : ""; ?>;
	color: <?php echo $itemTextColor; ?>;
	padding: <?php echo $itemPadding; ?>;
	margin: <?php echo $itemMargin; ?>;
}
</style>

<div id="vina-carousel-content<?php echo $module->id; ?>" class="vina-carousel-content default owl-carousel <?php echo $classSuffix; ?>">
	<!-- Items Block -->
	<?php
		$thumb = JURI::base() . 'modules/mod_vina_carousel_content/libs/timthumb.php?a=c&amp;q=99&amp;z=0&amp;w='.$imagegWidth.'&amp;h='.$imagegHeight;
		foreach ($list as $item) :
			$title 	= $item->title;
			$link   = $item->link;			
			$images = json_decode($item->images);
			$image 	= $images->image_fulltext;
			$image  = (empty($image)) ? $images->image_intro : $image;
			$image 	= (strpos($image, 'http://') === FALSE) ? JURI::base() . $image : $image;
			$image 	= ($resizeImage) ? $thumb . '&amp;src=' . $image : $image;
			$category 	= $item->displayCategoryTitle;
			$hits  		= $item->displayHits;
			$introtext 	= $item->displayIntrotext;
			$created   	= $item->displayDate;
			
			// Post Format
			$post_attribs = new JRegistry(json_decode( $item->attribs ));
			$post_format = $post_attribs->get('post_format', 'standard');
			
			//Quick View Blog
			$quickview = 'index.php?option=com_content&view=article&id=' . $item->slug . '&catid=' . $item->catslug.'&amp;tmpl=component';;		
			
	?>
	<div class="item">
		<div class="item-inner">
			<div class="blog-inner">
				<!-- Image Block -->
				<?php if($post_format == 'standard') { ?>
					<?php if($showImage && isset($images)) { ?>				
						<div class="image-block">
							<div class="entry-image">
								<a href="<?php echo $link; ?>" title="<?php echo $title; ?>">							
									<img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" title="<?php echo $title; ?>"/>							
								</a>							
								
								<!-- Quick View -->
								<?php if($blog_quickview) {?>
								<div class="actions">
									<div class="btn-buttons">								
										<a href="<?php echo $quickview; ?>" class="btn-button btn-quickview modal jutooltip vina-quickview" title="<?php echo JText::_( 'VM_LANG_QUICK_VIEW' ); ?>">									
											<span class="hidden"><?php echo JText::_( 'VM_LANG_QUICK_VIEW' ); ?></span>
											<i aria-hidden="true" class="simple-link"></i>
										</a>
										<a href="<?php echo $link; ?>" class="btn-button btn-detail jutooltip" title="<?php echo JText::_( 'VINA_DETAIL' ); ?>">
											<span class="hidden"><?php echo JText::_( 'VINA_DETAIL' ); ?></span>
											<i aria-hidden="true" class="simple-magnifier"></i>
										</a>
									</div>
								</div>
								<?php }?>
								
								<!-- Created Date -->
								<?php if($showCreatedDate) : ?>		
								<div class="img-circle intro-publish-date major_color">
									<span class="intro-day"><?php echo JHtml::_('date', $created, JText::_('d'));?></span>
									<span class="intro-month"><?php echo JHtml::_('date', $created, JText::_('M'));?></span>
								</div>
								<?php endif; ?>
							</div>
						</div>
					<?php } ?>
				<?php } else { ?>
					<?php echo JLayoutHelper::render('joomla.content.post_formats.post_' . $post_format, array('params' => $post_attribs, 'item' => $item)); ?>
				<?php } ?>
				
				
				<!-- Text Block -->
				<?php if($showTitle || $introText || $showCategory || $showHits || $readmore) : ?>
				<div class="text-block">
					<div class="entry-header">
						<!-- Title Block -->
						<?php if($showTitle) :?>
						<h3 class="title">
							<a href="<?php echo $link; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a>
						</h3>
						<?php endif; ?>	
						
						<!-- Article Info Block -->
						<?php if($showCategory || $showHits) : ?>
						<dl class="article-info">
							<dt class="article-info-term"></dt>
							<!-- Author -->
							<dd class="createdby">
								<?php echo JTEXT::_('VINA_BY'); ?>
								<span><?php echo $item->author; ?></span>
							</dd>
							<?php if($showHits) : ?>
							
							<!-- Show Hits -->
							<dd class="hits">
								<i class="fa fa-eye"></i>
								<span><?php echo JTEXT::_('VINA_HITS'); ?> <?php echo $hits; ?></span>
							</dd>
							<?php endif; ?>
							
							<!-- Show Category -->
							<?php if($showCategory) : ?>
							<dd class="category-name">
								<i class="fa fa-folder-open-o"></i>
								<?php echo $category; ?>
							</dd>
							<?php endif; ?>
							
						</dl>
						<?php endif; ?>
					</div>
					
					<!-- Intro text Block -->
					<?php if($introText) : ?>
					<div class="introtext"><?php echo $introtext; ?></div>
					<?php endif; ?>
					
					<!-- Readmore Block -->
					<?php if($readmore) : ?>
					<div class="readmore">
						<a class="btn btn-default jutooltip" href="<?php echo $link; ?>" title="<?php echo $title; ?>">
							<?php echo JText::_('VINA_CAROUSEL_READ_MORE'); ?>
						</a>
					</div>
					<?php endif; ?>
					
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
</div>

<script type="text/javascript">
jQuery(document).ready(function($) {
	$("#vina-carousel-content<?php echo $module->id; ?>").owlCarousel({
		items : 			<?php echo $itemsVisible; ?>,
        itemsDesktop : 		<?php echo $itemsDesktop; ?>,
        itemsDesktopSmall : <?php echo $itemsDesktopSmall; ?>,
        itemsTablet : 		<?php echo $itemsTablet; ?>,
        itemsTabletSmall : 	<?php echo $itemsTabletSmall; ?>,
        itemsMobile : 		<?php echo $itemsMobile; ?>,
        singleItem : 		<?php echo ($singleItem) ? 'true' : 'false'; ?>,
        itemsScaleUp : 		<?php echo ($itemsScaleUp) ? 'true' : 'false'; ?>,

        slideSpeed : 		<?php echo $slideSpeed; ?>,
        paginationSpeed : 	<?php echo $paginationSpeed; ?>,
        rewindSpeed : 		<?php echo $rewindSpeed; ?>,

        autoPlay : 		<?php echo ($autoPlay) ? 'true' : 'false'; ?>,
        stopOnHover : 	<?php echo ($stopOnHover) ? 'true' : 'false'; ?>,

        navigation : 	<?php echo ($navigation) ? 'true' : 'false'; ?>,
        rewindNav : 	<?php echo ($rewindNav) ? 'true' : 'false'; ?>,
        scrollPerPage : <?php echo ($scrollPerPage) ? 'true' : 'false'; ?>,

        pagination : 		<?php echo ($pagination) ? 'true' : 'false'; ?>,
        paginationNumbers : <?php echo ($paginationNumbers) ? 'true' : 'false'; ?>,

        responsive : 	<?php echo ($responsive) ? 'true' : 'false'; ?>,
        autoHeight : 	<?php echo ($autoHeight) ? 'true' : 'false'; ?>,
        mouseDrag : 	<?php echo ($mouseDrag) ? 'true' : 'false'; ?>,
        touchDrag : 	<?php echo ($touchDrag) ? 'true' : 'false'; ?>,
	});
}); 
</script>