<?php

/*
 * Plugin Name: WooCommerce Check Product Is Bought
 * Description: 检查wcc商品是否被购买
 * Version: 1.0
 * Author: Lucas
 * Author URI: https://www.yuanpengfei.com
 */

// 防止文件直接被访问
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// 创建二维码扫描页面
//register_activation_hook( __FILE__, 'create_wepay_qrcode_page' );

// 增加是否购物提示
function wcc_check_user_bought($atts, $content = null) {
    // 检查用户是否登录
    if (is_user_logged_in()) {
        global $product;
        $product_id = $product->get_id();
        $user = wp_get_current_user();
        $user_id = $user->ID; // Get the user ID
        $customer_email = $user->user_email; // Get the user email

        if (wc_customer_bought_product($customer_email, $user_id, $product_id)) {
            return do_shortcode($content);
        } else {
            return "你必须购买后才可以查看!";
        }
    } else {
        return "你必须登录后购买才可以查看!";
    }
}

add_shortcode('wcc-check-buy', 'wcc_check_user_bought');

// 移除正文内容描述标题
add_filter( 'woocommerce_product_description_heading', 'remove_product_description_heading' );
function remove_product_description_heading() {
    return '';
}



