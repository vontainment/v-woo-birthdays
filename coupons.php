<?php

/**
 * Creates a birthday coupon for a user.
 *
 * @param int $user_id User ID.
 * @return string Generated coupon code.
 */
function vontainment_create_birthday_coupon($user_id)
{
    // Generate a unique coupon code
    $coupon_code = 'BDAY-' . wp_generate_password(8, false);

    // Insert a new coupon into the database
    $new_coupon_id = wp_insert_post(array(
        'post_title' => $coupon_code,
        'post_content' => '',
        'post_status' => 'publish',
        'post_type' => 'shop_coupon'
    ));

    // Add the coupon meta data
    update_post_meta($new_coupon_id, 'discount_type', 'percent');
    update_post_meta($new_coupon_id, 'coupon_amount', '20');
    update_post_meta($new_coupon_id, 'individual_use', 'yes');
    update_post_meta($new_coupon_id, 'product_categories', array(27)); // Assuming 27 is the term_id for the desired category
    update_post_meta($new_coupon_id, 'exclude_sale_items', 'yes');
    update_post_meta($new_coupon_id, 'expiry_date', date('Y-m-d', strtotime('+30 days')));

    // Schedule the coupon deletion
    wp_schedule_single_event(strtotime('+30 days'), 'vontainment_delete_birthday_coupon_hook', array($coupon_code));

    return $coupon_code;
}

/**
 * Deletes a birthday coupon.
 *
 * @param string $coupon_code Coupon code to delete.
 */
function vontainment_delete_birthday_coupon($coupon_code)
{
    $coupon_post = get_page_by_title($coupon_code, OBJECT, 'shop_coupon');
    if ($coupon_post) {
        wp_delete_post($coupon_post->ID, true);
    }
}

// Hook for coupon deletion
add_action('vontainment_delete_birthday_coupon_hook', 'vontainment_delete_birthday_coupon');
