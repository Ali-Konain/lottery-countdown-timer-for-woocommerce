<?php
add_action('woocommerce_before_add_to_cart_form', 'add_progress_bar');
function add_progress_bar(){

	
	?>
	<div class="main_div" style="display:inline-flex; width: 90%;">
		<button class="quantity-btn" data-action="decrement" style="width:8%; border-radius: 50%;">-</button>
		<div class="svbp_progress" style="border-radius:12px; margin:2%; background-color:white;border: 1px solid green; height: 9px;width:80%;">

			<div class="svbp_progress-bar"  style="width:90%;border-radius:12px; background-color:green;height: 9px; " aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" >

			</div>

		</div>
		<button class="quantity-btn" data-action="increment"  style="width:8%;border-radius: 50%;">+</button>
	</div>
	<?php
}





function get_order_count_by_day($product_id) {
	$total_sold_count_per_day = 0;

    // Get all completed orders
	$completed_orders = wc_get_orders(array('status' => 'completed'));

    // Loop through each completed order
	foreach ($completed_orders as $order) {
        // Check if the order contains the specified product
		foreach ($order->get_items() as $item) {
			if ($item->get_product_id() == $product_id) {
                // Increment the total count for the product
				$total_sold_count_per_day += $item->get_quantity();
                break; // Break the inner loop since we found the product in this order
            }
        }
    }

    return $total_sold_count_per_day;
}




add_action( 'woocommerce_after_shop_loop_item', 'add_timer_n_progress_bar_on_shop', 10 );
function add_timer_n_progress_bar_on_shop() {
	if(is_shop()) {
		$product_id = get_the_ID(); 
		$producttt = wc_get_product($product_id);
		$total_sold_count_per_day = get_order_count_by_day($product_id);

		$stock_quantity = $producttt->get_stock_quantity();
		$progress_bar_width = 0;
		if ('' != $stock_quantity ) {
			$progress_bar_width=$total_sold_count_per_day*100;
			$progress_bar_width=$progress_bar_width/$stock_quantity;
		}else {
			$stock_quantity = '&infin;';
		}

		?>
		<div class="main_div" style="display:inline-flex; width: 90%;">

			<div class="svbp_progress" style="border-radius:2px; margin:2%; background-color:white;border: 1px solid green; height: 20px;width:80%;">
				<span style="width: 90%; text-align: center;" ><?php echo $total_sold_count_per_day . '/' . $stock_quantity ?></span>
				
				<div class="svbp_progress-bar"  style="width:<?php echo $progress_bar_width; ?>%;border-radius:1px; margin-top: -10%;background-color:green;height: 20px; " aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" >


				</div>

			</div>

		</div>

		<?php
		$product_id = get_the_ID();
		$product = wc_get_product(get_the_ID());
		$product_type = $product->get_type();
		$from_date = get_post_meta($product_id, 'from_date', true);
		$to_date = get_post_meta($product_id, 'to_date', true);
		if($product->get_type() == 'simple') {
			if($from_date != '' && $to_date != '' ) {
				?>
				<style>
					.container {
						text-align: center;
						margin-top: 20px;
					}

					.countdown {

						border-radius: 8px;
						display: inline-block;
					}

					#add_style {
						list-style: none;
						padding: 0;
						display: flex;
						justify-content: space-around;
						margin: unset;
					}

					#add_style li {
						margin: 10px 0;
						font-size: 16px;
						text-align: center;
						width: 22%;
						background-color: red;
						color:white;
						border-radius: 10px;
					}

					#add_style span {
						display: block;
						font-weight: bold;
						font-size: 24px;
					}
				</style>

				<div class="container countdown-container" data-from-date="<?php echo esc_attr($from_date); ?>" data-to-date="<?php echo esc_attr($to_date); ?>">
					<div class="countdown">
						<ul id="add_style">
							<li><span id="days"></span>Days</li>
							<li><span id="hours"></span>Hours</li>
							<li><span id="minutes"></span>Minutes</li>
							<li><span id="seconds"></span>Seconds</li>
						</ul>
					</div>
				</div>


				<script type="text/javascript">
					jQuery(document).ready(function (){

						const second = 1000,
						minute = second * 60,
						hour = minute * 60,
						day = hour * 24;

						let fromDate = new Date('<?php echo $from_date; ?>').getTime();
						let toDate = new Date('<?php echo $to_date; ?>').getTime();

						const x = setInterval(function () {
							const now = new Date().getTime();

							if (now < fromDate) {

								updateCountdown(fromDate - now);
							} else if (now <= toDate) {

								updateCountdown(toDate - now);
							} else {
								clearInterval(x);
							}
						}, 1000);

						function updateCountdown(distance) {

							jQuery('body').find(".countdown").each(function(){

								let fromDate = new Date(jQuery(this).parent().attr('data-from-date')).getTime();
								let toDate = new Date(jQuery(this).parent().attr('data-to-date')).getTime();
								const now = new Date().getTime();
								var distance = '';
								if (now < fromDate) {
									distance = (fromDate - now);
								} else if (now <= toDate) {

									distance = (toDate - now);
								}else {
									
								}
								
								if(distance != '') {
									jQuery(this).css("display", "block");
									jQuery(this).find("#days").text(Math.floor(distance / day));
									jQuery(this).find("#hours").text(Math.floor((distance % day) / hour));
									jQuery(this).find("#minutes").text(Math.floor((distance % hour) / minute));
									jQuery(this).find("#seconds").text(Math.floor((distance % minute) / second));
								}
								

								if(distance == '') {
									jQuery(this).css('display','none');
								} 
							})

						}

					});
				</script>

				<?php

			}
		}
	}

}




















