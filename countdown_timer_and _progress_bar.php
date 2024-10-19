<?php
/**
 *
 * Plugin Name: Custom CountDown & Progress Bar Live
 * Author: Syed Ali Konain
 * Author URI: https://wa.me/923125493647
 * Plugin URI: www.linkedin.com/in/syed-ali-konain-4bb025305
 * Description: Display CountDown & Progress Bar.
 */


if (is_admin()) {
	include 'Admin/count_down_fields.php';
} else {
	include 'Front/display_timer_and_progress_bar.php';
	
}
