<?php 
/**
 * 
 * CashPress
 * Custom post type and admin input fields for product data
 * 
**/

add_action('init', 'products');

function products(){
  $labels = array(
    'name' => _x('Products', 'post type general name'),
    'singular_name' => _x('Product', 'post type singular name'),
    'add_new' => _x('New Product', 'product'),
    'add_new_item' => __('Create New Product'),
    'edit_item' => __('Edit Product'),
    'new_item' => __('New Product'),
    'view_item' => __('View Product'),
    'search_items' => __('Search Products'),
    'not_found' =>  __('No products found'),
    'not_found_in_trash' => __('No products found in Trash'), 
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
    'menu_position' => 42,
    'menu_icon' => plugins_url() . '/inventorypress/images/product_icon.png',
    'supports' => array('title')
  ); 
  register_post_type('products',$args);
}

// Add filter to insure the product is displayed when user updates a product

add_filter('post_updated_messages', 'product_updated_messages');
function product_updated_messages( $messages ) {

  $messages['products'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Product updated. <a href="%s">View Product</a>'), esc_url( get_permalink(@$post_id) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Product updated.'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Product restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Product published. <a href="%s">View product</a>'), esc_url( get_permalink(@$post_ID) ) ),
    7 => __('Product saved.'),
    8 => sprintf( __('Product submitted. <a target="_blank" href="%s">Preview product</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink(@$post_ID) ) ) ),
    9 => sprintf( __('Product scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview product</a>'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( @$post->post_date ) ), esc_url( get_permalink(@$post_ID) ) ),
    10 => sprintf( __('Product draft updated. <a target="_blank" href="%s">Product</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink(@$post_ID) ) ) ),
  );

  return @$messages;
}

  
/*========================= First Custom Field Section ========================*/
	function product_metadata(){  
        global $post; 
        $custom = get_post_custom($post->ID);  
        $notes = $custom["notes"][0]; 
        

        
        echo '<input type="hidden" name="csp-nonce" id="csp-nonce" value="' .wp_create_nonce('tc-m'). '" />';
?>  
<div class="product_metadata">
    
    <div class="right"><label><?php _e("Notes:",'cashpress'); ?></label><br/><textarea name="notes"><?php echo $notes; ?></textarea></div>
      

</div>

<?php  
}  
    
function add_product_metadata(){  
        add_meta_box('product_metadata', __('Product Details', 'csp_product_metadata'), 'product_metadata', 'products', 'normal', 'low');  
} 
    
add_action('admin_init', 'add_product_metadata'); 
   

    
/*====================== Saves all Custom Field Data ======================*/    
function save_meta_product($post_id){  
		
		if (!wp_verify_nonce($_POST['csp-nonce'], 'tc-m')) return $post_id;
		
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
	
	   	update_post_meta($post_id, "notes", $_POST["notes"]);  
	   	
}  
	
	
add_action('save_post', 'save_meta_product'); 


// Creating the column layout when viewing list of Products in the backend
add_action("manage_posts_custom_column",  "products_custom_columns");
add_filter("manage_edit-products_columns", "products_edit_columns");
 
function products_edit_columns($columns){
  $columns = array(
    "cb" => "<input type=\"checkbox\" />",
    "title" => "Product",
      );
 
  return $columns;
}

function products_custom_columns($column)
{
	global $post;
	$custom = get_post_custom($post->ID);
	
	if ("ID" == $column) echo $post->ID; //displays title
	elseif ("notes" == $column) echo $custom['notes'][0] ; //displays the content excerpt
}


?>
