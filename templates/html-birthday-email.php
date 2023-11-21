<?php
<?php
/**
 * Birthday Email template.
 *
 * @param string $email_heading Email heading.
 * @param string $coupon_code Coupon code.
 * @param WC_Email $email Email object.
 */

if (!defined('ABSPATH')) {
    exit;
}

// Load default WooCommerce email header
do_action('woocommerce_email_header', $email_heading, $email);

// Email body content
?>
<p>Happy Birthday! As a special gift from us, here's a coupon for you: <strong><?php echo esc_html($coupon_code); ?></strong></p>
<p>Enjoy a special discount on your next purchase.</p>

<?php
// Load default WooCommerce email footer
do_action('woocommerce_email_footer', $email);
