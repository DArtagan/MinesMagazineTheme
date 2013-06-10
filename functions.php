<?php
 
function childtheme_create_stylesheet() {
    $templatedir = get_bloginfo('template_directory');
    $stylesheetdir = get_bloginfo('stylesheet_directory');
    ?>
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $templatedir ?>/style.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $templatedir ?>/styles/custom-style.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $templatedir ?>/style/nav.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $templatedir ?>/style/plugins.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $templatedir ?>/style/print.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $templatedir ?>/style/template-style.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $templatedir ?>/style/ui.tabs.css" />
    <?php
}
add_action('wp_head', 'childtheme_create_stylesheet');

function childtheme_activate_stylesheet() {
	?><link rel="stylesheet" type="text/css" 
  href="<?php echo get_stylesheet_directory_uri(); ?>/style.css" /><?php
}
add_action('wp_head', 'childtheme_activate_stylesheet', 99);


/**
 * Display users as firstname lastname
 */
class myUsers {
	static function init() {
		// Change the user's display name after insertion
		add_action( 'user_register', array( __CLASS__, 'change_display_name' ) );	
	}
	
	static function change_display_name( $user_id ) {
		$info = get_userdata( $user_id );
		
		$args = array(
			'ID' => $user_id, 
			'display_name' => $info->first_name . ' ' . $info->last_name 
		);
		
		wp_update_user( $args ) ;
	}
}

myUsers::init();


/**
 * child-theme options activation
 */
include(STYLESHEETPATH."/child_options.php");


/**
 * widget_wp_flash_img_show Class
 */
class widget_wp_flash_img_show extends WP_Widget {
	/** constructor */
	function widget_wp_flash_img_show() {
		parent::WP_Widget( 'widget_wp_flash_img_show', $name = 'Flash Image Show' );
	}

	/** @see WP_Widget::widget */
	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
		if (function_exists('wp_flash_img_show')) {wp_flash_img_show();}
		echo $after_widget;
	}

	/** @see WP_Widget::update */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}

	/** @see WP_Widget::form */
	function form( $instance ) {
		if ( $instance ) {
			$title = esc_attr( $instance[ 'title' ] );
		}
		else {
			$title = __( 'New title', 'text_domain' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<?php 
	}

} // class widget_wp_flash_img_show

// register widget_wp_flash_img_show widget
add_action( 'widgets_init', create_function( '', 'return register_widget("widget_wp_flash_img_show");' ) );


/**
 * RecentIssuesWidget Class
 */
class RecentIssuesWidget extends WP_Widget {
	/** constructor */
	function RecentIssuesWidget() {
		parent::WP_Widget( 'RecentIssuesWidget', $name = 'Recent Issues' );
	}

	/** @see WP_Widget::widget */
	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
		$arg = array('child_of'=>408, 'orderby'=>'id', 'order'=>'desc');
		$issues=  get_categories($arg);
		echo $after_widget;?>
		<ul class="subnav"><?php
			foreach($issues as $issue) { 
				echo '<li><a href="http://minesmagazine.com/cat/issues/' . $issue->slug . '">' . $issue->cat_name . '</a></li>'; 
			}?>
		</ul>
		<?php
	}

	/** @see WP_Widget::update */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}

	/** @see WP_Widget::form */
	function form( $instance ) {
		if ( $instance ) {
			$title = esc_attr( $instance[ 'title' ] );
		}
		else {
			$title = __( 'New title', 'text_domain' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<?php 
	}

} // class RecentIssuesWidget

// register RecentIssuesWidget
add_action( 'widgets_init', create_function( '', 'return register_widget("RecentIssuesWidget");' ) );


/**
 * Categories Widget with Exclusion
 */
class limited_catagories_list_widget extends WP_Widget {
        function limited_catagories_list_widget(){
                $widget_ops = array( 'classname' => 'Selective categories', 'description' => 'Show a list of Categories, with the ability to exclude categories' );
                $control_ops = array( 'id_base' => 'some-cats-widget' );
                $this->WP_Widget( 'some-cats-widget', 'Selective Catagories', $widget_ops, $control_ops );
        }
 
        function form ( $instance){
			$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
			$title = esc_attr( $instance['title'] );
			$excludes = ($instance['excludes']);
			$count = isset($instance['count']) ? (bool) $instance['count'] :false;
			$hierarchical = isset( $instance['hierarchical'] ) ? (bool) $instance['hierarchical'] : false;
			$dropdown = isset( $instance['dropdown'] ) ? (bool) $instance['dropdown'] : false;
			$instance = wp_parse_args( (array) $instance, $defaults );
			?>
			<p>
					<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
					<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
			</p>
			<p>
					<label for="<?php echo $this->get_field_id( 'excludes' ); ?>">Categories to exclude(comma separated list of Category IDs): </label>
					<p><input id="<?php echo $this->get_field_id( 'excludes' ); ?>" name="<?php echo $this->get_field_name( 'excludes' ); ?>" value="<?php echo $instance['excludes']; ?>" style="width:100%;" /></p>

		<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>"<?php checked( $count ); ?> />
		<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Show post counts' ); ?></label><br />

		<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('hierarchical'); ?>" name="<?php echo $this->get_field_name('hierarchical'); ?>"<?php checked( $hierarchical ); ?> />
		<label for="<?php echo $this->get_field_id('hierarchical'); ?>"><?php _e( 'Show hierarchy' ); ?></label></p>
			<?php
        }
 
        function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['excludes'] = strip_tags( $new_instance['excludes'] );
			$instance['count'] = !empty($new_instance['count']) ? 1 : 0;
			$instance['hierarchical'] = !empty($new_instance['hierarchical']) ? 1 : 0;
			return $instance;
        }
 
        function widget($args, $instance){
			
			extract( $args );
			$title = apply_filters('widget_title', $instance['title'] );
			$excludes = $instance['excludes'];
			$c = $instance['count'] ? '1' : '0';
			$h = $instance['hierarchical'] ? '1' : '0';

			$cat_args = array('orderby' => 'name', 'exclude' => $excludes, 'show_count' => $c, 'hierarchical' => $h);
			
			echo $before_widget;
			if ( $title )
					echo $before_title . $title . $after_title;
			$cat_args['title_li'] = '';
			echo '<ul class="subnav">';
			wp_list_categories(apply_filters('widget_categories_args', $cat_args));
			echo "</ul>";
			echo $after_widget;
        }
 
}
add_action( 'widgets_init', create_function( '', 'return register_widget("limited_catagories_list_widget");' ) );


