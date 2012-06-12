<?php
/**
 * Options page for the theme
 */
// the name of the theme
$childname = "Child-Theme";
// an abbreviation of the theme's name
$childshortname = "bmct";

$childoptions = array (
	array ( "name" => "Welcome Message",
			"type" => "title"),

	array ( "type" => "open"),

	array (	"name" => "Archive's Department Order",
			"desc" => "Comma seperated list of category IDs for the order in which you want the departments displayed in the archive pages.",
			"id" => $childshortname . "_department_order",
			"type" => "text",
			"std" => __("") ),
			
	array (	"name" => "Verbose Departments",
			"desc" => "Comma seperated list of category IDs for departments that should have snippet description.",
			"id" => $childshortname . "_verbose",
			"type" => "text",
			"std" => __("") ),

	array(    "type" => "close")
);

function childtheme_add_admin() {

    global $childname, $childshortname, $childoptions;

    if ( $_GET['page'] == basename(__FILE__) ) {

        if ( 'save' == $_REQUEST['action'] ) {

                foreach ($childoptions as $value) {
                    update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }

                foreach ($childoptions as $value) {
                    if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }

                header("Location: themes.php?page=child_options.php&saved=true");
                die;

        } else if( 'reset' == $_REQUEST['action'] ) {

            foreach ($childoptions as $value) {
                delete_option( $value['id'] ); }

            header("Location: themes.php?page=child_options.php&reset=true");
            die;

        }
    }

    add_theme_page($childname." Options", "".$childname." Options", 'edit_themes', basename(__FILE__), 'childtheme_admin');

}

function childtheme_admin() {

    global $childname, $childshortname, $childoptions;

    if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$childname.' settings saved.</strong></p></div>';
    if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$childname.' settings reset.</strong></p></div>';

?>
<div class="wrap">
<h2><?php echo $childname; ?> settings</h2>

<form method="post">

<?php foreach ($childoptions as $value) {

switch ( $value['type'] ) {

case "open":
?>
<table width="100%" border="0" style="background-color:#eef5fb; padding:10px;">

<?php break;

case "close":
?>

</table><br />

<?php break;

case "title":
?>
<table width="100%" border="0" style="background-color:#dceefc; padding:5px 10px;"><tr>
    <td colspan="2"><h3 style="font-family:Georgia,'Times New Roman',Times,serif;"><?php echo $value['name']; ?></h3></td>
</tr>

<?php break;

case 'text':
?>

<tr>
    <td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
    <td width="80%"><input style="width:400px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></td>
</tr>

<tr>
    <td><small><?php echo $value['desc']; ?></small></td>
</tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>

<?php
break;
}
}
?>
<p class="submit">
<input name="save" type="submit" value="Save changes" />
<input type="hidden" name="action" value="save" />
</p>
</form>
<form method="post">
<p class="submit">
<input name="reset" type="submit" value="Reset" />
<input type="hidden" name="action" value="reset" />
</p>
</form>

<?php
}

add_action('admin_menu', 'childtheme_add_admin');