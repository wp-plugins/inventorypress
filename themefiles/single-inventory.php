<?php
/**
* 
* Cashpress v3.0
* Inventory Template. Lots of stuff below.
* 
* Last Update: Version 3.0
* 
**/

/*============== First Custom Field Section ========================*/
	global $post; 
        @$custom = get_post_custom($post->ID);
	@$inventory_item_at_cost = $custom["inventory_item_at_cost"][0];	       	
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
	@$inventory_materialtype = $custom["inventory_materialtype"][0];
	@$inventory_producttype = $custom["inventory_producttype"][0];
	@$materialtype = get_posts('post_type=materials&numberposts=-1');
	@$inventory_brandname = $custom["inventory_brandname"][0]; 
        @$brandname = get_posts('post_type=brands&numberposts=-1');
        @$inventory_producttype = $custom["inventory_producttype"][0];
	@$producttype = get_posts('post_type=products&numberposts=-1');
	
        echo '<input type="hidden" name="inv-nonce" id="inv-nonce" value="' .wp_create_nonce('in-v'). '" />';
?>  

<?php get_header(); ?>
<?php echo $inventory_producttype ?> | <?php echo $inventory_brandname ?> | <?php echo $inventory_materialtype ?><br><br>

<?php echo $inventory_item_desc ?><br><br>
<?php if (@$inventory_item_at_msrp != ""){ echo "MSRP " . @$inventory_item_at_msrp; } else { echo 'MSRP N/A'; } ?><br>
<?php if (@$inventory_item_reg_price != ""){ echo "Regular Price " . @$inventory_item_reg_price; } else { echo 'Regular Price N/A'; } ?><br>
<?php if (@$inventory_item_on_sale != ""){ echo "Sale Price " . @$inventory_item_on_sale; } else { echo ''; } ?><br><br>
<?php if (@$inventory_item_quantity != ""){ echo "Quantity Available " . @$inventory_item_quantity; } else { echo 'Quantity Available N/A'; } ?><br>


<?php get_footer(); ?>
