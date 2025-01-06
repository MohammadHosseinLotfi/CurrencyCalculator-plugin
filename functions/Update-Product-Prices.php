<?php
// if (php_sapi_name() !== 'cli') {
//     die('Access denied');
// }
require_once('./../../../../wp-load.php');

global $wpdb;

$getProducts = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . 'wc_product_meta_lookup');

$getPrice = wp_remote_get("https://mhlotfi.ir/Api/Currency/");
$getPrice = floatval(wp_remote_retrieve_body($getPrice));

foreach ($getProducts as $value) {
    $ProductId = $value->product_id;

    $Gram_Gold = get_post_meta($ProductId, 'Gram_Gold', true);
    $Production_Cost = get_post_meta($ProductId, 'Production_Cost', true);
    $Profit_percentage = get_post_meta($ProductId, 'Profit_percentage', true);

    $price_Gram_Gold = ($Gram_Gold * $getPrice);
    $price_Production_Cost = $price_Gram_Gold + ($price_Gram_Gold * $Production_Cost) / 100;
    $price_finaly = round($price_Production_Cost + ($price_Production_Cost * $Profit_percentage) / 100,0);

    update_post_meta($ProductId, '_price', $price_finaly);
    update_post_meta($ProductId, '_sale_price', $price_finaly);
    update_post_meta($ProductId, '_regular_price', $price_finaly);

    update_post_meta($ProductId,'price_per_gram', number_format(round($getPrice)));

    $wpdb->update($wpdb->prefix . 'wc_product_meta_lookup', ['min_price' => $price_finaly, 'max_price' => $price_finaly], ['product_id' => $ProductId]);

    echo "Product Id : {$ProductId} , price_finaly : {$price_finaly} , price : {$getPrice}" . PHP_EOL;
}
