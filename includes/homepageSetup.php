<?php

$prefix = 'MM_homepageSetup';

global $meta_boxes;

$meta_boxes = array();

$meta_boxes[] = array(
	// Meta box id, UNIQUE per meta box. Optional since 4.1.5
	'id' => 'homepageSetup',

	// Meta box title - Will appear at the drag and drop handle bar. Required.
	'title' => __( 'Homepage Setup', 'rwmb' ),

	// Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
	'pages' => array( 'post', 'page' ),

	// Where the meta box appear: normal (default), advanced, side. Optional.
	'context' => 'side',

	// Order of meta box: high (default), low. Optional.
	'priority' => 'high',

	// Auto save: true, false (default). Optional.
	'autosave' => true,

	// List of meta fields
	'fields' => array(
		// COLUMN
		array(
			'name'     => __( 'Select', 'rwmb' ),
			'id'       => "{$prefix}_column",
			'type'     => 'select',
			// Array of 'value' => 'Label' pairs for select box
			'options'  => array(
				'left' => __( 'Left Column', 'rwmb' ),
				'center' => __( 'Center Column', 'rwmb' ),
				'right' => __( 'Right Column', 'rwmb' ),
				'feature' => __( 'Feature', 'rwmb' ),
			),
			// Select multiple values, optional. Default is false.
			'multiple' => false,
			'std'	=> __( 'Select an column', 'rwmb' ),
		),
		// RANK
		array(
			'name' => __( 'Rank', 'rwmb' ),
			'id'   => "{$prefix}_rank",
			'type' => 'number',
			'desc' => 'Numeric order on the homepage (lower number means higher priority).',
			'min'  => 0,
			'step' => 5,
		),
		// SUBJECT
		array(
			// Field name - Will be used as label
			'name'  => __( 'Subject Area', 'rwmb' ),
			// Field ID, i.e. the meta key
			'id'    => "{$prefix}_subject",
			// Field description (optional)
			'desc'  => __( 'Optional, intended for Inside Mines articles.  If provided, the subject area will display instead of the department heading.', 'rwmb' ),
			'type'  => 'text',
			// Default value (optional)
			//'std'   => __( 'Default text value', 'rwmb' ),
			// CLONES: Add to make the field cloneable (i.e. have multiple value)
		),
	)
);

/********************* META BOX REGISTERING ***********************/

/**
 * Register meta boxes
 *
 * @return void
 */
function MM_homepageSetup_register_meta_boxes()
{
	// Make sure there's no errors when the plugin is deactivated or during upgrade
	if ( !class_exists( 'RW_Meta_Box' ) )
		return;

	global $meta_boxes;
	foreach ( $meta_boxes as $meta_box )
	{
		new RW_Meta_Box( $meta_box );
	}
}
// Hook to 'admin_init' to make sure the meta box class is loaded before
// (in case using the meta box class in another plugin)
// This is also helpful for some conditionals like checking page template, categories, etc.
add_action( 'admin_init', 'MM_homepageSetup_register_meta_boxes' );

?>