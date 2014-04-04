<?php get_header(); ?>

<div id="content" class="clearfloat">
  <div id="articleColumn" class="column">
    <?php is_tag(); ?>
    <?php if (have_posts()) : ?>
    <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
    <?php if( is_tag() ) { ?>
    <h2 class="pagetitle">
      <?php _e('Posts Tagged', PRiNZ_DOMAIN); ?>
      &#8216;
      <?php single_tag_title(); ?>
      &#8217;</h2>
    <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
    <h2 class="pagetitle"><?php printf( __('Archive for %s', PRiNZ_DOMAIN), get_the_time(__('F jS, Y', PRiNZ_DOMAIN))); ?></h2>
    <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
    <h2 class="pagetitle"><?php printf( __('Archive for %s', PRiNZ_DOMAIN), get_the_time(__('F Y', PRiNZ_DOMAIN))); ?></h2>
    <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
    <h2 class="pagetitle"><?php printf( __('Archive for %s', PRiNZ_DOMAIN), get_the_time('Y')); ?></h2>
    <?php /* If this is a search */ } elseif (is_search()) { ?>
    <h2 class="pagetitle">
      <?php __('Search Results', PRiNZ_DOMAIN); ?>
    </h2>
    <?php /* If this is an author archive */ } elseif (is_author()) { ?>
    <h2 class="pagetitle">
      <?php _e('All entries by this author', PRiNZ_DOMAIN); ?>
    </h2>
    <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
      <h2 class="pagetitle">
        <?php _e('Blog Archives', PRiNZ_DOMAIN); ?>
      </h2>
      <?php } ?>
    <div class="clearfloat"></div>
    <?php while (have_posts()) : the_post(); ?>
    <div class="post">
      <h3 id="post-<?php the_ID(); ?>"><a class="title" href="<?php the_permalink() ?>" rel="bookmark" title="<?php __('Permanent Link to', PRiNZ_DOMAIN);?> <?php the_title(); ?>">
        <?php the_title(); ?>
        </a></h3>
      <small>
      <?php the_time(__('M jS, Y', PRiNZ_DOMAIN)); ?>
      |
      <?php _e('By', PRiNZ_DOMAIN);?>
      <?php the_author_posts_link(); ?>
      <?php edit_post_link('Edit', ' | ', ''); ?>
      </small>
      <div class="entry">
        <?php if ( function_exists('has_post_thumbnail') && has_post_thumbnail() ) { // this is the default WordPress post thumbnail function
  			the_post_thumbnail(array(prinz_get_option('prinz_archiveimage_width'),prinz_get_option('prinz_archiveimage_height')), array("class" =>  "alignleft"));
  			} ?>
        <?php the_excerpt() ?>
      </div>
      <div style="clear:both;margin-bottom:10px;"></div>
      <p class="postmetadata">
        <?php _e('Posted in', PRiNZ_DOMAIN);?>
        <?php the_category(', '); ?>
        |
        <?php comments_popup_link(__ ('No Comments &#187;',  PRiNZ_DOMAIN), __ ('1 Comment &#187;',  PRiNZ_DOMAIN), _n ('% comment', '% comments', get_comments_number (), PRiNZ_DOMAIN)); ?>
        <br />
        <?php if ( function_exists('the_tags') ) {
  			the_tags('<span class="tags"><strong>'.__('Tags:', PRiNZ_DOMAIN).'</strong> ', ', ', '</span>'); } ?>
      </p>
      <hr />
      <br />
    </div>
    <?php endwhile; ?>
    <ul id="paging">
      <li class="prev">
        <?php previous_posts_link(__('Previous entries', PRiNZ_DOMAIN)) ?>
      </li>
      <?php if (function_exists('the_paging_bar')) { ?>
      <li class="pages">
        <?php the_paging_bar() ?>
      </li>
      <?php } ?>
      <li class="next">
        <?php next_posts_link(__('Next entries', PRiNZ_DOMAIN)) ?>
      </li>
    </ul>
    <?php else : ?>
    <h2 class="center">
      <?php __('Not Found', PRiNZ_DOMAIN) ?>
    </h2>
    <?php get_search_form(); ?>
    <?php endif; ?>
  </div>
  <div id="rightcolumn" class="column">
    <?php get_sidebar(); ?>
  </div>
</div>
<?php get_footer(); ?>
