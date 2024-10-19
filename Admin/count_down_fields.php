<?php

add_action('woocommerce_product_options_general_product_data', 'add_lottery_timer_field_to_general_tab');


function add_lottery_timer_field_to_general_tab() {

	$product_id = get_the_ID();
	$product = wc_get_product(get_the_ID());
	$product_type = $product->get_type();
	$from_date = get_post_meta($product_id, 'from_date', true);
	$to_date = get_post_meta($product_id, 'to_date', true);
	
	if( 'simple' == $product_type) {
		?>
		<div class="options_group" style="margin-left: 15px;">

			
			<table style="padding: 5px 20px 5px 145px!important; width: 100%;" >
			
				<tr>
					<td> <label>Lottery From Date</label></td>
					<td><input type="datetime-local" name="from_date"  value="<?php echo $from_date;?>" style="width: 50%;" ></td>
				</tr>
				<tr>

					<td><label>Lottery To Date</label></td>
					<td><input type="datetime-local" name="to_date"  value="<?php echo $to_date;?>" style="width: 50%;"></td>
				</tr>
				
			</table>

		</div>
		<?php

	}
}


function save_lottery_timer_field_value($post_id) {
	$from_date = isset($_POST['from_date']) ? sanitize_text_field($_POST['from_date']) : '';
	$to_date = isset($_POST['to_date']) ? sanitize_text_field($_POST['to_date']) : '';
	
	update_post_meta($post_id, 'from_date', $from_date);
	update_post_meta($post_id, 'to_date', $to_date);
	
}
add_action('woocommerce_process_product_meta', 'save_lottery_timer_field_value', 10, 1);











function add_lottery_timer_field_to_variation_options($loop, $variation_data, $variation) {
	$variation_id = $variation->ID;
	$from_date = get_post_meta($variation_id, 'from_date', true);
	$to_date = get_post_meta($variation_id, 'to_date', true);
	?>
	<div class="options_group">

		
		<table>
			<tr>
				<td> <label>Lottery From Date</label></td>
				<td><input type="datetime-local"   name="from_date<?php echo $loop; ?>" value="<?php echo $from_date;?>" style="width: 50%;"></td>
			</tr>
			<tr>

				<td><label>Lottery To Date</label></td>
				<td><input type="datetime-local" name="to_date<?php echo $loop; ?>" value="<?php echo $to_date;?>" style="width: 50%;"></td>
			</tr>
			
		</table>

	</div>
	<hr>
	<?php
}

add_action('woocommerce_variation_options', 'add_lottery_timer_field_to_variation_options', 10, 3);

function save_custom_variation_lotrey_time_field_value($variation_id, $loop) {


	$from_date = isset($_POST['from_date' . $loop]) ? sanitize_text_field($_POST['from_date'. $loop]) : '';	
	$to_date = isset($_POST['to_date' . $loop]) ? sanitize_text_field($_POST['to_date'. $loop]) : '';
	
	update_post_meta($variation_id, 'from_date', $from_date);
	update_post_meta($variation_id, 'to_date', $to_date);
	
}
add_action('woocommerce_save_product_variation', 'save_custom_variation_lotrey_time_field_value', 10, 2);