/**
 * Get name of most recent issue
 */
	function CurrentIssue()  {
		$arg = array('child_of'=>408, 'orderby'=>'id', 'order'=>'desc');
		$issues=  get_categories($arg);
		echo $issues[0]->cat_name;
	}
	
/**
 * Get category of page
 */
	function CurrentCategory()  {
		if( is_category() ) {
			$catid = get_query_var('cat');
			echo $catid;
		} else {
			echo 'Nope';
		}
	}
	

/**
 * Custom template if the category belongs to the issues parent category
 */
	function IssuesTemplate()  {
		$parent = get_query_var('cat');
		while ($parent) {
			if ($parent == 408) {
				include('category-408.php');
				exit;
			}
			$cat = get_category($parent);
			$parent = $cat->category_parent;
		}
	}
add_action('template_redirect', 'IssuesTemplate', 1);


/**
 * Loop for archives
 */
	function IssuesArchiveLoop($verbose) {
		if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<div class="post" style="clear: both;">
					<h4 id="post-<?php the_ID(); ?>">
						<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php __('Permanent Link to');?> <?php the_title(); ?>">
							<?php the_title(); ?>
						</a>
					</h4>
					<?php if($verbose) { ?>
						<small>
							<?php the_time(__('M jS, Y')); ?>
							|
							<?php _e('By');?>
							<?php the_author_posts_link('namefl'); ?>
							<?php edit_post_link('Edit', ' | ', ''); ?>
						</small>
						<div class="entry" style="padding-bottom: 0px;">
							<?php postimage($prinz_archiveimage_width,$prinz_archiveimage_height); ?> 
							<?php the_excerpt(); ?>
						</div>
						<div class="clear postmetadata"></div>
					<?php } ?>
				</div>
			<?php endwhile; ?>
			<?php endif;
			wp_reset_query();
	}

	
/**
 * "Read more" for excerpts (get rid of it)
 */
	function excerpt_continue_reading($more) {
       global $post;
	return '';
}
add_filter('excerpt_more', 'excerpt_continue_reading');
	
	
/**
 * Author blurb boxes
 * Made with a little help from Boutros AbiChedid (http://bacsoftwareconsulting.com/blog/index.php/wordpress-cat/how-to-display-author-profile-box-in-wordpress-without-a-plugin/)
 */
	
	function add_post_content($content) {
	$img_size = 80;
	if(is_single()) {
		$content .= '<div class="author_blurb">' . get_avatar(get_the_author_meta('user_email'), $img_size) . '<div><span>' . the_author() . '</span></div>' . the_author_meta( 'user_description' ) . '</div>';
	}
	return $content;
}
//add_filter('the_content', 'add_post_content');

add_theme_support( 'post-thumbnails' );

?>