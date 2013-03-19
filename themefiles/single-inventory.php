<?php
/**
* 
* inventoryPress
* Frontend Individual Inventory Template. Lots of stuff below.
* 
* Last Update: Version 1.7.1
* 
**/
?>
<!---GET CURRENT THEME HEADER FILE-->
<?php
get_header();
?>
<!---BEGIN STYLE--->
<style type="text/css">
.inventory_item_wrapper {
    border: 1px dashed #000000;
    border-radius: 5px 5px 5px 5px;
    margin-top: 5px;
    padding: 5px;
	}
.inventory_table {
    table-layout: fixed;
    width: 100%;
	}
.inventory_table th {
    background-color: #4D90FE;
    border-right: 1px solid #FFFFFF;
    color: #FFFFFF;
    text-align: center;
	}
.inventory_table td {
    background-color: #FFFFFF;
    color: #000000;
	padding: 5px;
	text-align: center;
	}
.inventory_table td button {
    max-width:100%;
	}
</style>
<!---SETUP VARS FOR INVENTORY ITEMS-->
<?php
    global $post;
	@$custom = get_post_custom($post->ID);
	@$inventory_producttype = $custom["inventory_producttype"][0]; 	
	@$inventory_item_part_grp = $custom["inventory_item_part_grp"][0];
	@$inventory_item_upc = $custom["inventory_item_upc"][0];	      
	@$inventory_brandname = $custom["inventory_brandname"][0]; 
	@$inventory_materialtype = $custom["inventory_materialtype"][0];
	@$inventory_item_style = $custom["inventory_item_style"][0];
	@$inventory_material_color1 = $custom["inventory_material_color1"][0];
	@$inventory_material_color2 = $custom["inventory_material_color2"][0];	
	@$inventory_material_size1 = $custom["inventory_material_size1"][0];
	@$inventory_material_size2 = $custom["inventory_material_size2"][0];
	@$inventory_material_size3 = $custom["inventory_material_size3"][0];
	@$inventory_item_desc = $custom["inventory_item_desc"][0];	       	
    @$inventory_item_quantity = $custom["inventory_item_quantity"][0];
	@$inventory_item_at_cost = $custom["inventory_item_at_cost"][0];	       	
	@$inventory_item_at_msrp = $custom["inventory_item_at_msrp"][0];	       	
	@$inventory_item_reg_price = $custom["inventory_item_reg_price"][0];	       	
	@$inventory_item_on_sale = $custom["inventory_item_on_sale"][0];	       	
?>
<!---BEGIN INVENTORY TABLES-->
<div class = "inventory_item_wrapper">
<div class="inventory_table_content">
<table class="inventory_table" id="table1">
	<tr>
<!---TABLE 1 ROW 1-->
		<th><b>Product Type</b></th>
		<th><b>Part#</b></th>
		<th><b>UPC</b></th>
		<th><b>Brand</b></th>
		<th><b>Material</b></th>
		<th><b>Style</b></th>
</tr>
<!---TABLE 1 ROW 2-->
	<tr>
		<td><?php if (@$inventory_producttype != ""){ echo @$inventory_producttype; } else { echo 'N/A'; } ?></td>
		<td><?php if (@$inventory_item_part_grp != ""){ echo @$inventory_item_part_grp; } else { echo 'N/A'; } ?></td>
		<td><?php if (@$inventory_item_upc != ""){ echo @$inventory_item_upc; } else { echo 'N/A'; } ?></td>
		<td><?php if (@$inventory_brandname != ""){ echo @$inventory_brandname; } else { echo 'N/A'; } ?></td>
		<td><?php if (@$inventory_materialtype != ""){ echo @$inventory_materialtype; } else { echo 'N/A'; } ?></td>
		<td><?php if (@$inventory_item_style != ""){ echo @$inventory_item_style; } else { echo 'N/A'; } ?></td>
	</tr>
</table>
<table class="inventory_table" id="table2">
<!---TABLE 2 ROW 1-->
	<tr>
		<th><b>Color 1</b></th>
		<th><b>Color 2</b></th>
		<th><b>Size 1</b></th>
		<th><b>Size 2</b></th>
		<th><b>Size 3</b></th>
	</tr>
	<tr>
		<td><?php if (@$inventory_material_color1 != ""){ echo @$inventory_material_color1; } else { echo 'N/A'; } ?></td>
		<td><?php if (@$inventory_material_color2 != ""){ echo @$inventory_material_color2; } else { echo 'N/A'; } ?></td>
		<td><?php if (@$inventory_material_size1 != ""){ echo @$inventory_material_size1; } else { echo 'N/A'; } ?></td>
		<td><?php if (@$inventory_material_size2 != ""){ echo @$inventory_material_size2; } else { echo 'N/A'; } ?></td>
		<td><?php if (@$inventory_material_size3 != ""){ echo @$inventory_material_size3; } else { echo 'N/A'; } ?></td>
	</tr>
</table>
<table class="inventory_table" id="table3">
<!---TABLE 3 ROW 1-->
	<tr>
		<th><b>Stock</b></th>
		<th><b>Cost</b></th>
		<th><b>MSRP</b></th>
		<th><b>Regular</b></th>
		<th><b>Sale</b></th>
	</tr>
<!---TABLE 3 ROW 2-->
	<tr>
		<td><?php if (@$inventory_item_quantity != ""){ echo @$inventory_item_quantity; } else { echo 'N/A'; } ?></td>
		<td><?php if (@$inventory_item_at_cost != ""){ echo @$inventory_item_at_cost; } else { echo 'N/A'; } ?></td>
		<td><?php if (@$inventory_item_at_msrp != ""){ echo @$inventory_item_at_msrp; } else { echo 'N/A'; } ?></td>
		<td><?php if (@$inventory_item_reg_price != ""){ echo @$inventory_item_reg_price; } else { echo 'N/A'; } ?></td>
		<td><?php if (@$inventory_item_on_sale != ""){ echo @$inventory_item_on_sale; } else { echo 'N/A'; } ?></td>
	</tr>
</table>	
<table class="inventory_table" id="table4">	
<!---TABLE 4 ROW 1-->
	<tr>
		<th><b>Description</b></th>
	</tr>
<!---TABLE 4 ROW 2-->
	<tr>
		<td><?php if (@$inventory_item_desc != ""){ echo @$inventory_item_desc; } else { echo 'N/A'; } ?></td>
	</tr>
</table>
<!---END OF TABLE-->
</div>
</div>   
<!---END OF INVENTORY TEMPLATE-->
<!---GET CURRENT THEME FOOTER-->
<?php get_footer(); ?>