<?php
add_action('show_user_profile', 'vontainment_add_birthday_user_profile');
add_action('edit_user_profile', 'vontainment_add_birthday_user_profile');

add_action('personal_options_update', 'vontainment_save_extra_profile_fields');
add_action('edit_user_profile_update', 'vontainment_save_extra_profile_fields');

/**
 * Adds a birthday field to user profile in admin.
 *
 * @param WP_User $user User object.
 */
function vontainment_add_birthday_user_profile($user)
{
    echo '<h3>' . __('Extra profile information', 'woocommerce') . '</h3>';
    echo '<table class="form-table">';
    echo '<tr>';
    echo '<th><label for="birthday">' . __('Birthday', 'woocommerce') . '</label></th>';
    echo '<td>';
    echo '<input type="date" name="birthday" id="birthday" value="' . esc_attr(get_user_meta($user->ID, 'birthday', true)) . '" class="regular-text" />';
    echo '<br /><span class="description">' . __('Please enter your birthday.', 'woocommerce') . '</span>';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
}

/**
 * Saves the birthday field from the user profile.
 *
 * @param int $user_id User ID.
 */
function vontainment_save_extra_profile_fields($user_id)
{
    if (current_user_can('edit_user', $user_id) && isset($_POST['birthday'])) {
        update_user_meta($user_id, 'birthday', sanitize_text_field($_POST['birthday']));
    }
}
