<!-- SIDEBAR -->
<div id="sidebar">
  <div id="sidelist">
  	 <?php if (!prinz_get_option('prinz_newsblock')) : ?>
      <?php if ( is_home() ) { ?>
    <div class="newsblock">
      <h3>
        <?php 
	// this is where the name of the News (or whatever) category gets printed	  
	wp_list_categories('include='.get_cat_id(prinz_get_option('prinz_lead')).'&title_li=&style=none'); ?>
      </h3>
      <?php 
// this is where the last five headlines are pulled from the News (or whatever) category but not the first one (offset=1) since this is already displayed as leadarticle. 
		query_posts('cat='.get_cat_id(prinz_get_option('prinz_lead')).'&offset=1&showposts='.prinz_get_option('prinz_sidenewsnumber'));
		?>
      <ul class="bullets">
        <?php while (have_posts()) : the_post(); ?>
        <li><a href="<?php the_permalink() ?>" rel="bookmark">
          <?php the_title(); ?>
          </a></li>
        <?php endwhile; ?>
      </ul>
    </div>
    <?php } ?>
  <?php endif; ?>

  
   <?php if ( is_active_sidebar( 'regular' ) ) : ?>

		<?php dynamic_sidebar( 'regular' ); ?>
        
        <?php else : ?>
      
    <?php
// this is where 10 headlines from the current category get printed	  
if ( is_single() ) :
global $post;
$categories = get_the_category();
foreach ($categories as $category) :
?>
    <div>
      <h3><?php _e('More from this category', PRiNZ_DOMAIN);?></h3>
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

  <?php endif; ?>
  
  <?php if (!prinz_get_option('prinz_stayinformed')) : ?>
      <div>
      <h3><?php _e('Stay informed', PRiNZ_DOMAIN);?></h3>
      <ul class="feed">
        <li><a href="<?php bloginfo('rss2_url'); ?>"><?php _e('Entries RSS', PRiNZ_DOMAIN);?></a></li>
        <li><a href="<?php bloginfo('comments_rss2_url'); ?>"><?php _e('Comments RSS', PRiNZ_DOMAIN);?></a></li>
        <li class='podcast'><a href='http://itunes.apple.com/us/podcast/mines-magazine/id303361339'>Subscribe to our Podcast (iTunes)</a></li>
      </ul>
    </div>
  <?php endif; ?>
	
  </div>
  <!--END SIDELIST-->
</div>
<!--END SIDEBAR-->
