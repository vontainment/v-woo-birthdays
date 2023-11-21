<?php

/**
 * Sends a birthday email to a user with a coupon code.
 *
 * @param string $user_email User's email address.
 * @param string $first_name User's first name.
 * @param string $coupon_code Generated coupon code.
 */
function vontainment_send_birthday_email($user_email, $first_name, $coupon_code)
{
    $headers = array('Content-Type: text/html; charset=UTF-8');
    $subject = 'A Special Birthday Surprise for You! 🎉';
    $message = '<p>Dear ' . $first_name . ',</p>';
    $message .= '<p>On your special day, we at Zoe Beth Geller\'s Book World want to add a little extra joy. What’s better than getting lost in a thrilling new adventure on your birthday?</p>';
    $message .= '<p>As our gift to you, here’s an exclusive 20% off coupon for all ebooks in the romance category — just for you, to use within the next 30 days.</p>';
    $message .= '<p>Your unique coupon code: <strong>' . $coupon_code . '</strong></p>';
    $message .= '<p>From high-stakes mafia intrigue to heart-melting moments on the ice, let us help you celebrate with a story that sweeps you off your feet.</p>';
    $message .= '<p>Happy Reading and Happy Birthday!</p>';
    $message .= '<p>Warm wishes,</p>';
    $message .= '<p>Zoe Beth Geller & Team</p>';
    wp_mail($user_email, $subject, $message, $headers);
}
