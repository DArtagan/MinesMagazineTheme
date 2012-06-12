<!-- SIDEBAR -->
<?php include (TEMPLATEPATH.'/tools/get-theme-options.php'); ?>
<div id="sidebar">
  <div id="sidelist">
  
      <?php if ( is_home() ) { ?>
    <div>
      <h1 style="text-align: center;"><?php CurrentIssue() ?></h1>
    </div>
    <?php } ?>
  
    <?php 	/* Widgetized sidebar, if you have the plugin installed. */
					if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Regular Sidebar') ) : ?>
      
    <?php
// this is where 10 headlines from the current category get printed	  
if ( is_single() ) :
global $post;
$categories = get_the_category();
foreach ($categories as $category) :
?>
    <div>
      <h3><?php _e('More from this category','branfordmagazine');?></h3>
      <ul class="bullets">
        <?php
$posts = get_posts('numberposts=10&category='. $category->term_id);
foreach($posts as $post) :
?>
        <li><a href="<?php the_permalink(); ?>">
          <?php the_title(); ?>
          </a></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endforeach; endif ; ?>

    <div>
      <h3><?php _e('Browse Categories','branfordmagazine');?></h3>
      <ul class="subnav">
       <?php wp_list_categories("exclude=$prinz_sidecats&orderby=name&title_li=&hide_empty=1"); ?>
       	    
      </ul>
    </div>
    <div>
      <h3><?php _e('Ads &amp; Sponsors','branfordmagazine');?></h3>
<!-- GOOGLE 250x250px ADSENSE GOES HERE -->
<?php if ('wp_flash_img_show()') {wp_flash_img_show();} ?>
<?php echo stripslashes($prinz_250x250_ads); ?>
<!-- END GOOGLE ADSENSE -->
     </div>
    <div>
      <h3><?php _e('Browse Archives','branfordmagazine');?></h3>
     <select name="archive-dropdown" onchange='document.location.href=this.options[this.selectedIndex].value;'> 
  <option value=""><?php echo attribute_escape(__('Select Month')); ?></option> 
  <?php wp_get_archives('type=monthly&format=option&show_post_count=0'); ?> </select>

    </div>
  <?php endif; ?>
        <div>
      <h3><?php _e('Stay informed','branfordmagazine');?></h3>
      <ul>
        <li class="feed"><a href="<?php bloginfo('rss2_url'); ?>">Entries (RSS)</a></li>
        <li class="feed"><a href="<?php bloginfo('comments_rss2_url'); ?>">Comments (RSS)</a></li>
		<li class="podcast"><a href="http://itunes.apple.com/us/podcast/mines-magazine/id303361339">Subscribe to our Podcast (iTunes)</a></li>
      </ul>
    </div>

	
	<!--<a href="http://itunes.apple.com/us/podcast/mines-magazine/id303361339"><img src="http://magazine.mines.edu/NewSite/Pictures/podcast.jpg" />&nbsp;Check out our iTunes podcast</a> | <a href="http://minesmagazine.com/?page_id=2490">Access audio files</a>-->
<!--<a href=http://itunes.apple.com/us/podcast/mines-magazine/id303361339 rel=rokbox[1024][768]><img src= http://magazine.mines.edu/NewSite/Pictures/podcast.jpg>Subscribe to our Podcast (iTunes)</a>-->
	
  </div>
  <!--END SIDELIST-->
</div>
<!--END SIDEBAR-->
