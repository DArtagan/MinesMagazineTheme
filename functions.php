<?php

/**
 * child-theme options activation
 */
include(STYLESHEETPATH."/child_options.php");


/**
 * Import child-theme options
 */
	global $childoptions;
	foreach ($childoptions as $value) {
    	if (get_option( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; }
    	else { $$value['id'] = get_option( $value['id'] ); }
    }


/**
 * Stylesheets
 */
function childtheme_create_stylesheet() {
    $templatedir = get_bloginfo('template_directory');
    $stylesheetdir = get_bloginfo('stylesheet_directory');
    ?>
      <link rel="stylesheet" type="text/css" media="screen" href="<?php echo $templatedir ?>/style.css" />
    <?php
}
add_action('wp_head', 'childtheme_create_stylesheet');

function childtheme_activate_stylesheet() {
	?><link rel="stylesheet" type="text/css" 
  href="<?php echo get_stylesheet_directory_uri(); ?>/style.css" /><?php
}
add_action('wp_head', 'childtheme_activate_stylesheet', 99);


/**
 * Register image sizes
 */
	add_image_size('fullwidth' , $MM_fullwidthWidth, $MM_fullwidthHeight, $MM_cropHomepage );
	add_image_size('square', $MM_squareWidth, $MM_squareHeight, $MM_cropHomepage );
	add_image_size('feature', $MM_featureWidth, $MM_featureHeight, $MM_cropHomepage );
	add_image_size('cover-thumbnail', 100, 127, TRUE);

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
 * Append the issue name to the beginning of wp-nav menu
 */
 
add_filter('wp_nav_menu_items', 'issueNameInNav', 10, 2);
 
function issueNameInNav($items, $args) {
	//$args = array('child_of'=>408, 'orderby'=>'id', 'order'=>'desc');
	//get_categories($args);
	if (is_category()) {
		$category = get_category( get_query_var( 'cat' ) );
		$cat_name = $category->name;
	} else if (is_single()) {
		$categories = get_the_category();
		$cat_name = MM_currentIssue();
		foreach ($categories as $category) {
			if (get_category($category->cat_ID)->category_parent == 408) {
				$cat_name = $category->name;
				$cat_id = $category->cat_ID;
			}
		}
	} else {
		$cat_name = MM_currentIssue();
		$cat_id = MM_currentIssueID();
	}
    
    $issueTitle = '<li class="navIssueTitle"><a href="' . get_category_link($cat_id) . '">' . $cat_name .'</a></li>';
    $newitems = $issueTitle . $items;
    return $newitems;
}

/**
 * Append connect links to the end of the wp-nav menu
 */ 
add_filter('wp_nav_menu_items', 'connectInNav', 10, 2);
function connectInNav($items, $args) {

	$style_dir = get_bloginfo('stylesheet_directory');
    $connect = '<li class="navConnect"><a href="http://mines.edu">Mines.edu</a></li><li class="navConnect"><a href="http://minesalumni.com">MinesAlumni.com</a></li>';
    // $connect = $connect . '<li class="navConnect"><a href="http://facebook.com/minesalumni"><img src="' . $style_dir . '/images/facebook20.jpg"></a><a href="http://twitter.com/minesalumni"><img src="' . $style_dir . '/images/twitter20.jpg"></a></li>';

    $newitems = $items . $connect;
    return $newitems;
}


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
 * ConnectWidget Class
 */
class MM_ConnectWidget extends WP_Widget {
	/** constructor */
	function MM_ConnectWidget() {
		parent::WP_Widget( 'MM_ConnectWidget', $name = 'Mines Connect Links' );
	}

	/** @see WP_Widget::widget */
	function widget( $args, $instance ) {
		?>
			<div class="MM_connect"><a href="http://mines.edu">Mines.edu</a><a href="http://minesalumni.com">MinesAlumni.com</a></div>
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

} // class MM_ConnectWidget

// register MM_ConnectWidget
add_action( 'widgets_init', create_function( '', 'return register_widget("MM_ConnectWidget");' ) );


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
		$arg = array('child_of'=>$issuesID, 'orderby'=>'id', 'order'=>'desc');
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
	function MM_currentIssue()  {
		$arg = array('child_of'=>408, 'orderby'=>'id', 'order'=>'desc');
		$issues=  get_categories($arg);
		return $issues[0]->cat_name;
	}

/**
 * Get ID of most recent issue
 */
	function MM_currentIssueID()  {
		$arg = array('child_of'=>408, 'orderby'=>'id', 'order'=>'desc');
		$issues=  get_categories($arg);
		return $issues[0]->cat_ID;
	}
	
/**
 * Get category of page
 */
	function MM_currentCategory()  {
		if( is_category() ) {
			$catid = get_query_var('cat');
			return $catid;
		} else {
			return 'Nope';
		}
	}
	
/**
 * Loop for archives
 */
	function IssuesArchiveLoop($verbose) {
		if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<div class="post" style="clear: both;">
					<h3 id="post-<?php the_ID(); ?>">
						<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php __('Permanent Link to');?> <?php the_title(); ?>">
							<?php the_title(); ?>
						</a>
					</h3>
					<?php if($verbose) { ?>
						<small>
							<?php the_time(__('M jS, Y')); ?>
							|
							<?php _e('By');?>
							<?php the_author_posts_link('namefl'); ?>
							<?php edit_post_link('Edit', ' | ', ''); ?>
						</small>
						<div class="entry" style="padding-bottom: 0px;">
							<?php if ( function_exists('has_post_thumbnail') && has_post_thumbnail() ) { // this is the default WordPress post thumbnail function
								the_post_thumbnail(array(prinz_get_option('prinz_archiveimage_width'),prinz_get_option('prinz_archiveimage_height')), array("class" =>  "alignleft"));
							} ?>
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

/*
 * Custom Metabox
 */
include('includes/homepageSetup.php');
//include('includes/demo.php');

/**
 * Query for homepage articles, for a given column
 */
	function MM_homepageStyleQuery( $issue, $column ) {
		$args = array( 
        'posts_per_page' => '-1',
        'orderby' => 'meta_value_num',
        'meta_key' => 'MM_homepageSetup_rank',
        'order' => 'ASC',
        'tax_query' => array(
          array(
            'taxonomy' => 'category',
            'field' => 'id',
            'terms' => array( $issue ),
            'operator' => 'AND',
          )
        ),
        'meta_query' => array(
          array(
            'key' => 'MM_homepageSetup_rank',
            'value' => '0',
            'compare' => '>'
          ),
          array(
            'key' => 'MM_homepageSetup_column',
            'value' => $column,
          )
        )
      );
      return new WP_Query( $args );
	}

/**
 * Puts the results of a query into boxes, specifically for the homepage
 */
	function MM_homepageBox( $article_query ) {

		global $childoptions;
		foreach ($childoptions as $value) {
	    	if (get_option( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; }
	    	else { $$value['id'] = get_option( $value['id'] ); }
	    }

		while ($article_query->have_posts()) : $article_query->the_post();
		    echo '<div class="post">';
		    	edit_post_link(__('Edit'),'<div class="homepageEdit">','</div>');
		    	$subject = get_post_meta(get_the_ID(), 'MM_homepageSetup_subject', TRUE);
		    	echo '<div class="subject">';
		    	if($subject != '') {
		    		echo $subject;
		    	} else {
		    		foreach((get_the_category()) as $chaine){ 
		    			if($chaine->parent == $MM_departmentCat) { 
		    				echo $chaine->cat_name . ' ';  
		    			}
					}
		    	}
		    	echo '</div>';
		    	if (get_post_meta(get_the_ID(), 'MM_homepageSetup_column', TRUE) == 'feature') {
		    		if ( function_exists('has_post_thumbnail') && has_post_thumbnail() ) {
						the_post_thumbnail(get_post_meta(get_the_ID(), 'MM_homepageSetup_imgSize', TRUE));
					}
		    		echo '<h3><a href="' . get_permalink() . '" rel="bookmark" class="title">' . get_the_title() . '</a></h3>';
					echo '<h4>By ' . get_the_author() . '</h4>';
		    	} else {
		    		echo '<h3><a href="' . get_permalink() . '" rel="bookmark" class="title">' . get_the_title() . '</a></h3>';
					echo '<h4>By ' . get_the_author() . '</h4>';
					if ( function_exists('has_post_thumbnail') && has_post_thumbnail() ) {
						the_post_thumbnail(get_post_meta(get_the_ID(), 'MM_homepageSetup_imgSize', TRUE));
					}
		    	}
				the_excerpt();
		    echo '</div>';
    	endwhile;
    	wp_reset_query();
	}

/**
 * Force sub-categories to use the parent category template
 * By: Drew Jaynes
 * http://werdswords.com/force-sub-categories-use-the-parent-category-template/
 */
	function new_subcategory_hierarchy() { 
	    $category = get_queried_object();
	 
	    $parent_id = $category->category_parent;
	 
	    $templates = array();
	     
	    if ( $parent_id == 0 ) {
	        // Use default values from get_category_template()
	        $templates[] = "category-{$category->slug}.php";
	        $templates[] = "category-{$category->term_id}.php";
	        $templates[] = 'category.php';     
	    } else {
	        // Create replacement $templates array
	        $parent = get_category( $parent_id );
	 
	        // Current first
	        $templates[] = "category-{$category->slug}.php";
	        $templates[] = "category-{$category->term_id}.php";
	 
	        // Parent second
	        $templates[] = "category-{$parent->slug}.php";
	        $templates[] = "category-{$parent->term_id}.php";
	        $templates[] = 'category.php'; 
	    }
	    return locate_template( $templates );
	}
	 
	add_filter( 'category_template', 'new_subcategory_hierarchy' );

/**
 * Custom bulk and quick edits
 * Guide by: Rachel Carden
 * http://wpdreamer.com/2012/03/manage-wordpress-posts-using-bulk-edit-and-quick-edit/
 */
	add_filter( 'manage_posts_columns', 'MM_managing_placement_column', 10, 2 );
	function MM_managing_placement_column( $columns, $post_type ) {
		$new_columns = array();
		foreach( $columns as $key => $value ) {
			$new_columns[ $key ] = $value;
			if ( $key == 'categories' ) {
				$new_columns[ 'MM_column' ] = 'Col';
				$new_columns[ 'MM_rank' ] = 'Rank';
			}
		}
		return $new_columns;
	}

	add_action( 'manage_posts_custom_column', 'MM_populating_placement_column', 10, 2 );
	function MM_populating_placement_column( $column_name, $post_id ) {
	    switch( $column_name ) {
			case 'MM_column':
				echo '<div id="MM_column-' . $post_id . '">' . get_post_meta( $post_id, 'MM_homepageSetup_column', true ) . '</div>';
				break;
			case 'MM_rank':
				echo '<div id="MM_rank-' . $post_id . '">' . get_post_meta( $post_id, 'MM_homepageSetup_rank', true ) . '</div>';
				break;
	    }
	}

	add_action( 'bulk_edit_custom_box', 'MM_add_to_bulk_quick_edit_custom_box', 10, 2 );
	add_action( 'quick_edit_custom_box', 'MM_add_to_bulk_quick_edit_custom_box', 10, 2 );
	function MM_add_to_bulk_quick_edit_custom_box( $column_name, $post_type ) {
		switch( $column_name ) {
			case 'MM_column':
				?><fieldset class="inline-edit-col">
					<div class="inline-edit-group">
                        <span class="title">Column:</span>
                        <input type="text" name="MM_homepageSetup_column" size="15" value="" />
	                </div>
	            </fieldset><?php
	            break;
			case 'MM_rank':
				?><fieldset class="inline-edit-col">
	                <div class="inline-edit-group">
                        <span class="title">Rank:</span>
                        <input type="text" name="MM_homepageSetup_rank" size="5" value="" />
	                </div>
	            </fieldset><?php
	            break;
		}
	}
		/*<select name="MM_homepageSetup_column" value="">
        	<option value="left">Left</option>
        	<option value="center">Center</option>
        	<option value="right">Right</option>
        	<option value="feature">Feature</option>
        </select>*/

	add_action( 'admin_print_scripts-edit.php', 'MM_enqueue_edit_scripts' );
	function MM_enqueue_edit_scripts() {
		wp_enqueue_script( 'MM-admin-edit', get_bloginfo( 'stylesheet_directory' ) . '/includes/quick_edit.js', array( 'jquery', 'inline-edit-post' ), '', true );
	}

	add_action( 'save_post','MM_save_post', 10, 2 );
	function MM_save_post( $post_id, $post ) {

	   // don't save for autosave
	  	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
	   		return $post_id;

		// dont save for revisions
		if ( isset( $post->post_type ) && $post->post_type == 'revision' )
			return $post_id;

		// placement
		// Because this action is run in several places, checking for the array key keeps WordPress from editing
		// data that wasn't in the form, i.e. if you had this post meta on your "Quick Edit" but didn't have it
		// on the "Edit Post" screen.
		if ( array_key_exists( 'MM_homepageSetup_column', $_POST ) )
		    update_post_meta( $post_id, 'MM_homepageSetup_column', $_POST[ 'MM_homepageSetup_column' ] );
		if ( array_key_exists( 'MM_homepageSetup_rank', $_POST ) )
		    update_post_meta( $post_id, 'MM_homepageSetup_rank', $_POST[ 'MM_homepageSetup_rank' ] );
	}

	add_action( 'wp_ajax_MM_save_bulk_edit', 'MM_save_bulk_edit' );
	function MM_save_bulk_edit() {
	   // get our variables
	   $post_ids = ( isset( $_POST[ 'post_ids' ] ) && !empty( $_POST[ 'post_ids' ] ) ) ? $_POST[ 'post_ids' ] : array();
	   $MM_homepageSetup_column = ( isset( $_POST[ 'MM_homepageSetup_column' ] ) && !empty( $_POST[ 'MM_homepageSetup_column' ] ) ) ? $_POST[ 'MM_homepageSetup_column' ] : NULL;
	   $MM_homepageSetup_rank = ( isset( $_POST[ 'MM_homepageSetup_rank' ] ) && !empty( $_POST[ 'MM_homepageSetup_rank' ] ) ) ? $_POST[ 'MM_homepageSetup_rank' ] : NULL;
	   // if everything is in order
	   if ( !empty( $post_ids ) && is_array( $post_ids ) && !empty( $MM_homepageSetup_column ) && !empty( $MM_homepageSetup_rank ) ) {
	      foreach( $post_ids as $post_id ) {
	         update_post_meta( $post_id, 'MM_homepageSetup_column', $MM_homepageSetup_column );
	         update_post_meta( $post_id, 'MM_homepageSetup_rank', $MM_homepageSetup_rank );
	      }
	   }
	}
?>
