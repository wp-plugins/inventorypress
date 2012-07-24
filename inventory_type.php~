<?php 
/*
Plugin Name: InventoryPress
Plugin URI: http://hateyourwebsite.com/inventorypress.html
Description: Easily Manage Your Entire Inventory Using a Small Yet Powerful Set of Custom Post Types.
Version: v1.7
Author: Nolan Dempster
Author URI: http://www.hateyourwebsite.com
License: GPL2
*/

add_filter('gettext','invpress_custom_enter_title');
function invpress_custom_enter_title( $input ) {

    global $post_type;

    if( is_admin() && 'Enter title here' == $input && 'inventory' == $post_type )
        return 'Enter UPC or Inventory Control Number Here';


    return $input;
}


//custom post type
add_action('init', 'inventory');

function inventory(){
  $labels = array(
    'name' => _x('Inventory', 'post type general name'),
    'singular_name' => _x('Inventory', 'post type singular name'),
    'add_new' => _x('New Inventory Item', 'inventory'),
    'add_new_item' => __('Create New Inventory Item'),
    'edit_item' => __('Edit Inventory Item'),
    'new_item' => __('New Inventory Item'),
    'view_item' => __('View Inventory Item'),
    'search_items' => __('Search Inventory Items'),
    'not_found' =>  __('No Inventory Items found'),
    'not_found_in_trash' => __('No inventorys found in Trash'), 
    'parent_timecardcolon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'exclude_from_search' => false,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => 40,
    'menu_icon' => plugins_url() . '/cashpress/images/inventory_icon.png',
    'supports' => array('')
  ); 
  register_post_type('inventory',$args);

//sanitize_title( $inventory_item_part , $inventory_item_part );
}

// Add filter to insure the inventory is displayed when user updates a inventory

