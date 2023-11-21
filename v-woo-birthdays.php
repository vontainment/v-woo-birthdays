<?php
/*
Plugin Name: V-Woo Birthdays
Description: Handle birthday emails and discounts for WooCommerce.
Version: 1.0
Author: Your Name
*/

// Prevent direct file access
if (!defined('ABSPATH')) {
    exit;
}

include_once plugin_dir_path(__FILE__) . 'inc/my-account.php';
include_once plugin_dir_path(__FILE__) . 'inc/profiles.php';
include_once plugin_dir_path(__FILE__) . 'inc/checkout.php';
include_once plugin_dir_path(__FILE__) . 'email.php';
include_once plugin_dir_path(__FILE__) . 'coupons.php';

// Schedule the daily birthday email
add_action('wp', 'vontainment_schedule_birthday_email');

/**
 * Schedules a daily event to send birthday emails if not already scheduled.
 */
function vontainment_schedule_birthday_email()
{
    if (!wp_next_scheduled('vontainment_daily_send_birthday_email_hook')) {
        wp_schedule_event(time(), 'daily', 'vontainment_daily_send_birthday_email_hook');
    }
}

add_action('vontainment_daily_send_birthday_email_hook', 'vontainment_send_birthday_coupons');

function vontainment_add_custom_email_class($email_classes)
{
    require_once 'path/to/class-wc-birthday-email.php';
    $email_classes['WC_Birthday_Email'] = new WC_Birthday_Email();
    return $email_classes;
}
add_filter('woocommerce_email_classes', 'vontainment_add_custom_email_class');


/**
 * Sends birthday coupons to users.
 */
function vontainment_send_birthday_coupons()
{
    $users = get_users(array('fields' => array('ID', 'user_email', 'first_name')));
    $today = new DateTime();

    foreach ($users as $user) {
        $birthday = get_user_meta($user->ID, 'birthday', true);
        if (!empty($birthday)) {
            $birthday_date = new DateTime($birthday);
            if ($birthday_date->format('m-d') === $today->format('m-d')) {
                $coupon_code = vontainment_create_birthday_coupon($user->ID);
                vontainment_send_birthday_email($user->user_email, $user->first_name, $coupon_code);
            }
        }
    }
}