add_action('woocommerce_after_add_to_cart_form', 'display_timer');
function display_timer(){
	$product_id = get_the_ID();
	$product = wc_get_product(get_the_ID());
	$product_type = $product->get_type();
	$from_date = get_post_meta($product_id, 'from_date', true);
	$to_date = get_post_meta($product_id, 'to_date', true);
	if($product->get_type() == 'variable') {
		$variation_ids = $product->get_children();
		$varibale_hide = 'display:none;';

		foreach ($variation_ids as $key => $variation_id) {

			$from_date = get_post_meta($variation_id, 'from_date', true);
			$to_date = get_post_meta($variation_id, 'to_date', true);

			if($from_date != '' && $to_date != '' ) {
				?>
				<div class="container main_div_two_for_variable hide_for_variable" id="hide_for_variable<?php echo $variation_id;?>" style="<?php echo $varibale_hide; ?>">
					<!-- <h1 id="headline"></h1> -->

					<input type="hidden" name="" value="<?php echo $from_date;?>" id="from_timer<?php echo $variation_id;?>" >
					<input type="hidden" name="" value="<?php echo $to_date;?>" id="to_timer<?php echo $variation_id;?>" >

					<div id="countdown">
						<ul id="add_style" >
							<li><span id="<?php echo $variation_id;?>days"></span>Days</li>
							<li><span id="<?php echo $variation_id;?>hours"></span>Hours</li>
							<li><span id="<?php echo $variation_id;?>minutes"></span>Minutes</li>
							<li><span id="<?php echo $variation_id;?>seconds"></span>Seconds</li>
						</ul>
					</div>

				</div>
				<?php	
			}

		}
		?>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery( ".variations_form" ).on( "woocommerce_variation_select_change", function () {
					jQuery('.hide_for_variable').hide();
				});
				jQuery( ".single_variation_wrap" ).on( "show_variation", function ( event, variation ) {
					jQuery('.hide_for_variable').hide();

					jQuery('#hide_for_variable'+variation.variation_id).show();	
					startCountdown(variation.variation_id);

				// if (jQuery(window).width() < 600) {
				// 	jQuery('#hide_for_variable'+variation.variation_id).css('display', 'block');	
				// } else {
				// 	jQuery('#hide_for_variable'+variation.variation_id).css('display', 'flex');
				// }
				});
				const second = 1000,
				minute = second * 60,
				hour = minute * 60,
				day = hour * 24;
				function startCountdown(variation_id) {

					var from_Date = document.getElementById('from_timer' + variation_id).value;
					var to_Date = document.getElementById('to_timer' + variation_id).value;
					let fromDate = new Date(from_Date).getTime();
					let toDate = new Date(to_Date).getTime();
					console.log(from_Date);
					console.log(to_Date);
					console.log(fromDate);
					console.log(toDate);

					const x = setInterval(function () {
						const now = new Date().getTime();

						if (now < fromDate) {
							updateCountdown(fromDate - now, variation_id);
						} else if (now <= toDate) {
							updateCountdown(toDate - now, variation_id);
						} else {
							clearInterval(x);
						}
					}, 1000);
				}

				function updateCountdown(distance, variation_id) {
    // Update the countdown for the specified variation
					jQuery('#' + variation_id + 'days').text(Math.floor(distance / day));
					jQuery('#' + variation_id + 'hours').text(Math.floor((distance % day) / hour));
					jQuery('#' + variation_id + 'minutes').text(Math.floor((distance % hour) / minute));
					jQuery('#' + variation_id + 'seconds').text(Math.floor((distance % minute) / second));
					if(distance == '') {
						jQuery('#hide_for_variable'+ variation_id).hide();
					}
				}

			});
		</script>
		<?php

	}else {
		$product_id = get_the_ID();
		$from_date = get_post_meta($product_id, 'from_date', true);
		$to_date = get_post_meta($product_id, 'to_date', true);
		if($from_date != '' && $to_date != '' ) {
			?>
			<div class="container">
				<!-- <h1 id="headline"></h1> -->
				<div id="countdown">
					<ul id="add_style" >
						<li><span id="days"></span>Days</li>
						<li><span id="hours"></span>Hours</li>
						<li><span id="minutes"></span>Minutes</li>
						<li><span id="seconds"></span>Seconds</li>
					</ul>
				</div>

			</div>

			<script type="text/javascript">
				(function () {
					const second = 1000,
					minute = second * 60,
					hour = minute * 60,
					day = hour * 24;

					let fromDate = new Date('<?php echo $from_date; ?>').getTime();
					let toDate = new Date('<?php echo $to_date; ?>').getTime();

					const x = setInterval(function () {
						const now = new Date().getTime();

						if (now < fromDate) {

							updateCountdown(fromDate - now);
						} else if (now <= toDate) {

							updateCountdown(toDate - now);
						} else {

							clearInterval(x);
						}
					}, 1000);

					function updateCountdown(distance) {
            // document.getElementById("headline").innerText = "Countdown in progress";
						document.getElementById("countdown").style.display = "block";
						document.getElementById("days").innerText = Math.floor(distance / day);
						document.getElementById("hours").innerText = Math.floor((distance % day) / hour);
						document.getElementById("minutes").innerText = Math.floor((distance % hour) / minute);
						document.getElementById("seconds").innerText = Math.floor((distance % minute) / second);
						if(distance == '') {
							jQuery('#countdown').hide();
						}
					}
				})();
			</script>

			<?php
		}
	}

}


























