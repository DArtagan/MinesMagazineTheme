<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<?php if (prinz_get_option('prinz_responsive')) : ?>
<meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1" /><?php endif; ?>
<?php 
echo '	<title>';
if ( is_home() ) {
	// Blog's Home
	echo get_bloginfo('name') . '  &raquo; '; bloginfo('description') ; 
} elseif ( is_single() or is_page() ) {
	// Single blog post or page
	wp_title(''); echo ' - ' . get_bloginfo('name');
} elseif ( is_category() ) {
	// Archive: Category
	echo get_bloginfo('name') . ' &raquo;  '; single_cat_title();
} elseif ( is_day() ) {
	// Archive: By day
	echo get_bloginfo('name') . ' &raquo; ' . get_the_time('d') . '. ' . get_the_time('F') . ' ' . get_the_time('Y');
} elseif ( is_month() ) {
	// Archive: By month
	echo get_bloginfo('name') . ' &raquo; ' . get_the_time('F') . ' ' . get_the_time('Y');
} elseif ( is_year() ) {
	// Archive: By year
	echo get_bloginfo('name') . ' &raquo; ' . get_the_time('Y');
} elseif ( is_search() ) {
	// Search
	echo get_bloginfo('name') . ' &raquo; ' . esc_html($s, 1);
} elseif ( is_404() ) {
	// 404
	echo get_bloginfo('name') . '  &raquo; 404 - ERROR';
} else {
	// Everything else. Fallback
	bloginfo('name'); wp_title();
}
echo '</title>';
?>

<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('stylesheet_url'); ?>" />
	<?php if (!prinz_get_option('prinz_color_scheme')) : // in case no stylesheet is defined (e.g. in preview mode) make sure the default is loaded ?>
  <?php else: ?>
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo get_stylesheet_directory_uri(); ?>/styles/style_<?php echo prinz_get_option('prinz_color_scheme'); ?>.css" />
	<?php endif; ?>
<?php if (prinz_get_option('prinz_responsive')) : // Call the mediaqueries CSS if the theme is set to be responsive in the themes options ?>
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo get_stylesheet_directory_uri() ; ?>/styles/mediaqueries.css" />
<?php endif; ?>
<!--[if lt IE 9]>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
<![endif]-->
<style type="text/css">
<?php 	if (prinz_get_option('prinz_noopensans')) : ?>
body, select, input, textarea { font: 12px Arial, Verdana, Sans-Serif; line-height: 1.5em; }
<?php endif; ?>
#leftcol, #rightcol, .entry { text-align: <?php echo prinz_get_option('prinz_textalign'); ?>; }
<?php echo stripslashes(prinz_get_option('prinz_custom_css')); ?>
</style>

<!-- WP HEAD STARTS -->
<?php wp_head(); ?>
<!-- WP HEAD ENDS -->
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<!-- Custom header scripts from the themes options go here -->
<?php echo stripslashes(prinz_get_option('prinz_header_scripts')); ?>
<!-- end custom header scripts -->
</head>
<body <?php body_class(); ?>>
<div id="page" class="clearfloat">

<div id="header" class="clearfloat">
<!-- LOGO BLOCK STARTS HERE -->
  <div id="logo">
    <?php
   if (prinz_get_option('prinz_logo')) { ?>
      
    <a href="<?php echo home_url(); ?>/"><img style="border:none;padding:0;" src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="<?php bloginfo('name'); ?> - <?php bloginfo('description'); ?>" title="<?php bloginfo('name'); ?> - <?php bloginfo('description'); ?>" border="none" /></a>
    <?php } else { ?>
    
    <div class="blogtitle" ><a href="<?php echo home_url(); ?>/">
      <?php bloginfo('name'); ?>
      </a></div><!-- end .blogtitle -->
      
    <div class="description">
      <?php bloginfo('description'); ?>
    </div><!-- end .description -->
    <?php } ?>
  </div><!-- end #logo -->
<!-- LOGO BLOCK ENDS HERE -->

<!-- HEADER WIDGET AREA STARTS HERE -->
 <div id="headerwidgets">
  	<?php if ( is_active_sidebar( 'header' ) ) : ?>
	<?php dynamic_sidebar( 'header' ); ?>
    <?php endif; ?>
 </div>
<!-- HEADER WIDGET AREA ENDS HERE --> 

</div><!-- end #header -->

<!-- MAIN NAVIGATION BLOCK STARTS HERE -->
<div id="navwrap">
<?php
if (prinz_get_option('prinz_wpmenuon')) { //the primary horizontal custom Wordpress menu ?>
	<?php wp_nav_menu( array('menu_id' => 'primary', 'sort_column' => 'menu_order', 'container_class' => 'prinz-menu-primary clearfloat', 'menu_class' => 'sf-menu', 'theme_location' => 'primary-menu' ) ); ?>
<?php } ?>

<?php 
if (prinz_get_option('prinz_wpmenusecondaryon')) { //the secondray horizontal custom Wordpress menu ?>
	<?php wp_nav_menu( array( 'menu_id' => 'secondary', 'sort_column' => 'menu_order', 'container_class' => 'prinz-menu-secondary clearfloat', 'menu_class' => 'sf-menu', 'theme_location' => 'secondary-menu'  ) ); ?>
<?php } ?>
</div><!-- end #navwrap -->
<!-- MAIN NAVIGATION BLOCK ENDS HERE -->
