<?php
function wp_CC_meta_box_handler($post) {
    $get_Gram_Gold = get_post_meta($post->ID, 'Gram_Gold', true);
    $get_Production_Cost = get_post_meta($post->ID, 'Production_Cost', true);
    $get_Profit_percentage = get_post_meta($post->ID, 'Profit_percentage', true);
    include WP_CC_TPL . 'admin/metabox-product.php';
}

function wp_get_information_product_meta_box($post_type, $post) {
    add_meta_box(
        'wp_CC_meta_box',
        'محاسبه گر ارز',
        'wp_CC_meta_box_handler',
        'product',
        'normal',
        'default'
    );
}

function wp_save_product_handler($post_id) {
    $getPrice = wp_remote_get("https://mhlotfi.ir/Api/Currency/");
    $getPrice = floatval(wp_remote_retrieve_body($getPrice));

    global $wpdb;

    $Gram_Gold = isset($_POST['Gram_Gold']) ? floatval($_POST['Gram_Gold']) : 0;
    $Production_Cost = isset($_POST['Production_Cost']) ? floatval($_POST['Production_Cost']) : 0;
    $Profit_percentage = isset($_POST['Profit_percentage']) ? floatval($_POST['Profit_percentage']) : 0;

    update_post_meta($post_id,'Gram_Gold', $Gram_Gold);
    update_post_meta($post_id,'Production_Cost', $Production_Cost);
    update_post_meta($post_id,'Profit_percentage', $Profit_percentage);
    update_post_meta($post_id,'price_per_gram', number_format(round($getPrice)));

    $price_Gram_Gold = ($Gram_Gold * $getPrice);
    $price_Production_Cost = $price_Gram_Gold + ($price_Gram_Gold * $Production_Cost) / 100;
    $price_finaly = round($price_Production_Cost + ($price_Production_Cost * $Profit_percentage) / 100,0);

    update_post_meta($post_id, '_price', $price_finaly);
    update_post_meta($post_id, '_sale_price', $price_finaly);
    update_post_meta($post_id, '_regular_price', $price_finaly);

    $wpdb->update($wpdb->prefix . 'wc_product_meta_lookup', ['min_price' => $price_finaly, 'max_price' => $price_finaly], ['product_id' => $post_id]);
}

add_action('add_meta_boxes', 'wp_get_information_product_meta_box', 10, 2);
add_action('save_post', 'wp_save_product_handler');