add_action('wp_footer', 'add_script_and_style');
function add_script_and_style() {
	if ( is_shop()) {

		?>
		<style type="text/css">

			#add_style {
				margin: unset;
				width: 78%;
			}
			#add_style li{
				padding: 2px;
				padding-top: 8px;
			}
			.container {
				color: #333;
				margin: 0 auto;
				text-align: center;
			}


			#countdown li {
				display: inline-block;

				list-style-type: none;

				width: 20%;
				background: red;
				color: white;
				font-weight: 600;
				border-radius: 7%;
				margin-left:11%;
				
			}

			#countdown li span {
				display: block;
				font-size: 35px;
				color: white;
			}


			@media all and (max-width: 500px) {
				h1 {
					font-size: calc(1.5rem * var(--smaller));
				}

				#countdown li {
					font-size: calc(1.125rem * var(--smaller));
				}

				#countdown li span {
					font-size: calc(3.375rem * var(--smaller));
				}
			}
			@media all and (max-width: 300px) {
				body {
					word-wrap: normal !important;
				}
			}
		</style> 
		<?php



	}
	if(is_product()){
		?>
		<style type="text/css">

			#add_style {
				margin: unset;
				width: 85%;
			}
			.container {
				color: #333;
				margin: 0 auto;
				text-align: center;
				margin-top: 10%;
			}
			#countdown li {
				display: inline-block;

				list-style-type: none;

				width: 20%;
				background: red;
				color: white;
				font-weight: 600;
				border-radius: 7%;
				padding: 3px;
				padding-top: 20px;
			}
			#countdown li span {
				display: block;
				font-size: 35px;
				color: white;
			}

		</style>
		<?php
	}

	?>

	<script type="text/javascript">
		jQuery(document).ready(function() {
			
			updateProgressBar();
			// jQuery('.qty').attr('max', '100')
			jQuery('.qty').on('input', function () {
				updateProgressBar();
			});
			function updateProgressBar() {
				var quantity = jQuery('.qty').val();
				var maxQuantity = 100; 

				var percentage = (quantity / maxQuantity) * 100;

				jQuery('.svbp_progress-bar').css('width', percentage + '%');
			}

			jQuery('.quantity-btn[data-action="increment"]').on('mousedown', function () {
				continuousIncrement();
			}).on('mouseup mouseleave', function () {
				stopContinuous();
			});

			jQuery('.quantity-btn[data-action="decrement"]').on('mousedown', function () {
				continuousDecrement();
			}).on('mouseup mouseleave', function () {
				stopContinuous();
			});

			var continuousInterval;
			var continuousAction;

			function continuousIncrement() {
				continuousAction = 'increment';
				continuousInterval = setInterval(function () {
					var quantity = parseInt(jQuery('.qty').val());
					quantity++;
					
					if(jQuery('.qty').attr('max') >= quantity) {
						jQuery('.qty').val(quantity);
					}

					
					updateProgressBar();
				}, 100);
			}

			function continuousDecrement() {
				continuousAction = 'decrement';
				continuousInterval = setInterval(function () {
					var quantity = parseInt(jQuery('.qty').val());
					if (quantity > 0) {
						quantity--;
						jQuery('.qty').val(quantity);
						updateProgressBar();
					}
				}, 100);
			}

			function stopContinuous() {
				clearInterval(continuousInterval);
				continuousAction = null;
			}



		});
	</script>

	<?php
}


?>
