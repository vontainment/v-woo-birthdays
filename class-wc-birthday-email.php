<?php
class WC_Birthday_Email extends WC_Email {

public function __construct() {
$this->id = 'birthday_email';
$this->title = 'Birthday Email';
$this->description = 'Birthday email sent to customers on their birthday with a special offer.';
$this->template_html = '/html-birthday-email.php';
$this->template_plain = '/plain-birthday-email.php';
$this->template_base = plugin_dir_path(__FILE__) . 'templates/';

add_action('vontainment_send_birthday_email_notification', array($this, 'trigger'), 10, 2);

parent::__construct();
}

public function trigger($user_email, $coupon_code) {
$this->recipient = $user_email;
$this->coupon_code = $coupon_code;

if (!$this->is_enabled() || !$this->get_recipient()) {
return;
}

$this->send($this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments());
}

public function get_content_html() {
ob_start();
wc_get_template($this->template_html, array(
'email_heading' => $this->get_heading(),
'coupon_code' => $this->coupon_code,
'email' => $this,
), '', $this->template_base);
return ob_get_clean();
}

public function get_content_plain() {
ob_start();
wc_get_template($this->template_plain, array(
'email_heading' => $this->get_heading(),
'coupon_code' => $this->coupon_code,
'email' => $this,
), '', $this->template_base);
return ob_get_clean();
}
}