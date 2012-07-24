<?php 
/**
 * 
 * CashPress
 * Custom post type and admin input fields for brand data
 * 
**/

add_action('init', 'brands');

function brands(){
  $labels = array(
    'name' => _x('Brands', 'post type general name'),
    'singular_name' => _x('Brand', 'post type singular name'),
    'add_new' => _x('New Brand', 'brand'),
    'add_new_item' => __('Create New Brand'),
    'edit_item' => __('Edit Brand'),
    'new_item' => __('New Brand'),
    'view_item' => __('View Brand'),
    'search_items' => __('Search Brands'),
    'not_found' =>  __('No brands found'),
    'not_found_in_trash' => __('No brands found in Trash'), 
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
    'menu_position' => 43,
    'menu_icon' => plugins_url() . '/cashpress/images/brand_icon.png',
    'supports' => array('title')
  ); 
  register_post_type('brands',$args);
}

// Add filter to insure the brand is displayed when user updates a brand

add_filter('post_updated_messages', 'brand_updated_messages');
function brand_updated_messages( $messages ) {

  $messages['brands'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Brand updated. <a href="%s">View Brand</a>'), esc_url( get_permalink(@$post_id) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Brand updated.'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Brand restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Brand published. <a href="%s">View brand</a>'), esc_url( get_permalink(@$post_ID) ) ),
    7 => __('Brand saved.'),
    8 => sprintf( __('Brand submitted. <a target="_blank" href="%s">Preview brand</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink(@$post_ID) ) ) ),
    9 => sprintf( __('Brand scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview brand</a>'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( @$post->post_date ) ), esc_url( get_permalink(@$post_ID) ) ),
    10 => sprintf( __('Brand draft updated. <a target="_blank" href="%s">Brand</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink(@$post_ID) ) ) ),
  );

  return @$messages;
}

  
/*========================= First Custom Field Section ========================*/
	function brand_metadata(){  
        global $post; 
        $custom = get_post_custom($post->ID);  
        $company = $custom["company"][0]; 
        $address1 = $custom["address1"][0]; 
        $address2 = $custom["address2"][0]; 
        $address3 = $custom["address3"][0]; 
        $phone = $custom["phone"][0]; 
        $notes = $custom["notes"][0]; 
        $email = $custom["email"][0];
        $password = $custom["password"][0];

        
        echo '<input type="hidden" name="csp-nonce" id="csp-nonce" value="' .wp_create_nonce('tc-m'). '" />';
?>  
<div class="brand_metadata">
    
    <label><?php _e("Company:",'cashpress'); ?></label><input name="company" value="<?php echo $company; ?>" /><br/> 
    <label><?php _e("Address 1:",'cashpress'); ?></label><input name="address1" value="<?php echo $address1; ?>" /><br/>
    <label><?php _e("Address 2:",'cashpress'); ?></label><input name="address2" value="<?php echo $address2; ?>" /><br/>
    <label><?php _e("Address 3:",'cashpress'); ?></label><input name="address3" value="<?php echo $address3; ?>" /><br/>
    <label><?php _e("Phone:",'cashpress'); ?></label><input name="phone" value="<?php echo $phone; ?>" /><br/>
    <label><?php _e("Email Address:",'cashpress'); ?></label><input name="email" value="<?php echo $email; ?>" /><br/>
    <div class="right"><label><?php _e("Private Notes:",'cashpress'); ?></label><br/><textarea name="notes"><?php echo $notes; ?></textarea></div>
      

</div>

<?php  
}  
    
function add_brand_metadata(){  
        add_meta_box('brand_metadata', __('Brand Details', 'csp_brand_metadata'), 'brand_metadata', 'brands', 'normal', 'low');  
} 
    
add_action('admin_init', 'add_brand_metadata'); 
   

    
/*====================== Saves all Custom Field Data ======================*/    
function save_meta_brand($post_id){  
		
		if (!wp_verify_nonce($_POST['csp-nonce'], 'tc-m')) return $post_id;
		
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
	
	   	update_post_meta($post_id, "company", $_POST["company"]);
	   	update_post_meta($post_id, "address1", $_POST["address1"]);  
	   	update_post_meta($post_id, "address2", $_POST["address2"]);  
	   	update_post_meta($post_id, "address3", $_POST["address3"]);  
	   	update_post_meta($post_id, "phone", $_POST["phone"]);  
	   	update_post_meta($post_id, "notes", $_POST["notes"]);  
	   	update_post_meta($post_id, "password", $_POST["password"]); 
	   	update_post_meta($post_id, "email", $_POST["email"]); 
	   	update_post_meta($post_id, "pubnotes", $_POST["pubnotes"]); 
	      
}  
	
	
add_action('save_post', 'save_meta_brand'); 


// Creating the column layout when viewing list of Brands in the backend
add_action("manage_posts_custom_column",  "brands_custom_columns");
add_filter("manage_edit-brands_columns", "brands_edit_columns");
 
function brands_edit_columns($columns){
  $columns = array(
    "cb" => "<input type=\"checkbox\" />",
    "title" => "Brand",
    "address1" => "Address",
    "address2" => "City State Zip",
    "phone" => "Phone",
    "email" => "Email",
  );
 
  return $columns;
}

function brands_custom_columns($column)
{
	global $post;
	$custom = get_post_custom($post->ID);
	
	if ("ID" == $column) echo $post->ID; //displays title
	elseif ("address1" == $column) echo $custom['address1'][0] ; //displays the content excerpt
	elseif ("address2" == $column) echo $custom['address2'][0] ; //displays the content excerpt
	elseif ("phone" == $column) echo $custom['phone'][0] ; //displays the content excerpt
	elseif ("email" == $column) echo $custom['email'][0] ; //shows up our post thumbnail that we previously created.
}


?>
