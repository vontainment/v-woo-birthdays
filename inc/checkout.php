<?php
add_action('woocommerce_after_order_notes', 'vontainment_display_birthday_checkout');
add_action('woocommerce_checkout_update_order_meta', 'vontainment_save_birthday_checkout_field');

/**
 * Displays the birthday field in the checkout form.
 *
 * @param WC_Checkout $checkout Checkout object.
 */
function vontainment_display_birthday_checkout($checkout)
{
    $user_id = get_current_user_id();
    $birthday = $user_id ? get_user_meta($user_id, 'birthday', true) : '';
    $disabled = !empty($birthday) ? 'disabled' : '';

    woocommerce_form_field('birthday', array(
        'type' => 'date',
        'class' => array('form-row-wide'),
        'label' => __('Please enter your birthday to get special surprises on your day.'),
        'required' => false,
        'custom_attributes' => array('disabled' => $disabled)
    ), $checkout->get_value('birthday'));

    if (!empty($birthday)) {
        printf('<input type="hidden" name="birthday" value="%s">', esc_attr($birthday));
    }
}

/**
 * Saves the birthday field from the checkout form to user meta.
 *
 * @param int $order_id Order ID.
 */
function vontainment_save_birthday_checkout_field($order_id)
{
    if (!empty($_POST['birthday'])) {
        $user_id = get_current_user_id();

        if ($user_id) {
            update_user_meta($user_id, 'birthday', sanitize_text_field($_POST['birthday']));
        }
    }
}
