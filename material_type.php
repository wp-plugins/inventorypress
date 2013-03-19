<?php 
/**
 * 
 * CashPress
 * Custom post type and admin input fields for material data
 * 
**/

add_action('init', 'materials');

function materials(){
  $labels = array(
    'name' => _x('Materials', 'post type general name'),
    'singular_name' => _x('Material', 'post type singular name'),
    'add_new' => _x('New Material', 'material'),
    'add_new_item' => __('Create New Material'),
    'edit_item' => __('Edit Material'),
    'new_item' => __('New Material'),
    'view_item' => __('View Material'),
    'search_items' => __('Search Materials'),
    'not_found' =>  __('No materials found'),
    'not_found_in_trash' => __('No materials found in Trash'), 
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'exclude_from_search' => true,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => 41,
    'menu_icon' => plugins_url() . '/inventorypress/images/material_icon.png',
    'supports' => array('title')
  ); 
  register_post_type('materials',$args);
}

// Add filter to insure the material is displayed when user updates a material

add_filter('post_updated_messages', 'material_updated_messages');
function material_updated_messages( $messages ) {

  $messages['materials'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Material updated. <a href="%s">View Material</a>'), esc_url( get_permalink(@$post_id) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Material updated.'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Material restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Material published. <a href="%s">View material</a>'), esc_url( get_permalink(@$post_ID) ) ),
    7 => __('Material saved.'),
    8 => sprintf( __('Material submitted. <a target="_blank" href="%s">Preview material</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink(@$post_ID) ) ) ),
    9 => sprintf( __('Material scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview material</a>'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( @$post->post_date ) ), esc_url( get_permalink(@$post_ID) ) ),
    10 => sprintf( __('Material draft updated. <a target="_blank" href="%s">Material</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink(@$post_ID) ) ) ),
  );

  return @$messages;
}

  
/*========================= First Custom Field Section ========================*/
	function material_metadata(){  
        global $post; 
        $custom = get_post_custom($post->ID);  
        $notes = $custom["notes"][0]; 
        

        
        echo '<input type="hidden" name="csp-nonce" id="csp-nonce" value="' .wp_create_nonce('tc-m'). '" />';
?>  
<div class="material_metadata">
    
    <div class="right"><label><?php _e("Notes:",'cashpress'); ?></label><br/><textarea name="notes"><?php echo $notes; ?></textarea></div>
      

</div>

<?php  
}  
    
function add_material_metadata(){  
        add_meta_box('material_metadata', __('Material Details', 'csp_material_metadata'), 'material_metadata', 'materials', 'normal', 'low');  
} 
    
add_action('admin_init', 'add_material_metadata'); 
   

    
/*====================== Saves all Custom Field Data ======================*/    
function save_meta_material($post_id){  
		
		if (!wp_verify_nonce($_POST['csp-nonce'], 'tc-m')) return $post_id;
		
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
	
	   	update_post_meta($post_id, "notes", $_POST["notes"]);  
	   	
}  
	
	
add_action('save_post', 'save_meta_material'); 


// Creating the column layout when viewing list of Materials in the backend
add_action("manage_posts_custom_column",  "materials_custom_columns");
add_filter("manage_edit-materials_columns", "materials_edit_columns");
 
function materials_edit_columns($columns){
  $columns = array(
    "cb" => "<input type=\"checkbox\" />",
    "title" => "Material",
      );
 
  return $columns;
}

function materials_custom_columns($column)
{
	global $post;
	$custom = get_post_custom($post->ID);
	
	if ("ID" == $column) echo $post->ID; //displays title
	elseif ("notes" == $column) echo $custom['notes'][0] ; //displays the content excerpt
}


?>
