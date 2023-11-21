<?php
add_action('woocommerce_edit_account_form', 'vontainment_add_birthday_my_account');
add_action('woocommerce_save_account_details', 'vontainment_save_birthday_my_account');

/**
 * Adds a birthday field to the WooCommerce My Account page for editing.
 *
 * @param WP_User $user User object.
 */
function vontainment_add_birthday_my_account($user)
{
    $birthday = get_user_meta($user->ID, 'birthday', true);
    $disabled = !empty($birthday) ? 'disabled' : '';

    echo '<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">';
    echo '<label for="birthday">' . __('Birthday', 'woocommerce') . '&nbsp;</label>';
    echo '<input type="date" class="woocommerce-Input woocommerce-Input--text input-text" name="birthday" id="birthday" value="' . esc_attr($birthday) . '" ' . $disabled . ' />';
    echo '</p>';
}

/**
 * Saves the birthday field from the My Account page.
 *
 * @param int $user_id User ID.
 */
function vontainment_save_birthday_my_account($user_id)
{
    if (isset($_POST['birthday'])) {
        update_user_meta($user_id, 'birthday', sanitize_text_field($_POST['birthday']));
    }
}
