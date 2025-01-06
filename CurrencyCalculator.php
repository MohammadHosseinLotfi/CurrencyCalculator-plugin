<?php
/**
 * Plugin Name: Currency Calculator
 * Description: This plugin allows you to convert the prices of products you want to sell in real-time dollar rates into Toman. | این پلاگین این امکان رو به شما میده تا محصولاتی که به قیمت لحظه ایه دلار میخواهید بفروشید رو به تومان تبدیل کنه
 * Plugin URI: https://mhlotfi.ir
 * Author: MohammadHosseinLotfi
 * Version: 1.0.0
 * Author URI: https://t.me/sirlotfi
 */
if (!defined('ABSPATH')) {
    exit;
}

define('WP_CC_DIR', plugin_dir_path(__FILE__));
define('WP_CC_URL', plugin_dir_url(__FILE__));
define('WP_CC_INC', WP_CC_DIR . '/include/');
define('WP_CC_TPL', WP_CC_DIR . '/template/');

if (is_admin()) {
    include WP_CC_INC . 'admin/menus.php';
    include WP_CC_INC . 'admin/metaboxs.php';
}