add_filter('post_updated_messages', 'inventory_updated_messages');
function inventory_updated_messages( $messages ) {

  @$messages['inventory'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Inventory updated. <a href="%s">View Inventory</a>'), esc_url( get_permalink($post_id) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Inventory updated.'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Inventory restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Inventory published. <a href="%s">View inventory</a>'), esc_url( get_permalink(@$post_ID) ) ),
    7 => __('Inventory saved.'),
    8 => sprintf( __('Inventory submitted. <a target="_blank" href="%s">Preview inventory</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink(@$post_ID) ) ) ),
    9 => sprintf( __('Inventory scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview inventory</a>'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink(@$post_ID) ) ),
    10 => sprintf( __('Inventory draft updated. <a target="_blank" href="%s">Inventory</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink(@$post_ID) ) ) ),
  );

  return $messages;
}

  
/*============== First Custom Field Section ========================*/
	function inventory_metadata(){  
        global $post; 
        @$custom = get_post_custom($post->ID);
	@$inventory_item_at_cost = $custom["inventory_item_at_cost"][0];	       	
	@$inventory_item_at_msrp = $custom["inventory_item_at_msrp"][0];	       	
	@$inventory_item_reg_price = $custom["inventory_item_reg_price"][0];	       	
	@$inventory_item_on_sale = $custom["inventory_item_on_sale"][0];	       	
	@$inventory_item_desc = $custom["inventory_item_desc"][0];	       	
	@$inventory_item_upc = $custom["inventory_item_upc"][0];	       	
	@$inventory_item_part_grp = $custom["inventory_item_part_grp"][0];
	@$inventory_item_style = $custom["inventory_item_style"][0];
       	@$inventory_item_quantity = $custom["inventory_item_quantity"][0];
	@$inventory_material_color1 = $custom["inventory_material_color1"][0];
	@$inventory_material_color2 = $custom["inventory_material_color2"][0];	
	@$inventory_material_size1 = $custom["inventory_material_size1"][0];
	@$inventory_material_size2 = $custom["inventory_material_size2"][0];
	@$inventory_material_size3 = $custom["inventory_material_size3"][0];
	@$inventory_materialtype = $custom["inventory_materialtype"][0];
	@$inventory_producttype = $custom["inventory_producttype"][0];
	@$materialtype = get_posts('post_type=materials&numberposts=-1');
	@$inventory_brandname = $custom["inventory_brandname"][0]; 
        @$brandname = get_posts('post_type=brands&numberposts=-1');
        @$inventory_producttype = $custom["inventory_producttype"][0];
	@$producttype = get_posts('post_type=products&numberposts=-1');
	
        echo '<input type="hidden" name="inv-nonce" id="inv-nonce" value="' .wp_create_nonce('in-v'). '" />';
?>  
<table>
<div class="inventory_metadata">
<label>Brand:</label>
    <select name="inventory_brandname">
    	<option selected="yes" ><?php echo $inventory_brandname; ?></option>
    	<?php 
    	foreach($brandname as $cspbrandvalue){
    	echo '<option>' . $cspbrandvalue->post_title . '</option>' ."\n";
    	}
		?>
    </select>
<label>Product Type:</label>    
	<select name="inventory_producttype">
    	<option selected="yes" ><?php echo $inventory_producttype; ?></option>
    	<?php 
    	foreach($producttype as $cspproductvalue){
    	echo '<option>' . $cspproductvalue->post_title . '</option>' ."\n";
    	}
		?>
    </select>
<label>Item Group:</label><input name="inventory_item_part_grp" value="<?php echo @$inventory_item_part_grp; ?>" size="12"/>
<label>Style Name/No. :</label><input name="inventory_item_style" value="<?php echo @$inventory_item_style; ?>" size="12"/>
<label>UPC/ID/Serial No. :</label><input name="inventory_item_upc" value="<?php echo @$inventory_item_upc; ?>" size="12"/>
<br><br>
<label>Material Type:</label>    
	<select name="inventory_materialtype">
    	<option selected="yes" ><?php echo $inventory_materialtype; ?></option>
    	<?php 
    	foreach($materialtype as $cspmaterialvalue){
    	echo '<option>' . $cspmaterialvalue->post_title . '</option>' ."\n";
    	}
	?>
    </select>    
<label>Size 1:</label>
<select name="inventory_material_size1">
 	<option selected="yes"><?php echo $inventory_material_size1; ?></option>
	<option>1/8"</option>
<option>1/4"</option>
<option>3/8"</option>
<option>1/2"</option>
<option>5/8"</option>
<option>3/4"</option>
<option>7/8"</option>
<option>1"</option>
<option>1 1/8"</option>
<option>1 1/4"</option>
<option>1 3/8"</option>
<option>1 1/2"</option>
<option>1 5/8"</option>
<option>1 3/4"</option>
<option>1 7/8"</option>
<option>2"</option>
<option>2 1/8"</option>
<option>2 1/4"</option>
<option>2 3/8"</option>
<option>2 1/2"</option>
<option>2 5/8"</option>
<option>2 3/4"</option>
<option>2 7/8"</option>
<option>3"</option>
<option>3 1/8"</option>
<option>3 1/4"</option>
<option>3 3/8"</option>
<option>3 1/2"</option>
<option>3 5/8"</option>
<option>3 3/4"</option>
<option>3 7/8"</option>
<option>4"</option>
<option>4 1/8"</option>
<option>4 1/4"</option>
<option>4 3/8"</option>
<option>4 1/2"</option>
<option>4 5/8"</option>
<option>4 3/4"</option>
<option>4 7/8"</option>
<option>5"</option>
<option>5 1/8"</option>
<option>5 1/4"</option>
<option>5 3/8"</option>
<option>5 1/2"</option>
<option>5 5/8"</option>
<option>5 3/4"</option>
<option>5 7/8"</option>
<option>6"</option>
<option>6 1/8"</option>
<option>6 1/4"</option>
<option>6 3/8"</option>
<option>6 1/2"</option>
<option>6 5/8"</option>
<option>6 3/4"</option>
<option>6 7/8"</option>
<option>7"</option>
<option>7 1/8"</option>
<option>7 1/4"</option>
<option>7 3/8"</option>
<option>7 1/2"</option>
<option>7 5/8"</option>
<option>7 3/4"</option>
<option>7 7/8"</option>
<option>8"</option>
<option>8 1/8"</option>
<option>8 1/4"</option>
<option>8 3/8"</option>
<option>8 1/2"</option>
<option>8 5/8"</option>
<option>8 3/4"</option>
<option>8 7/8"</option>
<option>9"</option>
<option>9 1/8"</option>
<option>9 1/4"</option>
<option>9 3/8"</option>
<option>9 1/2"</option>
<option>9 5/8"</option>
<option>9 3/4"</option>
<option>9 7/8"</option>
<option>10"</option>
<option>10 1/8"</option>
<option>10 1/4"</option>
<option>10 3/8"</option>
<option>10 1/2"</option>
<option>10 5/8"</option>
<option>10 3/4"</option>
<option>10 7/8"</option>
<option>11"</option>
<option>11 1/8"</option>
<option>11 1/4"</option>
<option>11 3/8"</option>
<option>11 1/2"</option>
<option>11 5/8"</option>
<option>11 3/4"</option>
<option>11 7/8"</option>
<option>12"</option>
<option>12 1/8"</option>
<option>12 1/4"</option>
<option>12 3/8"</option>
<option>12 1/2"</option>
<option>12 5/8"</option>
<option>12 3/4"</option>
<option>12 7/8"</option>
<option>13"</option>
<option>13 1/8"</option>
<option>13 1/4"</option>
<option>13 3/8"</option>
<option>13 1/2"</option>
<option>13 5/8"</option>
<option>13 3/4"</option>
<option>13 7/8"</option>
<option>14"</option>
<option>14 1/8"</option>
<option>14 1/4"</option>
<option>14 3/8"</option>
<option>14 1/2"</option>
<option>14 5/8"</option>
<option>14 3/4"</option>
<option>14 7/8"</option>
<option>15"</option>
<option>15 1/8"</option>
<option>15 1/4"</option>
<option>15 3/8"</option>
<option>15 1/2"</option>
<option>15 5/8"</option>
<option>15 3/4"</option>
<option>15 7/8"</option>
<option>16"</option>
<option>16 1/8"</option>
<option>16 1/4"</option>
<option>16 3/8"</option>
<option>16 1/2"</option>
<option>16 5/8"</option>
<option>16 3/4"</option>
<option>16 7/8"</option>
<option>17"</option>
<option>17 1/8"</option>
<option>17 1/4"</option>
<option>17 3/8"</option>
<option>17 1/2"</option>
<option>17 5/8"</option>
<option>17 3/4"</option>
<option>17 7/8"</option>
<option>18"</option>
<option>18 1/8"</option>
<option>18 1/4"</option>
<option>18 3/8"</option>
<option>18 1/2"</option>
<option>18 5/8"</option>
<option>18 3/4"</option>
<option>18 7/8"</option>
<option>19"</option>
<option>19 1/8"</option>
<option>19 1/4"</option>
<option>19 3/8"</option>
<option>19 1/2"</option>
<option>19 5/8"</option>
<option>19 3/4"</option>
<option>19 7/8"</option>
<option>20"</option>
<option>20 1/8"</option>
<option>20 1/4"</option>
<option>20 3/8"</option>
<option>20 1/2"</option>
<option>20 5/8"</option>
<option>20 3/4"</option>
<option>20 7/8"</option>
<option>21"</option>
<option>21 1/8"</option>
<option>21 1/4"</option>
<option>21 3/8"</option>
<option>21 1/2"</option>
<option>21 5/8"</option>
<option>21 3/4"</option>
<option>21 7/8"</option>
<option>22"</option>
<option>22 1/8"</option>
<option>22 1/4"</option>
<option>22 3/8"</option>
<option>22 1/2"</option>
<option>22 5/8"</option>
<option>22 3/4"</option>
<option>22 7/8"</option>
<option>23"</option>
<option>23 1/8"</option>
<option>23 1/4"</option>
<option>23 3/8"</option>
<option>23 1/2"</option>
<option>23 5/8"</option>
<option>23 3/4"</option>
<option>23 7/8"</option>
<option>24"</option>
<option>24 1/8"</option>
<option>24 1/4"</option>
<option>24 3/8"</option>
<option>24 1/2"</option>
<option>24 5/8"</option>
<option>24 3/4"</option>
<option>24 7/8"</option>
<option>25"</option>
<option>25 1/8"</option>
<option>25 1/4"</option>
<option>25 3/8"</option>
<option>25 1/2"</option>
<option>25 5/8"</option>
<option>25 3/4"</option>
<option>25 7/8"</option>
<option>26"</option>
<option>26 1/8"</option>
<option>26 1/4"</option>
<option>26 3/8"</option>
<option>26 1/2"</option>
<option>26 5/8"</option>
<option>26 3/4"</option>
<option>26 7/8"</option>
<option>27"</option>
<option>27 1/8"</option>
<option>27 1/4"</option>
<option>27 3/8"</option>
<option>27 1/2"</option>
<option>27 5/8"</option>
<option>27 3/4"</option>
<option>27 7/8"</option>
<option>28"</option>
<option>28 1/8"</option>
<option>28 1/4"</option>
<option>28 3/8"</option>
<option>28 1/2"</option>
<option>28 5/8"</option>
<option>28 3/4"</option>
<option>28 7/8"</option>
<option>29"</option>
<option>29 1/8"</option>
<option>29 1/4"</option>
<option>29 3/8"</option>
<option>29 1/2"</option>
<option>29 5/8"</option>
<option>29 3/4"</option>
<option>29 7/8"</option>
<option>30"</option>
<option>30 1/8"</option>
<option>30 1/4"</option>
<option>30 3/8"</option>
<option>30 1/2"</option>
<option>30 5/8"</option>
<option>30 3/4"</option>
<option>30 7/8"</option>
<option>31"</option>
<option>31 1/8"</option>
<option>31 1/4"</option>
<option>31 3/8"</option>
<option>31 1/2"</option>
<option>31 5/8"</option>
<option>31 3/4"</option>
<option>31 7/8"</option>
<option>32"</option>
<option>32 1/8"</option>
<option>32 1/4"</option>
<option>32 3/8"</option>
<option>32 1/2"</option>
<option>32 5/8"</option>
<option>32 3/4"</option>
<option>32 7/8"</option>
<option>33"</option>
<option>33 1/8"</option>
<option>33 1/4"</option>
<option>33 3/8"</option>
<option>33 1/2"</option>
<option>33 5/8"</option>
<option>33 3/4"</option>
<option>33 7/8"</option>
<option>34"</option>
<option>34 1/8"</option>
<option>34 1/4"</option>
<option>34 3/8"</option>
<option>34 1/2"</option>
<option>34 5/8"</option>
<option>34 3/4"</option>
<option>34 7/8"</option>
<option>35"</option>
<option>35 1/8"</option>
<option>35 1/4"</option>
<option>35 3/8"</option>
<option>35 1/2"</option>
<option>35 5/8"</option>
<option>35 3/4"</option>
<option>35 7/8"</option>
<option>36"</option>
<option>36 1/8"</option>
<option>36 1/4"</option>
<option>36 3/8"</option>
<option>36 1/2"</option>
<option>36 5/8"</option>
<option>36 3/4"</option>
<option>36 7/8"</option>
<option>37"</option>
<option>37 1/8"</option>
<option>37 1/4"</option>
<option>37 3/8"</option>
<option>37 1/2"</option>
<option>37 5/8"</option>
<option>37 3/4"</option>
<option>37 7/8"</option>
<option>38"</option>
<option>38 1/8"</option>
<option>38 1/4"</option>
<option>38 3/8"</option>
<option>38 1/2"</option>
<option>38 5/8"</option>
<option>38 3/4"</option>
<option>38 7/8"</option>
<option>39"</option>
<option>39 1/8"</option>
<option>39 1/4"</option>
<option>39 3/8"</option>
<option>39 1/2"</option>
<option>39 5/8"</option>
<option>39 3/4"</option>
<option>39 7/8"</option>
<option>40"</option>
<option>40 1/8"</option>
<option>40 1/4"</option>
<option>40 3/8"</option>
<option>40 1/2"</option>
<option>40 5/8"</option>
<option>40 3/4"</option>
<option>40 7/8"</option>
<option>41"</option>
<option>41 1/8"</option>
<option>41 1/4"</option>
<option>41 3/8"</option>
<option>41 1/2"</option>
<option>41 5/8"</option>
<option>41 3/4"</option>
<option>41 7/8"</option>
<option>42"</option>
<option>42 1/8"</option>
<option>42 1/4"</option>
<option>42 3/8"</option>
<option>42 1/2"</option>
<option>42 5/8"</option>
<option>42 3/4"</option>
<option>42 7/8"</option>
<option>43"</option>
<option>43 1/8"</option>
<option>43 1/4"</option>
<option>43 3/8"</option>
<option>43 1/2"</option>
<option>43 5/8"</option>
<option>43 3/4"</option>
<option>43 7/8"</option>
<option>44"</option>
<option>44 1/8"</option>
<option>44 1/4"</option>
<option>44 3/8"</option>
<option>44 1/2"</option>
<option>44 5/8"</option>
<option>44 3/4"</option>
<option>44 7/8"</option>
<option>45"</option>
<option>45 1/8"</option>
<option>45 1/4"</option>
<option>45 3/8"</option>
<option>45 1/2"</option>
<option>45 5/8"</option>
<option>45 3/4"</option>
<option>45 7/8"</option>
<option>46"</option>
<option>46 1/8"</option>
<option>46 1/4"</option>
<option>46 3/8"</option>
<option>46 1/2"</option>
<option>46 5/8"</option>
<option>46 3/4"</option>
<option>46 7/8"</option>
<option>47"</option>
<option>47 1/8"</option>
<option>47 1/4"</option>
<option>47 3/8"</option>
<option>47 1/2"</option>
<option>47 5/8"</option>
<option>47 3/4"</option>
<option>47 7/8"</option>
<option>48"</option>
<option>48 1/8"</option>
<option>48 1/4"</option>
<option>48 3/8"</option>
<option>48 1/2"</option>
<option>48 5/8"</option>
<option>48 3/4"</option>
<option>48 7/8"</option>
<option>49"</option>
<option>49 1/8"</option>
<option>49 1/4"</option>
<option>49 3/8"</option>
<option>49 1/2"</option>
<option>49 5/8"</option>
<option>49 3/4"</option>
<option>49 7/8"</option>
<option>50"</option>
<option>50 1/8"</option>
<option>50 1/4"</option>
<option>50 3/8"</option>
<option>50 1/2"</option>
<option>50 5/8"</option>
<option>50 3/4"</option>
<option>50 7/8"</option>
<option>51"</option>
<option>51 1/8"</option>
<option>51 1/4"</option>
<option>51 3/8"</option>
<option>51 1/2"</option>
<option>51 5/8"</option>
<option>51 3/4"</option>
<option>51 7/8"</option>
<option>52"</option>
<option>52 1/8"</option>
<option>52 1/4"</option>
<option>52 3/8"</option>
<option>52 1/2"</option>
<option>52 5/8"</option>
<option>52 3/4"</option>
<option>52 7/8"</option>
<option>53"</option>
<option>53 1/8"</option>
<option>53 1/4"</option>
<option>53 3/8"</option>
<option>53 1/2"</option>
<option>53 5/8"</option>
<option>53 3/4"</option>
<option>53 7/8"</option>
<option>54"</option>
<option>54 1/8"</option>
<option>54 1/4"</option>
<option>54 3/8"</option>
<option>54 1/2"</option>
<option>54 5/8"</option>
<option>54 3/4"</option>
<option>54 7/8"</option>
<option>55"</option>
<option>55 1/8"</option>
<option>55 1/4"</option>
<option>55 3/8"</option>
<option>55 1/2"</option>
<option>55 5/8"</option>
<option>55 3/4"</option>
<option>55 7/8"</option>
<option>56"</option>
<option>56 1/8"</option>
<option>56 1/4"</option>
<option>56 3/8"</option>
<option>56 1/2"</option>
<option>56 5/8"</option>
<option>56 3/4"</option>
<option>56 7/8"</option>
<option>57"</option>
<option>57 1/8"</option>
<option>57 1/4"</option>
<option>57 3/8"</option>
<option>57 1/2"</option>
<option>57 5/8"</option>
<option>57 3/4"</option>
<option>57 7/8"</option>
<option>58"</option>
<option>58 1/8"</option>
<option>58 1/4"</option>
<option>58 3/8"</option>
<option>58 1/2"</option>
<option>58 5/8"</option>
<option>58 3/4"</option>
<option>58 7/8"</option>
<option>59"</option>
<option>59 1/8"</option>
<option>59 1/4"</option>
<option>59 3/8"</option>
<option>59 1/2"</option>
<option>59 5/8"</option>
<option>59 3/4"</option>
<option>59 7/8"</option>
<option>60"</option>
<option>60 1/8"</option>
<option>60 1/4"</option>
<option>60 3/8"</option>
<option>60 1/2"</option>
<option>60 5/8"</option>
<option>60 3/4"</option>
<option>60 7/8"</option>
<option>61"</option>
<option>61 1/8"</option>
<option>61 1/4"</option>
<option>61 3/8"</option>
<option>61 1/2"</option>
<option>61 5/8"</option>
<option>61 3/4"</option>
<option>61 7/8"</option>
<option>62"</option>
<option>62 1/8"</option>
<option>62 1/4"</option>
<option>62 3/8"</option>
<option>62 1/2"</option>
<option>62 5/8"</option>
<option>62 3/4"</option>
<option>62 7/8"</option>
<option>63"</option>
<option>63 1/8"</option>
<option>63 1/4"</option>
<option>63 3/8"</option>
<option>63 1/2"</option>
<option>63 5/8"</option>
<option>63 3/4"</option>
<option>63 7/8"</option>
<option>64"</option>
<option>64 1/8"</option>
<option>64 1/4"</option>
<option>64 3/8"</option>
<option>64 1/2"</option>
<option>64 5/8"</option>
<option>64 3/4"</option>
<option>64 7/8"</option>
<option>65"</option>
<option>65 1/8"</option>
<option>65 1/4"</option>
<option>65 3/8"</option>
<option>65 1/2"</option>
<option>65 5/8"</option>
<option>65 3/4"</option>
<option>65 7/8"</option>
<option>66"</option>
<option>66 1/8"</option>
<option>66 1/4"</option>
<option>66 3/8"</option>
<option>66 1/2"</option>
<option>66 5/8"</option>
<option>66 3/4"</option>
<option>66 7/8"</option>
<option>67"</option>
<option>67 1/8"</option>
<option>67 1/4"</option>
<option>67 3/8"</option>
<option>67 1/2"</option>
<option>67 5/8"</option>
<option>67 3/4"</option>
<option>67 7/8"</option>
<option>68"</option>
<option>68 1/8"</option>
<option>68 1/4"</option>
<option>68 3/8"</option>
<option>68 1/2"</option>
<option>68 5/8"</option>
<option>68 3/4"</option>
<option>68 7/8"</option>
<option>69"</option>
<option>69 1/8"</option>
<option>69 1/4"</option>
<option>69 3/8"</option>
<option>69 1/2"</option>
<option>69 5/8"</option>
<option>69 3/4"</option>
<option>69 7/8"</option>
<option>70"</option>
<option>70 1/8"</option>
<option>70 1/4"</option>
<option>70 3/8"</option>
<option>70 1/2"</option>
<option>70 5/8"</option>
<option>70 3/4"</option>
<option>70 7/8"</option>
<option>71"</option>
<option>71 1/8"</option>
<option>71 1/4"</option>
<option>71 3/8"</option>
<option>71 1/2"</option>
<option>71 5/8"</option>
<option>71 3/4"</option>
<option>71 7/8"</option>
<option>72"</option>
<option>72 1/8"</option>
<option>72 1/4"</option>
<option>72 3/8"</option>
<option>72 1/2"</option>
<option>72 5/8"</option>
<option>72 3/4"</option>
<option>72 7/8"</option>
<option>73"</option>
<option>73 1/8"</option>
<option>73 1/4"</option>
<option>73 3/8"</option>
<option>73 1/2"</option>
<option>73 5/8"</option>
<option>73 3/4"</option>
<option>73 7/8"</option>
<option>74"</option>
<option>74 1/8"</option>
<option>74 1/4"</option>
<option>74 3/8"</option>
<option>74 1/2"</option>
<option>74 5/8"</option>
<option>74 3/4"</option>
<option>74 7/8"</option>
<option>75"</option>
<option>75 1/8"</option>
<option>75 1/4"</option>
<option>75 3/8"</option>
<option>75 1/2"</option>
<option>75 5/8"</option>
<option>75 3/4"</option>
<option>75 7/8"</option>
<option>76"</option>
<option>76 1/8"</option>
<option>76 1/4"</option>
<option>76 3/8"</option>
<option>76 1/2"</option>
<option>76 5/8"</option>
<option>76 3/4"</option>
<option>76 7/8"</option>
<option>77"</option>
<option>77 1/8"</option>
<option>77 1/4"</option>
<option>77 3/8"</option>
<option>77 1/2"</option>
<option>77 5/8"</option>
<option>77 3/4"</option>
<option>77 7/8"</option>
<option>78"</option>
<option>78 1/8"</option>
<option>78 1/4"</option>
<option>78 3/8"</option>
<option>78 1/2"</option>
<option>78 5/8"</option>
<option>78 3/4"</option>
<option>78 7/8"</option>
<option>79"</option>
<option>79 1/8"</option>
<option>79 1/4"</option>
<option>79 3/8"</option>
<option>79 1/2"</option>
<option>79 5/8"</option>
<option>79 3/4"</option>
<option>79 7/8"</option>
<option>80"</option>
<option>80 1/8"</option>
<option>80 1/4"</option>
<option>80 3/8"</option>
<option>80 1/2"</option>
<option>80 5/8"</option>
<option>80 3/4"</option>
<option>80 7/8"</option>
<option>81"</option>
<option>81 1/8"</option>
<option>81 1/4"</option>
<option>81 3/8"</option>
<option>81 1/2"</option>
<option>81 5/8"</option>
<option>81 3/4"</option>
<option>81 7/8"</option>
<option>82"</option>
<option>82 1/8"</option>
<option>82 1/4"</option>
<option>82 3/8"</option>
<option>82 1/2"</option>
<option>82 5/8"</option>
<option>82 3/4"</option>
<option>82 7/8"</option>
<option>83"</option>
<option>83 1/8"</option>
<option>83 1/4"</option>
<option>83 3/8"</option>
<option>83 1/2"</option>
<option>83 5/8"</option>
<option>83 3/4"</option>
<option>83 7/8"</option>
<option>84"</option>
<option>84 1/8"</option>
<option>84 1/4"</option>
<option>84 3/8"</option>
<option>84 1/2"</option>
<option>84 5/8"</option>
<option>84 3/4"</option>
<option>84 7/8"</option>
<option>85"</option>
<option>85 1/8"</option>
<option>85 1/4"</option>
<option>85 3/8"</option>
<option>85 1/2"</option>
<option>85 5/8"</option>
<option>85 3/4"</option>
<option>85 7/8"</option>
<option>86"</option>
<option>86 1/8"</option>
<option>86 1/4"</option>
<option>86 3/8"</option>
<option>86 1/2"</option>
<option>86 5/8"</option>
<option>86 3/4"</option>
<option>86 7/8"</option>
<option>87"</option>
<option>87 1/8"</option>
<option>87 1/4"</option>
<option>87 3/8"</option>
<option>87 1/2"</option>
<option>87 5/8"</option>
<option>87 3/4"</option>
<option>87 7/8"</option>
<option>88"</option>
<option>88 1/8"</option>
<option>88 1/4"</option>
<option>88 3/8"</option>
<option>88 1/2"</option>
<option>88 5/8"</option>
<option>88 3/4"</option>
<option>88 7/8"</option>
<option>89"</option>
<option>89 1/8"</option>
<option>89 1/4"</option>
<option>89 3/8"</option>
<option>89 1/2"</option>
<option>89 5/8"</option>
<option>89 3/4"</option>
<option>89 7/8"</option>
<option>90"</option>
<option>90 1/8"</option>
<option>90 1/4"</option>
<option>90 3/8"</option>
<option>90 1/2"</option>
<option>90 5/8"</option>
<option>90 3/4"</option>
<option>90 7/8"</option>
<option>91"</option>
<option>91 1/8"</option>
<option>91 1/4"</option>
<option>91 3/8"</option>
<option>91 1/2"</option>
<option>91 5/8"</option>
<option>91 3/4"</option>
<option>91 7/8"</option>
<option>92"</option>
<option>92 1/8"</option>
<option>92 1/4"</option>
<option>92 3/8"</option>
<option>92 1/2"</option>
<option>92 5/8"</option>
<option>92 3/4"</option>
<option>92 7/8"</option>
<option>93"</option>
<option>93 1/8"</option>
<option>93 1/4"</option>
<option>93 3/8"</option>
<option>93 1/2"</option>
<option>93 5/8"</option>
<option>93 3/4"</option>
<option>93 7/8"</option>
<option>94"</option>
<option>94 1/8"</option>
<option>94 1/4"</option>
<option>94 3/8"</option>
<option>94 1/2"</option>
<option>94 5/8"</option>
<option>94 3/4"</option>
<option>94 7/8"</option>
<option>95"</option>
<option>95 1/8"</option>
<option>95 1/4"</option>
<option>95 3/8"</option>
<option>95 1/2"</option>
<option>95 5/8"</option>
<option>95 3/4"</option>
<option>95 7/8"</option>
<option>96"</option>
<option>96 1/8"</option>
<option>96 1/4"</option>
<option>96 3/8"</option>
<option>96 1/2"</option>
<option>96 5/8"</option>
<option>96 3/4"</option>
<option>96 7/8"</option>
<option>97"</option>
<option>97 1/8"</option>
<option>97 1/4"</option>
<option>97 3/8"</option>
<option>97 1/2"</option>
<option>97 5/8"</option>
<option>97 3/4"</option>
<option>97 7/8"</option>
<option>98"</option>
<option>98 1/8"</option>
<option>98 1/4"</option>
<option>98 3/8"</option>
<option>98 1/2"</option>
<option>98 5/8"</option>
<option>98 3/4"</option>
<option>98 7/8"</option>
<option>99"</option>
<option>99 1/8"</option>
<option>99 1/4"</option>
<option>99 3/8"</option>
<option>99 1/2"</option>
<option>99 5/8"</option>
<option>99 3/4"</option>
<option>99 7/8"</option>
<option>100"</option>
<option>100 1/8"</option>
<option>100 1/4"</option>
<option>100 3/8"</option>
<option>100 1/2"</option>
<option>100 5/8"</option>
<option>100 3/4"</option>
<option>100 7/8"</option>
<option>101"</option>
<option>101 1/8"</option>
<option>101 1/4"</option>
<option>101 3/8"</option>
<option>101 1/2"</option>
<option>101 5/8"</option>
<option>101 3/4"</option>
<option>101 7/8"</option>
<option>102"</option>
<option>102 1/8"</option>
<option>102 1/4"</option>
<option>102 3/8"</option>
<option>102 1/2"</option>
<option>102 5/8"</option>
<option>102 3/4"</option>
<option>102 7/8"</option>
<option>103"</option>
<option>103 1/8"</option>
<option>103 1/4"</option>
<option>103 3/8"</option>
<option>103 1/2"</option>
<option>103 5/8"</option>
<option>103 3/4"</option>
<option>103 7/8"</option>
<option>104"</option>
<option>104 1/8"</option>
<option>104 1/4"</option>
<option>104 3/8"</option>
<option>104 1/2"</option>
<option>104 5/8"</option>
<option>104 3/4"</option>
<option>104 7/8"</option>
<option>105"</option>
<option>105 1/8"</option>
<option>105 1/4"</option>
<option>105 3/8"</option>
<option>105 1/2"</option>
<option>105 5/8"</option>
<option>105 3/4"</option>
<option>105 7/8"</option>
<option>106"</option>
<option>106 1/8"</option>
<option>106 1/4"</option>
<option>106 3/8"</option>
<option>106 1/2"</option>
<option>106 5/8"</option>
<option>106 3/4"</option>
<option>106 7/8"</option>
<option>107"</option>
<option>107 1/8"</option>
<option>107 1/4"</option>
<option>107 3/8"</option>
<option>107 1/2"</option>
<option>107 5/8"</option>
<option>107 3/4"</option>
<option>107 7/8"</option>
<option>108"</option>
<option>108 1/8"</option>
<option>108 1/4"</option>
<option>108 3/8"</option>
<option>108 1/2"</option>
<option>108 5/8"</option>
<option>108 3/4"</option>
<option>108 7/8"</option>
<option>109"</option>
<option>109 1/8"</option>
<option>109 1/4"</option>
<option>109 3/8"</option>
<option>109 1/2"</option>
<option>109 5/8"</option>
<option>109 3/4"</option>
<option>109 7/8"</option>
<option>110"</option>
<option>110 1/8"</option>
<option>110 1/4"</option>
<option>110 3/8"</option>
<option>110 1/2"</option>
<option>110 5/8"</option>
<option>110 3/4"</option>
<option>110 7/8"</option>
<option>111"</option>
<option>111 1/8"</option>
<option>111 1/4"</option>
<option>111 3/8"</option>
<option>111 1/2"</option>
<option>111 5/8"</option>
<option>111 3/4"</option>
<option>111 7/8"</option>
<option>112"</option>
<option>112 1/8"</option>
<option>112 1/4"</option>
<option>112 3/8"</option>
<option>112 1/2"</option>
<option>112 5/8"</option>
<option>112 3/4"</option>
<option>112 7/8"</option>
<option>113"</option>
<option>113 1/8"</option>
<option>113 1/4"</option>
<option>113 3/8"</option>
<option>113 1/2"</option>
<option>113 5/8"</option>
<option>113 3/4"</option>
<option>113 7/8"</option>
<option>114"</option>
<option>114 1/8"</option>
<option>114 1/4"</option>
<option>114 3/8"</option>
<option>114 1/2"</option>
<option>114 5/8"</option>
<option>114 3/4"</option>
<option>114 7/8"</option>
<option>115"</option>
<option>115 1/8"</option>
<option>115 1/4"</option>
<option>115 3/8"</option>
<option>115 1/2"</option>
<option>115 5/8"</option>
<option>115 3/4"</option>
<option>115 7/8"</option>
<option>116"</option>
<option>116 1/8"</option>
<option>116 1/4"</option>
<option>116 3/8"</option>
<option>116 1/2"</option>
<option>116 5/8"</option>
<option>116 3/4"</option>
<option>116 7/8"</option>
<option>117"</option>
<option>117 1/8"</option>
<option>117 1/4"</option>
<option>117 3/8"</option>
<option>117 1/2"</option>
<option>117 5/8"</option>
<option>117 3/4"</option>
<option>117 7/8"</option>
<option>118"</option>
<option>118 1/8"</option>
<option>118 1/4"</option>
<option>118 3/8"</option>
<option>118 1/2"</option>
<option>118 5/8"</option>
<option>118 3/4"</option>
<option>118 7/8"</option>
<option>119"</option>
<option>119 1/8"</option>
<option>119 1/4"</option>
<option>119 3/8"</option>
<option>119 1/2"</option>
<option>119 5/8"</option>
<option>119 3/4"</option>
<option>119 7/8"</option>
<option>120"</option>
<option>120 1/8"</option>
<option>120 1/4"</option>
<option>120 3/8"</option>
<option>120 1/2"</option>
<option>120 5/8"</option>
<option>120 3/4"</option>
<option>120 7/8"</option>
<option>121"</option>
<option>121 1/8"</option>
<option>121 1/4"</option>
<option>121 3/8"</option>
<option>121 1/2"</option>
<option>121 5/8"</option>
<option>121 3/4"</option>
<option>121 7/8"</option>
<option>122"</option>
<option>122 1/8"</option>
<option>122 1/4"</option>
<option>122 3/8"</option>
<option>122 1/2"</option>
<option>122 5/8"</option>
<option>122 3/4"</option>
<option>122 7/8"</option>
<option>123"</option>
<option>123 1/8"</option>
<option>123 1/4"</option>
<option>123 3/8"</option>
<option>123 1/2"</option>
<option>123 5/8"</option>
<option>123 3/4"</option>
<option>123 7/8"</option>
<option>124"</option>
<option>124 1/8"</option>
<option>124 1/4"</option>
<option>124 3/8"</option>
<option>124 1/2"</option>
<option>124 5/8"</option>
<option>124 3/4"</option>
<option>124 7/8"</option>
<option>125"</option>
<option>125 1/8"</option>
<option>125 1/4"</option>
<option>125 3/8"</option>
<option>125 1/2"</option>
<option>125 5/8"</option>
<option>125 3/4"</option>
<option>125 7/8"</option>
<option>126"</option>
<option>126 1/8"</option>
<option>126 1/4"</option>
<option>126 3/8"</option>
<option>126 1/2"</option>
<option>126 5/8"</option>
<option>126 3/4"</option>
<option>126 7/8"</option>
<option>127"</option>
<option>127 1/8"</option>
<option>127 1/4"</option>
<option>127 3/8"</option>
<option>127 1/2"</option>
<option>127 5/8"</option>
<option>127 3/4"</option>
<option>127 7/8"</option>
<option>128"</option>
<option>128 1/8"</option>
<option>128 1/4"</option>
<option>128 3/8"</option>
<option>128 1/2"</option>
<option>128 5/8"</option>
<option>128 3/4"</option>
<option>128 7/8"</option>
<option>129"</option>
<option>129 1/8"</option>
<option>129 1/4"</option>
<option>129 3/8"</option>
<option>129 1/2"</option>
<option>129 5/8"</option>
<option>129 3/4"</option>
<option>129 7/8"</option>
<option>130"</option>
<option>130 1/8"</option>
<option>130 1/4"</option>
<option>130 3/8"</option>
<option>130 1/2"</option>
<option>130 5/8"</option>
<option>130 3/4"</option>
<option>130 7/8"</option>
<option>131"</option>
<option>131 1/8"</option>
<option>131 1/4"</option>
<option>131 3/8"</option>
<option>131 1/2"</option>
<option>131 5/8"</option>
<option>131 3/4"</option>
<option>131 7/8"</option>
<option>132"</option>
<option>132 1/8"</option>
<option>132 1/4"</option>
<option>132 3/8"</option>
<option>132 1/2"</option>
<option>132 5/8"</option>
<option>132 3/4"</option>
<option>132 7/8"</option>
<option>133"</option>
<option>133 1/8"</option>
<option>133 1/4"</option>
<option>133 3/8"</option>
<option>133 1/2"</option>
<option>133 5/8"</option>
<option>133 3/4"</option>
<option>133 7/8"</option>
<option>134"</option>
<option>134 1/8"</option>
<option>134 1/4"</option>
<option>134 3/8"</option>
<option>134 1/2"</option>
<option>134 5/8"</option>
<option>134 3/4"</option>
<option>134 7/8"</option>
<option>135"</option>
<option>135 1/8"</option>
<option>135 1/4"</option>
<option>135 3/8"</option>
<option>135 1/2"</option>
<option>135 5/8"</option>
<option>135 3/4"</option>
<option>135 7/8"</option>
<option>136"</option>
<option>136 1/8"</option>
<option>136 1/4"</option>
<option>136 3/8"</option>
<option>136 1/2"</option>
<option>136 5/8"</option>
<option>136 3/4"</option>
<option>136 7/8"</option>
<option>137"</option>
<option>137 1/8"</option>
<option>137 1/4"</option>
<option>137 3/8"</option>
<option>137 1/2"</option>
<option>137 5/8"</option>
<option>137 3/4"</option>
<option>137 7/8"</option>
<option>138"</option>
<option>138 1/8"</option>
<option>138 1/4"</option>
<option>138 3/8"</option>
<option>138 1/2"</option>
<option>138 5/8"</option>
<option>138 3/4"</option>
<option>138 7/8"</option>
<option>139"</option>
<option>139 1/8"</option>
<option>139 1/4"</option>
<option>139 3/8"</option>
<option>139 1/2"</option>
<option>139 5/8"</option>
<option>139 3/4"</option>
<option>139 7/8"</option>
<option>140"</option>
<option>140 1/8"</option>
<option>140 1/4"</option>
<option>140 3/8"</option>
<option>140 1/2"</option>
<option>140 5/8"</option>
<option>140 3/4"</option>
<option>140 7/8"</option>
<option>141"</option>
<option>141 1/8"</option>
<option>141 1/4"</option>
<option>141 3/8"</option>
<option>141 1/2"</option>
<option>141 5/8"</option>
<option>141 3/4"</option>
<option>141 7/8"</option>
<option>142"</option>
<option>142 1/8"</option>
<option>142 1/4"</option>
<option>142 3/8"</option>
<option>142 1/2"</option>
<option>142 5/8"</option>
<option>142 3/4"</option>
<option>142 7/8"</option>
<option>143"</option>
<option>143 1/8"</option>
<option>143 1/4"</option>
<option>143 3/8"</option>
<option>143 1/2"</option>
<option>143 5/8"</option>
<option>143 3/4"</option>
<option>143 7/8"</option>
<option>144"</option>
<option>144 1/8"</option>
<option>144 1/4"</option>
<option>144 3/8"</option>
<option>144 1/2"</option>
<option>144 5/8"</option>
<option>144 3/4"</option>
<option>144 7/8"</option>
<option>145"</option>
<option>145 1/8"</option>
<option>145 1/4"</option>
<option>145 3/8"</option>
<option>145 1/2"</option>
<option>145 5/8"</option>
<option>145 3/4"</option>
<option>145 7/8"</option>
<option>146"</option>
<option>146 1/8"</option>
<option>146 1/4"</option>
<option>146 3/8"</option>
<option>146 1/2"</option>
<option>146 5/8"</option>
<option>146 3/4"</option>
<option>146 7/8"</option>
<option>147"</option>
<option>147 1/8"</option>
<option>147 1/4"</option>
<option>147 3/8"</option>
<option>147 1/2"</option>
<option>147 5/8"</option>
<option>147 3/4"</option>
<option>147 7/8"</option>
<option>148"</option>
<option>148 1/8"</option>
<option>148 1/4"</option>
<option>148 3/8"</option>
<option>148 1/2"</option>
<option>148 5/8"</option>
<option>148 3/4"</option>
<option>148 7/8"</option>
<option>149"</option>
<option>149 1/8"</option>
<option>149 1/4"</option>
<option>149 3/8"</option>
<option>149 1/2"</option>
<option>149 5/8"</option>
<option>149 3/4"</option>
<option>149 7/8"</option>
<option>150"</option>
<option>150 1/8"</option>
<option>150 1/4"</option>
<option>150 3/8"</option>
<option>150 1/2"</option>
<option>150 5/8"</option>
<option>150 3/4"</option>
<option>150 7/8"</option>
<option>151"</option>
<option>151 1/8"</option>
<option>151 1/4"</option>
<option>151 3/8"</option>
<option>151 1/2"</option>
<option>151 5/8"</option>
<option>151 3/4"</option>
<option>151 7/8"</option>
<option>152"</option>
<option>152 1/8"</option>
<option>152 1/4"</option>
<option>152 3/8"</option>
<option>152 1/2"</option>
<option>152 5/8"</option>
<option>152 3/4"</option>
<option>152 7/8"</option>
<option>153"</option>
<option>153 1/8"</option>
<option>153 1/4"</option>
<option>153 3/8"</option>
<option>153 1/2"</option>
<option>153 5/8"</option>
<option>153 3/4"</option>
<option>153 7/8"</option>
<option>154"</option>
<option>154 1/8"</option>
<option>154 1/4"</option>
<option>154 3/8"</option>
<option>154 1/2"</option>
<option>154 5/8"</option>
<option>154 3/4"</option>
<option>154 7/8"</option>
<option>155"</option>
<option>155 1/8"</option>
<option>155 1/4"</option>
<option>155 3/8"</option>
<option>155 1/2"</option>
<option>155 5/8"</option>
<option>155 3/4"</option>
<option>155 7/8"</option>
<option>156"</option>
<option>156 1/8"</option>
<option>156 1/4"</option>
<option>156 3/8"</option>
<option>156 1/2"</option>
<option>156 5/8"</option>
<option>156 3/4"</option>
<option>156 7/8"</option>
<option>157"</option>
<option>157 1/8"</option>
<option>157 1/4"</option>
<option>157 3/8"</option>
<option>157 1/2"</option>
<option>157 5/8"</option>
<option>157 3/4"</option>
<option>157 7/8"</option>
<option>158"</option>
<option>158 1/8"</option>
<option>158 1/4"</option>
<option>158 3/8"</option>
<option>158 1/2"</option>
<option>158 5/8"</option>
<option>158 3/4"</option>
<option>158 7/8"</option>
<option>159"</option>
<option>159 1/8"</option>
<option>159 1/4"</option>
<option>159 3/8"</option>
<option>159 1/2"</option>
<option>159 5/8"</option>
<option>159 3/4"</option>
<option>159 7/8"</option>
<option>160"</option>
<option>160 1/8"</option>
<option>160 1/4"</option>
<option>160 3/8"</option>
<option>160 1/2"</option>
<option>160 5/8"</option>
<option>160 3/4"</option>
<option>160 7/8"</option>
<option>161"</option>
<option>161 1/8"</option>
<option>161 1/4"</option>
<option>161 3/8"</option>
<option>161 1/2"</option>
<option>161 5/8"</option>
<option>161 3/4"</option>
<option>161 7/8"</option>
<option>162"</option>
<option>162 1/8"</option>
<option>162 1/4"</option>
<option>162 3/8"</option>
<option>162 1/2"</option>
<option>162 5/8"</option>
<option>162 3/4"</option>
<option>162 7/8"</option>
<option>163"</option>
<option>163 1/8"</option>
<option>163 1/4"</option>
<option>163 3/8"</option>
<option>163 1/2"</option>
<option>163 5/8"</option>
<option>163 3/4"</option>
<option>163 7/8"</option>
<option>164"</option>
<option>164 1/8"</option>
<option>164 1/4"</option>
<option>164 3/8"</option>
<option>164 1/2"</option>
<option>164 5/8"</option>
<option>164 3/4"</option>
<option>164 7/8"</option>
<option>165"</option>
<option>165 1/8"</option>
<option>165 1/4"</option>
<option>165 3/8"</option>
<option>165 1/2"</option>
<option>165 5/8"</option>
<option>165 3/4"</option>
<option>165 7/8"</option>
<option>166"</option>
<option>166 1/8"</option>
<option>166 1/4"</option>
<option>166 3/8"</option>
<option>166 1/2"</option>
<option>166 5/8"</option>
<option>166 3/4"</option>
<option>166 7/8"</option>
<option>167"</option>
<option>167 1/8"</option>
<option>167 1/4"</option>
<option>167 3/8"</option>
<option>167 1/2"</option>
<option>167 5/8"</option>
<option>167 3/4"</option>
<option>167 7/8"</option>
<option>168"</option>
<option>168 1/8"</option>
<option>168 1/4"</option>
<option>168 3/8"</option>
<option>168 1/2"</option>
<option>168 5/8"</option>
<option>168 3/4"</option>
<option>168 7/8"</option>
<option>169"</option>
<option>169 1/8"</option>
<option>169 1/4"</option>
<option>169 3/8"</option>
<option>169 1/2"</option>
<option>169 5/8"</option>
<option>169 3/4"</option>
<option>169 7/8"</option>
<option>170"</option>
<option>170 1/8"</option>
<option>170 1/4"</option>
<option>170 3/8"</option>
<option>170 1/2"</option>
<option>170 5/8"</option>
<option>170 3/4"</option>
<option>170 7/8"</option>
<option>171"</option>
<option>171 1/8"</option>
<option>171 1/4"</option>
<option>171 3/8"</option>
<option>171 1/2"</option>
<option>171 5/8"</option>
<option>171 3/4"</option>
<option>171 7/8"</option>
<option>172"</option>
<option>172 1/8"</option>
<option>172 1/4"</option>
<option>172 3/8"</option>
<option>172 1/2"</option>
<option>172 5/8"</option>
<option>172 3/4"</option>
<option>172 7/8"</option>
<option>173"</option>
<option>173 1/8"</option>
<option>173 1/4"</option>
<option>173 3/8"</option>
<option>173 1/2"</option>
<option>173 5/8"</option>
<option>173 3/4"</option>
<option>173 7/8"</option>
<option>174"</option>
<option>174 1/8"</option>
<option>174 1/4"</option>
<option>174 3/8"</option>
<option>174 1/2"</option>
<option>174 5/8"</option>
<option>174 3/4"</option>
<option>174 7/8"</option>
<option>175"</option>
<option>175 1/8"</option>
<option>175 1/4"</option>
<option>175 3/8"</option>
<option>175 1/2"</option>
<option>175 5/8"</option>
<option>175 3/4"</option>
<option>175 7/8"</option>
<option>176"</option>
<option>176 1/8"</option>
<option>176 1/4"</option>
<option>176 3/8"</option>
<option>176 1/2"</option>
<option>176 5/8"</option>
<option>176 3/4"</option>
<option>176 7/8"</option>
<option>177"</option>
<option>177 1/8"</option>
<option>177 1/4"</option>
<option>177 3/8"</option>
<option>177 1/2"</option>
<option>177 5/8"</option>
<option>177 3/4"</option>
<option>177 7/8"</option>
<option>178"</option>
<option>178 1/8"</option>
<option>178 1/4"</option>
<option>178 3/8"</option>
<option>178 1/2"</option>
<option>178 5/8"</option>
<option>178 3/4"</option>
<option>178 7/8"</option>
<option>179"</option>
<option>179 1/8"</option>
<option>179 1/4"</option>
<option>179 3/8"</option>
<option>179 1/2"</option>
<option>179 5/8"</option>
<option>179 3/4"</option>
<option>179 7/8"</option>
<option>180"</option>
<option>180 1/8"</option>
<option>180 1/4"</option>
<option>180 3/8"</option>
<option>180 1/2"</option>
<option>180 5/8"</option>
<option>180 3/4"</option>
<option>180 7/8"</option>
<option>181"</option>
<option>181 1/8"</option>
<option>181 1/4"</option>
<option>181 3/8"</option>
<option>181 1/2"</option>
<option>181 5/8"</option>
<option>181 3/4"</option>
<option>181 7/8"</option>
<option>182"</option>
<option>182 1/8"</option>
<option>182 1/4"</option>
<option>182 3/8"</option>
<option>182 1/2"</option>
<option>182 5/8"</option>
<option>182 3/4"</option>
<option>182 7/8"</option>
<option>183"</option>
<option>183 1/8"</option>
<option>183 1/4"</option>
<option>183 3/8"</option>
<option>183 1/2"</option>
<option>183 5/8"</option>
<option>183 3/4"</option>
<option>183 7/8"</option>
<option>184"</option>
<option>184 1/8"</option>
<option>184 1/4"</option>
<option>184 3/8"</option>
<option>184 1/2"</option>
<option>184 5/8"</option>
<option>184 3/4"</option>
<option>184 7/8"</option>
<option>185"</option>
<option>185 1/8"</option>
<option>185 1/4"</option>
<option>185 3/8"</option>
<option>185 1/2"</option>
<option>185 5/8"</option>
<option>185 3/4"</option>
<option>185 7/8"</option>
<option>186"</option>
<option>186 1/8"</option>
<option>186 1/4"</option>
<option>186 3/8"</option>
<option>186 1/2"</option>
<option>186 5/8"</option>
<option>186 3/4"</option>
<option>186 7/8"</option>
<option>187"</option>
<option>187 1/8"</option>
<option>187 1/4"</option>
<option>187 3/8"</option>
<option>187 1/2"</option>
<option>187 5/8"</option>
<option>187 3/4"</option>
<option>187 7/8"</option>
<option>188"</option>
<option>188 1/8"</option>
<option>188 1/4"</option>
<option>188 3/8"</option>
<option>188 1/2"</option>
<option>188 5/8"</option>
<option>188 3/4"</option>
<option>188 7/8"</option>
<option>189"</option>
<option>189 1/8"</option>
<option>189 1/4"</option>
<option>189 3/8"</option>
<option>189 1/2"</option>
<option>189 5/8"</option>
<option>189 3/4"</option>
<option>189 7/8"</option>
<option>190"</option>
<option>190 1/8"</option>
<option>190 1/4"</option>
<option>190 3/8"</option>
<option>190 1/2"</option>
<option>190 5/8"</option>
<option>190 3/4"</option>
<option>190 7/8"</option>
<option>191"</option>
<option>191 1/8"</option>
<option>191 1/4"</option>
<option>191 3/8"</option>
<option>191 1/2"</option>
<option>191 5/8"</option>
<option>191 3/4"</option>
<option>191 7/8"</option>
<option>192"</option>
<option>192 1/8"</option>
<option>192 1/4"</option>
<option>192 3/8"</option>
<option>192 1/2"</option>
<option>192 5/8"</option>
<option>192 3/4"</option>
<option>192 7/8"</option>
<option>193"</option>
<option>193 1/8"</option>
<option>193 1/4"</option>
<option>193 3/8"</option>
<option>193 1/2"</option>
<option>193 5/8"</option>
<option>193 3/4"</option>
<option>193 7/8"</option>
<option>194"</option>
<option>194 1/8"</option>
<option>194 1/4"</option>
<option>194 3/8"</option>
<option>194 1/2"</option>
<option>194 5/8"</option>
<option>194 3/4"</option>
<option>194 7/8"</option>
<option>195"</option>
<option>195 1/8"</option>
<option>195 1/4"</option>
<option>195 3/8"</option>
<option>195 1/2"</option>
<option>195 5/8"</option>
<option>195 3/4"</option>
<option>195 7/8"</option>
<option>196"</option>
<option>196 1/8"</option>
<option>196 1/4"</option>
<option>196 3/8"</option>
<option>196 1/2"</option>
<option>196 5/8"</option>
<option>196 3/4"</option>
<option>196 7/8"</option>
<option>197"</option>
<option>197 1/8"</option>
<option>197 1/4"</option>
<option>197 3/8"</option>
<option>197 1/2"</option>
<option>197 5/8"</option>
<option>197 3/4"</option>
<option>197 7/8"</option>
<option>198"</option>
<option>198 1/8"</option>
<option>198 1/4"</option>
<option>198 3/8"</option>
<option>198 1/2"</option>
<option>198 5/8"</option>
<option>198 3/4"</option>
<option>198 7/8"</option>
<option>199"</option>
<option>199 1/8"</option>
<option>199 1/4"</option>
<option>199 3/8"</option>
<option>199 1/2"</option>
<option>199 5/8"</option>
<option>199 3/4"</option>
<option>199 7/8"</option>
<option>200"</option>
 	</select> 

<label>Size 2:</label>
<select name="inventory_material_size2">
 	<option selected="yes"><?php echo $inventory_material_size2; ?></option>
<option>1/8"</option>
<option>1/4"</option>
<option>3/8"</option>
<option>1/2"</option>
<option>5/8"</option>
<option>3/4"</option>
<option>7/8"</option>
<option>1"</option>
<option>1 1/8"</option>
<option>1 1/4"</option>
<option>1 3/8"</option>
<option>1 1/2"</option>
<option>1 5/8"</option>
<option>1 3/4"</option>
<option>1 7/8"</option>
<option>2"</option>
<option>2 1/8"</option>
<option>2 1/4"</option>
<option>2 3/8"</option>
<option>2 1/2"</option>
<option>2 5/8"</option>
<option>2 3/4"</option>
<option>2 7/8"</option>
<option>3"</option>
<option>3 1/8"</option>
<option>3 1/4"</option>
<option>3 3/8"</option>
<option>3 1/2"</option>
<option>3 5/8"</option>
<option>3 3/4"</option>
<option>3 7/8"</option>
<option>4"</option>
<option>4 1/8"</option>
<option>4 1/4"</option>
<option>4 3/8"</option>
<option>4 1/2"</option>
<option>4 5/8"</option>
<option>4 3/4"</option>
<option>4 7/8"</option>
<option>5"</option>
<option>5 1/8"</option>
<option>5 1/4"</option>
<option>5 3/8"</option>
<option>5 1/2"</option>
<option>5 5/8"</option>
<option>5 3/4"</option>
<option>5 7/8"</option>
<option>6"</option>
<option>6 1/8"</option>
<option>6 1/4"</option>
<option>6 3/8"</option>
<option>6 1/2"</option>
<option>6 5/8"</option>
<option>6 3/4"</option>
<option>6 7/8"</option>
<option>7"</option>
<option>7 1/8"</option>
<option>7 1/4"</option>
<option>7 3/8"</option>
<option>7 1/2"</option>
<option>7 5/8"</option>
<option>7 3/4"</option>
<option>7 7/8"</option>
<option>8"</option>
<option>8 1/8"</option>
<option>8 1/4"</option>
<option>8 3/8"</option>
<option>8 1/2"</option>
<option>8 5/8"</option>
<option>8 3/4"</option>
<option>8 7/8"</option>
<option>9"</option>
<option>9 1/8"</option>
<option>9 1/4"</option>
<option>9 3/8"</option>
<option>9 1/2"</option>
<option>9 5/8"</option>
<option>9 3/4"</option>
<option>9 7/8"</option>
<option>10"</option>
<option>10 1/8"</option>
<option>10 1/4"</option>
<option>10 3/8"</option>
<option>10 1/2"</option>
<option>10 5/8"</option>
<option>10 3/4"</option>
<option>10 7/8"</option>
<option>11"</option>
<option>11 1/8"</option>
<option>11 1/4"</option>
<option>11 3/8"</option>
<option>11 1/2"</option>
<option>11 5/8"</option>
<option>11 3/4"</option>
<option>11 7/8"</option>
<option>12"</option>
<option>12 1/8"</option>
<option>12 1/4"</option>
<option>12 3/8"</option>
<option>12 1/2"</option>
<option>12 5/8"</option>
<option>12 3/4"</option>
<option>12 7/8"</option>
<option>13"</option>
<option>13 1/8"</option>
<option>13 1/4"</option>
<option>13 3/8"</option>
<option>13 1/2"</option>
<option>13 5/8"</option>
<option>13 3/4"</option>
<option>13 7/8"</option>
<option>14"</option>
<option>14 1/8"</option>
<option>14 1/4"</option>
<option>14 3/8"</option>
<option>14 1/2"</option>
<option>14 5/8"</option>
<option>14 3/4"</option>
<option>14 7/8"</option>
<option>15"</option>
<option>15 1/8"</option>
<option>15 1/4"</option>
<option>15 3/8"</option>
<option>15 1/2"</option>
<option>15 5/8"</option>
<option>15 3/4"</option>
<option>15 7/8"</option>
<option>16"</option>
<option>16 1/8"</option>
<option>16 1/4"</option>
<option>16 3/8"</option>
<option>16 1/2"</option>
<option>16 5/8"</option>
<option>16 3/4"</option>
<option>16 7/8"</option>
<option>17"</option>
<option>17 1/8"</option>
<option>17 1/4"</option>
<option>17 3/8"</option>
<option>17 1/2"</option>
<option>17 5/8"</option>
<option>17 3/4"</option>
<option>17 7/8"</option>
<option>18"</option>
<option>18 1/8"</option>
<option>18 1/4"</option>
<option>18 3/8"</option>
<option>18 1/2"</option>
<option>18 5/8"</option>
<option>18 3/4"</option>
<option>18 7/8"</option>
<option>19"</option>
<option>19 1/8"</option>
<option>19 1/4"</option>
<option>19 3/8"</option>
<option>19 1/2"</option>
<option>19 5/8"</option>
<option>19 3/4"</option>
<option>19 7/8"</option>
<option>20"</option>
<option>20 1/8"</option>
<option>20 1/4"</option>
<option>20 3/8"</option>
<option>20 1/2"</option>
<option>20 5/8"</option>
<option>20 3/4"</option>
<option>20 7/8"</option>
<option>21"</option>
<option>21 1/8"</option>
<option>21 1/4"</option>
<option>21 3/8"</option>
<option>21 1/2"</option>
<option>21 5/8"</option>
<option>21 3/4"</option>
<option>21 7/8"</option>
<option>22"</option>
<option>22 1/8"</option>
<option>22 1/4"</option>
<option>22 3/8"</option>
<option>22 1/2"</option>
<option>22 5/8"</option>
<option>22 3/4"</option>
<option>22 7/8"</option>
<option>23"</option>
<option>23 1/8"</option>
<option>23 1/4"</option>
<option>23 3/8"</option>
<option>23 1/2"</option>
<option>23 5/8"</option>
<option>23 3/4"</option>
<option>23 7/8"</option>
<option>24"</option>
<option>24 1/8"</option>
<option>24 1/4"</option>
<option>24 3/8"</option>
<option>24 1/2"</option>
<option>24 5/8"</option>
<option>24 3/4"</option>
<option>24 7/8"</option>
<option>25"</option>
<option>25 1/8"</option>
<option>25 1/4"</option>
<option>25 3/8"</option>
<option>25 1/2"</option>
<option>25 5/8"</option>
<option>25 3/4"</option>
<option>25 7/8"</option>
<option>26"</option>
<option>26 1/8"</option>
<option>26 1/4"</option>
<option>26 3/8"</option>
<option>26 1/2"</option>
<option>26 5/8"</option>
<option>26 3/4"</option>
<option>26 7/8"</option>
<option>27"</option>
<option>27 1/8"</option>
<option>27 1/4"</option>
<option>27 3/8"</option>
<option>27 1/2"</option>
<option>27 5/8"</option>
<option>27 3/4"</option>
<option>27 7/8"</option>
<option>28"</option>
<option>28 1/8"</option>
<option>28 1/4"</option>
<option>28 3/8"</option>
<option>28 1/2"</option>
<option>28 5/8"</option>
<option>28 3/4"</option>
<option>28 7/8"</option>
<option>29"</option>
<option>29 1/8"</option>
<option>29 1/4"</option>
<option>29 3/8"</option>
<option>29 1/2"</option>
<option>29 5/8"</option>
<option>29 3/4"</option>
<option>29 7/8"</option>
<option>30"</option>
<option>30 1/8"</option>
<option>30 1/4"</option>
<option>30 3/8"</option>
<option>30 1/2"</option>
<option>30 5/8"</option>
<option>30 3/4"</option>
<option>30 7/8"</option>
<option>31"</option>
<option>31 1/8"</option>
<option>31 1/4"</option>
<option>31 3/8"</option>
<option>31 1/2"</option>
<option>31 5/8"</option>
<option>31 3/4"</option>
<option>31 7/8"</option>
<option>32"</option>
<option>32 1/8"</option>
<option>32 1/4"</option>
<option>32 3/8"</option>
<option>32 1/2"</option>
<option>32 5/8"</option>
<option>32 3/4"</option>
<option>32 7/8"</option>
<option>33"</option>
<option>33 1/8"</option>
<option>33 1/4"</option>
<option>33 3/8"</option>
<option>33 1/2"</option>
<option>33 5/8"</option>
<option>33 3/4"</option>
<option>33 7/8"</option>
<option>34"</option>
<option>34 1/8"</option>
<option>34 1/4"</option>
<option>34 3/8"</option>
<option>34 1/2"</option>
<option>34 5/8"</option>
<option>34 3/4"</option>
<option>34 7/8"</option>
<option>35"</option>
<option>35 1/8"</option>
<option>35 1/4"</option>
<option>35 3/8"</option>
<option>35 1/2"</option>
<option>35 5/8"</option>
<option>35 3/4"</option>
<option>35 7/8"</option>
<option>36"</option>
<option>36 1/8"</option>
<option>36 1/4"</option>
<option>36 3/8"</option>
<option>36 1/2"</option>
<option>36 5/8"</option>
<option>36 3/4"</option>
<option>36 7/8"</option>
<option>37"</option>
<option>37 1/8"</option>
<option>37 1/4"</option>
<option>37 3/8"</option>
<option>37 1/2"</option>
<option>37 5/8"</option>
<option>37 3/4"</option>
<option>37 7/8"</option>
<option>38"</option>
<option>38 1/8"</option>
<option>38 1/4"</option>
<option>38 3/8"</option>
<option>38 1/2"</option>
<option>38 5/8"</option>
<option>38 3/4"</option>
<option>38 7/8"</option>
<option>39"</option>
<option>39 1/8"</option>
<option>39 1/4"</option>
<option>39 3/8"</option>
<option>39 1/2"</option>
<option>39 5/8"</option>
<option>39 3/4"</option>
<option>39 7/8"</option>
<option>40"</option>
<option>40 1/8"</option>
<option>40 1/4"</option>
<option>40 3/8"</option>
<option>40 1/2"</option>
<option>40 5/8"</option>
<option>40 3/4"</option>
<option>40 7/8"</option>
<option>41"</option>
<option>41 1/8"</option>
<option>41 1/4"</option>
<option>41 3/8"</option>
<option>41 1/2"</option>
<option>41 5/8"</option>
<option>41 3/4"</option>
<option>41 7/8"</option>
<option>42"</option>
<option>42 1/8"</option>
<option>42 1/4"</option>
<option>42 3/8"</option>
<option>42 1/2"</option>
<option>42 5/8"</option>
<option>42 3/4"</option>
<option>42 7/8"</option>
<option>43"</option>
<option>43 1/8"</option>
<option>43 1/4"</option>
<option>43 3/8"</option>
<option>43 1/2"</option>
<option>43 5/8"</option>
<option>43 3/4"</option>
<option>43 7/8"</option>
<option>44"</option>
<option>44 1/8"</option>
<option>44 1/4"</option>
<option>44 3/8"</option>
<option>44 1/2"</option>
<option>44 5/8"</option>
<option>44 3/4"</option>
<option>44 7/8"</option>
<option>45"</option>
<option>45 1/8"</option>
<option>45 1/4"</option>
<option>45 3/8"</option>
<option>45 1/2"</option>
<option>45 5/8"</option>
<option>45 3/4"</option>
<option>45 7/8"</option>
<option>46"</option>
<option>46 1/8"</option>
<option>46 1/4"</option>
<option>46 3/8"</option>
<option>46 1/2"</option>
<option>46 5/8"</option>
<option>46 3/4"</option>
<option>46 7/8"</option>
<option>47"</option>
<option>47 1/8"</option>
<option>47 1/4"</option>
<option>47 3/8"</option>
<option>47 1/2"</option>
<option>47 5/8"</option>
<option>47 3/4"</option>
<option>47 7/8"</option>
<option>48"</option>
<option>48 1/8"</option>
<option>48 1/4"</option>
<option>48 3/8"</option>
<option>48 1/2"</option>
<option>48 5/8"</option>
<option>48 3/4"</option>
<option>48 7/8"</option>
<option>49"</option>
<option>49 1/8"</option>
<option>49 1/4"</option>
<option>49 3/8"</option>
<option>49 1/2"</option>
<option>49 5/8"</option>
<option>49 3/4"</option>
<option>49 7/8"</option>
<option>50"</option>
<option>50 1/8"</option>
<option>50 1/4"</option>
<option>50 3/8"</option>
<option>50 1/2"</option>
<option>50 5/8"</option>
<option>50 3/4"</option>
<option>50 7/8"</option>
<option>51"</option>
<option>51 1/8"</option>
<option>51 1/4"</option>
<option>51 3/8"</option>
<option>51 1/2"</option>
<option>51 5/8"</option>
<option>51 3/4"</option>
<option>51 7/8"</option>
<option>52"</option>
<option>52 1/8"</option>
<option>52 1/4"</option>
<option>52 3/8"</option>
<option>52 1/2"</option>
<option>52 5/8"</option>
<option>52 3/4"</option>
<option>52 7/8"</option>
<option>53"</option>
<option>53 1/8"</option>
<option>53 1/4"</option>
<option>53 3/8"</option>
<option>53 1/2"</option>
<option>53 5/8"</option>
<option>53 3/4"</option>
<option>53 7/8"</option>
<option>54"</option>
<option>54 1/8"</option>
<option>54 1/4"</option>
<option>54 3/8"</option>
<option>54 1/2"</option>
<option>54 5/8"</option>
<option>54 3/4"</option>
<option>54 7/8"</option>
<option>55"</option>
<option>55 1/8"</option>
<option>55 1/4"</option>
<option>55 3/8"</option>
<option>55 1/2"</option>
<option>55 5/8"</option>
<option>55 3/4"</option>
<option>55 7/8"</option>
<option>56"</option>
<option>56 1/8"</option>
<option>56 1/4"</option>
<option>56 3/8"</option>
<option>56 1/2"</option>
<option>56 5/8"</option>
<option>56 3/4"</option>
<option>56 7/8"</option>
<option>57"</option>
<option>57 1/8"</option>
<option>57 1/4"</option>
<option>57 3/8"</option>
<option>57 1/2"</option>
<option>57 5/8"</option>
<option>57 3/4"</option>
<option>57 7/8"</option>
<option>58"</option>
<option>58 1/8"</option>
<option>58 1/4"</option>
<option>58 3/8"</option>
<option>58 1/2"</option>
<option>58 5/8"</option>
<option>58 3/4"</option>
<option>58 7/8"</option>
<option>59"</option>
<option>59 1/8"</option>
<option>59 1/4"</option>
<option>59 3/8"</option>
<option>59 1/2"</option>
<option>59 5/8"</option>
<option>59 3/4"</option>
<option>59 7/8"</option>
<option>60"</option>
<option>60 1/8"</option>
<option>60 1/4"</option>
<option>60 3/8"</option>
<option>60 1/2"</option>
<option>60 5/8"</option>
<option>60 3/4"</option>
<option>60 7/8"</option>
<option>61"</option>
<option>61 1/8"</option>
<option>61 1/4"</option>
<option>61 3/8"</option>
<option>61 1/2"</option>
<option>61 5/8"</option>
<option>61 3/4"</option>
<option>61 7/8"</option>
<option>62"</option>
<option>62 1/8"</option>
<option>62 1/4"</option>
<option>62 3/8"</option>
<option>62 1/2"</option>
<option>62 5/8"</option>
<option>62 3/4"</option>
<option>62 7/8"</option>
<option>63"</option>
<option>63 1/8"</option>
<option>63 1/4"</option>
<option>63 3/8"</option>
<option>63 1/2"</option>
<option>63 5/8"</option>
<option>63 3/4"</option>
<option>63 7/8"</option>
<option>64"</option>
<option>64 1/8"</option>
<option>64 1/4"</option>
<option>64 3/8"</option>
<option>64 1/2"</option>
<option>64 5/8"</option>
<option>64 3/4"</option>
<option>64 7/8"</option>
<option>65"</option>
<option>65 1/8"</option>
<option>65 1/4"</option>
<option>65 3/8"</option>
<option>65 1/2"</option>
<option>65 5/8"</option>
<option>65 3/4"</option>
<option>65 7/8"</option>
<option>66"</option>
<option>66 1/8"</option>
<option>66 1/4"</option>
<option>66 3/8"</option>
<option>66 1/2"</option>
<option>66 5/8"</option>
<option>66 3/4"</option>
<option>66 7/8"</option>
<option>67"</option>
<option>67 1/8"</option>
<option>67 1/4"</option>
<option>67 3/8"</option>
<option>67 1/2"</option>
<option>67 5/8"</option>
<option>67 3/4"</option>
<option>67 7/8"</option>
<option>68"</option>
<option>68 1/8"</option>
<option>68 1/4"</option>
<option>68 3/8"</option>
<option>68 1/2"</option>
<option>68 5/8"</option>
<option>68 3/4"</option>
<option>68 7/8"</option>
<option>69"</option>
<option>69 1/8"</option>
<option>69 1/4"</option>
<option>69 3/8"</option>
<option>69 1/2"</option>
<option>69 5/8"</option>
<option>69 3/4"</option>
<option>69 7/8"</option>
<option>70"</option>
<option>70 1/8"</option>
<option>70 1/4"</option>
<option>70 3/8"</option>
<option>70 1/2"</option>
<option>70 5/8"</option>
<option>70 3/4"</option>
<option>70 7/8"</option>
<option>71"</option>
<option>71 1/8"</option>
<option>71 1/4"</option>
<option>71 3/8"</option>
<option>71 1/2"</option>
<option>71 5/8"</option>
<option>71 3/4"</option>
<option>71 7/8"</option>
<option>72"</option>
<option>72 1/8"</option>
<option>72 1/4"</option>
<option>72 3/8"</option>
<option>72 1/2"</option>
<option>72 5/8"</option>
<option>72 3/4"</option>
<option>72 7/8"</option>
<option>73"</option>
<option>73 1/8"</option>
<option>73 1/4"</option>
<option>73 3/8"</option>
<option>73 1/2"</option>
<option>73 5/8"</option>
<option>73 3/4"</option>
<option>73 7/8"</option>
<option>74"</option>
<option>74 1/8"</option>
<option>74 1/4"</option>
<option>74 3/8"</option>
<option>74 1/2"</option>
<option>74 5/8"</option>
<option>74 3/4"</option>
<option>74 7/8"</option>
<option>75"</option>
<option>75 1/8"</option>
<option>75 1/4"</option>
<option>75 3/8"</option>
<option>75 1/2"</option>
<option>75 5/8"</option>
<option>75 3/4"</option>
<option>75 7/8"</option>
<option>76"</option>
<option>76 1/8"</option>
<option>76 1/4"</option>
<option>76 3/8"</option>
<option>76 1/2"</option>
<option>76 5/8"</option>
<option>76 3/4"</option>
<option>76 7/8"</option>
<option>77"</option>
<option>77 1/8"</option>
<option>77 1/4"</option>
<option>77 3/8"</option>
<option>77 1/2"</option>
<option>77 5/8"</option>
<option>77 3/4"</option>
<option>77 7/8"</option>
<option>78"</option>
<option>78 1/8"</option>
<option>78 1/4"</option>
<option>78 3/8"</option>
<option>78 1/2"</option>
<option>78 5/8"</option>
<option>78 3/4"</option>
<option>78 7/8"</option>
<option>79"</option>
<option>79 1/8"</option>
<option>79 1/4"</option>
<option>79 3/8"</option>
<option>79 1/2"</option>
<option>79 5/8"</option>
<option>79 3/4"</option>
<option>79 7/8"</option>
<option>80"</option>
<option>80 1/8"</option>
<option>80 1/4"</option>
<option>80 3/8"</option>
<option>80 1/2"</option>
<option>80 5/8"</option>
<option>80 3/4"</option>
<option>80 7/8"</option>
<option>81"</option>
<option>81 1/8"</option>
<option>81 1/4"</option>
<option>81 3/8"</option>
<option>81 1/2"</option>
<option>81 5/8"</option>
<option>81 3/4"</option>
<option>81 7/8"</option>
<option>82"</option>
<option>82 1/8"</option>
<option>82 1/4"</option>
<option>82 3/8"</option>
<option>82 1/2"</option>
<option>82 5/8"</option>
<option>82 3/4"</option>
<option>82 7/8"</option>
<option>83"</option>
<option>83 1/8"</option>
<option>83 1/4"</option>
<option>83 3/8"</option>
<option>83 1/2"</option>
<option>83 5/8"</option>
<option>83 3/4"</option>
<option>83 7/8"</option>
<option>84"</option>
<option>84 1/8"</option>
<option>84 1/4"</option>
<option>84 3/8"</option>
<option>84 1/2"</option>
<option>84 5/8"</option>
<option>84 3/4"</option>
<option>84 7/8"</option>
<option>85"</option>
<option>85 1/8"</option>
<option>85 1/4"</option>
<option>85 3/8"</option>
<option>85 1/2"</option>
<option>85 5/8"</option>
<option>85 3/4"</option>
<option>85 7/8"</option>
<option>86"</option>
<option>86 1/8"</option>
<option>86 1/4"</option>
<option>86 3/8"</option>
<option>86 1/2"</option>
<option>86 5/8"</option>
<option>86 3/4"</option>
<option>86 7/8"</option>
<option>87"</option>
<option>87 1/8"</option>
<option>87 1/4"</option>
<option>87 3/8"</option>
<option>87 1/2"</option>
<option>87 5/8"</option>
<option>87 3/4"</option>
<option>87 7/8"</option>
<option>88"</option>
<option>88 1/8"</option>
<option>88 1/4"</option>
<option>88 3/8"</option>
<option>88 1/2"</option>
<option>88 5/8"</option>
<option>88 3/4"</option>
<option>88 7/8"</option>
<option>89"</option>
<option>89 1/8"</option>
<option>89 1/4"</option>
<option>89 3/8"</option>
<option>89 1/2"</option>
<option>89 5/8"</option>
<option>89 3/4"</option>
<option>89 7/8"</option>
<option>90"</option>
<option>90 1/8"</option>
<option>90 1/4"</option>
<option>90 3/8"</option>
<option>90 1/2"</option>
<option>90 5/8"</option>
<option>90 3/4"</option>
<option>90 7/8"</option>
<option>91"</option>
<option>91 1/8"</option>
<option>91 1/4"</option>
<option>91 3/8"</option>
<option>91 1/2"</option>
<option>91 5/8"</option>
<option>91 3/4"</option>
<option>91 7/8"</option>
<option>92"</option>
<option>92 1/8"</option>
<option>92 1/4"</option>
<option>92 3/8"</option>
<option>92 1/2"</option>
<option>92 5/8"</option>
<option>92 3/4"</option>
<option>92 7/8"</option>
<option>93"</option>
<option>93 1/8"</option>
<option>93 1/4"</option>
<option>93 3/8"</option>
<option>93 1/2"</option>
<option>93 5/8"</option>
<option>93 3/4"</option>
<option>93 7/8"</option>
<option>94"</option>
<option>94 1/8"</option>
<option>94 1/4"</option>
<option>94 3/8"</option>
<option>94 1/2"</option>
<option>94 5/8"</option>
<option>94 3/4"</option>
<option>94 7/8"</option>
<option>95"</option>
<option>95 1/8"</option>
<option>95 1/4"</option>
<option>95 3/8"</option>
<option>95 1/2"</option>
<option>95 5/8"</option>
<option>95 3/4"</option>
<option>95 7/8"</option>
<option>96"</option>
<option>96 1/8"</option>
<option>96 1/4"</option>
<option>96 3/8"</option>
<option>96 1/2"</option>
<option>96 5/8"</option>
<option>96 3/4"</option>
<option>96 7/8"</option>
<option>97"</option>
<option>97 1/8"</option>
<option>97 1/4"</option>
<option>97 3/8"</option>
<option>97 1/2"</option>
<option>97 5/8"</option>
<option>97 3/4"</option>
<option>97 7/8"</option>
<option>98"</option>
<option>98 1/8"</option>
<option>98 1/4"</option>
<option>98 3/8"</option>
<option>98 1/2"</option>
<option>98 5/8"</option>
<option>98 3/4"</option>
<option>98 7/8"</option>
<option>99"</option>
<option>99 1/8"</option>
<option>99 1/4"</option>
<option>99 3/8"</option>
<option>99 1/2"</option>
<option>99 5/8"</option>
<option>99 3/4"</option>
<option>99 7/8"</option>
<option>100"</option>
<option>100 1/8"</option>
<option>100 1/4"</option>
<option>100 3/8"</option>
<option>100 1/2"</option>
<option>100 5/8"</option>
<option>100 3/4"</option>
<option>100 7/8"</option>
<option>101"</option>
<option>101 1/8"</option>
<option>101 1/4"</option>
<option>101 3/8"</option>
<option>101 1/2"</option>
<option>101 5/8"</option>
<option>101 3/4"</option>
<option>101 7/8"</option>
<option>102"</option>
<option>102 1/8"</option>
<option>102 1/4"</option>
<option>102 3/8"</option>
<option>102 1/2"</option>
<option>102 5/8"</option>
<option>102 3/4"</option>
<option>102 7/8"</option>
<option>103"</option>
<option>103 1/8"</option>
<option>103 1/4"</option>
<option>103 3/8"</option>
<option>103 1/2"</option>
<option>103 5/8"</option>
<option>103 3/4"</option>
<option>103 7/8"</option>
<option>104"</option>
<option>104 1/8"</option>
<option>104 1/4"</option>
<option>104 3/8"</option>
<option>104 1/2"</option>
<option>104 5/8"</option>
<option>104 3/4"</option>
<option>104 7/8"</option>
<option>105"</option>
<option>105 1/8"</option>
<option>105 1/4"</option>
<option>105 3/8"</option>
<option>105 1/2"</option>
<option>105 5/8"</option>
<option>105 3/4"</option>
<option>105 7/8"</option>
<option>106"</option>
<option>106 1/8"</option>
<option>106 1/4"</option>
<option>106 3/8"</option>
<option>106 1/2"</option>
<option>106 5/8"</option>
<option>106 3/4"</option>
<option>106 7/8"</option>
<option>107"</option>
<option>107 1/8"</option>
<option>107 1/4"</option>
<option>107 3/8"</option>
<option>107 1/2"</option>
<option>107 5/8"</option>
<option>107 3/4"</option>
<option>107 7/8"</option>
<option>108"</option>
<option>108 1/8"</option>
<option>108 1/4"</option>
<option>108 3/8"</option>
<option>108 1/2"</option>
<option>108 5/8"</option>
<option>108 3/4"</option>
<option>108 7/8"</option>
<option>109"</option>
<option>109 1/8"</option>
<option>109 1/4"</option>
<option>109 3/8"</option>
<option>109 1/2"</option>
<option>109 5/8"</option>
<option>109 3/4"</option>
<option>109 7/8"</option>
<option>110"</option>
<option>110 1/8"</option>
<option>110 1/4"</option>
<option>110 3/8"</option>
<option>110 1/2"</option>
<option>110 5/8"</option>
<option>110 3/4"</option>
<option>110 7/8"</option>
<option>111"</option>
<option>111 1/8"</option>
<option>111 1/4"</option>
<option>111 3/8"</option>
<option>111 1/2"</option>
<option>111 5/8"</option>
<option>111 3/4"</option>
<option>111 7/8"</option>
<option>112"</option>
<option>112 1/8"</option>
<option>112 1/4"</option>
<option>112 3/8"</option>
<option>112 1/2"</option>
<option>112 5/8"</option>
<option>112 3/4"</option>
<option>112 7/8"</option>
<option>113"</option>
<option>113 1/8"</option>
<option>113 1/4"</option>
<option>113 3/8"</option>
<option>113 1/2"</option>
<option>113 5/8"</option>
<option>113 3/4"</option>
<option>113 7/8"</option>
<option>114"</option>
<option>114 1/8"</option>
<option>114 1/4"</option>
<option>114 3/8"</option>
<option>114 1/2"</option>
<option>114 5/8"</option>
<option>114 3/4"</option>
<option>114 7/8"</option>
<option>115"</option>
<option>115 1/8"</option>
<option>115 1/4"</option>
<option>115 3/8"</option>
<option>115 1/2"</option>
<option>115 5/8"</option>
<option>115 3/4"</option>
<option>115 7/8"</option>
<option>116"</option>
<option>116 1/8"</option>
<option>116 1/4"</option>
<option>116 3/8"</option>
<option>116 1/2"</option>
<option>116 5/8"</option>
<option>116 3/4"</option>
<option>116 7/8"</option>
<option>117"</option>
<option>117 1/8"</option>
<option>117 1/4"</option>
<option>117 3/8"</option>
<option>117 1/2"</option>
<option>117 5/8"</option>
<option>117 3/4"</option>
<option>117 7/8"</option>
<option>118"</option>
<option>118 1/8"</option>
<option>118 1/4"</option>
<option>118 3/8"</option>
<option>118 1/2"</option>
<option>118 5/8"</option>
<option>118 3/4"</option>
<option>118 7/8"</option>
<option>119"</option>
<option>119 1/8"</option>
<option>119 1/4"</option>
<option>119 3/8"</option>
<option>119 1/2"</option>
<option>119 5/8"</option>
<option>119 3/4"</option>
<option>119 7/8"</option>
<option>120"</option>
<option>120 1/8"</option>
<option>120 1/4"</option>
<option>120 3/8"</option>
<option>120 1/2"</option>
<option>120 5/8"</option>
<option>120 3/4"</option>
<option>120 7/8"</option>
<option>121"</option>
<option>121 1/8"</option>
<option>121 1/4"</option>
<option>121 3/8"</option>
<option>121 1/2"</option>
<option>121 5/8"</option>
<option>121 3/4"</option>
<option>121 7/8"</option>
<option>122"</option>
<option>122 1/8"</option>
<option>122 1/4"</option>
<option>122 3/8"</option>
<option>122 1/2"</option>
<option>122 5/8"</option>
<option>122 3/4"</option>
<option>122 7/8"</option>
<option>123"</option>
<option>123 1/8"</option>
<option>123 1/4"</option>
<option>123 3/8"</option>
<option>123 1/2"</option>
<option>123 5/8"</option>
<option>123 3/4"</option>
<option>123 7/8"</option>
<option>124"</option>
<option>124 1/8"</option>
<option>124 1/4"</option>
<option>124 3/8"</option>
<option>124 1/2"</option>
<option>124 5/8"</option>
<option>124 3/4"</option>
<option>124 7/8"</option>
<option>125"</option>
<option>125 1/8"</option>
<option>125 1/4"</option>
<option>125 3/8"</option>
<option>125 1/2"</option>
<option>125 5/8"</option>
<option>125 3/4"</option>
<option>125 7/8"</option>
<option>126"</option>
<option>126 1/8"</option>
<option>126 1/4"</option>
<option>126 3/8"</option>
<option>126 1/2"</option>
<option>126 5/8"</option>
<option>126 3/4"</option>
<option>126 7/8"</option>
<option>127"</option>
<option>127 1/8"</option>
<option>127 1/4"</option>
<option>127 3/8"</option>
<option>127 1/2"</option>
<option>127 5/8"</option>
<option>127 3/4"</option>
<option>127 7/8"</option>
<option>128"</option>
<option>128 1/8"</option>
<option>128 1/4"</option>
<option>128 3/8"</option>
<option>128 1/2"</option>
<option>128 5/8"</option>
<option>128 3/4"</option>
<option>128 7/8"</option>
<option>129"</option>
<option>129 1/8"</option>
<option>129 1/4"</option>
<option>129 3/8"</option>
<option>129 1/2"</option>
<option>129 5/8"</option>
<option>129 3/4"</option>
<option>129 7/8"</option>
<option>130"</option>
<option>130 1/8"</option>
<option>130 1/4"</option>
<option>130 3/8"</option>
<option>130 1/2"</option>
<option>130 5/8"</option>
<option>130 3/4"</option>
<option>130 7/8"</option>
<option>131"</option>
<option>131 1/8"</option>
<option>131 1/4"</option>
<option>131 3/8"</option>
<option>131 1/2"</option>
<option>131 5/8"</option>
<option>131 3/4"</option>
<option>131 7/8"</option>
<option>132"</option>
<option>132 1/8"</option>
<option>132 1/4"</option>
<option>132 3/8"</option>
<option>132 1/2"</option>
<option>132 5/8"</option>
<option>132 3/4"</option>
<option>132 7/8"</option>
<option>133"</option>
<option>133 1/8"</option>
<option>133 1/4"</option>
<option>133 3/8"</option>
<option>133 1/2"</option>
<option>133 5/8"</option>
<option>133 3/4"</option>
<option>133 7/8"</option>
<option>134"</option>
<option>134 1/8"</option>
<option>134 1/4"</option>
<option>134 3/8"</option>
<option>134 1/2"</option>
<option>134 5/8"</option>
<option>134 3/4"</option>
<option>134 7/8"</option>
<option>135"</option>
<option>135 1/8"</option>
<option>135 1/4"</option>
<option>135 3/8"</option>
<option>135 1/2"</option>
<option>135 5/8"</option>
<option>135 3/4"</option>
<option>135 7/8"</option>
<option>136"</option>
<option>136 1/8"</option>
<option>136 1/4"</option>
<option>136 3/8"</option>
<option>136 1/2"</option>
<option>136 5/8"</option>
<option>136 3/4"</option>
<option>136 7/8"</option>
<option>137"</option>
<option>137 1/8"</option>
<option>137 1/4"</option>
<option>137 3/8"</option>
<option>137 1/2"</option>
<option>137 5/8"</option>
<option>137 3/4"</option>
<option>137 7/8"</option>
<option>138"</option>
<option>138 1/8"</option>
<option>138 1/4"</option>
<option>138 3/8"</option>
<option>138 1/2"</option>
<option>138 5/8"</option>
<option>138 3/4"</option>
<option>138 7/8"</option>
<option>139"</option>
<option>139 1/8"</option>
<option>139 1/4"</option>
<option>139 3/8"</option>
<option>139 1/2"</option>
<option>139 5/8"</option>
<option>139 3/4"</option>
<option>139 7/8"</option>
<option>140"</option>
<option>140 1/8"</option>
<option>140 1/4"</option>
<option>140 3/8"</option>
<option>140 1/2"</option>
<option>140 5/8"</option>
<option>140 3/4"</option>
<option>140 7/8"</option>
<option>141"</option>
<option>141 1/8"</option>
<option>141 1/4"</option>
<option>141 3/8"</option>
<option>141 1/2"</option>
<option>141 5/8"</option>
<option>141 3/4"</option>
<option>141 7/8"</option>
<option>142"</option>
<option>142 1/8"</option>
<option>142 1/4"</option>
<option>142 3/8"</option>
<option>142 1/2"</option>
<option>142 5/8"</option>
<option>142 3/4"</option>
<option>142 7/8"</option>
<option>143"</option>
<option>143 1/8"</option>
<option>143 1/4"</option>
<option>143 3/8"</option>
<option>143 1/2"</option>
<option>143 5/8"</option>
<option>143 3/4"</option>
<option>143 7/8"</option>
<option>144"</option>
<option>144 1/8"</option>
<option>144 1/4"</option>
<option>144 3/8"</option>
<option>144 1/2"</option>
<option>144 5/8"</option>
<option>144 3/4"</option>
<option>144 7/8"</option>
<option>145"</option>
<option>145 1/8"</option>
<option>145 1/4"</option>
<option>145 3/8"</option>
<option>145 1/2"</option>
<option>145 5/8"</option>
<option>145 3/4"</option>
<option>145 7/8"</option>
<option>146"</option>
<option>146 1/8"</option>
<option>146 1/4"</option>
<option>146 3/8"</option>
<option>146 1/2"</option>
<option>146 5/8"</option>
<option>146 3/4"</option>
<option>146 7/8"</option>
<option>147"</option>
<option>147 1/8"</option>
<option>147 1/4"</option>
<option>147 3/8"</option>
<option>147 1/2"</option>
<option>147 5/8"</option>
<option>147 3/4"</option>
<option>147 7/8"</option>
<option>148"</option>
<option>148 1/8"</option>
<option>148 1/4"</option>
<option>148 3/8"</option>
<option>148 1/2"</option>
<option>148 5/8"</option>
<option>148 3/4"</option>
<option>148 7/8"</option>
<option>149"</option>
<option>149 1/8"</option>
<option>149 1/4"</option>
<option>149 3/8"</option>
<option>149 1/2"</option>
<option>149 5/8"</option>
<option>149 3/4"</option>
<option>149 7/8"</option>
<option>150"</option>
<option>150 1/8"</option>
<option>150 1/4"</option>
<option>150 3/8"</option>
<option>150 1/2"</option>
<option>150 5/8"</option>
<option>150 3/4"</option>
<option>150 7/8"</option>
<option>151"</option>
<option>151 1/8"</option>
<option>151 1/4"</option>
<option>151 3/8"</option>
<option>151 1/2"</option>
<option>151 5/8"</option>
<option>151 3/4"</option>
<option>151 7/8"</option>
<option>152"</option>
<option>152 1/8"</option>
<option>152 1/4"</option>
<option>152 3/8"</option>
<option>152 1/2"</option>
<option>152 5/8"</option>
<option>152 3/4"</option>
<option>152 7/8"</option>
<option>153"</option>
<option>153 1/8"</option>
<option>153 1/4"</option>
<option>153 3/8"</option>
<option>153 1/2"</option>
<option>153 5/8"</option>
<option>153 3/4"</option>
<option>153 7/8"</option>
<option>154"</option>
<option>154 1/8"</option>
<option>154 1/4"</option>
<option>154 3/8"</option>
<option>154 1/2"</option>
<option>154 5/8"</option>
<option>154 3/4"</option>
<option>154 7/8"</option>
<option>155"</option>
<option>155 1/8"</option>
<option>155 1/4"</option>
<option>155 3/8"</option>
<option>155 1/2"</option>
<option>155 5/8"</option>
<option>155 3/4"</option>
<option>155 7/8"</option>
<option>156"</option>
<option>156 1/8"</option>
<option>156 1/4"</option>
<option>156 3/8"</option>
<option>156 1/2"</option>
<option>156 5/8"</option>
<option>156 3/4"</option>
<option>156 7/8"</option>
<option>157"</option>
<option>157 1/8"</option>
<option>157 1/4"</option>
<option>157 3/8"</option>
<option>157 1/2"</option>
<option>157 5/8"</option>
<option>157 3/4"</option>
<option>157 7/8"</option>
<option>158"</option>
<option>158 1/8"</option>
<option>158 1/4"</option>
<option>158 3/8"</option>
<option>158 1/2"</option>
<option>158 5/8"</option>
<option>158 3/4"</option>
<option>158 7/8"</option>
<option>159"</option>
<option>159 1/8"</option>
<option>159 1/4"</option>
<option>159 3/8"</option>
<option>159 1/2"</option>
<option>159 5/8"</option>
<option>159 3/4"</option>
<option>159 7/8"</option>
<option>160"</option>
<option>160 1/8"</option>
<option>160 1/4"</option>
<option>160 3/8"</option>
<option>160 1/2"</option>
<option>160 5/8"</option>
<option>160 3/4"</option>
<option>160 7/8"</option>
<option>161"</option>
<option>161 1/8"</option>
<option>161 1/4"</option>
<option>161 3/8"</option>
<option>161 1/2"</option>
<option>161 5/8"</option>
<option>161 3/4"</option>
<option>161 7/8"</option>
<option>162"</option>
<option>162 1/8"</option>
<option>162 1/4"</option>
<option>162 3/8"</option>
<option>162 1/2"</option>
<option>162 5/8"</option>
<option>162 3/4"</option>
<option>162 7/8"</option>
<option>163"</option>
<option>163 1/8"</option>
<option>163 1/4"</option>
<option>163 3/8"</option>
<option>163 1/2"</option>
<option>163 5/8"</option>
<option>163 3/4"</option>
<option>163 7/8"</option>
<option>164"</option>
<option>164 1/8"</option>
<option>164 1/4"</option>
<option>164 3/8"</option>
<option>164 1/2"</option>
<option>164 5/8"</option>
<option>164 3/4"</option>
<option>164 7/8"</option>
<option>165"</option>
<option>165 1/8"</option>
<option>165 1/4"</option>
<option>165 3/8"</option>
<option>165 1/2"</option>
<option>165 5/8"</option>
<option>165 3/4"</option>
<option>165 7/8"</option>
<option>166"</option>
<option>166 1/8"</option>
<option>166 1/4"</option>
<option>166 3/8"</option>
<option>166 1/2"</option>
<option>166 5/8"</option>
<option>166 3/4"</option>
<option>166 7/8"</option>
<option>167"</option>
<option>167 1/8"</option>
<option>167 1/4"</option>
<option>167 3/8"</option>
<option>167 1/2"</option>
<option>167 5/8"</option>
<option>167 3/4"</option>
<option>167 7/8"</option>
<option>168"</option>
<option>168 1/8"</option>
<option>168 1/4"</option>
<option>168 3/8"</option>
<option>168 1/2"</option>
<option>168 5/8"</option>
<option>168 3/4"</option>
<option>168 7/8"</option>
<option>169"</option>
<option>169 1/8"</option>
<option>169 1/4"</option>
<option>169 3/8"</option>
<option>169 1/2"</option>
<option>169 5/8"</option>
<option>169 3/4"</option>
<option>169 7/8"</option>
<option>170"</option>
<option>170 1/8"</option>
<option>170 1/4"</option>
<option>170 3/8"</option>
<option>170 1/2"</option>
<option>170 5/8"</option>
<option>170 3/4"</option>
<option>170 7/8"</option>
<option>171"</option>
<option>171 1/8"</option>
<option>171 1/4"</option>
<option>171 3/8"</option>
<option>171 1/2"</option>
<option>171 5/8"</option>
<option>171 3/4"</option>
<option>171 7/8"</option>
<option>172"</option>
<option>172 1/8"</option>
<option>172 1/4"</option>
<option>172 3/8"</option>
<option>172 1/2"</option>
<option>172 5/8"</option>
<option>172 3/4"</option>
<option>172 7/8"</option>
<option>173"</option>
<option>173 1/8"</option>
<option>173 1/4"</option>
<option>173 3/8"</option>
<option>173 1/2"</option>
<option>173 5/8"</option>
<option>173 3/4"</option>
<option>173 7/8"</option>
<option>174"</option>
<option>174 1/8"</option>
<option>174 1/4"</option>
<option>174 3/8"</option>
<option>174 1/2"</option>
<option>174 5/8"</option>
<option>174 3/4"</option>
<option>174 7/8"</option>
<option>175"</option>
<option>175 1/8"</option>
<option>175 1/4"</option>
<option>175 3/8"</option>
<option>175 1/2"</option>
<option>175 5/8"</option>
<option>175 3/4"</option>
<option>175 7/8"</option>
<option>176"</option>
<option>176 1/8"</option>
<option>176 1/4"</option>
<option>176 3/8"</option>
<option>176 1/2"</option>
<option>176 5/8"</option>
<option>176 3/4"</option>
<option>176 7/8"</option>
<option>177"</option>
<option>177 1/8"</option>
<option>177 1/4"</option>
<option>177 3/8"</option>
<option>177 1/2"</option>
<option>177 5/8"</option>
<option>177 3/4"</option>
<option>177 7/8"</option>
<option>178"</option>
<option>178 1/8"</option>
<option>178 1/4"</option>
<option>178 3/8"</option>
<option>178 1/2"</option>
<option>178 5/8"</option>
<option>178 3/4"</option>
<option>178 7/8"</option>
<option>179"</option>
<option>179 1/8"</option>
<option>179 1/4"</option>
<option>179 3/8"</option>
<option>179 1/2"</option>
<option>179 5/8"</option>
<option>179 3/4"</option>
<option>179 7/8"</option>
<option>180"</option>
<option>180 1/8"</option>
<option>180 1/4"</option>
<option>180 3/8"</option>
<option>180 1/2"</option>
<option>180 5/8"</option>
<option>180 3/4"</option>
<option>180 7/8"</option>
<option>181"</option>
<option>181 1/8"</option>
<option>181 1/4"</option>
<option>181 3/8"</option>
<option>181 1/2"</option>
<option>181 5/8"</option>
<option>181 3/4"</option>
<option>181 7/8"</option>
<option>182"</option>
<option>182 1/8"</option>
<option>182 1/4"</option>
<option>182 3/8"</option>
<option>182 1/2"</option>
<option>182 5/8"</option>
<option>182 3/4"</option>
<option>182 7/8"</option>
<option>183"</option>
<option>183 1/8"</option>
<option>183 1/4"</option>
<option>183 3/8"</option>
<option>183 1/2"</option>
<option>183 5/8"</option>
<option>183 3/4"</option>
<option>183 7/8"</option>
<option>184"</option>
<option>184 1/8"</option>
<option>184 1/4"</option>
<option>184 3/8"</option>
<option>184 1/2"</option>
<option>184 5/8"</option>
<option>184 3/4"</option>
<option>184 7/8"</option>
<option>185"</option>
<option>185 1/8"</option>
<option>185 1/4"</option>
<option>185 3/8"</option>
<option>185 1/2"</option>
<option>185 5/8"</option>
<option>185 3/4"</option>
<option>185 7/8"</option>
<option>186"</option>
<option>186 1/8"</option>
<option>186 1/4"</option>
<option>186 3/8"</option>
<option>186 1/2"</option>
<option>186 5/8"</option>
<option>186 3/4"</option>
<option>186 7/8"</option>
<option>187"</option>
<option>187 1/8"</option>
<option>187 1/4"</option>
<option>187 3/8"</option>
<option>187 1/2"</option>
<option>187 5/8"</option>
<option>187 3/4"</option>
<option>187 7/8"</option>
<option>188"</option>
<option>188 1/8"</option>
<option>188 1/4"</option>
<option>188 3/8"</option>
<option>188 1/2"</option>
<option>188 5/8"</option>
<option>188 3/4"</option>
<option>188 7/8"</option>
<option>189"</option>
<option>189 1/8"</option>
<option>189 1/4"</option>
<option>189 3/8"</option>
<option>189 1/2"</option>
<option>189 5/8"</option>
<option>189 3/4"</option>
<option>189 7/8"</option>
<option>190"</option>
<option>190 1/8"</option>
<option>190 1/4"</option>
<option>190 3/8"</option>
<option>190 1/2"</option>
<option>190 5/8"</option>
<option>190 3/4"</option>
<option>190 7/8"</option>
<option>191"</option>
<option>191 1/8"</option>
<option>191 1/4"</option>
<option>191 3/8"</option>
<option>191 1/2"</option>
<option>191 5/8"</option>
<option>191 3/4"</option>
<option>191 7/8"</option>
<option>192"</option>
<option>192 1/8"</option>
<option>192 1/4"</option>
<option>192 3/8"</option>
<option>192 1/2"</option>
<option>192 5/8"</option>
<option>192 3/4"</option>
<option>192 7/8"</option>
<option>193"</option>
<option>193 1/8"</option>
<option>193 1/4"</option>
<option>193 3/8"</option>
<option>193 1/2"</option>
<option>193 5/8"</option>
<option>193 3/4"</option>
<option>193 7/8"</option>
<option>194"</option>
<option>194 1/8"</option>
<option>194 1/4"</option>
<option>194 3/8"</option>
<option>194 1/2"</option>
<option>194 5/8"</option>
<option>194 3/4"</option>
<option>194 7/8"</option>
<option>195"</option>
<option>195 1/8"</option>
<option>195 1/4"</option>
<option>195 3/8"</option>
<option>195 1/2"</option>
<option>195 5/8"</option>
<option>195 3/4"</option>
<option>195 7/8"</option>
<option>196"</option>
<option>196 1/8"</option>
<option>196 1/4"</option>
<option>196 3/8"</option>
<option>196 1/2"</option>
<option>196 5/8"</option>
<option>196 3/4"</option>
<option>196 7/8"</option>
<option>197"</option>
<option>197 1/8"</option>
<option>197 1/4"</option>
<option>197 3/8"</option>
<option>197 1/2"</option>
<option>197 5/8"</option>
<option>197 3/4"</option>
<option>197 7/8"</option>
<option>198"</option>
<option>198 1/8"</option>
<option>198 1/4"</option>
<option>198 3/8"</option>
<option>198 1/2"</option>
<option>198 5/8"</option>
<option>198 3/4"</option>
<option>198 7/8"</option>
<option>199"</option>
<option>199 1/8"</option>
<option>199 1/4"</option>
<option>199 3/8"</option>
<option>199 1/2"</option>
<option>199 5/8"</option>
<option>199 3/4"</option>
<option>199 7/8"</option>
<option>200"</option>
 	</select> 
<label>Size 3:</label>
<select name="inventory_material_size3">
 	<option selected="yes"><?php echo $inventory_material_size3; ?></option>
	<option>1/8"</option>
<option>1/4"</option>
<option>3/8"</option>
<option>1/2"</option>
<option>5/8"</option>
<option>3/4"</option>
<option>7/8"</option>
<option>1"</option>
<option>1 1/8"</option>
<option>1 1/4"</option>
<option>1 3/8"</option>
<option>1 1/2"</option>
<option>1 5/8"</option>
<option>1 3/4"</option>
<option>1 7/8"</option>
<option>2"</option>
<option>2 1/8"</option>
<option>2 1/4"</option>
<option>2 3/8"</option>
<option>2 1/2"</option>
<option>2 5/8"</option>
<option>2 3/4"</option>
<option>2 7/8"</option>
<option>3"</option>
<option>3 1/8"</option>
<option>3 1/4"</option>
<option>3 3/8"</option>
<option>3 1/2"</option>
<option>3 5/8"</option>
<option>3 3/4"</option>
<option>3 7/8"</option>
<option>4"</option>
<option>4 1/8"</option>
<option>4 1/4"</option>
<option>4 3/8"</option>
<option>4 1/2"</option>
<option>4 5/8"</option>
<option>4 3/4"</option>
<option>4 7/8"</option>
<option>5"</option>
<option>5 1/8"</option>
<option>5 1/4"</option>
<option>5 3/8"</option>
<option>5 1/2"</option>
<option>5 5/8"</option>
<option>5 3/4"</option>
<option>5 7/8"</option>
<option>6"</option>
<option>6 1/8"</option>
<option>6 1/4"</option>
<option>6 3/8"</option>
<option>6 1/2"</option>
<option>6 5/8"</option>
<option>6 3/4"</option>
<option>6 7/8"</option>
<option>7"</option>
<option>7 1/8"</option>
<option>7 1/4"</option>
<option>7 3/8"</option>
<option>7 1/2"</option>
<option>7 5/8"</option>
<option>7 3/4"</option>
<option>7 7/8"</option>
<option>8"</option>
<option>8 1/8"</option>
<option>8 1/4"</option>
<option>8 3/8"</option>
<option>8 1/2"</option>
<option>8 5/8"</option>
<option>8 3/4"</option>
<option>8 7/8"</option>
<option>9"</option>
<option>9 1/8"</option>
<option>9 1/4"</option>
<option>9 3/8"</option>
<option>9 1/2"</option>
<option>9 5/8"</option>
<option>9 3/4"</option>
<option>9 7/8"</option>
<option>10"</option>
<option>10 1/8"</option>
<option>10 1/4"</option>
<option>10 3/8"</option>
<option>10 1/2"</option>
<option>10 5/8"</option>
<option>10 3/4"</option>
<option>10 7/8"</option>
<option>11"</option>
<option>11 1/8"</option>
<option>11 1/4"</option>
<option>11 3/8"</option>
<option>11 1/2"</option>
<option>11 5/8"</option>
<option>11 3/4"</option>
<option>11 7/8"</option>
<option>12"</option>
<option>12 1/8"</option>
<option>12 1/4"</option>
<option>12 3/8"</option>
<option>12 1/2"</option>
<option>12 5/8"</option>
<option>12 3/4"</option>
<option>12 7/8"</option>
<option>13"</option>
<option>13 1/8"</option>
<option>13 1/4"</option>
<option>13 3/8"</option>
<option>13 1/2"</option>
<option>13 5/8"</option>
<option>13 3/4"</option>
<option>13 7/8"</option>
<option>14"</option>
<option>14 1/8"</option>
<option>14 1/4"</option>
<option>14 3/8"</option>
<option>14 1/2"</option>
<option>14 5/8"</option>
<option>14 3/4"</option>
<option>14 7/8"</option>
<option>15"</option>
<option>15 1/8"</option>
<option>15 1/4"</option>
<option>15 3/8"</option>
<option>15 1/2"</option>
<option>15 5/8"</option>
<option>15 3/4"</option>
<option>15 7/8"</option>
<option>16"</option>
<option>16 1/8"</option>
<option>16 1/4"</option>
<option>16 3/8"</option>
<option>16 1/2"</option>
<option>16 5/8"</option>
<option>16 3/4"</option>
<option>16 7/8"</option>
<option>17"</option>
<option>17 1/8"</option>
<option>17 1/4"</option>
<option>17 3/8"</option>
<option>17 1/2"</option>
<option>17 5/8"</option>
<option>17 3/4"</option>
<option>17 7/8"</option>
<option>18"</option>
<option>18 1/8"</option>
<option>18 1/4"</option>
<option>18 3/8"</option>
<option>18 1/2"</option>
<option>18 5/8"</option>
<option>18 3/4"</option>
<option>18 7/8"</option>
<option>19"</option>
<option>19 1/8"</option>
<option>19 1/4"</option>
<option>19 3/8"</option>
<option>19 1/2"</option>
<option>19 5/8"</option>
<option>19 3/4"</option>
<option>19 7/8"</option>
<option>20"</option>
<option>20 1/8"</option>
<option>20 1/4"</option>
<option>20 3/8"</option>
<option>20 1/2"</option>
<option>20 5/8"</option>
<option>20 3/4"</option>
<option>20 7/8"</option>
<option>21"</option>
<option>21 1/8"</option>
<option>21 1/4"</option>
<option>21 3/8"</option>
<option>21 1/2"</option>
<option>21 5/8"</option>
<option>21 3/4"</option>
<option>21 7/8"</option>
<option>22"</option>
<option>22 1/8"</option>
<option>22 1/4"</option>
<option>22 3/8"</option>
<option>22 1/2"</option>
<option>22 5/8"</option>
<option>22 3/4"</option>
<option>22 7/8"</option>
<option>23"</option>
<option>23 1/8"</option>
<option>23 1/4"</option>
<option>23 3/8"</option>
<option>23 1/2"</option>
<option>23 5/8"</option>
<option>23 3/4"</option>
<option>23 7/8"</option>
<option>24"</option>
<option>24 1/8"</option>
<option>24 1/4"</option>
<option>24 3/8"</option>
<option>24 1/2"</option>
<option>24 5/8"</option>
<option>24 3/4"</option>
<option>24 7/8"</option>
<option>25"</option>
<option>25 1/8"</option>
<option>25 1/4"</option>
<option>25 3/8"</option>
<option>25 1/2"</option>
<option>25 5/8"</option>
<option>25 3/4"</option>
<option>25 7/8"</option>
<option>26"</option>
<option>26 1/8"</option>
<option>26 1/4"</option>
<option>26 3/8"</option>
<option>26 1/2"</option>
<option>26 5/8"</option>
<option>26 3/4"</option>
<option>26 7/8"</option>
<option>27"</option>
<option>27 1/8"</option>
<option>27 1/4"</option>
<option>27 3/8"</option>
<option>27 1/2"</option>
<option>27 5/8"</option>
<option>27 3/4"</option>
<option>27 7/8"</option>
<option>28"</option>
<option>28 1/8"</option>
<option>28 1/4"</option>
<option>28 3/8"</option>
<option>28 1/2"</option>
<option>28 5/8"</option>
<option>28 3/4"</option>
<option>28 7/8"</option>
<option>29"</option>
<option>29 1/8"</option>
<option>29 1/4"</option>
<option>29 3/8"</option>
<option>29 1/2"</option>
<option>29 5/8"</option>
<option>29 3/4"</option>
<option>29 7/8"</option>
<option>30"</option>
<option>30 1/8"</option>
<option>30 1/4"</option>
<option>30 3/8"</option>
<option>30 1/2"</option>
<option>30 5/8"</option>
<option>30 3/4"</option>
<option>30 7/8"</option>
<option>31"</option>
<option>31 1/8"</option>
<option>31 1/4"</option>
<option>31 3/8"</option>
<option>31 1/2"</option>
<option>31 5/8"</option>
<option>31 3/4"</option>
<option>31 7/8"</option>
<option>32"</option>
<option>32 1/8"</option>
<option>32 1/4"</option>
<option>32 3/8"</option>
<option>32 1/2"</option>
<option>32 5/8"</option>
<option>32 3/4"</option>
<option>32 7/8"</option>
<option>33"</option>
<option>33 1/8"</option>
<option>33 1/4"</option>
<option>33 3/8"</option>
<option>33 1/2"</option>
<option>33 5/8"</option>
<option>33 3/4"</option>
<option>33 7/8"</option>
<option>34"</option>
<option>34 1/8"</option>
<option>34 1/4"</option>
<option>34 3/8"</option>
<option>34 1/2"</option>
<option>34 5/8"</option>
<option>34 3/4"</option>
<option>34 7/8"</option>
<option>35"</option>
<option>35 1/8"</option>
<option>35 1/4"</option>
<option>35 3/8"</option>
<option>35 1/2"</option>
<option>35 5/8"</option>
<option>35 3/4"</option>
<option>35 7/8"</option>
<option>36"</option>
<option>36 1/8"</option>
<option>36 1/4"</option>
<option>36 3/8"</option>
<option>36 1/2"</option>
<option>36 5/8"</option>
<option>36 3/4"</option>
<option>36 7/8"</option>
<option>37"</option>
<option>37 1/8"</option>
<option>37 1/4"</option>
<option>37 3/8"</option>
<option>37 1/2"</option>
<option>37 5/8"</option>
<option>37 3/4"</option>
<option>37 7/8"</option>
<option>38"</option>
<option>38 1/8"</option>
<option>38 1/4"</option>
<option>38 3/8"</option>
<option>38 1/2"</option>
<option>38 5/8"</option>
<option>38 3/4"</option>
<option>38 7/8"</option>
<option>39"</option>
<option>39 1/8"</option>
<option>39 1/4"</option>
<option>39 3/8"</option>
<option>39 1/2"</option>
<option>39 5/8"</option>
<option>39 3/4"</option>
<option>39 7/8"</option>
<option>40"</option>
<option>40 1/8"</option>
<option>40 1/4"</option>
<option>40 3/8"</option>
<option>40 1/2"</option>
<option>40 5/8"</option>
<option>40 3/4"</option>
<option>40 7/8"</option>
<option>41"</option>
<option>41 1/8"</option>
<option>41 1/4"</option>
<option>41 3/8"</option>
<option>41 1/2"</option>
<option>41 5/8"</option>
<option>41 3/4"</option>
<option>41 7/8"</option>
<option>42"</option>
<option>42 1/8"</option>
<option>42 1/4"</option>
<option>42 3/8"</option>
<option>42 1/2"</option>
<option>42 5/8"</option>
<option>42 3/4"</option>
<option>42 7/8"</option>
<option>43"</option>
<option>43 1/8"</option>
<option>43 1/4"</option>
<option>43 3/8"</option>
<option>43 1/2"</option>
<option>43 5/8"</option>
<option>43 3/4"</option>
<option>43 7/8"</option>
<option>44"</option>
<option>44 1/8"</option>
<option>44 1/4"</option>
<option>44 3/8"</option>
<option>44 1/2"</option>
<option>44 5/8"</option>
<option>44 3/4"</option>
<option>44 7/8"</option>
<option>45"</option>
<option>45 1/8"</option>
<option>45 1/4"</option>
<option>45 3/8"</option>
<option>45 1/2"</option>
<option>45 5/8"</option>
<option>45 3/4"</option>
<option>45 7/8"</option>
<option>46"</option>
<option>46 1/8"</option>
<option>46 1/4"</option>
<option>46 3/8"</option>
<option>46 1/2"</option>
<option>46 5/8"</option>
<option>46 3/4"</option>
<option>46 7/8"</option>
<option>47"</option>
<option>47 1/8"</option>
<option>47 1/4"</option>
<option>47 3/8"</option>
<option>47 1/2"</option>
<option>47 5/8"</option>
<option>47 3/4"</option>
<option>47 7/8"</option>
<option>48"</option>
<option>48 1/8"</option>
<option>48 1/4"</option>
<option>48 3/8"</option>
<option>48 1/2"</option>
<option>48 5/8"</option>
<option>48 3/4"</option>
<option>48 7/8"</option>
<option>49"</option>
<option>49 1/8"</option>
<option>49 1/4"</option>
<option>49 3/8"</option>
<option>49 1/2"</option>
<option>49 5/8"</option>
<option>49 3/4"</option>
<option>49 7/8"</option>
<option>50"</option>
<option>50 1/8"</option>
<option>50 1/4"</option>
<option>50 3/8"</option>
<option>50 1/2"</option>
<option>50 5/8"</option>
<option>50 3/4"</option>
<option>50 7/8"</option>
<option>51"</option>
<option>51 1/8"</option>
<option>51 1/4"</option>
<option>51 3/8"</option>
<option>51 1/2"</option>
<option>51 5/8"</option>
<option>51 3/4"</option>
<option>51 7/8"</option>
<option>52"</option>
<option>52 1/8"</option>
<option>52 1/4"</option>
<option>52 3/8"</option>
<option>52 1/2"</option>
<option>52 5/8"</option>
<option>52 3/4"</option>
<option>52 7/8"</option>
<option>53"</option>
<option>53 1/8"</option>
<option>53 1/4"</option>
<option>53 3/8"</option>
<option>53 1/2"</option>
<option>53 5/8"</option>
<option>53 3/4"</option>
<option>53 7/8"</option>
<option>54"</option>
<option>54 1/8"</option>
<option>54 1/4"</option>
<option>54 3/8"</option>
<option>54 1/2"</option>
<option>54 5/8"</option>
<option>54 3/4"</option>
<option>54 7/8"</option>
<option>55"</option>
<option>55 1/8"</option>
<option>55 1/4"</option>
<option>55 3/8"</option>
<option>55 1/2"</option>
<option>55 5/8"</option>
<option>55 3/4"</option>
<option>55 7/8"</option>
<option>56"</option>
<option>56 1/8"</option>
<option>56 1/4"</option>
<option>56 3/8"</option>
<option>56 1/2"</option>
<option>56 5/8"</option>
<option>56 3/4"</option>
<option>56 7/8"</option>
<option>57"</option>
<option>57 1/8"</option>
<option>57 1/4"</option>
<option>57 3/8"</option>
<option>57 1/2"</option>
<option>57 5/8"</option>
<option>57 3/4"</option>
<option>57 7/8"</option>
<option>58"</option>
<option>58 1/8"</option>
<option>58 1/4"</option>
<option>58 3/8"</option>
<option>58 1/2"</option>
<option>58 5/8"</option>
<option>58 3/4"</option>
<option>58 7/8"</option>
<option>59"</option>
<option>59 1/8"</option>
<option>59 1/4"</option>
<option>59 3/8"</option>
<option>59 1/2"</option>
<option>59 5/8"</option>
<option>59 3/4"</option>
<option>59 7/8"</option>
<option>60"</option>
<option>60 1/8"</option>
<option>60 1/4"</option>
<option>60 3/8"</option>
<option>60 1/2"</option>
<option>60 5/8"</option>
<option>60 3/4"</option>
<option>60 7/8"</option>
<option>61"</option>
<option>61 1/8"</option>
<option>61 1/4"</option>
<option>61 3/8"</option>
<option>61 1/2"</option>
<option>61 5/8"</option>
<option>61 3/4"</option>
<option>61 7/8"</option>
<option>62"</option>
<option>62 1/8"</option>
<option>62 1/4"</option>
<option>62 3/8"</option>
<option>62 1/2"</option>
<option>62 5/8"</option>
<option>62 3/4"</option>
<option>62 7/8"</option>
<option>63"</option>
<option>63 1/8"</option>
<option>63 1/4"</option>
<option>63 3/8"</option>
<option>63 1/2"</option>
<option>63 5/8"</option>
<option>63 3/4"</option>
<option>63 7/8"</option>
<option>64"</option>
<option>64 1/8"</option>
<option>64 1/4"</option>
<option>64 3/8"</option>
<option>64 1/2"</option>
<option>64 5/8"</option>
<option>64 3/4"</option>
<option>64 7/8"</option>
<option>65"</option>
<option>65 1/8"</option>
<option>65 1/4"</option>
<option>65 3/8"</option>
<option>65 1/2"</option>
<option>65 5/8"</option>
<option>65 3/4"</option>
<option>65 7/8"</option>
<option>66"</option>
<option>66 1/8"</option>
<option>66 1/4"</option>
<option>66 3/8"</option>
<option>66 1/2"</option>
<option>66 5/8"</option>
<option>66 3/4"</option>
<option>66 7/8"</option>
<option>67"</option>
<option>67 1/8"</option>
<option>67 1/4"</option>
<option>67 3/8"</option>
<option>67 1/2"</option>
<option>67 5/8"</option>
<option>67 3/4"</option>
<option>67 7/8"</option>
<option>68"</option>
<option>68 1/8"</option>
<option>68 1/4"</option>
<option>68 3/8"</option>
<option>68 1/2"</option>
<option>68 5/8"</option>
<option>68 3/4"</option>
<option>68 7/8"</option>
<option>69"</option>
<option>69 1/8"</option>
<option>69 1/4"</option>
<option>69 3/8"</option>
<option>69 1/2"</option>
<option>69 5/8"</option>
<option>69 3/4"</option>
<option>69 7/8"</option>
<option>70"</option>
<option>70 1/8"</option>
<option>70 1/4"</option>
<option>70 3/8"</option>
<option>70 1/2"</option>
<option>70 5/8"</option>
<option>70 3/4"</option>
<option>70 7/8"</option>
<option>71"</option>
<option>71 1/8"</option>
<option>71 1/4"</option>
<option>71 3/8"</option>
<option>71 1/2"</option>
<option>71 5/8"</option>
<option>71 3/4"</option>
<option>71 7/8"</option>
<option>72"</option>
<option>72 1/8"</option>
<option>72 1/4"</option>
<option>72 3/8"</option>
<option>72 1/2"</option>
<option>72 5/8"</option>
<option>72 3/4"</option>
<option>72 7/8"</option>
<option>73"</option>
<option>73 1/8"</option>
<option>73 1/4"</option>
<option>73 3/8"</option>
<option>73 1/2"</option>
<option>73 5/8"</option>
<option>73 3/4"</option>
<option>73 7/8"</option>
<option>74"</option>
<option>74 1/8"</option>
<option>74 1/4"</option>
<option>74 3/8"</option>
<option>74 1/2"</option>
<option>74 5/8"</option>
<option>74 3/4"</option>
<option>74 7/8"</option>
<option>75"</option>
<option>75 1/8"</option>
<option>75 1/4"</option>
<option>75 3/8"</option>
<option>75 1/2"</option>
<option>75 5/8"</option>
<option>75 3/4"</option>
<option>75 7/8"</option>
<option>76"</option>
<option>76 1/8"</option>
<option>76 1/4"</option>
<option>76 3/8"</option>
<option>76 1/2"</option>
<option>76 5/8"</option>
<option>76 3/4"</option>
<option>76 7/8"</option>
<option>77"</option>
<option>77 1/8"</option>
<option>77 1/4"</option>
<option>77 3/8"</option>
<option>77 1/2"</option>
<option>77 5/8"</option>
<option>77 3/4"</option>
<option>77 7/8"</option>
<option>78"</option>
<option>78 1/8"</option>
<option>78 1/4"</option>
<option>78 3/8"</option>
<option>78 1/2"</option>
<option>78 5/8"</option>
<option>78 3/4"</option>
<option>78 7/8"</option>
<option>79"</option>
<option>79 1/8"</option>
<option>79 1/4"</option>
<option>79 3/8"</option>
<option>79 1/2"</option>
<option>79 5/8"</option>
<option>79 3/4"</option>
<option>79 7/8"</option>
<option>80"</option>
<option>80 1/8"</option>
<option>80 1/4"</option>
<option>80 3/8"</option>
<option>80 1/2"</option>
<option>80 5/8"</option>
<option>80 3/4"</option>
<option>80 7/8"</option>
<option>81"</option>
<option>81 1/8"</option>
<option>81 1/4"</option>
<option>81 3/8"</option>
<option>81 1/2"</option>
<option>81 5/8"</option>
<option>81 3/4"</option>
<option>81 7/8"</option>
<option>82"</option>
<option>82 1/8"</option>
<option>82 1/4"</option>
<option>82 3/8"</option>
<option>82 1/2"</option>
<option>82 5/8"</option>
<option>82 3/4"</option>
<option>82 7/8"</option>
<option>83"</option>
<option>83 1/8"</option>
<option>83 1/4"</option>
<option>83 3/8"</option>
<option>83 1/2"</option>
<option>83 5/8"</option>
<option>83 3/4"</option>
<option>83 7/8"</option>
<option>84"</option>
<option>84 1/8"</option>
<option>84 1/4"</option>
<option>84 3/8"</option>
<option>84 1/2"</option>
<option>84 5/8"</option>
<option>84 3/4"</option>
<option>84 7/8"</option>
<option>85"</option>
<option>85 1/8"</option>
<option>85 1/4"</option>
<option>85 3/8"</option>
<option>85 1/2"</option>
<option>85 5/8"</option>
<option>85 3/4"</option>
<option>85 7/8"</option>
<option>86"</option>
<option>86 1/8"</option>
<option>86 1/4"</option>
<option>86 3/8"</option>
<option>86 1/2"</option>
<option>86 5/8"</option>
<option>86 3/4"</option>
<option>86 7/8"</option>
<option>87"</option>
<option>87 1/8"</option>
<option>87 1/4"</option>
<option>87 3/8"</option>
<option>87 1/2"</option>
<option>87 5/8"</option>
<option>87 3/4"</option>
<option>87 7/8"</option>
<option>88"</option>
<option>88 1/8"</option>
<option>88 1/4"</option>
<option>88 3/8"</option>
<option>88 1/2"</option>
<option>88 5/8"</option>
<option>88 3/4"</option>
<option>88 7/8"</option>
<option>89"</option>
<option>89 1/8"</option>
<option>89 1/4"</option>
<option>89 3/8"</option>
<option>89 1/2"</option>
<option>89 5/8"</option>
<option>89 3/4"</option>
<option>89 7/8"</option>
<option>90"</option>
<option>90 1/8"</option>
<option>90 1/4"</option>
<option>90 3/8"</option>
<option>90 1/2"</option>
<option>90 5/8"</option>
<option>90 3/4"</option>
<option>90 7/8"</option>
<option>91"</option>
<option>91 1/8"</option>
<option>91 1/4"</option>
<option>91 3/8"</option>
<option>91 1/2"</option>
<option>91 5/8"</option>
<option>91 3/4"</option>
<option>91 7/8"</option>
<option>92"</option>
<option>92 1/8"</option>
<option>92 1/4"</option>
<option>92 3/8"</option>
<option>92 1/2"</option>
<option>92 5/8"</option>
<option>92 3/4"</option>
<option>92 7/8"</option>
<option>93"</option>
<option>93 1/8"</option>
<option>93 1/4"</option>
<option>93 3/8"</option>
<option>93 1/2"</option>
<option>93 5/8"</option>
<option>93 3/4"</option>
<option>93 7/8"</option>
<option>94"</option>
<option>94 1/8"</option>
<option>94 1/4"</option>
<option>94 3/8"</option>
<option>94 1/2"</option>
<option>94 5/8"</option>
<option>94 3/4"</option>
<option>94 7/8"</option>
<option>95"</option>
<option>95 1/8"</option>
<option>95 1/4"</option>
<option>95 3/8"</option>
<option>95 1/2"</option>
<option>95 5/8"</option>
<option>95 3/4"</option>
<option>95 7/8"</option>
<option>96"</option>
<option>96 1/8"</option>
<option>96 1/4"</option>
<option>96 3/8"</option>
<option>96 1/2"</option>
<option>96 5/8"</option>
<option>96 3/4"</option>
<option>96 7/8"</option>
<option>97"</option>
<option>97 1/8"</option>
<option>97 1/4"</option>
<option>97 3/8"</option>
<option>97 1/2"</option>
<option>97 5/8"</option>
<option>97 3/4"</option>
<option>97 7/8"</option>
<option>98"</option>
<option>98 1/8"</option>
<option>98 1/4"</option>
<option>98 3/8"</option>
<option>98 1/2"</option>
<option>98 5/8"</option>
<option>98 3/4"</option>
<option>98 7/8"</option>
<option>99"</option>
<option>99 1/8"</option>
<option>99 1/4"</option>
<option>99 3/8"</option>
<option>99 1/2"</option>
<option>99 5/8"</option>
<option>99 3/4"</option>
<option>99 7/8"</option>
<option>100"</option>
<option>100 1/8"</option>
<option>100 1/4"</option>
<option>100 3/8"</option>
<option>100 1/2"</option>
<option>100 5/8"</option>
<option>100 3/4"</option>
<option>100 7/8"</option>
<option>101"</option>
<option>101 1/8"</option>
<option>101 1/4"</option>
<option>101 3/8"</option>
<option>101 1/2"</option>
<option>101 5/8"</option>
<option>101 3/4"</option>
<option>101 7/8"</option>
<option>102"</option>
<option>102 1/8"</option>
<option>102 1/4"</option>
<option>102 3/8"</option>
<option>102 1/2"</option>
<option>102 5/8"</option>
<option>102 3/4"</option>
<option>102 7/8"</option>
<option>103"</option>
<option>103 1/8"</option>
<option>103 1/4"</option>
<option>103 3/8"</option>
<option>103 1/2"</option>
<option>103 5/8"</option>
<option>103 3/4"</option>
<option>103 7/8"</option>
<option>104"</option>
<option>104 1/8"</option>
<option>104 1/4"</option>
<option>104 3/8"</option>
<option>104 1/2"</option>
<option>104 5/8"</option>
<option>104 3/4"</option>
<option>104 7/8"</option>
<option>105"</option>
<option>105 1/8"</option>
<option>105 1/4"</option>
<option>105 3/8"</option>
<option>105 1/2"</option>
<option>105 5/8"</option>
<option>105 3/4"</option>
<option>105 7/8"</option>
<option>106"</option>
<option>106 1/8"</option>
<option>106 1/4"</option>
<option>106 3/8"</option>
<option>106 1/2"</option>
<option>106 5/8"</option>
<option>106 3/4"</option>
<option>106 7/8"</option>
<option>107"</option>
<option>107 1/8"</option>
<option>107 1/4"</option>
<option>107 3/8"</option>
<option>107 1/2"</option>
<option>107 5/8"</option>
<option>107 3/4"</option>
<option>107 7/8"</option>
<option>108"</option>
<option>108 1/8"</option>
<option>108 1/4"</option>
<option>108 3/8"</option>
<option>108 1/2"</option>
<option>108 5/8"</option>
<option>108 3/4"</option>
<option>108 7/8"</option>
<option>109"</option>
<option>109 1/8"</option>
<option>109 1/4"</option>
<option>109 3/8"</option>
<option>109 1/2"</option>
<option>109 5/8"</option>
<option>109 3/4"</option>
<option>109 7/8"</option>
<option>110"</option>
<option>110 1/8"</option>
<option>110 1/4"</option>
<option>110 3/8"</option>
<option>110 1/2"</option>
<option>110 5/8"</option>
<option>110 3/4"</option>
<option>110 7/8"</option>
<option>111"</option>
<option>111 1/8"</option>
<option>111 1/4"</option>
<option>111 3/8"</option>
<option>111 1/2"</option>
<option>111 5/8"</option>
<option>111 3/4"</option>
<option>111 7/8"</option>
<option>112"</option>
<option>112 1/8"</option>
<option>112 1/4"</option>
<option>112 3/8"</option>
<option>112 1/2"</option>
<option>112 5/8"</option>
<option>112 3/4"</option>
<option>112 7/8"</option>
<option>113"</option>
<option>113 1/8"</option>
<option>113 1/4"</option>
<option>113 3/8"</option>
<option>113 1/2"</option>
<option>113 5/8"</option>
<option>113 3/4"</option>
<option>113 7/8"</option>
<option>114"</option>
<option>114 1/8"</option>
<option>114 1/4"</option>
<option>114 3/8"</option>
<option>114 1/2"</option>
<option>114 5/8"</option>
<option>114 3/4"</option>
<option>114 7/8"</option>
<option>115"</option>
<option>115 1/8"</option>
<option>115 1/4"</option>
<option>115 3/8"</option>
<option>115 1/2"</option>
<option>115 5/8"</option>
<option>115 3/4"</option>
<option>115 7/8"</option>
<option>116"</option>
<option>116 1/8"</option>
<option>116 1/4"</option>
<option>116 3/8"</option>
<option>116 1/2"</option>
<option>116 5/8"</option>
<option>116 3/4"</option>
<option>116 7/8"</option>
<option>117"</option>
<option>117 1/8"</option>
<option>117 1/4"</option>
<option>117 3/8"</option>
<option>117 1/2"</option>
<option>117 5/8"</option>
<option>117 3/4"</option>
<option>117 7/8"</option>
<option>118"</option>
<option>118 1/8"</option>
<option>118 1/4"</option>
<option>118 3/8"</option>
<option>118 1/2"</option>
<option>118 5/8"</option>
<option>118 3/4"</option>
<option>118 7/8"</option>
<option>119"</option>
<option>119 1/8"</option>
<option>119 1/4"</option>
<option>119 3/8"</option>
<option>119 1/2"</option>
<option>119 5/8"</option>
<option>119 3/4"</option>
<option>119 7/8"</option>
<option>120"</option>
<option>120 1/8"</option>
<option>120 1/4"</option>
<option>120 3/8"</option>
<option>120 1/2"</option>
<option>120 5/8"</option>
<option>120 3/4"</option>
<option>120 7/8"</option>
<option>121"</option>
<option>121 1/8"</option>
<option>121 1/4"</option>
<option>121 3/8"</option>
<option>121 1/2"</option>
<option>121 5/8"</option>
<option>121 3/4"</option>
<option>121 7/8"</option>
<option>122"</option>
<option>122 1/8"</option>
<option>122 1/4"</option>
<option>122 3/8"</option>
<option>122 1/2"</option>
<option>122 5/8"</option>
<option>122 3/4"</option>
<option>122 7/8"</option>
<option>123"</option>
<option>123 1/8"</option>
<option>123 1/4"</option>
<option>123 3/8"</option>
<option>123 1/2"</option>
<option>123 5/8"</option>
<option>123 3/4"</option>
<option>123 7/8"</option>
<option>124"</option>
<option>124 1/8"</option>
<option>124 1/4"</option>
<option>124 3/8"</option>
<option>124 1/2"</option>
<option>124 5/8"</option>
<option>124 3/4"</option>
<option>124 7/8"</option>
<option>125"</option>
<option>125 1/8"</option>
<option>125 1/4"</option>
<option>125 3/8"</option>
<option>125 1/2"</option>
<option>125 5/8"</option>
<option>125 3/4"</option>
<option>125 7/8"</option>
<option>126"</option>
<option>126 1/8"</option>
<option>126 1/4"</option>
<option>126 3/8"</option>
<option>126 1/2"</option>
<option>126 5/8"</option>
<option>126 3/4"</option>
<option>126 7/8"</option>
<option>127"</option>
<option>127 1/8"</option>
<option>127 1/4"</option>
<option>127 3/8"</option>
<option>127 1/2"</option>
<option>127 5/8"</option>
<option>127 3/4"</option>
<option>127 7/8"</option>
<option>128"</option>
<option>128 1/8"</option>
<option>128 1/4"</option>
<option>128 3/8"</option>
<option>128 1/2"</option>
<option>128 5/8"</option>
<option>128 3/4"</option>
<option>128 7/8"</option>
<option>129"</option>
<option>129 1/8"</option>
<option>129 1/4"</option>
<option>129 3/8"</option>
<option>129 1/2"</option>
<option>129 5/8"</option>
<option>129 3/4"</option>
<option>129 7/8"</option>
<option>130"</option>
<option>130 1/8"</option>
<option>130 1/4"</option>
<option>130 3/8"</option>
<option>130 1/2"</option>
<option>130 5/8"</option>
<option>130 3/4"</option>
<option>130 7/8"</option>
<option>131"</option>
<option>131 1/8"</option>
<option>131 1/4"</option>
<option>131 3/8"</option>
<option>131 1/2"</option>
<option>131 5/8"</option>
<option>131 3/4"</option>
<option>131 7/8"</option>
<option>132"</option>
<option>132 1/8"</option>
<option>132 1/4"</option>
<option>132 3/8"</option>
<option>132 1/2"</option>
<option>132 5/8"</option>
<option>132 3/4"</option>
<option>132 7/8"</option>
<option>133"</option>
<option>133 1/8"</option>
<option>133 1/4"</option>
<option>133 3/8"</option>
<option>133 1/2"</option>
<option>133 5/8"</option>
<option>133 3/4"</option>
<option>133 7/8"</option>
<option>134"</option>
<option>134 1/8"</option>
<option>134 1/4"</option>
<option>134 3/8"</option>
<option>134 1/2"</option>
<option>134 5/8"</option>
<option>134 3/4"</option>
<option>134 7/8"</option>
<option>135"</option>
<option>135 1/8"</option>
<option>135 1/4"</option>
<option>135 3/8"</option>
<option>135 1/2"</option>
<option>135 5/8"</option>
<option>135 3/4"</option>
<option>135 7/8"</option>
<option>136"</option>
<option>136 1/8"</option>
<option>136 1/4"</option>
<option>136 3/8"</option>
<option>136 1/2"</option>
<option>136 5/8"</option>
<option>136 3/4"</option>
<option>136 7/8"</option>
<option>137"</option>
<option>137 1/8"</option>
<option>137 1/4"</option>
<option>137 3/8"</option>
<option>137 1/2"</option>
<option>137 5/8"</option>
<option>137 3/4"</option>
<option>137 7/8"</option>
<option>138"</option>
<option>138 1/8"</option>
<option>138 1/4"</option>
<option>138 3/8"</option>
<option>138 1/2"</option>
<option>138 5/8"</option>
<option>138 3/4"</option>
<option>138 7/8"</option>
<option>139"</option>
<option>139 1/8"</option>
<option>139 1/4"</option>
<option>139 3/8"</option>
<option>139 1/2"</option>
<option>139 5/8"</option>
<option>139 3/4"</option>
<option>139 7/8"</option>
<option>140"</option>
<option>140 1/8"</option>
<option>140 1/4"</option>
<option>140 3/8"</option>
<option>140 1/2"</option>
<option>140 5/8"</option>
<option>140 3/4"</option>
<option>140 7/8"</option>
<option>141"</option>
<option>141 1/8"</option>
<option>141 1/4"</option>
<option>141 3/8"</option>
<option>141 1/2"</option>
<option>141 5/8"</option>
<option>141 3/4"</option>
<option>141 7/8"</option>
<option>142"</option>
<option>142 1/8"</option>
<option>142 1/4"</option>
<option>142 3/8"</option>
<option>142 1/2"</option>
<option>142 5/8"</option>
<option>142 3/4"</option>
<option>142 7/8"</option>
<option>143"</option>
<option>143 1/8"</option>
<option>143 1/4"</option>
<option>143 3/8"</option>
<option>143 1/2"</option>
<option>143 5/8"</option>
<option>143 3/4"</option>
<option>143 7/8"</option>
<option>144"</option>
<option>144 1/8"</option>
<option>144 1/4"</option>
<option>144 3/8"</option>
<option>144 1/2"</option>
<option>144 5/8"</option>
<option>144 3/4"</option>
<option>144 7/8"</option>
<option>145"</option>
<option>145 1/8"</option>
<option>145 1/4"</option>
<option>145 3/8"</option>
<option>145 1/2"</option>
<option>145 5/8"</option>
<option>145 3/4"</option>
<option>145 7/8"</option>
<option>146"</option>
<option>146 1/8"</option>
<option>146 1/4"</option>
<option>146 3/8"</option>
<option>146 1/2"</option>
<option>146 5/8"</option>
<option>146 3/4"</option>
<option>146 7/8"</option>
<option>147"</option>
<option>147 1/8"</option>
<option>147 1/4"</option>
<option>147 3/8"</option>
<option>147 1/2"</option>
<option>147 5/8"</option>
<option>147 3/4"</option>
<option>147 7/8"</option>
<option>148"</option>
<option>148 1/8"</option>
<option>148 1/4"</option>
<option>148 3/8"</option>
<option>148 1/2"</option>
<option>148 5/8"</option>
<option>148 3/4"</option>
<option>148 7/8"</option>
<option>149"</option>
<option>149 1/8"</option>
<option>149 1/4"</option>
<option>149 3/8"</option>
<option>149 1/2"</option>
<option>149 5/8"</option>
<option>149 3/4"</option>
<option>149 7/8"</option>
<option>150"</option>
<option>150 1/8"</option>
<option>150 1/4"</option>
<option>150 3/8"</option>
<option>150 1/2"</option>
<option>150 5/8"</option>
<option>150 3/4"</option>
<option>150 7/8"</option>
<option>151"</option>
<option>151 1/8"</option>
<option>151 1/4"</option>
<option>151 3/8"</option>
<option>151 1/2"</option>
<option>151 5/8"</option>
<option>151 3/4"</option>
<option>151 7/8"</option>
<option>152"</option>
<option>152 1/8"</option>
<option>152 1/4"</option>
<option>152 3/8"</option>
<option>152 1/2"</option>
<option>152 5/8"</option>
<option>152 3/4"</option>
<option>152 7/8"</option>
<option>153"</option>
<option>153 1/8"</option>
<option>153 1/4"</option>
<option>153 3/8"</option>
<option>153 1/2"</option>
<option>153 5/8"</option>
<option>153 3/4"</option>
<option>153 7/8"</option>
<option>154"</option>
<option>154 1/8"</option>
<option>154 1/4"</option>
<option>154 3/8"</option>
<option>154 1/2"</option>
<option>154 5/8"</option>
<option>154 3/4"</option>
<option>154 7/8"</option>
<option>155"</option>
<option>155 1/8"</option>
<option>155 1/4"</option>
<option>155 3/8"</option>
<option>155 1/2"</option>
<option>155 5/8"</option>
<option>155 3/4"</option>
<option>155 7/8"</option>
<option>156"</option>
<option>156 1/8"</option>
<option>156 1/4"</option>
<option>156 3/8"</option>
<option>156 1/2"</option>
<option>156 5/8"</option>
<option>156 3/4"</option>
<option>156 7/8"</option>
<option>157"</option>
<option>157 1/8"</option>
<option>157 1/4"</option>
<option>157 3/8"</option>
<option>157 1/2"</option>
<option>157 5/8"</option>
<option>157 3/4"</option>
<option>157 7/8"</option>
<option>158"</option>
<option>158 1/8"</option>
<option>158 1/4"</option>
<option>158 3/8"</option>
<option>158 1/2"</option>
<option>158 5/8"</option>
<option>158 3/4"</option>
<option>158 7/8"</option>
<option>159"</option>
<option>159 1/8"</option>
<option>159 1/4"</option>
<option>159 3/8"</option>
<option>159 1/2"</option>
<option>159 5/8"</option>
<option>159 3/4"</option>
<option>159 7/8"</option>
<option>160"</option>
<option>160 1/8"</option>
<option>160 1/4"</option>
<option>160 3/8"</option>
<option>160 1/2"</option>
<option>160 5/8"</option>
<option>160 3/4"</option>
<option>160 7/8"</option>
<option>161"</option>
<option>161 1/8"</option>
<option>161 1/4"</option>
<option>161 3/8"</option>
<option>161 1/2"</option>
<option>161 5/8"</option>
<option>161 3/4"</option>
<option>161 7/8"</option>
<option>162"</option>
<option>162 1/8"</option>
<option>162 1/4"</option>
<option>162 3/8"</option>
<option>162 1/2"</option>
<option>162 5/8"</option>
<option>162 3/4"</option>
<option>162 7/8"</option>
<option>163"</option>
<option>163 1/8"</option>
<option>163 1/4"</option>
<option>163 3/8"</option>
<option>163 1/2"</option>
<option>163 5/8"</option>
<option>163 3/4"</option>
<option>163 7/8"</option>
<option>164"</option>
<option>164 1/8"</option>
<option>164 1/4"</option>
<option>164 3/8"</option>
<option>164 1/2"</option>
<option>164 5/8"</option>
<option>164 3/4"</option>
<option>164 7/8"</option>
<option>165"</option>
<option>165 1/8"</option>
<option>165 1/4"</option>
<option>165 3/8"</option>
<option>165 1/2"</option>
<option>165 5/8"</option>
<option>165 3/4"</option>
<option>165 7/8"</option>
<option>166"</option>
<option>166 1/8"</option>
<option>166 1/4"</option>
<option>166 3/8"</option>
<option>166 1/2"</option>
<option>166 5/8"</option>
<option>166 3/4"</option>
<option>166 7/8"</option>
<option>167"</option>
<option>167 1/8"</option>
<option>167 1/4"</option>
<option>167 3/8"</option>
<option>167 1/2"</option>
<option>167 5/8"</option>
<option>167 3/4"</option>
<option>167 7/8"</option>
<option>168"</option>
<option>168 1/8"</option>
<option>168 1/4"</option>
<option>168 3/8"</option>
<option>168 1/2"</option>
<option>168 5/8"</option>
<option>168 3/4"</option>
<option>168 7/8"</option>
<option>169"</option>
<option>169 1/8"</option>
<option>169 1/4"</option>
<option>169 3/8"</option>
<option>169 1/2"</option>
<option>169 5/8"</option>
<option>169 3/4"</option>
<option>169 7/8"</option>
<option>170"</option>
<option>170 1/8"</option>
<option>170 1/4"</option>
<option>170 3/8"</option>
<option>170 1/2"</option>
<option>170 5/8"</option>
<option>170 3/4"</option>
<option>170 7/8"</option>
<option>171"</option>
<option>171 1/8"</option>
<option>171 1/4"</option>
<option>171 3/8"</option>
<option>171 1/2"</option>
<option>171 5/8"</option>
<option>171 3/4"</option>
<option>171 7/8"</option>
<option>172"</option>
<option>172 1/8"</option>
<option>172 1/4"</option>
<option>172 3/8"</option>
<option>172 1/2"</option>
<option>172 5/8"</option>
<option>172 3/4"</option>
<option>172 7/8"</option>
<option>173"</option>
<option>173 1/8"</option>
<option>173 1/4"</option>
<option>173 3/8"</option>
<option>173 1/2"</option>
<option>173 5/8"</option>
<option>173 3/4"</option>
<option>173 7/8"</option>
<option>174"</option>
<option>174 1/8"</option>
<option>174 1/4"</option>
<option>174 3/8"</option>
<option>174 1/2"</option>
<option>174 5/8"</option>
<option>174 3/4"</option>
<option>174 7/8"</option>
<option>175"</option>
<option>175 1/8"</option>
<option>175 1/4"</option>
<option>175 3/8"</option>
<option>175 1/2"</option>
<option>175 5/8"</option>
<option>175 3/4"</option>
<option>175 7/8"</option>
<option>176"</option>
<option>176 1/8"</option>
<option>176 1/4"</option>
<option>176 3/8"</option>
<option>176 1/2"</option>
<option>176 5/8"</option>
<option>176 3/4"</option>
<option>176 7/8"</option>
<option>177"</option>
<option>177 1/8"</option>
<option>177 1/4"</option>
<option>177 3/8"</option>
<option>177 1/2"</option>
<option>177 5/8"</option>
<option>177 3/4"</option>
<option>177 7/8"</option>
<option>178"</option>
<option>178 1/8"</option>
<option>178 1/4"</option>
<option>178 3/8"</option>
<option>178 1/2"</option>
<option>178 5/8"</option>
<option>178 3/4"</option>
<option>178 7/8"</option>
<option>179"</option>
<option>179 1/8"</option>
<option>179 1/4"</option>
<option>179 3/8"</option>
<option>179 1/2"</option>
<option>179 5/8"</option>
<option>179 3/4"</option>
<option>179 7/8"</option>
<option>180"</option>
<option>180 1/8"</option>
<option>180 1/4"</option>
<option>180 3/8"</option>
<option>180 1/2"</option>
<option>180 5/8"</option>
<option>180 3/4"</option>
<option>180 7/8"</option>
<option>181"</option>
<option>181 1/8"</option>
<option>181 1/4"</option>
<option>181 3/8"</option>
<option>181 1/2"</option>
<option>181 5/8"</option>
<option>181 3/4"</option>
<option>181 7/8"</option>
<option>182"</option>
<option>182 1/8"</option>
<option>182 1/4"</option>
<option>182 3/8"</option>
<option>182 1/2"</option>
<option>182 5/8"</option>
<option>182 3/4"</option>
<option>182 7/8"</option>
<option>183"</option>
<option>183 1/8"</option>
<option>183 1/4"</option>
<option>183 3/8"</option>
<option>183 1/2"</option>
<option>183 5/8"</option>
<option>183 3/4"</option>
<option>183 7/8"</option>
<option>184"</option>
<option>184 1/8"</option>
<option>184 1/4"</option>
<option>184 3/8"</option>
<option>184 1/2"</option>
<option>184 5/8"</option>
<option>184 3/4"</option>
<option>184 7/8"</option>
<option>185"</option>
<option>185 1/8"</option>
<option>185 1/4"</option>
<option>185 3/8"</option>
<option>185 1/2"</option>
<option>185 5/8"</option>
<option>185 3/4"</option>
<option>185 7/8"</option>
<option>186"</option>
<option>186 1/8"</option>
<option>186 1/4"</option>
<option>186 3/8"</option>
<option>186 1/2"</option>
<option>186 5/8"</option>
<option>186 3/4"</option>
<option>186 7/8"</option>
<option>187"</option>
<option>187 1/8"</option>
<option>187 1/4"</option>
<option>187 3/8"</option>
<option>187 1/2"</option>
<option>187 5/8"</option>
<option>187 3/4"</option>
<option>187 7/8"</option>
<option>188"</option>
<option>188 1/8"</option>
<option>188 1/4"</option>
<option>188 3/8"</option>
<option>188 1/2"</option>
<option>188 5/8"</option>
<option>188 3/4"</option>
<option>188 7/8"</option>
<option>189"</option>
<option>189 1/8"</option>
<option>189 1/4"</option>
<option>189 3/8"</option>
<option>189 1/2"</option>
<option>189 5/8"</option>
<option>189 3/4"</option>
<option>189 7/8"</option>
<option>190"</option>
<option>190 1/8"</option>
<option>190 1/4"</option>
<option>190 3/8"</option>
<option>190 1/2"</option>
<option>190 5/8"</option>
<option>190 3/4"</option>
<option>190 7/8"</option>
<option>191"</option>
<option>191 1/8"</option>
<option>191 1/4"</option>
<option>191 3/8"</option>
<option>191 1/2"</option>
<option>191 5/8"</option>
<option>191 3/4"</option>
<option>191 7/8"</option>
<option>192"</option>
<option>192 1/8"</option>
<option>192 1/4"</option>
<option>192 3/8"</option>
<option>192 1/2"</option>
<option>192 5/8"</option>
<option>192 3/4"</option>
<option>192 7/8"</option>
<option>193"</option>
<option>193 1/8"</option>
<option>193 1/4"</option>
<option>193 3/8"</option>
<option>193 1/2"</option>
<option>193 5/8"</option>
<option>193 3/4"</option>
<option>193 7/8"</option>
<option>194"</option>
<option>194 1/8"</option>
<option>194 1/4"</option>
<option>194 3/8"</option>
<option>194 1/2"</option>
<option>194 5/8"</option>
<option>194 3/4"</option>
<option>194 7/8"</option>
<option>195"</option>
<option>195 1/8"</option>
<option>195 1/4"</option>
<option>195 3/8"</option>
<option>195 1/2"</option>
<option>195 5/8"</option>
<option>195 3/4"</option>
<option>195 7/8"</option>
<option>196"</option>
<option>196 1/8"</option>
<option>196 1/4"</option>
<option>196 3/8"</option>
<option>196 1/2"</option>
<option>196 5/8"</option>
<option>196 3/4"</option>
<option>196 7/8"</option>
<option>197"</option>
<option>197 1/8"</option>
<option>197 1/4"</option>
<option>197 3/8"</option>
<option>197 1/2"</option>
<option>197 5/8"</option>
<option>197 3/4"</option>
<option>197 7/8"</option>
<option>198"</option>
<option>198 1/8"</option>
<option>198 1/4"</option>
<option>198 3/8"</option>
<option>198 1/2"</option>
<option>198 5/8"</option>
<option>198 3/4"</option>
<option>198 7/8"</option>
<option>199"</option>
<option>199 1/8"</option>
<option>199 1/4"</option>
<option>199 3/8"</option>
<option>199 1/2"</option>
<option>199 5/8"</option>
<option>199 3/4"</option>
<option>199 7/8"</option>
<option>200"</option>
 	</select> 

<label>Color 1:</label>
<select name="inventory_material_color1">
 	<option selected="yes"><?php echo $inventory_material_color1; ?></option>
	<option style="color: black; font-weight: bold;">black</option>
 	<option style="color: gray; font-weight: bold;">gray</option>
 	<option style="color: silver; font-weight: bold;">silver</option>
	<option style="color: steel; font-weight: bold;">steel</option>
 	<option style="color: #DD9475; font-weight: bold;">copper</option>
	<option style="color: gold; font-weight: bold;">gold</option>
 	<option style="color: white; background-color: black; font-weight: bold;">white</option>
	<option style="color: maroon; font-weight: bold;">maroon</option>
 	<option style="color: red; font-weight: bold;">red</option>
 	<option style="color: purple; font-weight: bold;">purple</option>
	<option style="color: fuchsia; font-weight: bold;">fuchsia</option>
 	<option style="color: green; font-weight: bold;">green</option>
	<option style="color: lime; font-weight: bold;">lime</option>
 	<option style="color: olive; font-weight: bold;">olive</option>
 	<option style="color: yellow; font-weight: bold;">yellow</option>
	<option style="color: navy; font-weight: bold;">navy</option>
 	<option style="color: blue; font-weight: bold;">blue</option>
	<option style="color: teal; font-weight: bold;">teal</option>
 	<option style="color: aqua; font-weight: bold;">aqua</option>
 	</select> 

<label>Color 2:</label>
<select name="inventory_material_color2">
 	<option selected="yes"><?php echo $inventory_material_color2; ?></option>
	<option style="color: black; font-weight: bold;">black</option>
 	<option style="color: gray; font-weight: bold;">gray</option>
 	<option style="color: silver; font-weight: bold;">silver</option>
	<option style="color: steel; font-weight: bold;">steel</option>
 	<option style="color: #DD9475; font-weight: bold;">copper</option>
	<option style="color: gold; font-weight: bold;">gold</option>
 	<option style="color: white; background-color: black; font-weight: bold;">white</option>
	<option style="color: maroon; font-weight: bold;">maroon</option>
 	<option style="color: red; font-weight: bold;">red</option>
 	<option style="color: purple; font-weight: bold;">purple</option>
	<option style="color: fuchsia; font-weight: bold;">fuchsia</option>
 	<option style="color: green; font-weight: bold;">green</option>
	<option style="color: lime; font-weight: bold;">lime</option>
 	<option style="color: olive; font-weight: bold;">olive</option>
 	<option style="color: yellow; font-weight: bold;">yellow</option>
	<option style="color: navy; font-weight: bold;">navy</option>
 	<option style="color: blue; font-weight: bold;">blue</option>
	<option style="color: teal; font-weight: bold;">teal</option>
 	<option style="color: aqua; font-weight: bold;">aqua</option>
 	</select> 
<br><br>

<label>Quantity Available:</label><input name="inventory_item_quantity" value="<?php echo $inventory_item_quantity; ?>" size="4"/>
<label>Item Cost:</label><input name="inventory_item_at_cost" value="<?php echo $inventory_item_at_cost; ?>" size="4"/>
<label>Item MSRP Price:</label><input name="inventory_item_at_msrp" value="<?php echo $inventory_item_at_msrp; ?>" size="4"/>
<label>Item Regular Price:</label><input name="inventory_item_reg_price" value="<?php echo $inventory_item_reg_price; ?>" size="4"/>
<label>Item Sale Price:</label><input name="inventory_item_on_sale" value="<?php echo $inventory_item_on_sale; ?>" size="4"/>

<br><br>

<label>Description:</label><input name="inventory_item_desc" value="<?php echo $inventory_item_desc; ?>" size="60"/><br>



</div>
</table>
<?php  
}  
    
function add_inventory_metadata(){  
        add_meta_box('inventory_metadata', __('Inventory Item Details', 'cp_inventory_metadata'), 'inventory_metadata', 'inventory', 'normal', 'low');  
} 
    
add_action('admin_init', 'add_inventory_metadata'); 

/*====================== Saves all Custom Field Data ======================*/    
function save_meta_inventory($post_id){  
		if (!wp_verify_nonce(@$_POST['inv-nonce'], 'in-v')) return $post_id;
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;
	update_post_meta($post_id, "inventory_brandname", $_POST["inventory_brandname"]);
	update_post_meta($post_id, "inventory_item_upc", $_POST["inventory_item_upc"]);
	update_post_meta($post_id, "inventory_item_desc", $_POST["inventory_item_desc"]);
	update_post_meta($post_id, "inventory_materialtype", $_POST["inventory_materialtype"]);
	update_post_meta($post_id, "inventory_producttype", $_POST["inventory_producttype"]);
	update_post_meta($post_id, "inventory_item_part_grp", $_POST["inventory_item_part_grp"]);
	update_post_meta($post_id, "inventory_item_style", $_POST["inventory_item_style"]);
	update_post_meta($post_id, "inventory_item_quantity", $_POST["inventory_item_quantity"]);
	update_post_meta($post_id, "inventory_material_size1", $_POST["inventory_material_size1"]);
	update_post_meta($post_id, "inventory_material_size2", $_POST["inventory_material_size2"]);
	update_post_meta($post_id, "inventory_material_size3", $_POST["inventory_material_size3"]);
	update_post_meta($post_id, "inventory_material_color1", $_POST["inventory_material_color1"]);
	update_post_meta($post_id, "inventory_material_color2", $_POST["inventory_material_color2"]);
	update_post_meta($post_id, "inventory_item_at_cost", $_POST["inventory_item_at_cost"]);
	update_post_meta($post_id, "inventory_item_at_msrp", $_POST["inventory_item_at_msrp"]);
	update_post_meta($post_id, "inventory_item_reg_price", $_POST["inventory_item_reg_price"]);
	update_post_meta($post_id, "inventory_item_on_sale", $_POST["inventory_item_on_sale"]);
	


			      
}  
add_action('save_post', 'save_meta_inventory'); 

// Creating the column layout when viewing list of Inventorys in the backend
add_action("manage_posts_custom_column",  "inventory_custom_columns");
add_filter("manage_edit-inventory_columns", "inventory_edit_columns");
 
function inventory_edit_columns($columns){
	$columns = array(
	"cb" => "<input type=\"checkbox\" />",
	'title' => __('UPC', 'trans' ),
	"inventory_brandname" => __( 'Brand', 'trans' ),
	"inventory_producttype" => __( 'Type', 'trans' ),
	"inventory_item_part_grp" => __( 'Group', 'trans' ),
	"inventory_materialtype" => __( 'Material', 'trans' ),
	"inventory_material_color1" => __( 'Color 1', 'trans' ),
	"inventory_material_color2" => __( 'Color 2', 'trans' ),    
	"inventory_material_size1" => __( 'Size 1', 'trans' ),
	"inventory_material_size2" => __( 'Size 2', 'trans' ),
	"inventory_material_size3" => __( 'Size 3', 'trans' ),
	"inventory_item_at_cost" => __( 'Cost', 'trans' ),
	"inventory_item_at_msrp" => __( 'MSRP', 'trans' ),
	"inventory_item_reg_price" => __( 'Regular', 'trans' ),
	"inventory_item_on_sale" => __( 'Sale', 'trans' ),
	"inventory_item_quantity" => __( 'Available', 'trans' ),



  );
 
  return $columns;
}

function inventory_custom_columns($column)
{
	global $post;
	@$custom = get_post_custom($post->ID);
	@$inventory_item_at_cost = $custom["inventory_item_at_cost"][0];	       	
	@$inventory_item_upc = $custom["inventory_item_upc"][0];	       	
	@$inventory_item_at_msrp = $custom["inventory_item_at_msrp"][0];	       	
	@$inventory_item_reg_price = $custom["inventory_item_reg_price"][0];	       	
	@$inventory_item_on_sale = $custom["inventory_item_on_sale"][0];	       	
	@$inventory_item_desc = $custom["inventory_item_desc"][0];	       	
	@$inventory_item_part_grp = $custom["inventory_item_part_grp"][0];
	@$inventory_item_style = $custom["inventory_item_style"][0];
       	@$inventory_item_quantity = $custom["inventory_item_quantity"][0];
	@$inventory_material_color1 = $custom["inventory_material_color1"][0];
	@$inventory_material_color2 = $custom["inventory_material_color2"][0];	
	@$inventory_material_size1 = $custom["inventory_material_size1"][0];
	@$inventory_material_size2 = $custom["inventory_material_size2"][0];
	@$inventory_material_size3 = $custom["inventory_material_size3"][0];
	@$inventory_materialtype = $custom["inventory_materialtype"][0];
	@$inventory_producttype = $custom["inventory_producttype"][0];
	@$inventory_brandname = $custom["inventory_brandname"][0]; 
        @$inventory_producttype = $custom["inventory_producttype"][0];


if ('ID' == $column) echo $post->ID; //displays title
elseif ('inventory_brandname' == $column) if (@$inventory_brandname != ""){ echo @$inventory_brandname; } else { echo 'N/A'; }
elseif ('inventory_producttype' == $column) if (@$inventory_producttype != ""){ echo @$inventory_producttype; } else { echo 'N/A'; }
elseif ('inventory_item_part_grp' == $column) if (@$inventory_item_part_grp != ""){ echo @$inventory_item_part_grp; } else { echo 'N/A'; }			
elseif ('inventory_materialtype' == $column) if (@$inventory_materialtype != ""){ echo @$inventory_materialtype; } else { echo 'N/A'; }
elseif ('inventory_material_color1' == $column) if (@$inventory_material_color1 != ""){ echo @$inventory_material_color1; } else { echo 'N/A'; }
elseif ('inventory_material_color2' == $column) if (@$inventory_material_color2 != ""){ echo @$inventory_material_color2; } else { echo 'N/A'; }
elseif ('inventory_material_size1' == $column) if (@$inventory_material_size1 != ""){ echo @$inventory_material_size1; } else { echo 'N/A'; }
elseif ('inventory_material_size2' == $column) if (@$inventory_material_size2 != ""){ echo @$inventory_material_size2; } else { echo 'N/A'; }
elseif ('inventory_material_size3' == $column) if (@$inventory_material_size3 != ""){ echo @$inventory_material_size3; } else { echo 'N/A'; } 
elseif ('inventory_item_at_cost' == $column) if (@$inventory_item_at_cost != ""){ echo '$'.@$inventory_item_at_cost;  } else { echo 'N/A'; }
elseif ('inventory_item_at_msrp' == $column) if (@$inventory_item_at_msrp != ""){ echo '$'.@$inventory_item_at_msrp; } else { echo 'N/A'; }
elseif ('inventory_item_reg_price' == $column) if (@$inventory_item_reg_price != ""){ echo '$'.@$inventory_item_reg_price; } else { echo 'N/A'; }
elseif ('inventory_item_on_sale' == $column) if (@$inventory_item_on_sale != ""){ echo '$'.@$inventory_item_on_sale; } else { echo 'N/A'; } 
elseif ('inventory_item_quantity' == $column) if (@$inventory_item_quantity != ""){ echo @$inventory_item_quantity; } else { echo 'N/A'; } 
	
	}

function sortable_columns() {
return array(
	'inventory_brandname'      => 'inventory_brandname',
	'inventory_producttype' => 'inventory_producttype',
	'inventory_item_part_grp' => 'inventory_item_part_grp',
	'inventory_materialtype' => 'inventory_materialtype',
	'inventory_material_color1' => 'inventory_material_color1',
	'inventory_material_color2' => 'inventory_material_color2',
	'inventory_material_size1' => 'inventory_material_size1',
	'inventory_material_size2' => 'inventory_material_size2',	
	'inventory_material_size3' => 'inventory_material_size3',
	'inventory_item_at_cost' => 'inventory_item_at_cost',
	'inventory_item_at_msrp' => 'inventory_item_at_msrp',
	'inventory_item_reg_price' => 'inventory_item_reg_price',
	'inventory_item_on_sale' => 'inventory_item_on_sale',
	'inventory_item_quantity' => 'inventory_item_quantity',
   );
}

add_filter( "manage_edit-inventory_sortable_columns", "sortable_columns" );

/*===================== Create Post Titles Using Meta Data=================*/
   

function create_inventory_doc_title_meta($inventory_meta_title){
     global $post;
    	
	if ($post->post_type == 'inventory') {
         $meta_data_title = $_POST['inventory_item_upc'];
     }
     return $inventory_meta_title;
}
add_filter('title_save_pre','create_inventory_doc_title_meta');


require_once('material_type.php');
require_once('product_type.php');
require_once('brand_type.php');
